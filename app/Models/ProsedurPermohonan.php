<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ProsedurPermohonan extends Model
{
    use HasFactory;

    protected $table = 'prosedur_permohonans';

    protected $fillable = [
        'judul',
        'subjudul',
        'jangka_waktu',
        'biaya_layanan',
        'syarat_utama',
        'hak_pemohon',
        'tahapan_permohonan',
        'tahapan_keberatan',
        'syarat_dokumen',
        'sla_matrix',
        'faqs',
    ];

    protected $casts = [
        'tahapan_permohonan' => 'array',
        'tahapan_keberatan'  => 'array',
        'syarat_dokumen'     => 'array',
        'sla_matrix'         => 'array',
        'faqs'               => 'array',
    ];

    /**
     * Default data fallback
     */
    public static function defaultData()
    {
        return [
            'judul' => 'Prosedur Permohonan Informasi Publik',
            'subjudul' => 'Panduan resmi dan alur langkah pengajuan permohonan informasi publik di lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA) Universitas Lampung secara cepat, transparan, dan akuntabel.',
            'jangka_waktu' => 'Maks. 10 Hari Kerja',
            'biaya_layanan' => 'GRATIS / Rp 0',
            'syarat_utama' => 'Kartu Identitas (KTP/KTM)',
            'hak_pemohon' => 'Pengajuan Keberatan',

            'tahapan_permohonan' => [
                [
                    'nomor' => '01',
                    'judul' => 'Pengajuan Permohonan',
                    'deskripsi' => 'Pemohon mengisi formulir permohonan informasi publik secara online di sistem portal PPID FMIPA Unila atau datang langsung ke Layanan PPID.',
                    'catatan' => 'Melampirkan KTP / KTM / Identitas Resmi',
                    'ikon' => 'fa-pen-to-square'
                ],
                [
                    'nomor' => '02',
                    'judul' => 'Verifikasi Dokumen',
                    'deskripsi' => 'Petugas PPID memeriksa kelengkapan persyaratan dan identitas permohonan. Jika lengkap, sistem memberikan bukti registrasi penerimaan.',
                    'catatan' => 'Maksimal 1 hari kerja',
                    'ikon' => 'fa-clipboard-check'
                ],
                [
                    'nomor' => '03',
                    'judul' => 'Pemrosesan Informasi',
                    'deskripsi' => 'PPID berkoordinasi dengan Unit/Jurusan terkait di FMIPA Unila untuk mengumpulkan, mengolah, dan mengevaluasi status dokumen informasi.',
                    'catatan' => 'Pengolahan Internal FMIPA',
                    'ikon' => 'fa-gears'
                ],
                [
                    'nomor' => '04',
                    'judul' => 'Pemberitahuan Tertulis',
                    'deskripsi' => 'PPID menerbitkan surat pemberitahuan tertulis yang menyatakan apakah informasi diterima, ditolak, atau memerlukan perpanjangan waktu.',
                    'catatan' => 'Maksimal 10 hari kerja',
                    'ikon' => 'fa-envelope-open-text'
                ],
                [
                    'nomor' => '05',
                    'judul' => 'Penyerahan Hasil',
                    'deskripsi' => 'Dokumen atau file salinan informasi publik diserahkan kepada pemohon melalui akun portal PPID (unduh langsung) atau email resmi.',
                    'catatan' => 'Selesai',
                    'ikon' => 'fa-file-circle-check'
                ]
            ],

            'tahapan_keberatan' => [
                [
                    'nomor' => '01',
                    'judul' => 'Pengajuan Keberatan',
                    'deskripsi' => 'Pemohon mengajukan permohonan keberatan tertulis kepada Atasan PPID melalui sistem portal atau loket PPID apabila permohonan ditolak, terlambat, atau tidak memuaskan.',
                    'catatan' => 'Maksimal 30 hari kerja sejak tanggapan PPID',
                    'ikon' => 'fa-file-signature'
                ],
                [
                    'nomor' => '02',
                    'judul' => 'Verifikasi Atasan PPID',
                    'deskripsi' => 'Atasan PPID mengkaji dokumen keberatan, alasan pengajuan, serta catatan penanganan oleh pejabat pengelola informasi.',
                    'catatan' => 'Evaluasi Internal Atasan',
                    'ikon' => 'fa-user-gear'
                ],
                [
                    'nomor' => '03',
                    'judul' => 'Tanggapan Atasan PPID',
                    'deskripsi' => 'Atasan PPID memberikan tanggapan tertulis berupa instruksi pemberian informasi atau penguatan penolakan informasi disertai pertimbangan hukum.',
                    'catatan' => 'Maksimal 30 hari kerja',
                    'ikon' => 'fa-gavel'
                ],
                [
                    'nomor' => '04',
                    'judul' => 'Penyelesaian Sengketa',
                    'deskripsi' => 'Jika pemohon masih tidak puas dengan tanggapan Atasan PPID, pemohon dapat mengajukan sengketa informasi ke Komisi Informasi.',
                    'catatan' => 'Komisi Informasi',
                    'ikon' => 'fa-scale-balanced'
                ]
            ],

            'syarat_dokumen' => [
                'perorangan' => [
                    'judul' => 'Pemohon Perorangan',
                    'deskripsi' => 'Warga Negara Indonesia (WNI) secara perorangan termasuk civitas akademika.',
                    'poin' => [
                        'Salinan KTP (Kartu Tanda Penduduk) / Passport yang masih berlaku.',
                        'KTM (Kartu Tanda Mahasiswa) untuk mahasiswa aktif FMIPA Unila.',
                        'Kontak nomor HP/WhatsApp & email aktif.'
                    ]
                ],
                'kelompok' => [
                    'judul' => 'Kelompok Masyarakat',
                    'deskripsi' => 'Permohonan yang diajukan oleh sekelompok orang atau tim kerja.',
                    'poin' => [
                        'Surat Kuasa khusus dari anggota kelompok permohonan.',
                        'Salinan KTP Penerima Kuasa / Ketua Kelompok.',
                        'Daftar nama dan identitas seluruh anggota kelompok pemohon.'
                    ]
                ],
                'badan_hukum' => [
                    'judul' => 'Badan Hukum / NGO',
                    'deskripsi' => 'Lembaga swadaya, badan usaha, media, atau organisasi terdaftar.',
                    'poin' => [
                        'Salinan Akta Pendirian / Pengesahan Badan Hukum dari Kemenkumham.',
                        'Surat Tugas / Surat Kuasa pimpinan lembaga.',
                        'Salinan KTP Pimpinan atau pihak yang diberi kuasa.'
                    ]
                ]
            ],

            'sla_matrix' => [
                [
                    'no' => 1,
                    'layanan' => 'Verifikasi & Registrasi Berkas Permohonan',
                    'waktu' => '1 Hari Kerja',
                    'biaya' => 'Gratis',
                    'output' => 'Tanda Terima / Nomor Registrasi Online'
                ],
                [
                    'no' => 2,
                    'layanan' => 'Pemberitahuan Tertulis (Tanggapan Resmi)',
                    'waktu' => '10 Hari Kerja',
                    'biaya' => 'Gratis',
                    'output' => 'Surat Pemberitahuan Tertulis PPID'
                ],
                [
                    'no' => 3,
                    'layanan' => 'Perpanjangan Waktu Pemrosesan (Jika Diperlukan)',
                    'waktu' => '7 Hari Kerja',
                    'biaya' => 'Gratis',
                    'output' => 'Surat Pemberitahuan Perpanjangan Waktu'
                ],
                [
                    'no' => 4,
                    'layanan' => 'Penyampaian Berkas Salinan Digital (Softcopy)',
                    'waktu' => 'Langsung Sesuai Tanggapan',
                    'biaya' => 'Gratis',
                    'output' => 'File PDF / Link Unduh Portal PPID'
                ],
                [
                    'no' => 5,
                    'layanan' => 'Tanggapan Atasan PPID atas Keberatan Pemohon',
                    'waktu' => '30 Hari Kerja',
                    'biaya' => 'Gratis',
                    'output' => 'Surat Keputusan Tanggapan Keberatan'
                ]
            ],

            'faqs' => [
                [
                    'tanya' => 'Apakah ada biaya dalam pengajuan permohonan informasi publik di FMIPA Unila?',
                    'jawab' => 'Seluruh layanan informasi publik di PPID FMIPA Universitas Lampung TIDAK DIPUNGUT BIAYA (GRATIS). Berkas atau dokumen diberikan dalam format salinan digital (softcopy PDF) yang dapat diunduh langsung melalui akun portal Anda.'
                ],
                [
                    'tanya' => 'Bagaimana cara melacak status permohonan informasi yang sudah saya kirimkan?',
                    'jawab' => 'Anda dapat memantau status secara real-time dengan masuk (login) ke dashboard akun pemohon Anda di menu Layanan Informasi. Setiap perubahan status (seperti Diproses, Diterima, atau Ditolak) akan diperbarui pada halaman rincian permohonan Anda.'
                ],
                [
                    'tanya' => 'Apa yang harus dilakukan jika permohonan informasi ditolak atau tidak ditanggapi?',
                    'jawab' => 'Apabila permohonan Anda ditolak tanpa alasan yang sah atau tidak mendapatkan tanggapan hingga batas waktu 10 hari kerja berakhir, Anda berhak mengajukan Pengajuan Keberatan kepada Atasan PPID melalui menu Formulir Keberatan di portal ini dalam kurun waktu 30 hari kerja.'
                ],
                [
                    'tanya' => 'Apakah perlu membuat akun terlebih dahulu untuk mengajukan permohonan?',
                    'jawab' => 'Ya, untuk mengajukan permohonan informasi publik atau pengajuan keberatan secara online, Anda wajib melakukan pendaftaran akun pemohon terlebih dahulu demi menjamin validitas identitas pemohon dan keamanan verifikasi data.'
                ]
            ]
        ];
    }

    /**
     * Get active procedure data (DB row or default fallback)
     */
    public static function getData()
    {
        try {
            if (Schema::hasTable('prosedur_permohonans')) {
                $item = self::first();
                if ($item) {
                    $defaults = self::defaultData();
                    return [
                        'judul' => $item->judul ?? $defaults['judul'],
                        'subjudul' => $item->subjudul ?? $defaults['subjudul'],
                        'jangka_waktu' => $item->jangka_waktu ?? $defaults['jangka_waktu'],
                        'biaya_layanan' => $item->biaya_layanan ?? $defaults['biaya_layanan'],
                        'syarat_utama' => $item->syarat_utama ?? $defaults['syarat_utama'],
                        'hak_pemohon' => $item->hak_pemohon ?? $defaults['hak_pemohon'],
                        'tahapan_permohonan' => $item->tahapan_permohonan ?: $defaults['tahapan_permohonan'],
                        'tahapan_keberatan' => $item->tahapan_keberatan ?: $defaults['tahapan_keberatan'],
                        'syarat_dokumen' => $item->syarat_dokumen ?: $defaults['syarat_dokumen'],
                        'sla_matrix' => $item->sla_matrix ?: $defaults['sla_matrix'],
                        'faqs' => $item->faqs ?: $defaults['faqs'],
                        'is_from_db' => true,
                        'model_id' => $item->id,
                    ];
                }
            }
        } catch (\Exception $e) {
            // fallback if table does not exist yet
        }

        $def = self::defaultData();
        $def['is_from_db'] = false;
        $def['model_id'] = null;
        return $def;
    }
}
