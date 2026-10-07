<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = array_filter([
            Schema::hasColumn('permohonans', 'file_pendukung') ? 'file_pendukung' : null,
            Schema::hasColumn('permohonans', 'nama_file_pendukung_asli') ? 'nama_file_pendukung_asli' : null,
        ]);

        if ($columns) {
            Schema::table('permohonans', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }

    public function down(): void
    {
        $columns = array_filter([
            Schema::hasColumn('permohonans', 'file_pendukung') ? null : 'file_pendukung',
            Schema::hasColumn('permohonans', 'nama_file_pendukung_asli') ? null : 'nama_file_pendukung_asli',
        ]);

        if ($columns) {
            Schema::table('permohonans', function (Blueprint $table) use ($columns) {
                foreach ($columns as $column) {
                    $table->string($column)->nullable();
                }
            });
        }
    }
};
