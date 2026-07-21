<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Berhasil Terkirim - PPID FMIPA Unila</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #f1f5f9;
            padding: 32px 16px;
            box-sizing: border-box;
        }
        .main-card {
            max-width: 580px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
        }
        .header {
            background-color: #1B365D;
            padding: 28px 32px;
            color: #ffffff;
        }
        .brand-title {
            font-size: 18px;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.3px;
            color: #ffffff;
        }
        .brand-sub {
            font-size: 11px;
            color: #93c5fd;
            margin: 3px 0 0 0;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .content {
            padding: 32px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .message-text {
            font-size: 14px;
            color: #475569;
            margin-bottom: 20px;
        }
        .ticket-box {
            text-align: center;
            background-color: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .ticket-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .ticket-number {
            font-size: 18px;
            font-weight: 800;
            color: #1B365D;
            letter-spacing: 0.5px;
        }
        .section-title {
            font-size: 12px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 24px;
            margin-bottom: 10px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            background-color: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .details-table td {
            padding: 11px 16px;
            font-size: 13px;
            border-bottom: 1px solid #f1f5f9;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .label-col {
            width: 36%;
            color: #64748b;
            font-weight: 600;
        }
        .value-col {
            color: #0f172a;
            font-weight: 600;
        }
        .btn-wrapper {
            text-align: center;
            margin-top: 28px;
            margin-bottom: 8px;
        }
        .btn-primary {
            display: inline-block;
            background-color: #1B365D;
            color: #ffffff !important;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13.5px;
            text-decoration: none;
        }
        .footer {
            padding: 24px 32px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="main-card">
        <div class="header">
            <h1 class="brand-title">PPID FMIPA UNILA</h1>
            <p class="brand-sub">Pejabat Pengelola Informasi & Dokumentasi</p>
        </div>

        <div class="content">
            <div class="greeting">Halo, {{ $pengajuan->nama }}</div>
            
            <p class="message-text">
                Pengajuan layanan informasi Anda telah berhasil kami terima. Petugas PPID FMIPA Unila akan segera meninjau dan menindaklanjuti berkas Anda.
            </p>

            <div class="ticket-box">
                <div class="ticket-label">Nomor Tiket Anda</div>
                <div class="ticket-number">{{ $pengajuan->no_tiket }}</div>
            </div>

            <div class="section-title">Ringkasan Pengajuan</div>
            <table class="details-table">
                <tr>
                    <td class="label-col">Jenis Layanan</td>
                    <td class="value-col">{{ $pengajuan->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Status Awal</td>
                    <td class="value-col">
                        <span style="color: #d97706; font-weight: 700;">{{ $pengajuan->status }}</span>
                    </td>
                </tr>
                @if($pengajuan->jenis_layanan === 'Permohonan')
                    <tr>
                        <td class="label-col">Rincian Informasi</td>
                        <td class="value-col">{{ $pengajuan->info_diminta }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Tujuan Penggunaan</td>
                        <td class="value-col">{{ $pengajuan->tujuan_permohonan }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="label-col">Tujuan Keberatan</td>
                        <td class="value-col">{{ $pengajuan->tujuan_keberatan }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Alasan Keberatan</td>
                        <td class="value-col">{{ $pengajuan->alasan_keberatan }}</td>
                    </tr>
                @endif
            </table>

            <div class="btn-wrapper">
                <a href="{{ url('/layanan') }}" class="btn-primary">Pantau Status Pengajuan</a>
            </div>
        </div>

        <div class="footer">
            <p style="margin:0 0 4px 0;">Pesan otomatis dari Portal Layanan Informasi PPID FMIPA Unila.</p>
            <p style="margin:0;">&copy; {{ date('Y') }} Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Lampung.</p>
        </div>
    </div>
</div>

</body>
</html>


