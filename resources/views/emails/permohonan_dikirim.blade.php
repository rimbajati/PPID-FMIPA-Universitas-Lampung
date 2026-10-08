<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Informasi Berhasil Terkirim - PPID FMIPA Unila</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
        <tr>
            <td style="padding: 24px 16px;">
                <div style="font-size: 14px; font-weight: 600; color: #555555; margin-bottom: 16px;">
                    PPID FMIPA Universitas Lampung
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin: 0 0 16px 0;">
                    Yth. Sdr/i {{ $permohonan->nama }},
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin: 0 0 20px 0;">
                    Permohonan informasi Anda telah kami terima dan tercatat di sistem. Sesuai UU KIP No. 14 Tahun 2008, permohonan akan ditanggapi paling lambat 10 (sepuluh) hari kerja sejak diterimanya permohonan.
                </p>

                <div style="margin-bottom: 24px;">
                    <div style="font-size: 13px; color: #555555; margin-bottom: 6px; font-weight: 600;">
                        Nomor Tiket
                    </div>
                    <div style="font-size: 20px; font-weight: 700; color: #0066cc; font-family: 'Courier New', monospace; letter-spacing: 1px; margin-bottom: 8px;">
                        {{ $permohonan->no_tiket }}
                    </div>
                    <p style="font-size: 13px; color: #555555; margin: 4px 0 0 0;">
                        Gunakan nomor ini untuk melacak permohonan Anda.
                    </p>
                </div>

                <div style="margin-top:24px;padding:16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;text-align:center;">
                    <a href="{{ url('/riwayat-layanan') }}" target="_blank" style="display: inline-block; background-color: #38bdf8; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 600;">
                        Lacak Permohonan
                    </a>
                </div>

                <div style="padding-top: 12px;">
            </td>
        </tr>
    </table>
</body>
</html>
