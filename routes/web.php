<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\HourMeterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubsidiaryController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('verified')->group(function() {

        Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    });

    Route::resource('subsidiary', SubsidiaryController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('equipment', EquipmentController::class);

    Route::prefix('report')->as('report.')->group(function() {
        Route::get('hour-meter', [HourMeterController::class, 'index'])->name('hour-meter');
    });

    Route::as('account.')->group(function() {
        Route::get('/account/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/account/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/account/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/account/change-password', [PasswordController::class, 'edit'])->name('password.edit');
    });
});

require __DIR__.'/auth.php';
