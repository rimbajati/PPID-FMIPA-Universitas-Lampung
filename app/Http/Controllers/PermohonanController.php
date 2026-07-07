<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    // --- MASYARAKAT ---
    public function create()
    {
        return view('layanan.permohonan', [
            'user' => auth()->user()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'pekerjaan'    => 'required|string',
            'alamat'       => 'required|string',
            'telepon'      => 'required|string|max:20',
            'email'        => 'required|email',
            'identitas'    => 'required|file|mimes:jpg,png,pdf|max:2048',
            'info_diminta' => 'required|string',
            'tujuan'       => 'required|string',
            'cara_ambil'   => 'required|in:Mengambil Langsung,Email,WhatsApp',
            'pernyataan'   => 'accepted',
        ], [
            'nama.required'         => 'Nama lengkap wajib diisi.',
            'pekerjaan.required'    => 'Silakan pilih pekerjaan Anda.',
            'alamat.required'       => 'Alamat lengkap wajib diisi.',
            'telepon.required'      => 'Nomor telepon wajib diisi.',
            'email.required'        => 'Alamat email wajib diisi.',
            'identitas.required'    => 'File kartu identitas wajib diupload.',
            'identitas.mimes'       => 'Format file harus JPG, PNG, atau PDF.',
            'identitas.max'         => 'Ukuran file maksimal 2 MB.',
            'info_diminta.required' => 'Rincian informasi wajib diisi.',
            'tujuan.required'       => 'Tujuan penggunaan informasi wajib diisi.',
            'cara_ambil.required'   => 'Silakan pilih cara pengambilan informasi.',
            'pernyataan.accepted'   => 'Anda wajib menyetujui pernyataan ini.',
        ]);

        if (!$request->hasFile('identitas')) {
            return back()->withErrors(['identitas' => 'File identitas tidak terdeteksi.']);
        }

        $path = $request->file('identitas')->store('identitas_pemohon', 'public');

        $permohonan = Permohonan::create([
            'user_id'        => Auth::id(),
            'nama'           => $request->nama,
            'pekerjaan'      => $request->pekerjaan,
            'alamat'         => $request->alamat,
            'telepon'        => $request->telepon,
            'email'          => $request->email,
            'file_identitas' => $path,
            'info_diminta'   => $request->info_diminta,
            'tujuan'         => $request->tujuan,
            'cara_ambil'     => $request->cara_ambil,
            'pernyataan'     => true,
            'status'         => 'DIAJUKAN',
        ]);

        $nomorTiket = 'REQ-' . date('Ymd') . '-' . str_pad($permohonan->id, 3, '0', STR_PAD_LEFT);
        $permohonan->update(['no_tiket' => $nomorTiket]);

        return redirect()->route('permohonan.create')->with([
            'success' => 'Permohonan berhasil dikirim!',
            'tiket'   => $nomorTiket
        ]);
    }

    // --- ADMIN: DAFTAR PERMOHONAN ---
    public function adminIndex(Request $request)
    {
        $status = $request->input('status');
        $query = Permohonan::query();
        if ($status) { $query->where('status', $status); }

        $permohonans = $query->latest()->paginate(10);

        $totalPermohonan = Permohonan::count();
        $totalDiajukan   = Permohonan::where('status', 'DIAJUKAN')->count();
        $totalDiproses   = Permohonan::where('status', 'DIPROSES')->count();
        $totalDiterima   = Permohonan::where('status', 'DITERIMA')->count();
        $totalDitolak    = Permohonan::where('status', 'DITOLAK')->count();

        return view('admin.permohonan', compact(
            'permohonans', 'totalPermohonan', 'totalDiajukan', 'totalDiproses', 'totalDiterima', 'totalDitolak'
        ));
    }

    // --- ADMIN: DETAIL PERMOHONAN ---
    public function show($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        return view('admin.permohonan_detail', compact('permohonan'));
    }

    // --- ADMIN: EKSEKUSI/UPDATE STATUS & EMAIL ---
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'        => 'required|in:DIAJUKAN,DIPROSES,DITERIMA,DITOLAK',
            'catatan_admin' => 'nullable|string',
            'file_jawaban'  => 'nullable|file|max:5120'
        ]);

        $permohonan = Permohonan::findOrFail($id);

        if ($request->hasFile('file_jawaban')) {
            if ($permohonan->file_jawaban) {
                Storage::disk('public')->delete($permohonan->file_jawaban);
            }
            $permohonan->file_jawaban = $request->file('file_jawaban')->store('jawaban_admin', 'public');
        }

        $permohonan->status = $request->status;
        $permohonan->catatan_admin = $request->catatan_admin;
        $permohonan->save();

        try {
            Mail::send('emails.status_permohonan', ['permohonan' => $permohonan], function($message) use ($permohonan) {
                $message->to($permohonan->email)
                        ->subject('Update Status Permohonan - ' . $permohonan->no_tiket)
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

                if ($permohonan->file_jawaban) {
                    $message->attach(storage_path('app/public/' . $permohonan->file_jawaban));
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Status diupdate, namun email gagal dikirim: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui & notifikasi email telah dikirim!');
    }
}
