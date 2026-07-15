<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengajuan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'jenis_layanan',
        'no_tiket',
        'nama',
        'pekerjaan',            // Baru ditambahkan
        'kategori_pemohon',
        'no_identitas',
        'lampiran_identitas',
        'akta_pendirian',       // Baru ditambahkan
        'email',
        'no_hp',
        'alamat',
        'info_diminta',
        'tujuan_permohonan',
        'tujuan_keberatan',
        'alasan_keberatan',
        'cara_memperoleh',
        'permohonan_terkait_id',
        'lampiran_pendukung',
        'status',
        'catatan_admin',
        'file_jawaban',
    ];

    /**
     * Relasi ke User
     * Setiap pengajuan dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Permohonan terkait
     * Digunakan jika pengajuan ini adalah bentuk Keberatan.
     */
    public function permohonanTerkait(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class, 'permohonan_terkait_id');
    }

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class, 'permohonan_terkait_id');
    }
}
