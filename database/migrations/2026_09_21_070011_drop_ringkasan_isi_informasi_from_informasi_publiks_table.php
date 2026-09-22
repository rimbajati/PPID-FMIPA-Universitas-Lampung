<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus kolom ringkasan_isi_informasi dari tabel informasi_publiks.
     * Kolom ini redundan karena nilainya selalu sama dengan sub_informasi.
     */
    public function up(): void
    {
        if (Schema::hasColumn('informasi_publiks', 'ringkasan_isi_informasi')) {
            Schema::table('informasi_publiks', function (Blueprint $table) {
                $table->dropColumn('ringkasan_isi_informasi');
            });
        }
    }

    /**
     * Rollback: tambahkan kembali kolom jika migration di-revert.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('informasi_publiks', 'ringkasan_isi_informasi')) {
            Schema::table('informasi_publiks', function (Blueprint $table) {
                $table->text('ringkasan_isi_informasi')->nullable()->after('sub_informasi');
            });
        }
    }
};
