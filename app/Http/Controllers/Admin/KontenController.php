<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    private static $filePath = 'beranda_konten.json';

    /**
     * Helper mengambil daftar Tanya Jawab (FAQ)
     */
    public static function getFaqs(): array
    {
        if (Storage::disk('local')->exists(self::$filePath)) {
            $data = json_decode(Storage::disk('local')->get(self::$filePath), true);
            if (is_array($data) && isset($data['faq'])) {
                return $data['faq'];
            }
        }

        // Data default FAQ jika belum tersimpan
        return [
            ['id' => 1, 'pertanyaan' => 'Berapa biaya pengajuan permohonan informasi publik di PPID FMIPA Unila?', 'jawaban' => 'Layanan permohonan informasi publik di PPID FMIPA Universitas Lampung adalah GRATIS (tidak dipungut biaya). Namun apabila pemohon memerlukan salinan cetak atau pengiriman fisik melalui pos, biaya fotokopi dan ongkos kirim ditanggung oleh pemohon sesuai ketentuan perundang-undangan.'],
            ['id' => 2, 'pertanyaan' => 'Berapa lama jangka waktu penyelesaian permohonan informasi?', 'jawaban' => 'Sesuai amanat UU No. 14 Tahun 2008, PPID FMIPA Unila wajib memberikan pemberitahuan tertulis paling lambat 10 (sepuluh) hari kerja sejak permohonan dinyatakan lengkap. Jangka waktu ini dapat diperpanjang paling lama 7 (tujuh) hari kerja berikutnya dengan disertai alasan tertulis.'],
            ['id' => 3, 'pertanyaan' => 'Apa saja syarat untuk mengajukan permohonan informasi?', 'jawaban' => "Pemohon wajib memiliki akun terdaftar dan melampirkan identitas resmi:\n- Melengkapi identitas resmi sesuai formulir permohonan.\n- Menyebutkan tujuan penggunaan informasi secara jelas dan tidak bertentangan dengan hukum."],
            ['id' => 4, 'pertanyaan' => 'Kapan pemohon dapat mengajukan keberatan?', 'jawaban' => 'Keberatan dapat diajukan jika: permohonan informasi ditolak tanpa alasan yang sah, informasi tidak diberikan dalam batas waktu yang ditentukan, biaya yang dikenakan tidak wajar, atau informasi yang diterima tidak sesuai dengan permohonan. Keberatan diajukan kepada Atasan PPID paling lambat 30 hari kerja.']
        ];
    }

    /**
     * Helper mengambil data Profil PPID Pelaksana
     */
    public static function getProfil(): array
    {
        $defaultProfil = [
            'nama'            => 'Aristoeteles',
            'jabatan'         => 'Kasubag TU / PIC PPID Pelaksana',
            'foto'            => null,
            'dasar_penetapan' => 'Dasar penetapan mengikuti SK Rektor Universitas Lampung tentang PPID (lihat Regulasi).',
            'tugas_fungsi'    => 'Mengelola, menyediakan, dan melayani informasi publik di lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam; menyusun Daftar Informasi Publik unit; melayani permohonan dan keberatan; serta melaporkan layanan kepada PPID Utama Universitas Lampung.',
            'email'           => 'ppid.fmipa@unila.ac.id',
            'whatsapp'        => '6281320178069',
        ];

        if (Storage::disk('local')->exists(self::$filePath)) {
            $data = json_decode(Storage::disk('local')->get(self::$filePath), true);
            if (is_array($data) && isset($data['profil']) && is_array($data['profil'])) {
                return array_merge($defaultProfil, $data['profil']);
            }
        }

        return $defaultProfil;
    }

    /**
     * Helper mengambil daftar Regulasi
     */
    public static function getRegulasi(): array
    {
        if (Storage::disk('local')->exists(self::$filePath)) {
            $data = json_decode(Storage::disk('local')->get(self::$filePath), true);
            if (is_array($data) && isset($data['regulasi']) && is_array($data['regulasi'])) {
                return $data['regulasi'];
            }
        }

        return [
            ['id' => 1, 'kategori' => 'nasional', 'badge' => 'Undang-Undang', 'tahun' => '2008', 'judul' => 'Undang-Undang No. 14 Tahun 2008', 'deskripsi' => 'Tentang Keterbukaan Informasi Publik (UU KIP) — Payung hukum utama yang menjamin hak warga negara untuk memperoleh informasi publik.', 'sumber' => 'Dokumen JDIH BPK', 'url' => 'https://peraturan.bpk.go.id/Details/39047/uu-no-14-tahun-2008'],
            ['id' => 2, 'kategori' => 'nasional', 'badge' => 'Peraturan Pemerintah', 'tahun' => '2010', 'judul' => 'Peraturan Pemerintah No. 61 Tahun 2010', 'deskripsi' => 'Tentang Pelaksanaan Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik.', 'sumber' => 'Dokumen JDIH BPK', 'url' => 'https://peraturan.bpk.go.id/Details/5048/pp-no-61-tahun-2010'],
            ['id' => 3, 'kategori' => 'nasional', 'badge' => 'Peraturan Komisi Informasi', 'tahun' => '2021', 'judul' => 'Perki No. 1 Tahun 2021', 'deskripsi' => 'Tentang Standar Layanan Informasi Publik (SLIP) — Mengatur klasifikasi, tata kelola, dan prosedur teknis layanan informasi oleh Badan Publik.', 'sumber' => 'Komisi Informasi Pusat', 'url' => 'https://ppid.unila.ac.id/peraturan-tentang-keterbukaan-informasi-publik/'],
            ['id' => 4, 'kategori' => 'nasional', 'badge' => 'Kompilasi Regulasi', 'tahun' => 'Kumpulan', 'judul' => 'Peraturan tentang Keterbukaan Informasi Publik', 'deskripsi' => 'Kompilasi peraturan terkait keterbukaan informasi publik yang dihimpun dan dipublikasikan pada portal PPID Universitas Lampung.', 'sumber' => 'PPID Universitas Lampung', 'url' => 'https://ppid.unila.ac.id/peraturan-tentang-keterbukaan-informasi-publik/'],
            ['id' => 5, 'kategori' => 'internal', 'badge' => 'Peraturan Rektor', 'tahun' => 'Universitas Lampung', 'judul' => 'Peraturan Rektor tentang Keterbukaan Informasi Publik', 'deskripsi' => 'Ketentuan dan pedoman pelaksanaan keterbukaan informasi publik serta tata kelola dokumen di lingkungan Universitas Lampung.', 'sumber' => 'PPID Universitas Lampung', 'url' => 'https://ppid.unila.ac.id/peraturan-rektor-tentang-keterbukaan-informasi-publik/'],
            ['id' => 6, 'kategori' => 'internal', 'badge' => 'Keputusan Rektor (SK)', 'tahun' => 'Universitas Lampung', 'judul' => 'SK PPID Universitas Lampung', 'deskripsi' => 'Surat Keputusan Rektor Universitas Lampung tentang Penetapan Pejabat Pengelola Informasi dan Dokumentasi (PPID) Utama dan PPID Pelaksana.', 'sumber' => 'PPID Universitas Lampung', 'url' => 'https://ppid.unila.ac.id/sk-ppid/'],
            ['id' => 7, 'kategori' => 'internal', 'badge' => 'Indeks Lengkap', 'tahun' => 'Portal Utama', 'judul' => 'Indeks Lengkap Regulasi PPID Universitas Lampung', 'deskripsi' => 'Akses katalog menyeluruh regulasi, SOP, maklumat pelayanan, dan pedoman tata kelola KIP di tingkat Universitas Lampung.', 'sumber' => 'ppid.unila.ac.id/regulasi/', 'url' => 'https://ppid.unila.ac.id/regulasi/'],
        ];
    }

    /**
     * Helper mengambil data konten lengkap halaman Profil PPID
     */
    public static function getHalamanProfil(): array
    {
        $default = [
            'hero_judul'     => 'Profil PPID Pelaksana FMIPA',
            'hero_deskripsi' => 'Mengenal lebih dekat Pejabat Pengelola Informasi dan Dokumentasi FMIPA Universitas Lampung — unit layanan keterbukaan informasi publik, dasar hukum, struktur organisasi, tugas dan fungsi, hingga standar pelayanan.',
            'tentang_judul'  => 'Apa itu PPID?',
            'tentang_p1'     => 'Pejabat Pengelola Informasi dan Dokumentasi (PPID) adalah pejabat yang bertanggung jawab di bidang penyimpanan, pendokumentasian, penyediaan, dan pelayanan informasi di badan publik.',
            'tentang_p2'     => 'PPID FMIPA Universitas Lampung dibentuk untuk mewujudkan komitmen keterbukaan informasi publik sesuai amanat Undang-Undang Nomor 14 Tahun 2008. Kami melayani sivitas akademika dan masyarakat umum dalam memperoleh informasi publik yang berkualitas.',
            'visi'           => 'Mewujudkan FMIPA Universitas Lampung sebagai institusi yang transparan, akuntabel, dan partisipatif dalam pengelolaan informasi publik yang berkualitas sesuai prinsip Good University Governance.',
            'misi'           => [
                ['judul' => 'Penyediaan Informasi', 'deskripsi' => 'Menyediakan dan melayani informasi publik secara cepat, tepat, dan akurat.'],
                ['judul' => 'Pelayanan Prima', 'deskripsi' => 'Ramah, profesional, dan mudah diakses semua pemangku kepentingan.'],
                ['judul' => 'Digitalisasi Dokumen', 'deskripsi' => 'Transformasi digital pengelolaan dan penyebaran informasi.'],
                ['judul' => 'Peningkatan Kapasitas', 'deskripsi' => 'Pelatihan dan evaluasi SDM pengelola informasi berkelanjutan.'],
            ],
            'maklumat_quote' => 'Memberikan pelayanan informasi publik sebaik-baiknya — cepat, tepat waktu, gratis, dan sederhana sesuai peraturan perundang-undangan.',
            'standar_pelayanan' => [
                ['label' => 'Jenis layanan', 'isi' => 'Permohonan Informasi & Dokumentasi Publik'],
                ['label' => 'Jam layanan', 'isi' => 'Senin – Jumat, 08:00 – 16:00 WIB'],
                ['label' => 'Biaya', 'isi' => 'GRATIS'],
                ['label' => 'Waktu selesai', 'isi' => '10 hari kerja (+7 hari perpanjangan)'],
                ['label' => 'Produk', 'isi' => 'Salinan hardcopy & softcopy'],
                ['label' => 'Dasar hukum', 'isi' => 'UU No. 14 Tahun 2008 tentang KIP'],
                ['label' => 'Sarana', 'isi' => 'Ruang layanan, komputer, internet, formulir digital'],
                ['label' => 'Kompetensi', 'isi' => 'Paham UU KIP & SOP layanan'],
            ],
            'struktur_judul'     => 'Struktur Organisasi',
            'struktur_deskripsi' => 'Tim profesional yang berdedikasi melayani dan mendokumentasikan informasi publik',
            'struktur_atasan'    => ['jabatan' => 'Dekan FMIPA', 'peran' => 'Atasan PPID'],
            'struktur_ketua'     => ['jabatan' => 'Wakil Dekan Bidang Umum dan Keuangan', 'peran' => 'Ketua PPID Pelaksana'],
            'struktur_bidang'    => [
                ['jabatan' => 'Layanan Informasi', 'peran' => 'Front office & helpdesk'],
                ['jabatan' => 'Dokumentasi & Arsip', 'peran' => 'Klasifikasi & retensi'],
                ['jabatan' => 'Sengketa & Keberatan', 'peran' => 'Mediasi & adjudikasi'],
                ['jabatan' => 'TI & Publikasi', 'peran' => 'Portal & media'],
            ]
        ];

        if (Storage::disk('local')->exists(self::$filePath)) {
            $data = json_decode(Storage::disk('local')->get(self::$filePath), true);
            if (is_array($data) && isset($data['halaman_profil']) && is_array($data['halaman_profil'])) {
                $merged = array_merge($default, $data['halaman_profil']);
                if (isset($data['halaman_profil']['struktur_bidang'])) $merged['struktur_bidang'] = $data['halaman_profil']['struktur_bidang'];
                if (isset($data['halaman_profil']['struktur_atasan'])) $merged['struktur_atasan'] = $data['halaman_profil']['struktur_atasan'];
                if (isset($data['halaman_profil']['struktur_ketua'])) $merged['struktur_ketua'] = $data['halaman_profil']['struktur_ketua'];
                return $merged;
            }
        }

        return $default;
    }

    /**
     * Simpan pembaruan data Profil PPID & Konten Halaman
     */
    public function updateProfil(Request $request)
    {
        // Validasi Profil Pejabat
        $request->validate([
            'nama'            => 'nullable|string|max:150',
            'gelar_depan'     => 'nullable|string|max:50',
            'nama_lengkap'    => 'nullable|string|max:150',
            'gelar_belakang'  => 'nullable|string|max:50',
            'jabatan'         => 'nullable|string|max:200',
            'foto'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'email'           => 'required|email|max:150',
            'whatsapp'        => 'required|string|max:30',
            'tugas_fungsi'    => 'nullable|string|max:1000',
            'wakil_nama'      => 'nullable|string|max:150',
            'wakil_gelar_depan'    => 'nullable|string|max:50',
            'wakil_nama_lengkap'   => 'nullable|string|max:150',
            'wakil_gelar_belakang' => 'nullable|string|max:50',
            // Validasi Halaman Profil
            'hero_judul'      => 'nullable|string|max:200',
            'hero_deskripsi'  => 'nullable|string|max:500',
            'tentang_judul'   => 'nullable|string|max:200',
            'tentang_isi'     => 'nullable|string|max:3000',
            'tentang_p1'      => 'nullable|string|max:1000',
            'tentang_p2'      => 'nullable|string|max:1000',
            'visi'            => 'required|string|max:1000',
            'maklumat_quote'  => 'required|string|max:500',
        ]);

        $profil = self::getProfil();

        // Kepala PPID - Format Nama
        $gelarDepan = trim($request->input('gelar_depan', ''));
        $namaLengkap = trim($request->input('nama_lengkap', ''));
        $gelarBelakang = trim($request->input('gelar_belakang', ''));

        $profil['gelar_depan'] = $gelarDepan;
        $profil['nama_lengkap'] = $namaLengkap;
        $profil['gelar_belakang'] = $gelarBelakang;

        if (!empty($namaLengkap)) {
            $formattedNama = $namaLengkap;
            if (!empty($gelarDepan)) {
                $formattedNama = $gelarDepan . ' ' . $formattedNama;
            }
            if (!empty($gelarBelakang)) {
                $formattedNama = $formattedNama . ', ' . $gelarBelakang;
            }
            $profil['nama'] = $formattedNama;
        } elseif ($request->filled('nama')) {
            $profil['nama'] = trim($request->input('nama'));
        }

        // Wakil Kepala PPID - Format Nama
        $wGelarDepan = trim($request->input('wakil_gelar_depan', ''));
        $wNamaLengkap = trim($request->input('wakil_nama_lengkap', ''));
        $wGelarBelakang = trim($request->input('wakil_gelar_belakang', ''));

        $profil['wakil_gelar_depan'] = $wGelarDepan;
        $profil['wakil_nama_lengkap'] = $wNamaLengkap;
        $profil['wakil_gelar_belakang'] = $wGelarBelakang;

        if (!empty($wNamaLengkap)) {
            $formattedWakil = $wNamaLengkap;
            if (!empty($wGelarDepan)) {
                $formattedWakil = $wGelarDepan . ' ' . $formattedWakil;
            }
            if (!empty($wGelarBelakang)) {
                $formattedWakil = $formattedWakil . ', ' . $wGelarBelakang;
            }
            $profil['wakil_nama'] = $formattedWakil;
        } elseif ($request->filled('wakil_nama')) {
            $profil['wakil_nama'] = trim($request->input('wakil_nama'));
        }

        if ($request->filled('jabatan')) {
            $profil['jabatan'] = trim($request->input('jabatan'));
        } elseif ($request->filled('struktur_atasan_jabatan')) {
            $profil['jabatan'] = trim($request->input('struktur_atasan_jabatan'));
        }
        $profil['email'] = trim($request->input('email'));
        $profil['whatsapp'] = preg_replace('/[^0-9]/', '', trim($request->input('whatsapp')));
        if ($request->has('tugas_fungsi')) {
            $profil['tugas_fungsi'] = trim($request->input('tugas_fungsi'));
        }

        if ($request->hasFile('foto')) {
            if (!empty($profil['foto']) && Storage::disk('public')->exists($profil['foto'])) {
                Storage::disk('public')->delete($profil['foto']);
            }
            $profil['foto'] = $request->file('foto')->store('profil-ppid', 'public');
        }

        if ($request->boolean('hapus_foto')) {
            if (!empty($profil['foto']) && Storage::disk('public')->exists($profil['foto'])) {
                Storage::disk('public')->delete($profil['foto']);
            }
            $profil['foto'] = null;
        }

        $existingHalaman = self::getHalamanProfil();

        // Proses input Tentang PPID (1 input, pisahkan per enter)
        $tentangIsi = trim($request->input('tentang_isi', ''));
        $tentangParas = array_values(array_filter(array_map('trim', preg_split('/\r\n\r\n|\n\n|\r\r|\n/', $tentangIsi))));

        // Simpan Konten Halaman
        $halaman = [
            'hero_judul'     => $request->filled('hero_judul') ? trim($request->input('hero_judul')) : ($existingHalaman['hero_judul'] ?? 'Profil PPID Pelaksana FMIPA'),
            'hero_deskripsi' => $request->filled('hero_deskripsi') ? trim($request->input('hero_deskripsi')) : ($existingHalaman['hero_deskripsi'] ?? 'Mengenal lebih dekat Pejabat Pengelola Informasi dan Dokumentasi FMIPA Universitas Lampung — unit layanan keterbukaan informasi publik, dasar hukum, struktur organisasi, tugas dan fungsi, hingga standar pelayanan.'),
            'tentang_judul'  => trim($request->input('tentang_judul', 'Apa itu PPID?')),
            'tentang_isi'    => $tentangIsi,
            'tentang_p1'     => $tentangParas[0] ?? trim($request->input('tentang_p1', '')),
            'tentang_p2'     => $tentangParas[1] ?? trim($request->input('tentang_p2', '')),
            'tentang_paragraf' => $tentangParas,
            'visi'           => trim($request->input('visi')),
            'maklumat_quote' => trim($request->input('maklumat_quote')),
        ];

        // Struktur Organisasi
        if ($request->filled('struktur_judul')) $halaman['struktur_judul'] = trim($request->input('struktur_judul'));
        if ($request->filled('struktur_deskripsi')) $halaman['struktur_deskripsi'] = trim($request->input('struktur_deskripsi'));
        $halaman['struktur_atasan'] = ['jabatan' => trim($request->input('struktur_atasan_jabatan') ?? 'Dekan FMIPA'), 'peran' => trim($request->input('struktur_atasan_peran') ?? 'Atasan PPID')];
        $halaman['struktur_ketua']  = ['jabatan' => trim($request->input('struktur_ketua_jabatan') ?? 'Ketua PPID Pelaksana'), 'peran' => trim($request->input('struktur_ketua_peran') ?? 'Wakil Dekan')];
        if ($request->has('struktur_bidang_nama') || $request->has('struktur_bidang_jabatan')) {
            $bidang = [];
            $namas = $request->input('struktur_bidang_nama', []);
            $jabatans = $request->input('struktur_bidang_jabatan', []);
            $perans = $request->input('struktur_bidang_peran', []);
            $totalItems = max(count($namas), count($jabatans));

            for ($i = 0; $i < $totalItems; $i++) {
                $nama = trim($namas[$i] ?? '');
                $jabatan = trim($jabatans[$i] ?? ($perans[$i] ?? ''));
                if (!empty($nama) || !empty($jabatan)) {
                    $bidang[] = [
                        'nama'    => $nama ?: $jabatan,
                        'jabatan' => $jabatan,
                        'peran'   => $jabatan,
                    ];
                }
            }
            $halaman['struktur_bidang'] = $bidang;
        }

        // Misi (Dynamic List)
        if ($request->has('misi_judul')) {
            $misiArr = [];
            foreach ($request->input('misi_judul') as $idx => $mJudul) {
                if (!empty(trim($mJudul))) {
                    $misiArr[] = [
                        'judul' => trim($mJudul),
                        'deskripsi' => trim($request->input('misi_deskripsi')[$idx] ?? '')
                    ];
                }
            }
            $halaman['misi'] = $misiArr;
        }

        // Standar (Dynamic List)
        if ($request->has('standar_label')) {
            $stdArr = [];
            foreach ($request->input('standar_label') as $idx => $sLabel) {
                if (!empty(trim($sLabel))) {
                    $stdArr[] = [
                        'label' => trim($sLabel),
                        'isi'   => trim($request->input('standar_isi')[$idx] ?? '')
                    ];
                }
            }
            $halaman['standar_pelayanan'] = $stdArr;
        }

        $currentData = [];
        if (Storage::disk('local')->exists(self::$filePath)) {
            $currentData = json_decode(Storage::disk('local')->get(self::$filePath), true) ?: [];
        }
        $currentData['profil'] = $profil;
        $currentData['halaman_profil'] = $halaman;
        
        Storage::disk('local')->put(self::$filePath, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->back()->with('success', 'Profil dan Konten Halaman berhasil diperbarui.');
    }

    /**
     * Helper menyimpan FAQ
     */
    private function saveFaqs(array $faqs): void
    {
        $currentData = [];
        if (Storage::disk('local')->exists(self::$filePath)) {
            $currentData = json_decode(Storage::disk('local')->get(self::$filePath), true) ?: [];
        }
        $currentData['faq'] = $faqs;
        Storage::disk('local')->put(self::$filePath, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function saveRegulasi(array $regulasi): void
    {
        $currentData = [];
        if (Storage::disk('local')->exists(self::$filePath)) {
            $currentData = json_decode(Storage::disk('local')->get(self::$filePath), true) ?: [];
        }
        $currentData['regulasi'] = $regulasi;
        Storage::disk('local')->put(self::$filePath, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Helper mengambil data Tata Cara Permohonan & Keberatan
     */
    public static function getTataCara(): array
    {
        $default = [
            'permohonan_langkah' => [
                ['judul' => 'Pengisian Formulir Permohonan', 'deskripsi' => 'Isi formulir permohonan secara online melalui portal PPID FMIPA atau datang langsung ke meja layanan PPID dengan melampirkan salinan identitas resmi (KTP / Paspor / Akta Pendirian bagi Badan Hukum) serta rincian informasi yang dibutuhkan.'],
                ['judul' => 'Registrasi & Penerimaan Nomor Tiket', 'deskripsi' => 'Petugas PPID memeriksa kelengkapan file pemohon, mencatat permohonan ke dalam buku register, dan memberikan nomor registrasi/nomor tiket unik untuk pelacakan.'],
                ['judul' => 'Pemrosesan & Jawaban Resmi (10 + 7 Hari)', 'deskripsi' => 'PPID memberikan tanggapan resmi paling lambat 10 hari kerja sejak permohonan dinyatakan lengkap, dan dapat diperpanjang maksimal 7 hari kerja dengan pemberitahuan tertulis sebelumnya kepada pemohon.'],
                ['judul' => 'Penyerahan Dokumen Informasi', 'deskripsi' => 'Informasi diberikan sesuai bentuk atau format yang diminta pemohon (salinan digital atau cetak). Layanan informasi tidak dipungut biaya; biaya penggandaan/pengiriman (bila ada) dibebankan kepada pemohon sesuai standar biaya yang berlaku.'],
            ],
            'keberatan_langkah' => [
                ['judul' => 'Pengajuan Keberatan oleh Pemohon', 'deskripsi' => 'Keberatan diajukan secara tertulis (online melalui portal atau langsung) paling lambat 30 hari kerja setelah diterimanya tanggapan atau setelah terlewatinya batas waktu pemberian jawaban oleh PPID.'],
                ['judul' => 'Pemberian Alasan Keberatan yang Sah', 'deskripsi' => 'Keberatan dapat didasari alasan: penolakan atas permohonan, informasi berkala tidak disediakan, permohonan tidak ditanggapi, permintaan tidak dipenuhi sebagaimana mestinya, pengenaan biaya yang tidak wajar, atau penyampaian informasi melebihi batas waktu.'],
                ['judul' => 'Tanggapan oleh Atasan PPID (30 Hari)', 'deskripsi' => 'Atasan PPID (Rektor Universitas Lampung) memberikan tanggapan tertulis atas keberatan paling lambat 30 hari kerja sejak permohonan keberatan diterima secara lengkap.'],
                ['judul' => 'Penyelesaian Sengketa Informasi (14 Hari)', 'deskripsi' => 'Apabila pemohon tidak puas dengan keputusan tanggapan keberatan dari Atasan PPID, pemohon dapat mengajukan permohonan penyelesaian Sengketa Informasi Publik ke Komisi Informasi paling lambat 14 hari kerja sejak diterimanya tanggapan tertulis.'],
            ],
        ];

        if (Storage::disk('local')->exists(self::$filePath)) {
            $data = json_decode(Storage::disk('local')->get(self::$filePath), true);
            if (is_array($data) && isset($data['tata_cara']) && is_array($data['tata_cara'])) {
                $merged = array_merge($default, $data['tata_cara']);
                if (empty($merged['permohonan_langkah']) || !is_array($merged['permohonan_langkah'])) {
                    $merged['permohonan_langkah'] = $default['permohonan_langkah'];
                }
                if (empty($merged['keberatan_langkah']) || !is_array($merged['keberatan_langkah'])) {
                    $merged['keberatan_langkah'] = $default['keberatan_langkah'];
                }
                return $merged;
            }
        }

        return $default;
    }

    private function saveTataCara(array $tataCara): void
    {
        $currentData = [];
        if (Storage::disk('local')->exists(self::$filePath)) {
            $currentData = json_decode(Storage::disk('local')->get(self::$filePath), true) ?: [];
        }
        $currentData['tata_cara'] = $tataCara;
        Storage::disk('local')->put(self::$filePath, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Tampilan Manajemen Profil PPID & Tanya Jawab (FAQ) digabung — redirect legacy
     */
    public function index()
    {
        return redirect()->route('admin.profil.index');
    }

    /**
     * Halaman Kelola Profil PPID Pelaksana (terpisah)
     */
    public function profil()
    {
        return view('admin.profil.index', [
            'profil'  => self::getProfil(),
            'halaman' => self::getHalamanProfil(),
        ]);
    }

    /**
     * Halaman Kelola FAQ (terpisah)
     */
    public function faq()
    {
        return view('admin.faq.index', [
            'faqs' => self::getFaqs()
        ]);
    }

    /**
     * Halaman Kelola Regulasi
     */
    public function regulasi()
    {
        return view('admin.regulasi.index', [
            'regulasi' => self::getRegulasi()
        ]);
    }

    /**
     * Halaman Kelola Tata Cara
     */
    public function tataCara()
    {
        return view('admin.tata_cara.index', [
            'data' => self::getTataCara()
        ]);
    }

    /**
     * Simpan Tata Cara
     */
    public function updateTataCara(Request $request)
    {
        // Hanya langkah yang disimpan — judul/deskripsi fix
        $current = self::getTataCara();
        $new = $current;

        $decodeSteps = function ($key) use ($request) {
            if (!$request->has($key)) return null;
            $val = $request->input($key);
            if (is_string($val)) {
                $decoded = json_decode($val, true);
                if (json_last_error() === JSON_ERROR_NONE) return $decoded;
                return null;
            }
            if (is_array($val)) return $val;
            return null;
        };

        $pLangkah = $decodeSteps('permohonan_langkah');
        if (is_array($pLangkah)) $new['permohonan_langkah'] = array_values(array_filter($pLangkah, fn($s) => !empty(trim($s['judul'] ?? ''))));

        $kLangkah = $decodeSteps('keberatan_langkah');
        if (is_array($kLangkah)) $new['keberatan_langkah'] = array_values(array_filter($kLangkah, fn($s) => !empty(trim($s['judul'] ?? ''))));

        // Bersihkan key lama yang sudah fix
        foreach (['permohonan_badge','permohonan_sla','permohonan_judul','permohonan_deskripsi','keberatan_badge','keberatan_sla','keberatan_judul','keberatan_deskripsi'] as $k) unset($new[$k]);

        $this->saveTataCara($new);

        return redirect()->back()->with('success', 'Tata Cara berhasil diperbarui.');
    }

    /**
     * Tambah FAQ Baru (Maks 5)
     */
    public function storeFaq(Request $request)
    {
        $faqs = self::getFaqs();
        
        if (count($faqs) >= 5) {
            return redirect()->back()->with('error', 'Batas maksimal FAQ adalah 5 pertanyaan.');
        }

        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban'    => 'required|string'
        ]);

        $maxId = count($faqs) > 0 ? max(array_column($faqs, 'id')) : 0;

        $faqs[] = [
            'id'         => $maxId + 1,
            'pertanyaan' => trim($request->input('pertanyaan')),
            'jawaban'    => trim($request->input('jawaban'))
        ];

        $this->saveFaqs(array_values($faqs));

        return redirect()->back()->with('success', 'Pertanyaan FAQ baru berhasil ditambahkan.');
    }

    /**
     * Hapus FAQ
     */
    public function destroyFaq($id)
    {
        $faqs = self::getFaqs();
        $filtered = array_values(array_filter($faqs, fn($item) => (int)($item['id'] ?? 0) !== (int)$id));
        $this->saveFaqs($filtered);

        return redirect()->back()->with('success', 'Pertanyaan FAQ berhasil dihapus.');
    }

    /**
     * Tambah Regulasi Baru
     */
    public function storeRegulasi(Request $request)
    {
        $request->validate([
            'kategori'  => 'required|in:nasional,internal',
            'judul'     => 'required|string|max:200',
            'deskripsi' => 'required|string|max:1000',
            'url'       => 'required|url|max:500',
        ]);

        $regulasi = self::getRegulasi();
        $maxId = count($regulasi) > 0 ? max(array_column($regulasi, 'id')) : 0;

        $regulasi[] = [
            'id'        => $maxId + 1,
            'kategori'  => $request->input('kategori'),
            'badge'     => $request->input('kategori') === 'nasional' ? 'Peraturan Nasional' : 'Regulasi Internal',
            'tahun'     => date('Y'),
            'judul'     => trim($request->input('judul')),
            'deskripsi' => trim($request->input('deskripsi')),
            'sumber'    => 'PPID FMIPA',
            'url'       => trim($request->input('url')),
        ];

        $this->saveRegulasi(array_values($regulasi));

        return redirect()->back()->with('success', 'Regulasi berhasil ditambahkan.');
    }

    /**
     * Hapus Regulasi
     */
    public function destroyRegulasi($id)
    {
        $regulasi = self::getRegulasi();
        $filtered = array_values(array_filter($regulasi, fn($item) => (int)($item['id'] ?? 0) !== (int)$id));
        $this->saveRegulasi($filtered);

        return redirect()->back()->with('success', 'Regulasi berhasil dihapus.');
    }
}
