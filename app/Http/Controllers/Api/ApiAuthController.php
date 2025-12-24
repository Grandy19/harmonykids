<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    //FUNGSI REGISTER
    public function registerWali(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'wali',
        ]);

        //Buat Token agar langsung login setelah daftar
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi Berhasil!',
            'data' => $user,
            'access_token' => $token, 
            'token_type' => 'Bearer'
        ], 201);
    }

    //FUNGSI LOGIN 
public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Salah!',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        //KIRIM DATA 
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil!',
            
            // Kirim User Data
            'data' => $user,
            'user' => $user, 

            // Kirim Token dengan DUA NAMA (Biar kena salah satu)
            'access_token' => $token, 
            'token' => $token,       
            
            'token_type' => 'Bearer'
        ], 200);
    }
}