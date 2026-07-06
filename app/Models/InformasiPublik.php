<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    use HasFactory;

    // 1. WAJIB DIKUNCI! Agar Laravel tidak mencari tabel 'informasi_publiks'
    protected $table = 'informasi_publik';

    // 2. Kolom fillable disesuaikan 100% dengan draf proposal baru (Tanpa kata 'dokumen')
    protected $fillable = [
        'judul_informasi',
        'kategori',
        'deskripsi',
        'tipe_informasi',  // isinya: 'pdf', 'docx', atau 'link'
        'jalur_informasi', // isinya: path simpan file atau URL http://...
        'tahun_publikasi',
        'dilihat',         // kolom baru untuk menghitung jumlah dilihat
    ];
}
