<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    /**
     * Halaman Admin: Manajemen Daftar Permohonan Informasi Publik
     */
    public function index(Request $request)
    {
        $query = Permohonan::query();

        // Pengurutan Waktu Pengajuan (Terbaru / Terlama)
        if ($request->input('urutan') === 'terlama') {
            $query->oldest();
        } else {
            $query->latest(); // Default: Terbaru
        }

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
            'pesan_diproses'          => 'nullable|string',
            'pesan_selesai'           => 'nullable|string',
            'alasan_ditolak'          => 'nullable|string',
            'pesan_ditolak'           => 'nullable|string',
            'file_jawaban'            => 'nullable|file|mimes:pdf,docx,xlsx,zip,rar|max:5120',
            'link_jawaban'            => 'nullable|url',
        ]);

        $statusBaru = $request->input('status');
        $alasanDitolak = $request->input('alasan_ditolak') ?: $request->input('pesan_ditolak');

        // Logika 1: Jika Ditolak, Alasan Penolakan Wajib Diisi
        if ($statusBaru === 'Ditolak' && empty(trim($alasanDitolak))) {
            return redirect()->back()->withErrors(['alasan_ditolak' => 'Alasan penolakan (pesan ditolak) wajib diisi sebelum menolak permohonan.'])->withInput();
        }

        // Logika 1b: Jika Diproses, Pesan Diproses Wajib Diisi
        if ($statusBaru === 'Diproses' && empty(trim($request->input('pesan_diproses')))) {
            return redirect()->back()->withErrors(['pesan_diproses' => 'Pesan untuk pemohon wajib diisi saat memproses permohonan.'])->withInput();
        }

        $fileUploaded = $request->file('file_jawaban');
        $linkInput = $request->input('link_jawaban');

        // Logika 2: Jika Selesai, Wajib ada Pesan untuk Pemohon
        if ($statusBaru === 'Selesai') {
            if (empty(trim($request->input('pesan_selesai')))) {
                return redirect()->back()->withErrors(['pesan_selesai' => 'Pesan untuk pemohon wajib diisi sebelum menyelesaikan permohonan.'])->withInput();
            }
        }

        // Upload Berkas Jawaban jika ada file baru
        $filePath = null;
        if (!empty($fileUploaded)) {
            if ($permohonan->file_jawaban) {
                Storage::disk('public')->delete($permohonan->file_jawaban);
            }
            $filePath = $fileUploaded->store('jawaban', 'public');
        }

        // Update Database dengan nama kolom baru
        $permohonan->update([
            'status'                  => $statusBaru,
            'pesan_diproses'          => $request->input('pesan_diproses', $permohonan->pesan_diproses),
            'pesan_selesai'           => $request->input('pesan_selesai', $permohonan->pesan_selesai),
            'alasan_ditolak'          => $alasanDitolak ?: $permohonan->alasan_ditolak,
            'file_jawaban'            => $filePath ?: $permohonan->file_jawaban,
            'link_jawaban'            => $linkInput ?: $permohonan->link_jawaban,
        ]);

        // Kirim Email Notifikasi Pembaruan Status ke Email Pemohon
        $recipientEmail = $permohonan->email ?? ($permohonan->user->email ?? null);
        if ($recipientEmail) {
            try {
                $pesanAktif = $permohonan->pesan_selesai ?: ($permohonan->alasan_ditolak ?: $permohonan->pesan_diproses);
                
                // Cek cara memperoleh informasi
                $caraPeroleh = strtolower($permohonan->cara_memperoleh_informasi ?? '');
                $isKirimEmail = str_contains($caraPeroleh, 'email');

                // Jika bukan lewat email (misal: mengambil langsung), file/link jawaban tidak dikirimkan lewat email
                $fileJawabanEmail = $isKirimEmail ? $permohonan->file_jawaban : null;
                $linkJawabanEmail = $isKirimEmail ? $permohonan->link_jawaban : null;

                $emailData = [
                    'nama'          => $permohonan->nama_lengkap ?? 'Pemohon',
                    'no_tiket'      => $permohonan->no_tiket,
                    'status'        => $permohonan->status,
                    'pesan'         => $pesanAktif,
                    'file_jawaban'  => $fileJawabanEmail,
                    'link_jawaban'  => $linkJawabanEmail,
                ];

                \Illuminate\Support\Facades\Mail::send('emails.permohonan_status_berubah', ['permohonan' => $emailData], function($m) use ($recipientEmail, $permohonan) {
                    $m->to($recipientEmail)->subject('Pembaruan Status Permohonan Informasi ' . $permohonan->no_tiket . ' - PPID FMIPA Unila');
                });
            } catch (\Exception $e) {
                // Ignore mail sending failure
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
        if ($permohonan->identitas_file) {
            Storage::disk('public')->delete($permohonan->identitas_file);
        }
        if ($permohonan->file_jawaban) {
            Storage::disk('public')->delete($permohonan->file_jawaban);
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
                if ($item->identitas_file) {
                    Storage::disk('public')->delete($item->identitas_file);
                }
                if ($item->file_jawaban) {
                    Storage::disk('public')->delete($item->file_jawaban);
                }
                $item->delete();
            }
            return redirect()->back()->with('success', count($ids) . ' data permohonan berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada data permohonan yang dipilih.');
    }
}
