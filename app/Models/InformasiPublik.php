<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    use HasFactory;

    protected $table = 'informasi_publik';

    protected $fillable = [
        'judul_informasi',
        'deskripsi_informasi',
        'kategori_informasi',
        'tahun_terbit',
        'file_informasi',
        'nama_file_asli',
        'link_informasi',
        'dilihat',
    ];
}
