<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PERHATIKAN: Saya ubah 'instansis' jadi 'instansi'
        Schema::table('instansi', function (Blueprint $table) {
            
            // 1. Kolom User ID (Pemilik Data)
            // ditaruh setelah id biar rapi
            $table->foreignId('user_id')
                  ->after('id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // 2. Kolom Status
            // ditaruh setelah nama_instansi
            $table->enum('status', ['pending', 'active', 'rejected'])
                  ->default('pending')
                  ->after('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('instansi', function (Blueprint $table) {
            // Hapus Foreign Key dulu baru kolomnya
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status']);
        });
    }
};