<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap'); // Menggunakan nama_lengkap sesuai kebutuhan PPID
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            // Kolom password dibuat nullable agar user Google tidak error saat dikosongkan
            $table->string('password')->nullable();

            $table->string('role')->default('masyarakat'); // Kolom role
            $table->string('google_id')->nullable();       // INI KOLOM YANG DIMINTA OLEH ERROR TADI

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
