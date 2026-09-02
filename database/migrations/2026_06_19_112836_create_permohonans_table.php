<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('no_tiket')->unique();
            $table->string('kategori_pemohon'); // Perorangan, Kelompok, Organisasi, Lembaga
            $table->string('nama_organisasi_lembaga')->nullable();
            $table->string('nama_lengkap');
            $table->string('no_identitas', 50);
            $table->string('file_identitas')->nullable();
            $table->string('email');
            $table->string('no_telepon', 20);
            $table->string('pekerjaan');
            $table->text('alamat_lengkap');
            $table->text('informasi_yang_diminta');
            $table->text('tujuan_penggunaan_informasi');
            $table->string('cara_memperoleh_informasi');
            $table->string('file_pendukung')->nullable();
            $table->string('status', 50)->default('Diajukan');
            $table->text('pesan_diproses')->nullable();
            $table->text('pesan_selesai')->nullable();
            $table->text('alasan_ditolak')->nullable();
            $table->string('file_jawaban')->nullable();
            $table->text('link_jawaban')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
