<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Informasi Telah Selesai - PPID FMIPA Unila</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="padding: 24px 16px;">
                <div style="font-size: 14px; font-weight: 600; color: #555555; margin-bottom: 16px;">
                    PPID FMIPA Universitas Lampung
                </div>

                <div style="font-size: 18px; font-weight: 700; color: #000000; margin-bottom: 12px;">
                    Permohonan Informasi Selesai
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Yth. {{ $permohonan['nama'] ?? 'Pemohon' }},
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Permohonan informasi publik yang Anda ajukan kepada PPID FMIPA Universitas Lampung telah selesai diproses dan dapat kami penuhi.
                </p>

                <!-- Status -->
                <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #f0fdf4; border-left: 4px solid #10b981; border-radius: 4px;">
                    <div style="font-size: 11px; color: #047857; margin-bottom: 4px; font-weight: 600; text-transform: uppercase;">
                        Status
                    </div>
                    <div style="font-size: 16px; font-weight: 700; color: #10b981;">
                        SELESAI
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

                <!-- Keterangan -->
                @if(!empty($permohonan['catatan_selesai']))
                    <div style="margin-bottom: 24px; padding: 12px 16px; background-color: #f5f5f5; border-radius: 4px;">
                        <div style="font-size: 12px; font-weight: 600; color: #555555; margin-bottom: 8px; text-transform: uppercase;">
                            Keterangan
                        </div>
                        <div style="font-size: 13px; line-height: 1.6; color: #555555;">
                            {!! nl2br(e($permohonan['catatan_selesai'])) !!}
                        </div>
                    </div>
                @endif

                <!-- Akses Informasi -->
                @if(!empty($permohonan['file_jawaban']) || !empty($permohonan['link_jawaban']))
                    <div style="margin-bottom: 24px;">
                        <div style="font-size: 12px; font-weight: 600; color: #555555; margin-bottom: 12px; text-transform: uppercase;">
                            Akses Informasi
                        </div>
                        @if(!empty($permohonan['file_jawaban']))
                            <div style="margin-bottom: 10px;">
                                <a href="{{ url('/storage/' . $permohonan['file_jawaban']) }}" target="_blank" style="display: inline-block; background-color: #059669; color: #ffffff; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                    Unduh Dokumen
                                </a>
                            </div>
                        @endif
                        @if(!empty($permohonan['link_jawaban']))
                            <div>
                                <a href="{{ $permohonan['link_jawaban'] }}" target="_blank" style="display: inline-block; background-color: #0066cc; color: #ffffff; text-decoration: none; padding: 8px 16px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                    Buka Tautan
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

                <p style="font-size: 12px; color: #888888; line-height: 1.6; margin-bottom: 24px; text-align: center;">
                    Terima kasih atas kepercayaan Anda menggunakan layanan informasi publik kami.
                </p>

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
