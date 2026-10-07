<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - PPID FMIPA Unila</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #333333;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="padding: 24px 16px;">
                <div style="font-size: 14px; font-weight: 600; color: #555555; margin-bottom: 16px;">
                    PPID FMIPA Universitas Lampung
                </div>

                <div style="font-size: 18px; font-weight: 700; color: #000000; margin-bottom: 12px;">
                    Atur Ulang Kata Sandi
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Halo {{ $user->name ?? 'Pengguna' }},
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                    Kami menerima permintaan untuk mengatur ulang kata sandi akun PPID FMIPA Unila Anda. Klik tombol di bawah ini untuk membuat kata sandi baru.
                </p>

                <!-- CTA Button -->
                <div style="margin-bottom: 24px; text-align: center;">
                    <a href="{{ $resetUrl }}" target="_blank" style="display: inline-block; background-color: #0066cc; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 600;">
                        Atur Ulang Kata Sandi
                    </a>
                </div>

                <!-- Info Keamanan -->
                <div style="margin-bottom: 20px; padding: 12px 16px; background-color: #f5f5f5; border-radius: 4px; font-size: 12.5px; line-height: 1.6; color: #555555;">
                    Tautan reset kata sandi ini hanya berlaku selama <strong>60 menit</strong>. Jika Anda tidak pernah meminta perubahan kata sandi, abaikan email ini dan akun Anda tetap aman.
                </div>

                <div style="font-size: 12px; color: #888888; line-height: 1.5; margin-bottom: 24px; word-break: break-all;">
                    Jika tombol tidak berfungsi, salin tautan berikut ke browser:<br>
                    <a href="{{ $resetUrl }}" style="color: #0066cc; text-decoration: underline;">{{ $resetUrl }}</a>
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