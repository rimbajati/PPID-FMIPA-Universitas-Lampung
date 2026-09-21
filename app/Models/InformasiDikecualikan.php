<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiDikecualikan extends Model
{
    use HasFactory;

    protected $table = 'informasi_dikecualikans';

    protected $fillable = [
        'ringkasan_informasi',
        'dasar_hukum',
        'dibuka',
        'ditutup',
        'jangka_waktu',
    ];
}
