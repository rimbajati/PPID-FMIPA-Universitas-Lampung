<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Informasi Berhasil Terkirim - PPID FMIPA Unila</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="padding: 24px 16px;">
                <div style="font-size: 14px; font-weight: 600; color: #555555; margin-bottom: 16px;">
                    PPID FMIPA Universitas Lampung
                </div>

                <div style="font-size: 18px; font-weight: 700; color: #000000; margin-bottom: 12px;">
                    Permohonan Anda Telah Diterima
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Halo {{ $permohonan->nama }},
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Permohonan informasi publik Anda telah kami terima dan tercatat di sistem kami. Petugas PPID akan segera menelaah dan memproses permohonan Anda.
                </p>

                <!-- Nomor Tiket -->
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 12px; color: #888888; margin-bottom: 6px; font-weight: 600;">
                        NOMOR TIKET
                    </div>
                    <div style="font-size: 20px; font-weight: 700; color: #0066cc; font-family: 'Courier New', monospace; letter-spacing: 1px;">
                        {{ $permohonan->no_tiket }}
                    </div>
                    <p style="font-size: 12px; color: #888888; margin-top: 6px;">
                        Gunakan nomor ini untuk melacak permohonan Anda.
                    </p>
                </div>

                <!-- Detail Singkat -->
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 12px; font-weight: 600; color: #555555; margin-bottom: 12px; text-transform: uppercase;">
                        Rincian Permohonan
                    </div>
                    <div style="font-size: 13px; line-height: 1.8; color: #555555;">
                        <div style="margin-bottom: 8px;">
                            <strong>Informasi Diminta:</strong><br>
                            {{ $permohonan->info_diminta }}
                        </div>
                        <div style="margin-bottom: 8px;">
                            <strong>Tujuan Penggunaan:</strong><br>
                            {{ $permohonan->tujuan_permohonan }}
                        </div>
                        <div>
                            <strong>Status:</strong> {{ $permohonan->status }}
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div style="margin-bottom: 24px; text-align: center;">
                    <a href="{{ url('/riwayat-layanan') }}" target="_blank" style="display: inline-block; background-color: #0066cc; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 600;">
                        Lacak Permohonan
                    </a>
                </div>

                <p style="font-size: 12px; color: #888888; line-height: 1.6; margin-bottom: 24px;">
                    Sesuai UU KIP No. 14 Tahun 2008, permohonan akan ditanggapi paling lambat 10 (sepuluh) hari kerja sejak diterimanya permohonan.
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
