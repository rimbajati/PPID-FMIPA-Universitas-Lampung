<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaruan Status Pengajuan - PPID FMIPA Unila</title>
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
        .status-badge-container {
            margin-bottom: 24px;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .status-diproses {
            background-color: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        .status-perbaikan {
            background-color: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .status-diterima {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .status-ditolak {
            background-color: #fff1f2;
            color: #9f1239;
            border: 1px solid #fecdd3;
        }
        .status-diajukan {
            background-color: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
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
        .notes-card {
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }
        .notes-card.perbaikan {
            background-color: #fffbeb;
            border-color: #fde68a;
        }
        .notes-card.ditolak {
            background-color: #fff1f2;
            border-color: #fecdd3;
        }
        .notes-card.diterima {
            background-color: #f0fdf4;
            border-color: #bbf7d0;
        }
        .notes-card.default {
            background-color: #f8fafc;
            border-color: #e2e8f0;
        }
        .notes-header {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .notes-card.perbaikan .notes-header { color: #b45309; }
        .notes-card.ditolak .notes-header { color: #be123c; }
        .notes-card.diterima .notes-header { color: #15803d; }
        .notes-card.default .notes-header { color: #475569; }

        .notes-body {
            font-size: 13.5px;
            color: #1e293b;
            line-height: 1.55;
            font-weight: 500;
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
        .btn-download {
            display: inline-block;
            background-color: #059669;
            color: #ffffff !important;
            padding: 9px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 12.5px;
            text-decoration: none;
            margin-top: 12px;
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
                @if($pengajuan->status === 'PERBAIKAN')
                    Pengajuan layanan informasi Anda membutuhkan perbaikan data sebelum dapat diproses lebih lanjut.
                @elseif($pengajuan->status === 'DIPROSES')
                    Pengajuan layanan informasi Anda saat ini sedang ditindaklanjuti oleh tim PPID FMIPA Unila.
                @elseif($pengajuan->status === 'DITERIMA')
                    Permohonan informasi Anda telah disetujui dan ditanggapi oleh PPID FMIPA Unila.
                @elseif($pengajuan->status === 'DITOLAK')
                    Pengajuan layanan informasi Anda tidak dapat ditindaklanjuti.
                @else
                    Status pengajuan layanan informasi Anda telah diperbarui.
                @endif
            </p>

            <div class="status-badge-container">
                <span class="status-badge 
                    @if($pengajuan->status === 'DIPROSES') status-diproses
                    @elseif($pengajuan->status === 'PERBAIKAN') status-perbaikan
                    @elseif($pengajuan->status === 'DITERIMA') status-diterima
                    @elseif($pengajuan->status === 'DITOLAK') status-ditolak
                    @else status-diajukan
                    @endif">
                    Status: {{ $pengajuan->status }}
                </span>
            </div>

            <table class="details-table">
                <tr>
                    <td class="label-col">Nomor Tiket</td>
                    <td class="value-col">{{ $pengajuan->no_tiket }}</td>
                </tr>
                <tr>
                    <td class="label-col">Jenis Layanan</td>
                    <td class="value-col">{{ $pengajuan->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}</td>
                </tr>
                <tr>
                    <td class="label-col">Waktu Pembaruan</td>
                    <td class="value-col">{{ date('d F Y, H:i') }} WIB</td>
                </tr>
            </table>

            @if($pengajuan->catatan_admin || $pengajuan->file_jawaban || $pengajuan->link_jawaban)
                <div class="notes-card 
                    @if($pengajuan->status === 'PERBAIKAN') perbaikan
                    @elseif($pengajuan->status === 'DITOLAK') ditolak
                    @elseif($pengajuan->status === 'DITERIMA') diterima
                    @else default
                    @endif">
                    <div class="notes-header">
                        @if($pengajuan->status === 'PERBAIKAN')
                            Catatan Perbaikan dari Petugas
                        @elseif($pengajuan->status === 'DITOLAK')
                            Alasan Penolakan
                        @elseif($pengajuan->status === 'DITERIMA')
                            Tanggapan & Jawaban Administrator
                        @else
                            Catatan Administrator
                        @endif
                    </div>

                    @if($pengajuan->catatan_admin)
                        <div class="notes-body">{!! nl2br(e($pengajuan->catatan_admin)) !!}</div>
                    @endif

                    @if($pengajuan->file_jawaban)
                        <div style="margin-top: 14px; padding-top: 10px; border-top: 1px dashed #cbd5e1;">
                            <a href="{{ url('/storage/' . $pengajuan->file_jawaban) }}" target="_blank" class="btn-download" style="display: inline-block; background-color: #1B365D; color: #ffffff; padding: 10px 18px; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 13px;">
                                📥 Unduh File Jawaban
                            </a>
                        </div>
                    @endif

                    @if($pengajuan->link_jawaban)
                        <div style="margin-top: 14px; padding-top: 10px; border-top: 1px dashed #cbd5e1;">
                            <a href="{{ $pengajuan->link_jawaban }}" target="_blank" class="btn-download" style="display: inline-block; background-color: #059669; color: #ffffff; padding: 10px 18px; border-radius: 8px; font-weight: bold; text-decoration: none; font-size: 13px;">
                                🔗 Buka Tautan / Link Jawaban
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <div class="btn-wrapper">
                <a href="{{ url('/layanan') }}" class="btn-primary">
                    @if($pengajuan->status === 'PERBAIKAN')
                        Perbaiki Data Sekarang
                    @else
                        Lihat Detail Pengajuan
                    @endif
                </a>
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


