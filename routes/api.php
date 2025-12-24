<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- 1. IMPORT CONTROLLER (JANGAN SAMPAI ADA YANG LEWAT!) ---
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\InstansiController;
use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\ProfileController; // <--- INI YANG TADI HILANG!

/*
|--------------------------------------------------------------------------
| API Routes - HarmonyKids
|--------------------------------------------------------------------------
*/

// --- AUTHENTICATION (Mobile) ---
Route::post('/register/wali', [ApiAuthController::class, 'registerWali']);
Route::post('/login', [ApiAuthController::class, 'login']);

// --- PUBLIC FEATURES ---
Route::get('/instansi', [InstansiController::class, 'index']);
Route::get('/instansi/{id}', [InstansiController::class, 'show']);
Route::post('/instansi', [InstansiController::class, 'store']);
Route::post('/instansi/compare', [InstansiController::class, 'compare']);

// --- PRIVATE FEATURES (Harus Login / Punya Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // 1. Fitur Profil (Ini yang tadi Error 500)
    Route::get('/profile', [ProfileController::class, 'fetch']);
    Route::post('/profile/update', [ProfileController::class, 'update']);

    // 2. Forum Diskusi
    Route::get('/forums', [ForumController::class, 'index']);      
    Route::post('/forums', [ForumController::class, 'store']);     
    Route::get('/forums/me', [ForumController::class, 'myPosts']); 

    // 3. Fitur Pendaftaran Sekolah
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']); 
    Route::get('/pendaftaran/me', [PendaftaranController::class, 'myRegistrations']); 

    // 4. Logout (Opsional, aktifkan jika AuthController sudah punya method logout)
    // Route::post('/logout', [ApiAuthController::class, 'logout']);
});

Route::get('/instansi', [InstansiController::class, 'index']);