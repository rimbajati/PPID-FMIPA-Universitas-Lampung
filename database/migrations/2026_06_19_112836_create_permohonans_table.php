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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (siapa pemohonnya)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_tiket')->unique();
            $table->string('file_kartu_identitas');
            $table->text('rincian_informasi');
            $table->text('tujuan_penggunaan');
            $table->string('cara_memperoleh_info');
            $table->string('cara_memperoleh_salinan');
            $table->dateTime('tanggal_pengajuan');
            $table->enum('status_layanan', ['diajukan', 'diproses', 'diterima', 'ditolak'])->default('diajukan');
            $table->text('alasan_penolakan')->nullable();
            $table->string('dokumen_jawaban')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
