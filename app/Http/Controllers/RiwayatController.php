<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Memberikan nama 'page_permohonan' dan 'page_keberatan'
        $permohonans = Pengajuan::where('jenis_layanan', 'Permohonan')->where('user_id', $userId)->latest()->paginate(3, ['*'], 'page_permohonan');
        $keberatans = Pengajuan::with('permohonan')->where('jenis_layanan', 'Keberatan')->where('user_id', $userId)->latest()->paginate(3, ['*'], 'page_keberatan');

        return view('pemohon.riwayat', compact('permohonans', 'keberatans'));
    }

    public function showPermohonan($id) {
        $perm = Pengajuan::where('jenis_layanan', 'Permohonan')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('pemohon.detail_permohonan', compact('perm'));
    }

    public function showKeberatan($id) {
        $keb = Pengajuan::with('permohonan')->where('jenis_layanan', 'Keberatan')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('pemohon.detail_keberatan', compact('keb'));
    }
}
