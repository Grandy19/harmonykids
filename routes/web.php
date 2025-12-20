<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// PENTING: Karena Controller ada di folder Pengelola, use-nya harus begini:
use App\Http\Controllers\Pengelola\PengelolaController; 

/*
|--------------------------------------------------------------------------
| Web Routes - HarmonyKids
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ADMIN
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/validasi', [DashboardController::class, 'validasiPage'])->name('admin.validasi.index');
    Route::patch('/validasi/{id}/approve', [DashboardController::class, 'approve'])->name('admin.instansi.approve');
    Route::patch('/validasi/{id}/reject', [DashboardController::class, 'reject'])->name('admin.instansi.reject');
    Route::get('/users', [DashboardController::class, 'users'])->name('admin.users');
});

// PENGELOLA
Route::middleware(['auth'])->prefix('pengelola')->name('pengelola.')->group(function () {
    
    Route::get('/dashboard', [PengelolaController::class, 'index'])->name('dashboard');
    Route::post('/instansi/store', [PengelolaController::class, 'storeInstansi'])->name('instansi.store');
    Route::put('/instansi/{id}/update', [PengelolaController::class, 'updateInstansi'])->name('instansi.update');

    // Route Pendaftaran (Menggunakan fungsi indexPendaftaran yang sudah dirapikan)
    Route::get('/pendaftaran', [PengelolaController::class, 'indexPendaftaran'])->name('pendaftaran');
    Route::patch('/pendaftaran/{id}/approve', [PengelolaController::class, 'approvePendaftaran'])->name('pendaftaran.approve');
    Route::patch('/pendaftaran/{id}/reject', [PengelolaController::class, 'rejectPendaftaran'])->name('pendaftaran.reject');
});