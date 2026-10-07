<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus unique constraint dari kolom no_tiket di tabel keberatans.
     * Keberatan menggunakan tiket yang sama dengan permohonan asalnya,
     * sehingga nilai no_tiket bisa saja sama antara permohonan dan keberatan.
     */
    public function up(): void
    {
        Schema::table('keberatans', function (Blueprint $table) {
            $table->dropUnique(['no_tiket']);
        });
    }

    public function down(): void
    {
        Schema::table('keberatans', function (Blueprint $table) {
            $table->unique('no_tiket');
        });
    }
};
