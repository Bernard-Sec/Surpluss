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

        $totalDonated = FoodItem::where('user_id', $userId)->count();
        $totalClaims = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'pending')->count();

        // --- PEMISAHAN DATA UNTUK TABS ---
        
        // 1. Tab Aktif: Hanya yang available (Boleh Edit/Delete)
        $activeItems = FoodItem::where('user_id', $userId)
                        ->where('status', 'available')
                        ->latest()
                        ->get();

        // 2. Tab Proses: Sedang diklaim orang (Hanya boleh Cancel)
        $ongoingItems = FoodItem::where('user_id', $userId)
                        ->where('status', 'claimed')
                        ->latest()
                        ->get();

        // 3. Tab Riwayat: Selesai, Expired, atau Dibatalkan (Read Only)
        $historyItems = FoodItem::where('user_id', $userId)
                        ->whereIn('status', ['completed', 'expired', 'cancelled'])
                        ->latest()
                        ->get();

        return view('donor.dashboard', compact(
            'user', 'totalDonated', 'totalClaims', 
            'activeItems', 'ongoingItems', 'historyItems'
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
        // Ensure the food item belongs to the logged-in user
        if ($claim->fooditems->user_id !== Auth::id()) abort(403); 

        $claim->update(['status' => 'approved']);

        // Opsional: Update status makanan jadi 'claimed' agar tidak bisa diklaim orang lain
        $claim->fooditems->update(['status' => 'claimed']);

        // 3. LOGIKA BARU: Tolak semua request lain untuk makanan INI
        // Cari klaim lain yang food_id nya sama, tapi ID klaimnya beda, dan statusnya masih pending
        Claim::where('food_id', $claim->food_id)
        ->where('id', '!=', $claim->id) // Jangan reject yang baru saja di-approve
        ->where('status', 'pending')
        ->update([
            'status' => 'rejected',
            'message' => 'Maaf, makanan ini telah diberikan kepada penerima lain.' // Pesan otomatis
        ]);

        return back()->with('success', 'Permintaan berhasil disetujui. Silakan hubungi penerima.');
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