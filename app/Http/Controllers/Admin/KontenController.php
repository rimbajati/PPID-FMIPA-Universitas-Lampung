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
     * Simpan pembaruan data Profil PPID
     */
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:150',
            'jabatan'         => 'required|string|max:200',
            'foto'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'dasar_penetapan' => 'nullable|string|max:500',
            'tugas_fungsi'    => 'required|string',
            'email'           => 'required|email|max:150',
            'whatsapp'        => 'required|string|max:30',
        ]);

        $profil = self::getProfil();
        $profil['nama'] = trim($request->input('nama'));
        $profil['jabatan'] = trim($request->input('jabatan'));
        $profil['tugas_fungsi'] = trim($request->input('tugas_fungsi'));
        $profil['email'] = trim($request->input('email'));
        $profil['whatsapp'] = preg_replace('/[^0-9]/', '', trim($request->input('whatsapp')));
        if ($request->filled('dasar_penetapan')) {
            $profil['dasar_penetapan'] = trim($request->input('dasar_penetapan'));
        }

        // Upload Foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika tersimpan di disk public
            if (!empty($profil['foto']) && Storage::disk('public')->exists($profil['foto'])) {
                Storage::disk('public')->delete($profil['foto']);
            }
            $path = $request->file('foto')->store('profil-ppid', 'public');
            $profil['foto'] = $path;
        }

        // Hapus foto jika checkbox/permintaan hapus foto dicentang
        if ($request->boolean('hapus_foto')) {
            if (!empty($profil['foto']) && Storage::disk('public')->exists($profil['foto'])) {
                Storage::disk('public')->delete($profil['foto']);
            }
            $profil['foto'] = null;
        }

        // Simpan ke beranda_konten.json
        $currentData = [];
        if (Storage::disk('local')->exists(self::$filePath)) {
            $currentData = json_decode(Storage::disk('local')->get(self::$filePath), true) ?: [];
        }
        $currentData['profil'] = $profil;
        Storage::disk('local')->put(self::$filePath, json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->back()->with('success', 'Profil PPID Pelaksana berhasil diperbarui.');
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
            'header_judul' => 'Tata Cara Permohonan dan Keberatan',
            'header_deskripsi' => 'Panduan komprehensif mengenai prosedur resmi pengajuan permohonan informasi publik, jangka waktu pemenuhan (SLA), mekanisme penyampaian keberatan, hingga penyelesaian sengketa informasi publik di lingkungan FMIPA Universitas Lampung.',
            'permohonan_badge' => 'Langkah Permohonan',
            'permohonan_sla' => '10 Hari Kerja',
            'permohonan_judul' => 'Tata Cara Permohonan Informasi',
            'permohonan_deskripsi' => 'Masyarakat dan badan hukum dapat mengajukan permohonan informasi publik dengan langkah-langkah berikut:',
            'permohonan_langkah' => [
                ['judul' => 'Pengisian Formulir Permohonan', 'deskripsi' => 'Isi formulir permohonan secara online melalui portal PPID FMIPA atau datang langsung ke meja layanan PPID dengan melampirkan salinan identitas resmi (KTP / Paspor / Akta Pendirian bagi Badan Hukum) serta rincian informasi yang dibutuhkan.'],
                ['judul' => 'Registrasi & Penerimaan Nomor Tiket', 'deskripsi' => 'Petugas PPID memeriksa kelengkapan file pemohon, mencatat permohonan ke dalam buku register, dan memberikan nomor registrasi/nomor tiket unik untuk pelacakan.'],
                ['judul' => 'Pemrosesan & Jawaban Resmi (10 + 7 Hari)', 'deskripsi' => 'PPID memberikan tanggapan resmi paling lambat 10 hari kerja sejak permohonan dinyatakan lengkap, dan dapat diperpanjang maksimal 7 hari kerja dengan pemberitahuan tertulis sebelumnya kepada pemohon.'],
                ['judul' => 'Penyerahan Dokumen Informasi', 'deskripsi' => 'Informasi diberikan sesuai bentuk atau format yang diminta pemohon (salinan digital atau cetak). Layanan informasi tidak dipungut biaya; biaya penggandaan/pengiriman (bila ada) dibebankan kepada pemohon sesuai standar biaya yang berlaku.'],
            ],
            'keberatan_badge' => 'Mekanisme Keberatan',
            'keberatan_sla' => '30 Hari Kerja',
            'keberatan_judul' => 'Tata Cara Pengajuan Keberatan',
            'keberatan_deskripsi' => 'Pemohon informasi publik berhak mengajukan keberatan resmi apabila menemui hambatan atau tidak puas atas tanggapan PPID:',
            'keberatan_langkah' => [
                ['judul' => 'Pengajuan Keberatan oleh Pemohon', 'deskripsi' => 'Keberatan diajukan secara tertulis (online melalui portal atau langsung) paling lambat 30 hari kerja setelah diterimanya tanggapan atau setelah terlewatinya batas waktu pemberian jawaban oleh PPID.'],
                ['judul' => 'Pemberian Alasan Keberatan yang Sah', 'deskripsi' => 'Keberatan dapat didasari alasan: penolakan atas permohonan, informasi berkala tidak disediakan, permohonan tidak ditanggapi, permintaan tidak dipenuhi sebagaimana mestinya, pengenaan biaya yang tidak wajar, atau penyampaian informasi melebihi batas waktu.'],
                ['judul' => 'Tanggapan oleh Atasan PPID (30 Hari)', 'deskripsi' => 'Atasan PPID (Rektor Universitas Lampung) memberikan tanggapan tertulis atas keberatan paling lambat 30 hari kerja sejak permohonan keberatan diterima secara lengkap.'],
                ['judul' => 'Penyelesaian Sengketa Informasi (14 Hari)', 'deskripsi' => 'Apabila pemohon tidak puas dengan keputusan tanggapan keberatan dari Atasan PPID, pemohon dapat mengajukan permohonan penyelesaian Sengketa Informasi Publik ke Komisi Informasi paling lambat 14 hari kerja sejak diterimanya tanggapan tertulis.'],
            ],
            'sla_judul' => 'Jangka Waktu Pelayanan (SLA)',
            'sla_items' => [
                'Jawaban Permohonan: Maksimal 10 hari kerja (dapat diperpanjang 7 hari kerja dengan pemberitahuan tertulis).',
                'Tanggapan Keberatan: Maksimal 30 hari kerja sejak keberatan diterima Atasan PPID.',
                'Jam Operasional: Senin–Kamis 08.00–16.00 WIB · Jumat 08.00–16.30 WIB (Istirahat 12.00–13.00 WIB).',
            ],
            'biaya_judul' => 'Standar Biaya Pelayanan',
            'biaya_items' => [
                'Gratis (Tidak Dipungut Biaya): Layanan pencarian data, konsultasi, dan pengiriman informasi format digital via email / portal PPID.',
                'Biaya Penggandaan / Ekspedisi: Bila pemohon meminta salinan fisik/cetak atau kurir pos, biaya dibebankan kepada pemohon sesuai standar biaya yang ditetapkan.',
            ],
            'biaya_link_text' => 'Pelajari Standar Biaya Layanan Informasi Unila →',
            'biaya_link_url' => 'https://ppid.unila.ac.id/standar-biaya-pelayanan-informasi-publik/',
            'dokumen_badge' => 'Dokumen Standar',
            'dokumen_judul' => 'SOP & Dokumen Standar Pelayanan Informasi',
            'dokumen_link_text' => 'Indeks Formulir Lengkap',
            'dokumen_link_url' => 'https://ppid.unila.ac.id/formulir-layanan-informasi/',
            'dokumen' => [
                ['judul' => 'POS AP Layanan Informasi (SOP)', 'deskripsi' => 'Standar Operasional Prosedur Layanan', 'url' => 'https://ppid.unila.ac.id/sop-layanan-informasi/'],
                ['judul' => 'Standar Pelayanan Informasi Publik', 'deskripsi' => 'Ketentuan umum dan hak pemohon', 'url' => 'https://ppid.unila.ac.id/standar-pelayanan-informasi-publik/'],
                ['judul' => 'Maklumat Pelayanan', 'deskripsi' => 'Komitmen pelayanan informasi KIP', 'url' => 'https://ppid.unila.ac.id/maklumat-pelayanan/'],
                ['judul' => 'Formulir Permohonan Informasi', 'deskripsi' => 'Lampiran VI Perki 1/2021', 'url' => 'https://ppid.unila.ac.id/formulir-permohonan-informasi-publik/'],
                ['judul' => 'Formulir Keberatan Jawaban', 'deskripsi' => 'Lampiran X Perki 1/2021', 'url' => 'https://ppid.unila.ac.id/formulir-keberatan-jawaban-informasi-publik/'],
                ['judul' => 'Formulir Keluhan Informasi', 'deskripsi' => 'Formulir aspirasi & pengaduan publik', 'url' => 'https://ppid.unila.ac.id/formulir-keluhan-informasi-publik/'],
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
                if (empty($merged['dokumen']) || !is_array($merged['dokumen'])) {
                    $merged['dokumen'] = $default['dokumen'];
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
            'profil' => self::getProfil()
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
        $request->validate([
            'header_judul'     => 'required|string|max:200',
            'header_deskripsi' => 'required|string|max:500',
            'permohonan_judul' => 'required|string|max:200',
            'keberatan_judul'  => 'required|string|max:200',
        ]);

        $current = self::getTataCara();
        $new = $current;

        // Field sederhana
        $fields = ['header_judul','header_deskripsi','permohonan_badge','permohonan_sla','permohonan_judul','permohonan_deskripsi','keberatan_badge','keberatan_sla','keberatan_judul','keberatan_deskripsi','sla_judul','biaya_judul','biaya_link_text','biaya_link_url','dokumen_badge','dokumen_judul','dokumen_link_text','dokumen_link_url'];
        foreach ($fields as $f) {
            if ($request->filled($f)) $new[$f] = trim($request->input($f));
        }

        // SLA / Biaya list (textarea baris per item)
        if ($request->filled('sla_items_text')) {
            $new['sla_items'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('sla_items_text')))));
        }
        if ($request->filled('biaya_items_text')) {
            $new['biaya_items'] = array_values(array_filter(array_map('trim', explode("\n", $request->input('biaya_items_text')))));
        }

        // Langkah permohonan & keberatan — terima array atau JSON
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

        $dok = $decodeSteps('dokumen');
        if (is_array($dok)) $new['dokumen'] = array_values(array_filter($dok, fn($d) => !empty(trim($d['judul'] ?? ''))));

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
            'badge'     => 'required|string|max:50',
            'tahun'     => 'required|string|max:50',
            'judul'     => 'required|string|max:200',
            'deskripsi' => 'required|string|max:1000',
            'sumber'    => 'required|string|max:100',
            'url'       => 'required|url|max:500',
        ]);

        $regulasi = self::getRegulasi();
        $maxId = count($regulasi) > 0 ? max(array_column($regulasi, 'id')) : 0;

        $regulasi[] = [
            'id'        => $maxId + 1,
            'kategori'  => $request->input('kategori'),
            'badge'     => trim($request->input('badge')),
            'tahun'     => trim($request->input('tahun')),
            'judul'     => trim($request->input('judul')),
            'deskripsi' => trim($request->input('deskripsi')),
            'sumber'    => trim($request->input('sumber')),
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
