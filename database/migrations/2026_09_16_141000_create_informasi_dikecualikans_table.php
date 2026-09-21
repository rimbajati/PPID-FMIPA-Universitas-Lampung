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
        Schema::create('informasi_dikecualikans', function (Blueprint $table) {
            $table->id();
            $table->string('ringkasan_informasi', 255);
            $table->text('dasar_hukum');
            $table->string('dibuka', 255)->default('-');
            $table->text('ditutup');
            $table->string('jangka_waktu', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_dikecualikans');
    }
};
