<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('verified')->group(function() {

        Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    });

    Route::as('account.')->group(function() {
        Route::get('/account/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/account/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/account/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/account/change-password', [PasswordController::class, 'edit'])->name('password.edit');
    });
});

require __DIR__.'/auth.php';
