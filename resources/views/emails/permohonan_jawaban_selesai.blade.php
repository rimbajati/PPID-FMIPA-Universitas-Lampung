<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Informasi Telah Selesai - PPID FMIPA Unila</title>
</head>
<body style="margin:0;padding:0;background-color:#ffffff;font-family:Arial,Helvetica,sans-serif;color:#222222;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
        <tr>
            <td style="padding:32px 24px;">
                <div style="font-size:13px;color:#6b7280;margin-bottom:20px;">PPID FMIPA Universitas Lampung</div>

                <p style="font-size:14px;line-height:1.7;color:#222222;margin:0 0 16px 0;">Yth. Sdr/i {{ $permohonan['nama'] ?? 'Pemohon' }},</p>

                <p style="font-size:14px;line-height:1.7;color:#222222;margin:0 0 16px 0;">Permohonan informasi publik Anda dengan nomor tiket <strong style="font-family:'Courier New',monospace;letter-spacing:0.5px;color:#1e4bd8;">{{ $permohonan['no_tiket'] ?? '-' }}</strong> telah selesai dipenuhi.</p>

                @if(!empty($permohonan['catatan_selesai']))
                    @php
                        $catatanHtml = e($permohonan['catatan_selesai']);
                        $catatanHtml = preg_replace('#(https?://[^\s<]+)#i', '<a href="$1" target="_blank" style="color:#0066cc;word-break:break-all;">$1</a>', $catatanHtml);
                    @endphp
                    <div style="font-size:14px;line-height:1.8;color:#222222;margin:16px 0 0 0;white-space:pre-line;">{!! nl2br($catatanHtml) !!}</div>
                @endif

                <div style="margin-top:24px;padding:16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;text-align:center;">
                    <p style="font-size:13px;color:#64748b;margin:0 0 12px 0;line-height:1.6;">Tidak puas dengan jawaban yang diberikan? Anda bisa mengajukan keberatan di sistem ini.</p>
                    <a href="{{ url('/pengajuan-keberatan?tiket=' . urlencode($permohonan['no_tiket'] ?? '')) }}" target="_blank" style="display:inline-block;background-color:#ea580c;color:#ffffff;text-decoration:none;padding:12px 28px;border-radius:4px;font-size:14px;font-weight:600;">Ajukan Keberatan</a>
                </div>


            </td>
        </tr>
    </table>
</body>
</html>
