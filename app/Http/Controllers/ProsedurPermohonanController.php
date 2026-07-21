<?php

namespace App\Http\Controllers;

use App\Models\ProsedurPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;

class ProsedurPermohonanController extends Controller
{
    /**
     * Memastikan tabel database `prosedur_permohonans` tersedia secara otomatis
     */
    private function ensureTableExists()
    {
        if (!Schema::hasTable('prosedur_permohonans')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                Schema::create('prosedur_permohonans', function (Blueprint $table) {
                    $table->id();
                    $table->string('judul')->default('Prosedur Permohonan Informasi Publik');
                    $table->text('subjudul')->nullable();
                    $table->string('jangka_waktu')->default('Maks. 10 Hari Kerja');
                    $table->string('biaya_layanan')->default('GRATIS / Rp 0');
                    $table->string('syarat_utama')->default('Kartu Identitas');
                    $table->string('hak_pemohon')->default('Pengajuan Keberatan');
                    $table->json('tahapan_permohonan')->nullable();
                    $table->json('tahapan_keberatan')->nullable();
                    $table->json('syarat_dokumen')->nullable();
                    $table->json('sla_matrix')->nullable();
                    $table->json('faqs')->nullable();
                    $table->timestamps();
                });
            }
        }
    }

    /**
     * Tampilkan halaman form edit Prosedur Permohonan untuk Admin
     */
    public function edit()
    {
        $this->ensureTableExists();
        $prosedur = ProsedurPermohonan::getData();
        return view('admin.kelola_konten.prosedur_permohonan.edit', compact('prosedur'));
    }

    /**
     * Simpan pembaruan konten Prosedur Permohonan oleh Admin
     */
    public function update(Request $request)
    {
        $this->ensureTableExists();

        $request->validate([
            'judul' => 'required|string|max:255',
            'subjudul' => 'nullable|string',
            'jangka_waktu' => 'required|string|max:100',
            'biaya_layanan' => 'required|string|max:100',
            'syarat_utama' => 'required|string|max:100',
            'hak_pemohon' => 'required|string|max:100',
        ]);

        // Process Tahapan Permohonan JSON
        $tahapanPermohonan = [];
        if ($request->has('tahapan_permohonan') && is_array($request->tahapan_permohonan)) {
            foreach ($request->tahapan_permohonan as $index => $item) {
                if (!empty($item['judul'])) {
                    $tahapanPermohonan[] = [
                        'nomor' => sprintf('%02d', $index + 1),
                        'judul' => $item['judul'],
                        'deskripsi' => $item['deskripsi'] ?? '',
                        'catatan' => $item['catatan'] ?? '',
                        'ikon' => $item['ikon'] ?? 'fa-pen-to-square',
                    ];
                }
            }
        }

        // Process Tahapan Keberatan JSON
        $tahapanKeberatan = [];
        if ($request->has('tahapan_keberatan') && is_array($request->tahapan_keberatan)) {
            foreach ($request->tahapan_keberatan as $index => $item) {
                if (!empty($item['judul'])) {
                    $tahapanKeberatan[] = [
                        'nomor' => sprintf('%02d', $index + 1),
                        'judul' => $item['judul'],
                        'deskripsi' => $item['deskripsi'] ?? '',
                        'catatan' => $item['catatan'] ?? '',
                        'ikon' => $item['ikon'] ?? 'fa-file-signature',
                    ];
                }
            }
        }

        // Process Syarat Dokumen
        $syaratDokumen = [
            'perorangan' => [
                'judul' => $request->input('syarat_perorangan_judul', 'Pemohon Perorangan'),
                'deskripsi' => $request->input('syarat_perorangan_deskripsi', ''),
                'poin' => array_values(array_filter($request->input('syarat_perorangan_poin', [])))
            ],
            'kelompok' => [
                'judul' => $request->input('syarat_kelompok_judul', 'Kelompok Masyarakat'),
                'deskripsi' => $request->input('syarat_kelompok_deskripsi', ''),
                'poin' => array_values(array_filter($request->input('syarat_kelompok_poin', [])))
            ],
            'badan_hukum' => [
                'judul' => $request->input('syarat_badan_hukum_judul', 'Badan Hukum / NGO'),
                'deskripsi' => $request->input('syarat_badan_hukum_deskripsi', ''),
                'poin' => array_values(array_filter($request->input('syarat_badan_hukum_poin', [])))
            ]
        ];

        // Process SLA Matrix
        $slaMatrix = [];
        if ($request->has('sla_matrix') && is_array($request->sla_matrix)) {
            foreach ($request->sla_matrix as $index => $item) {
                if (!empty($item['layanan'])) {
                    $slaMatrix[] = [
                        'no' => $index + 1,
                        'layanan' => $item['layanan'],
                        'waktu' => $item['waktu'] ?? '',
                        'biaya' => $item['biaya'] ?? 'Gratis',
                        'output' => $item['output'] ?? ''
                    ];
                }
            }
        }

        // Process FAQs
        $faqs = [];
        if ($request->has('faqs') && is_array($request->faqs)) {
            foreach ($request->faqs as $item) {
                if (!empty($item['tanya'])) {
                    $faqs[] = [
                        'tanya' => $item['tanya'],
                        'jawab' => $item['jawab'] ?? ''
                    ];
                }
            }
        }

        // Save to DB
        $prosedur = ProsedurPermohonan::first() ?? new ProsedurPermohonan();
        $prosedur->judul = $request->judul;
        $prosedur->subjudul = $request->subjudul;
        $prosedur->jangka_waktu = $request->jangka_waktu;
        $prosedur->biaya_layanan = $request->biaya_layanan;
        $prosedur->syarat_utama = $request->syarat_utama;
        $prosedur->hak_pemohon = $request->hak_pemohon;
        $prosedur->tahapan_permohonan = $tahapanPermohonan;
        $prosedur->tahapan_keberatan = $tahapanKeberatan;
        $prosedur->syarat_dokumen = $syaratDokumen;
        $prosedur->sla_matrix = $slaMatrix;
        $prosedur->faqs = $faqs;
        $prosedur->save();

        return redirect()->back()->with('success', 'Konten Prosedur Permohonan Informasi berhasil diperbarui!');
    }
}
