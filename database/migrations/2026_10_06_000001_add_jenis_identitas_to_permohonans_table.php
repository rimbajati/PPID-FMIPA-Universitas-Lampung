<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            if (!Schema::hasColumn('permohonans', 'jenis_identitas')) {
                $table->string('jenis_identitas', 50)->default('KTP')->after('nama_lengkap');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('permohonans', 'jenis_identitas')) {
            Schema::table('permohonans', function (Blueprint $table) {
                $table->dropColumn('jenis_identitas');
            });
        }
    }
};
