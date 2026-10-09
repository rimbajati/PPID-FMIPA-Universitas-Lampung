@php
    $tahun = date('Y');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dokumen Black Box Testing - PPID FMIPA Unila</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root { --sky:#0ea5e9; --sky-dark:#0284c7; --slate:#0f172a; }
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',system-ui,sans-serif;color:#1e293b;background:#f1f5f9;font-size:11px;line-height:1.4}
    @media print{
        @page{size:A4 landscape;margin:10mm 8mm 10mm 8mm}
        body{background:#fff}
        .no-print{display:none!important}
        .page-break{page-break-before:always}
        table{page-break-inside:auto}
        tr{page-break-inside:avoid}
    }
    .toolbar{position:sticky;top:0;z-index:50;background:#0f172a;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:10px 16px}
    .toolbar h1{font-size:13px;font-weight:800;letter-spacing:.02em}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:8px;font-weight:700;font-size:12px;border:0;cursor:pointer}
    .btn-print{background:var(--sky);color:#fff}
    .btn-print:hover{background:var(--sky-dark)}
    .sheet{max-width:1180px;margin:18px auto;background:#fff;box-shadow:0 8px 30px rgba(15,23,42,.08);border:1px solid #e2e8f0}
    /* wider for table */
    .sheet.wide{max-width: 1600px}
    .cover{padding:28px 24px 18px;text-align:center;border-bottom:3px solid var(--sky)}
    .cover .badge{display:inline-block;background:#e0f2fe;color:#0369a1;font-weight:800;font-size:10px;letter-spacing:.12em;padding:4px 10px;border-radius:999px;margin-bottom:10px}
    .cover h2{font-size:22px;font-weight:800;color:#0f172a;letter-spacing:-.02em}
    .cover h3{font-size:12px;font-weight:600;color:#475569;margin-top:4px}
    .cover .meta{margin-top:10px;font-size:10px;color:#64748b}
    .section{padding:14px 18px}
    .section h4{font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#0f172a;border-left:4px solid var(--sky);padding-left:8px;margin-bottom:10px}
    .grid2{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    .card{border:1px solid #e2e8f0;border-radius:10px;padding:10px 12px;background:#f8fafc}
    .card label{font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#64748b}
    .card .val{margin-top:4px;border-bottom:1px dotted #cbd5e1;padding:6px 2px;min-height:18px;font-size:11px;color:#0f172a}
    .hint{background:#fffbeb;border:1px solid #fde68a;color:#92400e;border-radius:8px;padding:8px 10px;font-size:10px}
    .hint b{color:#b45309}
    /* tables */
    .tbl-wrap{overflow:auto;border:1px solid #e2e8f0;border-radius:10px}
    table{width:100%;border-collapse:collapse;min-width:1100px}
    th,td{border:1px solid #e2e8f0;padding:6px 7px;vertical-align:top;text-align:left}
    th{background:#0f172a;color:#fff;font-size:9px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;white-space:nowrap}
    td{font-size:10px}
    td.no{text-align:center;font-weight:700;background:#f8fafc;width:28px}
    td.kode{white-space:nowrap;font-weight:700;font-size:9px;color:#0369a1}
    td.modul{white-space:nowrap;font-weight:600;font-size:9px}
    td.skenario{font-weight:600}
    td.langkah{font-size:9px;color:#334155}
    td.data{font-size:9px;color:#475569;word-break:break-word}
    td.harap{font-size:9px}
    td.kosong{background:#fffef7}
    td.cek{width:62px;text-align:center;white-space:nowrap}
    td.paraf{width:48px}
    tr.group td{background:#e0f2fe;color:#0c4a6e;font-weight:800;font-size:10px;letter-spacing:.04em;padding:7px 8px}
    .legend{display:flex;flex-wrap:wrap;gap:8px;font-size:9px;color:#64748b;margin-top:8px}
    .legend span{display:inline-flex;align-items:center;gap:4px}
    .dot{width:9px;height:9px;border-radius:3px;display:inline-block}
    .sign-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-top:12px}
    .sign-box{border:1px solid #e2e8f0;border-radius:10px;padding:12px;text-align:center;background:#f8fafc}
    .sign-box .role{font-size:9px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#64748b}
    .sign-box .name{margin-top:18px;border-bottom:1px dotted #94a3b8;padding:6px;font-weight:700;font-size:11px;min-height:22px}
    .sign-box .sig{height:72px;border:1px dashed #cbd5e1;border-radius:8px;margin-top:8px;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:9px;background:#fff}
    .footer-meta{margin-top:14px;display:flex;justify-content:space-between;gap:12px;font-size:9px;color:#64748b;border-top:1px solid #e2e8f0;padding-top:10px}
    .tag{display:inline-block;padding:2px 6px;border-radius:999px;font-size:9px;font-weight:800}
    .tag-admin{background:#fee2e2;color:#991b1b}
    .tag-user{background:#dcfce7;color:#166534}
    .tag-both{background:#e0e7ff;color:#3730a3}
    @media(max-width:900px){
        .grid2{grid-template-columns:1fr}
        .sign-grid{grid-template-columns:1fr}
        table{min-width:900px}
        .sheet{margin:0;border-radius:0}
    }
</style>
</head>
<body>

<div class="toolbar no-print">
    <h1>PPID FMIPA Unila — Dokumen Black Box Testing</h1>
    <div style="display:flex;gap:8px">
        <button class="btn btn-print" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        <a href="/" class="btn" style="background:#fff;color:#0f172a;text-decoration:none">← Beranda</a>
    </div>
</div>

<!-- COVER -->
<div class="sheet">
    <div class="cover">
        <div class="badge">DOKUMEN PENGUJIAN PERANGKAT LUNAK</div>
        <h2>BLACK BOX TESTING</h2>
        <h3>Sistem Informasi PPID Pelaksana FMIPA Universitas Lampung</h3>
        <div class="meta">Tahun {{ $tahun }} &nbsp;•&nbsp; Versi 1.0 &nbsp;•&nbsp; Metode: Black Box — Validasi Fungsional Tanpa Melihat Struktur Kode</div>
        <div style="margin-top:14px;display:flex;justify-content:center;gap:8px;flex-wrap:wrap">
            <span class="tag tag-user">Masyarakat</span>
            <span class="tag tag-admin">Admin</span>
            <span class="tag tag-both">Keduanya</span>
        </div>
    </div>

    <div class="section">
        <h4>1 &nbsp; Identitas Pengujian</h4>
        <div class="grid2">
            <div class="card">
                <label>Nama Penguji / Dosen Pembimbing</label>
                <div class="val" style="min-height:22px"></div>
                <label style="margin-top:8px;display:block">NIP / NIDN</label>
                <div class="val"></div>
                <label style="margin-top:8px;display:block">Tanggal Pengujian</label>
                <div class="val">{{ date('d F Y') }}</div>
            </div>
            <div class="card">
                <label>Nama Mahasiswa / Pengembang</label>
                <div class="val" style="min-height:22px"></div>
                <label style="margin-top:8px;display:block">NPM</label>
                <div class="val"></div>
                <label style="margin-top:8px;display:block">Lokasi Pengujian</label>
                <div class="val"></div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-top:10px">
            <div class="card"><label>Versi Aplikasi</label><div class="val">v1.0 — ppid-fmipa-baru</div></div>
            <div class="card"><label>Lingkungan Uji</label><div class="val">Laragon / Chrome / Firefox — Desktop & Mobile</div></div>
            <div class="card"><label>Total Skenario</label><div class="val" id="total-skenario">~ 92 kasus uji</div></div>
        </div>

        <div class="hint" style="margin-top:10px">
            <b>Petunjuk:</b> Isi kolom <b>Hasil Aktual</b> dan <b>Status</b> saat pengujian berlangsung. Beri tanda <b>✓ Berhasil</b> jika sesuai harapan, <b>✗ Gagal</b> jika tidak. Bubuhkan <b>paraf</b> penguji pada tiap baris / per kelompok modul. Tanda tangan akhir di halaman terakhir mengesahkan hasil uji.
        </div>

        <div class="legend">
            <span><i class="dot" style="background:#e0f2fe;border:1px solid #7dd3fc"></i> Header kelompok modul</span>
            <span><i class="dot" style="background:#fffef7;border:1px solid #e2e8f0"></i> Kolom diisi penguji</span>
            <span>✓ = Berhasil &nbsp; ✗ = Gagal &nbsp; — = Tidak diuji</span>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="sheet wide">
    <div class="section" style="padding-bottom:6px">
        <h4>2 &nbsp; Tabel Pengujian Fungsional (Black Box)</h4>
        <div style="font-size:9px;color:#64748b;margin-bottom:8px">Akses: Masyarakat = tanpa login &nbsp;|&nbsp; Admin = butuh login <code>/admin-panel/login</code> + role <code>admin</code>. Seluruh URL diuji di desktop dan mobile (hamburger).</div>
    </div>
    <div style="padding:0 12px 12px">
        <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:28px">No</th>
                    <th style="width:52px">Kode</th>
                    <th style="width:98px">Modul / Fitur</th>
                    <th style="width:150px">Skenario Pengujian</th>
                    <th>Langkah / Prosedur Uji</th>
                    <th style="width:150px">Data Uji</th>
                    <th style="width:170px">Hasil yang Diharapkan</th>
                    <th style="width:110px">Hasil Aktual <span style="font-weight:400;text-transform:none">(diisi penguji)</span></th>
                    <th style="width:62px">Status</th>
                    <th style="width:46px">Paraf</th>
                </tr>
            </thead>
            <tbody>

                <!-- A -->
                <tr class="group"><td colspan="10">A — BERANDA & NAVIGASI UMUM (Masyarakat)</td></tr>
                <tr><td class="no">1</td><td class="kode">A-01</td><td class="modul">Beranda / Hero</td><td class="skenario">Buka beranda <code>/</code></td><td class="langkah">1. Akses <code>/</code> tanpa login<br>2. Periksa hero, kategori DIP, statistik, profil PPID, FAQ</td><td class="data">—</td><td class="harap">Beranda tampil lengkap, tidak error, data dinamis (jumlah dokumen, permohonan, keberatan) sesuai DB</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">2</td><td class="kode">A-02</td><td class="modul">Navbar — Beranda</td><td class="skenario">Klik Beranda</td><td class="langkah">Klik menu Beranda di desktop & mobile</td><td class="data">—</td><td class="harap">Scroll ke atas / tetap di <code>/</code>, state aktif benar</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">3</td><td class="kode">A-03</td><td class="modul">Navbar — Profil PPID</td><td class="skenario">Klik Profil PPID</td><td class="langkah">Klik Profil PPID</td><td class="data">—</td><td class="harap">Scroll ke section <code>#profil-ppid</code> di beranda, foto & jabatan tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">4</td><td class="kode">A-04</td><td class="modul">Navbar — Informasi Publik</td><td class="skenario">Dropdown Informasi Publik tampil cantik + sekat</td><td class="langkah">Hover (desktop) / tap (mobile) menu Informasi Publik</td><td class="data">—</td><td class="harap">Dropdown muncul dengan ikon: Daftar (list), Berkala (clock), Setiap Saat (rotate), Serta-Merta (warning), Dikecualikan (lock) + sekat hanya sebelum Dikecualikan</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">5</td><td class="kode">A-05</td><td class="modul">Navbar — Layanan</td><td class="skenario">Dropdown Layanan tampil cantik + sekat</td><td class="langkah">Hover/tap menu Layanan</td><td class="data">—</td><td class="harap">Urutan: Tata Cara Permohonan → sekat → Form Permohonan Informasi (envelope, biru) + Form Pengajuan Keberatan (gavel, orange) → sekat → Lacak Tiket Layanan → sekat → Statistik Layanan (chart, sky)</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">6</td><td class="kode">A-06</td><td class="modul">Navbar — Regulasi</td><td class="skenario">Klik Regulasi</td><td class="langkah">Klik Regulasi</td><td class="data">—</td><td class="harap">Menuju <code>/regulasi</code> daftar regulasi tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">7</td><td class="kode">A-07</td><td class="modul">Navbar — Mobile</td><td class="skenario">Hamburger mobile</td><td class="langkah">Kecilkan viewport &lt;768px, tap hamburger, buka semua accordion</td><td class="data">—</td><td class="harap">Menu mobile tampil, accordion Informasi Publik & Layanan bisa buka/tutup, icon selaras desktop</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">8</td><td class="kode">A-08</td><td class="modul">Footer</td><td class="skenario">Footer ramping tidak menyatu</td><td class="langkah">Scroll ke bawah halaman mana pun</td><td class="data">—</td><td class="harap">Footer bg <code>#E0F2FE</code> terpisah jelas dari body putih, 4 kolom: Branding (logoPPID 2 baris + email/WA), Layanan, Informasi Publik, Tautan; bottom bar alamat</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- B -->
                <tr class="group"><td colspan="10">B — KATALOG INFORMASI PUBLIK (Masyarakat)</td></tr>
                <tr><td class="no">9</td><td class="kode">B-01</td><td class="modul">Daftar DIP</td><td class="skenario">Buka <code>/informasi-publik</code></td><td class="langkah">Akses Daftar Informasi Publik</td><td class="data">—</td><td class="harap">Katalog tampil, filter kategori/tahun/satker/search + pagination</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">10</td><td class="kode">B-02</td><td class="modul">Filter Kategori Berkala</td><td class="skenario">Pilih Informasi Berkala</td><td class="langkah">Klik kategori Berkala via dropdown / <code>/informasi-publik/kategori/berkala</code></td><td class="data">kategori=Informasi Berkala</td><td class="harap">Hanya dokumen Berkala tampil, urutan rincian baku (Profil → Program → Kinerja …)</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">11</td><td class="kode">B-03</td><td class="modul">Filter Setiap Saat</td><td class="skenario">Pilih Informasi Setiap Saat</td><td class="langkah">Akses <code>/informasi-publik/kategori/setiap-saat</code></td><td class="data">kategori=Informasi Setiap Saat</td><td class="harap">Hanya dokumen Setiap Saat tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">12</td><td class="kode">B-04</td><td class="modul">Filter Serta-Merta</td><td class="skenario">Pilih Informasi Serta-Merta</td><td class="langkah">Akses <code>/informasi-publik/kategori/serta-merta</code></td><td class="data">kategori=Informasi Serta-Merta</td><td class="harap">Hanya dokumen Serta-Merta tampil, urut terbaru</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">13</td><td class="kode">B-05</td><td class="modul">Dikecualikan</td><td class="skenario">Buka daftar Dikecualikan</td><td class="langkah">Akses <code>/informasi-dikecualikan</code></td><td class="data">—</td><td class="harap">Daftar informasi dikecualikan tampil (tanpa file publik)</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">14</td><td class="kode">B-06</td><td class="modul">Pencarian & Filter</td><td class="skenario">Cari dokumen</td><td class="langkah">Isi search, pilih tahun & satker, terapkan filter</td><td class="data">search="laporan", tahun=2024, satker="Fakultas"</td><td class="harap">Hasil terfilter benar, kombinasi filter AND, kosong → "Tidak ada data"</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">15</td><td class="kode">B-07</td><td class="modul">Detail Informasi</td><td class="skenario">Buka detail <code>/informasi-publik/{id}</code></td><td class="langkah">Klik salah satu dokumen</td><td class="data">id valid</td><td class="harap">Detail tampil: ringkasan, pejabat/unit, penanggung jawab, waktu, retensi, tombol Lihat File</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">16</td><td class="kode">B-08</td><td class="modul">Lihat File — dokumen file</td><td class="skenario">Preview file inline</td><td class="langkah">Klik Lihat File pada dokumen ber-file</td><td class="data">dokumen dengan file_informasi</td><td class="harap">File terbuka inline <code>/informasi/lihat/{id}</code> atau <code>/informasi/file/{id}/{nama}</code>, mime benar, nama file asli tampil, dilihat +1</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">17</td><td class="kode">B-09</td><td class="modul">Lihat File — link eksternal</td><td class="skenario">Dokumen hanya link</td><td class="langkah">Klik Lihat File pada dokumen link saja</td><td class="data">link_informasi terisi, file kosong</td><td class="harap">Redirect away ke URL eksternal</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">18</td><td class="kode">B-10</td><td class="modul">Counter Dilihat</td><td class="skenario">Pastikan admin tidak menambah counter</td><td class="langkah">Buka file dari masyarakat vs buka dengan <code>?from_admin=1</code></td><td class="data">—</td><td class="harap">Masyarakat → viewed +1; admin → tidak +1</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">19</td><td class="kode">B-11</td><td class="modul">File 404</td><td class="skenario">File hilang</td><td class="langkah">Akses id tanpa file / path rusak</td><td class="data">id tanpa file</td><td class="harap">404 "File tidak ditemukan"</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- C -->
                <tr class="group"><td colspan="10">C — PERMOHONAN INFORMASI (Masyarakat — tanpa login)</td></tr>
                <tr><td class="no">20</td><td class="kode">C-01</td><td class="modul">Form Permohonan</td><td class="skenario">Buka form <code>/permohonan</code></td><td class="langkah">Akses via navbar Layanan → Form Permohonan Informasi</td><td class="data">—</td><td class="harap">Form tampil: identitas, kontak, rincian informasi, tujuan, upload identitas</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">21</td><td class="kode">C-02</td><td class="modul">Submit — Valid Perorangan</td><td class="skenario">Kirim permohonan lengkap KTP</td><td class="langkah">Isi semua wajib + upload KTP (jpg/pdf ≤2MB) → Kirim</td><td class="data">Nama, NIK 16 digit, email valid, WA, alamat, rincian, tujuan, KTP</td><td class="harap">Berhasil, dapat No Tiket (contoh PM-2026-XXXX), toast sukses, data masuk admin Pending</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">22</td><td class="kode">C-03</td><td class="modul">Submit — Valid Badan Hukum</td><td class="skenario">Kirim sebagai Badan Hukum</td><td class="langkah">Pilih jenis identitas Badan Hukum + upload akta</td><td class="data">Jenis=Badan Hukum, file akta</td><td class="harap">Berhasil diproses sama, tiket terbit</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">23</td><td class="kode">C-04</td><td class="modul">Validasi — Wajib Kosong</td><td class="skenario">Kirim kosong</td><td class="langkah">Kosongkan nama/email/rincian → Kirim</td><td class="data">field wajib kosong</td><td class="harap">Gagal validasi, pesan error di field, tidak terbuat tiket</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">24</td><td class="kode">C-05</td><td class="modul">Validasi — Email & WA</td><td class="skenario">Format email & WA salah</td><td class="langkah">Isi email "abc", WA "huruf"</td><td class="data">email=abc, wa=abcd</td><td class="harap">Validasi menolak, pesan format email/WA tidak valid</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">25</td><td class="kode">C-06</td><td class="modul">Validasi — File</td><td class="skenario">File salah format / kebesaran</td><td class="langkah">Upload .exe / >2MB</td><td class="data">file .exe 5MB</td><td class="harap">Ditolak, info tipe & ukuran diperbolehkan</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">26</td><td class="kode">C-07</td><td class="modul">File Preview Permohonan</td><td class="skenario">Preview identitas</td><td class="langkah">Akses <code>/permohonan/file/{id}/identitas/{nama}</code></td><td class="data">id permohonan valid</td><td class="harap">File identitas tampil inline dengan nama asli</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- D -->
                <tr class="group"><td colspan="10">D — PENGAJUAN KEBERATAN (Masyarakat)</td></tr>
                <tr><td class="no">27</td><td class="kode">D-01</td><td class="modul">Form Keberatan</td><td class="skenario">Buka <code>/pengajuan-keberatan</code></td><td class="langkah">Akses via Layanan → Form Pengajuan Keberatan</td><td class="data">—</td><td class="harap">Form tampil: no tiket permohonan terkait, alasan, kronologi, upload pendukung</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">28</td><td class="kode">D-02</td><td class="modul">Submit — Valid</td><td class="skenario">Kirim keberatan valid</td><td class="langkah">Isi tiket permohonan valid + alasan keberatan → Kirim</td><td class="data">no_tiket valid, alasan terisi</td><td class="harap">Berhasil, dapat No Tiket Keberatan KB-…, toast sukses</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">29</td><td class="kode">D-03</td><td class="modul">Validasi — Tiket tidak ada</td><td class="skenario">Tiket permohonan tidak ditemukan</td><td class="langkah">Isi no tiket asal yang tidak ada</td><td class="data">no_tiket=PM-XXXX nada</td><td class="harap">Gagal, pesan tiket tidak ditemukan</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">30</td><td class="kode">D-04</td><td class="modul">Validasi — Alasan kosong</td><td class="skenario">Alasan kosong</td><td class="langkah">Kosongkan alasan keberatan → Kirim</td><td class="data">alasan=""</td><td class="harap">Validasi menolak</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">31</td><td class="kode">D-05</td><td class="modul">Upload Pendukung</td><td class="skenario">Upload file pendukung</td><td class="langkah">Lampirkan pdf/jpg pendukung</td><td class="data">file pendukung valid</td><td class="harap">File tersimpan, bisa di-preview via <code>/keberatan/file/{id}/{nama}</code></td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- E -->
                <tr class="group"><td colspan="10">E — LACAK TIKET / RIWAYAT LAYANAN (Masyarakat)</td></tr>
                <tr><td class="no">32</td><td class="kode">E-01</td><td class="modul">Halaman Lacak</td><td class="skenario">Buka <code>/riwayat-layanan</code></td><td class="langkah">Akses via Layanan → Lacak Tiket Layanan</td><td class="data">—</td><td class="harap">Form lacak tampil: input No Tiket + No Identitas / Email</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">33</td><td class="kode">E-02</td><td class="modul">Lacak — Valid</td><td class="skenario">Lacak tiket valid</td><td class="langkah">Isi no tiket + no identitas yang benar → Lacak (POST)</td><td class="data">tiket valid dari C-02</td><td class="harap">Detail status tampil: Diajukan/Diproses/Selesai/Ditolak + catatan admin + timeline</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">34</td><td class="kode">E-03</td><td class="modul">Lacak — Salah</td><td class="skenario">Tiket / identitas salah</td><td class="langkah">Isi tiket salah atau identitas tidak cocok</td><td class="data">tiket salah</td><td class="harap">Pesan "Tiket tidak ditemukan / tidak cocok"</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">35</td><td class="kode">E-04</td><td class="modul">Validasi Lacak</td><td class="skenario">Input kosong</td><td class="langkah">Kosongkan field → Lacak</td><td class="data">kosong</td><td class="harap">Validasi wajib muncul</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- F -->
                <tr class="group"><td colspan="10">F — TATA CARA, REGULASI, PROFIL, FAQ & STATISTIK BERANDA</td></tr>
                <tr><td class="no">36</td><td class="kode">F-01</td><td class="modul">Tata Cara</td><td class="skenario">Buka <code>/tata-cara-permohonan-dan-keberatan</code></td><td class="langkah">Akses via Layanan → Tata Cara Permohonan</td><td class="data">—</td><td class="harap">Halaman tata cara tampil (permohonan & keberatan), konten dari admin</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">37</td><td class="kode">F-02</td><td class="modul">Regulasi</td><td class="skenario">Buka <code>/regulasi</code></td><td class="langkah">Klik Regulasi</td><td class="data">—</td><td class="harap">Daftar regulasi tampil lengkap</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">38</td><td class="kode">F-03</td><td class="modul">Profil PPID</td><td class="skenario">Profil di beranda</td><td class="langkah">Scroll ke Profil PPID di beranda</td><td class="data">—</td><td class="harap">Nama, foto, jabatan, tugas & fungsi, email, WA tampil sinkron dengan admin</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">39</td><td class="kode">F-04</td><td class="modul">FAQ</td><td class="skenario">FAQ accordion</td><td class="langkah">Klik pertanyaan FAQ</td><td class="data">—</td><td class="harap">Jawaban expand/collapse, data dari admin</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">40</td><td class="kode">F-05</td><td class="modul">Statistik Beranda</td><td class="skenario">Statistik layanan di beranda</td><td class="langkah">Scroll ke Statistik Layanan, ganti tahun, hover chart</td><td class="data">tahun={{ $tahun }}</td><td class="harap">Kartu total, donat kategori, chart tahunan/bulanan tampil, angka sesuai DB, rata waktu proses tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- G -->
                <tr class="group"><td colspan="10">G — AUTH ADMIN</td></tr>
                <tr><td class="no">41</td><td class="kode">G-01</td><td class="modul">Login Page</td><td class="skenario">Buka <code>/admin-panel/login</code></td><td class="langkah">Akses login tanpa auth</td><td class="data">—</td><td class="harap">Form login tampil, halaman login hide navbar masyarakat</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">42</td><td class="kode">G-02</td><td class="modul">Login — Valid</td><td class="skenario">Login admin benar</td><td class="langkah">Isi email & password admin benar → Login</td><td class="data">kredensial admin valid</td><td class="harap">Redirect ke <code>/admin/informasi-publik</code>, sidebar biru muncul, toast sukses</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">43</td><td class="kode">G-03</td><td class="modul">Login — Salah Password</td><td class="skenario">Password salah</td><td class="langkah">Email benar, password salah → Login</td><td class="data">password salah</td><td class="harap">Gagal, pesan error, tetap di login</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">44</td><td class="kode">G-04</td><td class="modul">Akses Tanpa Login</td><td class="skenario">Akses <code>/admin/*</code> tanpa login</td><td class="langkah">Logout lalu akses <code>/admin/informasi-publik</code></td><td class="data">belum login</td><td class="harap">Redirect ke login, tidak bisa akses</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">45</td><td class="kode">G-05</td><td class="modul">Akses Sudah Login</td><td class="skenario">Buka login saat sudah login admin</td><td class="langkah">Sudah login lalu akses <code>/admin-panel/login</code></td><td class="data">session admin aktif</td><td class="harap">Auto redirect ke <code>/admin/informasi-publik</code></td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">46</td><td class="kode">G-06</td><td class="modul">Logout</td><td class="skenario">Keluar admin</td><td class="langkah">Klik Keluar di sidebar footer / navbar mobile</td><td class="data">—</td><td class="harap">Logout berhasil, redirect ke beranda / login, session hilang</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- H -->
                <tr class="group"><td colspan="10">H — ADMIN: INFORMASI PUBLIK (CRUD + FILTER + FILE)</td></tr>
                <tr><td class="no">47</td><td class="kode">H-01</td><td class="modul">List & Filter</td><td class="skenario">List + filter kategori/tahun/satker/search</td><td class="langkah">Buka <code>/admin/informasi-publik</code>, coba filter & search</td><td class="data">kategori, tahun, satker, keyword</td><td class="harap">Tabel terfilter benar, pagination jalan, border siku, card vivid (violet/blue/emerald/amber)</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">48</td><td class="kode">H-02</td><td class="modul">Tambah — Valid</td><td class="skenario">Tambah DIP baru lengkap + file</td><td class="langkah">Klik Tambah → isi semua wajib + upload file → Simpan</td><td class="data">Rincian, Sub Informasi, Jenis, Tahun, Satker, file pdf</td><td class="harap">Berhasil, toast sukses, data muncul di tabel & katalog publik</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">49</td><td class="kode">H-03</td><td class="modul">Tambah — Validasi</td><td class="skenario">Validasi wajib gagal</td><td class="langkah">Kosongkan field wajib → Simpan</td><td class="data">wajib kosong</td><td class="harap">Error validasi tampil, tidak tersimpan</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">50</td><td class="kode">H-04</td><td class="modul">Edit</td><td class="skenario">Edit DIP</td><td class="langkah">Klik Edit → ubah rincian/satker/file → Update</td><td class="data">perubahan rincian</td><td class="harap">Berhasil update, toast sukses</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">51</td><td class="kode">H-05</td><td class="modul">Hapus Single</td><td class="skenario">Hapus satu data + modal konfirmasi</td><td class="langkah">Klik Hapus → konfirmasi Ya</td><td class="data">—</td><td class="harap">Modal muncul, setelah Ya data hilang, toast sukses</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">52</td><td class="kode">H-06</td><td class="modul">Bulk Delete</td><td class="skenario">Hapus banyak via checkbox</td><td class="langkah">Toggle Pilih/Hapus → centang beberapa → Hapus Terpilih → konfirmasi</td><td class="data">2–3 row dicentang</td><td class="harap">Hanya yang dicentang terhapus, counter badge update</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">53</td><td class="kode">H-07</td><td class="modul">Rename Rincian</td><td class="skenario">Rename rincian kategori</td><td class="langkah">POST <code>/admin/informasi-publik/rename-rincian</code> via modal</td><td class="data">nama rincian baru</td><td class="harap">Nama rincian berubah untuk kelompok tersebut</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">54</td><td class="kode">H-08</td><td class="modul">Delete Rincian</td><td class="skenario">Hapus satu rincian kelompok</td><td class="langkah">DELETE <code>/admin/informasi-publik/delete-rincian</code></td><td class="data">rincian, jenis</td><td class="harap">Kelompok rincian terhapus</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">55</td><td class="kode">H-09</td><td class="modul">Lihat File Admin</td><td class="skenario">Preview file dari admin</td><td class="langkah">Klik Lihat File di tabel admin</td><td class="data">—</td><td class="harap">File inline terbuka, karena <code>?from_admin=1</code> counter tidak +1</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- I -->
                <tr class="group"><td colspan="10">I — ADMIN: INFORMASI DIKECUALIKAN</td></tr>
                <tr><td class="no">56</td><td class="kode">I-01</td><td class="modul">List</td><td class="skenario">Buka <code>/admin/informasi-dikecualikan</code></td><td class="langkah">Akses menu Informasi Dikecualikan (admin)</td><td class="data">—</td><td class="harap">Tabel DIK tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">57</td><td class="kode">I-02</td><td class="modul">Tambah / Edit</td><td class="skenario">CRUD DIK</td><td class="langkah">Tambah baru → Edit → Simpan</td><td class="data">judul, dasar hukum, konsekuensi</td><td class="harap">Berhasil simpan & update, tampil di publik</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">58</td><td class="kode">I-03</td><td class="modul">Hapus</td><td class="skenario">Hapus single & bulk</td><td class="langkah">Hapus satu + bulk via checkbox</td><td class="data">—</td><td class="harap">Terhapus dengan modal konfirmasi</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- J -->
                <tr class="group"><td colspan="10">J — ADMIN: PERMOHONAN INFORMASI</td></tr>
                <tr><td class="no">59</td><td class="kode">J-01</td><td class="modul">List & Filter</td><td class="skenario">List permohonan + filter status/search</td><td class="langkah">Buka <code>/admin/permohonan</code>, filter status & search tiket/nama</td><td class="data">status=Diajukan, search="nama"</td><td class="harap">Tabel terfilter benar, badge pending di sidebar sinkron</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">60</td><td class="kode">J-02</td><td class="modul">Detail</td><td class="skenario">Lihat detail <code>/admin/permohonan/{id}</code></td><td class="langkah">Klik Detail/Lihat</td><td class="data">id valid</td><td class="harap">Detail lengkap + file identitas preview + panel status</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">61</td><td class="kode">J-03</td><td class="modul">Update Status Diproses</td><td class="skenario">Ubah Diajukan → Diproses</td><td class="langkah">PUT <code>/admin/permohonan/{id}/status</code> status=diproses + catatan</td><td class="data">status=diproses</td><td class="harap">Status berubah, catatan tersimpan, lacak masyarakat ikut update</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">62</td><td class="kode">J-04</td><td class="modul">Update Status Selesai</td><td class="skenario">Ubah → Selesai</td><td class="langkah">PUT status=selesai + catatan_selesai</td><td class="data">status=selesai</td><td class="harap">Status selesai, masuk hitungan statistik selesai</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">63</td><td class="kode">J-05</td><td class="modul">Update Status Ditolak</td><td class="skenario">Ubah → Ditolak + alasan</td><td class="langkah">PUT status=ditolak + alasan_ditolak wajib</td><td class="data">status=ditolak, alasan terisi</td><td class="harap">Status ditolak, alasan tampil di lacak & export</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">64</td><td class="kode">J-06</td><td class="modul">Hapus & Bulk</td><td class="skenario">Hapus permohonan</td><td class="langkah">DELETE single & bulk-delete</td><td class="data">—</td><td class="harap">Terhapus, file ikut terhapus aman</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- K -->
                <tr class="group"><td colspan="10">K — ADMIN: KEBERATAN</td></tr>
                <tr><td class="no">65</td><td class="kode">K-01</td><td class="modul">List & Filter</td><td class="skenario">List keberatan</td><td class="langkah">Buka <code>/admin/keberatan</code>, filter & search</td><td class="data">search tiket/alasan</td><td class="harap">Tabel terfilter, relasi permohonan tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">66</td><td class="kode">K-02</td><td class="modul">Detail</td><td class="skenario">Detail keberatan</td><td class="langkah">Klik detail</td><td class="data">id valid</td><td class="harap">Detail + alasan + kronologi + file pendukung preview</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">67</td><td class="kode">K-03</td><td class="modul">Update Status</td><td class="skenario">Diproses / Selesai / Ditolak</td><td class="langkah">PUT <code>/admin/keberatan/{id}/status</code> ganti status bertahap</td><td class="data">status berurutan</td><td class="harap">Status update benar, tampil di lacak jika ada</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">68</td><td class="kode">K-04</td><td class="modul">Hapus & Bulk</td><td class="skenario">Hapus keberatan</td><td class="langkah">DELETE single & bulk</td><td class="data">—</td><td class="harap">Terhapus</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- L -->
                <tr class="group"><td colspan="10">L — ADMIN: PROFIL PPID & KONTEN BERANDA</td></tr>
                <tr><td class="no">69</td><td class="kode">L-01</td><td class="modul">Profil — Buka</td><td class="skenario">Buka <code>/admin/profil-ppid</code></td><td class="langkah">Akses menu Profil PPID</td><td class="data">—</td><td class="harap">Form profil tampil: Nama, Foto, Jabatan, Tugas & Fungsi, Email, WA — grid 2 kolom</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">70</td><td class="kode">L-02</td><td class="modul">Profil — Update Teks</td><td class="skenario">Update nama/jabatan/tugas/email/WA</td><td class="langkah">POST <code>/admin/profil-ppid</code> ubah field → Simpan</td><td class="data">nama baru, email baru</td><td class="harap">Berhasil, tampil di beranda & footer sinkron</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">71</td><td class="kode">L-03</td><td class="modul">Profil — Foto</td><td class="skenario">Upload foto landscape preview</td><td class="langkah">Upload foto PPID (jpg/png) → preview</td><td class="data">foto landscape</td><td class="harap">Preview object-contain landscape, tersimpan & tampil di beranda</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">72</td><td class="kode">L-04</td><td class="modul">FAQ — CRUD</td><td class="skenario">Kelola FAQ</td><td class="langkah">Buka <code>/admin/faq</code> → Tambah → Hapus</td><td class="data">pertanyaan & jawaban</td><td class="harap">FAQ baru tampil di beranda, hapus hilang</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">73</td><td class="kode">L-05</td><td class="modul">Regulasi — CRUD</td><td class="skenario">Kelola Regulasi</td><td class="langkah">Buka <code>/admin/regulasi-admin</code> → Tambah → Hapus</td><td class="data">judul, file/link</td><td class="harap">Regulasi tampil di <code>/regulasi</code></td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">74</td><td class="kode">L-06</td><td class="modul">Tata Cara — Update</td><td class="skenario">Kelola Tata Cara</td><td class="langkah">Buka <code>/admin/tata-cara-admin</code> → Update → Simpan</td><td class="data">konten tata cara</td><td class="harap">Update tampil di <code>/tata-cara-permohonan-dan-keberatan</code></td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- M -->
                <tr class="group"><td colspan="10">M — ADMIN: STATISTIK LAYANAN</td></tr>
                <tr><td class="no">75</td><td class="kode">M-01</td><td class="modul">Buka Statistik</td><td class="skenario">Buka <code>/admin/statistik</code></td><td class="langkah">Akses menu Statistik</td><td class="data">—</td><td class="harap">Summary card, filter tahun, chart tahunan & bulanan tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">76</td><td class="kode">M-02</td><td class="modul">Filter Tahun & Bulan</td><td class="skenario">Ganti tahun & bulan</td><td class="langkah">Pilih tahun berbeda, pilih bulan, hover chart</td><td class="data">tahun 2024, 2025</td><td class="harap">Chart & rekap bulanan update sesuai tahun, tanpa reload error</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">77</td><td class="kode">M-03</td><td class="modul">Jenis Identitas</td><td class="skenario">Statistik jenis identitas</td><td class="langkah">Periksa donat KTP/Paspor/Badan Hukum</td><td class="data">—</td><td class="harap">Donat tampil 1 kolom legend rata kiri, tanpa persentase, sesuai data permohonan</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">78</td><td class="kode">M-04</td><td class="modul">Hint Drilldown</td><td class="skenario">Hint interaktif</td><td class="langkah">Hover legend / label footer kartu</td><td class="data">—</td><td class="harap">Hint drilldown muncul, legend grid 1 kolom rapi</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- N -->
                <tr class="group"><td colspan="10">N — ADMIN: EXPORT EXCEL / PDF (Filter-aware, Landscape)</td></tr>
                <tr><td class="no">79</td><td class="kode">N-01</td><td class="modul">Export DIP Excel</td><td class="skenario">Export DIP .xlsx (kategori=all)</td><td class="langkah">GET <code>/admin/export/informasi/excel</code></td><td class="data">—</td><td class="harap">Terunduh .xlsx, header biru, kolom 8 (Cetak/Online ✓), filter kategori & search dihormati, urutan baku</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">80</td><td class="kode">N-02</td><td class="modul">Export DIP Excel Filter</td><td class="skenario">Export filter kategori & tahun</td><td class="langkah">GET dengan kategori=Informasi Berkala & tahun=2024</td><td class="data">kategori, tahun</td><td class="harap">Hanya data filter yang diekspor</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">81</td><td class="kode">N-03</td><td class="modul">Export DIP PDF</td><td class="skenario">Cetak DIP PDF landscape</td><td class="langkah">GET <code>/admin/export/informasi/pdf</code> → Print</td><td class="data">—</td><td class="harap">PDF landscape, layout tabel rapi, header periode tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">82</td><td class="kode">N-04</td><td class="modul">Export DIK PDF</td><td class="skenario">Export Dikecualikan PDF</td><td class="langkah">GET <code>/admin/export/informasi-dikecualikan/pdf</code></td><td class="data">—</td><td class="harap">PDF DIK terunduh</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">83</td><td class="kode">N-05</td><td class="modul">Export Statistik Excel</td><td class="skenario">Statistik CSV</td><td class="langkah">GET <code>/admin/export/statistik/excel?tahun=2025</code></td><td class="data">tahun</td><td class="harap">CSV terunduh, 12 bulan + total, UTF-8 BOM, kolom 7</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">84</td><td class="kode">N-06</td><td class="modul">Export Statistik PDF</td><td class="skenario">Statistik PDF landscape</td><td class="langkah">GET <code>/admin/export/statistik/pdf?tahun=2025</code></td><td class="data">tahun</td><td class="harap">PDF rekap 12 bulan + total, kolom tanpa bold berlebihan</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">85</td><td class="kode">N-07</td><td class="modul">Export Permohonan Excel</td><td class="skenario">Permohonan CSV filter status</td><td class="langkah">GET <code>/admin/export/permohonan/excel?status=Selesai&search=...</code></td><td class="data">status, search</td><td class="harap">CSV 15 kolom, filter dihormati, NIK/WA dengan petik ' agar tidak hilang 0</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">86</td><td class="kode">N-08</td><td class="modul">Export Permohonan PDF</td><td class="skenario">Permohonan PDF landscape</td><td class="langkah">GET <code>/admin/export/permohonan/pdf</code></td><td class="data">—</td><td class="harap">PDF landscape, tanpa bold pada Nama & Status</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">87</td><td class="kode">N-09</td><td class="modul">Export Keberatan Excel</td><td class="skenario">Keberatan CSV</td><td class="langkah">GET <code>/admin/export/keberatan/excel</code></td><td class="data">—</td><td class="harap">CSV 9 kolom, relasi permohonan tampil</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">88</td><td class="kode">N-10</td><td class="modul">Export Keberatan PDF</td><td class="skenario">Keberatan PDF landscape</td><td class="langkah">GET <code>/admin/export/keberatan/pdf</code></td><td class="data">—</td><td class="harap">PDF landscape tanpa bold Nama/Status</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

                <!-- O -->
                <tr class="group"><td colspan="10">O — UMUM: UI, KEAMANAN & KETAHANAN</td></tr>
                <tr><td class="no">89</td><td class="kode">O-01</td><td class="modul">Toast & Validasi</td><td class="skenario">Notifikasi 3.5 dtk</td><td class="langkah">Trigger success/error/validation apapun</td><td class="data">—</td><td class="harap">Toast muncul kanan atas, hilang otomatis ±3.5 dtk, animasi slide</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">90</td><td class="kode">O-02</td><td class="modul">Sidebar Admin</td><td class="skenario">Toggle sidebar & backdrop</td><td class="langkah">Klik hamburger (desktop geser, mobile overlay + blur)</td><td class="data">—</td><td class="harap">Sidebar toggle mulus, backdrop mobile muncul, body lock scroll saat open</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">91</td><td class="kode">O-03</td><td class="modul">Keamanan — Auth Guard</td><td class="skenario">Coba akses admin via URL langsung tanpa login</td><td class="langkah">Akses <code>/admin/permohonan/1</code> tanpa session</td><td class="data">—</td><td class="harap">Ditolak, redirect login, tidak bocor data</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">92</td><td class="kode">O-04</td><td class="modul">Keamanan — CSRF & File</td><td class="skenario">CSRF & path traversal</td><td class="langkah">Coba POST tanpa CSRF, coba <code>../</code> di file param</td><td class="data">—</td><td class="harap">419 CSRF mismatch, traversal diblok 404</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>
                <tr><td class="no">93</td><td class="kode">O-05</td><td class="modul">Responsif</td><td class="skenario">Uji 360px — 1920px</td><td class="langkah">Resize viewport, cek tabel horizontal scroll, grid footer, kartu DIP</td><td class="data">—</td><td class="harap">Tidak ada layout pecah, tabel scroll-x, radius card 0.375/0.5rem konsisten</td><td class="kosong"></td><td class="cek">☐ ✓ &nbsp; ☐ ✗</td><td class="paraf"></td></tr>

            </tbody>
        </table>
        </div>

        <div class="hint" style="margin-top:10px">
            <b>Catatan penguji:</b> Tuliskan temuan / bug / saran singkat di kolom <b>Hasil Aktual</b> bila status ✗. Contoh: "Filter tahun tidak bereaksi", "Toast tidak hilang", "PDF kolom terpotong di A4".
        </div>
    </div>
</div>

<!-- REKAP -->
<div class="sheet">
    <div class="section">
        <h4>3 &nbsp; Rekapitulasi Hasil Uji</h4>
        <div class="tbl-wrap" style="min-width:0">
        <table style="min-width:0">
            <thead><tr><th style="width:40%">Kategori Modul</th><th>Jumlah Kasus</th><th>Berhasil (✓)</th><th>Gagal (✗)</th><th>Tidak Diuji (—)</th><th>Paraf</th></tr></thead>
            <tbody>
                <tr><td>A — Beranda & Navigasi</td><td style="text-align:center">8</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>B — Katalog Informasi Publik</td><td style="text-align:center">11</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>C — Permohonan Informasi</td><td style="text-align:center">7</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>D — Pengajuan Keberatan</td><td style="text-align:center">5</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>E — Lacak Tiket</td><td style="text-align:center">4</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>F — Tata Cara/Regulasi/Profil/FAQ/Statistik</td><td style="text-align:center">5</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>G — Auth Admin</td><td style="text-align:center">6</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>H — Admin Informasi Publik</td><td style="text-align:center">9</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>I — Admin Informasi Dikecualikan</td><td style="text-align:center">3</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>J — Admin Permohonan</td><td style="text-align:center">6</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>K — Admin Keberatan</td><td style="text-align:center">4</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>L — Admin Profil/FAQ/Regulasi/Tata Cara</td><td style="text-align:center">6</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>M — Admin Statistik</td><td style="text-align:center">4</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>N — Export Excel/PDF</td><td style="text-align:center">10</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr><td>O — Umum UI/Keamanan/Responsif</td><td style="text-align:center">5</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
                <tr style="background:#f1f5f9;font-weight:800"><td>TOTAL</td><td style="text-align:center">93</td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td><td class="kosong"></td></tr>
            </tbody>
        </table>
        </div>

        <div class="hint" style="margin-top:10px">Persentase keberhasilan = (Berhasil / Total Diuji) × 100%. Target kelulusan: ≥ 90% kasus Berhasil untuk sidang.</div>
    </div>
</div>

<!-- SIGN -->
<div class="sheet">
    <div class="section">
        <h4>4 &nbsp; Pengesahan</h4>
        <p style="font-size:10px;color:#475569;margin-bottom:10px">Dengan menandatangani di bawah ini, pihak penguji menyatakan telah melakukan pengujian black box sesuai skenario di atas dan hasilnya dicatat dengan sebenarnya.</p>
        <div class="sign-grid">
            <div class="sign-box">
                <div class="role">Penguji I — Dosen Pembimbing / Penguji</div>
                <div style="font-size:10px;color:#64748b;margin-top:6px">Nama terang:</div>
                <div class="name"></div>
                <div class="sig">Tanda tangan & stempel</div>
                <div style="font-size:9px;color:#64748b;margin-top:6px">Tanggal: ____ / ____ / {{ $tahun }}</div>
            </div>
            <div class="sign-box">
                <div class="role">Penguji II — Dosen Penguji (jika ada)</div>
                <div style="font-size:10px;color:#64748b;margin-top:6px">Nama terang:</div>
                <div class="name"></div>
                <div class="sig">Tanda tangan</div>
                <div style="font-size:9px;color:#64748b;margin-top:6px">Tanggal: ____ / ____ / {{ $tahun }}</div>
            </div>
            <div class="sign-box">
                <div class="role">Mahasiswa / Pengembang</div>
                <div style="font-size:10px;color:#64748b;margin-top:6px">Nama terang:</div>
                <div class="name"></div>
                <div class="sig">Tanda tangan</div>
                <div style="font-size:9px;color:#64748b;margin-top:6px">Tanggal: ____ / ____ / {{ $tahun }}</div>
            </div>
        </div>

        <div class="footer-meta">
            <span>Dokumen ini dicetak dari sistem PPID FMIPA Unila — <code>/dokumen/blackbox-testing</code> — {{ date('d/m/Y H:i') }}</span>
            <span>Halaman 1 dari 1 — Cetak landscape A4, skala 85–90% jika terpotong</span>
        </div>
    </div>
</div>

<div class="sheet no-print" style="padding:12px 18px;display:flex;justify-content:center">
    <button class="btn btn-print" onclick="window.print()">🖨️ Cetak / Simpan sebagai PDF</button>
</div>

</body>
</html>
