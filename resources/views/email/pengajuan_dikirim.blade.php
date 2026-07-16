<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan PPID FMIPA Berhasil Terkirim</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0b192f;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header p {
            color: #0095e8;
            margin: 5px 0 0 0;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 10px;
        }
        .intro {
            font-size: 15px;
            color: #64748b;
            margin-bottom: 30px;
        }
        .ticket-badge {
            display: inline-block;
            background-color: #f0f9ff;
            border: 1px dashed #0095e8;
            color: #0095e8;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 8px;
            margin-top: 30px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table td {
            padding: 10px 0;
            vertical-align: top;
            font-size: 14px;
        }
        .data-table td.label {
            width: 35%;
            color: #64748b;
            font-weight: 600;
        }
        .data-table td.value {
            width: 65%;
            color: #1e293b;
            font-weight: 500;
            padding-left: 10px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 30px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .footer a {
            color: #0095e8;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-action {
            display: block;
            text-align: center;
            background-color: #0b192f;
            color: #ffffff !important;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            margin-top: 30px;
            box-shadow: 0 4px 6px -1px rgba(11, 25, 47, 0.2);
        }
        .btn-action:hover {
            background-color: #0095e8;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>PPID FMIPA</h1>
        <p>Universitas Lampung</p>
    </div>

    <div class="content">
        <div class="greeting">Halo, {{ $pengajuan->nama }}</div>
        <div class="intro">
            Terima kasih telah mengajukan permohonan layanan informasi melalui PPID FMIPA Unila. Pengajuan Anda telah berhasil kami terima dan saat ini sedang berada dalam antrean untuk diproses.
        </div>

        <div style="text-align: center;">
            <span class="ticket-badge">No. Tiket: {{ $pengajuan->no_tiket }}</span>
        </div>

        <div class="section-title">Data Pemohon</div>
        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="value">: {{ $pengajuan->nama }}</td>
            </tr>
            <tr>
                <td class="label">No. Identitas</td>
                <td class="value">: {{ $pengajuan->no_identitas }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">: {{ $pengajuan->email }}</td>
            </tr>
            <tr>
                <td class="label">No. HP / Telepon</td>
                <td class="value">: {{ $pengajuan->no_hp }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td class="value">: {{ $pengajuan->pekerjaan }}</td>
            </tr>
            <tr>
                <td class="label">Kategori Pemohon</td>
                <td class="value">: {{ $pengajuan->kategori_pemohon }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="value">: {{ $pengajuan->alamat }}</td>
            </tr>
        </table>

        <div class="section-title">Detail Pengajuan</div>
        <table class="data-table">
            <tr>
                <td class="label">Jenis Layanan</td>
                <td class="value">: <strong style="color: #0b192f;">{{ $pengajuan->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Status Saat Ini</td>
                <td class="value">: 
                    <span style="background-color: #fffbeb; color: #b45309; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 12px; border: 1px solid #fef3c7;">
                        {{ $pengajuan->status }}
                    </span>
                </td>
            </tr>
            @if($pengajuan->jenis_layanan === 'Permohonan')
                <tr>
                    <td class="label">Rincian Informasi</td>
                    <td class="value">: {{ $pengajuan->info_diminta }}</td>
                </tr>
                <tr>
                    <td class="label">Tujuan Penggunaan</td>
                    <td class="value">: {{ $pengajuan->tujuan_permohonan }}</td>
                </tr>
                <tr>
                    <td class="label">Cara Memperoleh</td>
                    <td class="value">: {{ $pengajuan->cara_memperoleh }}</td>
                </tr>
            @else
                <tr>
                    <td class="label">Nomor Tiket Terkait</td>
                    <td class="value">: {{ $pengajuan->permohonanTerkait ? $pengajuan->permohonanTerkait->no_tiket : '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tujuan Keberatan</td>
                    <td class="value">: {{ $pengajuan->tujuan_keberatan }}</td>
                </tr>
                <tr>
                    <td class="label">Alasan Keberatan</td>
                    <td class="value">: {{ $pengajuan->alasan_keberatan }}</td>
                </tr>
            @endif
        </table>

        <a href="{{ url('/layanan') }}" class="btn-action">Pantau Riwayat Pengajuan</a>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis oleh sistem PPID FMIPA Universitas Lampung.</p>
        <p>&copy; {{ date('Y') }} PPID FMIPA Unila. All Rights Reserved.</p>
    </div>
</div>

</body>
</html>

