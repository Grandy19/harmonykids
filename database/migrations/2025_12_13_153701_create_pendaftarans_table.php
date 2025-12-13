<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            
            // RELASI
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Wali
            $table->foreignId('instansi_id')->constrained('instansi')->onDelete('cascade'); // Sekolah Tujuan
            
            // DATA ANAK (Sesuai Gambar)
            $table->string('nama_anak');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin'); // "Laki-laki" atau "Perempuan"
            $table->string('agama');
            $table->text('alamat');
            $table->text('riwayat_kesehatan')->nullable(); // Boleh kosong
            $table->string('kewarganegaraan');
            
            // DATA PEMBAYARAN
            $table->string('bukti_bayar'); // Simpan path gambar struk
            $table->string('status_pendaftaran')->default('pending'); // pending, diterima, ditolak

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};