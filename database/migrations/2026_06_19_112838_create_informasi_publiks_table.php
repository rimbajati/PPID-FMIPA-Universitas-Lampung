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
        // Tabel 'informasi_publik' sesuai draf proposal
        Schema::create('informasi_publik', function (Blueprint $table) {
            $table->id();

            $table->string('judul_informasi');

            // Menggunakan enum untuk memastikan data valid dan tidak terpotong (truncated)
            $table->enum('kategori', [
                'Informasi Tersedia Setiap Saat',
                'Informasi Tersedia Secara Berkala',
                'Informasi Diumumkan Serta-Merta'
            ]);

            $table->text('deskripsi')->nullable();

            // Tipe: pdf, docx, atau link
            $table->string('tipe_informasi');

            // Jalur: letak file di server atau URL
            $table->string('jalur_informasi');

            $table->string('tahun_publikasi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_publik');
    }
};
