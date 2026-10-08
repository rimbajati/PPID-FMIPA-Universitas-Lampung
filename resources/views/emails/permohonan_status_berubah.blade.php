<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaruan Status Permohonan Informasi - PPID FMIPA Unila</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
        <tr>
            <td style="padding: 24px 16px;">
                <div style="font-size: 14px; font-weight: 600; color: #555555; margin-bottom: 16px;">
                    PPID FMIPA Universitas Lampung
                </div>

                <div style="font-size: 18px; font-weight: 700; color: #000000; margin-bottom: 12px;">
                    Pembaruan Status Permohonan
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Yth. Sdr/i {{ $permohonan['nama'] ?? 'Pemohon' }},
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Permohonan informasi publik Anda dengan Nomor Tiket <strong>{{ $permohonan['no_tiket'] ?? '-' }}</strong> telah diperbarui oleh Admin PPID FMIPA Unila.
                </p>

                @php
                    $st = strtolower($permohonan['status'] ?? '');
                    $statusColor = '#666666';
                    if (in_array($st, ['diproses', 'proses', 'pemeriksaan', 'verifikasi'])) {
                        $statusColor = '#0066cc';
                    } elseif (in_array($st, ['perlu perbaikan', 'perbaikan', 'pending'])) {
                        $statusColor = '#f59e0b';
                    } elseif (in_array($st, ['selesai', 'terima', 'diterima', 'disetujui'])) {
                        $statusColor = '#10b981';
                    } elseif ($st === 'ditolak') {
                        $statusColor = '#ef4444';
                    }
                @endphp
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 13px; font-weight: 600; color: #555555; margin-bottom: 12px;">
                        Rincian Tiket
                    </div>
                    <div style="font-size: 14px; line-height: 1.8; color: #333333;">
                        <div style="margin-bottom: 8px;">
                            Nomor Tiket<br>
                            <span style="font-size: 20px; font-weight: 700; color: #0066cc; font-family: 'Courier New', monospace;">{{ $permohonan['no_tiket'] ?? '-' }}</span>
                        </div>
                        <div style="padding: 12px 16px; background-color: #f5f5f5; border-left: 4px solid {{ $statusColor }}; border-radius: 4px; margin-bottom: 8px;">
                            <div style="font-size: 13px; color: #555555; margin-bottom: 4px; font-weight: 600;">
                                Status
                            </div>
                            <div style="font-size: 16px; font-weight: 700; color: {{ $statusColor }};">
                                {{ $permohonan['status'] ?? '-' }}
                            </div>
                        </div>
                        <div style="margin-bottom: 8px;">
                            <strong>Informasi yang Diminta:</strong><br>
                            {{ $permohonan['info_diminta'] ?? '-' }}
                        </div>
                        <div>
                            <strong>Waktu Pembaruan:</strong> {{ date('d F Y, H:i') }} WIB
                        </div>
                    </div>
                </div>

                @if(!empty($permohonan['pesan']))
                    <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #f5f5f5; border-radius: 4px;">
                        <div style="font-size: 13px; font-weight: 600; color: #555555; margin-bottom: 8px;">
                            Catatan dari Petugas
                        </div>
                        <div style="font-size: 14px; line-height: 1.6; color: #333333;">
                            {!! nl2br(e($permohonan['pesan'])) !!}
                        </div>

                        @if(!empty($permohonan['files']) && count($permohonan['files']))
                            <div style="margin-top: 12px; font-size: 13px; color: #333;">
                                <div style="font-weight: 600; margin-bottom: 6px;">File Jawaban</div>
                                @foreach($permohonan['files'] as $f)
                                    <a href="{{ url('/storage/' . $f->file_path) }}" target="_blank" style="display: inline-block; margin: 4px 8px 0 0; background-color: #059669; color: #ffffff; text-decoration: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600;">{{ $f->file_name }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <div style="margin-bottom: 24px; text-align: left;">
                    <a href="{{ url('/riwayat-layanan') }}" target="_blank" style="display: inline-block; background-color: #0066cc; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 600;">
                        Lihat Detail Lengkap
                    </a>
                </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
