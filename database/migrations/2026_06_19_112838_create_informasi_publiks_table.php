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
        // Nama tabel disesuaikan menjadi 'informasi_publik' (tanpa 's')
        Schema::create('informasi_publik', function (Blueprint $table) {
            $table->id();

            // Kolom disesuaikan 100% dengan draf proposal baru (menghilangkan kata 'dokumen')
            $table->string('judul_informasi');

            // Mengakomodasi 4 kategori sesuai Tabel 4 draf proposal terbaru
            $table->enum('kategori', [
                'Informasi Berkala',
                'Informasi Serta-Merta',
                'Informasi Setiap Saat',
                'Informasi Dikecualikan'
            ]);

            $table->text('deskripsi')->nullable();

            // Menampung representasi bentuk informasi (contoh: 'pdf', 'docx', atau 'link')
            $table->string('tipe_informasi');

            // Menampung letak berkas di server atau tautan URL eksternal
            $table->string('jalur_informasi');

            $table->string('tahun_publikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_publik');
    }
};
