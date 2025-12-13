<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\InstansiController;
use App\Http\Controllers\Api\ForumController;

// Register dipisah sesuai peran (Wali / Pengelola)
Route::post('/register/wali', [AuthController::class, 'registerWali']);
Route::post('/register/pengelola', [AuthController::class, 'registerPengelola']);
Route::post('/login', [AuthController::class, 'login']); 

/* 2. INSTANSI / SEKOLAH (Public) */
Route::get('/instansi', [InstansiController::class, 'index']);
Route::get('/instansi/{id}', [InstansiController::class, 'show']);
Route::post('/instansi', [InstansiController::class, 'store']);
Route::post('/instansi/compare', [InstansiController::class, 'compare']);

/* 3. FITUR PRIVATE (Harus Login) */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Forum Diskusi
    Route::get('/forums', [ForumController::class, 'index']);      
    Route::post('/forums', [ForumController::class, 'store']);     
    Route::get('/forums/me', [ForumController::class, 'myPosts']); 

    // Fitur Pendaftaran Sekolah
    Route::post('/pendaftaran', [App\Http\Controllers\Api\PendaftaranController::class, 'store']); // Kirim Form
    Route::get('/pendaftaran/me', [App\Http\Controllers\Api\PendaftaranController::class, 'myRegistrations']); // Cek Status
});