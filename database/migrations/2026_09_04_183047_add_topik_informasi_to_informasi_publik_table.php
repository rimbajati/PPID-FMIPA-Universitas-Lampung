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
            $table->string('topik_informasi')->nullable()->after('kategori_informasi')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_publik', function (Blueprint $table) {
            $table->dropColumn('topik_informasi');
        });
    }
};
