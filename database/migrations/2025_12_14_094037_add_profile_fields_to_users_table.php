<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom nomor_telepon
            $table->string('foto_profil')->nullable()->after('nomor_telepon');
            $table->text('alamat')->nullable()->after('foto_profil');
            $table->string('pekerjaan')->nullable()->after('alamat');
            $table->string('hubungan_dengan_anak')->nullable()->after('pekerjaan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jaga-jaga kalau mau rollback (hapus kolom)
            $table->dropColumn(['foto_profil', 'alamat', 'pekerjaan', 'hubungan_dengan_anak']);
        });
    }
};