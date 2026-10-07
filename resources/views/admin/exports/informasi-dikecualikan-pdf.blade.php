<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Informasi yang Dikecualikan - PPID FMIPA Unila</title>
    <style>
        @page { size: A4 landscape; margin: 12mm; }
        * { box-sizing: border-box; }
        body { margin: 0; padding: 14mm 0; color: #111; background: #e2e8f0; font: 10pt "Times New Roman", serif; }
        .page { width: 297mm; min-height: 210mm; margin: 0 auto; padding: 12mm 15mm; background: #fff; }
        .actions { position: fixed; top: 12px; right: 16px; display: flex; gap: 8px; }
        .actions button { border: 0; border-radius: 6px; padding: 9px 14px; font-weight: 700; cursor: pointer; }
        .print { color: #fff; background: #0284c7; }
        .close { color: #334155; background: #e2e8f0; }
        .heading { margin-bottom: 7mm; text-align: center; }
        .heading h1, .heading h2 { margin: 0; font-size: 12pt; text-transform: uppercase; }
        .heading h2 { margin-top: 2mm; font-size: 11pt; }
        .heading p { margin: 2mm auto 0; max-width: 240mm; font-size: 9pt; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #111; padding: 2mm; vertical-align: middle; overflow-wrap: anywhere; line-height: 1.25; }
        th { text-align: center; font-weight: 700; }
        td { font-size: 9pt; }
        .center { text-align: center; }
        .no-data { padding: 12mm; text-align: center; }
        .signature-container { display: flex; justify-content: flex-end; margin-top: 14mm; page-break-inside: avoid; }
        .signature-box { width: 85mm; font-size: 10pt; line-height: 1.35; }
        .signature-space { height: 22mm; }
        .signature-name, .signature-nip { font-size: 10pt; }
        .signature-nip { margin-top: 1mm; }
        @media screen { .page { box-shadow: 0 4px 20px #0002; } }
        @media print {
            body { padding: 0; background: #fff; }
            .page { width: auto; min-height: 0; margin: 0; padding: 0; }
            .actions { display: none; }
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="actions no-print">
        <button class="print" onclick="window.print()">Cetak / Simpan PDF</button>
        <button class="close" onclick="window.close()">Tutup</button>
    </div>

    <main class="page">
        <header class="heading">
            <h1>Daftar Informasi Publik yang Dikecualikan</h1>
            <h2>PPID Pelaksana Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Lampung</h2>
            <p>Daftar informasi yang dikecualikan berdasarkan pengujian konsekuensi sesuai ketentuan keterbukaan informasi publik.</p>
        </header>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" style="width: 5%">No</th>
                    <th rowspan="2" style="width: 22%">Informasi</th>
                    <th rowspan="2" style="width: 20%">Dasar Hukum</th>
                    <th colspan="2" style="width: 38%">Konsekuensi / Pertimbangan Bagi Publik</th>
                    <th rowspan="2" style="width: 15%">Jangka Waktu</th>
                </tr>
                <tr>
                    <th style="width: 19%">Dibuka</th>
                    <th style="width: 19%">Ditutup</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                    <tr>
                        <td class="center">{{ $index + 1 }}</td>
                        <td>{{ $item->ringkasan_informasi }}</td>
                        <td>{{ $item->dasar_hukum ?: '-' }}</td>
                        <td>{{ $item->dibuka ?: '-' }}</td>
                        <td>{{ $item->ditutup ?: '-' }}</td>
                        <td>{{ $item->jangka_waktu ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="no-data">Belum ada data informasi yang dikecualikan.</td></tr>
                @endforelse
            </tbody>
        </table>

        <section class="signature-container">
            <div class="signature-box">
                <div contenteditable="true" title="Klik untuk mengubah tanggal">Bandar Lampung, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div contenteditable="true" title="Klik untuk mengubah jabatan" style="font-weight: 700; margin-top: 2px;">
                    PPID Pelaksana FMIPA Universitas Lampung
                </div>
                <div class="signature-space"></div>
                <div class="signature-name" contenteditable="true" title="Klik untuk mengubah nama">
                    ................................................................
                </div>
                <div class="signature-nip" contenteditable="true" title="Klik untuk mengubah NIP">
                    NIP. ................................................................
                </div>
            </div>
        </section>
    </main>
</body>
</html>
