<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Claim;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DonorController extends Controller
{
    public function index()
    {
        // --- TAMBAHAN LOGIC LAZY UPDATE ---
        // Sebelum menampilkan dashboard, update dulu semua item milik user ini yang sudah basi
        \App\Models\FoodItem::where('user_id', Auth::id()) // Opsional: atau hapus where user_id untuk update global
            ->where('status', 'available')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
        // ----------------------------------
        
        $user = Auth::user();
        $userId = $user->id;

        // A. Total Donasi Aktif (Stok Available)
        $totalActive = FoodItem::where('user_id', $userId)
                        ->where('status', 'available')
                        ->count();

        // B. Total Donasi Selesai (Berhasil Disalurkan)
        $totalCompleted = FoodItem::where('user_id', $userId)
                        ->where('status', 'completed')
                        ->count();

        // C. Permintaan Masuk (Pending Claims)
        $totalRequests = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'pending')->count();

        // --- PEMISAHAN DATA UNTUK TABS ---

        // Pending Requests (Pindahan dari method requests)
        $pendingClaims = Claim::whereHas('fooditems', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'pending') 
        ->with(['fooditems', 'receiver']) 
        ->latest()
        ->get();
        
        // 1. Tab Aktif: Hanya yang available (Boleh Edit/Delete)
        $activeItems = FoodItem::where('user_id', $userId)
                        ->where('status', 'available')
                        ->latest()
                        ->get();

        // 2. Tab Proses: Sedang diklaim orang (Hanya boleh Cancel)
        $ongoingQuery = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('status', 'approved') // Hanya ambil transaksi yang sudah Deal/Approved
        ->with(['fooditems', 'receiver']);
        $ongoingItems = $ongoingQuery->get();

        // 3. Tab Riwayat: Selesai, Expired, atau Dibatalkan (Read Only)
        $historyItems = FoodItem::where('user_id', $userId)
                        ->whereIn('status', ['completed', 'expired', 'cancelled'])
                        ->latest()
                        ->get();

        return view('donor.dashboard', compact(
            'user', 
            'totalActive', 'totalCompleted', 'totalRequests', 
            'pendingClaims', 'activeItems', 'ongoingItems', 'historyItems'
        ));
    }

    public function create()
    {
        $user = Auth::user();
        $categories = Category::all();
        return view('donor.food.create', compact('user', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'pickup_location' => 'required|string',
            'pickup_time' => 'required|string|max:255',
            'expires_at' => 'required|date|after:today',
            'photo' => 'nullable|image|max:2048', 
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Simpan ke folder 'storage/app/public/foodImages'
            $photoPath = $request->file('photo')->store('foodImages', 'public');
        }

        FoodItem::create([
            'user_id' => Auth::id(), // FIX: Uses logged-in user
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'quantity' => $validated['quantity'],
            'pickup_location' => $validated['pickup_location'],
            'pickup_time' => $validated['pickup_time'],
            'expires_at' => $validated['expires_at'],
            'photo' => $photoPath,
            'status' => 'available',
        ]);

        return redirect()->route('donor.dashboard')->with('success', 'Makanan berhasil didonasikan!');
    }

    public function edit(FoodItem $foodItem)
    {
        if ($foodItem->status !== 'available') {
            return redirect()->route('donor.dashboard')
                ->with('error', 'Item yang sedang diklaim atau selesai tidak bisa diedit.');
        }

        if ($foodItem->user_id !== Auth::id()) { // FIX: Uses logged-in user
            abort(403);
        }

        $categories = Category::all();
        return view('donor.food.edit', compact('foodItem', 'categories'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        if ($foodItem->status !== 'available') abort(403, 'Item tidak bisa diedit saat status: ' . $foodItem->status);
        
        if ($foodItem->user_id !== Auth::id()) abort(403); // FIX: Uses logged-in user

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'quantity' => 'required|integer',
            'description' => 'nullable',
            'pickup_location' => 'required',
            'pickup_time' => 'required|string|max:255',
            'expires_at' => 'required|date',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($foodItem->photo) {
                Storage::disk('public')->delete($foodItem->photo);
            }

            $validated['photo'] = $request->file('photo')->store('foodImages', 'public');
        }

        $foodItem->update($validated);

        return redirect()->route('donor.dashboard')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(FoodItem $foodItem)
    {
        if ($foodItem->status !== 'available') {
            return back()->with('error', 'Item sedang dalam proses klaim atau sudah selesai, tidak bisa dihapus.');
        }
        
        if ($foodItem->user_id !== Auth::id()) abort(403); // FIX: Uses logged-in user

        if ($foodItem->photo) {
            Storage::disk('public')->delete($foodItem->photo);
        }

        $foodItem->delete();

        return redirect()->route('donor.dashboard')->with('success', 'Item berhasil dihapus.');
    }

    public function cancel(Request $request, FoodItem $foodItem)
    {
        if ($foodItem->user_id !== Auth::id()) abort(403); // FIX: Uses logged-in user

        // Hanya boleh cancel jika statusnya 'claimed' (sedang jalan)
        if ($foodItem->status === 'claimed') {
            $foodItem->update(['status' => 'cancelled']);
            
            // Opsional: Jika mau lebih canggih, disini kita bisa reject semua Claim terkait
            Claim::where('food_id', $foodItem->id)->update(['status' => 'rejected']);

            return back()->with('success', 'Donasi berhasil dibatalkan.');
        }

        return back()->with('error', 'Status item tidak valid untuk pembatalan.');
    }

    public function cancelApproved(Claim $claim)
    {
        // 1. Validasi
        if ($claim->fooditems->user_id !== Auth::id()) abort(403);
        if ($claim->status !== 'approved') return back()->with('error', 'Hanya transaksi approved yang bisa dibatalkan disini.');

        $foodItem = $claim->fooditems;

        // 2. Kembalikan Stok
        $foodItem->quantity += $claim->quantity;
        
        // 3. Jika status makanan sebelumnya 'claimed' (habis), kembalikan jadi 'available'
        if ($foodItem->status == 'claimed') {
            $foodItem->status = 'available';
        }
        $foodItem->save();

        // 4. Update Status Claim jadi Cancelled
        $claim->update(['status' => 'cancelled']);

        return back()->with('success', 'Pickup dibatalkan. Stok telah dikembalikan ke inventory.');
    }

    public function requests()
    {
        $claims = Claim::whereHas('fooditems', function($query) {
            $query->where('user_id', Auth::id()); // FIX: Uses logged-in user
        })->where('status', 'pending') 
        ->with(['fooditems', 'receiver']) 
        ->latest()
        ->get();

        return view('donor.requests.index', compact('claims'));
    }

    public function approve(Claim $claim)
    {
        // 1. Validasi Pemilik (Security)
        if ($claim->fooditems->user_id !== Auth::id()) abort(403);

        $foodItem = $claim->fooditems;

        // 2. Cek apakah stok cukup
        if ($foodItem->quantity < $claim->quantity) {
            return back()->with('error', 'Gagal menyetujui. Stok tersisa (' . $foodItem->quantity . ') tidak cukup untuk permintaan ini (' . $claim->quantity . ').');
        }

        // 3. Kurangi Stok
        $newQuantity = $foodItem->quantity - $claim->quantity;
        $foodItem->quantity = $newQuantity;

        // 4. Update Status Claim jadi Approved
        $claim->update(['status' => 'approved']);

        // 5. Logika Sisa Stok
        if ($newQuantity <= 0) {
            // SKENARIO A: Stok Habis
            // Ubah status makanan jadi 'claimed' agar pindah ke tab "Dalam Proses"
            $foodItem->status = 'claimed'; 
            $foodItem->save();

            // Tolak semua request lain yang masih pending karena barang sudah habis
            Claim::where('food_id', $foodItem->id)
                ->where('id', '!=', $claim->id) // Kecuali yang baru saja diapprove
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'message' => 'Maaf, stok makanan ini telah habis diberikan kepada penerima lain.'
                ]);
                
        } else {
            // SKENARIO B: Stok Masih Ada
            // Status makanan tetap 'available' agar bisa diklaim user lain
            $foodItem->save();
        }

        return back()->with('success', 'Permintaan disetujui. Stok telah diperbarui.');
    }

    public function reject(Request $request, Claim $claim)
    {
        // Ensure the food item belongs to the logged-in user
        if ($claim->fooditems->user_id !== Auth::id()) abort(403); 

        // Validasi input alasan
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $claim->update([
            'status' => 'rejected',
            'message' => $request->rejection_reason, // Simpan alasan ke kolom message
        ]);

        return back()->with('success', 'Permintaan ditolak.');
    }

    public function profile()
    {
        $userId = Auth::id(); // FIX: Uses logged-in user
        $user = User::findOrFail($userId);

        // Statistik
        $totalDonations = FoodItem::where('user_id', $userId)->count();
        $activeDonations = FoodItem::where('user_id', $userId)->where('status', 'available')->count();
        $completedDonations = FoodItem::where('user_id', $userId)->where('status', 'claimed')->count();
        $recentDonations = FoodItem::where('user_id', $userId)->latest()->limit(5)->get();

        return view('donor.profile', compact(
            'user', 'totalDonations', 'activeDonations', 'completedDonations', 'recentDonations'
        ));
    }

    public function editProfile()
    {
        $user = Auth::user(); // FIX: Uses logged-in user
        return view('donor.profile-edit', compact('user'));
    }

    // Proses Update ke Database
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // FIX: Uses logged-in user

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:25',
            'address' => 'nullable|string|max:100',
        ]);

        $user->update($validated);

        return redirect()->route('donor.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}