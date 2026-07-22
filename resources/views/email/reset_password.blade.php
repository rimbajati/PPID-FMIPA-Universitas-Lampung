<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - PPID FMIPA Unila</title>
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
            margin-bottom: 8px;
        }
        .text-p {
            font-size: 14px;
            color: #475569;
            margin-top: 0;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .btn-box {
            text-align: center;
            margin: 28px 0;
        }
        .btn-action {
            display: inline-block;
            background-color: #1B365D;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .note-box {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 14px 18px;
            border-radius: 6px;
            margin-bottom: 24px;
        }
        .note-text {
            font-size: 13px;
            color: #334155;
            margin: 0;
        }
        .alt-link-title {
            font-size: 12px;
            color: #64748b;
            margin-top: 24px;
            margin-bottom: 6px;
        }
        .alt-link-box {
            font-size: 11px;
            color: #2563eb;
            word-break: break-all;
            background-color: #f1f5f9;
            padding: 10px 14px;
            border-radius: 6px;
            border: 1px dashed #cbd5e1;
        }
        .footer {
            padding: 20px 32px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main-card">
            <!-- Header Section -->
            <div class="header">
                <h1 class="brand-title">PPID FMIPA Universitas Lampung</h1>
                <p class="brand-sub">Layanan Informasi Publik Terpadu</p>
            </div>

            <!-- Content Section -->
            <div class="content">
                <div class="greeting">Halo {{ $user->nama_lengkap ?? 'Pengguna' }},</div>
                
                <p class="text-p">
                    Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di portal Layanan Informasi Publik <strong>PPID FMIPA Universitas Lampung</strong>.
                </p>

                <div class="btn-box">
                    <a href="{{ $url }}" class="btn-action">Atur Ulang Kata Sandi</a>
                </div>

                <div class="note-box">
                    <p class="note-text">
                        ⏱️ Link di atas berlaku selama <strong>60 menit</strong>.<br>
                        🔒 Jika Anda tidak merasa meminta perubahan kata sandi, abaikan email ini dan kata sandi Anda akan tetap aman.
                    </p>
                </div>

                <div class="alt-link-title">Jika tombol di atas tidak dapat diklik, salin dan tempel tautan berikut ke browser Anda:</div>
                <div class="alt-link-box">
                    <a href="{{ $url }}" style="color: #2563eb; text-decoration: none;">{{ $url }}</a>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="footer">
                &copy; {{ date('Y') }} PPID FMIPA Universitas Lampung. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </div>
</body>
</html>
