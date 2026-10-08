<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    /**
     * Menampilkan Form Permohonan Informasi Publik bagi Pemohon
     */
    public function index()
    {
        return view('masyarakat.layanan.permohonan.index');
    }

    /**
     * Menyimpan Data Permohonan Informasi Publik ke Database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'          => 'required|string|max:255',
            'jenis_identitas'        => 'required|string|in:KTP,Paspor,Badan hukum',
            'no_identitas'           => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) use ($request) {
                    $jenis = $request->input('jenis_identitas');
                    if ($jenis === 'KTP') {
                        if (!preg_match('/^[0-9]{16}$/', $value)) {
                            $fail('Nomor Induk Kependudukan (NIK) harus terdiri dari 16 digit angka.');
                        }
                    } elseif ($jenis === 'Paspor') {
                        if (strlen($value) < 6 || strlen($value) > 20) {
                            $fail('Nomor Paspor harus memiliki panjang antara 6 sampai 20 karakter.');
                        }
                    } elseif ($jenis === 'Badan hukum') {
                        if (strlen($value) < 3) {
                            $fail('Nomor Akta Notaris / SK Pendirian tidak boleh kurang dari 3 karakter.');
                        }
                    }
                }
            ],
            'email'                  => 'required|email|max:255',
            'no_telepon'             => 'required|string|max:20',
            'alamat_lengkap'         => 'required|string|max:1000',
            'pekerjaan'              => 'required|string|max:255',
            'tujuan_penggunaan_informasi' => 'required|string',
            'informasi_yang_diminta' => 'required|string',
            'cara_memperoleh_informasi'   => 'required|string|in:Salinan Digital (Dikirim melalui Email),Datang Langsung ke Dekanat FMIPA Universitas Lampung,Dikirim melalui Email,Diambil langsung di Dekanat FMIPA Universitas Lampung,Melihat/Membaca di tempat',
            'file_identitas'         => 'required|file|extensions:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Normalisasi dan petakan jenis_permohonan secara otomatis
        $caraMemperoleh = $validated['cara_memperoleh_informasi'];
        $jenisPermohonan = ($caraMemperoleh === 'Salinan Digital (Dikirim melalui Email)' || $caraMemperoleh === 'Dikirim melalui Email') 
            ? 'Mendapatkan salinan' 
            : 'Melihat/Membaca di tempat atau Mengambil Salinan Fisik';

        // Upload File Identitas (KTP/Paspor/Akta) - Maks 2MB
        $identitasPath = null;
        $namaIdentitasAsli = null;
        if ($request->hasFile('file_identitas')) {
            $fileId = $request->file('file_identitas');
            $identitasPath = $fileId->store('identitas', 'public');
            $namaIdentitasAsli = $fileId->getClientOriginalName();
        }

        // Generate Nomor Tiket Otomatis yang Dijamin Unik (Format: PPID-YYYYMMDD-XXXX)
        $todayStr = date('Ymd');
        do {
            $random  = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 4));
            $noTiket = 'PPID-' . $todayStr . '-' . $random;
        } while (Permohonan::where('no_tiket', $noTiket)->exists());

        // Simpan ke Database (Tabel permohonans)
        $permohonan = Permohonan::create([
            'user_id'                        => null,
            'no_tiket'                       => $noTiket,
            'nama_lengkap'                   => $validated['nama_lengkap'],
            'jenis_identitas'                => $validated['jenis_identitas'],
            'no_identitas'                   => $validated['no_identitas'],
            'email'                          => $validated['email'],
            'no_telepon'                     => $validated['no_telepon'],
            'alamat_lengkap'                 => $validated['alamat_lengkap'],
            'pekerjaan'                      => $validated['pekerjaan'],
            'jenis_permohonan'               => $jenisPermohonan,
            'tujuan_penggunaan_informasi'    => $validated['tujuan_penggunaan_informasi'],
            'informasi_yang_diminta'         => $validated['informasi_yang_diminta'],
            'cara_memperoleh_informasi'      => $caraMemperoleh,
            'file_identitas'                 => $identitasPath,
            'nama_file_identitas_asli'       => $namaIdentitasAsli,
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
                    $m->to($recipientEmail)->subject('Permohonan Informasi Anda Telah Diterima - PPID FMIPA Universitas Lampung');
                });
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email permohonan baru: ' . $e->getMessage());
            }
        }

        return redirect()->route('layanan.permohonan')->with('success_tiket', $noTiket)->with('success', 'Permohonan Informasi Publik berhasil dikirim.');
    }
}
