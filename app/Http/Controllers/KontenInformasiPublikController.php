<?php

namespace App\Http\Controllers;

use App\Models\KontenInformasiPublik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class KontenInformasiPublikController extends Controller
{
    /**
     * Pastikan tabel konten_informasi_publiks sudah tersedia secara aman
     */
    private function ensureTableExists()
    {
        if (!Schema::hasTable('konten_informasi_publiks')) {
            Schema::create('konten_informasi_publiks', function (Blueprint $table) {
                $table->id();
                $table->string('informasi_publik_judul')->default('Daftar Informasi Publik');
                $table->text('informasi_publik_subjudul')->nullable();
                $table->string('setiap_saat_judul')->default('Informasi Tersedia Setiap Saat');
                $table->text('setiap_saat_subjudul')->nullable();
                $table->string('berkala_judul')->default('Informasi Tersedia Secara Berkala');
                $table->text('berkala_subjudul')->nullable();
                $table->string('serta_merta_judul')->default('Informasi Diumumkan Serta Merta');
                $table->text('serta_merta_subjudul')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Form Edit Konten Halaman Informasi Publik untuk Admin
     */
    public function edit()
    {
        $this->ensureTableExists();
        $konten = KontenInformasiPublik::getData();
        return view('admin.kelola_konten.halaman_informasi_publik.edit', compact('konten'));
    }

    /**
     * Update Konten Halaman Informasi Publik oleh Admin
     */
    public function update(Request $request)
    {
        $this->ensureTableExists();

        $validated = $request->validate([
            'informasi_publik_judul' => 'required|string|max:255',
            'informasi_publik_subjudul' => 'nullable|string',

            'setiap_saat_judul' => 'required|string|max:255',
            'setiap_saat_subjudul' => 'nullable|string',

            'berkala_judul' => 'required|string|max:255',
            'berkala_subjudul' => 'nullable|string',

            'serta_merta_judul' => 'required|string|max:255',
            'serta_merta_subjudul' => 'nullable|string',
        ]);

        $record = KontenInformasiPublik::first();
        if ($record) {
            $record->update($validated);
        } else {
            KontenInformasiPublik::create($validated);
        }

        return redirect()->back()->with('success', 'Tampilan Halaman Informasi Publik berhasil diperbarui!');
    }
}
