<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatLayananController extends Controller
{
    /**
     * Halaman Riwayat Layanan Publik Pemohon (Permohonan & Keberatan)
     */
    public function index()
    {
        $userId = Auth::id();
        $user = Auth::user();

        // 1. Ambil Permohonan milik user
        $permohonans = Permohonan::where('user_id', $userId)->latest()->get()->map(function ($item) use ($user) {
            $item->type = 'permohonan';
            $item->jenis_label = 'Permohonan Informasi';
            $item->judul = $item->informasi_yang_diminta ?? $item->rincian_informasi;
            $item->deskripsi = $item->tujuan_penggunaan_informasi ?? $item->tujuan_penggunaan;
            $item->nama_pemohon = !empty($item->nama_lengkap) ? $item->nama_lengkap : ($user ? $user->name : 'Pemohon');
            $item->tanggal_pengajuan = $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-';
            $item->created_at_formatted = $item->created_at ? $item->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '';
            $item->updated_at_formatted = $item->updated_at ? $item->updated_at->translatedFormat('d F Y, H:i') . ' WIB' : '';
            $item->estimasi_selesai = $item->created_at ? $item->created_at->addDays(10)->translatedFormat('d F Y') : '-';
            $item->identitas_file = $item->file_identitas ?? $item->identitas_file;
            $item->identitas_file_url = $item->identitas_file ? asset('storage/' . $item->identitas_file) : null;
            $item->file_pendukung_url = $item->file_pendukung ? asset('storage/' . $item->file_pendukung) : null;
            
            // Pesan Tanggapan Admin berdasarkan standar 4 status
            $item->pesan_diproses = $item->pesan_diproses ?? null;
            $item->pesan_selesai  = $item->pesan_selesai ?? null;
            $item->alasan_ditolak = $item->alasan_ditolak ?? $item->pesan_ditolak ?? null;

            $item->has_keberatan = Keberatan::where('permohonan_id', $item->id)->exists();
            return $item;
        });

        // 2. Ambil Keberatan milik user
        $keberatans = Keberatan::with('permohonan')->where('user_id', $userId)->latest()->get()->map(function ($item) use ($user) {
            $item->type = 'keberatan';
            $item->jenis_label = 'Pengajuan Keberatan';
            $item->no_tiket_asal = $item->permohonan ? $item->permohonan->no_tiket : null;
            $item->informasi_asal = $item->permohonan ? $item->permohonan->informasi_yang_diminta : null;
            
            $item->judul = $item->informasi_asal ?: ($item->no_tiket_asal ? 'Permohonan #' . $item->no_tiket_asal : $item->alasan_keberatan);
            $item->deskripsi = $item->alasan_keberatan;
            
            $item->nama_pemohon = !empty($item->nama_lengkap) ? $item->nama_lengkap : ($user ? $user->name : 'Pemohon');
            $item->tanggal_pengajuan = $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-';
            $item->created_at_formatted = $item->created_at ? $item->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '';
            $item->updated_at_formatted = $item->updated_at ? $item->updated_at->translatedFormat('d F Y, H:i') . ' WIB' : '';
            $item->estimasi_selesai = $item->created_at ? $item->created_at->addDays(30)->translatedFormat('d F Y') : '-';
            $item->identitas_file = $item->permohonan ? ($item->permohonan->file_identitas ?? $item->permohonan->identitas_file) : null;
            $item->identitas_file_url = $item->identitas_file ? asset('storage/' . $item->identitas_file) : null;
            $item->file_pendukung_url = $item->file_pendukung ? asset('storage/' . $item->file_pendukung) : ($item->pendukung_file ? asset('storage/' . $item->pendukung_file) : null);
            
            // Pesan Tanggapan Admin berdasarkan standar 4 status
            $item->pesan_diproses = $item->pesan_diproses ?? null;
            $item->pesan_selesai  = $item->pesan_selesai ?? null;
            $item->alasan_ditolak = $item->alasan_ditolak ?? $item->pesan_ditolak ?? null;

            return $item;
        });

        // Gabungkan permohonan dan keberatan, diurutkan dari terbaru
        $allLayans = $permohonans->concat($keberatans)->sortByDesc('created_at')->values();

        return view('masyarakat.layanan.riwayat.index', compact('allLayans', 'permohonans', 'keberatans'));
    }
}
