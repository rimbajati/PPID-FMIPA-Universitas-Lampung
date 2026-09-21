<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Statistik Layanan PPID FMIPA - Tahun {{ $tahun }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            font-size: 11.5px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 2.5px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 4px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        .header h2 {
            font-size: 13px;
            font-weight: 700;
            margin: 0 0 4px 0;
            color: #0284c7;
        }
        .header p {
            font-size: 10px;
            color: #64748b;
            margin: 0;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 11px;
            color: #475569;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .summary-box {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
            background: #f8fafc;
        }
        .summary-box .num {
            font-size: 20px;
            font-weight: 800;
            color: #0284c7;
            display: block;
        }
        .summary-box .lbl {
            font-size: 10px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 7px 9px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #f1f5f9;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid;
        }
        .signature {
            text-align: center;
            width: 240px;
        }
        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #0f172a;
            font-weight: 700;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="position: fixed; top: 15px; right: 15px; z-index: 999; display: flex; gap: 8px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #0284c7; color: white; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
            🖨️ Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 8px 14px; background: #e2e8f0; color: #334155; border: none; border-radius: 6px; font-weight: 700; cursor: pointer; font-size: 12px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h1>LAPORAN REKAPITULASI STATISTIK LAYANAN INFORMASI PUBLIK</h1>
        <h2>PPID PELAKSANA FAKULTAS MIPA - UNIVERSITAS LAMPUNG</h2>
        <p>Jl. Prof. Dr. Ir. Sumantri Brojonegoro No. 1, Gedong Meneng, Bandar Lampung 35145 | ppid@fmipa.unila.ac.id</p>
    </div>

    <div class="meta-info">
        <div>
            <span>Periode Laporan: <strong>Tahun {{ $tahun }}</strong></span>
        </div>
        <div>
            <span>Tanggal Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB</strong></span>
        </div>
    </div>

    <!-- Ringkasan Kartu -->
    <div class="summary-grid">
        <div class="summary-box">
            <span class="num" style="color: #2563eb;">{{ $totMasuk }}</span>
            <span class="lbl">Permohonan Masuk</span>
        </div>
        <div class="summary-box">
            <span class="num" style="color: #059669;">{{ $totSelesai }}</span>
            <span class="lbl">Permohonan Selesai</span>
        </div>
        <div class="summary-box">
            <span class="num" style="color: #e11d48;">{{ $totTolak }}</span>
            <span class="lbl">Permohonan Ditolak</span>
        </div>
        <div class="summary-box">
            <span class="num" style="color: #d97706;">{{ $totKeberatan }}</span>
            <span class="lbl">Pengajuan Keberatan</span>
        </div>
    </div>

    <!-- Tabel Rekap Per Bulan -->
    <h3 style="font-size: 12px; font-weight: 800; margin-bottom: 8px; color: #0f172a; text-transform: uppercase;">
        Tabel Distribusi Layanan Informasi Per Bulan (Tahun {{ $tahun }})
    </h3>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 25%;">Bulan</th>
                <th style="width: 14%; text-align: center;">Permohonan</th>
                <th style="width: 14%; text-align: center;">Selesai</th>
                <th style="width: 14%; text-align: center;">Ditolak</th>
                <th style="width: 14%; text-align: center;">Diproses</th>
                <th style="width: 14%; text-align: center;">Keberatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $idx => $r)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="font-bold" style="color: #1e293b;">{{ $r['bulan'] }}</td>
                    <td class="text-center">{{ $r['masuk'] }}</td>
                    <td class="text-center font-bold" style="color: #059669;">{{ $r['selesai'] }}</td>
                    <td class="text-center font-bold" style="color: #e11d48;">{{ $r['tolak'] }}</td>
                    <td class="text-center">{{ $r['proses'] }}</td>
                    <td class="text-center font-bold" style="color: #d97706;">{{ $r['keberatan'] }}</td>
                </tr>
            @endforeach
            <tr style="background: #e2e8f0; font-weight: 800;">
                <td colspan="2" class="text-center">TOTAL TAHUN {{ $tahun }}</td>
                <td class="text-center">{{ $totMasuk }}</td>
                <td class="text-center" style="color: #059669;">{{ $totSelesai }}</td>
                <td class="text-center" style="color: #e11d48;">{{ $totTolak }}</td>
                <td class="text-center">{{ $totProses }}</td>
                <td class="text-center" style="color: #d97706;">{{ $totKeberatan }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <div>Bandar Lampung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
            <div style="font-weight: 700; margin-top: 4px;">Pejabat Pengelola Informasi & Dokumentasi (PPID)</div>
            <div style="font-size: 10px; color: #64748b;">FMIPA Universitas Lampung</div>
            <div class="signature-line"></div>
            <div style="margin-top: 4px; font-size: 9.5px; color: #64748b;">NIP. ...................................................</div>
        </div>
    </div>

</body>
</html>
