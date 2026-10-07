<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            if (!Schema::hasColumn('permohonans', 'alamat_lengkap')) {
                $table->text('alamat_lengkap')->nullable();
            }
            if (!Schema::hasColumn('permohonans', 'pekerjaan')) {
                $table->string('pekerjaan')->nullable();
            }
            if (!Schema::hasColumn('permohonans', 'jenis_permohonan')) {
                $table->string('jenis_permohonan')->nullable();
            }
        });
    }

    public function down(): void
    {
        $columns = array_filter([
            Schema::hasColumn('permohonans', 'alamat_lengkap') ? 'alamat_lengkap' : null,
            Schema::hasColumn('permohonans', 'pekerjaan') ? 'pekerjaan' : null,
            Schema::hasColumn('permohonans', 'jenis_permohonan') ? 'jenis_permohonan' : null,
        ]);

        if ($columns) {
            Schema::table('permohonans', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
