<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonans';

    protected $fillable = [
        'user_id',
        'no_tiket',
        'nama_lengkap',
        'jenis_identitas',
        'no_identitas',
        'email',
        'no_telepon',
        'alamat_lengkap',
        'pekerjaan',
        'informasi_yang_diminta',
        'tujuan_penggunaan_informasi',
        'jenis_permohonan',
        'cara_memperoleh_informasi',
        'file_identitas',
        'nama_file_identitas_asli',
        'status',
        'catatan_diproses',
        'catatan_selesai',
        'alasan_ditolak',
        'file_jawaban',
        'link_jawaban',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function keberatans(): HasMany
    {
        return $this->hasMany(Keberatan::class, 'permohonan_id');
    }

    public function keberatan()
    {
        return $this->hasOne(Keberatan::class, 'permohonan_id')->latestOfMany();
    }
}
