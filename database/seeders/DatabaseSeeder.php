<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Instansi;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT AKUN USERS DAN SIMPAN KE VARIABEL
        $pengelola = User::create([
            'name' => 'Pak Budi Pengelola',
            'email' => 'pengelola@harmonykids.com',
            'password' => bcrypt('password'),
            'role' => 'pengelola', 
        ]);
        
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@harmonykids.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Asep Wali',
            'email' => 'asep@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'wali',
        ]);

        // 2. TAMBAHKAN DATA DUMMY INSTANSI (Tambahkan 'user_id')
        // Kita gunakan $pengelola->id agar data sekolah terhubung ke Pak Budi

        // --- DATA BANDUNG ---
        Instansi::create([
            'user_id' => $pengelola->id, // <--- TAMBAHKAN INI
            'nama' => 'TK Ceria Bandung',
            'jenis_instansi' => 'TK/PG',
            'alamat' => 'Jl. Pasir Kaliki No.90, Cicendo',
            'kota' => 'Bandung',
            'biaya_display' => 'Rp 350.000 /Bulan',
            'biaya_angka' => 350000,
            'rating' => 5.0,
            'is_popular' => true,
            'thumbnail' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=400',
            'deskripsi' => 'Sekolah taman kanak-kanak dengan fasilitas bermain lengkap.'
        ]);

        Instansi::create([
            'user_id' => $pengelola->id, // <--- TAMBAHKAN INI
            'nama' => 'Daycare Mungil Bandung',
            'jenis_instansi' => 'Daycare',
            'alamat' => 'Jl. Dago No.12, Coblong',
            'kota' => 'Bandung',
            'biaya_display' => 'Rp 1.500.000 /Bulan',
            'biaya_angka' => 1500000,
            'rating' => 4.7,
            'is_popular' => false,
            'thumbnail' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?q=80&w=400',
            'deskripsi' => 'Penitipan anak dengan pengawasan CCTV 24 jam.'
        ]);

        // --- DATA BEKASI ---
        Instansi::create([
            'user_id' => $pengelola->id, // <--- TAMBAHKAN INI
            'nama' => 'TK Bintang Bekasi',
            'jenis_instansi' => 'TK/PG',
            'alamat' => 'Jl. Ahmad Yani No.5, Bekasi Barat',
            'kota' => 'Bekasi',
            'biaya_display' => 'Rp 500.000 /Bulan',
            'biaya_angka' => 500000,
            'rating' => 4.8,
            'is_popular' => true,
            'thumbnail' => 'https://images.unsplash.com/photo-1588072432836-e10032774350?q=80&w=400',
            'deskripsi' => 'Sekolah berbasis karakter untuk anak usia dini.'
        ]);

        // --- DATA SURABAYA ---
        Instansi::create([
            'user_id' => $pengelola->id, // <--- TAMBAHKAN INI
            'nama' => 'Surabaya Playgroup',
            'jenis_instansi' => 'TK/PG',
            'alamat' => 'Jl. Gubeng No.44, Surabaya Pusat',
            'kota' => 'Surabaya',
            'biaya_display' => 'Rp 750.000 /Bulan',
            'biaya_angka' => 750000,
            'rating' => 4.9,
            'is_popular' => false,
            'thumbnail' => 'https://images.unsplash.com/photo-1595113316349-9fa4ee24f884?q=80&w=400',
            'deskripsi' => 'Metode belajar Montessori yang menyenangkan.'
        ]);
    }
}