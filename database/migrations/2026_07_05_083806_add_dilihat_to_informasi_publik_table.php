<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('informasi_publik', function (Blueprint $table) {
            $table->integer('dilihat')->default(0);
        });
    }
    public function down(): void {
        Schema::table('informasi_publik', function (Blueprint $table) {
            $table->dropColumn('dilihat');
        });
    }
};
