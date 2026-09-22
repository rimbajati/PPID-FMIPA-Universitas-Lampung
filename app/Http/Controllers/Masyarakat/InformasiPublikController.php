<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use Illuminate\Http\Request;

class InformasiPublikController extends Controller
{
    /**
     * Menampilkan Katalog Informasi Publik untuk Masyarakat
     */
    public function index(Request $request)
    {
        $query = InformasiPublik::query();

        // Pada katalog DIP publik masyarakat: hanya tampilkan dokumen yang sudah siap
        $query->where(function($q) {
            $q->where('sub_informasi', '!=', 'Dokumen sedang dilengkapi unit')
              ->orWhereNull('sub_informasi');
        });

        // Filter pencarian di semua kolom isi tabel DIP (Optimized standard SQL LIKE)
        if ($request->filled('search')) {
            $term = trim($request->search);
            $query->where(function($q) use ($term) {
                $q->where('sub_informasi', 'like', "%{$term}%")
                  ->orWhere('rincian_informasi', 'like', "%{$term}%")
                  ->orWhere('pejabat_unit_yang_menguasai_informasi', 'like', "%{$term}%")
                  ->orWhere('penanggung_jawab_pembuatan_informasi', 'like', "%{$term}%")
                  ->orWhere('waktu_pembuatan_informasi', 'like', "%{$term}%")
                  ->orWhere('retensi_arsip', 'like', "%{$term}%")
                  ->orWhere('bentuk_informasi_yang_tersedia', 'like', "%{$term}%");
            });
        }

        // Filter berdasarkan satker / unit penguasa
        if ($request->filled('topik') || $request->filled('satker')) {
            $tp = $request->satker ?: $request->topik;
            if (is_array($tp)) {
                $query->whereIn('pejabat_unit_yang_menguasai_informasi', array_filter($tp));
            } else {
                $query->where('pejabat_unit_yang_menguasai_informasi', $tp);
            }
        }

        // Filter berdasarkan kategori/jenis informasi
        if ($request->filled('kategori')) {
            $kat = $request->kategori;
            if (is_array($kat)) {
                $query->whereIn('jenis_informasi', array_filter($kat));
            } else {
                $query->where('jenis_informasi', $kat);
            }
        }

        // Filter berdasarkan tahun terbit
        if ($request->filled('tahun')) {
            $thn = $request->tahun;
            if (is_array($thn)) {
                $query->whereIn('waktu_pembuatan_informasi', array_filter($thn));
            } else {
                $query->where('waktu_pembuatan_informasi', $thn);
            }
        }

        // Filter berdasarkan format file (pdf, docx, xlsx, link)
        if ($request->filled('format')) {
            $fmtReq = strtolower($request->format);
            if ($fmtReq === 'link') {
                $query->whereNotNull('link_informasi')->whereNull('file_informasi');
            } else {
                $query->where(function($q) use ($fmtReq) {
                    $q->where('nama_file_asli', 'like', '%.' . $fmtReq)
                      ->orWhere('file_informasi', 'like', '%.' . $fmtReq);
                });
            }
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

        $listJenis = InformasiPublik::whereNotNull('jenis_informasi')
            ->where('jenis_informasi', '!=', '')
            ->distinct()
            ->orderBy('jenis_informasi', 'asc')
            ->pluck('jenis_informasi');

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

        // Sorting Dinamis per Kolom (Header Sorting)
        $sortBy = $request->input('sort_by');
        $sortDir = strtolower($request->input('sort_direction', 'asc')) === 'desc' ? 'desc' : 'asc';

        $sortableColumns = [
            'no'              => 'id',
            'ringkasan'       => 'sub_informasi',
            'pejabat'         => 'pejabat_unit_yang_menguasai_informasi',
            'penanggung_jawab'=> 'penanggung_jawab_pembuatan_informasi',
            'waktu'           => 'waktu_pembuatan_informasi',
            'retensi'         => 'retensi_arsip',
            'bentuk'          => 'bentuk_informasi_yang_tersedia',
        ];

        if ($sortBy && isset($sortableColumns[$sortBy])) {
            $query->orderBy($sortableColumns[$sortBy], $sortDir);
        } else {
            // Sorting Default: Selalu kelompokkan berdasarkan urutan resmi jenis informasi
            // (1. Informasi Berkala, 2. Informasi Setiap Saat, 3. Informasi Serta-Merta)
            $sort = $request->input('sort', 'kategori_standar');
            if ($sort === 'terlama') {
                $query->orderBy('created_at', 'asc');
            } elseif ($sort === 'terbaru') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sort === 'az') {
                $query->orderBy('sub_informasi', 'asc');
            } elseif ($sort === 'za') {
                $query->orderBy('sub_informasi', 'desc');
            } elseif ($sort === 'populer') {
                $query->orderBy('dilihat', 'desc')->orderBy('created_at', 'desc');
            } else {
                // Default: Kelompokkan berdasarkan jenis informasi resmi UU No. 14 Tahun 2008, lalu urutkan rincian dan id
                $query->orderByRaw("
                    CASE 
                        WHEN jenis_informasi = 'Informasi Berkala' THEN 1
                        WHEN jenis_informasi = 'Informasi Setiap Saat' THEN 2
                        WHEN jenis_informasi = 'Informasi Serta-Merta' THEN 3
                        ELSE 4
                    END ASC
                ")->orderByRaw("
                    CASE 
                        WHEN rincian_informasi LIKE 'Profil unit%' OR rincian_informasi LIKE 'Profil Badan Publik%' THEN 1
                        WHEN rincian_informasi LIKE 'Program dan kegiatan%' THEN 2
                        WHEN rincian_informasi LIKE 'Ringkasan kinerja%' THEN 3
                        WHEN rincian_informasi LIKE 'Ringkasan laporan keuangan%' THEN 4
                        WHEN rincian_informasi LIKE 'Ringkasan laporan akses%' THEN 5
                        WHEN rincian_informasi LIKE 'Peraturan, keputusan%' THEN 6
                        WHEN rincian_informasi LIKE 'Prosedur memperoleh%' THEN 7
                        WHEN rincian_informasi LIKE 'Tata cara pengaduan%' THEN 8
                        WHEN rincian_informasi LIKE 'Pengadaan barang%' THEN 9
                        WHEN rincian_informasi LIKE 'Ketenagakerjaan%' THEN 10
                        WHEN rincian_informasi LIKE 'Prosedur peringatan dini%' THEN 11
                        ELSE 12
                    END ASC
                ")->orderBy('rincian_informasi', 'asc')->orderBy('id', 'asc');
            }
        }

        // Ambil seluruh data agar DataTables client-side berjalan instan 0 milidetik persis seperti Unpad
        $informasiList = $query->get();

        $years = $listTahun;
        $topiks = $listSatker;

        $topikCounts = InformasiPublik::select('pejabat_unit_yang_menguasai_informasi', \DB::raw('count(*) as count'))
            ->whereNotNull('pejabat_unit_yang_menguasai_informasi')
            ->where('pejabat_unit_yang_menguasai_informasi', '<>', '')
            ->groupBy('pejabat_unit_yang_menguasai_informasi')
            ->orderBy('count', 'desc')
            ->pluck('count', 'pejabat_unit_yang_menguasai_informasi')
            ->toArray();

        $totalCount = InformasiPublik::count();

        $kategoryCounts = [
            'Informasi Berkala'      => InformasiPublik::where('jenis_informasi', 'Informasi Berkala')->count(),
            'Informasi Serta-Merta'  => InformasiPublik::where('jenis_informasi', 'Informasi Serta-Merta')->count(),
            'Informasi Setiap Saat'  => InformasiPublik::where('jenis_informasi', 'Informasi Setiap Saat')->count(),
        ];

        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('components.masyarakat.informasi_publik.table', [
                'informasi' => $informasiList,
                'listJenis' => $listJenis,
                'listTahun' => $listTahun,
                'listSatker' => $listSatker,
                'listBentuk' => $listBentuk,
                'listRetensi' => $listRetensi,
            ])->render();
        }

        return view('masyarakat.informasi_publik.index', compact(
            'informasiList',
            'years',
            'topiks',
            'totalCount',
            'kategoryCounts',
            'topikCounts',
            'listJenis',
            'listTahun',
            'listSatker',
            'listBentuk',
            'listRetensi'
        ));
    }

