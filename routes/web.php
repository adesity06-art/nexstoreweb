<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CashierController;

// Login & Logout
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman yang butuh login
Route::middleware('auth')->group(function () {
    
    // Hanya Admin
    Route::middleware('can:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class);
        Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');
    });

    // Admin & Kasir
    Route::get('/kasir', [CashierController::class, 'index'])->name('kasir');
    Route::post('/kasir/store', [CashierController::class, 'store'])->name('kasir.store');
    Route::get('/kasir/receipt/{id}', [CashierController::class, 'receipt'])->name('kasir.receipt');
});