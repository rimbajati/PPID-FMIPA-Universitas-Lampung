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
        Schema::table('keberatans', function (Blueprint $table) {
            $table->string('nama_file_pendukung_asli')->nullable()->after('file_pendukung');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keberatans', function (Blueprint $table) {
            $table->dropColumn('nama_file_pendukung_asli');
        });
    }
};
