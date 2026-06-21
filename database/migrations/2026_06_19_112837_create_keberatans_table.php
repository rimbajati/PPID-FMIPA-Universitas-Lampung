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
        Schema::create('keberatans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke permohonan awal yang ditolak
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            // Menghubungkan ke user pemohon
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('alasan_keberatan');
            $table->string('dokumen_pendukung')->nullable();
            $table->dateTime('tanggal_pengajuan');
            $table->enum('status_putusan', ['menunggu', 'diproses', 'diterima', 'ditolak'])->default('menunggu');
            $table->string('dokumen_putusan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keberatans');
    }
};
