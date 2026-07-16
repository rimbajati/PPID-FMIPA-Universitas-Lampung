<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusHistory extends Model
{
    protected $table = 'status_histories';

    protected $fillable = [
        'pengajuan_id',
        'status',
        'catatan',
    ];

    /**
     * Relasi ke Pengajuan
     */
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
