<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_publik', function (Blueprint $table) {
            $table->id();
            $table->string('rincian_informasi')->index(); // Judul + Index
            $table->text('sub_informasi')->nullable();
            $table->enum('kategori', [
                'Informasi Tersedia Setiap Saat',
                'Informasi Tersedia Secara Berkala',
                'Informasi Diumumkan Serta-Merta'
            ]);
            $table->string('tipe_informasi');
            $table->string('jalur_informasi');

            // Kolom & Index dari migrasi yang digabung
            $table->integer('dilihat')->default(0)->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_publik');
    }
};
