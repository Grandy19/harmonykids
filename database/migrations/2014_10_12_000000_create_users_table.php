<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Wali / Nama Sekolah
            $table->string('email')->unique();
            $table->string('nomor_telepon')->nullable(); // Wajib utk Wali & Sekolah
            $table->string('role'); // 'admin', 'wali', 'pengelola'
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};