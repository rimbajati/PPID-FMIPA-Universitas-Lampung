<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Memberikan nama 'page_permohonan' dan 'page_keberatan'
        $permohonans = Permohonan::where('user_id', $userId)->latest()->paginate(3, ['*'], 'page_permohonan');
        $keberatans = Keberatan::with('permohonan')->where('user_id', $userId)->latest()->paginate(3, ['*'], 'page_keberatan');

        return view('dashboard.riwayat', compact('permohonans', 'keberatans'));
    }

    public function showPermohonan($id) {
        $perm = Permohonan::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('dashboard.detail_permohonan', compact('perm'));
    }

    public function showKeberatan($id) {
        $keb = Keberatan::with('permohonan')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('dashboard.detail_keberatan', compact('keb'));
    }
}
