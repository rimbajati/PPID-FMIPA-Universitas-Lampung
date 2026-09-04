<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use Illuminate\Http\Request;

class InformasiPublikController extends Controller
{
    /**
     * Menampilkan Katalog Informasi Publik untuk Masyarakat
     */
    public function index(Request $request)
    {
        $query = InformasiPublik::query();

        // Filter pencarian berdasarkan judul atau deskripsi
        if ($request->filled('search')) {
            $term = strtolower(trim($request->search));
            $query->where(function($q) use ($term) {
                $q->whereRaw('LOWER(judul_informasi) LIKE ?', ["%{$term}%"])
                  ->orWhereRaw('LOWER(deskripsi_informasi) LIKE ?', ["%{$term}%"]);
            });
        }

        // Filter berdasarkan kategori informasi
        if ($request->filled('kategori')) {
            $kat = $request->kategori;
            if (is_array($kat)) {
                $query->whereIn('kategori_informasi', array_filter($kat));
            } else {
                $query->where('kategori_informasi', $kat);
            }
        }

        // Filter berdasarkan tahun terbit
        if ($request->filled('tahun')) {
            $thn = $request->tahun;
            if (is_array($thn)) {
                $query->whereIn('tahun_terbit', array_filter($thn));
            } else {
                $query->where('tahun_terbit', $thn);
            }
        }

        // Filter berdasarkan format file (pdf, docx, xlsx, link)
        if ($request->filled('format')) {
            $fmtReq = strtolower($request->format);
            if ($fmtReq === 'link') {
                $query->whereNotNull('link_informasi')->whereNull('file_informasi');
            } else {
                $query->where(function($q) use ($fmtReq) {
                    $q->where('nama_file_asli', 'like', '%.' . $fmtReq)
                      ->orWhere('file_informasi', 'like', '%.' . $fmtReq);
                });
            }
        }

        // Sorting
        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'az') {
            $query->orderBy('judul_informasi', 'asc');
        } elseif ($sort === 'za') {
            $query->orderBy('judul_informasi', 'desc');
        } elseif ($sort === 'populer') {
            $query->orderBy('dilihat', 'desc')->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $informasiList = $query->paginate(25)->withQueryString();

        // Data untuk filter dropdown & pill tabs
        $years = InformasiPublik::select('tahun_terbit')
            ->distinct()
            ->whereNotNull('tahun_terbit')
            ->where('tahun_terbit', '<>', '')
            ->orderBy('tahun_terbit', 'desc')
            ->pluck('tahun_terbit');

        $totalCount = InformasiPublik::count();

        $kategoryCounts = [
            'Informasi Berkala'      => InformasiPublik::where('kategori_informasi', 'Informasi Berkala')->count(),
            'Informasi Serta-Merta'  => InformasiPublik::where('kategori_informasi', 'Informasi Serta-Merta')->count(),
            'Informasi Setiap Saat'  => InformasiPublik::where('kategori_informasi', 'Informasi Setiap Saat')->count(),
            'Informasi Dikecualikan' => InformasiPublik::where('kategori_informasi', 'Informasi Dikecualikan')->count(),
        ];

        return view('masyarakat.informasi_publik.index', compact(
            'informasiList',
            'years',
            'totalCount',
            'kategoryCounts'
        ));
    }

    /**
     * Menampilkan Halaman Detail & Preview Informasi Publik (Layout 2 Kolom)
     */
    public function show($id)
    {
        $info = InformasiPublik::findOrFail($id);
        
        // Increment dilihat count
        if (\Illuminate\Support\Facades\Schema::hasColumn('informasi_publik', 'dilihat')) {
            $info->increment('dilihat');
        }

        $relatedList = InformasiPublik::where('id', '<>', $id)
            ->where('kategori_informasi', $info->kategori_informasi)
            ->take(5)
            ->get();

        return view('masyarakat.informasi_publik.detail', compact('info', 'relatedList'));
    }
}
