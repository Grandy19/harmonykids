<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'instansi_id',
        'nama_anak', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'agama', 'alamat', 
        'riwayat_kesehatan', 'kewarganegaraan',
        'bukti_bayar', 'status_pendaftaran'
    ];

    // Relasi ke Wali
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Sekolah
    public function instansi() {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }
}