<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        // Data KPI Summary (Updated to use Pengajuan model)
        $kpi = [
            'total'     => Pengajuan::count(),
            'diterima'  => Pengajuan::where('jenis_layanan', 'Permohonan')->where('status', 'DITERIMA')->count(),
            'ditolak'   => Pengajuan::where('jenis_layanan', 'Permohonan')->where('status', 'DITOLAK')->count(),
            'keberatan' => Pengajuan::where('jenis_layanan', 'Keberatan')->count(),
            'rata_rata' => '1 hari'
        ];

        // LOGIKA DATA SAMA SEPERTI BERANDA (Updated to use Pengajuan model)
        $minYear = (int)(Pengajuan::min(DB::raw('YEAR(created_at)')) ?? date('Y'));
        $currentYear = (int)date('Y');
        $years = range($minYear, $currentYear);

        $yearlyData = [];
        $monthlyData = [];

        foreach ($years as $y) {
            $yearlyData[$y] = [
                'permohonan' => Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->count(),
                'diterima'   => Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->where('status', 'DITERIMA')->count(),
                'ditolak'    => Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->where('status', 'DITOLAK')->count(),
                'keberatan'  => Pengajuan::where('jenis_layanan', 'Keberatan')->whereYear('created_at', $y)->count(),
            ];

            for ($m = 1; $m <= 12; $m++) {
                $monthlyData[$y][$m] = [
                    'permohonan' => Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->whereMonth('created_at', $m)->count(),
                    'diterima'   => Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'DITERIMA')->count(),
                    'ditolak'    => Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'DITOLAK')->count(),
                    'keberatan'  => Pengajuan::where('jenis_layanan', 'Keberatan')->whereYear('created_at', $y)->whereMonth('created_at', $m)->count(),
                ];
            }
        }

        return view('public.statistik', compact('kpi', 'yearlyData', 'monthlyData'));
    }
}
