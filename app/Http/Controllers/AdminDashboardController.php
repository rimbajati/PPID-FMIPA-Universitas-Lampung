<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Keberatan;
use App\Models\InformasiPublik;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Total & Statistik Permohonan Informasi
        $totalPermohonan = Permohonan::count();
        $permohonanMenunggu = Permohonan::where('status', 'Diajukan')->count();
        $permohonanDiproses = Permohonan::where('status', 'Diproses')->count();
        $permohonanSelesai  = Permohonan::where('status', 'Selesai')->count();
        $permohonanDitolak  = Permohonan::where('status', 'Ditolak')->count();

        // Total & Statistik Keberatan Informasi
        $totalKeberatan = Keberatan::count();
        $keberatanMenunggu = Keberatan::where('status', 'Diajukan')->count();
        $keberatanDiproses = Keberatan::where('status', 'Diproses')->count();
        $keberatanSelesai  = Keberatan::where('status', 'Selesai')->count();
        $keberatanDitolak  = Keberatan::where('status', 'Ditolak')->count();

        // Total Informasi Publik
        $totalInformasiPublik = InformasiPublik::count();

        // Hitung Rata-rata Waktu Penyelesaian Riil (dalam Hari) dari Database
        $selesaiItems = Permohonan::where('status', 'Selesai')->get();
        if ($selesaiItems->count() > 0) {
            $totalDays = 0;
            foreach ($selesaiItems as $item) {
                $diffInHours = $item->created_at->diffInHours($item->updated_at);
                $totalDays += ($diffInHours / 24);
            }
            $avgResponseDays = round($totalDays / $selesaiItems->count(), 1);
            if ($avgResponseDays < 0.1) {
                $avgResponseDays = 0.1;
            }
        } else {
            $avgResponseDays = 0;
        }

        // Filter Periode Grafik Tren Layanan (Bulanan: Jan - Des Tahun Berjalan, Tahunan: 5 Tahun Terakhir)
        $period = $request->get('period', 'monthly');
        $chartLabels = [];
        $chartPermohonan = [];
        $chartKeberatan = [];

        $now = \Carbon\Carbon::now();
        $currentYear = $now->year;

        if ($period === 'yearly') {
            // TAHUNAN: Tepat 5 Tahun Terakhir (Misal: 2022 - 2026)
            for ($y = $currentYear - 4; $y <= $currentYear; $y++) {
                $chartLabels[] = (string) $y;
                $chartPermohonan[] = Permohonan::whereYear('created_at', $y)->count();
                $chartKeberatan[]  = Keberatan::whereYear('created_at', $y)->count();
            }
        } else {
            // BULANAN (Default): Januari hingga Desember pada Tahun Berjalan (Hanya Nama Bulan)
            $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
            
            for ($m = 1; $m <= 12; $m++) {
                $chartLabels[] = $namaBulan[$m - 1];

                $chartPermohonan[] = Permohonan::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $m)
                    ->count();

                $chartKeberatan[]  = Keberatan::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $m)
                    ->count();
            }
        }

        $chartLabels = array_values($chartLabels);
        $chartPermohonan = array_values($chartPermohonan);
        $chartKeberatan = array_values($chartKeberatan);

        // Data 2: Distribusi Kategori Informasi Publik (Berkala, Serta Merta, Setiap Saat, Dikecualikan)
        $kategoriBerkala      = InformasiPublik::where('kategori_informasi', 'like', '%Berkala%')->count();
        $kategoriSertaMerta    = InformasiPublik::where('kategori_informasi', 'like', '%Serta%')->count();
        $kategoriSetiapSaat    = InformasiPublik::where('kategori_informasi', 'like', '%Setiap Saat%')->count();
        $kategoriDikecualikan = InformasiPublik::where('kategori_informasi', 'like', '%Dikecualikan%')->count();

        // Data 3: Distribusi Alasan Keberatan Pemohon Sesuai UU KIP
        $alasanOptions = [
            'Permohonan Informasi Ditolak',
            'Informasi Berkala Tidak Disediakan',
            'Permohonan Informasi Tidak Ditanggapi',
            'Permohonan Informasi Ditanggapi Tidak Sebagaimana Yang Diminta',
            'Permohonan Informasi Tidak Dipenuhi',
            'Biaya Yang Dikenakan Tidak Wajar',
            'Penyampaian Informasi Melebihi Waktu Yang Ditentukan'
        ];

        $alasanKeberatanData = [];
        foreach ($alasanOptions as $opt) {
            $alasanKeberatanData[$opt] = Keberatan::where('alasan_keberatan', 'like', '%' . $opt . '%')->count();
        }

        // Aktivitas Terbaru (Gabungan 5 Permohonan Terbaru & 5 Keberatan Terbaru)
        $latestPermohonan = Permohonan::latest()->take(5)->get();
        $latestKeberatan  = Keberatan::latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalPermohonan',
            'permohonanMenunggu',
            'permohonanDiproses',
            'permohonanSelesai',
            'permohonanDitolak',
            'totalKeberatan',
            'keberatanMenunggu',
            'keberatanDiproses',
            'keberatanSelesai',
            'keberatanDitolak',
            'totalInformasiPublik',
            'avgResponseDays',
            'period',
            'chartLabels',
            'chartPermohonan',
            'chartKeberatan',
            'kategoriBerkala',
            'kategoriSertaMerta',
            'kategoriSetiapSaat',
            'kategoriDikecualikan',
            'alasanKeberatanData',
            'latestPermohonan',
            'latestKeberatan'
        ));
    }

    public function analitik(Request $request)
    {
        $startDate = $request->get('start_date', \Carbon\Carbon::now()->startOfYear()->toDateString());
        $endDate   = $request->get('end_date', \Carbon\Carbon::now()->toDateString());

        // Filter Query berdasarkan Rentang Tanggal
        $queryPermohonan = Permohonan::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $queryKeberatan  = Keberatan::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        $totalPermohonanFiltered = (clone $queryPermohonan)->count();
        $totalKeberatanFiltered  = (clone $queryKeberatan)->count();

        // 1. Analisis Pekerjaan / Profesi Pemohon
        $profesiData = (clone $queryPermohonan)
            ->selectRaw('pekerjaan, count(*) as total')
            ->groupBy('pekerjaan')
            ->pluck('total', 'pekerjaan')
            ->toArray();

        // 2. Analisis Rasio Keputusan (Selesai/Diterima vs Ditolak)
        $statusSelesai = (clone $queryPermohonan)->where('status', 'Selesai')->count();
        $statusDitolak = (clone $queryPermohonan)->where('status', 'Ditolak')->count();
        $statusDiproses = (clone $queryPermohonan)->where('status', 'Diproses')->count();
        $statusDiajukan = (clone $queryPermohonan)->where('status', 'Diajukan')->count();

        // 3. Distribusi Alasan Keberatan
        $alasanOptions = [
            'Permohonan Informasi Ditolak',
            'Informasi Berkala Tidak Disediakan',
            'Permohonan Informasi Tidak Ditanggapi',
            'Permohonan Informasi Ditanggapi Tidak Sebagaimana Yang Diminta',
            'Permohonan Informasi Tidak Dipenuhi',
            'Biaya Yang Dikenakan Tidak Wajar',
            'Penyampaian Informasi Melebihi Waktu Yang Ditentukan'
        ];
        $alasanData = [];
        foreach ($alasanOptions as $opt) {
            $alasanData[$opt] = (clone $queryKeberatan)->where('alasan_keberatan', 'like', '%' . $opt . '%')->count();
        }

        // 4. Data Tren Bulanan untuk Line Chart Perbandingan
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
        $trendPermohonan = [];
        $trendKeberatan = [];
        $currentYear = \Carbon\Carbon::parse($startDate)->year;

        for ($m = 1; $m <= 12; $m++) {
            $trendPermohonan[] = Permohonan::whereYear('created_at', $currentYear)->whereMonth('created_at', $m)->count();
            $trendKeberatan[]  = Keberatan::whereYear('created_at', $currentYear)->whereMonth('created_at', $m)->count();
        }

        return view('admin.analitik.index', compact(
            'startDate',
            'endDate',
            'totalPermohonanFiltered',
            'totalKeberatanFiltered',
            'profesiData',
            'statusSelesai',
            'statusDitolak',
            'statusDiproses',
            'statusDiajukan',
            'alasanData',
            'months',
            'trendPermohonan',
            'trendKeberatan'
        ));
    }
}
