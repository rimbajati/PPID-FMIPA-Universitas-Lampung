# Product Requirement Document (PRD)
## Sistem Informasi PPID FMIPA Universitas Lampung

---

### 1. Ringkasan Eksekutif (Executive Summary)
**Sistem Informasi Pejabat Pengelola Informasi dan Dokumentasi (PPID) FMIPA Universitas Lampung** adalah platform berbasis web yang dirancang untuk memfasilitasi transparansi publik, keterbukaan informasi, serta kemudahan layanan pengajuan informasi dan keberatan bagi masyarakat/civitas akademika sesuai dengan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.

---

### 2. Sasaran & Pengguna Target (Target Audience / Users)
Sistem ini melayani 2 aktor/peran utama:

1. **Masyarakat / Pemohon Informasi (Public Users)**
   - **Masyarakat Umum / Mahasiswa / Peneliti**: Mencari dokumen publik, mengajukan permohonan informasi baru, melacak status permohonan, dan mengajukan keberatan jika permohonan ditolak/tidak direspons.
2. **Admin / Pengelola PPID (Internal Staff)**
   - **Admin PPID FMIPA**: Mempublikasikan katalog informasi publik, memverifikasi & memproses permohonan masuk, memberikan tanggapan/file jawaban, serta mengelola pengajuan keberatan.

---

### 3. Arsitektur Teknis (Technical Architecture)
- **Framework Backend**: Laravel 10.x (PHP 8.1+)
- **Frontend / View Engine**: Blade Templates + Alpine.js / Dynamic JS + CSS (TailwindCSS / Custom UI)
- **Database**: MySQL / MariaDB
- **Autentikasi**: Laravel Auth Native (Multi-step Registration, Email Verification, Google OAuth SSO)
- **Storage**: Laravel Local File Storage (Protected file serving)

---

### 4. Daftar Fitur & Spesifikasi Modul (Functional Requirements)

#### Modul 1: Autentikasi & Pengelolaan Akun (Authentication & Profile)
* **Login Multi-Role**: Login terpisah untuk Pemohon Publik (Masyarakat/Mahasiswa) dan Admin Panel.
* **Registrasi 3-Tahap (Multi-step Register)**:
  1. *Step 1*: Pengisian email & kata sandi / pilihan login cepat Google OAuth.
  2. *Step 2*: Verifikasi OTP via email.
  3. *Step 3*: Kelengkapan profil pemohon (Nama lengkap, NIK/No Identitas, No HP/WhatsApp, Alamat, Pekerjaan, Upload KTP/Identitas).
* **Lupa & Reset Password**: Pengiriman tautan reset kata sandi aman via email.

#### Modul 2: Katalog Informasi Publik (Public Information Catalog)
* **Kategori Informasi**:
  * Informasi Berkala (Laporan keuangan, program kerja, dll.)
  * Informasi Serta Merta (Informasi darurat/bencana/kejadian penting)
  * Informasi Setiap Saat (SOP, peraturan, struktur organisasi)
  * Informasi Dikecualikan
* **Pencarian & Filter**: Filter berdasarkan kategori, pencarian kata kunci, serta pengurutan tanggal.
* **Viewer Dokumen Safe Serving**: Preview/Unduh berkas informasi publik aman dengan pencatatan otomatis jumlah tayangan (*view counter*).

#### Modul 3: Layanan Permohonan Informasi Publik (Public Information Request)
* **Pengajuan Permohonan (Form Permohonan)**:
  * Pengisian rincian informasi yang dibutuhkan, tujuan penggunaan informasi, serta cara memperoleh/mendapatkan salinan (softcopy/hardcopy).
  * Auto-fill data pemohon dari profil pengguna terautentikasi.
* **Penomoran & Pelacakan Otomatis (Tracking Ticket)**: Generasi nomor tiket/kode registrasi unik untuk setiap permohonan.
* **Status Permohonan**: `diajukan` $\rightarrow$ `diproses` $\rightarrow$ `selesai` (disertai lampiran berkas jawaban) atau `ditolak` (disertai alasan penolakan).

#### Modul 4: Layanan Pengajuan Keberatan (Objection Services)
* **Pengajuan Keberatan Informasi**:
  * Pengajuan keberatan atas permohonan yang ditolak, tidak direspon sesuai batas waktu (10+6 hari kerja), atau biaya yang tidak sesuai.
  * Pemilihan nomor permohonan asal dan pengisian alasan keberatan secara rinci.
* **Status Keberatan**: Alur status seragam dengan permohonan (`diajukan` $\rightarrow$ `diproses` $\rightarrow$ `selesai` atau `ditolak`).
* **Pemroses Keberatan oleh Atasan PPID**:
  * Peninjauan ulang permohonan oleh Admin/Atasan PPID dan pembaharuan status tindak lanjut keberatan.

#### Modul 5: Riwayat & Timeline Layanan Masyarakat (User Dashboard / History)
* **Riwayat Permohonan & Keberatan**: Halaman khusus pemohon untuk memantau status secara real-time.
* **Visual Timeline**: Progress tracker visual mengenai tahap pemrosesan surat/permohonan dari saat diajukan hingga selesai.

#### Modul 6: Panel Manajemen Admin (Admin Management Panel)
* **Dashboard Ringkasan & Statistik**:
  * Card statistik jumlah permohonan masuk, permohonan selesai, diproses, ditolak, serta total keberatan.
* **Manajemen Informasi Publik (CRUD)**:
  * Tambah, edit, hapus, dan hapus masal (*bulk delete*) dokumen informasi publik.
  * Pengunggahan file PDF/dokumen atau penyertaan link eksternal.
* **Manajemen Permohonan Informasi**:
  * Peninjauan detail permohonan dan identitas pemohon.
  * Pembaharuan status permohonan, pengiriman berkas balasan/jawaban, atau memberikan alasan penolakan.
* **Manajemen Pengajuan Keberatan**:
  * Peninjauan dan respon atas keberatan yang diajukan masyarakat.

---

### 5. Kebutuhan Non-Fungsional (Non-Functional Requirements)
* **Keamanan (Security)**:
  * Perlindungan terhadap CSRF dan SQL Injection.
  * Sanitasi dan validasi pengunggahan dokumen identitas (KTP/SIM) dan berkas respon.
  * Pembatasan akses admin dengan middleware `auth` dan `admin`.
* **Kinerja (Performance)**:
  * Responsivitas tinggi pada peranti mobile dan desktop.
  * Pengunggah berkas yang dioptimalkan untuk performa server.
* **Kemudahan Penggunaan (Usability)**:
  * UI modern, ramah pengguna, berstandar aksesibilitas publik dengan skema warna konsisten.

---

### 6. Rencana Pengujian & Verifikasi (Verification & Testing Plan)
1. **Pengujian Alur Autentikasi**: Registrasi multi-step, OTP verification, dan login OAuth.
2. **Pengujian End-to-End Permohonan**: Pengajuan permohonan oleh masyarakat $\rightarrow$ Pemrosesan oleh Admin $\rightarrow$ Pelacakan riwayat & pengunduhan berkas jawaban oleh pemohon.
3. **Pengujian End-to-End Keberatan**: Pengajuan keberatan atas permohonan $\rightarrow$ Pembaharuan status tindak lanjut oleh Admin.
