<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\PengajuanStatusChangedMail;

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

        // 3. Filter berdasarkan Jenis Layanan jika ada
        if ($request->has('jenis_layanan') && $request->jenis_layanan != '') {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }

        // 4. Pencarian berdasarkan kata kunci
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('info_diminta', 'like', "%{$search}%")
                  ->orWhere('tujuan_permohonan', 'like', "%{$search}%")
                  ->orWhere('tujuan_keberatan', 'like', "%{$search}%")
                  ->orWhere('alasan_keberatan', 'like', "%{$search}%");
            });
        }

        // 5. Ambil data dengan pagination, pertahankan query parameter di link pagination
        $permohonans = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // 6. Statistik untuk Grid (Berdasarkan tabel tunggal Pengajuan)
        $totalPermohonan = Pengajuan::count();
        $totalDiajukan   = Pengajuan::where('status', 'DIAJUKAN')->count();
        $totalDiproses   = Pengajuan::where('status', 'DIPROSES')->count();
        $totalDiterima   = Pengajuan::where('status', 'DITERIMA')->count();
        $totalDitolak    = Pengajuan::where('status', 'DITOLAK')->count();

        // 7. Kirim ke View
        return view('admin.pengajuan.index', compact(
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
        return view('admin.pengajuan.show', compact('permohonan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // Validasi Alur Status tambahan
        if ($pengajuan->status === 'DIPROSES' && $request->status === 'DIAJUKAN') {
            return redirect()->back()->withErrors(['status' => 'Status tidak dapat dikembalikan ke DIAJUKAN setelah DIPROSES.'])->withInput();
        }

        if (in_array($pengajuan->status, ['DITERIMA', 'DITOLAK']) && $request->status !== $pengajuan->status) {
            return redirect()->back()->withErrors(['status' => 'Status final (DITERIMA/DITOLAK) tidak dapat diubah kembali.'])->withInput();
        }

        $rules = [
            'status' => 'required|in:DIAJUKAN,DIPROSES,DITERIMA,DITOLAK',
            'catatan_admin' => $request->status === 'DITOLAK' ? 'required|string' : 'nullable|string',
            'file_jawaban' => 'nullable|file|mimes:pdf,jpg,png,zip,docx|max:5120',
        ];

        $request->validate($rules, [
            'catatan_admin.required' => 'Catatan/alasan wajib diisi jika status ditolak.',
        ]);

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

        // Record status history
        $pengajuan->statusHistories()->create([
            'status' => $request->status,
            'catatan' => $request->catatan_admin ?: null,
        ]);

        // Kirim email notifikasi pembaruan status
        try {
            $emailUser = $pengajuan->email;
            if ($emailUser) {
                Mail::to($emailUser)->send(new PengajuanStatusChangedMail($pengajuan));
            }
        } catch (\Exception $mailEx) {
            Log::warning('Gagal mengirim email notifikasi pembaruan status: ' . $mailEx->getMessage());
        }

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        $files = [
            $pengajuan->lampiran_identitas,
            $pengajuan->akta_pendirian,
            $pengajuan->lampiran_pendukung,
            $pengajuan->file_jawaban
        ];

        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $pengajuan->delete();

        return redirect()->back()->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids || !is_array($ids)) {
            return redirect()->back()->with('error', 'Pilih minimal satu pengajuan untuk dihapus.');
        }

        $pengajuans = Pengajuan::whereIn('id', $ids)->get();

        foreach ($pengajuans as $pengajuan) {
            $files = [
                $pengajuan->lampiran_identitas,
                $pengajuan->akta_pendirian,
                $pengajuan->lampiran_pendukung,
                $pengajuan->file_jawaban
            ];

            foreach ($files as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }

            $pengajuan->delete();
        }

        return redirect()->back()->with('success', count($ids) . ' pengajuan berhasil dihapus.');
    }
}
