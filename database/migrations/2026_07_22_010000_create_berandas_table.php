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
        Schema::create('berandas', function (Blueprint $table) {
            $table->id();
            $table->string('hero_tagline')->nullable();
            $table->string('hero_judul_1')->nullable();
            $table->string('hero_judul_2')->nullable();
            $table->string('hero_subjudul')->nullable();
            $table->string('hero_search_placeholder')->nullable();
            $table->text('hero_cta_user_text')->nullable();
            
            $table->string('alur_judul')->nullable();
            $table->text('alur_subjudul')->nullable();
            $table->json('alur_steps')->nullable();

            $table->string('stats_tagline')->nullable();
            $table->string('stats_judul')->nullable();
            $table->text('stats_deskripsi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berandas');
    }
};
