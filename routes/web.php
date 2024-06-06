<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryRuleController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\HourMeterReportController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubsidiaryController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'dashboard');

Route::middleware('auth')->group(function () {

    Route::middleware('verified')->group(function () {

        Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    });

    Route::resource('subsidiary', SubsidiaryController::class)->except(['show']);
    Route::resource('category', CategoryController::class)->except(['show']);
    Route::as('category.')->prefix('category/{category}')->group(function () {
        Route::resource('rule', CategoryRuleController::class)->except(['show']);
        Route::get('rule-search', [CategoryRuleController::class, 'rule'])->name('rule.search');
    });
    Route::resource('equipment', EquipmentController::class)->except(['show']);
    Route::get('api/equipment', [EquipmentController::class, 'search']);

    Route::prefix('report')->as('report.')->group(function () {
        Route::resource('hour-meter', HourMeterReportController::class)->except(['edit', 'update']);
    });

    Route::as('account.')->group(function () {
        Route::get('/account/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/account/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/account/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/account/change-password', [PasswordController::class, 'edit'])->name('password.edit');
    });
});

require __DIR__.'/auth.php';
