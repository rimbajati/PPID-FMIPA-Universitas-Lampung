<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informasi_dikecualikans', function (Blueprint $table) {
            $table->string('dibuka', 255)->change();
        });

        DB::table('informasi_dikecualikans')
            ->where('dibuka', '-')
            ->update(['dibuka' => '']);
    }

    public function down(): void
    {
        DB::table('informasi_dikecualikans')
            ->where('dibuka', '')
            ->update(['dibuka' => '-']);

        Schema::table('informasi_dikecualikans', function (Blueprint $table) {
            $table->string('dibuka', 255)->default('-')->change();
        });
    }
};
