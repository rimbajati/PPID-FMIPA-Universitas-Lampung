<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Beranda extends Model
{
    use HasFactory;

    protected $table = 'berandas';

    protected $fillable = [
        'hero_tagline',
        'hero_judul_1',
        'hero_judul_2',
        'hero_subjudul',
        'hero_search_placeholder',
        'hero_cta_user_text',
        'alur_judul',
        'alur_subjudul',
        'alur_steps',
        'stats_tagline',
        'stats_judul',
        'stats_deskripsi',
    ];

    protected $casts = [
        'alur_steps' => 'array',
    ];

    /**
     * Default data fallback for Homepage
     */
    public static function defaultData()
    {
        return [
            'hero_tagline' => 'Pejabat Pengelola Informasi & Dokumentasi (PPID)',
            'hero_judul_1' => 'Fakultas Matematika &',
            'hero_judul_2' => 'Ilmu Pengetahuan Alam',
            'hero_subjudul' => 'Universitas Lampung',
            'hero_search_placeholder' => 'Masukan Informasi yang Anda cari...',
            'hero_cta_user_text' => 'Jika informasi yang Anda cari tidak ditemukan, Anda dapat mengajukan permohonan baru di bawah ini.',
            
            'alur_judul' => 'Alur Permohonan Informasi',
            'alur_subjudul' => 'Ikuti langkah mudah berikut untuk mengajukan permohonan informasi publik di lingkungan FMIPA Unila.',
            'alur_steps' => [
                [
                    'icon' => 'fa-user-plus',
                    'title' => 'Registrasi/Login',
                    'desc' => 'Daftar akun atau masuk ke sistem untuk memulai permohonan.'
                ],
                [
                    'icon' => 'fa-file-signature',
                    'title' => 'Isi Formulir',
                    'desc' => 'Lengkapi form permohonan dengan data diri dan tujuan informasi.'
                ],
                [
                    'icon' => 'fa-paper-plane',
                    'title' => 'Kirim Permohonan',
                    'desc' => 'Submit formulir dan dapatkan nomor registrasi permohonan.'
                ],
                [
                    'icon' => 'fa-envelope-open-text',
                    'title' => 'Terima Jawaban',
                    'desc' => 'Tunggu respon dari admin PPID melalui sistem atau email Anda.'
                ]
            ],

            'stats_tagline' => 'LAPORAN KETERBUKAAN INFORMASI',
            'stats_judul' => 'Statistik Permohonan Informasi',
            'stats_deskripsi' => 'Data ini menyajikan statistik keterbukaan informasi publik FMIPA Unila secara transparan. Masyarakat dapat memantau tren permohonan, status layanan, hingga perkembangan proses yang sedang berlangsung.',
        ];
    }

    /**
     * Get active Homepage data (DB row or default fallback)
     */
    public static function getData()
    {
        try {
            if (Schema::hasTable('berandas')) {
                $item = self::first();
                if ($item) {
                    $defaults = self::defaultData();
                    return [
                        'hero_tagline' => $item->hero_tagline ?? $defaults['hero_tagline'],
                        'hero_judul_1' => $item->hero_judul_1 ?? $defaults['hero_judul_1'],
                        'hero_judul_2' => $item->hero_judul_2 ?? $defaults['hero_judul_2'],
                        'hero_subjudul' => $item->hero_subjudul ?? $defaults['hero_subjudul'],
                        'hero_search_placeholder' => $item->hero_search_placeholder ?? $defaults['hero_search_placeholder'],
                        'hero_cta_user_text' => $item->hero_cta_user_text ?? $defaults['hero_cta_user_text'],
                        
                        'alur_judul' => $item->alur_judul ?? $defaults['alur_judul'],
                        'alur_subjudul' => $item->alur_subjudul ?? $defaults['alur_subjudul'],
                        'alur_steps' => $item->alur_steps ?: $defaults['alur_steps'],

                        'stats_tagline' => $item->stats_tagline ?? $defaults['stats_tagline'],
                        'stats_judul' => $item->stats_judul ?? $defaults['stats_judul'],
                        'stats_deskripsi' => $item->stats_deskripsi ?? $defaults['stats_deskripsi'],
                        'is_from_db' => true,
                    ];
                }
            }
        } catch (\Exception $e) {
            // fallback
        }

        $def = self::defaultData();
        $def['is_from_db'] = false;
        return $def;
    }
}
