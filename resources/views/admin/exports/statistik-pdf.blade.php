<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Statistik Layanan PPID FMIPA - Tahun {{ $tahun }}</title>
    <style>
        @page {
            size: A4 portrait;
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
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 12mm 15mm;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            border-radius: 2px;
        }
        .doc-header-title {
            text-align: center;
            margin-bottom: 5mm;
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
        .doc-header-title .meta-line {
            font-size: 9.5pt;
            font-weight: 400;
            margin-top: 2mm;
            color: #000000;
        }
        /* Summary cards in formal style */
        .summary-grid {
            display: flex;
            gap: 4mm;
            margin-bottom: 5mm;
        }
        .summary-box {
            flex: 1;
            border: 0.35mm solid #000000;
            padding: 3mm;
            text-align: center;
        }
        .summary-box .num {
            font-size: 14pt;
            font-weight: 800;
            display: block;
            line-height: 1.2;
        }
        .summary-box .lbl {
            font-size: 7.5pt;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 1mm;
            display: block;
        }
        h3.table-title {
            font-size: 10pt;
            font-weight: 700;
            text-transform: uppercase;
            margin: 5mm 0 3mm;
            page-break-after: avoid;
        }
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
            font-size: 8.5pt;
            text-align: center;
            vertical-align: middle;
            padding: 2.5mm 1.5mm;
            text-transform: uppercase;
        }
        table.data-table td {
            color: #000000;
            font-size: 8.5pt;
            font-weight: 400;
            vertical-align: middle;
        }
        table.data-table tr.total-row td {
            font-weight: 700;
            font-size: 8.5pt;
        }
        .text-center { text-align: center !important; }
        .text-left { text-align: left !important; }
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
        .signature-space { height: 18mm; }
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
        [contenteditable="true"] {
            outline: none;
            padding: 1px 3px;
            border-radius: 2px;
            transition: background 0.15s ease;
        }
        [contenteditable="true"]:hover { background-color: #f1f5f9; cursor: text; }
        [contenteditable="true"]:focus { background-color: #e0f2fe; box-shadow: 0 0 0 1px #0284c7; }
        @media print {
            body { padding: 0; background: #ffffff !important; }
            .page-wrapper { width: 100% !important; min-height: auto !important; padding: 0 !important; margin: 0 !important; box-shadow: none !important; border-radius: 0 !important; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="position: fixed; top: 15px; right: 20px; z-index: 999; display: flex; gap: 8px;">
        <button onclick="window.print()" style="padding: 9px 18px; background: #0284c7; color: white; border: none; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 12px; box-shadow: 0 4px 12px rgba(2,132,199,0.3); display: flex; align-items: center; gap: 6px;">
            <span>🖨️</span> Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 9px 15px; background: #e2e8f0; color: #334155; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 12px;">
            Tutup
        </button>
    </div>

    <div class="page-wrapper">

        <div class="doc-header-title">
            <h1 contenteditable="true" title="Klik untuk mengedit">LAPORAN REKAPITULASI STATISTIK LAYANAN INFORMASI PUBLIK</h1>
            <h2 contenteditable="true" title="Klik untuk mengedit">PADA FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM UNIVERSITAS LAMPUNG</h2>
            <div class="meta-line">
                Periode: <strong>Tahun {{ $tahun }}</strong> &nbsp;|&nbsp;
                Tanggal Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB</strong>
            </div>
        </div>

        <!-- Ringkasan Kartu Formal -->
        <div class="summary-grid">
            <div class="summary-box" style="background: #f8fafc;">
                <span class="num">{{ $totMasuk }}</span>
                <span class="lbl">Permohonan Masuk</span>
            </div>
            <div class="summary-box" style="background: #f8fafc;">
                <span class="num">{{ $totSelesai }}</span>
                <span class="lbl">Permohonan Selesai</span>
            </div>
            <div class="summary-box" style="background: #f8fafc;">
                <span class="num">{{ $totTolak }}</span>
                <span class="lbl">Permohonan Ditolak</span>
            </div>
            <div class="summary-box" style="background: #f8fafc;">
                <span class="num">{{ $totKeberatan }}</span>
                <span class="lbl">Pengajuan Keberatan</span>
            </div>
        </div>

        <h3 class="table-title">Tabel Distribusi Layanan Informasi Per Bulan (Tahun {{ $tahun }})</h3>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 6%;">No</th>
                    <th style="width: 24%;">Bulan</th>
                    <th style="width: 14%;">Permohonan</th>
                    <th style="width: 14%;">Selesai</th>
                    <th style="width: 14%;">Ditolak</th>
                    <th style="width: 14%;">Diproses</th>
                    <th style="width: 14%;">Keberatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekap as $idx => $r)
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-center" style="font-weight: 700;">{{ $r['bulan'] }}</td>
                        <td class="text-center">{{ $r['masuk'] }}</td>
                        <td class="text-center" style="font-weight: 700;">{{ $r['selesai'] }}</td>
                        <td class="text-center" style="font-weight: 700;">{{ $r['tolak'] }}</td>
                        <td class="text-center">{{ $r['proses'] }}</td>
                        <td class="text-center" style="font-weight: 700;">{{ $r['keberatan'] }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="2" class="text-center">TOTAL TAHUN {{ $tahun }}</td>
                    <td class="text-center">{{ $totMasuk }}</td>
                    <td class="text-center">{{ $totSelesai }}</td>
                    <td class="text-center">{{ $totTolak }}</td>
                    <td class="text-center">{{ $totProses }}</td>
                    <td class="text-center">{{ $totKeberatan }}</td>
                </tr>
            </tbody>
        </table>

        <div class="signature-container">
            <div class="signature-box">
                <div contenteditable="true" title="Klik untuk edit tanggal">Bandar Lampung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div style="font-weight: 700; margin-top: 2px;" contenteditable="true" title="Klik untuk edit jabatan">
                    Pejabat Pengelola Informasi & Dokumentasi (PPID)
                </div>
                <div style="font-size: 9.5pt;" contenteditable="true">FMIPA Universitas Lampung</div>
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
