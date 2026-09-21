<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Register Pengajuan Keberatan Informasi - PPID FMIPA Unila</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.2cm;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 15px;
            font-size: 10px;
            line-height: 1.35;
        }
        .header {
            text-align: center;
            border-bottom: 2.5px solid #0f172a;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header h1 {
            font-size: 15px;
            font-weight: 800;
            margin: 0 0 3px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        .header h2 {
            font-size: 12px;
            font-weight: 700;
            margin: 0 0 3px 0;
            color: #d97706;
        }
        .header p {
            font-size: 9.5px;
            color: #64748b;
            margin: 0;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 9.5px;
            color: #475569;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 7px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f1f5f9;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8.5px;
            font-weight: 700;
        }
        .badge-selesai { background: #dcfce7; color: #15803d; }
        .badge-tolak { background: #ffe4e6; color: #be123c; }
        .badge-proses { background: #fef3c7; color: #b45309; }
        .badge-diajukan { background: #e0f2fe; color: #0369a1; }
        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid;
        }
        .signature {
            text-align: center;
            width: 220px;
        }
        .signature-line {
            margin-top: 50px;
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
        <h1>BUKU REGISTER PENGAJUAN KEBERATAN INFORMASI PUBLIK</h1>
        <h2>PPID PELAKSANA FAKULTAS MIPA - UNIVERSITAS LAMPUNG</h2>
        <p>Jl. Prof. Dr. Ir. Sumantri Brojonegoro No. 1, Gedong Meneng, Bandar Lampung 35145 | ppid@fmipa.unila.ac.id</p>
    </div>

    <div class="meta-info">
        <div>
            <span>Status: <strong>{{ $status ?: 'Semua Status' }}</strong></span> | 
            <span>Total: <strong>{{ count($items) }} data</strong></span>
        </div>
        <div>
            <span>Tanggal Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB</strong></span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%; text-align: center;">No</th>
                <th style="width: 11%;">No. Tiket Keberatan</th>
                <th style="width: 8%;">Tanggal</th>
                <th style="width: 11%;">Tiket Permohonan</th>
                <th style="width: 14%;">Nama Pemohon</th>
                <th style="width: 20%;">Alasan Keberatan</th>
                <th style="width: 19%;">Kronologi</th>
                <th style="width: 8%; text-align: center;">Status</th>
                <th style="width: 6%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $idx => $item)
                @php
                    $badgeClass = match(strtolower($item->status)) {
                        'selesai' => 'badge-selesai',
                        'ditolak' => 'badge-tolak',
                        'diproses' => 'badge-proses',
                        default => 'badge-diajukan',
                    };
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td style="font-weight: 700; color: #d97706;">{{ $item->no_tiket }}</td>
                    <td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
                    <td style="color: #0284c7; font-weight: 600;">{{ $item->permohonan ? $item->permohonan->no_tiket : '-' }}</td>
                    <td style="font-weight: 600;">{{ $item->permohonan ? $item->permohonan->nama_lengkap : ($item->user->name ?? '-') }}</td>
                    <td>{{ $item->alasan_keberatan ?: '-' }}</td>
                    <td>{{ $item->kronologi_keberatan ?: '-' }}</td>
                    <td style="text-align: center;">
                        <span class="badge {{ $badgeClass }}">{{ strtoupper($item->status) }}</span>
                    </td>
                    <td style="font-size: 8.5px;">
                        {{ $item->status === 'Ditolak' ? ($item->alasan_ditolak ?: '-') : ($item->catatan_selesai ?: '-') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 20px; color: #94a3b8;">
                        Tidak ada data pengajuan keberatan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <div>Bandar Lampung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
            <div style="font-weight: 700; margin-top: 4px;">Atasan PPID Pelaksana</div>
            <div style="font-size: 10px; color: #64748b;">FMIPA Universitas Lampung</div>
            <div class="signature-line"></div>
            <div style="margin-top: 4px; font-size: 9.5px; color: #64748b;">NIP. ...................................................</div>
        </div>
    </div>

</body>
</html>
