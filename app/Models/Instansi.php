<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi';

    protected $fillable = [
        'user_id', 'nama', 'status', 'jenis_instansi', 'alamat', 'kota',
        'deskripsi', 'biaya_display', 'biaya_angka', 'biaya_pendaftaran',
        'jam_operasional', 'program_belajar', 'kategori_minat',
        'nomor_telepon', 'email', 'thumbnail', 'galeri_foto',
        'rating', 'is_popular', 'skor_fasilitas', 'skor_keamanan',
        'skor_kenyamanan', 'skor_pengajar', 'skor_layanan',
    ];

    protected $casts = [
        'program_belajar' => 'array',
        'kategori_minat' => 'array',
        'galeri_foto' => 'array',
        'is_popular' => 'boolean',
        'rating' => 'double',
    ];

    // --- INI BAGIAN PENTING YANG TADI HILANG ---
    // Agar $instansi->append('thumbnail_url') di Controller tidak error
    protected $appends = ['thumbnail_url'];

    public function getThumbnailUrlAttribute()
    {
        // Jika kolom 'thumbnail' kosong, return null
        if (!$this->thumbnail) {
            return null;
        }

        // Jika isinya link online (http...), kembalikan langsung
        if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
            return $this->thumbnail;
        }
        
        // Jika isinya nama file lokal, panggil via asset storage
        return asset('storage/' . $this->thumbnail);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}