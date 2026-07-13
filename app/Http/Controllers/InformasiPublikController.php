<?php

namespace App\Http\Controllers;

use App\Models\InformasiPublik;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class InformasiPublikController extends Controller
{
    public function hitungAkses($id)
    {
        $info = InformasiPublik::findOrFail($id);
        $info->increment('dilihat');

        // Menggunakan 'storage/' prefix karena file disimpan di Storage (storage/app/public)
        return redirect()->away(
            $info->tipe_informasi === 'link' ? $info->jalur_informasi : asset('storage/' . $info->jalur_informasi)
        );
    }

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
                $allDocs = $baseQuery->get(['id', 'rincian_informasi']);
                $ids = [];
                $maxDist = strlen($term) <= 3 ? 1 : 2;

                foreach ($allDocs as $doc) {
                    $titleLower = strtolower($doc->rincian_informasi);
                    if (levenshtein($term, $titleLower) <= $maxDist) {
                        $ids[] = $doc->id;
                        continue;
                    }
                    $tokens = explode(' ', $titleLower);
                    foreach ($tokens as $token) {
                        if (abs(strlen($term) - strlen($token)) > $maxDist) continue;
                        if (levenshtein($term, $token) <= $maxDist) {
                            $ids[] = $doc->id;
                            break;
                        }
                    }
                }

                if (!empty($ids)) {
                    $items = InformasiPublik::whereIn('id', $ids)
                        ->latest()
                        ->paginate($paginateCount);
                }
            }
        } else {
            $items = $baseQuery->latest()->paginate($paginateCount);
        }

        $items->appends($request->all());

        return view('public.informasi_publik', ['informasi' => $items]);
    }

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

    public function adminIndex(Request $request)
    {
        $query = InformasiPublik::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
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

        // TAMBAHKAN BARIS INI: Ambil daftar rincian informasi unik
        $kategori_tersedia = InformasiPublik::distinct()->pluck('rincian_informasi');

        $informasi = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.informasi_publik', compact(
            'informasi', 'totalInformasi', 'totalBerkala', 'totalSertaMerta', 'totalSetiapSaat', 'kategori_tersedia'
        ));
    }

    public function create()
    {
        $kategori_tersedia = InformasiPublik::distinct()->pluck('rincian_informasi');
        return view('admin.informasi_publik_create', compact('kategori_tersedia'));
    }

    public function edit($id)
    {
        $informasi = InformasiPublik::findOrFail($id);
        $kategori_tersedia = InformasiPublik::distinct()->pluck('rincian_informasi');
        return view('admin.informasi_publik_create', compact('informasi', 'kategori_tersedia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rincian_informasi'      => 'required_without:rincian_informasi_baru|max:255',
            'rincian_informasi_baru' => 'required_without:rincian_informasi|max:255',
            'sub_informasi'          => 'required',
            'kategori'               => 'required',
            'opsi_format'            => 'required|in:file,link',
            'berkas'                 => 'required_if:opsi_format,file|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'url_link'               => 'required_if:opsi_format,link|url',
        ]);

        $payload = $request->except(['opsi_format', 'berkas', 'url_link', 'rincian_informasi_baru']);

        // Set Rincian Informasi (Grup)
        $payload['rincian_informasi'] = $request->filled('rincian_informasi_baru') ? $request->rincian_informasi_baru : $request->rincian_informasi;

        if ($request->opsi_format === 'file') {
            $path = $request->file('berkas')->store('informasi', 'public');
            $payload['tipe_informasi']  = $request->file('berkas')->getClientOriginalExtension();
            $payload['jalur_informasi'] = $path;
        } else {
            $payload['tipe_informasi']  = 'link';
            $payload['jalur_informasi'] = $request->url_link;
        }

        InformasiPublik::create($payload);

        return redirect('/admin/informasi-publik')->with('success', 'Data berhasil ditambahkan.');
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

        // Set Rincian Informasi (Grup)
        $payload['rincian_informasi'] = $request->filled('rincian_informasi_baru') ? $request->rincian_informasi_baru : $request->rincian_informasi;

        if ($request->opsi_format === 'file' && $request->hasFile('berkas')) {
            // Hapus file lama di Storage
            if ($info->tipe_informasi !== 'link' && Storage::disk('public')->exists($info->jalur_informasi)) {
                Storage::disk('public')->delete($info->jalur_informasi);
            }

            $path = $request->file('berkas')->store('informasi', 'public');
            $payload['tipe_informasi']  = $request->file('berkas')->getClientOriginalExtension();
            $payload['jalur_informasi'] = $path;
        } elseif ($request->opsi_format === 'link') {
            $payload['tipe_informasi']  = 'link';
            $payload['jalur_informasi'] = $request->url_link;
        }

        $info->update($payload);

        return redirect('/admin/informasi-publik')->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $info = InformasiPublik::findOrFail($id);
        if ($info->tipe_informasi !== 'link' && Storage::disk('public')->exists($info->jalur_informasi)) {
            Storage::disk('public')->delete($info->jalur_informasi);
        }
        $info->delete();

        return redirect('/admin/informasi-publik')->with('success', 'Arsip berhasil dihapus.');
    }
}
