<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaruan Status Pengajuan PPID FMIPA</title>
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
        .status-badge {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 18px;
            margin-bottom: 30px;
            text-align: center;
        }
        .status-diproses {
            background-color: #fffbeb;
            border: 1px solid #fef3c7;
            color: #b45309;
        }
        .status-diterima {
            background-color: #ecfdf5;
            border: 1px solid #d1fae5;
            color: #047857;
        }
        .status-ditolak {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #b91c1c;
        }
        .status-diajukan {
            background-color: #f0f9ff;
            border: 1px solid #e0f2fe;
            color: #0369a1;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .info-title {
            font-size: 14px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .info-body {
            font-size: 15px;
            color: #1e293b;
            font-weight: 500;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
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
            margin-top: 20px;
            box-shadow: 0 4px 6px -1px rgba(11, 25, 47, 0.2);
        }
        .btn-action:hover {
            background-color: #0095e8;
        }
        .btn-download {
            display: inline-block;
            background-color: #047857;
            color: #ffffff !important;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            font-size: 13px;
            margin-top: 10px;
        }
        .btn-download:hover {
            background-color: #065f46;
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
            Status pengajuan layanan informasi Anda telah diperbarui oleh Administrator PPID FMIPA Unila. Berikut rincian perubahan status terkini:
        </div>

        <div style="text-align: center; margin-bottom: 10px;">
            <span class="status-badge 
                @if($pengajuan->status === 'DIPROSES') status-diproses
                @elseif($pengajuan->status === 'DITERIMA') status-diterima
                @elseif($pengajuan->status === 'DITOLAK') status-ditolak
                @else status-diajukan
                @endif">
                STATUS: {{ $pengajuan->status }}
            </span>
        </div>

        <table class="data-table">
            <tr>
                <td class="label">No. Tiket</td>
                <td class="value">: <strong style="color: #0b192f;">{{ $pengajuan->no_tiket }}</strong></td>
            </tr>
            <tr>
                <td class="label">Jenis Layanan</td>
                <td class="value">: {{ $pengajuan->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}</td>
            </tr>
            <tr>
                <td class="label">Waktu Pembaruan</td>
                <td class="value">: {{ date('d F Y, H:i') }} WIB</td>
            </tr>
        </table>

        @if($pengajuan->catatan_admin)
            <div class="info-card">
                <div class="info-title">Catatan Administrator</div>
                <div class="info-body">{!! nl2br(e($pengajuan->catatan_admin)) !!}</div>
                
                @if($pengajuan->status === 'DITERIMA' && $pengajuan->file_jawaban)
                    <div style="margin-top: 15px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                        <span class="info-title" style="display: block; margin-bottom: 5px;">Berkas Jawaban / Tanggapan</span>
                        <a href="{{ url('/storage/' . $pengajuan->file_jawaban) }}" target="_blank" class="btn-download">
                            <i class="fa-solid fa-download"></i> Unduh Berkas Lampiran
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <a href="{{ url('/layanan') }}" class="btn-action">Lihat Riwayat & Detail Lengkap</a>
    </div>

    <div class="footer">
        <p>Email ini dikirim secara otomatis oleh sistem PPID FMIPA Universitas Lampung.</p>
        <p>&copy; {{ date('Y') }} PPID FMIPA Unila. All Rights Reserved.</p>
    </div>
</div>

</body>
</html>

