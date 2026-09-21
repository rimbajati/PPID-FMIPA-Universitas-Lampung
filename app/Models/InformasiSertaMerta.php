<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiSertaMerta extends Model
{
    use HasFactory;

    protected $table = 'informasi_serta_mertas';

    protected $fillable = [
        'judul_informasi',
        'waktu_pembuatan_informasi',
        'pejabat_unit_yang_menguasai_informasi',
        'file_informasi',
        'nama_file_asli',
        'link_informasi',
        'dilihat',
    ];
}
