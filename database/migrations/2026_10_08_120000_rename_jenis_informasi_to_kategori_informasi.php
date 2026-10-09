<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('informasi_publiks', 'jenis_informasi')) {
            Schema::table('informasi_publiks', function (Blueprint $table) {
                $table->renameColumn('jenis_informasi', 'kategori_informasi');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('informasi_publiks', 'kategori_informasi')) {
            Schema::table('informasi_publiks', function (Blueprint $table) {
                $table->renameColumn('kategori_informasi', 'jenis_informasi');
            });
        }
    }
};
