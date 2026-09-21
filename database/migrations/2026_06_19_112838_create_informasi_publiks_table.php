<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_publiks', function (Blueprint $table) {
            $table->id();
            $table->string('ringkasan_isi_informasi')->index();
            $table->enum('jenis_informasi', [
                'Informasi Setiap Saat',
                'Informasi Berkala',
                'Informasi Serta-Merta'
            ]);
            $table->string('pejabat_unit_yang_menguasai_informasi')->nullable();
            $table->string('waktu_pembuatan_informasi')->nullable();
            $table->string('bentuk_informasi_yang_tersedia')->nullable();
            $table->string('retensi_arsip')->nullable();
            $table->string('file_informasi')->nullable();
            $table->string('nama_file_asli')->nullable();
            $table->text('link_informasi')->nullable();
            $table->integer('dilihat')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_publiks');
    }
};
