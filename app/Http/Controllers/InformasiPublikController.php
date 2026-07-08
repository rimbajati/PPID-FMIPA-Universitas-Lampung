<?php

namespace App\Http\Controllers;

use App\Models\InformasiPublik;
use Illuminate\Http\Request;

class InformasiPublikController extends Controller
{
    public function hitungAkses($id)
    {
        $info = InformasiPublik::findOrFail($id);
        $info->increment('dilihat');

        return redirect()->away(
            $info->tipe_informasi === 'link' ? $info->jalur_informasi : asset($info->jalur_informasi)
        );
    }

    public function index(Request $request)
    {
        // Menangkap nilai perPage dari request, defaultnya 10
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
            // Menggunakan $paginateCount sebagai ganti 10
            $items = $matchQuery->whereRaw('LOWER(judul_informasi) LIKE ?', ["%$term%"])
                ->latest()
                ->paginate($paginateCount);

            if ($items->isEmpty()) {
                $allDocs = $baseQuery->get(['id', 'judul_informasi']);
                $ids = [];
                $maxDist = strlen($term) <= 3 ? 1 : 2;

                foreach ($allDocs as $doc) {
                    $titleLower = strtolower($doc->judul_informasi);
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
                    // Menggunakan $paginateCount sebagai ganti 10
                    $items = InformasiPublik::whereIn('id', $ids)
                        ->latest()
                        ->paginate($paginateCount);
                }
            }
        } else {
            // Menggunakan $paginateCount sebagai ganti 10
            $items = $baseQuery->latest()->paginate($paginateCount);
        }

        // appends() akan memastikan filter (search & kategori) tetap terbawa saat pindah halaman
        $items->appends($request->all());

        return view('public.informasi_publik', ['informasi' => $items]);
    }

    public function adminIndex()
    {
        return view('admin.informasi_publik', [
            'informasi' => InformasiPublik::latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('admin.informasi_publik_create');
    }

    public function edit($id)
    {
        return view('admin.informasi_publik_create', [
            'informasi' => InformasiPublik::findOrFail($id)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_informasi' => 'required|max:255',
            'kategori'        => 'required',
            'tahun_publikasi' => 'required|digits:4',
            'opsi_format'     => 'required|in:file,link',
            'berkas'          => 'required_if:opsi_format,file|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:10240',
            'url_link'        => 'required_if:opsi_format,link|url',
        ]);

        $payload = $request->except(['opsi_format', 'berkas', 'url_link']);

        if ($request->opsi_format === 'file') {
            $file = $request->file('berkas');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('informasi'), $name);

            $payload['tipe_informasi']  = $file->getClientOriginalExtension();
            $payload['jalur_informasi'] = 'informasi/' . $name;
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
        $payload = $request->except(['opsi_format', 'berkas', 'url_link']);

        if ($request->opsi_format === 'file' && $request->hasFile('berkas')) {
            if ($info->tipe_informasi !== 'link' && file_exists(public_path($info->jalur_informasi))) {
                @unlink(public_path($info->jalur_informasi));
            }
            $file = $request->file('berkas');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('informasi'), $name);

            $payload['tipe_informasi']  = $file->getClientOriginalExtension();
            $payload['jalur_informasi'] = 'informasi/' . $name;
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
        if ($info->tipe_informasi !== 'link' && file_exists(public_path($info->jalur_informasi))) {
            @unlink(public_path($info->jalur_informasi));
        }
        $info->delete();

        return redirect('/admin/informasi-publik')->with('success', 'Arsip berhasil dihapus.');
    }
}
