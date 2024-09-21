<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WizardEventController;
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


require __DIR__.'/auth.php';
