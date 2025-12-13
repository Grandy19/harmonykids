<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi';

    protected $fillable = [
        'nama', 
        'jenis_instansi',
        'alamat', 
        'kota', 
        'biaya_display', 
        'biaya_angka', 
        'rating', 
        'is_popular', 
        'thumbnail',
        'deskripsi', 
        'program_belajar', 
        'kategori_minat',
        'biaya_pendaftaran', 
        'jam_operasional', 
        'nomor_telepon', 
        'email', 
        'galeri_foto',

        // SKOR MEMBANDINGKAN
        'skor_fasilitas', 
        'skor_keamanan', 
        'skor_kenyamanan', 
        'skor_pengajar', 
        'skor_layanan'
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'program_belajar' => 'array',
        'kategori_minat' => 'array',
        'galeri_foto' => 'array',
    ];
}