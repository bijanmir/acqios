<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ListingsController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/', function () {
    $listings = Listing::latest()->get(); // Fetch all listings sorted by the latest
    return view('landing');
})->name('home');


Route::get('/dashboard', function () {
    $listings = auth()->user()->listings; // Fetch user's listings
    return view('dashboard', compact('listings'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/listings', [ListingsController::class, 'index'])->name('listings.index');
    Route::get('/listings/create', [ListingsController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingsController::class, 'store'])->name('listings.store');
    Route::delete('/listings/{listing}', [ListingsController::class, 'destroy'])->name('listings.destroy');
    Route::put('/listings/{listing}', [ListingsController::class, 'update'])->name('listings.update')->middleware('auth');

});
Route::get('/listings/{id}', [ListingsController::class, 'show'])->name('listings.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/listings/{listing}/edit', [ListingsController::class, 'edit'])->name('listings.edit');
});

Route::post('/listings/{listing}/contact', [ListingsController::class, 'contactOwner'])
    ->middleware('auth')
    ->name('listings.contact');

Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::middleware('auth')->post('/listings/{listing}/favorite', [ListingsController::class, 'toggleFavorite'])->name('listings.toggleFavorite');

// Premium subscription routes
Route::middleware(['auth'])->group(function () {
    Route::get('/premium/upgrade', [PremiumController::class, 'showUpgradePage'])->name('premium.upgrade');
    Route::post('/premium/subscribe', [PremiumController::class, 'processSubscription'])->name('premium.subscribe');
    Route::get('/premium/success', [PremiumController::class, 'showSuccess'])->name('premium.success');
    Route::post('/premium/cancel', [PremiumController::class, 'cancelSubscription'])->name('premium.cancel');
});

Route::post('/listings/{listing}/quick-update', [ListingsController::class, 'quickUpdate'])->name('listings.quick-update');

require __DIR__.'/auth.php';
