<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 Akun Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@harmonykids.com',
            'nomor_telepon' => '08123456789',
            'role' => 'admin',
            'password' => Hash::make('admin123'), // Password Admin
        ]);
    }
}