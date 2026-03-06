<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

// Home - Show welcomee page
Route::get('/', function () {
    return view('welcomee');
});

// Authenticated routes - Admin only
Route::middleware('auth')->group(function () {
    // Rental System Routes
    Route::get('/rental/dashboard', [DashboardController::class, 'index'])->name('rental.dashboard');
    
    // Technologies Management
    Route::resource('technologies', TechnologyController::class, ['as' => 'rental']);
    
    // Rental Management
    Route::patch('/rental/{rental}/status', [RentalController::class, 'updateStatus'])->name('rental.update-status');
    Route::patch('/rental/{rental}/log', [RentalController::class, 'addLog'])->name('rental.add-log');
    Route::get('/rental/create-rental', [RentalController::class, 'create'])->name('rental.rentals.create');
    Route::post('/rental/store-rental', [RentalController::class, 'storeRental'])->name('rental.rentals.store');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard redirect
Route::get('/dashboard', function () {
    return redirect()->route('rental.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
