<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi'; // Pastikan nama tabel sesuai (biasanya singular/plural, cek di database)

    // Daftar kolom sesuai gambar database Anda
    protected $fillable = [
        'user_id',
        'nama',
        'status',          // pending/active
        'jenis_instansi',  // TK/PG/Daycare
        'alamat',
        'kota',
        
        // Data Tambahan
        'deskripsi',
        'biaya_display',     // Contoh: "Rp 500rb - 1jt"
        'biaya_angka',       // Contoh: 500000 (untuk sorting)
        'biaya_pendaftaran',
        'jam_operasional',
        'program_belajar',
        'kategori_minat',
        
        // Kontak & Media
        'nomor_telepon',
        'email',
        'thumbnail',        // Foto utama
        'galeri_foto',      // Foto-foto lain
        
        // Statistik & Skor (Default 0)
        'rating',
        'is_popular',
        'skor_fasilitas',
        'skor_keamanan',
        'skor_kenyamanan',
        'skor_pengajar',
        'skor_layanan',
    ];

    // Relasi ke User (Pemilik Sekolah)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}