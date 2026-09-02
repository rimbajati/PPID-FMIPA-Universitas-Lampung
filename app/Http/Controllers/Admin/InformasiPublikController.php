<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InformasiPublikController extends Controller
{
    public function index(Request $request)
    {
        $query = InformasiPublik::query();

        $listJudul = InformasiPublik::distinct()->pluck('judul_informasi');
        $listTahun = InformasiPublik::whereNotNull('tahun_terbit')
                        ->where('tahun_terbit', '!=', '')
                        ->distinct()
                        ->orderBy('tahun_terbit', 'desc')
                        ->pluck('tahun_terbit');

        if ($request->filled('kategori')) {
            $query->where('kategori_informasi', $request->kategori);
        }

        if ($request->filled('judul')) {
            $query->where('judul_informasi', $request->judul);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(judul_informasi) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(deskripsi_informasi) LIKE ?', ["%{$term}%"]);
            });
        }

        // Sorting
        if ($request->sort == 'terlama') {
            $query->oldest();
        } elseif ($request->sort == 'judul_asc') {
            $query->orderBy('judul_informasi', 'asc');
        } elseif ($request->sort == 'judul_desc') {
            $query->orderBy('judul_informasi', 'desc');
        } else {
            $query->latest();
        }

        $totalInformasi = InformasiPublik::count();
        $totalSetiapSaat = InformasiPublik::where('kategori_informasi', 'Informasi Setiap Saat')->count();
        $totalBerkala = InformasiPublik::where('kategori_informasi', 'Informasi Berkala')->count();
        $totalSertaMerta = InformasiPublik::where('kategori_informasi', 'Informasi Serta-Merta')->count();
        $totalDikecualikan = InformasiPublik::where('kategori_informasi', 'Informasi Dikecualikan')->count();

        // Tanggal Update Terakhir per Kategori
        $lastUpdateTotal = InformasiPublik::max('updated_at');
        $lastUpdateBerkala = InformasiPublik::where('kategori_informasi', 'Informasi Berkala')->max('updated_at');
        $lastUpdateSertaMerta = InformasiPublik::where('kategori_informasi', 'Informasi Serta-Merta')->max('updated_at');
        $lastUpdateSetiapSaat = InformasiPublik::where('kategori_informasi', 'Informasi Setiap Saat')->max('updated_at');
        $lastUpdateDikecualikan = InformasiPublik::where('kategori_informasi', 'Informasi Dikecualikan')->max('updated_at');

        $informasi = $query->paginate(10)->appends($request->all());

        return view('admin.informasi_publik.index', compact(
            'informasi', 'listJudul', 'listTahun', 'totalInformasi', 'totalSetiapSaat', 'totalBerkala', 'totalSertaMerta', 'totalDikecualikan',
            'lastUpdateTotal', 'lastUpdateBerkala', 'lastUpdateSertaMerta', 'lastUpdateSetiapSaat', 'lastUpdateDikecualikan'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_informasi'     => 'required|string|max:100',
            'deskripsi_informasi' => 'required|string|max:200',
            'tahun_terbit'        => 'required|string|max:255',
            'kategori_informasi'  => ['required', Rule::in(['Informasi Setiap Saat', 'Informasi Berkala', 'Informasi Serta-Merta', 'Informasi Dikecualikan'])],
            'file_informasi'      => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'link_informasi'      => 'nullable|url',
        ], [
            'file_informasi.mimes' => 'Format file tidak didukung! Hanya diperbolehkan file PDF, DOC, DOCX, XLS, atau XLSX.',
            'file_informasi.max'   => 'Ukuran file melebihi batas maksimal (Maksimal 5 MB)!',
        ]);

        if ($request->hasFile('file_informasi')) {
            $file = $request->file('file_informasi');
            $path = $file->store('informasi_publik', 'local');
            $validated['file_informasi'] = $path;
            $validated['link_informasi'] = null;
            $validated['nama_file_asli'] = $file->getClientOriginalName();
        } else if ($request->filled('link_informasi')) {
            $validated['file_informasi'] = null;
            $validated['link_informasi'] = $request->link_informasi;
            $validated['nama_file_asli'] = null;
        } else {
            return back()->withErrors(['file_informasi' => 'Gagal menyimpan! Salah satu berkas file atau alamat tautan eksternal wajib diisi.'])->withInput();
        }

        InformasiPublik::create($validated);

        return redirect()->back()->with('success', 'Data Informasi Publik berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $info = InformasiPublik::findOrFail($id);

        $validated = $request->validate([
            'judul_informasi'     => 'required|string|max:255',
            'deskripsi_informasi' => 'required|string',
            'tahun_terbit'        => 'required|string|max:255',
            'kategori_informasi'  => ['required', Rule::in(['Informasi Setiap Saat', 'Informasi Berkala', 'Informasi Serta-Merta', 'Informasi Dikecualikan'])],
            'file_informasi'      => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'link_informasi'      => 'nullable|url',
        ], [
            'file_informasi.mimes' => 'Format file tidak didukung! Hanya diperbolehkan file PDF, DOC, DOCX, XLS, atau XLSX.',
            'file_informasi.max'   => 'Ukuran file melebihi batas maksimal (Maksimal 5 MB)!',
        ]);

        $inputFormat = $request->input('jenis_informasi', 'file');

        if ($inputFormat === 'file') {
            if ($request->hasFile('file_informasi')) {
                if ($info->file_informasi && Storage::disk('local')->exists($info->file_informasi)) {
                    Storage::disk('local')->delete($info->file_informasi);
                }
                $file = $request->file('file_informasi');
                $path = $file->store('informasi_publik', 'local');
                $validated['file_informasi'] = $path;
                $validated['link_informasi'] = null;
                $validated['nama_file_asli'] = $file->getClientOriginalName();
            } else {
                $validated['file_informasi'] = $info->file_informasi;
                $validated['link_informasi'] = null;
            }
        } else {
            if ($info->file_informasi && Storage::disk('local')->exists($info->file_informasi)) {
                Storage::disk('local')->delete($info->file_informasi);
            }
            $validated['file_informasi'] = null;
            $validated['link_informasi'] = $request->link_informasi;
            $validated['nama_file_asli'] = null;
        }

        $info->update($validated);

        return redirect()->back()->with('success', 'Data Informasi Publik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $info = InformasiPublik::findOrFail($id);
        if ($info->file_informasi && Storage::disk('local')->exists($info->file_informasi)) {
            Storage::disk('local')->delete($info->file_informasi);
        }
        $info->delete();
        return redirect()->back()->with('success', 'Data Informasi Publik berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $items = InformasiPublik::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file_informasi && Storage::disk('local')->exists($item->file_informasi)) {
                Storage::disk('local')->delete($item->file_informasi);
            }
            $item->delete();
        }

        return redirect()->back()->with('success', count($items) . ' data Informasi Publik berhasil dihapus.');
    }
}
