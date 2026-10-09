<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use App\Models\InformasiDikecualikan;
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
            $query->where('kategori_informasi', $request->kategori);
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
                WHEN kategori_informasi = 'Informasi Berkala' THEN 1
                WHEN kategori_informasi = 'Informasi Setiap Saat' THEN 2
                WHEN kategori_informasi = 'Informasi Serta-Merta' THEN 3
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

        $groupedItems = $items->groupBy('kategori_informasi');
        $categorySections = [
            'Informasi Berkala' => 'Informasi Publik yang Wajib Disediakan secara Berkala',
            'Informasi Setiap Saat' => 'Informasi Publik yang Wajib Tersedia Setiap Saat',
            'Informasi Serta-Merta' => 'Informasi Publik yang Wajib Diumumkan secara Serta-Merta',
        ];
        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        $rows = [];
        $merges = [];
        $rowNumber = 1;
        $addRow = function (array $cells, int $height = 30) use (&$rows, &$rowNumber) {
            $rows[] = ['number' => $rowNumber++, 'height' => $height, 'cells' => $cells];
        };

        $addRow([['DAFTAR INFORMASI PUBLIK (DIP)', 1]], 30);
        $merges[] = 'A1:H1';
        $addRow([['PPID PELAKSANA FAKULTAS MIPA - UNIVERSITAS LAMPUNG', 2]], 24);
        $merges[] = 'A2:H2';
        $addRow([['Tahun Penetapan / Periode: ' . ($request->tahun ?: date('Y')), 2]], 22);
        $merges[] = 'A3:H3';
        $addRow([['Tanggal Ekspor: ' . date('d F Y H:i:s'), 2]], 22);
        $merges[] = 'A4:H4';
        $addRow([], 12);

        $categoryNumber = 0;
        foreach ($categorySections as $jenis => $judul) {
            $categoryItems = $groupedItems->get($jenis, collect());
            if ($categoryItems->isEmpty()) {
                continue;
            }

            $categoryNumber++;
            $addRow([[chr(64 + $categoryNumber) . '. ' . $judul, 3]], 25);
            $merges[] = 'A' . ($rowNumber - 1) . ':H' . ($rowNumber - 1);
            $addRow(array_map(fn ($value) => [$value, 4], [
                'No',
                'Ringkasan Isi Informasi',
                'Pejabat/Unit/Satker yang Menguasai Informasi',
                'Penanggung Jawab Pembuatan atau Penerbitan Informasi',
                'Waktu dan Tempat Pembuatan Informasi',
                'Cetak',
                'Online',
                'Jangka Waktu Penyimpanan atau Retensi Arsip',
            ]), 42);

            foreach ($categoryItems as $index => $item) {
                $bentuk = strtolower(trim($item->bentuk_informasi_yang_tersedia ?? ''));
                $cetak = str_contains($bentuk, 'cetak') || str_contains($bentuk, 'hardcopy');
                $online = str_contains($bentuk, 'online') || str_contains($bentuk, 'softcopy')
                    || !empty($item->file_informasi) || !empty($item->link_informasi);

                $addRow([
                    [$index + 1, 5],
                    [trim($item->sub_informasi ?: ''), 5],
                    [$item->pejabat_unit_yang_menguasai_informasi ?: '-', 5],
                    [$item->penanggung_jawab_pembuatan_informasi ?: '-', 5],
                    [$item->waktu_pembuatan_informasi ?: '-', 5],
                    [$cetak ? '✓' : '', 6],
                    [$online ? '✓' : '', 6],
                    [$item->retensi_arsip ?: '-', 5],
                ], 0);
            }
            $addRow([], 12);
        }

        $escape = static fn ($value) => htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $sheetRows = '';
        foreach ($rows as $row) {
            $heightAttributes = $row['height'] > 0
                ? ' ht="' . $row['height'] . '" customHeight="1"'
                : '';
            $sheetRows .= '<row r="' . $row['number'] . '"' . $heightAttributes . '>';
            foreach ($row['cells'] as $columnIndex => [$value, $style]) {
                $reference = $columns[$columnIndex] . $row['number'];
                if (is_int($value) || is_float($value)) {
                    $sheetRows .= '<c r="' . $reference . '" s="' . $style . '"><v>' . $value . '</v></c>';
                } else {
                    $sheetRows .= '<c r="' . $reference . '" s="' . $style . '" t="inlineStr"><is><t xml:space="preserve">' . $escape($value) . '</t></is></c>';
                }
            }
            $sheetRows .= '</row>';
        }

        $mergeXml = '<mergeCells count="' . count($merges) . '">';
        foreach ($merges as $merge) {
            $mergeXml .= '<mergeCell ref="' . $merge . '"/>';
        }
        $mergeXml .= '</mergeCells>';

        $sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<cols><col min="1" max="1" width="7" customWidth="1"/><col min="2" max="2" width="38" customWidth="1"/><col min="3" max="4" width="34" customWidth="1"/><col min="5" max="5" width="27" customWidth="1"/><col min="6" max="7" width="12" customWidth="1"/><col min="8" max="8" width="36" customWidth="1"/></cols>'
            . '<sheetData>' . $sheetRows . '</sheetData>' . $mergeXml . '<pageMargins left="0.25" right="0.25" top="0.5" bottom="0.5" header="0.2" footer="0.2"/>'
            . '</worksheet>';
        $stylesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="3"><font><sz val="11"/><name val="Arial"/></font><font><b/><sz val="16"/><name val="Arial"/></font><font><b/><sz val="11"/><name val="Arial"/></font></fonts>'
            . '<fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF0EA5E9"/><bgColor indexed="64"/></patternFill></fill></fills>'
            . '<borders count="2"><border><left/><right/><top/><bottom/><diagonal/></border><border><left style="thin"><color rgb="FFD1D5DB"/></left><right style="thin"><color rgb="FFD1D5DB"/></right><top style="thin"><color rgb="FFD1D5DB"/></top><bottom style="thin"><color rgb="FFD1D5DB"/></bottom><diagonal/></border></borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            . '<cellXfs count="7"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/><xf numFmtId="0" fontId="1" fillId="0" borderId="0" xfId="0"/><xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1"/><xf numFmtId="0" fontId="2" fillId="0" borderId="0" xfId="0" applyFont="1"/><xf numFmtId="0" fontId="2" fillId="2" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center" wrapText="1"/></xf><xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment vertical="center" wrapText="1"/></xf><xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf></cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>';

        $tempBase = tempnam(sys_get_temp_dir(), 'dip-');
        $tempFile = $tempBase . '.xlsx';
        @unlink($tempBase);
        $archive = new \ZipArchive();
        if ($archive->open($tempFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'File spreadsheet gagal dibuat. Silakan coba kembali.');
        }
        $archive->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/></Types>');
        $archive->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
        $archive->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Daftar Informasi" sheetId="1" r:id="rId1"/></sheets></workbook>');
        $archive->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
        $archive->addFromString('xl/worksheets/sheet1.xml', $sheetXml);
        $archive->addFromString('xl/styles.xml', $stylesXml);
        $archive->close();

        $filename = 'Daftar_Informasi_Publik_PPID_FMIPA_' . ($request->tahun ?: date('Y')) . '_' . date('Ymd_His') . '.xlsx';

        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    /**
     * 1. Export Daftar Informasi Publik (DIP) - Print / PDF
     */
    public function exportInformasiPdf(Request $request)
    {
        $query = InformasiPublik::query();

        $kategori = $request->kategori ?: null;

        if ($kategori) {
            $query->where('kategori_informasi', $kategori);
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
                    WHEN kategori_informasi = 'Informasi Berkala' THEN 1
                    WHEN kategori_informasi = 'Informasi Setiap Saat' THEN 2
                    WHEN kategori_informasi = 'Informasi Serta-Merta' THEN 3
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
                return $item->kategori_informasi ?: 'Informasi Lainnya';
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

    /** Export Daftar Informasi yang Dikecualikan - PDF */
    public function exportInformasiDikecualikanPdf()
    {
        $items = InformasiDikecualikan::latest()->get();

        return view('admin.exports.informasi-dikecualikan-pdf', [
            'items' => $items,
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

        return view('admin.exports.statistik-pdf', [
            'tahun'           => $tahun,
            'rekap'           => $rekap,
            'totMasuk'        => $totMasuk,
            'totSelesai'      => $totSelesai,
            'totTolak'        => $totTolak,
            'totProses'       => $totProses,
            'totKeberatan'    => $totKeberatan,
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
                'No. Identitas (NIK/KTM)',
                'Email',
                'No. Telepon/WA',
                'Alamat Lengkap',
                'Pekerjaan',
                'Rincian Informasi Yang Diminta',
                'Tujuan Penggunaan',
                'Jenis Permohonan',
                'Cara Menerima Informasi',
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
                    $item->no_identitas ? "'" . $item->no_identitas : '-',
                    $item->email,
                    $item->no_telepon ? "'" . $item->no_telepon : '-',
                    $item->alamat_lengkap ?: '-',
                    $item->pekerjaan ?: '-',
                    $item->informasi_yang_diminta,
                    $item->tujuan_penggunaan_informasi ?: '-',
                    $item->jenis_permohonan ?: '-',
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