    /**
     * Menampilkan Halaman Detail & Preview Informasi Publik (Layout 2 Kolom)
     */
    public function show($id)
    {
        $info = InformasiPublik::findOrFail($id);
        
        // Increment dilihat count
        if (\Illuminate\Support\Facades\Schema::hasColumn('informasi_publiks', 'dilihat')) {
            $info->increment('dilihat');
        }

        $relatedList = InformasiPublik::where('id', '<>', $id)
            ->where('jenis_informasi', $info->jenis_informasi)
            ->take(5)
            ->get();

        return view('masyarakat.informasi_publik.detail', compact('info', 'relatedList'));
    }

    /**
     * Menampilkan Halaman Khusus Kategori Informasi Publik (List Minimalis Modern)
     * Contoh: Informasi Berkala, Informasi Setiap Saat, Informasi Serta-Merta
     */
    public function kategori(Request $request, $slug)
    {
        $kategoriMap = [
            'berkala'     => 'Informasi Berkala',
            'setiap-saat' => 'Informasi Setiap Saat',
            'serta-merta' => 'Informasi Serta-Merta',
        ];

        if (!isset($kategoriMap[$slug])) {
            abort(404);
        }

        $namaKategori = $kategoriMap[$slug];

        $query = InformasiPublik::where('jenis_informasi', $namaKategori);

        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(COALESCE(sub_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(rincian_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(pejabat_unit_yang_menguasai_informasi, "")) LIKE ?', ["%{$term}%"]);
            });
        }

