<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Statistik Layanan PPID FMIPA - Tahun {{ $tahun }}</title>
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
            font-family: Arial, Helvetica, sans-serif;
            color: #000000;
            margin: 0;
            padding: 15mm 0;
            font-size: 8.5pt;
            line-height: 1.2;
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
        .doc-header-title {
            text-align: center;
            margin-bottom: 8mm;
        }
        .doc-header-title h1 {
            font-size: 11pt;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0;
        }
        .doc-header-title h2 {
            font-size: 10.5pt;
            font-weight: 800;
            text-transform: uppercase;
            margin: 1mm 0 0 0;
        }
        .meta-line {
            font-size: 8.5pt;
            margin-top: 2mm;
            font-weight: bold;
        }
        .summary-grid {
            display: flex;
            gap: 4mm;
            margin-bottom: 5mm;
        }
        .summary-box {
            flex: 1;
            border: 0.2mm solid #000000;
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
            font-size: 9pt;
            font-weight: 700;
            text-transform: uppercase;
            margin: 5mm 0 3mm;
            page-break-after: avoid;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
            table-layout: fixed;
        }
        table.data-table th,
        table.data-table td {
            border: 0.2mm solid #000000;
            padding: 2.5mm 1.5mm;
            vertical-align: middle;
            word-wrap: break-word;
        }
        table.data-table th {
            background-color: transparent;
            font-weight: 800;
            text-align: center;
            font-size: 8pt;
        }
        table.data-table td {
            font-size: 8.5pt;
            font-weight: 400;
        }
        table.data-table tr.total-row td {
            font-weight: 700;
            background-color: #f8fafc;
        }
        .text-center { text-align: center !important; }
        .text-left { text-align: left !important; }
        .signature-container {
            margin-top: 10mm;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid;
        }
        .signature-box {
            text-align: left;
            width: 80mm;
            font-size: 9pt;
        }
        .signature-space { height: 18mm; }
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
            <h1>LAPORAN REKAPITULASI STATISTIK LAYANAN INFORMASI PUBLIK</h1>
            <h2>PADA FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM UNIVERSITAS LAMPUNG</h2>
            <div class="meta-line">
                Periode: <strong>Tahun {{ $tahun }}</strong> &nbsp;|&nbsp;
                Tanggal Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB</strong>
            </div>
        </div>

        <div class="summary-grid">
            <div class="summary-box">
                <span class="num">{{ $totMasuk }}</span>
                <span class="lbl">Permohonan Masuk</span>
            </div>
            <div class="summary-box">
                <span class="num">{{ $totSelesai }}</span>
                <span class="lbl">Permohonan Selesai</span>
            </div>
            <div class="summary-box">
                <span class="num">{{ $totTolak }}</span>
                <span class="lbl">Permohonan Ditolak</span>
            </div>
            <div class="summary-box">
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
                        <td class="text-center">{{ $r['bulan'] }}</td>
                        <td class="text-center">{{ $r['masuk'] }}</td>
                        <td class="text-center">{{ $r['selesai'] }}</td>
                        <td class="text-center">{{ $r['tolak'] }}</td>
                        <td class="text-center">{{ $r['proses'] }}</td>
                        <td class="text-center">{{ $r['keberatan'] }}</td>
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
                <div>Bandar Lampung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div style="font-weight: 700; margin-top: 1mm;">Petugas Pelayanan Informasi (PPID)</div>
                <div>FMIPA Universitas Lampung</div>
                <div class="signature-space"></div>
                <div>................................................................</div>
                <div style="margin-top: 1mm;">NIP. ................................................................</div>
            </div>
        </div>

    </div>

</body>
</html>
