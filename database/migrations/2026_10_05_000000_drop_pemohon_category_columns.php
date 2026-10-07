<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = array_filter([
            Schema::hasColumn('permohonans', 'kategori_pemohon') ? 'kategori_pemohon' : null,
            Schema::hasColumn('permohonans', 'nama_organisasi_lembaga') ? 'nama_organisasi_lembaga' : null,
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
            Schema::hasColumn('permohonans', 'kategori_pemohon') ? null : 'kategori_pemohon',
            Schema::hasColumn('permohonans', 'nama_organisasi_lembaga') ? null : 'nama_organisasi_lembaga',
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
