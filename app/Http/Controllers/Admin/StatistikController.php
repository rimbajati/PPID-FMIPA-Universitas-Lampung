<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiPublik;
use App\Models\Permohonan;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StatistikController extends Controller
{
    public function index()
    {
        $totalDokumen = InformasiPublik::count();
        $totalPermohonan = Permohonan::count();
        $totalPermohonanSelesai = Permohonan::where('status', 'selesai')->count();
        $totalPermohonanDitolak = Permohonan::where('status', 'ditolak')->count();
        $totalKeberatan = Keberatan::count();
        $totalDilihat = Schema::hasColumn('informasi_publik', 'dilihat')
            ? InformasiPublik::sum('dilihat')
            : 0;

        // Data Tren Tahunan
        $currentYear = (int) date('Y');
        $years = range($currentYear - 4, $currentYear);
        $chartTahunan = [
            'years' => $years,
            'permintaan' => [],
            'disetujui' => [],
            'ditolak' => [],
            'keberatan' => [],
        ];

        foreach ($years as $year) {
            $chartTahunan['permintaan'][] = Permohonan::whereYear('created_at', $year)->count();
            $chartTahunan['disetujui'][] = Permohonan::whereYear('created_at', $year)->where('status', 'selesai')->count();
            $chartTahunan['ditolak'][] = Permohonan::whereYear('created_at', $year)->where('status', 'ditolak')->count();
            $chartTahunan['keberatan'][] = Keberatan::whereYear('created_at', $year)->count();
        }

        // Data Tren Bulanan per Tahun
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartBulananPerTahun = [];
        foreach ($years as $year) {
            $chartBulananPerTahun[$year] = [
                'months' => $months,
                'year' => $year,
                'permintaan' => [],
                'disetujui' => [],
                'ditolak' => [],
                'keberatan' => [],
            ];
            for ($m = 1; $m <= 12; $m++) {
                $chartBulananPerTahun[$year]['permintaan'][] = Permohonan::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
                $chartBulananPerTahun[$year]['disetujui'][] = Permohonan::whereYear('created_at', $year)->whereMonth('created_at', $m)->where('status', 'selesai')->count();
                $chartBulananPerTahun[$year]['ditolak'][] = Permohonan::whereYear('created_at', $year)->whereMonth('created_at', $m)->where('status', 'ditolak')->count();
                $chartBulananPerTahun[$year]['keberatan'][] = Keberatan::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
            }
        }
        $chartBulanan = $chartBulananPerTahun[$currentYear];

        // Rata-rata waktu respons
        $tiketSelesaiPermohonan = Permohonan::whereIn('status', ['diproses', 'selesai', 'ditolak'])->get(['created_at', 'updated_at']);
        $tiketSelesaiKeberatan = Keberatan::whereIn('status', ['diproses', 'selesai', 'ditolak'])->get(['created_at', 'updated_at']);
        $semuaTiketProses = $tiketSelesaiPermohonan->concat($tiketSelesaiKeberatan);

        $rataRataWaktuTeks = '1 Hari';
        if ($semuaTiketProses->isNotEmpty()) {
            $totalDetik = 0;
            foreach ($semuaTiketProses as $tiket) {
                $totalDetik += $tiket->created_at->diffInSeconds($tiket->updated_at);
            }
            $avgDetik = $totalDetik / $semuaTiketProses->count();
            $avgHari = max(1, (int) ceil($avgDetik / 86400));
            $rataRataWaktuTeks = $avgHari . ' Hari';
        }

        // 1. Klasifikasi Informasi Publik (UU KIP)
        $statKlasifikasi = [
            'Informasi Berkala'      => InformasiPublik::where('jenis_informasi', 'Informasi Berkala')->count(),
            'Informasi Setiap Saat'  => InformasiPublik::where('jenis_informasi', 'Informasi Setiap Saat')->count(),
            'Informasi Serta-Merta'  => InformasiPublik::where('jenis_informasi', 'Informasi Serta-Merta')->count(),
            'Informasi Dikecualikan' => \App\Models\InformasiDikecualikan::count(),
        ];

        // 2. Kategori Pemohon Informasi
        $kategoriPemohonList = ['Perorangan', 'Kelompok', 'Organisasi', 'Lembaga'];
        $statPemohon = [];
        foreach ($kategoriPemohonList as $kat) {
            $statPemohon[$kat] = Permohonan::where('kategori_pemohon', $kat)->count();
        }
        $pemohonLain = Permohonan::whereNotIn('kategori_pemohon', $kategoriPemohonList)
            ->whereNotNull('kategori_pemohon')
            ->where('kategori_pemohon', '!=', '')
            ->count();
        if ($pemohonLain > 0) {
            $statPemohon['Lainnya'] = $pemohonLain;
        }

        // 3. Cara Memperoleh Informasi
        $statCara = [
            'Melalui Email' => Permohonan::where('cara_memperoleh_informasi', 'like', '%email%')->count(),
            'Datang langsung ke Dekanat FMIPA Universitas Lampung' => Permohonan::where('cara_memperoleh_informasi', 'like', '%langsung%')->count(),
        ];
        $caraLain = Permohonan::where('cara_memperoleh_informasi', 'not like', '%email%')
            ->where('cara_memperoleh_informasi', 'not like', '%langsung%')
            ->whereNotNull('cara_memperoleh_informasi')
            ->count();
        if ($caraLain > 0) {
            $statCara['Lainnya'] = $caraLain;
        }

        // 4. Alasan Pengajuan Keberatan
        $alasanList = [
            'Permohonan Informasi Ditolak',
            'Informasi Berkala Tidak Disediakan',
            'Permohonan Informasi Tidak Ditanggapi',
            'Permohonan Informasi Ditanggapi Tidak Sebagaimana Yang Diminta',
            'Permohonan Informasi Tidak Dipenuhi',
            'Biaya Yang Dikenakan Tidak Wajar',
            'Penyampaian Informasi Melebihi Waktu Yang Ditentukan'
        ];
        $statAlasanKeberatan = [];
        foreach ($alasanList as $alasan) {
            $statAlasanKeberatan[$alasan] = Keberatan::where('alasan_keberatan', $alasan)->count();
        }
        $alasanLain = Keberatan::whereNotIn('alasan_keberatan', $alasanList)
            ->whereNotNull('alasan_keberatan')
            ->where('alasan_keberatan', '!=', '')
            ->count();
        if ($alasanLain > 0) {
            $statAlasanKeberatan['Lainnya'] = $alasanLain;
        }

        return view('admin.statistik.index', compact(
            'totalDokumen',
            'totalPermohonan',
            'totalPermohonanSelesai',
            'totalPermohonanDitolak',
            'totalKeberatan',
            'totalDilihat',
            'rataRataWaktuTeks',
            'chartTahunan',
            'chartBulanan',
            'chartBulananPerTahun',
            'statKlasifikasi',
            'statPemohon',
            'statCara',
            'statAlasanKeberatan'
        ));
    }
}
