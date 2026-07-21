<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontenInformasiPublik extends Model
{
    protected $table = 'konten_informasi_publiks';
    protected $guarded = ['id'];

    /**
     * Fallback data default jika belum ada record DB
     */
    public static function defaultData(): array
    {
        return [
            'informasi_publik_judul' => 'Daftar Informasi Publik',
            'informasi_publik_subjudul' => 'Penetapan Daftar Informasi Publik FMIPA Universitas Lampung mengacu pada aturan yang berlaku secara transparan, akuntabel, dan mudah diakses oleh masyarakat.',

            'setiap_saat_judul' => 'Informasi Tersedia Setiap Saat',
            'setiap_saat_subjudul' => 'Daftar informasi publik yang dapat diakses dan diperoleh oleh publik kapan saja secara terbuka tanpa perlu melalui permohonan khusus.',

            'berkala_judul' => 'Informasi Tersedia Secara Berkala',
            'berkala_subjudul' => 'Daftar informasi publik yang diperbarui dan disediakan secara rutin (berkala) oleh FMIPA Universitas Lampung untuk publik.',

            'serta_merta_judul' => 'Informasi Diumumkan Serta Merta',
            'serta_merta_subjudul' => 'Daftar informasi publik yang berkaitan dengan hajat hidup orang banyak dan ketertiban umum yang wajib diumumkan secara serta merta.',
        ];
    }

    /**
     * Ambil data tunggal (singleton record)
     */
    public static function getData(): array
    {
        try {
            $record = static::first();
            if ($record) {
                $defaults = static::defaultData();
                $data = $record->toArray();
                return array_merge($defaults, array_filter($data, fn($v) => !is_null($v)));
            }
        } catch (\Exception $e) {
            // Abaikan jika tabel belum di-migrate
        }

        return static::defaultData();
    }
}
