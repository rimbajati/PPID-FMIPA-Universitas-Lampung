<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus kolom penanggung_jawab_pembuatan_informasi dari tabel informasi_publiks.
     * Penanggung jawab sudah terpusat di profil PPID Pelaksana FMIPA Unila.
     */
    public function up(): void
    {
        if (Schema::hasColumn('informasi_publiks', 'penanggung_jawab_pembuatan_informasi')) {
            Schema::table('informasi_publiks', function (Blueprint $table) {
                $table->dropColumn('penanggung_jawab_pembuatan_informasi');
            });
        }
    }

    /**
     * Rollback: tambahkan kembali kolom jika migration di-revert.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('informasi_publiks', 'penanggung_jawab_pembuatan_informasi')) {
            Schema::table('informasi_publiks', function (Blueprint $table) {
                $table->string('penanggung_jawab_pembuatan_informasi')->nullable()->after('pejabat_unit_yang_menguasai_informasi');
            });
        }
    }
};
