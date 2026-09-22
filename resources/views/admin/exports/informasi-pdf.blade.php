<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategori ? 'Daftar ' . $kategori : 'Daftar Informasi Publik (DIP)' }} - PPID FMIPA Unila</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 12mm;
        }
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            color: #000000;
            margin: 0;
            padding: 15mm 0;
            font-size: 9.5pt;
            line-height: 1.3;
            background: #e2e8f0;
        }
        .page-wrapper {
            width: 297mm;
            min-height: 210mm;
            margin: 0 auto;
            padding: 12mm 15mm;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            border-radius: 2px;
        }

        /* Header Judul Dokumen (Sesuai Contoh: DAFTAR INFORMASI PUBLIK PADA ...) */
        .doc-header-title {
            text-align: center;
            margin-bottom: 6mm;
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
        }
        .doc-header-title h1 {
            font-size: 11.5pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.3pt;
            margin: 0;
            line-height: 1.4;
        }
        .doc-header-title h2 {
            font-size: 11pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.2pt;
            margin: 1mm 0 0 0;
            line-height: 1.35;
        }

        /* Tabel Standar DIP Formal (Persis Layout Gambar Pengguna) */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
            font-family: 'Times New Roman', Times, serif;
            table-layout: fixed;
        }
        table.data-table th, 
        table.data-table td {
            border: 0.35mm solid #000000;
            padding: 2mm 2.5mm;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.3;
        }
        table.data-table th {
            background-color: transparent;
            color: #000000;
            font-weight: 700;
            font-size: 9.5pt;
            text-align: center;
            vertical-align: middle;
            padding: 2.5mm 1.5mm;
        }
        table.data-table td {
            color: #000000;
            font-size: 9pt;
            font-weight: 400;
            vertical-align: middle;
        }
        .category-header-cell {
            font-size: 9.5pt;
            font-weight: 700;
            text-align: left;
            padding: 2.2mm 2.5mm;
            background-color: transparent;
        }

        .text-center { text-align: center !important; }
        .text-left { text-align: left !important; }
        .italic-text { font-style: italic; }

        /* Tanda Tangan */
        .signature-container {
            margin-top: 6mm;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid;
            font-family: 'Times New Roman', Times, serif;
        }
        .signature-box {
            text-align: left;
            width: 85mm;
            font-size: 10pt;
            line-height: 1.35;
            color: #000000;
        }
        .signature-space {
            height: 18mm;
        }
        .signature-name {
            font-weight: normal;
            font-size: 10pt;
            color: #000000;
        }
        .signature-nip {
            margin-top: 1mm;
            font-size: 10pt;
            color: #000000;
        }

        /* Inline editing support */
        [contenteditable="true"] {
            outline: none;
            padding: 1px 3px;
            border-radius: 2px;
            transition: background 0.15s ease;
        }
        [contenteditable="true"]:hover {
            background-color: #f1f5f9;
            cursor: text;
        }
        [contenteditable="true"]:focus {
            background-color: #e0f2fe;
            box-shadow: 0 0 0 1px #0284c7;
        }

        @media print {
            body { 
                padding: 0; 
                background: #ffffff !important;
            }
            .page-wrapper {
                width: 100% !important;
                min-height: auto !important;
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .no-print { 
                display: none !important; 
            }
        }
    </style>
</head>
<body>

    <!-- Floating Action Buttons -->
    <div class="no-print" style="position: fixed; top: 15px; right: 20px; z-index: 999; display: flex; gap: 8px;">
        <button onclick="window.print()" style="padding: 9px 18px; background: #0284c7; color: white; border: none; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 12px; box-shadow: 0 4px 12px rgba(2,132,199,0.3); display: flex; items-center; gap: 6px;">
            <span>🖨️</span> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 9px 15px; background: #e2e8f0; color: #334155; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 12px;">
            Tutup
        </button>
    </div>

    <div class="page-wrapper">
        @php
            $currentYear = $tahun ?: date('Y');
        @endphp

        <!-- Judul Dokumen Resmi (Format Gambar: DAFTAR INFORMASI PUBLIK PADA ...) -->
        <div class="doc-header-title">
            <h1 contenteditable="true" title="Klik untuk mengedit">DAFTAR INFORMASI PUBLIK</h1>
            <h2 contenteditable="true" title="Klik untuk mengedit">PADA FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM UNIVERSITAS LAMPUNG</h2>
            @if($tahun)
                <div style="font-size: 10pt; font-weight: 700; margin-top: 1mm;">TAHUN {{ $tahun }}</div>
            @endif
        </div>

        @php
            $globalNo = 1;
        @endphp

        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 3.5%;">No</th>
                    <th rowspan="2" style="width: 28.5%;">Ringkasan Isi Informasi</th>
                    <th rowspan="2" style="width: 16%;">Pejabat/Unit/Satker yang Menguasai Informasi</th>
                    <th rowspan="2" style="width: 16%;">Penanggungjawab Pembuatan atau Penerbitan Informasi</th>
                    <th rowspan="2" style="width: 13%;">Waktu dan Tempat Pembuatan Informasi</th>
                    <th colspan="2" style="width: 12%;">Bentuk Informasi yang Tersedia</th>
                    <th rowspan="2" style="width: 11%;">Jangka Waktu Penyimpanan atau Retensi Arsip</th>
                </tr>
                <tr>
                    <th style="width: 6%; white-space: nowrap; padding: 2mm 1mm;">Cetak</th>
                    <th style="width: 6%; white-space: nowrap; padding: 2mm 1mm;">Online</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedItems as $namaKelompok => $daftarItem)
                    @php
                        $judulKelompok = match($namaKelompok) {
                            'Informasi Berkala'     => 'Informasi yang Wajib Disediakan dan Diumumkan Secara Berkala',
                            'Informasi Setiap Saat' => 'Informasi yang Wajib Disediakan Setiap Saat',
                            'Informasi Serta-Merta' => 'Informasi yang Wajib Diumumkan Secara Serta-Merta',
                            default                 => 'Informasi ' . $namaKelompok,
                        };
                    @endphp

                    <!-- Baris Header Kategori (Spanning Kolom 1 s/d 8) -->
                    <tr>
                        <td colspan="8" class="category-header-cell">
                            <strong>{{ $judulKelompok }}</strong>
                        </td>
                    </tr>

                    {{-- MODE DEFAULT DIP RESMI: Menggunakan standard HTML rowspan yang presisi dan rapi --}}
                    @php
                        $rincianGroups = $daftarItem->groupBy(function($item) {
                            return $item->rincian_informasi ?: $item->sub_informasi;
                        });
                    @endphp

                        @php $rincianGroupNo = 0; @endphp
                        @foreach($rincianGroups as $namaRincian => $subItems)
                            @php
                                $rincianGroupNo++;
                                $subCount = $subItems->count();
                            @endphp

                            {{-- Baris Rincian Informasi --}}
                            {{-- No: rowspan = 1 (baris rincian ini) + subCount (baris sub di bawahnya) --}}
                            {{-- Nama rincian: colspan 7 (span semua kolom selain No), tanpa data --}}
                            <tr style="background-color: #ffffff;">
                                <td rowspan="{{ $subCount + 1 }}" class="text-center"
                                    style="vertical-align: middle; font-weight: bold; border-right: 1px solid #000000;">
                                    {{ $rincianGroupNo }}
                                </td>
                                <td colspan="7" style="vertical-align: middle; padding: 2mm 3mm; font-weight: bold;">
                                    {{ $namaRincian }}
                                </td>
                            </tr>

                            {{-- Baris Sub Informasi (No tidak ada, sudah di-rowspan dari baris rincian) --}}
                            @foreach($subItems as $sub)
                                @php
                                    $subText    = trim($sub->sub_informasi ?: '');
                                    $subBentuk  = strtolower(trim($sub->bentuk_informasi_yang_tersedia ?? ''));
                                    $subCetak   = str_contains($subBentuk, 'cetak') || str_contains($subBentuk, 'hardcopy');
                                    $subOnline  = str_contains($subBentuk, 'online') || str_contains($subBentuk, 'softcopy')
                                                  || !empty($sub->file_informasi) || !empty($sub->link_informasi);
                                    $subPejabat = $sub->pejabat_unit_yang_menguasai_informasi ?: '-';
                                    $subPJ      = $sub->penanggung_jawab_pembuatan_informasi ?: '-';
                                    $subWaktu   = $sub->waktu_pembuatan_informasi ?: '-';
                                    $subRetensi = $sub->retensi_arsip ?: '-';
                                @endphp
                                <tr>
                                    {{-- Col 2: Sub name (sedikit indent) --}}
                                    <td style="vertical-align: middle; padding: 2mm 3mm 2mm 5mm;">
                                        {{ $subText }}
                                    </td>
                                    {{-- Col 3-8: Data milik sub ini --}}
                                    <td class="text-center" style="vertical-align: middle;">{{ $subPejabat }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $subPJ }}</td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $subWaktu }}</td>
                                    <td class="text-center" style="vertical-align: middle; font-size: 11pt;">
                                        @if($subCetak) ✔ @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle; font-size: 11pt;">
                                        @if($subOnline) ✔ @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">{{ $subRetensi }}</td>
                                </tr>
                            @endforeach
                        @endforeach


                @endforeach
            </tbody>
        </table>

        <!-- Tanda Tangan Pengesahan Pejabat PPID Pelaksana / Dekan -->
        <div class="signature-container">
            <div class="signature-box">
                <div contenteditable="true" title="Klik untuk edit tanggal">Bandar Lampung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div style="font-weight: 700; margin-top: 2px;" contenteditable="true" title="Klik untuk edit jabatan">
                    PPID Pelaksana FMIPA Universitas Lampung
                </div>
                <div class="signature-space"></div>
                <div class="signature-name" contenteditable="true" title="Klik untuk edit nama">
                    ................................................................
                </div>
                <div class="signature-nip" contenteditable="true" title="Klik untuk edit NIP">
                    NIP. ................................................................
                </div>
            </div>
        </div>
    </div>

</body>
</html>

