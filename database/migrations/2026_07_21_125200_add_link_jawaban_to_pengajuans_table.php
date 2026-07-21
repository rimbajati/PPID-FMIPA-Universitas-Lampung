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
        Schema::table('pengajuans', function (Blueprint $table) {
            if (!Schema::hasColumn('pengajuans', 'link_jawaban')) {
                $table->text('link_jawaban')->nullable()->after('file_jawaban');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            if (Schema::hasColumn('pengajuans', 'link_jawaban')) {
                $table->dropColumn('link_jawaban');
            }
        });
    }
};
