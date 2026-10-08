<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class JawabanFile extends Model
{
    protected $fillable = [
        'jawabanable_type',
        'jawabanable_id',
        'file_path',
        'file_name',
        'file_size',
    ];

    public function jawabanable(): MorphTo
    {
        return $this->morphTo();
    }
}
