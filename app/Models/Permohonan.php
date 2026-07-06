<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'nama', 'pekerjaan', 'alamat', 'telepon', 'email',
        'file_identitas', 'info_diminta', 'tujuan', 'pernyataan', 'no_tiket', 'status', 'catatan_admin', 'file_jawaban'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Keberatan (1 Permohonan bisa memiliki 1 pengajuan keberatan)
     */
    public function keberatan()
    {
        return $this->hasOne(Keberatan::class);
    }
}
