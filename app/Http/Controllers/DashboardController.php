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
        // 1. Data Statis untuk Kartu (Membatasi jenis_layanan)
        $totalInformasi  = InformasiPublik::count();
        $totalPermohonan = Pengajuan::where('jenis_layanan', 'Permohonan')->count();
        $permohonanBaru  = Pengajuan::where('jenis_layanan', 'Permohonan')->where('status', 'DIAJUKAN')->count();

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
        $monthlyData = [];
        $yearlyData = [];

        // Inisialisasi struktur data
        // Menggabungkan data dari permohonan dan keberatan
        foreach ($permohonanStats as $stat) {
            $y = $stat->year;
            $m = $stat->month;

            if (!isset($monthlyData[$y][$m])) {
                $monthlyData[$y][$m] = ['permohonan' => 0, 'diterima' => 0, 'ditolak' => 0, 'keberatan' => 0];
            }

            $monthlyData[$y][$m]['permohonan'] += $stat->total;
            if ($stat->status == 'DITERIMA') $monthlyData[$y][$m]['diterima'] += $stat->total;
            if ($stat->status == 'DITOLAK')  $monthlyData[$y][$m]['ditolak'] += $stat->total;
        }

        foreach ($keberatanStats as $stat) {
            $y = $stat->year;
            $m = $stat->month;
            if (!isset($monthlyData[$y][$m])) {
                $monthlyData[$y][$m] = ['permohonan' => 0, 'diterima' => 0, 'ditolak' => 0, 'keberatan' => 0];
            }
            $monthlyData[$y][$m]['keberatan'] += $stat->total;
        }

        // Kalkulasi Yearly Data dari Monthly Data
        foreach ($monthlyData as $year => $months) {
            $yearlyData[$year] = ['permohonan' => 0, 'diterima' => 0, 'ditolak' => 0, 'keberatan' => 0];
            foreach ($months as $monthData) {
                $yearlyData[$year]['permohonan'] += $monthData['permohonan'];
                $yearlyData[$year]['diterima']   += $monthData['diterima'];
                $yearlyData[$year]['ditolak']    += $monthData['ditolak'];
                $yearlyData[$year]['keberatan']  += $monthData['keberatan'];
            }
        }

        // Data untuk Donut Chart
        $statusCounts = [
            'DITERIMA' => Pengajuan::where('jenis_layanan', 'Permohonan')->where('status', 'DITERIMA')->count(),
            'DIPROSES' => Pengajuan::where('jenis_layanan', 'Permohonan')->where('status', 'DIPROSES')->count(),
            'Ditolak'  => Pengajuan::where('jenis_layanan', 'Permohonan')->where('status', 'DITOLAK')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalInformasi',
            'totalPermohonan',
            'permohonanBaru',
            'yearlyData',
            'monthlyData',
            'statusCounts'
        ));
    }
}
