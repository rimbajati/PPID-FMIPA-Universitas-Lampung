<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // --- TAMPILAN FORM (User) ---
    public function create()
    {
        // Mengambil daftar permohonan untuk keperluan dropdown Keberatan
        $permohonans = Permohonan::where('user_id', Auth::id())->latest()->get();
        return view('layanan.index', compact('permohonans'));
    }

    // --- ROUTER/DISPATCHER (Satu pintu untuk simpan form) ---
    public function store(Request $request)
    {
        $request->validate(['jenis_layanan' => 'required|in:permohonan,keberatan']);

        if ($request->jenis_layanan === 'permohonan') {
            return $this->storePermohonan($request);
        } else {
            return $this->storeKeberatan($request);
        }
    }

    // --- LOGIKA SIMPAN PERMOHONAN ---
    private function storePermohonan(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'pekerjaan'    => 'required|string',
            'alamat'       => 'required|string',
            'telepon'      => 'required|string|max:20',
            'identitas'    => 'required|file|mimes:jpg,png,pdf|max:2048',
            'info_diminta' => 'required|string',
            'tujuan'       => 'required|string',
            'cara_ambil'   => 'required|in:Mengambil Langsung,Email,WhatsApp',
            'pernyataan'   => 'accepted',
        ]);

        $path = $request->file('identitas')->store('identitas_pemohon', 'public');

        $permohonan = Permohonan::create([
            'user_id'        => Auth::id(),
            'nama'           => $request->nama,
            'pekerjaan'      => $request->pekerjaan,
            'alamat'         => $request->alamat,
            'telepon'        => $request->telepon,
            'email'          => auth()->user()->email,
            'file_identitas' => $path,
            'info_diminta'   => $request->info_diminta,
            'tujuan'         => $request->tujuan,
            'cara_ambil'     => $request->cara_ambil,
            'pernyataan'     => true,
            'status'         => 'DIAJUKAN',
        ]);

        $nomorTiket = 'REQ-' . date('Ymd') . '-' . str_pad($permohonan->id, 3, '0', STR_PAD_LEFT);
        $permohonan->update(['no_tiket' => $nomorTiket]);

        return redirect()->back()->with(['success' => 'Permohonan berhasil dikirim!', 'tiket' => $nomorTiket]);
    }

    // --- LOGIKA SIMPAN KEBERATAN ---
    private function storeKeberatan(Request $request)
    {
        $request->validate([
            'permohonan_id'     => 'required|exists:permohonans,id',
            'alasan_keberatan'  => 'required|string|min:15',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pernyataan'        => 'accepted',
        ]);

        // Keamanan: Cek apakah permohonan milik user login
        Permohonan::where('id', $request->permohonan_id)->where('user_id', Auth::id())->firstOrFail();

        $filePath = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $file = $request->file('dokumen_pendukung');
            $fileName = time() . '_keberatan_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('dokumen_keberatan', $fileName, 'public');
        }

        Keberatan::create([
            'permohonan_id'     => $request->permohonan_id,
            'user_id'           => Auth::id(),
            'alasan_keberatan'  => $request->alasan_keberatan,
            'dokumen_pendukung' => $filePath,
            'tanggal_pengajuan' => now(),
            'status_putusan'    => 'menunggu',
        ]);

        return redirect()->back()->with('success', 'Pengajuan keberatan berhasil dikirim.');
    }

    // --- ADMIN LOGIC (Dipertahankan dari PermohonanController) ---
    public function adminIndex(Request $request)
    {
        $status = $request->input('status');
        $query = Permohonan::query();
        if ($status) { $query->where('status', $status); }

        $permohonans = $query->latest()->paginate(10);

        $stats = [
            'totalPermohonan' => Permohonan::count(),
            'totalDiajukan'   => Permohonan::where('status', 'DIAJUKAN')->count(),
            'totalDiproses'   => Permohonan::where('status', 'DIPROSES')->count(),
            'totalDiterima'   => Permohonan::where('status', 'DITERIMA')->count(),
            'totalDitolak'    => Permohonan::where('status', 'DITOLAK')->count(),
        ];

        return view('admin.permohonan', array_merge(compact('permohonans'), $stats));
    }

    public function show($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('admin.permohonan_detail', compact('permohonan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'        => 'required|in:DIAJUKAN,DIPROSES,DITERIMA,DITOLAK',
            'catatan_admin' => 'nullable|string',
            'file_jawaban'  => 'nullable|file|max:5120'
        ]);

        $permohonan = Permohonan::findOrFail($id);
        if ($request->hasFile('file_jawaban')) {
            if ($permohonan->file_jawaban) Storage::disk('public')->delete($permohonan->file_jawaban);
            $permohonan->file_jawaban = $request->file('file_jawaban')->store('jawaban_admin', 'public');
        }

        $permohonan->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin
        ]);

        // Logic email tetap sama
        try {
            Mail::send('emails.status_permohonan', ['permohonan' => $permohonan], function($message) use ($permohonan) {
                $message->to($permohonan->email)->subject('Update Status Permohonan - ' . $permohonan->no_tiket);
                if ($permohonan->file_jawaban) $message->attach(storage_path('app/public/' . $permohonan->file_jawaban));
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Status diupdate, email gagal dikirim.');
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
