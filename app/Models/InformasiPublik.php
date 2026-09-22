<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    use HasFactory;

    protected $table = 'informasi_publiks';

    protected $fillable = [
        'rincian_informasi',
        'sub_informasi',
        'jenis_informasi',
        'pejabat_unit_yang_menguasai_informasi',
        'penanggung_jawab_pembuatan_informasi',
        'waktu_pembuatan_informasi',
        'bentuk_informasi_yang_tersedia',
        'retensi_arsip',
        'file_informasi',
        'nama_file_asli',
        'link_informasi',
        'dilihat',
    ];
}
