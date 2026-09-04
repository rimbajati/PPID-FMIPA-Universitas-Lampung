<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermohonanController extends Controller
{
    /**
     * Menampilkan Form Permohonan Informasi Publik bagi Pemohon
     */
    public function index()
    {
        $user = Auth::user();
        return view('masyarakat.layanan.permohonan.index', compact('user'));
    }

    /**
     * Menyimpan Data Permohonan Informasi Publik ke Database
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'kategori_pemohon'       => 'required|string|in:Perorangan,Kelompok,Organisasi,Lembaga',
            'nama_organisasi_lembaga'=> 'nullable|required_if:kategori_pemohon,Organisasi,Lembaga|string|max:255',
            'no_identitas'           => 'required|string|max:50',
            'no_telepon'             => 'required|string|max:20',
            'alamat_lengkap'         => 'required|string',
            'pekerjaan'              => 'required|string|max:255',
            'tujuan_penggunaan_informasi' => 'required|string',
            'informasi_yang_diminta' => 'required|string',
            'cara_memperoleh_informasi'   => 'required|string|max:255',
            'file_identitas'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_pendukung'         => 'nullable|file|mimes:pdf,docx|max:5120',
        ]);

        // Upload File Identitas (KTP/SIM) - Maks 2MB
        $identitasPath = null;
        if ($request->hasFile('file_identitas')) {
            $identitasPath = $request->file('file_identitas')->store('identitas', 'public');
        }

        // Upload File Pendukung (Opsional) - Maks 5MB
        $pendukungPath = null;
        if ($request->hasFile('file_pendukung')) {
            $pendukungPath = $request->file('file_pendukung')->store('pendukung', 'public');
        }

        // Generate Nomor Tiket Otomatis yang Dijamin Unik (Format: PER-YYYYMMDD-XXX)
        $todayStr = date('Ymd');
        $countToday = Permohonan::whereDate('created_at', date('Y-m-d'))->count();
        $seq = $countToday + 1;
        do {
            $nextSequence = str_pad($seq, 3, '0', STR_PAD_LEFT);
            $noTiket = 'PER-' . $todayStr . '-' . $nextSequence;
            $seq++;
        } while (Permohonan::where('no_tiket', $noTiket)->exists());

        // Simpan ke Database (Tabel permohonans)
        $permohonan = Permohonan::create([
            'user_id'                        => Auth::id(),
            'no_tiket'                       => $noTiket,
            'kategori_pemohon'               => $validated['kategori_pemohon'],
            'nama_organisasi_lembaga'        => in_array($validated['kategori_pemohon'], ['Organisasi', 'Lembaga']) ? ($validated['nama_organisasi_lembaga'] ?? null) : null,
            'no_identitas'                   => $validated['no_identitas'],
            'nama_lengkap'                   => $user ? ($user->nama_lengkap ?? $user->name) : $request->input('nama_lengkap'),
            'email'                          => $user ? $user->email : $request->input('email'),
            'no_telepon'                     => $validated['no_telepon'],
            'alamat_lengkap'                 => $validated['alamat_lengkap'],
            'pekerjaan'                      => $validated['pekerjaan'],
            'tujuan_penggunaan_informasi'    => $validated['tujuan_penggunaan_informasi'],
            'informasi_yang_diminta'         => $validated['informasi_yang_diminta'],
            'cara_memperoleh_informasi'      => $validated['cara_memperoleh_informasi'],
            'file_identitas'                 => $identitasPath,
            'file_pendukung'                 => $pendukungPath,
            'status'                         => 'Diajukan',
        ]);

        // Kirim Email Bukti Pengajuan Permohonan Baru
        $recipientEmail = $permohonan->email ?? ($permohonan->user->email ?? null);
        if ($recipientEmail) {
            try {
                $emailData = (object)[
                    'nama'              => $permohonan->nama_lengkap ?? 'Pemohon',
                    'no_tiket'          => $permohonan->no_tiket,
                    'status'            => 'Diajukan',
                    'info_diminta'      => $permohonan->informasi_yang_diminta,
                    'tujuan_permohonan' => $permohonan->tujuan_penggunaan_informasi,
                ];

                \Illuminate\Support\Facades\Mail::send('emails.permohonan_dikirim', ['permohonan' => $emailData], function($m) use ($recipientEmail, $permohonan) {
                    $m->to($recipientEmail)->subject('Permohonan Informasi Berhasil Masuk ke Sistem PPID FMIPA Universitas Lampung');
                });
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email permohonan baru: ' . $e->getMessage());
            }
        }

        return redirect()->route('layanan')->with('success_tiket', $noTiket)->with('success', 'Permohonan Informasi Publik berhasil dikirim.');
    }
}
