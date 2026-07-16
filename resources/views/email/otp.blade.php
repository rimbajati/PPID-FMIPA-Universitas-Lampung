<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .box { max-width: 500px; margin: 20px auto; padding: 30px; border: 1px solid #e5e7eb; border-radius: 16px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .otp-angka { font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #0095e8; background: #f0f9ff; padding: 16px 20px; border-radius: 12px; margin: 24px 0; display: inline-block; }
        .footer { margin-top: 30px; font-size: 11px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 16px; }
    </style>
</head>
<body>
    <div class="box">
        <h2 style="margin-top:0; color:#0f2b4a;">Kode Verifikasi PPID</h2>
        <p>Halo,</p>
        <p>Anda telah melakukan permintaan pendaftaran akun di portal Layanan Informasi Terpadu <b>PPID FMIPA Universitas Lampung</b>. Berikut adalah kode verifikasi Anda:</p>

        <div class="otp-angka">{{ $otp }}</div>

        <p style="font-size: 13px; color: #4b5563;">Kode ini hanya berlaku selama <b>3 menit</b>. Jangan berikan kode ini kepada siapa pun, termasuk pihak Admin PPID.</p>

        <div class="footer">
            &copy; {{ date('Y') }} PPID FMIPA Universitas Lampung.
        </div>
    </div>
</body>
</html>

