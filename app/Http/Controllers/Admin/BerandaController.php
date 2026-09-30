<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BerandaController extends Controller
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
            ['id' => 3, 'pertanyaan' => 'Apa saja syarat untuk mengajukan permohonan informasi?', 'jawaban' => "Pemohon wajib memiliki akun terdaftar dan melampirkan identitas resmi:\n- Bagi individu: Kartu Tanda Penduduk (KTP) atau Kartu Tanda Mahasiswa (KTM).\n- Bagi badan hukum/organisasi: Akta notaris/SK Kemenkumham serta surat kuasa perwakilan.\n- Menyebutkan tujuan penggunaan informasi secara jelas dan tidak bertentangan dengan hukum."],
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
            'tugas_fungsi'    => 'Mengelola, menyediakan, dan melayani informasi publik di lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam; menyusun Daftar Informasi Publik unit; melayani permohonan dan keberatan; serta melaporkan layanan kepada PPID Utama Universitas Lampung.'
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
        ]);

        $profil = self::getProfil();
        $profil['nama'] = trim($request->input('nama'));
        $profil['jabatan'] = trim($request->input('jabatan'));
        $profil['tugas_fungsi'] = trim($request->input('tugas_fungsi'));
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

    /**
     * Tampilan Simpel Manajemen Profil PPID & Tanya Jawab (FAQ) di Admin
     */
    public function index()
    {
        return view('admin.beranda.index', [
            'faqs'   => self::getFaqs(),
            'profil' => self::getProfil()
        ]);
    }

    /**
     * Tambah FAQ Baru
     */
    public function storeFaq(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban'    => 'required|string'
        ]);

        $faqs = self::getFaqs();
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
}
