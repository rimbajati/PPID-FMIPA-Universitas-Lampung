<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('nama');
            $table->string('pekerjaan');
            $table->text('alamat');
            $table->string('telepon');
            $table->string('email');
            $table->string('file_identitas');
            $table->text('info_diminta');
            $table->text('tujuan');
            $table->string('cara_ambil'); // Untuk menampung hasil radio button
            $table->boolean('pernyataan');
            $table->string('no_tiket')->nullable(); // Tambahkan ini
            $table->string('status')->default('DIAJUKAN'); // Tambahkan ini
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
