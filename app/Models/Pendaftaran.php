<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    // Nama tabel sesuai di phpMyAdmin
    protected $table = 'pendaftarans';

    // Daftar kolom yang boleh diisi (sesuai gambar database kamu)
    protected $fillable = [
        'user_id',
        'instansi_id',
        'nama_anak',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'riwayat_kesehatan',
        'kewarganegaraan',
        'bukti_bayar',       
        'status_pendaftaran', // <-- INI YANG PALING PENTING
    ];

    // Relasi ke User (Wali Murid)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Instansi (Sekolah)
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }
}