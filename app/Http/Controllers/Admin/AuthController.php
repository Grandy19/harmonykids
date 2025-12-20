<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm() {
        // Pastikan file view ada di resources/views/admin/auth/login.blade.php
        return view('admin.auth.login'); 
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // CEK ROLE & REDIRECT
            $role = Auth::user()->role; // Pastikan kolom 'role' ada di tabel users

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } 
            
            if ($role === 'pengelola') {
                return redirect()->route('pengelola.dashboard');
            }

            return redirect('/'); // Default fallback
        }

        return back()->withErrors(['email' => 'Email atau Password salah!'])->onlyInput('email');
    }

    // 1. Tampilkan Form Daftar
    public function showRegisterForm() {
        return view('admin.auth.register');
    }

    // 2. Proses Simpan User Baru
    public function register(Request $request) {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users', // Email gak boleh kembar
            'password' => 'required|min:6|confirmed', // Harus ada field password_confirmation
        ]);

        // Buat User Baru (Otomatis jadi PENGELOLA)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengelola', // <--- PENTING: Kunci role di sini
        ]);

        // Langsung Login otomatis setelah daftar
        Auth::login($user);

        // Lempar ke Dashboard Pengelola
        return redirect()->route('pengelola.dashboard')->with('success', 'Akun berhasil dibuat! Silakan daftarkan sekolah Anda.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}