<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\InformasiPublik;
use App\Models\Keberatan;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalInformasi'  => \App\Models\InformasiPublik::count(),
            'totalPermohonan' => \App\Models\Permohonan::count(),
            'permohonanBaru'  => \App\Models\Permohonan::where('status', 'DIAJUKAN')->count(),
            'keberatanBaru'   => 0,

            // Mengambil data untuk grafik
            'statistik' => \App\Models\Permohonan::selectRaw('MONTH(created_at) as bulan, status, count(*) as total')
                            ->whereYear('created_at', date('Y'))
                            ->groupBy('bulan', 'status')
                            ->get(),

            // Data untuk Donut Chart
            'statusCounts' => [
                'DITERIMA' => \App\Models\Permohonan::where('status', 'DITERIMA')->count(),
                'DIPROSES' => \App\Models\Permohonan::where('status', 'DIPROSES')->count(),
                'DITOLAK'  => \App\Models\Permohonan::where('status', 'DITOLAK')->count(),
            ]
        ];

        return view('admin.dashboard', $data);
    }
}
