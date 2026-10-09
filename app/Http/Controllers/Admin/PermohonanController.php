<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $query = Permohonan::query()->latest();

        // Filter pencarian berdasarkan No Tiket, Nama Pemohon, NIK, Email, atau Detail Informasi
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('informasi_yang_diminta', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $permohonans = $query->with('keberatan')->paginate(10)->withQueryString();

        // Ringkasan Jumlah Statistik 4 Status Utama (Diajukan, Diproses, Selesai, Ditolak)
        $totalPermohonan = Permohonan::count();
        $totalMenunggu   = Permohonan::where('status', 'Diajukan')->count();
        $totalDiproses   = Permohonan::where('status', 'Diproses')->count();
        $totalSelesai    = Permohonan::where('status', 'Selesai')->count();
        $totalDitolak    = Permohonan::where('status', 'Ditolak')->count();

        return view('admin.permohonan.index', compact(
            'permohonans',
            'totalPermohonan',
            'totalMenunggu',
            'totalDiproses',
            'totalSelesai',
            'totalDitolak'
        ));
    }

    /**
     * Halaman Detail Permohonan Informasi
     */
    public function show($id)
    {
        $permohonan = Permohonan::with(['user', 'keberatan'])->findOrFail($id);

        return view('admin.permohonan.show', compact('permohonan'));
    }

    /**
     * Update Status Permohonan oleh Admin (Diajukan, Diproses, Selesai, Ditolak)
     */
    public function updateStatus(Request $request, $id)
    {
        $permohonan = Permohonan::findOrFail($id);

        // Proteksi: Status final (Selesai/Ditolak) tidak bisa diubah lagi
        $statusFinal = ['Selesai', 'Ditolak'];
        if (in_array($permohonan->status, $statusFinal)) {
            return redirect()->back()
                ->with('error', 'Permohonan ' . $permohonan->no_tiket . ' sudah berstatus "' . $permohonan->status . '" dan tidak dapat diubah lagi.');
        }

        // Proteksi: Jika permohonan ini telah diajukan Keberatan oleh pemohon, kunci pemrosesan di menu permohonan
        if ($permohonan->keberatan) {
            return redirect()->back()
                ->with('error', 'Permohonan ' . $permohonan->no_tiket . ' telah diajukan KEBERATAN (Tiket: ' . $permohonan->keberatan->no_tiket . '). Pemrosesan dialihkan ke Menu Keberatan.');
        }

        $validated = $request->validate([
            'status'                  => 'required|in:Diproses,Selesai,Ditolak',
            'catatan_diproses'        => 'nullable|string',
            'catatan_selesai'         => 'nullable|string',
            'jawaban'                 => 'nullable|string',
            'alasan_ditolak'          => 'nullable|string',
            'file_jawaban'            => 'nullable|file|extensions:pdf,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        $statusBaru = $request->input('status');

        // Logika 1: Jika Ditolak, Alasan Penolakan Wajib Diisi
        if ($statusBaru === 'Ditolak' && empty(trim($request->input('alasan_ditolak')))) {
            return redirect()->back()->withErrors(['alasan_ditolak' => 'Alasan penolakan wajib diisi.'])->withInput();
        }

        // Logika 1b: Jika Diproses, Catatan Diproses Wajib Diisi
        if ($statusBaru === 'Diproses' && empty(trim($request->input('catatan_diproses')))) {
            return redirect()->back()->withErrors(['catatan_diproses' => 'Pesan PPID wajib diisi.'])->withInput();
        }

        // Logika 2: Jika Selesai/Ditolak, Pesan PPID wajib diisi
        $catatanSelesaiInput = $request->input('catatan_selesai');
        if (in_array($statusBaru, ['Selesai', 'Ditolak'])) {
            if (empty(trim($catatanSelesaiInput ?? ''))) {
                return redirect()->back()->withErrors(['catatan_selesai' => 'Pesan PPID wajib diisi.'])->withInput();
            }
        }
        
        // Logika 3: Jika Selesai, Jawaban email wajib diisi
        $jawabanInput = $request->input('jawaban');
        if ($statusBaru === 'Selesai' && empty(trim($jawabanInput ?? ''))) {
            return redirect()->back()->withErrors(['jawaban' => 'Jawaban email wajib diisi.'])->withInput();
        }
        
        // Update Catatan & Status
        $permohonan->update([
            'status'                  => $statusBaru,
            'catatan_diproses'        => $request->input('catatan_diproses', $permohonan->catatan_diproses),
            'catatan_selesai'         => $catatanSelesaiInput ?: $permohonan->catatan_selesai,
            'jawaban'                 => $jawabanInput ?: $permohonan->jawaban,
            'alasan_ditolak'          => $request->input('alasan_ditolak') ?: $permohonan->alasan_ditolak,
        ]);

        // Upload Berkas Jawaban (single file, opsional)
        if ($request->hasFile('file_jawaban')) {
            $file = $request->file('file_jawaban');
            $path = $file->store('jawaban', 'public');
            $permohonan->jawabanFiles()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
            ]);
        }

        // Kirim Email Notifikasi
        $permohonan->load('jawabanFiles');
        $statusFinalEmail = ['Selesai', 'Ditolak'];
        if (in_array($permohonan->status, $statusFinalEmail)) {
            $recipientEmail = $permohonan->email ?? ($permohonan->user->email ?? null);
            if ($recipientEmail) {
                try {
                    $emailData = [
                        'nama'              => $permohonan->nama_lengkap ?? ($permohonan->user->nama_lengkap ?? 'Pemohon'),
                        'no_tiket'          => $permohonan->no_tiket,
                        'info_diminta'      => $permohonan->informasi_yang_diminta ?? '-',
                        'tujuan_permohonan' => $permohonan->tujuan_penggunaan_informasi ?? '-',
                        'files'             => $permohonan->jawabanFiles,
                    ];

                    if ($permohonan->status === 'Selesai') {
                        $emailData['catatan_selesai'] = $permohonan->jawaban;
                        $template = 'emails.permohonan_jawaban_selesai';
                        $subject  = 'Permohonan ' . $permohonan->no_tiket . ' Telah Selesai — PPID FMIPA Universitas Lampung';
                    } else {
                        $emailData['alasan_ditolak'] = $permohonan->alasan_ditolak;
                        $template = 'emails.permohonan_jawaban_ditolak';
                        $subject  = 'Permohonan ' . $permohonan->no_tiket . ' Tidak Dapat Dipenuhi — PPID FMIPA Universitas Lampung';
                    }

                    \Illuminate\Support\Facades\Mail::send($template, ['permohonan' => $emailData], function($m) use ($recipientEmail, $subject, $permohonan) {
                        $m->to($recipientEmail)->subject($subject);
                        foreach ($permohonan->jawabanFiles as $file) {
                            if (Storage::disk('public')->exists($file->file_path)) {
                                $m->attach(Storage::disk('public')->path($file->file_path), ['as' => $file->file_name]);
                            }
                        }
                    });
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal mengirim email permohonan jawaban: ' . $e->getMessage());
                }
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status permohonan ' . $permohonan->no_tiket . ' berhasil diperbarui menjadi ' . $permohonan->status . '.',
                'status'  => $permohonan->status
            ]);
        }

        return redirect()->back()->with('success', 'Status permohonan ' . $permohonan->no_tiket . ' berhasil diperbarui menjadi ' . $permohonan->status . '.');
    }

    /**
     * Hapus Tunggal Permohonan
     */
    public function destroy($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        
        // Hapus berkas lampiran jika ada
        if ($permohonan->file_identitas) {
            Storage::disk('public')->delete($permohonan->file_identitas);
        }
        if ($permohonan->identitas_file) {
            Storage::disk('public')->delete($permohonan->identitas_file);
        }
        foreach ($permohonan->jawabanFiles as $jf) {
            Storage::disk('public')->delete($jf->file_path);
            $jf->delete();
        }

        $permohonan->delete();

        return redirect()->back()->with('success', 'Data permohonan berhasil dihapus.');
    }

    /**
     * Hapus Massal (Bulk Delete) Permohonan
     */
    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $items = Permohonan::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                $fileIdentitas = $item->file_identitas ?? $item->identitas_file;
                if ($fileIdentitas) {
                    Storage::disk('public')->delete($fileIdentitas);
                }
                foreach ($item->jawabanFiles as $jf) {
                    Storage::disk('public')->delete($jf->file_path);
                    $jf->delete();
                }
                $item->delete();
            }
            return redirect()->back()->with('success', count($ids) . ' data permohonan berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada data permohonan yang dipilih.');
    }
}
