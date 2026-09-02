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
            'status'         => 'required|string|in:Diajukan,Diproses,Selesai,Ditolak',
            'pesan_diproses' => 'nullable|string',
            'pesan_selesai'  => 'nullable|string',
            'alasan_ditolak' => 'nullable|string',
            'file_jawaban'   => 'nullable|file|mimes:pdf,docx,xlsx|max:5120',
            'link_jawaban'   => 'nullable|url|max:255',
        ]);

        $statusInput = $validated['status'];

        // Jika Ditolak, Alasan Penolakan Wajib Diisi (alasan_ditolak)
        if ($statusInput === 'Ditolak' && empty(trim($request->input('alasan_ditolak')))) {
            return redirect()->back()->withErrors(['alasan_ditolak' => 'Alasan penolakan wajib diisi sebelum menolak pengajuan keberatan.'])->withInput();
        }

        // Jika Diproses, Pesan Diproses Wajib Diisi
        if ($statusInput === 'Diproses' && empty(trim($request->input('pesan_diproses')))) {
            return redirect()->back()->withErrors(['pesan_diproses' => 'Pesan untuk pemohon wajib diisi saat memproses pengajuan keberatan.'])->withInput();
        }

        // Jika Selesai/Dikabulkan, Pesan Selesai Wajib Diisi
        if ($statusInput === 'Selesai' && empty(trim($request->input('pesan_selesai')))) {
            return redirect()->back()->withErrors(['pesan_selesai' => 'Pesan untuk pemohon wajib diisi sebelum menyelesaikan keberatan.'])->withInput();
        }

        $updateData = [
            'status'         => $statusInput,
            'pesan_diproses' => $validated['pesan_diproses'] ?? $keberatan->pesan_diproses,
            'pesan_selesai'  => $validated['pesan_selesai'] ?? $keberatan->pesan_selesai,
            'alasan_ditolak'  => $validated['alasan_ditolak'] ?? $keberatan->alasan_ditolak,
            'link_jawaban'   => $validated['link_jawaban'] ?? null,
        ];

        if ($request->hasFile('file_jawaban')) {
            // Hapus file lama jika ada
            if ($keberatan->file_jawaban && Storage::disk('public')->exists($keberatan->file_jawaban)) {
                Storage::disk('public')->delete($keberatan->file_jawaban);
            }
            $updateData['file_jawaban'] = $request->file('file_jawaban')->store('jawaban', 'public');
        }

        $keberatan->update($updateData);

        // Kirim Notifikasi Email Pembaruan Keberatan
        $recipientEmail = $keberatan->permohonan->email ?? ($keberatan->user->email ?? null);
        if ($recipientEmail) {
            try {
                $pesanAktif = $keberatan->pesan_selesai ?: ($keberatan->alasan_ditolak ?: $keberatan->pesan_diproses);
                
                // Cek cara memperoleh informasi dari permohonan terkait
                $caraPeroleh = strtolower($keberatan->permohonan->cara_memperoleh_informasi ?? '');
                $isKirimEmail = str_contains($caraPeroleh, 'email');

                // Jika bukan lewat email (misal: mengambil langsung), file/link jawaban tidak dikirimkan lewat email
                $fileJawabanEmail = $isKirimEmail ? $keberatan->file_jawaban : null;
                $linkJawabanEmail = $isKirimEmail ? $keberatan->link_jawaban : null;

                $emailData = [
                    'nama'          => $keberatan->permohonan->nama_lengkap ?? ($keberatan->user->nama_lengkap ?? 'Pemohon'),
                    'no_tiket'      => $keberatan->no_tiket,
                    'status'        => $keberatan->status,
                    'pesan'         => $pesanAktif,
                    'file_jawaban'  => $fileJawabanEmail,
                    'link_jawaban'  => $linkJawabanEmail,
                ];

                \Illuminate\Support\Facades\Mail::send('emails.keberatan_status_berubah', ['keberatan' => $emailData], function($m) use ($recipientEmail, $keberatan) {
                    $m->to($recipientEmail)->subject('Pembaruan Status Pengajuan Keberatan ' . $keberatan->no_tiket . ' - PPID FMIPA Unila');
                });
            } catch (\Exception $e) {
                // Ignore mail sending failure
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
        
        if ($keberatan->file_jawaban) {
            Storage::disk('public')->delete($keberatan->file_jawaban);
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
                if ($item->file_jawaban) {
                    Storage::disk('public')->delete($item->file_jawaban);
                }
                $item->delete();
            }
            return redirect()->back()->with('success', count($ids) . ' data keberatan berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada data keberatan yang dipilih.');
    }
}
