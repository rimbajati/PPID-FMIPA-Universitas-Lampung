<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keberatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            $table->string('no_tiket')->unique();
            $table->text('alasan_keberatan');
            $table->text('kronologi_keberatan')->nullable();
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
        Schema::dropIfExists('keberatans');
    }
};