        if ($request->filled('tahun')) {
            $query->where('waktu_pembuatan_informasi', $request->tahun);
        }

        if ($slug === 'serta-merta') {
            $items = $query->orderBy('waktu_pembuatan_informasi', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->get();
        } elseif ($slug === 'berkala') {
            // Urutkan persis 11 poin standar website Monev PPID Unila / Perki 1/2021 (Profil Unit urutan pertama)
            $items = $query->orderByRaw("
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
            ")->orderBy('id', 'asc')->get();
        } else {
            // Kelompokkan per rincian informasi terlebih dahulu agar sub-informasi satu topik berkumpul dan rowspan rapi
            $items = $query->orderBy('rincian_informasi', 'asc')
                           ->orderBy('id', 'asc')
                           ->get();
        }

        $years = InformasiPublik::where('jenis_informasi', $namaKategori)
                    ->whereNotNull('waktu_pembuatan_informasi')
                    ->where('waktu_pembuatan_informasi', '!=', '')
                    ->distinct()
                    ->orderBy('waktu_pembuatan_informasi', 'desc')
                    ->pluck('waktu_pembuatan_informasi');

        return view('masyarakat.informasi_publik.kategori', compact('items', 'namaKategori', 'slug', 'years'));
    }

    /**
     * Menampilkan Halaman Daftar Informasi yang Dikecualikan (DIK) untuk Publik
     */
    public function dikecualikan(Request $request)
    {
        $query = \App\Models\InformasiDikecualikan::query();

        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(ringkasan_informasi) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(dasar_hukum) LIKE ?', ["%{$term}%"]);
            });
        }

        $items = $query->orderBy('created_at', 'desc')
                       ->get();

        return view('masyarakat.informasi_publik.dikecualikan', compact('items'));
    }
}
