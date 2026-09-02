<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeberatanController extends Controller
{
    /**
     * Menampilkan Halaman Formulir Pengajuan Keberatan bagi Pemohon
     */
    public function index()
    {
        $user = Auth::user();

        // Pemohon hanya boleh mengajukan keberatan jika permohonan sudah Selesai, Ditolak, 
        // ATAU berstatus Diajukan/Diproses tetapi sudah melampaui batas waktu 10 hari kerja.
        $permohonanUser = Permohonan::where('user_id', Auth::id())
            ->whereDoesntHave('keberatans')
            ->get()
            ->filter(function ($p) {
                if (in_array($p->status, ['Selesai', 'Ditolak'])) {
                    return true;
                }
                return $p->created_at && $p->created_at->diffInDays(now()) > 10;
            })
            ->values()
            ->map(function ($p) {
                return [
                    'id'                          => $p->id,
                    'no_tiket'                    => $p->no_tiket,
                    'informasi_yang_diminta'      => $p->informasi_yang_diminta,
                    'tujuan_penggunaan_informasi' => $p->tujuan_penggunaan_informasi,
                    'kategori_pemohon'            => $p->kategori_pemohon,
                    'nama_organisasi_lembaga'     => $p->nama_organisasi_lembaga,
                    'nik'                         => $p->no_identitas ?? $p->nik,
                    'nama_lengkap'                => $p->nama_lengkap ?? ($p->user->nama_lengkap ?? $p->user->name ?? ''),
                    'email'                       => $p->user->email ?? '',
                    'no_hp'                       => $p->no_telepon,
                    'alamat'                      => $p->alamat_lengkap,
                    'pekerjaan'                   => $p->pekerjaan,
                    'tgl_diajukan'                => $p->created_at ? $p->created_at->format('Y-m-d') : '',
                    'tgl_tanggapan'               => ($p->status !== 'Diajukan' && $p->updated_at) ? $p->updated_at->format('Y-m-d') : '',
                    'status'                      => $p->status ?? 'Diajukan',
                ];
            });

        return view('masyarakat.layanan.keberatan.index', compact('user', 'permohonanUser'));
    }

    /**
     * Menyimpan Data Pengajuan Keberatan ke Database (Tabel keberatans)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'permohonan_id'       => 'required|exists:permohonans,id',
            'alasan_keberatan'    => 'required|string',
            'kronologi_keberatan' => 'required|string',
            'pendukung_file'      => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png|max:5120',
        ]);

        $permohonan = Permohonan::findOrFail($request->permohonan_id);

        $isFinishedOrRejected = in_array($permohonan->status, ['Selesai', 'Ditolak']);
        $isOver10Days = $permohonan->created_at && $permohonan->created_at->diffInDays(now()) > 10;

        if (!$isFinishedOrRejected && !$isOver10Days) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Permohonan ' . $permohonan->no_tiket . ' masih dalam masa pelayanan resmi (kurang dari 10 hari kerja). Pengajuan keberatan hanya dapat dilakukan jika permohonan sudah selesai, ditolak, atau telah melampaui batas waktu 10 hari kerja.');
        }

        $existingKeberatan = Keberatan::where('permohonan_id', $request->permohonan_id)->first();
        if ($existingKeberatan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Permohonan ini (' . $existingKeberatan->permohonan->no_tiket . ') sudah pernah diajukan keberatan sebelumnya dengan Nomor Tiket ' . $existingKeberatan->no_tiket . '. Anda tidak dapat mengajukan keberatan ganda untuk permohonan yang sama.');
        }

        $pendukungPath = null;
        if ($request->hasFile('pendukung_file')) {
            $pendukungPath = $request->file('pendukung_file')->store('pendukung', 'public');
        }

        $todayStr = date('Ymd');
        $countToday = Keberatan::whereDate('created_at', date('Y-m-d'))->count();
        $seq = $countToday + 1;
        do {
            $nextSequence = str_pad($seq, 3, '0', STR_PAD_LEFT);
            $noTiket = 'KEB-' . $todayStr . '-' . $nextSequence;
            $seq++;
        } while (Keberatan::where('no_tiket', $noTiket)->exists());

        $keberatan = Keberatan::create([
            'user_id'             => Auth::id() ?? $permohonan->user_id,
            'permohonan_id'       => $permohonan->id,
            'no_tiket'            => $noTiket,
            'alasan_keberatan'    => $request->alasan_keberatan,
            'kronologi_keberatan' => $request->kronologi_keberatan,
            'file_pendukung'      => $pendukungPath,
            'status'              => 'Diajukan',
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
                    $m->to($recipientEmail)->subject('Pengajuan Keberatan ' . $noTiket . ' Berhasil Terkirim - PPID FMIPA Unila');
                });
            } catch (\Exception $e) {
                // Ignore jika SMTP gagal
            }
        }

        return redirect()->route('layanan.riwayat')->with('success', 'Pengajuan keberatan Anda dengan Nomor Tiket ' . $noTiket . ' berhasil dikirim!');
    }
}
