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
        Schema::create('informasi_publiks', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (siapa admin yang mengunggah)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('judul_dokumen');
            $table->enum('kategori', ['berkala', 'serta_merta', 'setiap_saat']);
            $table->string('file_path');
            $table->dateTime('tanggal_unggah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_publiks');
    }
};
