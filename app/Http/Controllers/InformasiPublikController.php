<?php

namespace App\Http\Controllers;

use App\Models\InformasiPublik;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class InformasiPublikController extends Controller
{
    /**
     * 1. Fungsi Khusus Menampilkan File PDF Secara Aman & Privat
     */
    public function lihatFile($id, $slug = null)
    {
        $info = InformasiPublik::findOrFail($id);
        $info->increment('dilihat');

        if ($info->tipe_informasi === 'link') {
            return redirect()->route('informasi.link', ['id' => $info->id, 'slug' => $slug]);
        }

        $path = Storage::disk('local')->path($info->jalur_informasi);

        if (!file_exists($path)) {
            abort(404, 'Berkas dokumen tidak ditemukan di server.');
        }

        return response()->file($path);
    }

    /**
     * 2. Fungsi Gateway Khusus Mencatat Klik & Mengalihkan Link Eksternal
     */
    public function kunjungiLink($id, $slug = null)
    {
        $info = InformasiPublik::findOrFail($id);
        $info->increment('dilihat');

        if ($info->tipe_informasi !== 'link') {
            return redirect()->route('informasi.file', ['id' => $info->id, 'slug' => $slug]);
        }

        return redirect()->away($info->jalur_informasi);
    }

    /**
     * Halaman Repositori Informasi Publik (Sisi User)
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paginateCount = ($perPage == 9999) ? 9999 : (int)$perPage;
        $keyword = trim($request->query('search', ''));
        $kategori = $request->query('kategori');

        $baseQuery = InformasiPublik::query();

        if ($kategori) {
            $baseQuery->where('kategori', $kategori);
        }

        if ($keyword !== '') {
            $term = strtolower($keyword);
            $matchQuery = clone $baseQuery;
            $items = $matchQuery->whereRaw('LOWER(rincian_informasi) LIKE ?', ["%$term%"])
                ->latest()
                ->paginate($paginateCount);

            if ($items->isEmpty()) {
                // ... (logika Levenshtein Anda tetap di sini)
                $allDocs = $baseQuery->get(['id', 'rincian_informasi']);
                $ids = [];
                $maxDist = strlen($term) <= 3 ? 1 : 2;
                foreach ($allDocs as $doc) {
                    $titleLower = strtolower($doc->rincian_informasi);
                    if (levenshtein($term, $titleLower) <= $maxDist) { $ids[] = $doc->id; continue; }
                    $tokens = explode(' ', $titleLower);
                    foreach ($tokens as $token) {
                        if (abs(strlen($term) - strlen($token)) > $maxDist) continue;
                        if (levenshtein($term, $token) <= $maxDist) { $ids[] = $doc->id; break; }
                    }
                }
                if (!empty($ids)) {
                    $items = InformasiPublik::whereIn('id', $ids)->latest()->paginate($paginateCount);
                }
            }
        } else {
            $items = $baseQuery->latest()->paginate($paginateCount);
        }

        $items->appends($request->all());

        // TAMBAHKAN INI agar Modal Edit berfungsi
        $listRincian = InformasiPublik::distinct()->pluck('rincian_informasi');

        return view('public.informasi_publik', ['informasi' => $items, 'listRincian' => $listRincian]);
    }

    // --- Fungsi Sisi User (Berkala, Serta-Merta, Setiap Saat) ---

    public function indexSetiapSaat(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paginateCount = ($perPage == 9999) ? 9999 : (int)$perPage;
        $keyword = trim($request->query('search', ''));

        $query = InformasiPublik::where('kategori', 'Informasi Tersedia Setiap Saat');

        if ($keyword !== '') {
            $query->where(function($q) use ($keyword) {
                $q->where('rincian_informasi', 'LIKE', "%{$keyword}%")
                ->orWhere('sub_informasi', 'LIKE', "%{$keyword}%");
            });
        }

        $items = $query->latest()->paginate($paginateCount)->appends($request->all());
        return view('public.informasi_setiap_saat', ['informasi' => $items]);
    }

    public function indexBerkala(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paginateCount = ($perPage == 9999) ? 9999 : (int)$perPage;
        $keyword = trim($request->query('search', ''));

        $query = InformasiPublik::where('kategori', 'Informasi Tersedia Secara Berkala');

        if ($keyword !== '') {
            $query->where(function($q) use ($keyword) {
                $q->where('rincian_informasi', 'LIKE', "%{$keyword}%")
                ->orWhere('sub_informasi', 'LIKE', "%{$keyword}%");
            });
        }

        $items = $query->latest()->paginate($paginateCount)->appends($request->all());
        return view('public.informasi_berkala', ['informasi' => $items]);
    }

    public function indexSertaMerta(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $paginateCount = ($perPage == 9999) ? 9999 : (int)$perPage;
        $keyword = trim($request->query('search', ''));

        $query = InformasiPublik::where('kategori', 'Informasi Diumumkan Serta-Merta');

        if ($keyword !== '') {
            $query->where(function($q) use ($keyword) {
                $q->where('rincian_informasi', 'LIKE', "%{$keyword}%")
                ->orWhere('sub_informasi', 'LIKE', "%{$keyword}%");
            });
        }

        $items = $query->latest()->paginate($paginateCount)->appends($request->all());
        return view('public.informasi_serta_merta', ['informasi' => $items]);
    }

    /**
     * Halaman Dashboard Manajemen Informasi Publik (Sisi Admin)
     */
    public function adminIndex(Request $request)
    {
        $query = InformasiPublik::query();

        // Ambil list rincian untuk filter
        $listRincian = InformasiPublik::distinct()->pluck('rincian_informasi');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('rincian')) {
            $query->where('rincian_informasi', $request->rincian);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('rincian_informasi', 'LIKE', '%' . $request->search . '%')
                ->orWhere('sub_informasi', 'LIKE', '%' . $request->search . '%');
            });
        }

        $totalInformasi = InformasiPublik::count();
        $totalBerkala = InformasiPublik::where('kategori', 'Informasi Tersedia Secara Berkala')->count();
        $totalSertaMerta = InformasiPublik::where('kategori', 'Informasi Diumumkan Serta-Merta')->count();
        $totalSetiapSaat = InformasiPublik::where('kategori', 'Informasi Tersedia Setiap Saat')->count();

        $informasi = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.informasi_publik', compact(
            'informasi', 'listRincian', 'totalInformasi', 'totalBerkala', 'totalSertaMerta', 'totalSetiapSaat'
        ));
    }

    public function create()
    {
        $listRincian = InformasiPublik::distinct()->pluck('rincian_informasi');
        return view('admin.informasi_publik_create', compact('listRincian'));
    }

    public function edit($id)
    {
        $informasi = InformasiPublik::findOrFail($id);
        $listRincian = InformasiPublik::distinct()->pluck('rincian_informasi');
        return view('admin.informasi_publik_create', compact('informasi', 'listRincian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rincian_informasi'      => 'required_without:rincian_informasi_baru|max:255',
            'rincian_informasi_baru' => 'required_without:rincian_informasi|max:255',
            'sub_informasi'          => 'required',
            'kategori'               => 'required',
            'opsi_format'            => 'required|in:file,link',
            'berkas'                 => 'required_if:opsi_format,file|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2480',
            'url_link'               => 'required_if:opsi_format,link|url',
        ]);

        $payload = $request->except(['opsi_format', 'berkas', 'url_link', 'rincian_informasi_baru']);
        $payload['rincian_informasi'] = $request->filled('rincian_informasi_baru') ? $request->rincian_informasi_baru : $request->rincian_informasi;

        if ($request->opsi_format === 'file') {
            $path = $request->file('berkas')->store('informasi', 'local');
            $payload['tipe_informasi']  = $request->file('berkas')->getClientOriginalExtension();
            $payload['jalur_informasi'] = $path;
        } else {
            $payload['tipe_informasi']  = 'link';
            $payload['jalur_informasi'] = $request->url_link;
        }

        InformasiPublik::create($payload);

        return redirect('/admin/informasi-publik')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $info = InformasiPublik::findOrFail($id);
        $request->validate([
            'rincian_informasi'      => 'required_without:rincian_informasi_baru|max:255',
            'rincian_informasi_baru' => 'required_without:rincian_informasi|max:255',
            'sub_informasi'          => 'required',
            'kategori'               => 'required',
        ]);

        $payload = $request->except(['opsi_format', 'berkas', 'url_link', 'rincian_informasi_baru']);
        $payload['rincian_informasi'] = $request->filled('rincian_informasi_baru') ? $request->rincian_informasi_baru : $request->rincian_informasi;

        if ($request->opsi_format === 'file' && $request->hasFile('berkas')) {
            if ($info->tipe_informasi !== 'link' && Storage::disk('local')->exists($info->jalur_informasi)) {
                Storage::disk('local')->delete($info->jalur_informasi);
            }
            $path = $request->file('berkas')->store('informasi', 'local');
            $payload['tipe_informasi']  = $request->file('berkas')->getClientOriginalExtension();
            $payload['jalur_informasi'] = $path;
        } elseif ($request->opsi_format === 'link') {
            $payload['tipe_informasi']  = 'link';
            $payload['jalur_informasi'] = $request->url_link;
        }

        $info->update($payload);

        return redirect('/admin/informasi-publik')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $info = InformasiPublik::findOrFail($id);
        if ($info->tipe_informasi !== 'link' && Storage::disk('local')->exists($info->jalur_informasi)) {
            Storage::disk('local')->delete($info->jalur_informasi);
        }
        $info->delete();

        return redirect('/admin/informasi-publik')->with('success', 'Data berhasil dihapus!');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->ids;
        if (!$ids) {
            return redirect()->back()->with('error', 'Pilih minimal satu data.');
        }

        $items = \App\Models\InformasiPublik::whereIn('id', $ids)->get();
        foreach ($items as $item) {
            // Hapus file fisik jika bukan link
            if ($item->tipe_informasi !== 'link' && \Illuminate\Support\Facades\Storage::disk('local')->exists($item->jalur_informasi)) {
                \Illuminate\Support\Facades\Storage::disk('local')->delete($item->jalur_informasi);
            }
            $item->delete();
        }
        return redirect()->back()->with('success', count($ids) . ' data berhasil dihapus!');
    }
}
