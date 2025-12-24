<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- IMPORT CONTROLLER BARU (HMVC) ---
use App\Http\Controllers\Api\Auth\AuthController;         // <--- Class Auth baru
use App\Http\Controllers\Api\Instansi\InstansiController; // <--- Class Instansi baru

// --- IMPORT CONTROLLER LAMA (Belum dipindah) ---
use App\Http\Controllers\Api\ForumController;
use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes - HarmonyKids
|--------------------------------------------------------------------------
*/

// --- AUTHENTICATION (Mobile) ---
Route::prefix('auth')->group(function () {
    // Sesuaikan nama method dengan yang ada di AuthController.php
    Route::post('/register', [AuthController::class, 'register']); 
    Route::post('/login', [AuthController::class, 'login']);
    
    // Logout butuh token, jadi ditaruh di dalam middleware nanti atau di sini
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

// --- PUBLIC FEATURES (Instansi) ---
Route::get('/instansi', [InstansiController::class, 'index']);
Route::get('/instansi/{id}', [InstansiController::class, 'show']);
// Route::post('/instansi', [InstansiController::class, 'store']); // Matikan dulu kalau belum ada fitur create
// Route::post('/instansi/compare', [InstansiController::class, 'compare']); // Matikan dulu kalau belum ada

// --- PRIVATE FEATURES (Harus Login / Punya Token) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // 1. Fitur Profil
    Route::get('/profile', [ProfileController::class, 'fetch']);
    Route::post('/profile/update', [ProfileController::class, 'update']);

    // 2. Forum Diskusi
    Route::get('/forums', [ForumController::class, 'index']);      
    Route::post('/forums', [ForumController::class, 'store']);     
    Route::get('/forums/me', [ForumController::class, 'myPosts']); 

    // 3. Fitur Pendaftaran Sekolah
    Route::post('/pendaftaran', [PendaftaranController::class, 'store']); 
    Route::get('/pendaftaran/me', [PendaftaranController::class, 'myRegistrations']); 
});