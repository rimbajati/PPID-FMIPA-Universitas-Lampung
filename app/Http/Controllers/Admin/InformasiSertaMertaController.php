<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiSertaMerta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiSertaMertaController extends Controller
{
    public function index(Request $request)
    {
        $query = InformasiSertaMerta::query();

        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(judul_informasi) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(pejabat_unit_yang_menguasai_informasi) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(waktu_pembuatan_informasi) LIKE ?', ["%{$term}%"]);
            });
        }

        // Default urutan terbaru
        $items = $query->orderBy('created_at', 'desc')->get();
        $totalSertaMerta = InformasiSertaMerta::count();
        $lastUpdate = InformasiSertaMerta::max('updated_at');

        return view('admin.informasi_serta_merta.index', compact('items', 'totalSertaMerta', 'lastUpdate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_informasi'                      => 'required|string|max:255',
            'waktu_pembuatan_informasi'            => 'required|string|max:100',
            'pejabat_unit_yang_menguasai_informasi'=> 'required|string|max:255',
            'format_serta_merta'                   => 'required|in:file,link',
            'file_informasi'                       => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'link_informasi'                       => 'nullable|url|max:500',
        ]);

        $format = $request->input('format_serta_merta', 'file');

        if ($format === 'file') {
            if ($request->hasFile('file_informasi')) {
                $file = $request->file('file_informasi');
                $path = $file->store('informasi_serta_merta', 'public');
                $validated['file_informasi'] = $path;
                $validated['nama_file_asli'] = $file->getClientOriginalName();
                $validated['link_informasi'] = null;
            }
        } else {
            $validated['file_informasi'] = null;
            $validated['nama_file_asli'] = null;
        }

        InformasiSertaMerta::create($validated);

        return redirect()->back()->with('success', 'Informasi Serta-Merta berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $item = InformasiSertaMerta::findOrFail($id);

        $validated = $request->validate([
            'judul_informasi'                      => 'required|string|max:255',
            'waktu_pembuatan_informasi'            => 'required|string|max:100',
            'pejabat_unit_yang_menguasai_informasi'=> 'required|string|max:255',
            'format_serta_merta'                   => 'required|in:file,link',
            'file_informasi'                       => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:5120',
            'link_informasi'                       => 'nullable|url|max:500',
        ]);

        $format = $request->input('format_serta_merta', 'file');

        if ($format === 'file') {
            if ($request->hasFile('file_informasi')) {
                if ($item->file_informasi && Storage::disk('public')->exists($item->file_informasi)) {
                    Storage::disk('public')->delete($item->file_informasi);
                }
                $file = $request->file('file_informasi');
                $path = $file->store('informasi_serta_merta', 'public');
                $validated['file_informasi'] = $path;
                $validated['nama_file_asli'] = $file->getClientOriginalName();
                $validated['link_informasi'] = null;
            } else {
                $validated['file_informasi'] = $item->file_informasi;
                $validated['nama_file_asli'] = $item->nama_file_asli;
                $validated['link_informasi'] = null;
            }
        } else {
            if ($item->file_informasi && Storage::disk('public')->exists($item->file_informasi)) {
                Storage::disk('public')->delete($item->file_informasi);
            }
            $validated['file_informasi'] = null;
            $validated['nama_file_asli'] = null;
        }

        $item->update($validated);

        return redirect()->back()->with('success', 'Informasi Serta-Merta berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = InformasiSertaMerta::findOrFail($id);
        if ($item->file_informasi && Storage::disk('public')->exists($item->file_informasi)) {
            Storage::disk('public')->delete($item->file_informasi);
        }
        $item->delete();

        return redirect()->back()->with('success', 'Informasi Serta-Merta berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $items = InformasiSertaMerta::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->file_informasi && Storage::disk('public')->exists($item->file_informasi)) {
                Storage::disk('public')->delete($item->file_informasi);
            }
            $item->delete();
        }

        return redirect()->back()->with('success', count($items) . ' Informasi Serta-Merta berhasil dihapus.');
    }
}
