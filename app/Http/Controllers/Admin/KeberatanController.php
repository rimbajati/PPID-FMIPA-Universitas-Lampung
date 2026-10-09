<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeberatanController extends Controller
{
    /**
     * Dashboard Admin - Menampilkan Seluruh Pengajuan Keberatan
     */
    public function index(Request $request)
    {
        $query = Keberatan::with(['user', 'permohonan'])->latest();

        // Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Live Search berdasarkan Tiket, Nama/NIK via Permohonan, atau Alasan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'LIKE', "%{$search}%")
                  ->orWhere('alasan_keberatan', 'LIKE', "%{$search}%")
                  ->orWhereHas('permohonan', function ($pq) use ($search) {
                      $pq->where('nama_lengkap', 'LIKE', "%{$search}%")
                         ->orWhere('no_identitas', 'LIKE', "%{$search}%")
                         ->orWhere('no_tiket', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Statistik Overview
        $totalKeberatan = Keberatan::count();
        $totalMenunggu  = Keberatan::where('status', 'Diajukan')->count();
        $totalDiproses  = Keberatan::where('status', 'Diproses')->count();
        $totalSelesai   = Keberatan::where('status', 'Selesai')->count();
        $totalDitolak   = Keberatan::where('status', 'Ditolak')->count();

        $keberatans = $query->with(['permohonan', 'user'])->paginate(10)->withQueryString();

        return view('admin.keberatan.index', compact(
            'keberatans',
            'totalKeberatan',
            'totalMenunggu',
            'totalDiproses',
            'totalSelesai',
            'totalDitolak'
        ));
    }

    /**
     * Halaman Detail Pengajuan Keberatan
     */
    public function show($id)
    {
        $keberatan = Keberatan::with(['user', 'permohonan'])->findOrFail($id);

        return view('admin.keberatan.show', compact('keberatan'));
    }

    /**
     * Dashboard Admin - Update Status & Tanggapan Keberatan (Diajukan, Diproses, Selesai, Ditolak)
     */
    public function updateStatus(Request $request, $id)
    {
        $keberatan = Keberatan::findOrFail($id);

        // Proteksi: Status final (Selesai/Ditolak) tidak bisa diubah lagi
        $statusFinal = ['Selesai', 'Ditolak'];
        if (in_array($keberatan->status, $statusFinal)) {
            return redirect()->back()
                ->with('error', 'Keberatan ' . $keberatan->no_tiket . ' sudah berstatus "' . $keberatan->status . '" dan tidak dapat diubah lagi.');
        }

        $validated = $request->validate([
            'status'           => 'required|string|in:Diajukan,Diproses,Selesai,Ditolak',
            'catatan_diproses' => 'nullable|string',
            'catatan_selesai'  => 'nullable|string',
            'jawaban'          => 'nullable|string',
            'alasan_ditolak'   => 'nullable|string',
            'file_jawaban'     => 'nullable|file|extensions:pdf,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        $statusInput = $validated['status'];

        if ($statusInput === 'Ditolak' && empty(trim($request->input('alasan_ditolak')))) {
            return redirect()->back()->withErrors(['alasan_ditolak' => 'Alasan penolakan wajib diisi.'])->withInput();
        }

        if ($statusInput === 'Diproses' && empty(trim($request->input('catatan_diproses')))) {
            return redirect()->back()->withErrors(['catatan_diproses' => 'Pesan PPID wajib diisi.'])->withInput();
        }

        $catatanSelesaiInput = $validated['catatan_selesai'] ?? null;
        if (in_array($statusInput, ['Selesai', 'Ditolak'])) {
            if (empty(trim($catatanSelesaiInput ?? ''))) {
                return redirect()->back()->withErrors(['catatan_selesai' => 'Pesan PPID wajib diisi.'])->withInput();
            }
        }

        $jawabanInput = $request->input('jawaban');
        if ($statusInput === 'Selesai' && empty(trim($jawabanInput ?? ''))) {
            return redirect()->back()->withErrors(['jawaban' => 'Jawaban email wajib diisi.'])->withInput();
        }

        $updateData = [
            'status'           => $statusInput,
            'catatan_diproses' => $validated['catatan_diproses'] ?? $keberatan->catatan_diproses,
            'catatan_selesai'  => $catatanSelesaiInput ?: $keberatan->catatan_selesai,
            'jawaban'          => $jawabanInput ?: $keberatan->jawaban,
            'alasan_ditolak'   => $validated['alasan_ditolak'] ?? $keberatan->alasan_ditolak,
        ];

        $keberatan->update($updateData);

        // Upload Berkas Jawaban (single file, opsional)
        if ($request->hasFile('file_jawaban')) {
            $file = $request->file('file_jawaban');
            $path = $file->store('jawaban', 'public');
            $keberatan->jawabanFiles()->create([
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
            ]);
        }

        // Kirim Email Notifikasi
        $keberatan->load('jawabanFiles');
        $statusFinalEmail = ['Selesai', 'Ditolak'];
        if (in_array($keberatan->status, $statusFinalEmail)) {
            $recipientEmail = $keberatan->permohonan->email ?? ($keberatan->user->email ?? null);
            if ($recipientEmail) {
                try {
                    $emailData = [
                        'nama'             => $keberatan->permohonan->nama_lengkap ?? ($keberatan->user->nama_lengkap ?? 'Pemohon'),
                        'no_tiket'         => $keberatan->no_tiket,
                        'alasan_keberatan' => $keberatan->alasan_keberatan ?? '-',
                        'files'            => $keberatan->jawabanFiles,
                    ];

                    if ($keberatan->status === 'Selesai') {
                        $emailData['catatan_selesai'] = $keberatan->jawaban;
                        $template = 'emails.keberatan_jawaban_selesai';
                        $subject  = 'Keberatan ' . $keberatan->no_tiket . ' Telah Selesai Diproses — PPID FMIPA Universitas Lampung';
                    } else {
                        $emailData['alasan_ditolak'] = $keberatan->alasan_ditolak;
                        $template = 'emails.keberatan_jawaban_ditolak';
                        $subject  = 'Keberatan ' . $keberatan->no_tiket . ' Tidak Dapat Dipenuhi — PPID FMIPA Universitas Lampung';
                    }

                    \Illuminate\Support\Facades\Mail::send($template, ['keberatan' => $emailData], function($m) use ($recipientEmail, $subject, $keberatan) {
                        $m->to($recipientEmail)->subject($subject);
                        foreach ($keberatan->jawabanFiles as $file) {
                            if (Storage::disk('public')->exists($file->file_path)) {
                                $m->attach(Storage::disk('public')->path($file->file_path), ['as' => $file->file_name]);
                            }
                        }
                    });
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal mengirim email keberatan jawaban: ' . $e->getMessage());
                }
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pengajuan keberatan ' . $keberatan->no_tiket . ' berhasil diperbarui menjadi ' . $keberatan->status . '!',
                'status'  => $keberatan->status
            ]);
        }

        return redirect()->back()->with('success', 'Status pengajuan keberatan ' . $keberatan->no_tiket . ' berhasil diperbarui menjadi ' . $keberatan->status . '!');
    }

    /**
     * Hapus Tunggal Keberatan
     */
    public function destroy($id)
    {
        $keberatan = Keberatan::findOrFail($id);
        
        foreach ($keberatan->jawabanFiles as $jf) {
            Storage::disk('public')->delete($jf->file_path);
            $jf->delete();
        }

        $keberatan->delete();

        return redirect()->back()->with('success', 'Data keberatan berhasil dihapus.');
    }

    /**
     * Hapus Massal (Bulk Delete) Keberatan
     */
    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $items = Keberatan::whereIn('id', $ids)->get();
            foreach ($items as $item) {
                foreach ($item->jawabanFiles as $jf) {
                    Storage::disk('public')->delete($jf->file_path);
                    $jf->delete();
                }
                $item->delete();
            }
            return redirect()->back()->with('success', count($ids) . ' data keberatan berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada data keberatan yang dipilih.');
    }
}
