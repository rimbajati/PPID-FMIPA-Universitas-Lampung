<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Informasi Tidak Dapat Dipenuhi - PPID FMIPA Unila</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="padding: 24px 16px;">
                <div style="font-size: 14px; font-weight: 600; color: #555555; margin-bottom: 16px;">
                    PPID FMIPA Universitas Lampung
                </div>

                <div style="font-size: 18px; font-weight: 700; color: #000000; margin-bottom: 12px;">
                    Permohonan Tidak Dapat Dipenuhi
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Yth. {{ $permohonan['nama'] ?? 'Pemohon' }},
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Setelah melalui proses pemeriksaan dan penelaahan, permohonan informasi publik yang Anda ajukan kepada PPID FMIPA Universitas Lampung tidak dapat kami penuhi berdasarkan ketentuan yang berlaku.
                </p>

                <!-- Status -->
                <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #fff1f2; border-left: 4px solid #ef4444; border-radius: 4px;">
                    <div style="font-size: 11px; color: #dc2626; margin-bottom: 4px; font-weight: 600; text-transform: uppercase;">
                        Status
                    </div>
                    <div style="font-size: 16px; font-weight: 700; color: #ef4444;">
                        DITOLAK
                    </div>
                </div>

                <!-- Nomor Tiket -->
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 12px; color: #888888; margin-bottom: 6px; font-weight: 600;">
                        NOMOR TIKET
                    </div>
                    <div style="font-size: 20px; font-weight: 700; color: #0066cc; font-family: 'Courier New', monospace; letter-spacing: 1px;">
                        {{ $permohonan['no_tiket'] ?? '-' }}
                    </div>
                </div>

                <!-- Detail -->
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 12px; font-weight: 600; color: #555555; margin-bottom: 12px; text-transform: uppercase;">
                        Rincian Permohonan
                    </div>
                    <div style="font-size: 13px; line-height: 1.8; color: #555555;">
                        <div style="margin-bottom: 8px;">
                            <strong>Informasi Diminta:</strong><br>
                            {{ $permohonan['info_diminta'] ?? '-' }}
                        </div>
                        <div>
                            <strong>Tujuan Penggunaan:</strong><br>
                            {{ $permohonan['tujuan_permohonan'] ?? '-' }}
                        </div>
                    </div>
                </div>

                <!-- Alasan -->
                @if(!empty($permohonan['alasan_ditolak']))
                    <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #fff1f2; border-radius: 4px;">
                        <div style="font-size: 12px; font-weight: 600; color: #dc2626; margin-bottom: 8px; text-transform: uppercase;">
                            Alasan Penolakan
                        </div>
                        <div style="font-size: 13px; line-height: 1.6; color: #555555;">
                            {!! nl2br(e($permohonan['alasan_ditolak'])) !!}
                        </div>
                    </div>
                @endif

                <!-- Info Keberatan -->
                <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #eff6ff; border-radius: 4px;">
                    <div style="font-size: 12px; font-weight: 600; color: #1d4ed8; margin-bottom: 8px; text-transform: uppercase;">
                        Hak Pengajuan Keberatan
                    </div>
                    <div style="font-size: 13px; line-height: 1.6; color: #555555;">
                        Apabila Anda tidak menerima keputusan ini, Anda berhak mengajukan keberatan kepada Atasan PPID FMIPA Universitas Lampung sesuai Pasal 35 UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div style="margin-bottom: 24px; text-align: center;">
                    <a href="{{ url('/pengajuan-keberatan?tiket=' . urlencode($permohonan['no_tiket'] ?? '')) }}" target="_blank" style="display: inline-block; background-color: #dc2626; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 600; margin-right: 8px;">
                        Ajukan Keberatan
                    </a>
                    <a href="{{ url('/riwayat-layanan') }}" target="_blank" style="display: inline-block; background-color: #f5f5f5; color: #555555; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 600; border: 1px solid #cccccc;">
                        Lihat Riwayat
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
