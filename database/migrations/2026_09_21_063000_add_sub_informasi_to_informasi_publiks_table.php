<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informasi_publiks', function (Blueprint $table) {
            if (!Schema::hasColumn('informasi_publiks', 'sub_informasi')) {
                $table->string('sub_informasi')->nullable()->after('rincian_informasi')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('informasi_publiks', function (Blueprint $table) {
            if (Schema::hasColumn('informasi_publiks', 'sub_informasi')) {
                $table->dropColumn('sub_informasi');
            }
        });
    }
};
