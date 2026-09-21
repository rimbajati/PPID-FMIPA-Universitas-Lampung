<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informasi_publiks', function (Blueprint $table) {
            $table->string('rincian_informasi')->nullable()->after('ringkasan_isi_informasi')->index();
        });
    }

    public function down(): void
    {
        Schema::table('informasi_publiks', function (Blueprint $table) {
            $table->dropColumn('rincian_informasi');
        });
    }
};
