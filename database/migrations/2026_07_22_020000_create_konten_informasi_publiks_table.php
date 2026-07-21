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
        Schema::create('konten_informasi_publiks', function (Blueprint $table) {
            $table->id();
            
            // Header 1: Daftar Informasi Publik
            $table->string('informasi_publik_judul')->default('Daftar Informasi Publik');
            $table->text('informasi_publik_subjudul')->nullable();

            // Header 2: Informasi Tersedia Setiap Saat
            $table->string('setiap_saat_judul')->default('Informasi Tersedia Setiap Saat');
            $table->text('setiap_saat_subjudul')->nullable();

            // Header 3: Informasi Tersedia Secara Berkala
            $table->string('berkala_judul')->default('Informasi Tersedia Secara Berkala');
            $table->text('berkala_subjudul')->nullable();

            // Header 4: Informasi Diumumkan Serta Merta
            $table->string('serta_merta_judul')->default('Informasi Diumumkan Serta Merta');
            $table->text('serta_merta_subjudul')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konten_informasi_publiks');
    }
};
