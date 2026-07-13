<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublik extends Model
{
    use HasFactory;

    protected $table = 'informasi_publik';

    protected $fillable = [
        'rincian_informasi',
        'sub_informasi',
        'kategori',
        'tipe_informasi',
        'jalur_informasi'
    ];
}
