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
use Illuminate\Support\Str;

class DonorController extends Controller
{
    public function index()
    {
        \App\Models\FoodItem::where('user_id', Auth::id()) 
            ->where('status', 'available')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
        
        $user = Auth::user();
        $userId = $user->id;

        $totalActive = FoodItem::where('user_id', $userId)
                        ->where('status', 'available')
                        ->count();

        $totalCompleted = FoodItem::where('user_id', $userId)
                        ->where('status', 'completed')
                        ->count();

        $totalRequests = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'pending')->count();

        $totalClaimsCompleted = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'completed')->count();

        $pendingClaims = Claim::whereHas('fooditems', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'pending') 
        ->with(['fooditems', 'receiver']) 
        ->latest()
        ->get();

        $activeItems = FoodItem::where('user_id', $userId)
                        ->where('status', 'available')
                        ->latest()
                        ->get();

        $ongoingQuery = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('status', 'approved')
        ->with(['fooditems', 'receiver']);
        $ongoingItems = $ongoingQuery->get();

        $historyItemsQuery = FoodItem::where('user_id', $userId)
                    ->whereIn('status', ['completed', 'expired', 'cancelled'])
                    ->orderBy('updated_at', 'desc');
        $historyItems = $historyItemsQuery->get();

        $historyClaimsQuery = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->whereIn('status', ['completed', 'rejected', 'cancelled'])
        ->with(['fooditems', 'receiver'])
        ->orderBy('updated_at', 'desc');
        $historyClaims = $historyClaimsQuery->get();

        return view('donor.dashboard', compact(
            'user', 
            'totalActive', 'totalCompleted', 'totalRequests', 'totalClaimsCompleted',
            'pendingClaims', 'activeItems', 'ongoingItems', 
            'historyItems', 'historyClaims'
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
            $photoPath = $request->file('photo')->store('images/foodImages', 'public');
        }

        FoodItem::create([
            'user_id' => Auth::id(),
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

        if ($foodItem->user_id !== Auth::id()) { 
            abort(403);
        }

        $categories = Category::all();
        return view('donor.food.edit', compact('foodItem', 'categories'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        if ($foodItem->status !== 'available') abort(403, 'Item tidak bisa diedit saat status: ' . $foodItem->status);
        
        if ($foodItem->user_id !== Auth::id()) abort(403); 

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
        
        if ($foodItem->user_id !== Auth::id()) abort(403); 

        if ($foodItem->photo) {
            Storage::disk('public')->delete($foodItem->photo);
        }

        $foodItem->delete();

        return redirect()->route('donor.dashboard')->with('success', 'Item berhasil dihapus.');
    }

    public function cancel(Request $request, FoodItem $foodItem)
    {
        if ($foodItem->user_id !== Auth::id()) abort(403);

        if ($foodItem->status === 'claimed') {
            $foodItem->update(['status' => 'cancelled']);

            Claim::where('food_id', $foodItem->id)->update(['status' => 'rejected']);

            return back()->with('success', 'Donasi berhasil dibatalkan.');
        }

        return back()->with('error', 'Status item tidak valid untuk pembatalan.');
    }

    public function cancelApproved(Claim $claim)
    {
        if ($claim->fooditems->user_id !== Auth::id()) abort(403);
        if ($claim->status !== 'approved') return back()->with('error', 'Hanya transaksi approved yang bisa dibatalkan disini.');

        $foodItem = $claim->fooditems;

        $foodItem->quantity += $claim->quantity;

        if ($foodItem->status == 'claimed') {
            $foodItem->status = 'available';
        }
        $foodItem->save();

        $claim->update(['status' => 'cancelled']);

        return back()->with('success', 'Pickup dibatalkan. Stok telah dikembalikan ke inventory.');
    }

    public function requests()
    {
        $claims = Claim::whereHas('fooditems', function($query) {
            $query->where('user_id', Auth::id());
        })->where('status', 'pending') 
        ->with(['fooditems', 'receiver']) 
        ->latest()
        ->get();

        return view('donor.requests.index', compact('claims'));
    }

    public function approve(Claim $claim)
    {

        if ($claim->fooditems->user_id !== Auth::id()) abort(403);

        $foodItem = $claim->fooditems;

        if ($foodItem->quantity < $claim->quantity) {
            return back()->with('error', 'Gagal menyetujui. Stok tersisa (' . $foodItem->quantity . ') tidak cukup untuk permintaan ini (' . $claim->quantity . ').');
        }

        $code = strtoupper(Str::random(4));

        $claim->update([
            'status' => 'approved',
            'verification_code' => $code 
        ]);

        $newQuantity = $foodItem->quantity - $claim->quantity;
        $foodItem->quantity = $newQuantity;

        if ($newQuantity <= 0) {
            $foodItem->status = 'claimed'; 
            $foodItem->save();

            Claim::where('food_id', $foodItem->id)
                ->where('id', '!=', $claim->id) 
                ->where('status', 'pending')
                ->update([
                    'status' => 'rejected',
                    'message' => 'Maaf, stok makanan ini telah habis diberikan kepada penerima lain.'
                ]);
                
        } else {
            $foodItem->save();
        }

        return back()->with('success', 'Permintaan disetujui. Silakan tunggu penerima menunjukkan kode verifikasi saat pengambilan.');
    }

    public function verify(Request $request, Claim $claim)
    {
        if ($claim->fooditems->user_id !== Auth::id()) abort(403);

        $request->validate([
            'verification_code' => 'required|string',
        ]);

        if (strcasecmp($request->verification_code, $claim->verification_code) !== 0) {
            return back()->with('error', 'Kode verifikasi salah! Silakan coba lagi.');
        }

        $claim->update(['status' => 'completed']);

        $foodItem = $claim->fooditems;
        
        $activeClaimsCount = \App\Models\Claim::where('food_id', $foodItem->id)
                                ->whereIn('status', ['pending', 'approved'])
                                ->count();

        if ($foodItem->quantity == 0 && $activeClaimsCount == 0) {

            $foodItem->update(['status' => 'completed']);
        }

        return back()->with('success', 'Verifikasi berhasil! Transaksi selesai.');
    }

    public function reject(Request $request, Claim $claim)
    {

        if ($claim->fooditems->user_id !== Auth::id()) abort(403); 

        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $claim->update([
            'status' => 'rejected',
            'message' => $request->rejection_reason, 
        ]);

        return back()->with('success', 'Permintaan ditolak.');
    }

    public function profile()
    {
        $userId = Auth::id(); 
        $user = User::findOrFail($userId);

        $totalActive = FoodItem::where('user_id', $userId)
                        ->where('status', 'available')
                        ->count();

        $totalRequests = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'pending')->count();

        $totalClaimsCompleted = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('status', 'completed')->count();

        $totalCompleted = FoodItem::where('user_id', $userId)
                        ->where('status', 'completed')
                        ->count();

        $recentDonations = FoodItem::where('user_id', $userId)->latest()->limit(5)->get();

        return view('donor.profile', compact(
            'user', 
            'totalActive', 'totalRequests', 'totalClaimsCompleted', 'totalCompleted',
            'recentDonations'
        ));
    }

    public function editProfile()
    {
        $user = Auth::user(); 
        return view('donor.profile-edit', compact('user'));
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

        return redirect()->route('donor.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}