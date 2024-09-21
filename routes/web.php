<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WizardEventController;
use App\Http\Controllers\WizardEventBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('event')->as('wizard.event.')->group(function () {
    Route::post('/', [WizardEventController::class, 'store'])->name('store');
    Route::delete('/{id}', [WizardEventController::class, 'destroy'])->name('destroy');
    Route::get('/create', [WizardEventController::class, 'create'])->name('create');
});

Route::middleware('auth')->prefix('booking')->as('wizard.event.booking.')->group(function () {
    Route::get('/create', [WizardEventBookingController::class, 'create'])->name('create');
    Route::post('/', [WizardEventBookingController::class, 'store'])->name('store');
});

require __DIR__.'/auth.php';
