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
            $table->boolean('pernyataan');
            $table->string('no_tiket')->nullable();
            $table->string('status')->default('DIAJUKAN');
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
