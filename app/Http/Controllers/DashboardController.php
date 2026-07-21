<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\InformasiPublik;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data Statis untuk Kartu Statistik (4 Kartu Utama)
        $totalInformasi   = InformasiPublik::count();
        $totalPengajuan   = Pengajuan::count();
        $totalPermohonan  = Pengajuan::where('jenis_layanan', 'Permohonan')->count();
        $totalKeberatan   = Pengajuan::where('jenis_layanan', 'Keberatan')->count();
        $pengajuanBaru    = Pengajuan::where('status', 'DIAJUKAN')->count();
        $pengajuanDiproses = Pengajuan::where('status', 'DIPROSES')->count();

        // 2. Mengambil data mentah permohonan dan keberatan menggunakan model Pengajuan
        $permohonanStats = Pengajuan::where('jenis_layanan', 'Permohonan')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, status, count(*) as total')
            ->groupBy('year', 'month', 'status')
            ->get();

        $keberatanStats = Pengajuan::where('jenis_layanan', 'Keberatan')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, count(*) as total')
            ->groupBy('year', 'month')
            ->get();

        // 3. Memproses data menjadi format yang dibutuhkan Chart
        $currentYear = (int) date('Y');
        $monthlyData = [
            $currentYear => []
        ];

        // Fill all 12 months with default zeroes for current year
        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[$currentYear][$m] = ['permohonan' => 0, 'diterima' => 0, 'ditolak' => 0, 'keberatan' => 0];
        }

        // Menggabungkan data dari permohonan dan keberatan
        foreach ($permohonanStats as $stat) {
            $y = (int) $stat->year;
            $m = (int) $stat->month;

            if (!isset($monthlyData[$y])) {
                for ($i = 1; $i <= 12; $i++) {
                    $monthlyData[$y][$i] = ['permohonan' => 0, 'diterima' => 0, 'ditolak' => 0, 'keberatan' => 0];
                }
            }

            $monthlyData[$y][$m]['permohonan'] += $stat->total;
            if (strtoupper($stat->status) == 'DITERIMA') $monthlyData[$y][$m]['diterima'] += $stat->total;
            if (strtoupper($stat->status) == 'DITOLAK')  $monthlyData[$y][$m]['ditolak'] += $stat->total;
        }

        foreach ($keberatanStats as $stat) {
            $y = (int) $stat->year;
            $m = (int) $stat->month;

            if (!isset($monthlyData[$y])) {
                for ($i = 1; $i <= 12; $i++) {
                    $monthlyData[$y][$i] = ['permohonan' => 0, 'diterima' => 0, 'ditolak' => 0, 'keberatan' => 0];
                }
            }

            $monthlyData[$y][$m]['keberatan'] += $stat->total;
        }

        // Kalkulasi Yearly Data dari Monthly Data
        $yearlyData = [];
        foreach ($monthlyData as $year => $months) {
            $yearlyData[$year] = ['permohonan' => 0, 'diterima' => 0, 'ditolak' => 0, 'keberatan' => 0];
            foreach ($months as $monthData) {
                $yearlyData[$year]['permohonan'] += $monthData['permohonan'];
                $yearlyData[$year]['diterima']   += $monthData['diterima'];
                $yearlyData[$year]['ditolak']    += $monthData['ditolak'];
                $yearlyData[$year]['keberatan']  += $monthData['keberatan'];
            }
        }

        // Data Lengkap untuk Donut Chart (Status Keseluruhan Pengajuan)
        $statusCounts = [
            'DIAJUKAN' => Pengajuan::where('status', 'DIAJUKAN')->count(),
            'DIPROSES' => Pengajuan::where('status', 'DIPROSES')->count(),
            'DITERIMA' => Pengajuan::where('status', 'DITERIMA')->count(),
            'DITOLAK'  => Pengajuan::where('status', 'DITOLAK')->count(),
        ];

        $totalPengajuanAll = array_sum($statusCounts);
        $completionRate = $totalPengajuanAll > 0 ? round(($statusCounts['DITERIMA'] / $totalPengajuanAll) * 100) : 0;

        // Data 5 Pengajuan Terbaru untuk Widget Dashboard
        $recentPengajuan = Pengajuan::with('user')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalInformasi',
            'totalPengajuan',
            'totalPermohonan',
            'totalKeberatan',
            'pengajuanBaru',
            'pengajuanDiproses',
            'yearlyData',
            'monthlyData',
            'statusCounts',
            'totalPengajuanAll',
            'completionRate',
            'recentPengajuan'
        ));
    }
}
