<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        // Data KPI Summary (Sama seperti sebelumnya)
        $kpi = [
            'total' => Permohonan::count(),
            'diterima' => Permohonan::where('status', 'DITERIMA')->count(),
            'ditolak' => Permohonan::where('status', 'DITOLAK')->count(),
            'keberatan' => Keberatan::count(),
            'rata_rata' => '1 hari'
        ];

        // LOGIKA DATA SAMA SEPERTI BERANDA
        $minYear = (int)(Permohonan::min(DB::raw('YEAR(created_at)')) ?? date('Y'));
        $currentYear = (int)date('Y');
        $years = range($minYear, $currentYear);

        $yearlyData = [];
        $monthlyData = [];

        foreach ($years as $y) {
            $yearlyData[$y] = [
                'permohonan' => Permohonan::whereYear('created_at', $y)->count(),
                'diterima'   => Permohonan::whereYear('created_at', $y)->where('status', 'DITERIMA')->count(),
                'ditolak'    => Permohonan::whereYear('created_at', $y)->where('status', 'DITOLAK')->count(),
                'keberatan'  => Keberatan::whereYear('created_at', $y)->count(),
            ];

            for ($m = 1; $m <= 12; $m++) {
                $monthlyData[$y][$m] = [
                    'permohonan' => Permohonan::whereYear('created_at', $y)->whereMonth('created_at', $m)->count(),
                    'diterima'   => Permohonan::whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'DITERIMA')->count(),
                    'ditolak'    => Permohonan::whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'DITOLAK')->count(),
                    'keberatan'  => Keberatan::whereYear('created_at', $y)->whereMonth('created_at', $m)->count(),
                ];
            }
        }

        return view('public.statistik', compact('kpi', 'yearlyData', 'monthlyData'));
    }
}
