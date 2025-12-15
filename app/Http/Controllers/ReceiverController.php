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
        \App\Models\FoodItem::where('status', 'available')
            ->where('expires_at', '<', now())
            ->update(['status' => 'expired']);
        
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

        $totalClaims = Claim::where('receiver_id', $userId)
                            ->where('status', '!=', 'cancelled')
                            ->count();

        $pendingClaims = Claim::where('receiver_id', $userId)
                            ->where('status', 'pending')
                            ->count(); 

        $approvedClaims = Claim::where('receiver_id', $userId)
                            ->whereIn('status', ['approved', 'claimed', 'completed']) 
                            ->count();

        $claimsHistory = Claim::with(['fooditems.users']) 
                            ->where('receiver_id', $userId)
                            ->latest()
                            ->take(5)
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

        if ($foodItem->status !== 'available') {
            return back()->with('error', 'Item tidak tersedia.');
        }

        if ($foodItem->expires_at < now()) {
            return back()->with('error', 'Maaf, makanan ini sudah kedaluwarsa.');
        }
        
        if ($foodItem->user_id === \Illuminate\Support\Facades\Auth::id()) {
            return back()->with('error', 'Anda tidak bisa mengklaim makanan Anda sendiri.');
        }

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
        if ($claim->receiver_id != (Auth::id() ?? 2)) {
            abort(403);
        }

        if (in_array($claim->status, ['pending', 'claimed'])) {
            
            $claim->update(['status' => 'cancelled']);

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

        $sort = $request->get('sort', 'date'); 
        $direction = $request->get('direction', 'desc');

        $query = Claim::with(['fooditems.users'])
                    ->where('receiver_id', $userId);

        if ($sort == 'food_name') {
            $query->join('food_items', 'claims.food_id', '=', 'food_items.id')
                ->orderBy('food_items.name', $direction)
                ->select('claims.*'); 
        } 
        elseif ($sort == 'status') {
            $query->orderBy('status', $direction);
        } 
        else {
            $query->orderBy('created_at', $direction);
        }

        $claimsHistory = $query->paginate(10)->withQueryString();

        return view('receiver.history', compact('claimsHistory'));
    }

    public function showHistoryDetail(\App\Models\Claim $claim)
    {
        if ($claim->receiver_id != \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        $claim->load(['fooditems.users', 'fooditems.category']);

        return view('receiver.history-show', compact('claim'));
    }
}