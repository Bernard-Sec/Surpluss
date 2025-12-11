<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Category;
use App\Models\Claim;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReceiverController extends Controller
{ 
    public function index(Request $request)
    {
        // --- TAMBAHAN LOGIC LAZY UPDATE ---
        // Update data global agar receiver tidak melihat item basi
        \App\Models\FoodItem::where('status', 'available')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
        // ----------------------------------
        
        $query = FoodItem::with(['users', 'category']) 
                 ->where('status', 'available')
                 ->where('expires_at', '>', now()); 

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('location')) {
            $query->where('pickup_location', 'like', '%' . $request->location . '%');
        }

        $foods = $query->latest()->paginate(9);

        $categories = Category::all();

        return view('receiver.dashboard', compact('foods', 'categories'));
    }

    public function show(FoodItem $foodItem)
    {
        if ($foodItem->status !== 'available') {
            abort(404, 'Maaf, makanan ini sudah tidak tersedia.');
        }

        $foodItem->load('users');

        return view('receiver.food.show', compact('foodItem'));
    }

    

    
    public function profile()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        // 1. TOTAL REQUEST
        // Logic: Count everything EXCEPT 'cancelled'
        $totalClaims = Claim::where('receiver_id', $userId)
                            ->where('status', '!=', 'cancelled')
                            ->count();

        // 2. (Pending)
        // Logic: Only strictly 'pending'
        $pendingClaims = Claim::where('receiver_id', $userId)
                            ->where('status', 'pending')
                            ->count(); 

        // 3. BERHASIL
        $approvedClaims = Claim::where('receiver_id', $userId)
                            ->whereIn('status', ['approved', 'claimed', 'completed']) // Added 'completed'
                            ->count();

        // History List
        $claimsHistory = Claim::with(['fooditems.users']) 
                            ->where('receiver_id', $userId)
                            ->latest()
                            ->get();

        return view('receiver.profile', compact('user', 'totalClaims', 'pendingClaims', 'approvedClaims', 'claimsHistory'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('receiver.profile-edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:25',
            'address' => 'nullable|string|max:100',
        ]);

        $user->update($validated);

        return redirect()->route('receiver.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function storeClaim(Request $request, FoodItem $foodItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $foodItem->quantity,
        ], [
            'quantity.max' => 'Jumlah permintaan melebihi stok yang tersedia.'
        ]);

        // 1. Cek status
        if ($foodItem->status !== 'available') {
            return back()->with('error', 'Item tidak tersedia.');
        }

        // 2. TAMBAHAN: Cek tanggal expired
        if ($foodItem->expires_at < now()) {
            return back()->with('error', 'Maaf, makanan ini sudah kedaluwarsa.');
        }
        
        if ($foodItem->user_id === \Illuminate\Support\Facades\Auth::id()) {
            return back()->with('error', 'Anda tidak bisa mengklaim makanan Anda sendiri.');
        }

        // $existing = \App\Models\Claim::where('food_id', $foodItem->id)
        //                  ->where('receiver_id', \Illuminate\Support\Facades\Auth::id())
        //                  ->first();

        // if ($existing) {
        //     return back()->with('error', 'Anda sudah mengajukan klaim untuk makanan ini sebelumnya.');
        // }

        \App\Models\Claim::create([
            'food_id' => $foodItem->id,
            'receiver_id' => \Illuminate\Support\Facades\Auth::id(),
            'quantity' => $request->quantity,
            'status' => 'pending',
            'message' => 'Saya ingin mengklaim makanan ini.',
        ]);

        return redirect()->route('receiver.profile')->with('success', 'Permintaan berhasil dikirim! Mohon tunggu konfirmasi donatur.');
    }

    public function cancelClaim(Claim $claim)
    {
        // Pastikan yang cancel adalah pemilik claim
        if ($claim->receiver_id != (Auth::id() ?? 2)) {
            abort(403);
        }

        // Hanya boleh cancel jika status masih pending atau claimed (belum diambil/selesai)
        if (in_array($claim->status, ['pending', 'claimed'])) {
            
            // 1. Ubah status claim jadi cancelled
            $claim->update(['status' => 'cancelled']);

            // 2. KEMBALIKAN STATUS MAKANAN JADI AVAILABLE (PENTING!)
            // Agar bisa diambil orang lain lagi
            if ($claim->fooditems) {
                $claim->fooditems->update(['status' => 'available']);
            }

            return back()->with('success', 'Permintaan berhasil dibatalkan. Makanan kembali tersedia untuk umum.');
        }

        return back()->with('error', 'Tidak dapat membatalkan permintaan dengan status ini.');
    }

    public function history(Request $request)
    {
        $userId = Auth::id();

        // Ambil parameter dari URL, default-nya urutkan berdasarkan tanggal terbaru (desc)
        $sort = $request->get('sort', 'date'); 
        $direction = $request->get('direction', 'desc');

        $query = Claim::with(['fooditems.users'])
                    ->where('receiver_id', $userId);

        // --- LOGIC SORTING ---
        if ($sort == 'food_name') {
            // Sort berdasarkan Nama Makanan (Relasi)
            $query->join('food_items', 'claims.food_id', '=', 'food_items.id')
                ->orderBy('food_items.name', $direction)
                ->select('claims.*'); // Penting: Ambil kolom claims saja agar ID tidak bentrok
        } 
        elseif ($sort == 'status') {
            // Sort berdasarkan Status
            $query->orderBy('status', $direction);
        } 
        else {
            // Default: Tanggal Request
            $query->orderBy('created_at', $direction);
        }

        $claimsHistory = $query->paginate(10)->withQueryString();

        return view('receiver.history', compact('claimsHistory'));
    }
}