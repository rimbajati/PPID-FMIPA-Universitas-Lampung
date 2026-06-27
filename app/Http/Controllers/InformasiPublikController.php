<?php

namespace App\Http\Controllers;

use App\Models\InformasiPublik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiPublikController extends Controller
{
    // 1. LOKET MASYARAKAT
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        $query = InformasiPublik::query();

        if (!empty($search)) {
            $searchTerm = strtolower(trim($search));
            $query->whereRaw('LOWER(judul_informasi) LIKE ?', ["%$searchTerm%"]);
        }
        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        $informasi = $query->latest()->paginate(6);
        $informasi->appends($request->all());

        return view('public.informasi_publik', compact('informasi'));
    }

    // 2. LOKET ADMIN
    public function adminIndex(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');

        $totalInformasi  = InformasiPublik::count();
        $totalBerkala    = InformasiPublik::where('kategori', 'Informasi Berkala')->count();
        $totalSertaMerta = InformasiPublik::where('kategori', 'Informasi Serta-Merta')->count();
        $totalSetiapSaat = InformasiPublik::where('kategori', 'Informasi Setiap Saat')->count();

        $query = InformasiPublik::query();

        // LOGIKA PENCARIAN DIPERBAIKI: Menggunakan lowercase agar tidak sensitif huruf besar/kecil
        if (!empty($search)) {
            $searchTerm = strtolower(trim($search));
            $query->whereRaw('LOWER(judul_informasi) LIKE ?', ["%$searchTerm%"]);
        }
        if (!empty($kategori)) {
            $query->where('kategori', $kategori);
        }

        $informasi = $query->latest()->paginate(10);
        $informasi->appends($request->all());

        return view('admin.informasi_publik', compact(
            'informasi', 'totalInformasi', 'totalBerkala', 'totalSertaMerta', 'totalSetiapSaat'
        ));
    }

    public function create()
    {
        return view('admin.informasi_publik_create');
    }

    public function store(Request $request)
    {
        $rules = [
            'judul_informasi' => 'required|string|max:255',
            'kategori'        => 'required',
            'tahun_publikasi' => 'required|digits:4',
            'opsi_format'     => 'required|in:file,link',
        ];

        if ($request->opsi_format == 'file') {
            $rules['berkas'] = 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240';
        } else {
            $rules['url_link'] = 'required|url';
        }

        $request->validate($rules);

        $informasi = new InformasiPublik();
        $informasi->judul_informasi = $request->judul_informasi;
        $informasi->kategori        = $request->kategori;
        $informasi->tahun_publikasi = $request->tahun_publikasi;
        $informasi->deskripsi       = $request->deskripsi;

        if ($request->opsi_format == 'file') {
            $path = $request->file('berkas')->store('informasi', 'public');
            $informasi->tipe_informasi  = $request->file('berkas')->getClientOriginalExtension();
            $informasi->jalur_informasi = 'storage/' . $path;
        } else {
            $informasi->tipe_informasi  = 'link';
            $informasi->jalur_informasi = $request->url_link;
        }

        $informasi->save();
        return redirect('/admin/informasi-publik')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $informasi = InformasiPublik::findOrFail($id);
        return view('admin.informasi_publik_create', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $informasi = InformasiPublik::findOrFail($id);

        $rules = [
            'judul_informasi' => 'required|string|max:255',
            'kategori'        => 'required',
            'tahun_publikasi' => 'required|digits:4',
            'opsi_format'     => 'required|in:file,link',
        ];

        if ($request->opsi_format == 'file' && $request->hasFile('berkas')) {
            $rules['berkas'] = 'file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240';
        } elseif ($request->opsi_format == 'link') {
            $rules['url_link'] = 'required|url';
        }

        $request->validate($rules);

        $informasi->judul_informasi = $request->judul_informasi;
        $informasi->kategori        = $request->kategori;
        $informasi->tahun_publikasi = $request->tahun_publikasi;
        $informasi->deskripsi       = $request->deskripsi;

        if ($request->opsi_format == 'file') {
            if ($request->hasFile('berkas')) {
                if ($informasi->tipe_informasi !== 'link') {
                    Storage::delete(str_replace('storage/', '', $informasi->jalur_informasi));
                }
                $path = $request->file('berkas')->store('informasi', 'public');
                $informasi->tipe_informasi  = $request->file('berkas')->getClientOriginalExtension();
                $informasi->jalur_informasi = 'storage/' . $path;
            }
        } else {
            if ($informasi->tipe_informasi !== 'link') {
                Storage::delete(str_replace('storage/', '', $informasi->jalur_informasi));
            }
            $informasi->tipe_informasi  = 'link';
            $informasi->jalur_informasi = $request->url_link;
        }

        $informasi->save();
        return redirect('/admin/informasi-publik')->with('success', 'Arsip berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $informasi = InformasiPublik::findOrFail($id);
        if ($informasi->tipe_informasi !== 'link') {
            Storage::delete(str_replace('storage/', '', $informasi->jalur_informasi));
        }
        $informasi->delete();

        return redirect('/admin/informasi-publik')->with('success', 'Arsip berhasil dihapus!');
    }
}
