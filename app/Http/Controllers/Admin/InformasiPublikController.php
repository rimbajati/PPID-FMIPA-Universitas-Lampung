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

        $standarBerkalaPerki = [
            'Profil unit (kedudukan, tugas, struktur, pejabat)',
            'Program dan kegiatan tahun berjalan',
            'Ringkasan kinerja',
            'Ringkasan laporan keuangan / realisasi anggaran',
            'Ringkasan laporan akses informasi publik',
            'Peraturan, keputusan, dan kebijakan unit',
            'Prosedur memperoleh informasi publik',
            'Tata cara pengaduan penyalahgunaan wewenang',
            'Pengadaan barang dan jasa',
            'Ketenagakerjaan dan penerimaan',
            'Prosedur peringatan dini dan evakuasi keadaan darurat',
        ];

        $listRincian = collect(array_values(array_unique(array_merge($standarBerkalaPerki, InformasiPublik::whereNotNull('rincian_informasi')
                        ->where('rincian_informasi', '!=', '')
                        ->distinct()
                        ->pluck('rincian_informasi')
                        ->toArray()))))->sort()->values();

        $existingBerkala = InformasiPublik::where('jenis_informasi', 'Informasi Berkala')
                        ->whereNotNull('rincian_informasi')
                        ->where('rincian_informasi', '!=', '')
                        ->distinct()
                        ->pluck('rincian_informasi')
                        ->toArray();

        // Gabungkan dengan urutan standar 1-11 Perki tetap di atas (Profil Unit teratas)
        $listRincianBerkala = collect(array_values(array_unique(array_merge($standarBerkalaPerki, $existingBerkala))));

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

        $listJudul = InformasiPublik::distinct()->pluck('ringkasan_isi_informasi');
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
                        ->where('retensi_arsip', '!=', '')
                        ->distinct()
                        ->orderBy('retensi_arsip', 'asc')
                        ->pluck('retensi_arsip');

        if ($request->filled('kategori')) {
            $query->where('jenis_informasi', $request->kategori);
        } else {
            // Pada halaman Daftar Informasi Publik (DIP) Utama: hanya tampilkan dokumen yang sudah siap (bukan sedang dilengkapi unit)
            $query->where(function($q) {
                $q->where('sub_informasi', '!=', 'Dokumen sedang dilengkapi unit')
                  ->orWhereNull('sub_informasi');
            })->where(function($q) {
                $q->where('ringkasan_isi_informasi', '!=', 'Dokumen sedang dilengkapi unit')
                  ->orWhereNull('ringkasan_isi_informasi');
            });
        }

        if ($request->filled('judul')) {
            $query->where(function($q) use ($request) {
                $q->where('sub_informasi', $request->judul)
                  ->orWhere('ringkasan_isi_informasi', $request->judul);
            });
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
                  ->orWhereRaw('LOWER(COALESCE(ringkasan_isi_informasi, "")) LIKE ?', ["%{$term}%"])
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
            $query->orderBy('ringkasan_isi_informasi', 'asc');
        } elseif ($request->sort == 'judul_desc') {
            $query->orderBy('ringkasan_isi_informasi', 'desc');
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
            'informasi', 'listJenis', 'listRincian', 'listRincianBerkala', 'listRincianSetiapSaat', 'listRincianSertaMerta', 'listJudul', 'listTahun', 'listSatker', 'listBentuk', 'listRetensi', 'totalInformasi', 'totalSetiapSaat', 'totalBerkala', 'totalSertaMerta', 'totalDikecualikan',
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

            // Ubah ringkasan_isi_informasi menjadi TEXT agar muat deskripsi panjang
            try {
                \Illuminate\Support\Facades\DB::statement('ALTER TABLE informasi_publiks MODIFY ringkasan_isi_informasi TEXT NULL');
            } catch (\Exception $e) {}

            // Jika sub_informasi masih kosong, salin dari ringkasan_isi_informasi dan buat ringkasan deskripsi yang informatif
            $nullSubs = \Illuminate\Support\Facades\DB::table('informasi_publiks')
                ->where(function($q) {
                    $q->whereNull('sub_informasi')->orWhere('sub_informasi', '');
                })
                ->get();

            foreach ($nullSubs as $row) {
                $subVal = $row->ringkasan_isi_informasi ?: ($row->rincian_informasi ?: 'Dokumen Informasi');
                \Illuminate\Support\Facades\DB::table('informasi_publiks')
                    ->where('id', $row->id)
                    ->update([
                        'sub_informasi' => $subVal,
                        'ringkasan_isi_informasi' => 'Dokumen resmi mengenai ' . strtolower($subVal) . ' di lingkungan FMIPA Universitas Lampung.'
                    ]);
            }
        }

        // Sinkronisasi otomatis 11 poin standar Informasi Wajib Berkala sesuai Website Resmi Monev PPID FMIPA Unila (https://monev-ppid.unila.ac.id/pelaksana/fmipa)
        if (\Illuminate\Support\Facades\Schema::hasTable('informasi_publiks')) {
            $syncKey = 'monev_fmipa_synced_v3';
            if (!\Illuminate\Support\Facades\Cache::has($syncKey)) {
                // Hapus data Informasi Berkala lama agar terbarui bersih sesuai monev-ppid.unila.ac.id/pelaksana/fmipa
                \App\Models\InformasiPublik::where('jenis_informasi', 'Informasi Berkala')->delete();

                $monevBerkalaData = [
                    // 1. PROFIL
                    [
                        'rincian' => 'Profil Unit',
                        'sub' => 'Profil unit (kedudukan, tugas, struktur, pejabat)',
                        'ringkasan' => 'Profil Fakultas Matematika dan Ilmu Pengetahuan Alam tersedia pada situs unit dan profil universitas.',
                        'pejabat' => 'Dekanat / Bagian Tata Usaha FMIPA',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => 'https://fmipa.unila.ac.id',
                        'bentuk' => 'Online',
                    ],
                    // 2. PROGRAM
                    [
                        'rincian' => 'Program dan Kegiatan Tahun Berjalan',
                        'sub' => 'Dokumen sedang dilengkapi unit',
                        'ringkasan' => 'Dokumen sedang dilengkapi unit',
                        'pejabat' => 'Dekanat / Bagian Tata Usaha FMIPA',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => '#',
                        'bentuk' => 'Online',
                    ],
                    // 3. KINERJA
                    [
                        'rincian' => 'Ringkasan Kinerja',
                        'sub' => 'Dokumen sedang dilengkapi unit',
                        'ringkasan' => 'Dokumen sedang dilengkapi unit',
                        'pejabat' => 'Dekanat / Bagian Tata Usaha FMIPA',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => '#',
                        'bentuk' => 'Online',
                    ],
                    // 4. KEUANGAN
                    [
                        'rincian' => 'Ringkasan Laporan Keuangan / Realisasi Anggaran',
                        'sub' => 'Dokumen sedang dilengkapi unit',
                        'ringkasan' => 'Dokumen sedang dilengkapi unit',
                        'pejabat' => 'Dekanat / Bagian Tata Usaha FMIPA',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => '#',
                        'bentuk' => 'Online',
                    ],
                    // 5. AKSES
                    [
                        'rincian' => 'Ringkasan Laporan Akses Informasi Publik',
                        'sub' => 'Statistik dan Laporan Akses Informasi Publik',
                        'ringkasan' => 'Lihat statistik layanan unit pada seksi Laporan & Statistik.',
                        'pejabat' => 'PPID Pelaksana FMIPA Unila',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => url('/statistik'),
                        'bentuk' => 'Online',
                    ],
                    // 6. PERATURAN
                    [
                        'rincian' => 'Peraturan, Keputusan, dan Kebijakan Unit',
                        'sub' => 'Dokumen sedang dilengkapi unit',
                        'ringkasan' => 'Dokumen sedang dilengkapi unit',
                        'pejabat' => 'Dekanat / Bagian Tata Usaha FMIPA',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => '#',
                        'bentuk' => 'Online',
                    ],
                    // 7. PROSEDUR
                    [
                        'rincian' => 'Prosedur Memperoleh Informasi Publik',
                        'sub' => 'Tata Cara dan Prosedur Permohonan Informasi Publik',
                        'ringkasan' => 'Prosedur permohonan melalui formulir online atau meja layanan, pemberian nomor registrasi, dan tindak lanjut maksimal 10 hari kerja.',
                        'pejabat' => 'PPID Pelaksana FMIPA Unila',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => url('/layanan'),
                        'bentuk' => 'Online',
                    ],
                    // 8. PENGADUAN
                    [
                        'rincian' => 'Tata Cara Pengaduan Penyalahgunaan Wewenang',
                        'sub' => 'Tata Cara Pengaduan Penyalahgunaan Wewenang / Pelanggaran Pejabat',
                        'ringkasan' => 'Pengaduan pelanggaran/penyalahgunaan wewenang melalui kanal resmi Universitas Lampung dan SP4N LAPOR! (lapor.go.id) dengan perlindungan pelapor.',
                        'pejabat' => 'PPID Pelaksana FMIPA Unila',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => 'https://ppid.unila.ac.id/tata-cara-pengaduan-penyalahgunaan-wewenang-pejabat/',
                        'bentuk' => 'Online',
                    ],
                    // 9. PENGADAAN
                    [
                        'rincian' => 'Pengadaan Barang dan Jasa',
                        'sub' => 'Informasi Pengadaan Barang dan Jasa',
                        'ringkasan' => 'Informasi pengadaan barang/jasa Universitas Lampung diumumkan melalui LPSE/SPSE dan RUP (SiRUP) FMIPA Unila.',
                        'pejabat' => 'Bagian Pengadaan Barang dan Jasa FMIPA Unila',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => 'https://lpse.unila.ac.id',
                        'bentuk' => 'Online',
                    ],
                    // 10. KETENAGAKERJAAN
                    [
                        'rincian' => 'Ketenagakerjaan dan Penerimaan',
                        'sub' => 'Dokumen sedang dilengkapi unit',
                        'ringkasan' => 'Dokumen sedang dilengkapi unit',
                        'pejabat' => 'Dekanat / Kepegawaian FMIPA',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => '#',
                        'bentuk' => 'Online',
                    ],
                    // 11. DARURAT
                    [
                        'rincian' => 'Prosedur Peringatan Dini dan Evakuasi Keadaan Darurat',
                        'sub' => 'Dokumen sedang dilengkapi unit',
                        'ringkasan' => 'Dokumen sedang dilengkapi unit',
                        'pejabat' => 'Subbag Umum dan Keuangan FMIPA',
                        'penanggung' => 'PPID Pelaksana FMIPA Unila',
                        'link' => '#',
                        'bentuk' => 'Online',
                    ],
                ];

                foreach ($monevBerkalaData as $item) {
                    \App\Models\InformasiPublik::create([
                        'jenis_informasi' => 'Informasi Berkala',
                        'rincian_informasi' => $item['rincian'],
                        'sub_informasi' => $item['sub'],
                        'ringkasan_isi_informasi' => $item['ringkasan'],
                        'pejabat_unit_yang_menguasai_informasi' => $item['pejabat'],
                        'penanggung_jawab_pembuatan_informasi' => $item['penanggung'],
                        'waktu_pembuatan_informasi' => date('Y'),
                        'retensi_arsip' => 'Selama Berlaku',
                        'bentuk_informasi_yang_tersedia' => $item['bentuk'],
                        'link_informasi' => $item['link'],
                        'file_informasi' => null,
                        'dilihat' => 0,
                    ]);
                }

                \Illuminate\Support\Facades\Cache::forever($syncKey, true);
            }
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rincian_informasi'                      => 'nullable|string|max:255',
            'sub_informasi'                          => 'nullable|string|max:255',
            'ringkasan_isi_informasi'                => 'nullable|string|max:1000',
            'pejabat_unit_yang_menguasai_informasi'  => 'required|string|max:255',
            'penanggung_jawab_pembuatan_informasi'   => 'nullable|string|max:255',
            'waktu_pembuatan_informasi'              => 'required|string|max:255',
            'bentuk_informasi_yang_tersedia'         => 'required|string|max:100',
            'retensi_arsip'                          => 'required|string|max:255',
            'jenis_informasi'                        => ['required', Rule::in(['Informasi Setiap Saat', 'Informasi Berkala', 'Informasi Serta-Merta'])],
            'file_informasi'                         => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'link_informasi'                         => 'nullable|url',
        ], [
            'file_informasi.mimes' => 'Format file tidak didukung! Hanya diperbolehkan file PDF, DOC, DOCX, XLS, atau XLSX.',
            'file_informasi.max'   => 'Ukuran file melebihi batas maksimal (Maksimal 5 MB)!',
        ]);

        // Jika sub_informasi kosong, otomatis berstatus 'Dokumen sedang dilengkapi unit'
        if (empty(trim($validated['sub_informasi'] ?? ''))) {
            $validated['sub_informasi'] = 'Dokumen sedang dilengkapi unit';
        }

        if ($request->bentuk_informasi_yang_tersedia === 'Cetak') {
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
                // Berkas atau tautan belum tersedia (opsional untuk mendukung rincian dibuat terlebih dahulu)
                $validated['file_informasi'] = null;
                $validated['link_informasi'] = null;
                $validated['nama_file_asli'] = null;
            }
        }

        InformasiPublik::create($validated);

        return redirect()->back()->with('success', 'Data Informasi Publik berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $info = InformasiPublik::findOrFail($id);

        $validated = $request->validate([
            'rincian_informasi'                      => 'nullable|string|max:255',
            'sub_informasi'                          => 'nullable|string|max:255',
            'ringkasan_isi_informasi'                => 'nullable|string|max:1000',
            'pejabat_unit_yang_menguasai_informasi'  => 'required|string|max:255',
            'penanggung_jawab_pembuatan_informasi'   => 'nullable|string|max:255',
            'waktu_pembuatan_informasi'              => 'required|string|max:255',
            'bentuk_informasi_yang_tersedia'         => 'required|string|max:100',
            'retensi_arsip'                          => 'required|string|max:255',
            'jenis_informasi'                => ['required', Rule::in(['Informasi Setiap Saat', 'Informasi Berkala', 'Informasi Serta-Merta'])],
            'file_informasi'                 => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'link_informasi'                 => 'nullable|url',
        ], [
            'file_informasi.mimes' => 'Format file tidak didukung! Hanya diperbolehkan file PDF, DOC, DOCX, XLS, atau XLSX.',
            'file_informasi.max'   => 'Ukuran file melebihi batas maksimal (Maksimal 5 MB)!',
        ]);

        if (empty(trim($validated['sub_informasi'] ?? ''))) {
            $validated['sub_informasi'] = 'Dokumen sedang dilengkapi unit';
        }

        if ($request->bentuk_informasi_yang_tersedia === 'Cetak') {
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

        if ($info->file_informasi && Storage::disk('public')->exists($info->file_informasi)) {
            Storage::disk('public')->delete($info->file_informasi);
        }

        $info->delete();
        return redirect()->back()->with('success', 'Data Informasi Publik berhasil dihapus.');
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
