<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaruan Status Pengajuan Keberatan - PPID FMIPA Unila</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="padding: 24px 16px;">
                <div style="font-size: 14px; font-weight: 600; color: #555555; margin-bottom: 16px;">
                    PPID FMIPA Universitas Lampung
                </div>

                <div style="font-size: 18px; font-weight: 700; color: #000000; margin-bottom: 12px;">
                    Pembaruan Status Keberatan
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Halo {{ $keberatan['nama'] ?? 'Pemohon' }},
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Status penanganan keberatan atas nomor tiket <strong>{{ $keberatan['no_tiket'] ?? '-' }}</strong> telah diperbarui oleh Atasan PPID FMIPA Unila.
                </p>

                <!-- Status Badge -->
                @php
                    $st = strtolower($keberatan['status'] ?? '');
                    $statusColor = '#666666';
                    if (in_array($st, ['diproses', 'proses', 'pemeriksaan', 'verifikasi'])) {
                        $statusColor = '#0066cc';
                    } elseif (in_array($st, ['perlu tanggapan', 'tanggapan'])) {
                        $statusColor = '#f59e0b';
                    } elseif (in_array($st, ['selesai', 'diterima', 'dikabulkan', 'disetujui'])) {
                        $statusColor = '#10b981';
                    } elseif (in_array($st, ['ditolak', 'tidak dikabulkan'])) {
                        $statusColor = '#ef4444';
                    }
                @endphp
                <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #f5f5f5; border-left: 4px solid {{ $statusColor }}; border-radius: 4px;">
                    <div style="font-size: 11px; color: #888888; margin-bottom: 4px; font-weight: 600; text-transform: uppercase;">
                        Status Terbaru
                    </div>
                    <div style="font-size: 16px; font-weight: 700; color: {{ $statusColor }}; text-transform: uppercase;">
                        {{ $keberatan['status'] ?? '-' }}
                    </div>
                </div>

                <!-- Detail -->
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 12px; font-weight: 600; color: #555555; margin-bottom: 12px; text-transform: uppercase;">
                        Rincian Keberatan
                    </div>
                    <div style="font-size: 13px; line-height: 1.8; color: #555555;">
                        <div style="margin-bottom: 8px;">
                            <strong>Nomor Tiket:</strong> <span style="font-family: 'Courier New', monospace;">{{ $keberatan['no_tiket'] ?? '-' }}</span>
                        </div>
                        <div style="margin-bottom: 8px;">
                            <strong>Alasan Keberatan:</strong><br>
                            {{ $keberatan['alasan_keberatan'] ?? '-' }}
                        </div>
                        <div>
                            <strong>Waktu Pembaruan:</strong> {{ date('d F Y, H:i') }} WIB
                        </div>
                    </div>
                </div>

                <!-- Tanggapan -->
                @if(!empty($keberatan['tanggapan']))
                    <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #f5f5f5; border-radius: 4px;">
                        <div style="font-size: 12px; font-weight: 600; color: #555555; margin-bottom: 8px; text-transform: uppercase;">
                            Tanggapan Atasan PPID
                        </div>
                        <div style="font-size: 13px; line-height: 1.6; color: #555555;">
                            {!! nl2br(e($keberatan['tanggapan'])) !!}
                        </div>

                        @if(!empty($keberatan['file_tanggapan']))
                            <div style="margin-top: 12px;">
                                <a href="{{ url('/storage/' . $keberatan['file_tanggapan']) }}" target="_blank" style="display: inline-block; background-color: #059669; color: #ffffff; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                    Unduh Surat Tanggapan
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- CTA Button -->
                <div style="margin-bottom: 24px; text-align: center;">
                    <a href="{{ url('/riwayat-layanan') }}" target="_blank" style="display: inline-block; background-color: #0066cc; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 600;">
                        Lihat Detail Lengkap
                    </a>
                </div>

                <div style="border-top: 1px solid #cccccc; padding-top: 16px; font-size: 12px; color: #888888; line-height: 1.6;">
                    <div style="margin-bottom: 4px;">
                        PPID Pelaksana FMIPA Universitas Lampung
                    </div>
                    <div>
                        Gedung Dekanat FMIPA Unila, Jl. Prof. Dr. Sumantri Brojonegoro No. 1, Bandar Lampung<br>
                        Email ini dikirim otomatis. Jangan balas email ini.
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
