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
        'file_identitas', 'info_diminta', 'tujuan', 'cara_ambil', 'pernyataan', 'no_tiket','status'
    ];

    /**
     * Relasi ke User (opsional, jika ingin memanggil data user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
