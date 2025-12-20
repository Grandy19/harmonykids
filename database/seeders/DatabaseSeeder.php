<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN PENGELOLA (Untuk tes input data nanti)
        User::create([
            'name' => 'Pak Budi Pengelola',
            'email' => 'pengelola@harmonykids.com',
            'password' => bcrypt('password'),
            'role' => 'pengelola', 
        ]);
        
        // 2. BUAT AKUN ADMIN (Untuk tes validasi nanti)
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@harmonykids.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Bagian Instansi::create(...) SUDAH DIHAPUS.
        // Jadi database tabel 'instansi' bakal bersih (kosong).
    }
}