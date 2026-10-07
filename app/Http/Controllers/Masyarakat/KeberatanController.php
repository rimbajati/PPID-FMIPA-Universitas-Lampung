<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class KeberatanController extends Controller
{
    /**
     * Menampilkan Halaman Formulir Pengajuan Keberatan bagi Pemohon
     */
    public function index()
    {
        return view('masyarakat.layanan.keberatan.index');
    }

    /**
     * Menyimpan Data Pengajuan Keberatan ke Database (Tabel keberatans)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_tiket_permohonan' => 'required|string|max:40',
            'email'               => 'required|email|max:255',
            'alasan_keberatan'    => 'required|string',
            'kronologi_keberatan' => 'required|string',
            'pendukung_file'      => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png|max:5120',
        ]);

        $permohonan = Permohonan::whereRaw('UPPER(no_tiket) = ?', [strtoupper($validated['no_tiket_permohonan'])])
            ->whereRaw('LOWER(email) = ?', [strtolower($validated['email'])])
            ->first();

        if (!$permohonan) {
            return back()->withInput()->withErrors([
                'no_tiket_permohonan' => 'Nomor tiket dan email tidak cocok dengan permohonan yang terdaftar.',
            ]);
        }

        $isFinishedOrRejected = in_array($permohonan->status, ['Selesai', 'Ditolak']);
        $isOver10Days = $permohonan->created_at && $permohonan->created_at->diffInDays(now()) > 10;

        if (!$isFinishedOrRejected && !$isOver10Days) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Permohonan ' . $permohonan->no_tiket . ' masih dalam masa pelayanan resmi (kurang dari 10 hari kerja). Pengajuan keberatan hanya dapat dilakukan jika permohonan sudah selesai, ditolak, atau telah melampaui batas waktu 10 hari kerja.');
        }

        $existingKeberatan = Keberatan::where('permohonan_id', $permohonan->id)->first();
        if ($existingKeberatan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Permohonan dengan tiket ' . $existingKeberatan->permohonan->no_tiket . ' sudah pernah diajukan keberatan sebelumnya. Anda tidak dapat mengajukan keberatan ganda untuk permohonan yang sama.');
        }

        $pendukungPath = null;
        $namaPendukungAsli = null;
        if ($request->hasFile('pendukung_file')) {
            $filePendukung = $request->file('pendukung_file');
            $pendukungPath = $filePendukung->store('pendukung', 'public');
            $namaPendukungAsli = $filePendukung->getClientOriginalName();
        }

        // Generate nomor tiket keberatan baru (format: PPID-YYYYMMDD-XXXX)
        $today = now()->format('Ymd');
        $randomCode = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4));
        $noTiket = "PPID-{$today}-{$randomCode}";

        $keberatan = Keberatan::create([
            'user_id'                  => null,
            'permohonan_id'            => $permohonan->id,
            'no_tiket'                 => $noTiket,
            'alasan_keberatan'         => $request->alasan_keberatan,
            'kronologi_keberatan'      => $request->kronologi_keberatan,
            'file_pendukung'           => $pendukungPath,
            'nama_file_pendukung_asli' => $namaPendukungAsli,
            'status'                   => 'Diajukan',
        ]);

        // Kirim Email Bukti Pengajuan Keberatan Baru
        $recipientEmail = $permohonan->email ?? ($permohonan->user->email ?? null);
        if ($recipientEmail) {
            try {
                $emailData = (object)[
                    'nama'             => $permohonan->nama_lengkap ?? 'Pemohon',
                    'no_tiket'         => $noTiket,
                    'status'           => 'Diajukan',
                    'alasan_keberatan' => $request->alasan_keberatan,
                ];

                \Illuminate\Support\Facades\Mail::send('emails.keberatan_dikirim', ['keberatan' => $emailData], function($m) use ($recipientEmail, $noTiket) {
                    $m->to($recipientEmail)->subject('Pengajuan Keberatan ' . $noTiket . ' Berhasil Terkirim - PPID FMIPA Universitas Lampung');
                });
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email keberatan baru: ' . $e->getMessage());
            }
        }

        return redirect()->route('layanan.keberatan')
            ->with('success_keberatan_tiket', $noTiket)
            ->with('success', 'Pengajuan keberatan Anda dengan Nomor Tiket ' . $noTiket . ' berhasil dikirim!');
    }
}
