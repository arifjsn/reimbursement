<?php

use App\Http\Controllers\Admin\ClaimGaransiController as AdminClaimGaransiController;
use App\Http\Controllers\Admin\RegistrasiGaransiController as AdminRegistrasiGaransiController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReimbursementController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
});
Route::post('/login', [AuthController::class, 'loginAction'])->name('login_submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Profile
     */
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
    });

    /**
     * Reimbursement
     */
    Route::controller(ReimbursementController::class)
        ->prefix('reimbursement')
        ->name('reimbursement.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}/edit', 'edit')->name('edit');
            Route::put('/{id}', 'update')->name('update');
            Route::delete('/{id}', 'destroy')->name('destroy');
            Route::get('/{id}/detail', 'detail')->name('detail');
        });

    /**
     * Admin
     */
    Route::middleware('role:Admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::controller(LogController::class)
                ->prefix('log')
                ->name('log.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                });
        });
});
