<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permohonan;
use App\Models\Keberatan;
use App\Models\JawabanFile;

return new class extends Migration
{
    public function up(): void
    {
        // Migrasi Data Permohonan
        $permohonans = Permohonan::whereNotNull('file_jawaban')->get();
        foreach ($permohonans as $p) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($p->file_jawaban)) {
                JawabanFile::create([
                    'jawabanable_type' => Permohonan::class,
                    'jawabanable_id'   => $p->id,
                    'file_path'        => $p->file_jawaban,
                    'file_name'        => basename($p->file_jawaban),
                    'file_size'        => null,
                ]);
            }
        }

        // Migrasi Data Keberatan
        $keberatans = Keberatan::whereNotNull('file_jawaban')->get();
        foreach ($keberatans as $k) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($k->file_jawaban)) {
                JawabanFile::create([
                    'jawabanable_type' => Keberatan::class,
                    'jawabanable_id'   => $k->id,
                    'file_path'        => $k->file_jawaban,
                    'file_name'        => basename($k->file_jawaban),
                    'file_size'        => null,
                ]);
            }
        }

        // Hapus kolom lama
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['file_jawaban', 'link_jawaban']);
        });
        Schema::table('keberatans', function (Blueprint $table) {
            $table->dropColumn(['file_jawaban', 'link_jawaban']);
        });
    }

    public function down(): void
    {
        // Tidak perlu reverse karena struktur sudah pindah ke jawaban_files
    }
};
