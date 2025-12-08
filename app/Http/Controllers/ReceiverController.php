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

    // public function editProfile()
    // {
    //     $userId = Auth::id() ?? 2;
    //     $user = User::find($userId);

    //     // Pastikan ini 'receiver.profile-edit' (pakai strip, bukan titik)
    //     return view('receiver.profile-edit', compact('user'));
    // }

    // public function updateProfile(Request $request)
    // {
    //     $userId = Auth::id() ?? 2;
    //     $user = User::find($userId);

    //     // 1. Validasi Input
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
    //         'phone' => 'nullable|string|max:15',
    //         'address' => 'nullable|string',
    //     ]);

    //     // 2. Update Data
    //     $user->update([
    //         'name' => $validated['name'],
    //         'email' => $validated['email'],
    //         'phone' => $validated['phone'],
    //         'address' => $validated['address'],
    //     ]);

    //     return redirect()->route('receiver.profile')->with('success', 'Profil berhasil diperbarui!');
    // }


    public function profile()
    {
        // $userId = Auth::id();
        $userId = Auth::id();
        $user = User::find($userId);

        $totalClaims = Claim::where('receiver_id', $userId)->count();
        $pendingClaims = Claim::where('receiver_id', $userId)->where('status', 'pending')->count();
        $approvedClaims = Claim::where('receiver_id', $userId)->where('status', 'approved')->count();

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

        $existing = \App\Models\Claim::where('food_id', $foodItem->id)
                         ->where('receiver_id', \Illuminate\Support\Facades\Auth::id())
                         ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah mengajukan klaim untuk makanan ini sebelumnya.');
        }

        \App\Models\Claim::create([
            'food_id' => $foodItem->id,
            'receiver_id' => \Illuminate\Support\Facades\Auth::id(),
            'status' => 'pending',
            'message' => 'Saya ingin mengklaim makanan ini.',
        ]);

        return redirect()->route('receiver.profile')->with('success', 'Permintaan berhasil dikirim! Mohon tunggu konfirmasi donatur.');
    }
}