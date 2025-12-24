<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Kita pakai Schema::table karena tabel users sudah dibuat di migrasi sebelumnya
            
            // Cek dulu biar gak error duplicate, tapi kalau fresh harusnya aman
            if (!Schema::hasColumn('users', 'foto_profil')) {
                $table->string('foto_profil', 2048)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('foto_profil');
            }
            if (!Schema::hasColumn('users', 'pekerjaan')) {
                // Taruh setelah nomor_telepon (karena nomor_telepon ada di tabel utama)
                $table->string('pekerjaan')->nullable()->after('nomor_telepon'); 
            }
            if (!Schema::hasColumn('users', 'hubungan_dengan_anak')) {
                $table->string('hubungan_dengan_anak')->nullable()->after('pekerjaan');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'foto_profil', 
                'alamat', 
                'pekerjaan', 
                'hubungan_dengan_anak'
            ]);
        });
    }
};