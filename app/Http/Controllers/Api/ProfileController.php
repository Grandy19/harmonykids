<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    // === API 1: AMBIL DATA PROFIL (GET) ===
    public function fetch(Request $request)
    {
        // Debugging sederhana: Pastikan user terdeteksi
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'nomor_telepon' => $user->nomor_telepon,
                'jenis_kelamin' => $user->jenis_kelamin,
                'alamat' => $user->alamat,
                'pekerjaan' => $user->pekerjaan,
                'hubungan_dengan_anak' => $user->hubungan_dengan_anak,
                
                // Helper Asset untuk URL Gambar
                'foto_profil_url' => $user->foto_profil 
                    ? asset('storage/' . $user->foto_profil) 
                    : null, 
            ]
        ], 200);
    }

    // === API 2: UPDATE DATA PROFIL (POST) ===
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:20',
            'jenis_kelamin' => 'nullable|string',
            'alamat'        => 'nullable|string|max:500',
            'pekerjaan'     => 'nullable|string|max:100',
            'hubungan_dengan_anak' => 'nullable|string|max:100',
            'photo'         => 'nullable|image|max:2048', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // 2. Logika Update Foto
            if ($request->hasFile('photo')) {
                if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                    Storage::disk('public')->delete($user->foto_profil);
                }
                $path = $request->file('photo')->store('profile-photos', 'public');
                $user->foto_profil = $path;
            }

            // 3. Update Data Text
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            
            // Cek satu per satu field opsional
            if ($request->has('nomor_telepon')) $user->nomor_telepon = $request->input('nomor_telepon');
            if ($request->has('jenis_kelamin')) $user->jenis_kelamin = $request->input('jenis_kelamin');
            if ($request->has('alamat')) $user->alamat = $request->input('alamat');
            if ($request->has('pekerjaan')) $user->pekerjaan = $request->input('pekerjaan');
            if ($request->has('hubungan_dengan_anak')) $user->hubungan_dengan_anak = $request->input('hubungan_dengan_anak');

            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Profil berhasil diperbarui',
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}