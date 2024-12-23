<?php

use App\Http\Controllers\ListingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

Route::get('/', function () {
    $listings = Listing::latest()->get(); // Fetch all listings sorted by the latest
    return view('welcome', compact('listings'));
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
    Route::get('/listings/create', [ListingsController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingsController::class, 'store'])->name('listings.store');
    Route::get('/listings/{id}', [ListingsController::class, 'show'])->name('listings.show');

});

require __DIR__.'/auth.php';
