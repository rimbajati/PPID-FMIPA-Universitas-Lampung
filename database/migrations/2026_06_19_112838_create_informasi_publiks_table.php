<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_publik', function (Blueprint $table) {
            $table->id();
            $table->string('judul_informasi')->index();
            $table->text('deskripsi_informasi')->nullable();
            $table->enum('kategori_informasi', [
                'Informasi Setiap Saat',
                'Informasi Berkala',
                'Informasi Serta-Merta',
                'Informasi Dikecualikan'
            ]);
            $table->string('tahun_terbit')->nullable();
            $table->string('file_informasi')->nullable();
            $table->string('nama_file_asli')->nullable();
            $table->text('link_informasi')->nullable();
            $table->integer('dilihat')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_publik');
    }
};
