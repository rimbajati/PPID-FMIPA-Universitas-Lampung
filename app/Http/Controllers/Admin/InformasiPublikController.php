<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InformasiPublikController extends Controller
{
    public function index(Request $request)
    {
        $query = InformasiPublik::query();

        $listJenis = InformasiPublik::whereNotNull('jenis_informasi')
                        ->where('jenis_informasi', '!=', '')
                        ->distinct()
                        ->orderBy('jenis_informasi', 'asc')
                        ->pluck('jenis_informasi');

        $listRincian = InformasiPublik::whereNotNull('rincian_informasi')
                        ->where('rincian_informasi', '!=', '')
                        ->distinct()
                        ->orderBy('rincian_informasi', 'asc')
                        ->pluck('rincian_informasi');

        $listRincianBerkala = InformasiPublik::where('jenis_informasi', 'Informasi Berkala')
                        ->whereNotNull('rincian_informasi')
                        ->where('rincian_informasi', '!=', '')
                        ->distinct()
                        ->orderBy('rincian_informasi', 'asc')
                        ->pluck('rincian_informasi');

        $listRincianSetiapSaat = InformasiPublik::where('jenis_informasi', 'Informasi Setiap Saat')
                        ->whereNotNull('rincian_informasi')
                        ->where('rincian_informasi', '!=', '')
                        ->distinct()
                        ->orderBy('rincian_informasi', 'asc')
                        ->pluck('rincian_informasi');

        $listRincianSertaMerta = InformasiPublik::where('jenis_informasi', 'Informasi Serta-Merta')
                        ->whereNotNull('rincian_informasi')
                        ->where('rincian_informasi', '!=', '')
                        ->distinct()
                        ->orderBy('rincian_informasi', 'asc')
                        ->pluck('rincian_informasi');

        $listJudul = InformasiPublik::whereNotNull('sub_informasi')->where('sub_informasi', '!=', '')->where('sub_informasi', '!=', 'Dokumen sedang dilengkapi unit')->distinct()->orderBy('sub_informasi', 'asc')->pluck('sub_informasi');
        $listTahun = InformasiPublik::whereNotNull('waktu_pembuatan_informasi')
                        ->where('waktu_pembuatan_informasi', '!=', '')
                        ->distinct()
                        ->orderBy('waktu_pembuatan_informasi', 'desc')
                        ->pluck('waktu_pembuatan_informasi');

        $listSatker = InformasiPublik::whereNotNull('pejabat_unit_yang_menguasai_informasi')
                        ->where('pejabat_unit_yang_menguasai_informasi', '!=', '')
                        ->distinct()
                        ->orderBy('pejabat_unit_yang_menguasai_informasi', 'asc')
                        ->pluck('pejabat_unit_yang_menguasai_informasi');

        $listBentuk = InformasiPublik::whereNotNull('bentuk_informasi_yang_tersedia')
                        ->where('bentuk_informasi_yang_tersedia', '!=', '')
                        ->distinct()
                        ->orderBy('bentuk_informasi_yang_tersedia', 'asc')
                        ->pluck('bentuk_informasi_yang_tersedia');

        $listRetensi = InformasiPublik::whereNotNull('retensi_arsip')
                        ->where('retensi_arsip', '!='  , '')
                        ->distinct()
                        ->orderBy('retensi_arsip', 'asc')
                        ->pluck('retensi_arsip');

        $listPenanggungJawab = InformasiPublik::whereNotNull('penanggung_jawab_pembuatan_informasi')
                        ->where('penanggung_jawab_pembuatan_informasi', '!='  , '')
                        ->distinct()
                        ->orderBy('penanggung_jawab_pembuatan_informasi', 'asc')
                        ->pluck('penanggung_jawab_pembuatan_informasi');

        // Map: rincian_informasi => [sub_informasi, ...] untuk dropdown dinamis di modal
        $listSubByRincian = InformasiPublik::whereNotNull('sub_informasi')
                        ->where('sub_informasi', '!=', '')
                        ->where('sub_informasi', '!=', 'Dokumen sedang dilengkapi unit')
                        ->whereNotNull('rincian_informasi')
                        ->where('rincian_informasi', '!=', '')
                        ->select('rincian_informasi', 'sub_informasi')
                        ->distinct()
                        ->orderBy('rincian_informasi')
                        ->orderBy('sub_informasi')
                        ->get()
                        ->groupBy('rincian_informasi')
                        ->map(fn($items) => $items->pluck('sub_informasi')->values()->toArray())
                        ->toArray();

        if ($request->filled('kategori')) {
            $query->where('jenis_informasi', $request->kategori);
        } else {
            // Pada halaman Daftar Informasi Publik (DIP) Utama: hanya tampilkan dokumen yang sudah siap (bukan sedang dilengkapi unit)
            $query->where(function($q) {
                $q->where('sub_informasi', '!=', 'Dokumen sedang dilengkapi unit')
                  ->orWhereNull('sub_informasi');
            });
        }

        if ($request->filled('judul')) {
            $query->where('sub_informasi', $request->judul);
        }

        if ($request->filled('tahun')) {
            $query->where('waktu_pembuatan_informasi', $request->tahun);
        }

        if ($request->filled('satker')) {
            $query->where('pejabat_unit_yang_menguasai_informasi', $request->satker);
        }

        if ($request->filled('bentuk')) {
            $query->where('bentuk_informasi_yang_tersedia', $request->bentuk);
        }

        if ($request->filled('retensi')) {
            $query->where('retensi_arsip', $request->retensi);
        }

        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(COALESCE(sub_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(rincian_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(pejabat_unit_yang_menguasai_informasi, "")) LIKE ?', ["%{$term}%"]);
            });
        }

        // Sorting: Serta-Merta (pengumuman) tampil terbaru di atas (latest), sedangkan kategori DIP lainnya dikelompokkan berdasarkan Rincian Informasi (Topik) agar sub-informasi satu topik selalu berkumpul berurutan
        if ($request->sort == 'terlama') {
            $query->oldest();
        } elseif ($request->sort == 'terbaru') {
            $query->latest();
        } elseif ($request->sort == 'judul_asc') {
            $query->orderBy('sub_informasi', 'asc');
        } elseif ($request->sort == 'judul_desc') {
            $query->orderBy('sub_informasi', 'desc');
        } else {
            if ($request->kategori === 'Informasi Serta-Merta') {
                $query->latest();
            } elseif ($request->kategori === 'Informasi Berkala') {
                // Sesuai urutan standar website Monev PPID Unila / Perki 1/2021: Profil Unit nomor 1
                $query->orderByRaw("
                    CASE 
                        WHEN rincian_informasi LIKE 'Profil Unit%' OR rincian_informasi LIKE 'Profil Badan Publik%' THEN 1
                        WHEN rincian_informasi LIKE 'Program dan Kegiatan%' THEN 2
                        WHEN rincian_informasi LIKE 'Ringkasan Kinerja%' THEN 3
                        WHEN rincian_informasi LIKE 'Ringkasan Laporan Keuangan%' THEN 4
                        WHEN rincian_informasi LIKE 'Ringkasan Laporan Akses%' THEN 5
                        WHEN rincian_informasi LIKE 'Peraturan, Keputusan%' THEN 6
                        WHEN rincian_informasi LIKE 'Prosedur Memperoleh%' THEN 7
                        WHEN rincian_informasi LIKE 'Tata Cara Pengaduan%' THEN 8
                        WHEN rincian_informasi LIKE 'Pengadaan Barang%' THEN 9
                        WHEN rincian_informasi LIKE 'Ketenagakerjaan%' THEN 10
                        WHEN rincian_informasi LIKE 'Prosedur Peringatan Dini%' THEN 11
                        ELSE 12
                    END ASC
                ")->orderBy('id', 'asc');
            } elseif ($request->filled('kategori')) {
                // Kategori Setiap Saat atau lainnya
                $query->orderBy('rincian_informasi', 'asc')->orderBy('id', 'asc');
            } else {
                // Seluruh DIP: Kelompokkan berdasarkan urutan resmi jenis informasi
                // (1. Informasi Berkala [dengan urutan 1-11 standar], 2. Informasi Setiap Saat, 3. Informasi Serta-Merta)
                $query->orderByRaw("
                    CASE 
                        WHEN jenis_informasi = 'Informasi Berkala' THEN 1
                        WHEN jenis_informasi = 'Informasi Setiap Saat' THEN 2
                        WHEN jenis_informasi = 'Informasi Serta-Merta' THEN 3
                        ELSE 4
                    END ASC
                ")->orderByRaw("
                    CASE 
                        WHEN rincian_informasi LIKE 'Profil Unit%' OR rincian_informasi LIKE 'Profil Badan Publik%' THEN 1
                        WHEN rincian_informasi LIKE 'Program dan Kegiatan%' THEN 2
                        WHEN rincian_informasi LIKE 'Ringkasan Kinerja%' THEN 3
                        WHEN rincian_informasi LIKE 'Ringkasan Laporan Keuangan%' THEN 4
                        WHEN rincian_informasi LIKE 'Ringkasan Laporan Akses%' THEN 5
                        WHEN rincian_informasi LIKE 'Peraturan, Keputusan%' THEN 6
                        WHEN rincian_informasi LIKE 'Prosedur Memperoleh%' THEN 7
                        WHEN rincian_informasi LIKE 'Tata Cara Pengaduan%' THEN 8
                        WHEN rincian_informasi LIKE 'Pengadaan Barang%' THEN 9
                        WHEN rincian_informasi LIKE 'Ketenagakerjaan%' THEN 10
                        WHEN rincian_informasi LIKE 'Prosedur Peringatan Dini%' THEN 11
                        ELSE 12
                    END ASC
                ")->orderBy('rincian_informasi', 'asc')->orderBy('id', 'asc');
            }
        }

        $totalInformasi = InformasiPublik::count();
        $totalSetiapSaat = InformasiPublik::where('jenis_informasi', 'Informasi Setiap Saat')->count();
        $totalBerkala = InformasiPublik::where('jenis_informasi', 'Informasi Berkala')->count();
        $totalSertaMerta = InformasiPublik::where('jenis_informasi', 'Informasi Serta-Merta')->count();
        $totalDikecualikan = \App\Models\InformasiDikecualikan::count();

        // Tanggal Update Terakhir per Kategori
        $lastUpdateTotal = InformasiPublik::max('updated_at');
        $lastUpdateBerkala = InformasiPublik::where('jenis_informasi', 'Informasi Berkala')->max('updated_at');
        $lastUpdateSertaMerta = InformasiPublik::where('jenis_informasi', 'Informasi Serta-Merta')->max('updated_at');
        $lastUpdateSetiapSaat = InformasiPublik::where('jenis_informasi', 'Informasi Setiap Saat')->max('updated_at');
        $lastUpdateDikecualikan = \App\Models\InformasiDikecualikan::max('updated_at');

        $informasi = $query->get();

        return view('admin.informasi_publik.index', compact(
            'informasi', 'listJenis', 'listRincian', 'listRincianBerkala', 'listRincianSetiapSaat', 'listRincianSertaMerta', 'listJudul', 'listTahun', 'listSatker', 'listBentuk', 'listRetensi', 'listPenanggungJawab', 'listSubByRincian', 'totalInformasi', 'totalSetiapSaat', 'totalBerkala', 'totalSertaMerta', 'totalDikecualikan',
            'lastUpdateTotal', 'lastUpdateBerkala', 'lastUpdateSertaMerta', 'lastUpdateSetiapSaat', 'lastUpdateDikecualikan'
        ));
    }

    public function __construct()
    {
        // Pastikan kolom penanggung_jawab_pembuatan_informasi sudah ada di database jika migration belum jalan
        if (\Illuminate\Support\Facades\Schema::hasTable('informasi_publiks') && !\Illuminate\Support\Facades\Schema::hasColumn('informasi_publiks', 'penanggung_jawab_pembuatan_informasi')) {
            \Illuminate\Support\Facades\Schema::table('informasi_publiks', function ($table) {
                $table->string('penanggung_jawab_pembuatan_informasi')->nullable()->after('pejabat_unit_yang_menguasai_informasi');
            });
        }

        // Pastikan kolom sub_informasi sudah ada di database
        if (\Illuminate\Support\Facades\Schema::hasTable('informasi_publiks')) {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('informasi_publiks', 'sub_informasi')) {
                \Illuminate\Support\Facades\Schema::table('informasi_publiks', function ($table) {
                    $table->string('sub_informasi')->nullable()->after('rincian_informasi');
                });
            }


        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rincian_informasi'                      => 'required|string|max:255',
            'sub_informasi'                          => 'nullable|string|max:255',
            'pejabat_unit_yang_menguasai_informasi'  => 'nullable|string|max:255',
            'penanggung_jawab_pembuatan_informasi'   => 'nullable|string|max:255',
            'waktu_pembuatan_informasi'              => 'nullable|string|max:255',
            'bentuk_informasi_yang_tersedia'         => 'nullable|string|max:100',
            'retensi_arsip'                          => 'nullable|string|max:255',
            'jenis_informasi'                        => ['required', Rule::in(['Informasi Setiap Saat', 'Informasi Berkala', 'Informasi Serta-Merta'])],
            'file_informasi'                         => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'link_informasi'                         => 'nullable|url',
        ], [
            'rincian_informasi.required' => 'Rincian Informasi wajib diisi.',
            'file_informasi.mimes'       => 'Format file tidak didukung! Hanya diperbolehkan file PDF, DOC, DOCX, XLS, atau XLSX.',
            'file_informasi.max'         => 'Ukuran file melebihi batas maksimal (Maksimal 5 MB)!',
        ]);

        $rincian = trim($validated['rincian_informasi']);
        $sub = trim($validated['sub_informasi'] ?? '');

        // Normalisasi rincian: jika rincian dengan nama serupa (case-insensitive) sudah ada,
        // UPDATE semua data lama agar menggunakan penulisan yang baru diketik admin.
        // Contoh: DB ada "Profil Unit", admin ketik "Profil unit" → semua data lama diubah jadi "Profil unit".
        $existingRincian = InformasiPublik::whereRaw('LOWER(rincian_informasi) = ?', [strtolower($rincian)])
            ->value('rincian_informasi');
        if ($existingRincian !== null && $existingRincian !== $rincian) {
            InformasiPublik::whereRaw('LOWER(rincian_informasi) = ?', [strtolower($rincian)])
                ->update(['rincian_informasi' => $rincian]);
        }

        // Jika sub_informasi kosong, otomatis berstatus 'Dokumen sedang dilengkapi unit' (hanya rincian informasi)
        if (empty($sub)) {
            $validated['sub_informasi'] = 'Dokumen sedang dilengkapi unit';
        } else {
            $validated['sub_informasi'] = $sub;
        }

        // Nilai kolom detail: simpan null jika dikosongkan oleh admin
        $validated['pejabat_unit_yang_menguasai_informasi'] = !empty(trim($validated['pejabat_unit_yang_menguasai_informasi'] ?? '')) 
            ? trim($validated['pejabat_unit_yang_menguasai_informasi']) 
            : null;
            
        $validated['penanggung_jawab_pembuatan_informasi'] = !empty(trim($validated['penanggung_jawab_pembuatan_informasi'] ?? '')) 
            ? trim($validated['penanggung_jawab_pembuatan_informasi']) 
            : null;

        $validated['waktu_pembuatan_informasi'] = !empty(trim($validated['waktu_pembuatan_informasi'] ?? '')) 
            ? trim($validated['waktu_pembuatan_informasi']) 
            : null;

        $validated['bentuk_informasi_yang_tersedia'] = !empty(trim($validated['bentuk_informasi_yang_tersedia'] ?? '')) 
            ? trim($validated['bentuk_informasi_yang_tersedia']) 
            : null;

        $validated['retensi_arsip'] = !empty(trim($validated['retensi_arsip'] ?? '')) 
            ? trim($validated['retensi_arsip']) 
            : null;

        if ($validated['bentuk_informasi_yang_tersedia'] === 'Cetak') {
            $validated['file_informasi'] = null;
            $validated['link_informasi'] = null;
            $validated['nama_file_asli'] = null;
        } else {
            if ($request->hasFile('file_informasi')) {
                $file = $request->file('file_informasi');
                $path = $file->store('informasi_publik', 'public');
                $validated['file_informasi'] = $path;
                $validated['link_informasi'] = null;
                $validated['nama_file_asli'] = $file->getClientOriginalName();
            } else if ($request->filled('link_informasi')) {
                $validated['file_informasi'] = null;
                $validated['link_informasi'] = $request->link_informasi;
                $validated['nama_file_asli'] = null;
            } else {
                $validated['file_informasi'] = null;
                $validated['link_informasi'] = null;
                $validated['nama_file_asli'] = null;
            }
        }

        // Jika sub_informasi kosong (hanya rincian informasi), cek apakah topik ini sudah pernah dibuat sebelumnya.
        // Jika sudah ada, jangan buat baris duplikat baru!
        if (empty($sub)) {
            $existingRincian = InformasiPublik::where('jenis_informasi', $validated['jenis_informasi'])
                ->where('rincian_informasi', $rincian)
                ->first();

            if ($existingRincian) {
                return redirect()->back()->with('success', 'Rincian Informasi "' . $rincian . '" sudah tersedia.');
            }
        }

        // Jika rincian ini sebelumnya sudah ada baris placeholder ('Dokumen sedang dilengkapi unit')
        // dan admin sekarang mengisi dokumen baru (sub_informasi terisi), maka update baris placeholder tersebut
        // agar tidak menimbulkan baris ganda yang membingungkan.
        if (!empty($sub)) {
            $existingPlaceholder = InformasiPublik::where('jenis_informasi', $validated['jenis_informasi'])
                ->where('rincian_informasi', $rincian)
                ->where(function($q) {
                    $q->where('sub_informasi', 'Dokumen sedang dilengkapi unit')
                      ->orWhereNull('sub_informasi')
                      ->orWhere('sub_informasi', '');
                })
                ->first();

            if ($existingPlaceholder) {
                $existingPlaceholder->update($validated);
                return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan ke Rincian Informasi.');
            }
        }

        InformasiPublik::create($validated);

        return redirect()->back()->with('success', 'Data Informasi Publik berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $info = InformasiPublik::findOrFail($id);

        $validated = $request->validate([
            'rincian_informasi'                      => 'required|string|max:255',
            'sub_informasi'                          => 'nullable|string|max:255',
            'pejabat_unit_yang_menguasai_informasi'  => 'nullable|string|max:255',
            'penanggung_jawab_pembuatan_informasi'   => 'nullable|string|max:255',
            'waktu_pembuatan_informasi'              => 'nullable|string|max:255',
            'bentuk_informasi_yang_tersedia'         => 'nullable|string|max:100',
            'retensi_arsip'                          => 'nullable|string|max:255',
            'jenis_informasi'                        => ['required', Rule::in(['Informasi Setiap Saat', 'Informasi Berkala', 'Informasi Serta-Merta'])],
            'file_informasi'                         => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'link_informasi'                         => 'nullable|url',
        ], [
            'rincian_informasi.required' => 'Rincian Informasi wajib diisi.',
            'file_informasi.mimes'       => 'Format file tidak didukung! Hanya diperbolehkan file PDF, DOC, DOCX, XLS, atau XLSX.',
            'file_informasi.max'         => 'Ukuran file melebihi batas maksimal (Maksimal 5 MB)!',
        ]);

        $rincian = trim($validated['rincian_informasi']);
        $sub = trim($validated['sub_informasi'] ?? '');

        if (empty($sub)) {
            $validated['sub_informasi'] = 'Dokumen sedang dilengkapi unit';
        } else {
            $validated['sub_informasi'] = $sub;
        }

        $validated['pejabat_unit_yang_menguasai_informasi'] = !empty(trim($validated['pejabat_unit_yang_menguasai_informasi'] ?? '')) 
            ? trim($validated['pejabat_unit_yang_menguasai_informasi']) 
            : null;
            
        $validated['penanggung_jawab_pembuatan_informasi'] = !empty(trim($validated['penanggung_jawab_pembuatan_informasi'] ?? '')) 
            ? trim($validated['penanggung_jawab_pembuatan_informasi']) 
            : null;

        $validated['waktu_pembuatan_informasi'] = !empty(trim($validated['waktu_pembuatan_informasi'] ?? '')) 
            ? trim($validated['waktu_pembuatan_informasi']) 
            : null;

        $validated['bentuk_informasi_yang_tersedia'] = !empty(trim($validated['bentuk_informasi_yang_tersedia'] ?? '')) 
            ? trim($validated['bentuk_informasi_yang_tersedia']) 
            : null;

        $validated['retensi_arsip'] = !empty(trim($validated['retensi_arsip'] ?? '')) 
            ? trim($validated['retensi_arsip']) 
            : null;

        if ($validated['bentuk_informasi_yang_tersedia'] === 'Cetak') {
            if ($info->file_informasi && Storage::disk('public')->exists($info->file_informasi)) {
                Storage::disk('public')->delete($info->file_informasi);
            }
            $validated['file_informasi'] = null;
            $validated['link_informasi'] = null;
            $validated['nama_file_asli'] = null;
        } else {
            $inputFormat = $request->input('jenis_informasi_format', 'file');

            if ($inputFormat === 'file') {
                if ($request->hasFile('file_informasi')) {
                    if ($info->file_informasi && Storage::disk('public')->exists($info->file_informasi)) {
                        Storage::disk('public')->delete($info->file_informasi);
                    }
                    $file = $request->file('file_informasi');
                    $path = $file->store('informasi_publik', 'public');
                    $validated['file_informasi'] = $path;
                    $validated['link_informasi'] = null;
                    $validated['nama_file_asli'] = $file->getClientOriginalName();
                } else {
                    $validated['file_informasi'] = $info->file_informasi;
                    $validated['link_informasi'] = null;
                }
            } else {
                if ($info->file_informasi && Storage::disk('public')->exists($info->file_informasi)) {
                    Storage::disk('public')->delete($info->file_informasi);
                }
                $validated['file_informasi'] = null;
                $validated['link_informasi'] = $request->link_informasi;
                $validated['nama_file_asli'] = null;
            }
        }

        $info->update($validated);

        return redirect()->back()->with('success', 'Data Informasi Publik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $info = InformasiPublik::findOrFail($id);
        $rincian = $info->rincian_informasi;
        $jenis = $info->jenis_informasi;

        if ($info->file_informasi && Storage::disk('public')->exists($info->file_informasi)) {
            Storage::disk('public')->delete($info->file_informasi);
        }

        // Cek berapa banyak entri dokumen untuk rincian informasi ini
        $siblingsCount = InformasiPublik::where('rincian_informasi', $rincian)
            ->where('jenis_informasi', $jenis)
            ->count();

        // Jika ini adalah dokumen terakhir pada rincian informasi tersebut,
        // ubah menjadi status kosong (Dokumen sedang dilengkapi unit) agar Rincian Informasinya TIDAK hilang!
        if ($siblingsCount <= 1) {
            $info->update([
                'sub_informasi' => 'Dokumen sedang dilengkapi unit',
                'pejabat_unit_yang_menguasai_informasi' => null,
                'penanggung_jawab_pembuatan_informasi' => null,
                'waktu_pembuatan_informasi' => null,
                'bentuk_informasi_yang_tersedia' => null,
                'retensi_arsip' => null,
                'file_informasi' => null,
                'nama_file_asli' => null,
                'link_informasi' => null,
            ]);
            return redirect()->back()->with('success', 'Dokumen berhasil dihapus. Rincian Informasi tetap dipertahankan.');
        }

        $info->delete();
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function destroyRincian(Request $request)
    {
        $rincian = $request->input('rincian');
        $jenis = $request->input('jenis');

        if (empty($rincian)) {
            return redirect()->back()->with('error', 'Rincian Informasi tidak valid.');
        }

        $query = InformasiPublik::where('rincian_informasi', $rincian);
        if (!empty($jenis)) {
            $query->where('jenis_informasi', $jenis);
        }

        $items = $query->get();
        foreach ($items as $item) {
            if ($item->file_informasi && Storage::disk('public')->exists($item->file_informasi)) {
                Storage::disk('public')->delete($item->file_informasi);
            }
            $item->delete();
        }

        return redirect()->back()->with('success', 'Rincian Informasi "' . $rincian . '" beserta seluruh isinya berhasil dihapus.');
    }

    public function renameRincian(Request $request)
    {
        $oldRincian = trim($request->input('old_rincian', ''));
        $newRincian = trim($request->input('new_rincian', ''));
        $jenis      = trim($request->input('jenis_informasi', ''));

        if (empty($oldRincian) || empty($newRincian)) {
            return response()->json(['success' => false, 'message' => 'Nama rincian tidak boleh kosong.'], 422);
        }

        $query = InformasiPublik::where('rincian_informasi', $oldRincian);
        if (!empty($jenis)) {
            $query->where('jenis_informasi', $jenis);
        }

        $updated = $query->update(['rincian_informasi' => $newRincian]);

        return response()->json([
            'success' => true,
            'message' => "Rincian \"$oldRincian\" berhasil diubah menjadi \"$newRincian\" ($updated data diperbarui).",
        ]);
    }


    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $items = InformasiPublik::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file_informasi && Storage::disk('public')->exists($item->file_informasi)) {
                Storage::disk('public')->delete($item->file_informasi);
            }
            $item->delete();
        }

        return redirect()->back()->with('success', count($items) . ' data Informasi Publik berhasil dihapus.');
    }
}
