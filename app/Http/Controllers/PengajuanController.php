<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:DIAJUKAN,DIPROSES,DITERIMA,DITOLAK',
            'catatan_admin' => 'nullable|string',
            'file_jawaban' => 'nullable|file|mimes:pdf,jpg,png,zip,docx|max:5120',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        $data = [
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ];

        if ($request->hasFile('file_jawaban')) {
            // Delete old file if exists
            if ($pengajuan->file_jawaban) {
                Storage::disk('public')->delete($pengajuan->file_jawaban);
            }
            $data['file_jawaban'] = $request->file('file_jawaban')->store('file_jawaban', 'public');
        }

        $pengajuan->update($data);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
