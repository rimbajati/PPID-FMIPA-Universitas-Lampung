<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keberatan Tidak Dapat Dipenuhi - PPID FMIPA Unila</title>
</head>
<body style="margin:0;padding:0;background-color:#ffffff;font-family:Arial,Helvetica,sans-serif;color:#222222;">
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
        <tr>
            <td style="padding:32px 24px;">
                <div style="font-size:13px;color:#6b7280;margin-bottom:20px;">PPID FMIPA Universitas Lampung</div>

                <p style="font-size:14px;line-height:1.7;color:#222222;margin:0 0 16px 0;">Yth. Sdr/i {{ $keberatan['nama'] ?? 'Pemohon' }},</p>

                <p style="font-size:14px;line-height:1.7;color:#222222;margin:0 0 16px 0;">Pengajuan keberatan Anda dengan nomor tiket <strong style="font-family:'Courier New',monospace;letter-spacing:0.5px;color:#ea580c;">{{ $keberatan['no_tiket'] ?? '-' }}</strong> tidak dapat kami penuhi dengan alasan berikut.</p>

                @if(!empty($keberatan['alasan_ditolak']))
                    <div style="font-size:14px;line-height:1.8;color:#222222;margin:16px 0;white-space:pre-line;">{!! nl2br(e($keberatan['alasan_ditolak'])) !!}</div>
                @endif

                <p style="font-size:14px;line-height:1.7;color:#222222;margin:16px 0 0 0;">Apabila tidak menerima putusan ini, Anda dapat mengajukan penyelesaian sengketa informasi kepada Komisi Informasi Provinsi Lampung sesuai Pasal 37 UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.</p>
            </td>
        </tr>
    </table>
</body>
</html>
