<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    /**
     * 1. Export Daftar Informasi Publik (DIP) - Excel (CSV UTF-8 with BOM)
     */
    public function exportInformasiExcel(Request $request)
    {
        $query = InformasiPublik::query();

        if ($request->filled('kategori')) {
            $query->where('jenis_informasi', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $tahunParam = $request->tahun;
            if (is_array($tahunParam)) {
                $query->whereIn('waktu_pembuatan_informasi', $tahunParam);
            } else {
                $query->where('waktu_pembuatan_informasi', $tahunParam);
            }
        }

        if ($request->filled('satker')) {
            $query->where('pejabat_unit_yang_menguasai_informasi', $request->satker);
        }

        // Dokumen yang masih dilengkapi unit tidak dimasukkan ke dalam dokumen DIP resmi yang diekspor
        $query->where('sub_informasi', '!=', 'Dokumen sedang dilengkapi unit');

        // Filter search jika ada
        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(COALESCE(sub_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(rincian_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(pejabat_unit_yang_menguasai_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(penanggung_jawab_pembuatan_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(waktu_pembuatan_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(retensi_arsip, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(bentuk_informasi_yang_tersedia, "")) LIKE ?', ["%{$term}%"]);
            });
        }

        // Selalu gunakan urutan baku dokumen DIP resmi (Berkala -> Setiap Saat -> Serta-Merta)
        $query->orderByRaw("
            CASE 
                WHEN jenis_informasi = 'Informasi Berkala' THEN 1
                WHEN jenis_informasi = 'Informasi Setiap Saat' THEN 2
                WHEN jenis_informasi = 'Informasi Serta-Merta' THEN 3
                ELSE 4
            END ASC
        ")->orderByRaw("
            CASE 
                WHEN rincian_informasi LIKE 'Profil Unit%' OR rincian_informasi LIKE 'Profil unit%' OR rincian_informasi LIKE 'Profil Badan Publik%' THEN 1
                WHEN rincian_informasi LIKE 'Program dan Kegiatan%' OR rincian_informasi LIKE 'Program dan kegiatan%' THEN 2
                WHEN rincian_informasi LIKE 'Ringkasan Kinerja%' OR rincian_informasi LIKE 'Ringkasan kinerja%' THEN 3
                WHEN rincian_informasi LIKE 'Ringkasan Laporan Keuangan%' OR rincian_informasi LIKE 'Ringkasan laporan keuangan%' THEN 4
                WHEN rincian_informasi LIKE 'Ringkasan Laporan Akses%' OR rincian_informasi LIKE 'Ringkasan laporan akses%' THEN 5
                WHEN rincian_informasi LIKE 'Peraturan, Keputusan%' OR rincian_informasi LIKE 'Peraturan, keputusan%' THEN 6
                WHEN rincian_informasi LIKE 'Prosedur Memperoleh%' OR rincian_informasi LIKE 'Prosedur memperoleh%' THEN 7
                WHEN rincian_informasi LIKE 'Tata Cara Pengaduan%' OR rincian_informasi LIKE 'Tata cara pengaduan%' THEN 8
                WHEN rincian_informasi LIKE 'Pengadaan Barang%' OR rincian_informasi LIKE 'Pengadaan barang%' THEN 9
                WHEN rincian_informasi LIKE 'Ketenagakerjaan%' OR rincian_informasi LIKE 'Ketenagakerjaan%' THEN 10
                WHEN rincian_informasi LIKE 'Prosedur Peringatan Dini%' OR rincian_informasi LIKE 'Prosedur peringatan dini%' THEN 11
                ELSE 12
            END ASC
        ")->orderBy('id', 'asc');

        $items = $query->get();

        $filename = 'Daftar_Informasi_Publik_PPID_FMIPA_' . ($request->tahun ?: date('Y')) . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function() use ($items, $request) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Judul Dokumen Resmi
            fputcsv($file, ['DAFTAR INFORMASI PUBLIK (DIP)']);
            fputcsv($file, ['PPID PELAKSANA FAKULTAS MIPA - UNIVERSITAS LAMPUNG']);
            fputcsv($file, ['Tahun Penetapan / Periode: ' . ($request->tahun ?: date('Y'))]);
            fputcsv($file, ['Tanggal Ekspor: ' . date('d F Y H:i:s')]);
            fputcsv($file, []);

            // Header kolom standar DIP (sesuai format Unpad)
            fputcsv($file, [
                'No',
                'Ringkasan Isi Informasi',
                'Jenis Informasi',
                'Pejabat/Unit/Satker yang Menguasai Informasi',
                'Penanggung Jawab Pembuatan atau Penerbitan Informasi',
                'Waktu dan Tempat Pembuatan Informasi',
                'Bentuk Informasi yang Tersedia',
                'Jangka Waktu Penyimpanan atau Retensi Arsip',
                'Tautan / Akses Berkas'
            ]);

            // Kelompokkan berdasarkan rincian_informasi — struktur hierarki DIP Unpad
            $rincianGroups = $items->groupBy(function($item) {
                return $item->rincian_informasi ?: ($item->sub_informasi ?: '-');
            });

            $groupNo = 0;
            $no = 1;
            foreach ($rincianGroups as $namaRincian => $subItems) {
                $groupNo++;
                $first = $subItems->first();

                // Baris rincian — persis seperti DIP Unpad:
                // Nama rincian di kolom Ringkasan, data bersama dari item pertama
                fputcsv($file, [
                    $groupNo,
                    $namaRincian,
                    $first->jenis_informasi ?: '-',
                    $first->pejabat_unit_yang_menguasai_informasi ?: '-',
                    $first->penanggung_jawab_pembuatan_informasi ?: '-',
                    $first->waktu_pembuatan_informasi ?: '-',
                    $first->bentuk_informasi_yang_tersedia ?: '-',
                    $first->retensi_arsip ?: '-',
                    '-'
                ]);

                // Baris sub informasi di bawahnya (indented 4 spasi)
                foreach ($subItems as $item) {
                    $subText  = trim($item->sub_informasi ?: '');
                    $bentuk   = $item->bentuk_informasi_yang_tersedia ?: '-';
                    $link     = $item->file_informasi ? url('/informasi/lihat/' . $item->id) : ($item->link_informasi ?: '-');
                    $pejabat  = $item->pejabat_unit_yang_menguasai_informasi ?: '-';
                    $pj       = $item->penanggung_jawab_pembuatan_informasi ?: '-';
                    $waktu    = $item->waktu_pembuatan_informasi ?: '-';
                    $retensi  = $item->retensi_arsip ?: '-';

                    fputcsv($file, [
                        $no++,
                        '    ' . $subText,
                        $item->jenis_informasi ?: '-',
                        $pejabat,
                        $pj,
                        $waktu,
                        $bentuk,
                        $retensi,
                        $link
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 1. Export Daftar Informasi Publik (DIP) - Print / PDF
     */
    public function exportInformasiPdf(Request $request)
    {
        $query = InformasiPublik::query();

        $kategori = $request->kategori ?: null;

        if ($kategori) {
            $query->where('jenis_informasi', $kategori);
        }

        // Dukung filter tahun tunggal maupun beberapa tahun (rentang periode)
        if ($request->filled('tahun')) {
            $tahunParam = $request->tahun;
            if (is_array($tahunParam)) {
                $query->whereIn('waktu_pembuatan_informasi', $tahunParam);
            } else {
                $query->where('waktu_pembuatan_informasi', $tahunParam);
            }
        }

        // Filter satker jika ada
        if ($request->filled('satker')) {
            $query->where('pejabat_unit_yang_menguasai_informasi', $request->satker);
        }

        // Dokumen yang masih dilengkapi unit tidak dimasukkan ke dalam dokumen DIP resmi yang dicetak/diekspor
        $query->where('sub_informasi', '!=', 'Dokumen sedang dilengkapi unit');

        // Filter search jika ada
        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(COALESCE(sub_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(rincian_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(pejabat_unit_yang_menguasai_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(penanggung_jawab_pembuatan_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(waktu_pembuatan_informasi, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(retensi_arsip, "")) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(COALESCE(bentuk_informasi_yang_tersedia, "")) LIKE ?', ["%{$term}%"]);
            });
        }

        if ($kategori === 'Informasi Serta-Merta') {
            $items = $query->orderBy('waktu_pembuatan_informasi', 'desc')->latest()->get();
            $groupedItems = [$kategori => $items];
        } elseif ($kategori) {
            $items = $query->orderByRaw("
                CASE 
                    WHEN rincian_informasi LIKE 'Profil Unit%' OR rincian_informasi LIKE 'Profil unit%' OR rincian_informasi LIKE 'Profil Badan Publik%' THEN 1
                    WHEN rincian_informasi LIKE 'Program dan Kegiatan%' OR rincian_informasi LIKE 'Program dan kegiatan%' THEN 2
                    WHEN rincian_informasi LIKE 'Ringkasan Kinerja%' OR rincian_informasi LIKE 'Ringkasan kinerja%' THEN 3
                    WHEN rincian_informasi LIKE 'Ringkasan Laporan Keuangan%' OR rincian_informasi LIKE 'Ringkasan laporan keuangan%' THEN 4
                    WHEN rincian_informasi LIKE 'Ringkasan Laporan Akses%' OR rincian_informasi LIKE 'Ringkasan laporan akses%' THEN 5
                    WHEN rincian_informasi LIKE 'Peraturan, Keputusan%' OR rincian_informasi LIKE 'Peraturan, keputusan%' THEN 6
                    WHEN rincian_informasi LIKE 'Prosedur Memperoleh%' OR rincian_informasi LIKE 'Prosedur memperoleh%' THEN 7
                    WHEN rincian_informasi LIKE 'Tata Cara Pengaduan%' OR rincian_informasi LIKE 'Tata cara pengaduan%' THEN 8
                    WHEN rincian_informasi LIKE 'Pengadaan Barang%' OR rincian_informasi LIKE 'Pengadaan barang%' THEN 9
                    WHEN rincian_informasi LIKE 'Ketenagakerjaan%' OR rincian_informasi LIKE 'Ketenagakerjaan%' THEN 10
                    WHEN rincian_informasi LIKE 'Prosedur Peringatan Dini%' OR rincian_informasi LIKE 'Prosedur peringatan dini%' THEN 11
                    ELSE 12
                END ASC
            ")->orderBy('id', 'asc')->get();
            $groupedItems = [$kategori => $items];
        } else {
            // Seluruh DIP: Selalu urutkan kategori dan rincian informasi baku dokumen resmi
            $items = $query->orderByRaw("
                CASE 
                    WHEN jenis_informasi = 'Informasi Berkala' THEN 1
                    WHEN jenis_informasi = 'Informasi Setiap Saat' THEN 2
                    WHEN jenis_informasi = 'Informasi Serta-Merta' THEN 3
                    ELSE 4
                END ASC
            ")->orderByRaw("
                CASE 
                    WHEN rincian_informasi LIKE 'Profil Unit%' OR rincian_informasi LIKE 'Profil unit%' OR rincian_informasi LIKE 'Profil Badan Publik%' THEN 1
                    WHEN rincian_informasi LIKE 'Program dan Kegiatan%' OR rincian_informasi LIKE 'Program dan kegiatan%' THEN 2
                    WHEN rincian_informasi LIKE 'Ringkasan Kinerja%' OR rincian_informasi LIKE 'Ringkasan kinerja%' THEN 3
                    WHEN rincian_informasi LIKE 'Ringkasan Laporan Keuangan%' OR rincian_informasi LIKE 'Ringkasan laporan keuangan%' THEN 4
                    WHEN rincian_informasi LIKE 'Ringkasan Laporan Akses%' OR rincian_informasi LIKE 'Ringkasan laporan akses%' THEN 5
                    WHEN rincian_informasi LIKE 'Peraturan, Keputusan%' OR rincian_informasi LIKE 'Peraturan, keputusan%' THEN 6
                    WHEN rincian_informasi LIKE 'Prosedur Memperoleh%' OR rincian_informasi LIKE 'Prosedur memperoleh%' THEN 7
                    WHEN rincian_informasi LIKE 'Tata Cara Pengaduan%' OR rincian_informasi LIKE 'Tata cara pengaduan%' THEN 8
                    WHEN rincian_informasi LIKE 'Pengadaan Barang%' OR rincian_informasi LIKE 'Pengadaan barang%' THEN 9
                    WHEN rincian_informasi LIKE 'Ketenagakerjaan%' OR rincian_informasi LIKE 'Ketenagakerjaan%' THEN 10
                    WHEN rincian_informasi LIKE 'Prosedur Peringatan Dini%' OR rincian_informasi LIKE 'Prosedur peringatan dini%' THEN 11
                    ELSE 12
                END ASC
            ")->orderBy('id', 'asc')->get();

            $order = [
                'Informasi Berkala' => 1,
                'Informasi Setiap Saat' => 2,
                'Informasi Serta-Merta' => 3,
            ];

            $groupedItems = $items->groupBy(function($item) {
                return $item->jenis_informasi ?: 'Informasi Lainnya';
            })->sortBy(function($val, $key) use ($order) {
                return $order[$key] ?? 99;
            });
        }

        $tahunLabel = null;
        if ($request->filled('tahun')) {
            $tahunParam = (array) $request->tahun;
            // Urutkan tahun secara ascending (misal: 2024, 2026)
            sort($tahunParam, SORT_NUMERIC);
            
            if (count($tahunParam) === 1) {
                $tahunLabel = $tahunParam[0];
            } elseif (count($tahunParam) === 2) {
                // Jika 2 tahun berturutan atau rentang: contoh '2024 - 2025' atau '2024 & 2026'
                if ((int)$tahunParam[1] - (int)$tahunParam[0] === 1) {
                    $tahunLabel = $tahunParam[0] . ' - ' . $tahunParam[1];
                } else {
                    $tahunLabel = $tahunParam[0] . ' & ' . $tahunParam[1];
                }
            } else {
                $minY = min($tahunParam);
                $maxY = max($tahunParam);
                // Jika tahun berurutan penuh
                if ((int)$maxY - (int)$minY + 1 === count($tahunParam)) {
                    $tahunLabel = $minY . ' - ' . $maxY;
                } else {
                    $tahunLabel = implode(', ', $tahunParam);
                }
            }
        }

        return view('admin.exports.informasi-pdf', [
            'items'        => $items,
            'groupedItems' => $groupedItems,
            'total'        => $items->count(),
            'kategori'     => $kategori,
            'tahun'        => $tahunLabel,
            'satker'       => $request->satker ?: null,
        ]);
    }

    /**
     * 2. Export Rekapitulasi Statistik Layanan - Excel
     */
    public function exportStatistikExcel(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $filename = 'Rekap_Statistik_Layanan_PPID_FMIPA_' . $tahun . '_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function() use ($tahun, $months) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['REKAPITULASI STATISTIK LAYANAN INFORMASI PUBLIK']);
            fputcsv($file, ['PPID FMIPA UNIVERSITAS LAMPUNG - TAHUN ' . $tahun]);
            fputcsv($file, ['Tanggal Unduh: ' . date('d F Y H:i:s')]);
            fputcsv($file, []); // baris kosong

            fputcsv($file, [
                'Bulan',
                'Permohonan Masuk',
                'Permohonan Selesai',
                'Permohonan Ditolak',
                'Permohonan Diproses',
                'Pengajuan Keberatan',
                'Total Aktivitas Layanan'
            ]);

            $totMasuk = 0;
            $totSelesai = 0;
            $totTolak = 0;
            $totProses = 0;
            $totKeberatan = 0;

            foreach ($months as $num => $namaBulan) {
                $masuk = Permohonan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->count();
                $selesai = Permohonan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->where('status', 'selesai')->count();
                $tolak = Permohonan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->where('status', 'ditolak')->count();
                $proses = Permohonan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->whereIn('status', ['diajukan', 'diproses'])->count();
                $keberatan = Keberatan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->count();
                $totalAktivitas = $masuk + $keberatan;

                $totMasuk += $masuk;
                $totSelesai += $selesai;
                $totTolak += $tolak;
                $totProses += $proses;
                $totKeberatan += $keberatan;

                fputcsv($file, [
                    $namaBulan,
                    $masuk,
                    $selesai,
                    $tolak,
                    $proses,
                    $keberatan,
                    $totalAktivitas
                ]);
            }

            // Total Baris
            fputcsv($file, [
                'TOTAL ' . $tahun,
                $totMasuk,
                $totSelesai,
                $totTolak,
                $totProses,
                $totKeberatan,
                $totMasuk + $totKeberatan
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 2. Export Rekapitulasi Statistik Layanan - Print / PDF
     */
    public function exportStatistikPdf(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $rekap = [];
        $totMasuk = 0;
        $totSelesai = 0;
        $totTolak = 0;
        $totProses = 0;
        $totKeberatan = 0;

        foreach ($months as $num => $namaBulan) {
            $masuk = Permohonan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->count();
            $selesai = Permohonan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->where('status', 'selesai')->count();
            $tolak = Permohonan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->where('status', 'ditolak')->count();
            $proses = Permohonan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->whereIn('status', ['diajukan', 'diproses'])->count();
            $keberatan = Keberatan::whereYear('created_at', $tahun)->whereMonth('created_at', $num)->count();

            $totMasuk += $masuk;
            $totSelesai += $selesai;
            $totTolak += $tolak;
            $totProses += $proses;
            $totKeberatan += $keberatan;

            $rekap[] = [
                'bulan'     => $namaBulan,
                'masuk'     => $masuk,
                'selesai'   => $selesai,
                'tolak'     => $tolak,
                'proses'    => $proses,
                'keberatan' => $keberatan,
                'total'     => $masuk + $keberatan
            ];
        }

        // Statistik Kategori Pemohon & Klasifikasi
        $kategoriPemohon = [
            'Perorangan / Mahasiswa' => Permohonan::whereYear('created_at', $tahun)->where(fn($q) => $q->where('kategori_pemohon', 'like', '%perorangan%')->orWhere('kategori_pemohon', 'like', '%mahasiswa%'))->count(),
            'Kelompok Orang'         => Permohonan::whereYear('created_at', $tahun)->where('kategori_pemohon', 'like', '%kelompok%')->count(),
            'Badan Hukum / Lembaga'  => Permohonan::whereYear('created_at', $tahun)->where(fn($q) => $q->where('kategori_pemohon', 'like', '%badan hukum%')->orWhere('kategori_pemohon', 'like', '%lembaga%'))->count(),
        ];

        return view('admin.exports.statistik-pdf', [
            'tahun'           => $tahun,
            'rekap'           => $rekap,
            'totMasuk'        => $totMasuk,
            'totSelesai'      => $totSelesai,
            'totTolak'        => $totTolak,
            'totProses'       => $totProses,
            'totKeberatan'    => $totKeberatan,
            'kategoriPemohon' => $kategoriPemohon
        ]);
    }

    /**
     * 3. Export Permohonan Informasi - Excel
     */
    public function exportPermohonanExcel(Request $request)
    {
        $query = Permohonan::query();

        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('no_identitas', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('informasi_yang_diminta', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->get();

        $filename = 'Laporan_Permohonan_Informasi_PPID_FMIPA_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function() use ($items) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'No. Tiket',
                'Tanggal Masuk',
                'Nama Pemohon',
                'Kategori Pemohon',
                'No. Identitas (NIK/KTM)',
                'Email',
                'No. Telepon/WA',
                'Rincian Informasi Yang Diminta',
                'Tujuan Penggunaan',
                'Cara Memperoleh',
                'Status Permohonan',
                'Catatan / Alasan Penolakan'
            ]);

            $no = 1;
            foreach ($items as $item) {
                $catatan = $item->status === 'Ditolak' 
                    ? ($item->alasan_ditolak ?: '-') 
                    : ($item->catatan_selesai ?: ($item->catatan_diproses ?: '-'));

                fputcsv($file, [
                    $no++,
                    $item->no_tiket,
                    $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-',
                    $item->nama_lengkap,
                    $item->kategori_pemohon ?: '-',
                    $item->no_identitas ? "'" . $item->no_identitas : '-',
                    $item->email,
                    $item->no_telepon ? "'" . $item->no_telepon : '-',
                    $item->informasi_yang_diminta,
                    $item->tujuan_penggunaan_informasi ?: '-',
                    $item->cara_memperoleh_informasi ?: '-',
                    strtoupper($item->status),
                    $catatan
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 3. Export Permohonan Informasi - Print / PDF
     */
    public function exportPermohonanPdf(Request $request)
    {
        $query = Permohonan::query();

        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('no_identitas', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('informasi_yang_diminta', 'like', "%{$search}%");
            });
        }

        $items = $query->latest()->get();

        return view('admin.exports.permohonan-pdf', [
            'items'  => $items,
            'status' => $request->status
        ]);
    }

    /**
     * 4. Export Keberatan Informasi - Excel
     */
    public function exportKeberatanExcel(Request $request)
    {
        $query = Keberatan::with(['user', 'permohonan'])->latest();

        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'LIKE', "%{$search}%")
                  ->orWhere('alasan_keberatan', 'LIKE', "%{$search}%")
                  ->orWhereHas('permohonan', function ($pq) use ($search) {
                      $pq->where('nama_lengkap', 'LIKE', "%{$search}%")
                         ->orWhere('no_identitas', 'LIKE', "%{$search}%")
                         ->orWhere('no_tiket', 'LIKE', "%{$search}%");
                  });
            });
        }

        $items = $query->get();

        $filename = 'Laporan_Keberatan_Informasi_PPID_FMIPA_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function() use ($items) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'No. Tiket Keberatan',
                'Tanggal Pengajuan',
                'No. Tiket Permohonan Terkait',
                'Nama Pemohon',
                'Alasan Pengajuan Keberatan',
                'Kronologi / Keterangan',
                'Status Keberatan',
                'Catatan Tindak Lanjut'
            ]);

            $no = 1;
            foreach ($items as $item) {
                $catatan = $item->status === 'Ditolak' 
                    ? ($item->alasan_ditolak ?: '-') 
                    : ($item->catatan_selesai ?: ($item->catatan_diproses ?: '-'));

                fputcsv($file, [
                    $no++,
                    $item->no_tiket,
                    $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-',
                    $item->permohonan ? $item->permohonan->no_tiket : '-',
                    $item->permohonan ? $item->permohonan->nama_lengkap : ($item->user->name ?? '-'),
                    $item->alasan_keberatan ?: '-',
                    $item->kronologi_keberatan ?: '-',
                    strtoupper($item->status),
                    $catatan
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 4. Export Keberatan Informasi - Print / PDF
     */
    public function exportKeberatanPdf(Request $request)
    {
        $query = Keberatan::with(['user', 'permohonan'])->latest();

        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'LIKE', "%{$search}%")
                  ->orWhere('alasan_keberatan', 'LIKE', "%{$search}%")
                  ->orWhereHas('permohonan', function ($pq) use ($search) {
                      $pq->where('nama_lengkap', 'LIKE', "%{$search}%")
                         ->orWhere('no_identitas', 'LIKE', "%{$search}%")
                         ->orWhere('no_tiket', 'LIKE', "%{$search}%");
                  });
            });
        }

        $items = $query->get();

        return view('admin.exports.keberatan-pdf', [
            'items'  => $items,
            'status' => $request->status
        ]);
    }
}
