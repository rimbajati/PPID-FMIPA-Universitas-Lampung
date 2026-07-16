<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengajuanSubmittedMail;
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
        $pengajuans = Pengajuan::with('statusHistories')->where('user_id', Auth::id())->latest()->get();
        $permohonans = Pengajuan::with('statusHistories')->where('jenis_layanan', 'Permohonan')->where('user_id', Auth::id())->latest()->get();
        return view('pemohon.layanan.index', compact('pengajuans', 'permohonans'));
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
            'identitas'          => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'akta_pendirian'     => 'required_if:kategori_pemohon,LSM/NGO,Instansi Pemerintah,Lembaga Pemerintah|nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'lampiran_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'info_diminta'       => 'required|string',
            'tujuan'             => 'required|string',
            'cara_ambil'         => 'required|in:Mengambil langsung ke FMIPA,Melalui Email atau Website',
            'pernyataan'         => 'accepted',
        ], [
            'pernyataan.accepted'       => 'Anda wajib menyetujui pernyataan kebenaran data.',
            'identitas.required'        => 'Lampiran Identitas wajib diunggah.',
            'identitas.mimes'           => 'Format lampiran identitas harus berupa JPG, JPEG, atau PNG.',
            'identitas.max'             => 'Ukuran lampiran identitas maksimal 2 MB.',
            'akta_pendirian.required_if'=> 'Akta Pendirian wajib diunggah untuk kategori ini.',
            'akta_pendirian.mimes'      => 'Format akta pendirian harus berupa JPG, JPEG, PNG, atau PDF.',
            'akta_pendirian.max'        => 'Ukuran akta pendirian maksimal 2 MB.',
            'lampiran_pendukung.mimes'  => 'Format lampiran data pendukung harus berupa JPG, JPEG, PNG, atau PDF.',
            'lampiran_pendukung.max'    => 'Ukuran lampiran data pendukung maksimal 2 MB.',
            'pekerjaan.required'        => 'Pekerjaan wajib dipilih.',
            'kategori_pemohon.required' => 'Kategori pemohon wajib dipilih.',
            'alamat.required'           => 'Alamat wajib diisi.',
            'telepon.required'          => 'Nomor telepon wajib diisi.',
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

            $data->statusHistories()->create([
                'status' => 'DIAJUKAN',
                'catatan' => null,
            ]);

            DB::commit();

            // Kirim notifikasi email ke pemohon
            try {
                $emailUser = Auth::user()->email;
                Mail::to($emailUser)->send(new PengajuanSubmittedMail($data));
            } catch (\Exception $mailEx) {
                Log::warning('Gagal mengirim email notifikasi permohonan: ' . $mailEx->getMessage());
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permohonan berhasil dikirim!',
                    'tiket' => $nomorTiket
                ]);
            }

            return redirect()->back()->with(['success' => 'Permohonan berhasil dikirim!', 'tiket' => $nomorTiket]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan permohonan: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    private function storeKeberatan(Request $request)
    {
        $request->validate([
            'permohonan_terkait_id' => 'required|exists:pengajuans,id',
            'tujuan_keberatan'      => 'required|string',
            'alasan_keberatan'      => 'required|string',
            'lampiran_pendukung'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'dokumen_pendukung'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
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
            'lampiran_pendukung.mimes'       => 'Format lampiran data pendukung harus berupa JPG, JPEG, PNG, atau PDF.',
            'lampiran_pendukung.max'         => 'Ukuran lampiran data pendukung maksimal 2 MB.',
            'dokumen_pendukung.mimes'        => 'Format lampiran data pendukung harus berupa JPG, JPEG, PNG, atau PDF.',
            'dokumen_pendukung.max'          => 'Ukuran lampiran data pendukung maksimal 2 MB.',
            'no_identitas.required'          => 'Nomor identitas wajib diisi.',
            'telepon.required'               => 'Nomor Telepon wajib diisi.',
            'alamat.required'                => 'Alamat wajib diisi.',
            'pekerjaan.required'             => 'Pekerjaan wajib diisi.',
            'kategori_pemohon.required'      => 'Kategori pemohon wajib diisi.',
        ]);

        try {
            $filePath = null;
            if ($request->hasFile('lampiran_pendukung')) {
                $filePath = $request->file('lampiran_pendukung')->store('lampiran_pendukung', 'public');
            } elseif ($request->hasFile('dokumen_pendukung')) {
                $filePath = $request->file('dokumen_pendukung')->store('dokumen_keberatan', 'public');
            } else {
                // Inherit from the related permohonan
                $related = Pengajuan::find($request->permohonan_terkait_id);
                if ($related && $related->lampiran_pendukung) {
                    $filePath = $related->lampiran_pendukung;
                }
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

            $data->statusHistories()->create([
                'status' => 'DIAJUKAN',
                'catatan' => null,
            ]);

            // Kirim notifikasi email ke pemohon
            try {
                $emailUser = Auth::user()->email;
                Mail::to($emailUser)->send(new PengajuanSubmittedMail($data));
            } catch (\Exception $mailEx) {
                Log::warning('Gagal mengirim email notifikasi keberatan: ' . $mailEx->getMessage());
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengajuan keberatan berhasil dikirim.',
                    'tiket' => $nomorTiket
                ]);
            }

            return redirect()->back()->with(['success' => 'Pengajuan keberatan berhasil dikirim.', 'tiket' => $nomorTiket]);
        } catch (\Exception $e) {
            Log::error('Gagal simpan keberatan: ' . $e->getMessage());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function update(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->user_id != Auth::id()) {
            abort(403);
        }

        if ($pengajuan->status !== 'DIAJUKAN') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Pengajuan yang sedang diproses tidak dapat diubah.'], 403);
            }
            return redirect()->back()->with('error', 'Pengajuan yang sedang diproses tidak dapat diubah.');
        }

        if ($pengajuan->jenis_layanan === 'Permohonan') {
            $request->validate([
                'pekerjaan'          => 'required|string',
                'kategori_pemohon'   => 'required|string',
                'alamat'             => 'required|string',
                'telepon'            => 'required|string|max:20',
                'no_identitas'       => 'required|string',
                'identitas'          => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'akta_pendirian'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'lampiran_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'info_diminta'       => 'required|string',
                'tujuan'             => 'required|string',
                'cara_ambil'         => 'required|in:Mengambil langsung ke FMIPA,Melalui Email atau Website',
            ], [
                'identitas.mimes'           => 'Format lampiran identitas harus berupa JPG, JPEG, atau PNG.',
                'identitas.max'             => 'Ukuran lampiran identitas maksimal 2 MB.',
                'akta_pendirian.mimes'      => 'Format akta pendirian harus berupa JPG, JPEG, PNG, atau PDF.',
                'akta_pendirian.max'        => 'Ukuran akta pendirian maksimal 2 MB.',
                'lampiran_pendukung.mimes'  => 'Format lampiran data pendukung harus berupa JPG, JPEG, PNG, atau PDF.',
                'lampiran_pendukung.max'    => 'Ukuran lampiran data pendukung maksimal 2 MB.',
                'pekerjaan.required'        => 'Pekerjaan wajib dipilih.',
                'kategori_pemohon.required' => 'Kategori pemohon wajib dipilih.',
                'alamat.required'           => 'Alamat wajib diisi.',
                'telepon.required'          => 'Nomor Telepon wajib diisi.',
                'no_identitas.required'     => 'Nomor identitas wajib diisi.',
                'info_diminta.required'     => 'Rincian informasi wajib diisi.',
                'tujuan.required'           => 'Tujuan permohonan wajib diisi.',
                'cara_ambil.required'       => 'Cara memperoleh informasi wajib dipilih.',
            ]);

            try {
                DB::beginTransaction();

                $updateData = [
                    'pekerjaan'        => $request->pekerjaan,
                    'kategori_pemohon' => $request->kategori_pemohon,
                    'no_identitas'     => $request->no_identitas,
                    'alamat'           => $request->alamat,
                    'no_hp'            => $request->telepon,
                    'info_diminta'     => $request->info_diminta,
                    'tujuan_permohonan'=> $request->tujuan,
                    'cara_memperoleh'  => $request->cara_ambil,
                ];

                if ($request->hasFile('identitas')) {
                    $updateData['lampiran_identitas'] = $request->file('identitas')->store('identitas_pemohon', 'public');
                }
                if ($request->hasFile('akta_pendirian')) {
                    $updateData['akta_pendirian'] = $request->file('akta_pendirian')->store('akta_pendirian', 'public');
                }
                if ($request->hasFile('lampiran_pendukung')) {
                    $updateData['lampiran_pendukung'] = $request->file('lampiran_pendukung')->store('lampiran_pendukung', 'public');
                }

                $pengajuan->update($updateData);

                DB::commit();

                if ($request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Pengajuan permohonan berhasil diperbarui!']);
                }
                return redirect()->back()->with('success', 'Pengajuan permohonan berhasil diperbarui!');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Gagal update permohonan: ' . $e->getMessage());
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
                }
                return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
            }
        } else {
            $request->validate([
                'tujuan_keberatan'   => 'required|string',
                'alasan_keberatan'   => 'required|string',
                'lampiran_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'dokumen_pendukung'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ], [
                'lampiran_pendukung.mimes' => 'Format lampiran data pendukung harus berupa JPG, JPEG, PNG, atau PDF.',
                'lampiran_pendukung.max'   => 'Ukuran lampiran data pendukung maksimal 2 MB.',
                'dokumen_pendukung.mimes'  => 'Format lampiran data pendukung harus berupa JPG, JPEG, PNG, atau PDF.',
                'dokumen_pendukung.max'    => 'Ukuran lampiran data pendukung maksimal 2 MB.',
            ]);

            try {
                DB::beginTransaction();

                $updateData = [
                    'tujuan_keberatan' => $request->tujuan_keberatan,
                    'alasan_keberatan' => $request->alasan_keberatan,
                ];

                if ($request->hasFile('lampiran_pendukung')) {
                    $updateData['lampiran_pendukung'] = $request->file('lampiran_pendukung')->store('lampiran_pendukung', 'public');
                } elseif ($request->hasFile('dokumen_pendukung')) {
                    $updateData['lampiran_pendukung'] = $request->file('dokumen_pendukung')->store('dokumen_keberatan', 'public');
                }

                $pengajuan->update($updateData);

                DB::commit();

                if ($request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Pengajuan keberatan berhasil diperbarui!']);
                }
                return redirect()->back()->with('success', 'Pengajuan keberatan berhasil diperbarui!');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Gagal update keberatan: ' . $e->getMessage());
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
                }
                return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->user_id != Auth::id()) {
            abort(403);
        }

        if ($pengajuan->status !== 'DIAJUKAN') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Pengajuan yang sedang diproses tidak dapat dihapus.'], 403);
            }
            return redirect()->back()->with('error', 'Pengajuan yang sedang diproses tidak dapat dihapus.');
        }

        try {
            $pengajuan->delete();
            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Pengajuan berhasil dihapus!']);
            }
            return redirect()->back()->with('success', 'Pengajuan berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Gagal hapus pengajuan: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem.'], 500);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}
