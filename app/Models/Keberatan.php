<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keberatan extends Model
{
    use HasFactory;

    protected $table = 'keberatans';

    protected $fillable = [
        'user_id',
        'permohonan_id',
        'no_tiket',
        'alasan_keberatan',
        'kronologi_keberatan',
        'file_pendukung',
        'status',
        'pesan_diproses',
        'pesan_selesai',
        'alasan_ditolak',
        'file_jawaban',
        'link_jawaban',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }
}
