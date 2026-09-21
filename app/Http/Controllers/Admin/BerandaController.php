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
     * Helper menyimpan FAQ
     */
    private function saveFaqs(array $faqs): void
    {
        $data = ['faq' => $faqs];
        Storage::disk('local')->put(self::$filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Tampilan Simpel Manajemen Tanya Jawab (FAQ) di Admin
     */
    public function index()
    {
        return view('admin.beranda.index', [
            'faqs' => self::getFaqs()
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
