<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Permohonan Informasi Publik - PPID FMIPA Unila</title>
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
        table.data-table {
            width: 100%;
            border-collapse: collapse;
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
        .text-center { text-align: center !important; }
        
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
        <button onclick="window.print()" style="padding: 9px 18px; background: #0284c7; color: white; border: none; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 12px; box-shadow: 0 4px 12px rgba(2,132,199,0.3);">
            🖨️ Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 9px 15px; background: #e2e8f0; color: #334155; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 12px;">
            Tutup
        </button>
    </div>

    <div class="page-wrapper">

        <div class="doc-header-title">
            <h1>DAFTAR PERMOHONAN INFORMASI PUBLIK</h1>
            <h2>PADA FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM UNIVERSITAS LAMPUNG</h2>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 11%;">Tanggal Permohonan Informasi</th>
                    <th style="width: 13%;">Identitas Pemohon Informasi</th>
                    <th style="width: 9%;">Pekerjaan</th>
                    <th style="width: 20%;">Informasi Yang Diminta</th>
                    <th style="width: 15%;">Tujuan Permohonan Informasi</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%;">Waktu Penyelesaian</th>
                    <th style="width: 9%;">Durasi Penyelesaian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $idx => $item)
                    @php
                        $isSelesai = in_array(strtolower($item->status), ['selesai', 'ditolak']);
                        $durasi = '-';
                        if($isSelesai && $item->created_at && $item->updated_at) {
                            $diff = $item->created_at->startOfDay()->diffInDays($item->updated_at->startOfDay());
                            $durasi = $diff === 0 ? '< 1 hari kerja' : $diff . ' hari kerja';
                        }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="text-center">{{ $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-' }}</td>
                        <td style="font-weight: 600;">{{ $item->nama_lengkap }}</td>
                        <td class="text-center">{{ $item->pekerjaan ?: '-' }}</td>
                        <td>{{ $item->informasi_yang_diminta }}</td>
                        <td>{{ $item->tujuan_penggunaan_informasi ?: '-' }}</td>
                        <td class="text-center" style="font-weight: 700;">{{ $item->status }}</td>
                        <td class="text-center">{{ ($isSelesai && $item->updated_at) ? $item->updated_at->translatedFormat('d F Y') : '-' }}</td>
                        <td class="text-center">{{ $durasi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center" style="padding: 10mm 0;">Tidak ada data permohonan.</td>
                    </tr>
                @endforelse
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
