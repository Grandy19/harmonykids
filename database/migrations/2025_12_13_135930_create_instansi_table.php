<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instansi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_instansi');
            $table->string('alamat');
            $table->string('kota');
            $table->string('biaya_display');
            $table->integer('biaya_angka');
            $table->double('rating', 3, 1)->default(0);
            $table->boolean('is_popular')->default(false);
            $table->string('thumbnail');
            $table->text('deskripsi');
            $table->json('program_belajar')->nullable();
            $table->json('kategori_minat')->nullable(); 
            $table->string('biaya_pendaftaran')->nullable();
            $table->string('jam_operasional')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('email')->nullable();
            $table->json('galeri_foto')->nullable();

            // SKOR PERBANDINGAN
            $table->integer('skor_fasilitas')->default(0);
            $table->integer('skor_keamanan')->default(0);
            $table->integer('skor_kenyamanan')->default(0);
            $table->integer('skor_pengajar')->default(0);
            $table->integer('skor_layanan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instansi');
    }
};