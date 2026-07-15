<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Query Dasar
        $query = Pengajuan::query();

        // 2. Filter berdasarkan Status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 3. Ambil data dengan pagination
        $permohonans = $query->orderBy('created_at', 'desc')->paginate(10);

        // 4. Statistik untuk Grid (Berdasarkan tabel tunggal Pengajuan)
        $totalPermohonan = Pengajuan::count();
        $totalDiajukan   = Pengajuan::where('status', 'DIAJUKAN')->count();
        $totalDiproses   = Pengajuan::where('status', 'DIPROSES')->count();
        $totalDiterima   = Pengajuan::where('status', 'DITERIMA')->count();
        $totalDitolak    = Pengajuan::where('status', 'DITOLAK')->count();

        // 5. Kirim ke View
        return view('admin.pengajuan', compact(
            'permohonans',
            'totalPermohonan',
            'totalDiajukan',
            'totalDiproses',
            'totalDiterima',
            'totalDitolak'
        ));
    }

    public function show($id)
    {
        // Mencari data pengajuan berdasarkan ID
        $permohonan = Pengajuan::findOrFail($id);

        // Mengembalikan ke file view detail yang sudah kita buat sebelumnya
        return view('admin.pengajuan_detail', compact('permohonan'));
    }
}
