<?php

namespace App\Http\Controllers;

use App\Models\Keberatan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeberatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        // Mengambil daftar permohonan milik user yang sedang login
        // Agar user bisa memilih permohonan mana yang ingin disanggah/diajukan keberatan
        $permohonans = Permohonan::where('user_id', Auth::id())
                                 ->latest()
                                 ->get();

        return view('layanan.keberatan', compact('permohonans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'permohonan_id' => 'required|exists:permohonans,id',
            'alasan_keberatan' => 'required|string|min:15',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'permohonan_id.required' => 'Silakan pilih nomor tiket permohonan yang diajukan keberatan.',
            'alasan_keberatan.required' => 'Alasan keberatan wajib diisi.',
            'alasan_keberatan.min' => 'Alasan keberatan minimal 15 karakter agar jelas dan informatif.',
            'dokumen_pendukung.mimes' => 'Dokumen pendukung harus berupa file PDF, JPG, atau PNG.',
            'dokumen_pendukung.max' => 'Ukuran file dokumen pendukung maksimal 2 MB.',
        ]);

        // Pastikan permohonan_id yang dikirim benar-benar milik user tersebut (Keamanan)
        $permohonan = Permohonan::where('id', $request->permohonan_id)
                                ->where('user_id', Auth::id())
                                ->firstOrFail();

        // Handle upload file dokumen pendukung (jika ada)
        $filePath = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $file = $request->file('dokumen_pendukung');
            $fileName = time() . '_keberatan_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('dokumen_keberatan', $fileName, 'public');
        }

        // Simpan ke database
        Keberatan::create([
            'permohonan_id' => $permohonan->id,
            'user_id' => Auth::id(),
            'alasan_keberatan' => $request->alasan_keberatan,
            'dokumen_pendukung' => $filePath,
            'tanggal_pengajuan' => now(),
            'status_putusan' => 'menunggu',
        ]);

        return redirect()->route('keberatan.create')->with('success', 'Pengajuan keberatan Anda berhasil dikirim dan sedang menunggu proses verifikasi petugas.');
    }
}
