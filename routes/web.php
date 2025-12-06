<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ReceiverController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return Redirect::back();
})->name('lang.switch');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('public.home'); 
})->name('home');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/how-it-works', [HomeController::class, 'how'])->name('how');

// Custom Register Routes
Route::get('/register', [RegisterController::class, 'show'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::prefix('donor')->middleware('role:donor')->group(function () {
        Route::get('/dashboard', [DonorController::class, 'index'])->name('donor.dashboard');
        
        Route::get('/food/create', [DonorController::class, 'create'])->name('donor.food.create');
        Route::post('/food', [DonorController::class, 'store'])->name('donor.food.store');
        Route::get('/food/{foodItem}/edit', [DonorController::class, 'edit'])->name('donor.food.edit');
        Route::put('/food/{foodItem}', [DonorController::class, 'update'])->name('donor.food.update');
        Route::delete('/food/{foodItem}', [DonorController::class, 'destroy'])->name('donor.food.destroy');
        Route::patch('/food/{foodItem}/cancel', [DonorController::class, 'cancel'])->name('donor.food.cancel');
        
        Route::get('/requests', [DonorController::class, 'requests'])->name('donor.requests.index');
        Route::patch('/requests/{claim}/approve', [DonorController::class, 'approve'])->name('donor.requests.approve');
        Route::patch('/requests/{claim}/reject', [DonorController::class, 'reject'])->name('donor.requests.reject');
        
        Route::get('/donor/profile', [DonorController::class, 'profile'])->name('donor.profile');
        Route::get('/profile/edit', [DonorController::class, 'editProfile'])->name('donor.profile.edit');
        Route::put('/profile', [DonorController::class, 'updateProfile'])->name('donor.profile.update');
    });

    Route::prefix('receiver')->middleware('role:receiver')->group(function () {
        Route::get('/dashboard', [ReceiverController::class, 'index'])->name('receiver.dashboard');
        Route::get('/food/{foodItem}', [ReceiverController::class, 'show'])->name('receiver.food.show');
        Route::get('/profile', [ReceiverController::class, 'profile'])->name('receiver.profile');

        Route::get('/profile/edit', [ReceiverController::class, 'editProfile'])->name('receiver.profile-edit');
        Route::put('/profile', [ReceiverController::class, 'updateProfile'])->name('receiver.profile.update');
        Route::post('/food/{foodItem}/claim', [ReceiverController::class, 'storeClaim'])->name('receiver.claim.store');
    });

});