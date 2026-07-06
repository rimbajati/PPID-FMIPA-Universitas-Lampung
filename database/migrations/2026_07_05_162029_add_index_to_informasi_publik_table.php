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
        Schema::table('informasi_publik', function (Blueprint $table) {
            // Menambahkan index agar pencarian judul dan pengurutan jumlah dilihat super cepat
            $table->index('judul_informasi');
            $table->index('dilihat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_publik', function (Blueprint $table) {
            $table->dropIndex(['judul_informasi']);
        });
    }
};
