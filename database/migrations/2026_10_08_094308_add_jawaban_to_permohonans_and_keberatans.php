<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->text('jawaban')->nullable()->after('catatan_selesai');
        });
        Schema::table('keberatans', function (Blueprint $table) {
            $table->text('jawaban')->nullable()->after('catatan_selesai');
        });
    }

    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn('jawaban');
        });
        Schema::table('keberatans', function (Blueprint $table) {
            $table->dropColumn('jawaban');
        });
    }
};
