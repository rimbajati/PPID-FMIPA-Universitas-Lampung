<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pengajuans = Pengajuan::where('user_id', Auth::id())->latest()->get();
        $permohonans = Pengajuan::where('jenis_layanan', 'Permohonan')->where('user_id', Auth::id())->latest()->get();
        return view('layanan.index', compact('pengajuans', 'permohonans'));
    }

    public function store(Request $request)
    {
        $request->validate(
            ['jenis_layanan' => 'required|in:Permohonan,Keberatan'],
            ['jenis_layanan.required' => 'Pilih jenis layanan terlebih dahulu.']
        );

        if ($request->jenis_layanan === 'Permohonan') {
            return $this->storePermohonan($request);
        } else {
            return $this->storeKeberatan($request);
        }
    }

    private function storePermohonan(Request $request)
    {
        $request->validate([
            'pekerjaan'          => 'required|string',
            'kategori_pemohon'   => 'required|string',
            'alamat'             => 'required|string',
            'telepon'            => 'required|string|max:20',
            'no_identitas'       => 'required|string',
            'identitas'          => 'required|file|mimes:jpg,png,pdf|max:2048',
            'akta_pendirian'     => 'required_if:kategori_pemohon,LSM/NGO,Instansi Pemerintah,Lembaga Pemerintah|nullable|file|mimes:jpg,png,pdf|max:2048',
            'lampiran_pendukung' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'info_diminta'       => 'required|string',
            'tujuan'             => 'required|string',
            'cara_ambil'         => 'required|in:Mengambil Langsung,Email,WhatsApp',
            'pernyataan'         => 'accepted',
        ], [
            'pernyataan.accepted'       => 'Anda wajib menyetujui pernyataan kebenaran data.',
            'identitas.required'        => 'Lampiran Identitas (KTP) wajib diunggah.',
            'akta_pendirian.required_if'=> 'Akta Pendirian wajib diunggah untuk kategori ini.',
            'pekerjaan.required'        => 'Pekerjaan wajib dipilih.',
            'kategori_pemohon.required' => 'Kategori pemohon wajib dipilih.',
            'alamat.required'           => 'Alamat wajib diisi.',
            'telepon.required'          => 'Nomor HP wajib diisi.',
            'no_identitas.required'     => 'Nomor identitas wajib diisi.',
            'info_diminta.required'     => 'Rincian informasi wajib diisi.',
            'tujuan.required'           => 'Tujuan permohonan wajib diisi.',
            'cara_ambil.required'       => 'Cara memperoleh informasi wajib dipilih.',
        ]);

        try {
            DB::beginTransaction();

            $pathIdentitas = $request->file('identitas')->store('identitas_pemohon', 'public');

            $pathAkta = null;
            if ($request->hasFile('akta_pendirian')) {
                $pathAkta = $request->file('akta_pendirian')->store('akta_pendirian', 'public');
            }

            $pathPendukung = null;
            if ($request->hasFile('lampiran_pendukung')) {
                $pathPendukung = $request->file('lampiran_pendukung')->store('lampiran_pendukung', 'public');
            }

            $data = Pengajuan::create([
                'user_id'            => Auth::id(),
                'jenis_layanan'      => 'Permohonan',
                'nama'               => Auth::user()->nama_lengkap,
                'pekerjaan'          => $request->pekerjaan,
                'kategori_pemohon'   => $request->kategori_pemohon,
                'no_identitas'       => $request->no_identitas,
                'alamat'             => $request->alamat,
                'no_hp'              => $request->telepon,
                'email'              => Auth::user()->email,
                'lampiran_identitas' => $pathIdentitas,
                'akta_pendirian'     => $pathAkta,
                'lampiran_pendukung' => $pathPendukung,
                'info_diminta'       => $request->info_diminta,
                'tujuan_permohonan'  => $request->tujuan,
                'cara_memperoleh'    => $request->cara_ambil,
                'status'             => 'DIAJUKAN',
                'no_tiket'           => 'TEMP',
            ]);

            $nomorTiket = 'PER-' . date('Ymd') . '-' . str_pad($data->id, 3, '0', STR_PAD_LEFT);
            $data->update(['no_tiket' => $nomorTiket]);

            DB::commit();
            return redirect()->back()->with(['success' => 'Permohonan berhasil dikirim!', 'tiket' => $nomorTiket]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan permohonan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    private function storeKeberatan(Request $request)
    {
        $request->validate([
            'permohonan_terkait_id' => 'required|exists:pengajuans,id',
            'tujuan_keberatan'      => 'required|string',
            'alasan_keberatan'      => 'required|string',
            'dokumen_pendukung'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pernyataan'            => 'accepted',
            'no_identitas'          => 'required|string',
            'telepon'               => 'required|string',
            'alamat'                => 'required|string',
            'pekerjaan'             => 'required|string',
            'kategori_pemohon'      => 'required|string',
        ], [
            'pernyataan.accepted'            => 'Anda wajib menyetujui pernyataan kebenaran data.',
            'permohonan_terkait_id.required' => 'Mohon pilih permohonan yang terkait.',
            'tujuan_keberatan.required'      => 'Tujuan mengajukan keberatan wajib diisi.',
            'alasan_keberatan.required'      => 'Alasan mengajukan keberatan wajib diisi.',
            'no_identitas.required'          => 'Nomor identitas wajib diisi.',
            'telepon.required'               => 'Nomor HP wajib diisi.',
            'alamat.required'                => 'Alamat wajib diisi.',
            'pekerjaan.required'             => 'Pekerjaan wajib diisi.',
            'kategori_pemohon.required'      => 'Kategori pemohon wajib diisi.',
        ]);

        try {
            $filePath = null;
            if ($request->hasFile('dokumen_pendukung')) {
                $filePath = $request->file('dokumen_pendukung')->store('dokumen_keberatan', 'public');
            }

            $data = Pengajuan::create([
                'user_id'               => Auth::id(),
                'jenis_layanan'         => 'Keberatan',
                'permohonan_terkait_id' => $request->permohonan_terkait_id,
                'tujuan_keberatan'      => $request->tujuan_keberatan,
                'alasan_keberatan'      => $request->alasan_keberatan,
                'lampiran_pendukung'    => $filePath,
                'status'                => 'DIAJUKAN',
                'no_tiket'              => 'TEMP',
                'nama'                  => Auth::user()->nama_lengkap,
                'email'                 => Auth::user()->email,
                'pekerjaan'             => $request->pekerjaan,
                'kategori_pemohon'      => $request->kategori_pemohon,
                'no_identitas'          => $request->no_identitas,
                'no_hp'                 => $request->telepon,
                'alamat'                => $request->alamat,
                'lampiran_identitas'    => '-'
            ]);

            $nomorTiket = 'KEB-' . date('Ymd') . '-' . str_pad($data->id, 3, '0', STR_PAD_LEFT);
            $data->update(['no_tiket' => $nomorTiket]);

            return redirect()->back()->with('success', 'Pengajuan keberatan berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Gagal simpan keberatan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}
