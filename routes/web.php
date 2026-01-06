<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [LoanController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/loan/store', [LoanController::class, 'store'])->name('loan.store');
    Route::patch('/loan/return/{id}', [LoanController::class, 'returnItem'])->name('loan.return');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
