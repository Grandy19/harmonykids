<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. REGISTER WALI (Orang Tua) -- SUDAH DIPERBAIKI
    public function registerWali(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'nomor_telepon' => 'required|string',
            // Pindah kesini (Wajib pilih Laki-laki/Perempuan)
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', 
            'password' => 'required|min:6|confirmed' 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_kelamin' => $request->jenis_kelamin, // <-- Data disimpan disini
            'password' => Hash::make($request->password),
            'role' => 'wali' 
        ]);

        return response()->json(['message' => 'Register Wali Berhasil', 'user' => $user], 201);
    }

    // 2. REGISTER PENGELOLA (Sekolah)
    public function registerPengelola(Request $request) {
        $request->validate([
            'name' => 'required|string', // Nama Sekolah
            'email' => 'required|email|unique:users', 
            'nomor_telepon' => 'required|string', 
            // Sekolah biasanya tidak punya jenis kelamin, jadi saya hapus dari sini
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name, 
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            // 'jenis_kelamin' => tidak perlu untuk sekolah
            'password' => Hash::make($request->password),
            'role' => 'pengelola' 
        ]);

        return response()->json(['message' => 'Register Pengelola Berhasil', 'user' => $user], 201);
    }

    // 3. LOGIN (Sama seperti sebelumnya)
    public function login(Request $request) {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email atau Password Salah'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil',
            'role' => $user->role, 
            'user' => $user,
            'access_token' => $token, 
            'token_type' => 'Bearer'
        ]);
    }
    
    // 4. LOGOUT
    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout Berhasil']);
    }
}