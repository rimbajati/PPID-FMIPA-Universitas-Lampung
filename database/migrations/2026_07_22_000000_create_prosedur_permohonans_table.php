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
        Schema::create('prosedur_permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->default('Prosedur Permohonan Informasi Publik');
            $table->text('subjudul')->nullable();
            $table->string('jangka_waktu')->default('Maks. 10 Hari Kerja');
            $table->string('biaya_layanan')->default('GRATIS / Rp 0');
            $table->string('syarat_utama')->default('Kartu Identitas');
            $table->string('hak_pemohon')->default('Pengajuan Keberatan');
            
            $table->json('tahapan_permohonan')->nullable();
            $table->json('tahapan_keberatan')->nullable();
            $table->json('syarat_dokumen')->nullable();
            $table->json('sla_matrix')->nullable();
            $table->json('faqs')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosedur_permohonans');
    }
};
