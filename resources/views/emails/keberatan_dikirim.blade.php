<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Keberatan Berhasil Terkirim - PPID FMIPA Unila</title>
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
            margin-bottom: 24px;
        }
        .ticket-box {
            background-color: #fff7ed;
            border: 1px dashed #f97316;
            border-radius: 12px;
            padding: 16px 20px;
            text-align: center;
            margin-bottom: 24px;
        }
        .ticket-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #c2410c;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .ticket-number {
            font-size: 22px;
            font-weight: 900;
            color: #9a3412;
            letter-spacing: 1px;
        }
        .section-title {
            font-size: 13px;
            font-weight: 800;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            background-color: #f8fafc;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .details-table td {
            padding: 12px 16px;
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
            font-weight: 700;
        }
        .btn-wrapper {
            text-align: center;
            margin-top: 24px;
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
            <div class="greeting">Halo, {{ $keberatan->nama }}</div>
            
            <p class="message-text">
                Pengajuan Keberatan Informasi Publik Anda telah berhasil kami terima. Atasan PPID FMIPA Unila akan segera memeriksa berkas pengajuan keberatan Anda.
            </p>

            <div class="ticket-box">
                <div class="ticket-label">Nomor Tiket Keberatan</div>
                <div class="ticket-number">{{ $keberatan->no_tiket }}</div>
            </div>

            <div class="section-title">Ringkasan Keberatan</div>
            <table class="details-table">
                <tr>
                    <td class="label-col">Jenis Layanan</td>
                    <td class="value-col">Pengajuan Keberatan Informasi</td>
                </tr>
                <tr>
                    <td class="label-col">Status Awal</td>
                    <td class="value-col">
                        <span style="color: #ea580c; font-weight: 700;">{{ $keberatan->status }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label-col">Alasan Keberatan</td>
                    <td class="value-col">{{ $keberatan->alasan_keberatan }}</td>
                </tr>
            </table>

            <div class="btn-wrapper">
                <a href="{{ url('/riwayat-layanan') }}" class="btn-primary">Lacak Status Keberatan</a>
            </div>
        </div>

        <div class="footer">
            Email ini dikirim secara otomatis oleh Sistem PPID FMIPA Universitas Lampung.<br>
            Mohon tidak membalas email ini secara langsung.
        </div>
    </div>
</div>

</body>
</html>
