<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keberatan Tidak Dikabulkan - PPID FMIPA Unila</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="padding: 24px 16px;">
                <div style="font-size: 14px; font-weight: 600; color: #555555; margin-bottom: 16px;">
                    PPID FMIPA Universitas Lampung
                </div>

                <div style="font-size: 18px; font-weight: 700; color: #000000; margin-bottom: 12px;">
                    Keberatan Tidak Dikabulkan
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Yth. {{ $keberatan['nama'] ?? 'Pemohon' }},
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Atasan PPID FMIPA Universitas Lampung telah memeriksa pengajuan keberatan yang Anda sampaikan dan memutuskan untuk <strong>tidak mengabulkan</strong> keberatan tersebut berdasarkan pertimbangan yang berlaku.
                </p>

                <!-- Status -->
                <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #fff1f2; border-left: 4px solid #ef4444; border-radius: 4px;">
                    <div style="font-size: 11px; color: #dc2626; margin-bottom: 4px; font-weight: 600; text-transform: uppercase;">
                        Status
                    </div>
                    <div style="font-size: 16px; font-weight: 700; color: #ef4444;">
                        TIDAK DIKABULKAN
                    </div>
                </div>

                <!-- Nomor Tiket -->
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 12px; color: #888888; margin-bottom: 6px; font-weight: 600;">
                        NOMOR TIKET KEBERATAN
                    </div>
                    <div style="font-size: 20px; font-weight: 700; color: #0066cc; font-family: 'Courier New', monospace; letter-spacing: 1px;">
                        {{ $keberatan['no_tiket'] ?? '-' }}
                    </div>
                </div>

                <!-- Detail -->
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 12px; font-weight: 600; color: #555555; margin-bottom: 12px; text-transform: uppercase;">
                        Rincian Keberatan
                    </div>
                    <div style="font-size: 13px; line-height: 1.8; color: #555555;">
                        <div>
                            <strong>Alasan Keberatan:</strong><br>
                            {{ $keberatan['alasan_keberatan'] ?? '-' }}
                        </div>
                    </div>
                </div>

                <!-- Pertimbangan -->
                @if(!empty($keberatan['alasan_ditolak']))
                    <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #fff1f2; border-radius: 4px;">
                        <div style="font-size: 12px; font-weight: 600; color: #dc2626; margin-bottom: 8px; text-transform: uppercase;">
                            Pertimbangan Atasan PPID
                        </div>
                        <div style="font-size: 13px; line-height: 1.6; color: #555555;">
                            {!! nl2br(e($keberatan['alasan_ditolak'])) !!}
                        </div>
                    </div>
                @endif

                <!-- Info Sengketa -->
                <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #eff6ff; border-radius: 4px;">
                    <div style="font-size: 12px; font-weight: 600; color: #1d4ed8; margin-bottom: 8px; text-transform: uppercase;">
                        Upaya Hukum Lanjutan
                    </div>
                    <div style="font-size: 13px; line-height: 1.6; color: #555555;">
                        Apabila Anda tidak menerima putusan ini, Anda dapat mengajukan <strong>penyelesaian sengketa informasi</strong> kepada Komisi Informasi Provinsi Lampung sesuai Pasal 37 UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
                    </div>
                </div>

                <!-- CTA Button -->
                <div style="margin-bottom: 24px; text-align: center;">
                    <a href="{{ url('/riwayat-layanan') }}" target="_blank" style="display: inline-block; background-color: #0066cc; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 600;">
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