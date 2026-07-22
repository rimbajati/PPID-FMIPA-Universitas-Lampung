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

    public function index(Request $request)
    {
        $query = Pengajuan::with('statusHistories')->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_layanan')) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                  ->orWhere('info_diminta', 'like', "%{$search}%")
                  ->orWhere('tujuan_permohonan', 'like', "%{$search}%")
                  ->orWhere('tujuan_keberatan', 'like', "%{$search}%")
                  ->orWhere('alasan_keberatan', 'like', "%{$search}%");
            });
        }

        $pengajuans = $query->latest()->get();
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

            $pathIdentitas = $this->storeOriginalFile($request->file('identitas'), 'identitas_pemohon');

            $pathAkta = null;
            if ($request->hasFile('akta_pendirian')) {
                $pathAkta = $this->storeOriginalFile($request->file('akta_pendirian'), 'akta_pendirian');
            }

            $pathPendukung = null;
            if ($request->hasFile('lampiran_pendukung')) {
                $pathPendukung = $this->storeOriginalFile($request->file('lampiran_pendukung'), 'lampiran_pendukung');
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

            $today = date('Ymd');
            $countToday = Pengajuan::where('no_tiket', 'like', "PER-{$today}-%")->count();
            $nomorTiket = 'PER-' . $today . '-' . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
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

        $related = Pengajuan::where('id', $request->permohonan_terkait_id)
                            ->where('user_id', Auth::id())
                            ->where('jenis_layanan', 'Permohonan')
                            ->first();

        if (!$related) {
            $errorMsg = 'Permohonan informasi terkait tidak ditemukan atau bukan milik Anda.';
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMsg,
                    'errors'  => ['permohonan_terkait_id' => [$errorMsg]]
                ], 422);
            }
            return redirect()->back()->withErrors(['permohonan_terkait_id' => $errorMsg]);
        }

        try {
            $filePath = null;
            if ($request->hasFile('lampiran_pendukung')) {
                $filePath = $this->storeOriginalFile($request->file('lampiran_pendukung'), 'lampiran_pendukung');
            } elseif ($request->hasFile('dokumen_pendukung')) {
                $filePath = $this->storeOriginalFile($request->file('dokumen_pendukung'), 'dokumen_keberatan');
            } else {
                // Inherit from the related permohonan
                if ($related->lampiran_pendukung) {
                    $filePath = $related->lampiran_pendukung;
                }
            }

            $data = Pengajuan::create([
                'user_id'               => Auth::id(),
                'jenis_layanan'         => 'Keberatan',
                'permohonan_terkait_id' => $related->id,
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
                'lampiran_identitas'    => $related->lampiran_identitas ?: '-'
            ]);

            $today = date('Ymd');
            $countToday = Pengajuan::where('no_tiket', 'like', "KEB-{$today}-%")->count();
            $nomorTiket = 'KEB-' . $today . '-' . str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
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

        if (!in_array($pengajuan->status, ['DIAJUKAN', 'PERBAIKAN'])) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Pengajuan yang sedang diproses atau selesai tidak dapat diubah.'], 403);
            }
            return redirect()->back()->with('error', 'Pengajuan yang sedang diproses atau selesai tidak dapat diubah.');
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

                $isWasPerbaikan = $pengajuan->status === 'PERBAIKAN';

                $updateData = [
                    'pekerjaan'        => $request->pekerjaan,
                    'kategori_pemohon' => $request->kategori_pemohon,
                    'no_identitas'     => $request->no_identitas,
                    'alamat'           => $request->alamat,
                    'no_hp'            => $request->telepon,
                    'info_diminta'     => $request->info_diminta,
                    'tujuan_permohonan'=> $request->tujuan,
                    'cara_memperoleh'  => $request->cara_ambil,
                    'status'           => 'DIAJUKAN',
                ];

                if ($request->hasFile('identitas')) {
                    $updateData['lampiran_identitas'] = $this->storeOriginalFile($request->file('identitas'), 'identitas_pemohon');
                }
                if ($request->hasFile('akta_pendirian')) {
                    $updateData['akta_pendirian'] = $this->storeOriginalFile($request->file('akta_pendirian'), 'akta_pendirian');
                }
                if ($request->hasFile('lampiran_pendukung')) {
                    $updateData['lampiran_pendukung'] = $this->storeOriginalFile($request->file('lampiran_pendukung'), 'lampiran_pendukung');
                }

                $pengajuan->update($updateData);

                if ($isWasPerbaikan) {
                    $pengajuan->statusHistories()->create([
                        'status' => 'DIAJUKAN',
                        'catatan' => 'Pemohon telah memperbarui data pengajuan.',
                    ]);
                }

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
                    $updateData['lampiran_pendukung'] = $this->storeOriginalFile($request->file('lampiran_pendukung'), 'lampiran_pendukung');
                } elseif ($request->hasFile('dokumen_pendukung')) {
                    $updateData['lampiran_pendukung'] = $this->storeOriginalFile($request->file('dokumen_pendukung'), 'dokumen_keberatan');
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

    private function storeOriginalFile($file, $folder)
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $sanitized = preg_replace('/[^a-zA-Z0-9_\-\s]/', '', $originalName);
        $sanitized = trim(preg_replace('/\s+/', '_', $sanitized));
        if (empty($sanitized)) {
            $sanitized = 'file';
        }
        $filename = time() . '_' . $sanitized . '.' . $extension;
        return $file->storeAs($folder, $filename, 'public');
    }

    public function destroy(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->user_id != Auth::id()) {
            abort(403);
        }

        if ($pengajuan->status !== 'DIAJUKAN') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Hanya pengajuan berstatus diajukan yang dapat dihapus.'], 403);
            }
            return redirect()->back()->with('error', 'Hanya pengajuan berstatus diajukan yang dapat dihapus.');
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
