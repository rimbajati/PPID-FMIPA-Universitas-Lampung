<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_tiket');
            $table->enum('jenis_layanan', ['Permohonan', 'Keberatan']);
            $table->string('status')->default('DIAJUKAN');

            // --- DATA UMUM ---
            $table->string('nama');
            $table->string('pekerjaan'); // Kolom baru untuk dropdown pekerjaan
            $table->string('kategori_pemohon'); // Kolom kategori
            $table->string('no_identitas');
            $table->string('lampiran_identitas');
            $table->string('email');
            $table->string('no_hp');
            $table->text('alamat');

            // --- DATA SPESIFIK ---
            $table->text('info_diminta')->nullable();
            $table->text('tujuan_permohonan')->nullable();
            $table->string('cara_memperoleh')->nullable();
            $table->unsignedBigInteger('permohonan_terkait_id')->nullable();
            $table->text('tujuan_keberatan')->nullable();

            // --- LAMPIRAN ---
            $table->string('akta_pendirian')->nullable(); // Kolom baru untuk akta badan hukum
            $table->string('lampiran_pendukung')->nullable(); // Kolom lampiran opsional

            $table->timestamps();

            // Relasi
            $table->foreign('permohonan_terkait_id')->references('id')->on('pengajuans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuans');
    }
};
