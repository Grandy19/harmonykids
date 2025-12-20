<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 1. Panggil Controller API yang Benar
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\InstansiController;
use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\PendaftaranController;

/*
|--------------------------------------------------------------------------
| API Routes - HarmonyKids
|--------------------------------------------------------------------------
*/

// --- AUTHENTICATION (Mobile) ---
// Gunakan [ApiAuthController], JANGAN [AuthController] biasa.
Route::post('/register/wali', [ApiAuthController::class, 'registerWali']);

// Jalur Login (PASTIKAN BARIS INI ADA & TIDAK DI-KOMENTAR)
Route::post('/login', [ApiAuthController::class, 'login']);

// Nanti kita buat Login khusus API juga di sini (ApiAuthController)
// Route::post('/login', [ApiAuthController::class, 'login']); 


// --- PUBLIC FEATURES ---
Route::get('/instansi', [InstansiController::class, 'index']);
Route::get('/instansi/{id}', [InstansiController::class, 'show']);
Route::post('/instansi', [InstansiController::class, 'store']);
Route::post('/instansi/compare', [InstansiController::class, 'compare']);


// --- PRIVATE FEATURES (Harus Login / Punya Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout API
    // Route::post('/logout', [ApiAuthController::class, 'logout']);

    // Forum Diskusi
    Route::get('/forums', [ForumController::class, 'index']);      
    Route::post('/forums', [ForumController::class, 'store']);     
    Route::get('/forums/me', [ForumController::class, 'myPosts']); 

    // Fitur Pendaftaran Sekolah
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']); 
    Route::get('/pendaftaran/me', [PendaftaranController::class, 'myRegistrations']); 
});