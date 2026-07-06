<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keberatan extends Model
{
    use HasFactory;

    protected $table = 'keberatans';

    protected $fillable = [
        'permohonan_id',
        'user_id',
        'alasan_keberatan',
        'dokumen_pendukung',
        'tanggal_pengajuan',
        'status_putusan',
        'dokumen_putusan'
    ];

    /**
     * Relasi kembali ke Permohonan Awal
     */
    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }

    /**
     * Relasi ke User Pengaju
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
