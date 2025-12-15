<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. REGISTER WALI (Orang Tua) 
    public function registerWali(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'nomor_telepon' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan', 
            'password' => 'required|min:6|confirmed' 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'jenis_kelamin' => $request->jenis_kelamin, 
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
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name, 
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
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

    // 5. UPDATE PROFIL LENGKAP (Wali)
    public function updateProfile(Request $request) {
        $user = $request->user(); // Ambil data user yg sedang login

        // Validasi Input Sesuai Gambar Desain
        $request->validate([
            'name'          => 'required|string', // Nama Wali (diwakili 'name')
            'email'         => 'required|email|unique:users,email,'.$user->id, 
            'nomor_telepon' => 'required|string',
            'alamat'        => 'nullable|string',
            'pekerjaan'     => 'nullable|string',
            'hubungan_dengan_anak' => 'nullable|string',
            // Validasi Foto: Harus gambar, max 2MB
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // Proses Upload Foto Profil (Jika ada)
        $fotoPath = $user->foto_profil; // Default pakai foto lama
        if ($request->hasFile('foto_profil')) {
            // Simpan di folder public/uploads/profil
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profil'), $filename);
            $fotoPath = 'uploads/profil/' . $filename;
        }

        // 3. Update data di database
        $user->update([
            'name'                 => $request->name,
            'email'                => $request->email,
            'nomor_telepon'        => $request->nomor_telepon,
            'alamat'               => $request->alamat,
            'pekerjaan'            => $request->pekerjaan,
            'hubungan_dengan_anak' => $request->hubungan_dengan_anak,
            'foto_profil'          => $fotoPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => $user
        ]);
    }
}