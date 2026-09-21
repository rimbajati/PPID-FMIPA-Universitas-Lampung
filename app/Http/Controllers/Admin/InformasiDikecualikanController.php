<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiDikecualikan;
use Illuminate\Http\Request;

class InformasiDikecualikanController extends Controller
{
    public function index(Request $request)
    {
        $query = InformasiDikecualikan::query();

        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(ringkasan_informasi) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(dasar_hukum) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(ditutup) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(jangka_waktu) LIKE ?', ["%{$term}%"]);
            });
        }

        // Sorting
        if ($request->sort == 'terlama') {
            $query->oldest();
        } elseif ($request->sort == 'ringkasan_asc') {
            $query->orderBy('ringkasan_informasi', 'asc');
        } elseif ($request->sort == 'ringkasan_desc') {
            $query->orderBy('ringkasan_informasi', 'desc');
        } else {
            $query->latest();
        }

        $totalDikecualikan = InformasiDikecualikan::count();
        $lastUpdate = InformasiDikecualikan::max('updated_at');

        $items = $query->get();

        return view('admin.informasi_dikecualikan.index', compact('items', 'totalDikecualikan', 'lastUpdate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ringkasan_informasi' => 'required|string',
            'dasar_hukum'         => 'required|string',
            'dibuka'              => 'nullable|string',
            'ditutup'             => 'required|string',
            'jangka_waktu'        => 'required|string',
        ]);

        if (empty($validated['dibuka'])) {
            $validated['dibuka'] = '-';
        }

        InformasiDikecualikan::create($validated);

        return redirect()->back()->with('success', 'Informasi Dikecualikan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $item = InformasiDikecualikan::findOrFail($id);

        $validated = $request->validate([
            'ringkasan_informasi' => 'required|string',
            'dasar_hukum'         => 'required|string',
            'dibuka'              => 'nullable|string',
            'ditutup'             => 'required|string',
            'jangka_waktu'        => 'required|string',
        ]);

        if (empty($validated['dibuka'])) {
            $validated['dibuka'] = '-';
        }

        $item->update($validated);

        return redirect()->back()->with('success', 'Informasi Dikecualikan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $item = InformasiDikecualikan::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Informasi Dikecualikan berhasil dihapus!');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            InformasiDikecualikan::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', count($ids) . ' data Informasi Dikecualikan berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }
}
