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
        Schema::create('jawaban_files', function (Blueprint $table) {
            $table->id();
            $table->morphs('jawabanable'); // jawabanable_type & jawabanable_id (Permohonan / Keberatan)
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_files');
    }
};
