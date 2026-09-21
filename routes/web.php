<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Masyarakat\InformasiPublikController as MasyarakatInformasiPublikController;
use App\Http\Controllers\Masyarakat\PermohonanController as MasyarakatPermohonanController;
use App\Http\Controllers\Masyarakat\KeberatanController as MasyarakatKeberatanController;
use App\Http\Controllers\Admin\InformasiPublikController as AdminInformasiPublikController;
use App\Http\Controllers\Admin\InformasiDikecualikanController as AdminInformasiDikecualikanController;
use App\Http\Controllers\Admin\PermohonanController as AdminPermohonanController;
use App\Http\Controllers\Admin\KeberatanController as AdminKeberatanController;
use App\Http\Controllers\Admin\StatistikController as AdminStatistikController;
use App\Http\Controllers\Admin\BerandaController as AdminBerandaController;
use App\Http\Controllers\Masyarakat\RiwayatLayananController as MasyarakatRiwayatLayananController;
use Illuminate\Http\Request;

Route::get('/', function () {
    $totalDokumen = \App\Models\InformasiPublik::count();
    $totalPermohonan = \App\Models\Permohonan::count();
    $totalPermohonanSelesai = \App\Models\Permohonan::where('status', 'selesai')->count();
    $totalPermohonanDitolak = \App\Models\Permohonan::where('status', 'ditolak')->count();
    $totalKeberatan = \App\Models\Keberatan::count();
    $totalDilihat = \Illuminate\Support\Facades\Schema::hasColumn('informasi_publiks', 'dilihat') 
        ? \App\Models\InformasiPublik::sum('dilihat') 
        : 0;

    $kategoriCount = [
        'setiap_saat'  => \App\Models\InformasiPublik::where('jenis_informasi', 'Informasi Setiap Saat')->count(),
        'berkala'      => \App\Models\InformasiPublik::where('jenis_informasi', 'Informasi Berkala')->count(),
        'serta_merta'  => \App\Models\InformasiPublik::where('jenis_informasi', 'Informasi Serta-Merta')->count(),
        'dikecualikan' => \App\Models\InformasiDikecualikan::count(),
    ];

    // Data Tren Tahunan (Permintaan, Disetujui/Selesai, Ditolak, Keberatan)
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
        $chartTahunan['permintaan'][] = \App\Models\Permohonan::whereYear('created_at', $year)->count();
        $chartTahunan['disetujui'][] = \App\Models\Permohonan::whereYear('created_at', $year)->where('status', 'selesai')->count();
        $chartTahunan['ditolak'][] = \App\Models\Permohonan::whereYear('created_at', $year)->where('status', 'ditolak')->count();
        $chartTahunan['keberatan'][] = \App\Models\Keberatan::whereYear('created_at', $year)->count();
    }

    // Data Tren Bulanan untuk setiap tahun yang tersedia
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
            $chartBulananPerTahun[$year]['permintaan'][] = \App\Models\Permohonan::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
            $chartBulananPerTahun[$year]['disetujui'][] = \App\Models\Permohonan::whereYear('created_at', $year)->whereMonth('created_at', $m)->where('status', 'selesai')->count();
            $chartBulananPerTahun[$year]['ditolak'][] = \App\Models\Permohonan::whereYear('created_at', $year)->whereMonth('created_at', $m)->where('status', 'ditolak')->count();
            $chartBulananPerTahun[$year]['keberatan'][] = \App\Models\Keberatan::whereYear('created_at', $year)->whereMonth('created_at', $m)->count();
        }
    }
    $chartBulanan = $chartBulananPerTahun[$currentYear];

    // Hitung Rata-Rata Waktu Pemrosesan (Durasi dari tiket dibuat 'created_at' hingga ditindaklanjuti 'updated_at')
    // Mengambil tiket permohonan dan keberatan yang sudah pernah ditindaklanjuti (bukan lagi 'diajukan')
    $tiketSelesaiPermohonan = \App\Models\Permohonan::whereIn('status', ['diproses', 'selesai', 'ditolak'])->get(['created_at', 'updated_at']);
    $tiketSelesaiKeberatan = \App\Models\Keberatan::whereIn('status', ['diproses', 'selesai', 'ditolak'])->get(['created_at', 'updated_at']);
    $semuaTiketProses = $tiketSelesaiPermohonan->concat($tiketSelesaiKeberatan);

    $rataRataWaktuTeks = '1 Hari'; // Default standar layanan KIP
    if ($semuaTiketProses->isNotEmpty()) {
        $totalDetik = 0;
        foreach ($semuaTiketProses as $tiket) {
            $totalDetik += $tiket->created_at->diffInSeconds($tiket->updated_at);
        }
        $avgDetik = $totalDetik / $semuaTiketProses->count();
        // Pembulatan ke atas (ceil) ke satuan hari penuh, minimal 1 hari
        $avgHari = max(1, (int) ceil($avgDetik / 86400));
        $rataRataWaktuTeks = $avgHari . ' Hari';
    }

    $dokumenTerbaru = \App\Models\InformasiPublik::latest()->take(4)->get();
    
    // Konten dinamis Tanya Jawab (FAQ) dari file JSON
    $faqs = AdminBerandaController::getFaqs();

    return view('masyarakat.beranda.index', compact(
        'totalDokumen',
        'totalPermohonan',
        'totalPermohonanSelesai',
        'totalPermohonanDitolak',
        'totalKeberatan',
        'totalDilihat',
        'kategoriCount',
        'chartTahunan',
        'chartBulanan',
        'chartBulananPerTahun',
        'rataRataWaktuTeks',
        'dokumenTerbaru',
        'faqs'
    ));
})->name('beranda');
Route::get('/home', function () { return redirect()->route('beranda'); });

// Rute Katalog Informasi Publik untuk Publik
Route::get('/informasi-publik', [MasyarakatInformasiPublikController::class, 'index'])->name('informasi.publik');
Route::get('/informasi-publik/kategori/{slug}', [MasyarakatInformasiPublikController::class, 'kategori'])->name('informasi.kategori');
Route::get('/informasi-dikecualikan', [MasyarakatInformasiPublikController::class, 'dikecualikan'])->name('informasi.dikecualikan');
Route::get('/informasi-publik/{id}', [MasyarakatInformasiPublikController::class, 'show'])->name('informasi.detail');

// Rute Halaman Hub Layanan PPID Online (Dialihkan langsung ke Permohonan)
Route::get('/layanan', function () { return redirect()->route('layanan.permohonan'); })->name('layanan');

// Rute Autentikasi Guest (Belum Login)
Route::middleware('guest')->group(function () {
    // Login Pemohon & Admin
    Route::get('/login', function () { return view('auth.login.index'); })->name('login');
    Route::get('/admin-panel/login', function () { return view('auth.admin_login'); })->name('admin.login');

    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'publicLoginProcess');
        Route::post('/admin-panel/login', 'adminLoginProcess');
        Route::get('/auth/google', 'redirectToGoogle');
        Route::get('/auth/google/callback', 'handleGoogleCallback');
    });

    // Lupa & Reset Kata Sandi
    Route::get('/forgot-password', function () { return view('auth.password.forgot'); })->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', function ($token) { return view('auth.password.reset', ['token' => $token]); })->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // Registrasi Pemohon (3 Tahap)
    Route::controller(AuthController::class)->group(function () {
        Route::get('/register', 'showRegisterStep1')->name('register');
        Route::post('/register/step1', 'processRegisterStep1')->name('register.step1.process');

        Route::get('/register/verifikasi', 'showRegisterStep2')->name('register.step2')->middleware('signed');
        Route::post('/register/verifikasi', 'processRegisterStep2')->name('register.step2.process');
        Route::post('/register/resend-otp', 'resendOtp')->name('register.resend');

        Route::get('/register/lengkapi-profil', 'showRegisterStep3')->name('register.step3')->middleware('signed');
        Route::post('/register/lengkapi-profil', 'processRegisterStep3')->name('register.step3.process');
    });
});

// Rute Logout & Sesi Terproteksi Pemohon (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/riwayat-layanan', [MasyarakatRiwayatLayananController::class, 'index'])->name('layanan.riwayat');

    // Rute Formulir Permohonan Informasi Publik (Wajib Login)
    Route::controller(MasyarakatPermohonanController::class)->group(function () {
        Route::get('/permohonan', 'index')->name('layanan.permohonan');
        Route::post('/permohonan', 'store')->name('layanan.permohonan.store');
        Route::get('/permohonan-informasi', function () { return redirect('/permohonan'); });
        Route::get('/layanan/permohonan-informasi', function () { return redirect('/permohonan'); });
    });

    // Rute Formulir Pengajuan Keberatan Informasi (Wajib Login)
    Route::controller(MasyarakatKeberatanController::class)->group(function () {
        Route::get('/pengajuan-keberatan', 'index')->name('layanan.keberatan');
        Route::post('/pengajuan-keberatan', 'store')->name('layanan.keberatan.store');
    });
});

// Rute Lihat Berkas Dokumen Informasi Publik (Publik / Masyarakat)
Route::get('/informasi/lihat/{id}', function (Request $request, $id) {
    $info = \App\Models\InformasiPublik::findOrFail($id);
    
    // Increment Counter Dilihat hanya jika dibuka dari bagian masyarakat (BUKAN dari panel admin)
    if (!$request->has('from_admin') && \Illuminate\Support\Facades\Schema::hasColumn('informasi_publik', 'dilihat')) {
        $info->increment('dilihat');
    }

    if ($info->link_informasi && !$info->file_informasi) {
        return redirect()->away($info->link_informasi);
    }
    
    if ($info->file_informasi) {
        $path = null;
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($info->file_informasi)) {
            $path = storage_path('app/public/' . $info->file_informasi);
        } elseif (\Illuminate\Support\Facades\Storage::disk('local')->exists($info->file_informasi)) {
            $path = storage_path('app/' . $info->file_informasi);
        } elseif (file_exists(public_path('storage/' . $info->file_informasi))) {
            $path = public_path('storage/' . $info->file_informasi);
        }

        if ($path && file_exists($path)) {
            $filename = $info->nama_file_asli ?: basename($path);
            $mimeType = \Illuminate\Support\Facades\File::mimeType($path) ?? 'application/octet-stream';

            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . addslashes($filename) . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        }
    }
    abort(404, 'File tidak ditemukan');
})->name('informasi.lihat');

// Rute alternatif dengan nama file asli pada URL (contoh: /informasi/file/20/Transkrip_Akademik.pdf)
Route::get('/informasi/file/{id}/{filename}', function (Request $request, $id, $filename) {
    $info = \App\Models\InformasiPublik::findOrFail($id);

    // Increment Counter Dilihat hanya jika dibuka dari bagian masyarakat (BUKAN dari panel admin)
    if (!$request->has('from_admin')) {
        $info->increment('dilihat');
    }

    if ($info->file_informasi) {
        $path = null;
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($info->file_informasi)) {
            $path = storage_path('app/public/' . $info->file_informasi);
        } elseif (\Illuminate\Support\Facades\Storage::disk('local')->exists($info->file_informasi)) {
            $path = storage_path('app/' . $info->file_informasi);
        } elseif (file_exists(public_path('storage/' . $info->file_informasi))) {
            $path = public_path('storage/' . $info->file_informasi);
        }

        if ($path && file_exists($path)) {
            $mimeType = \Illuminate\Support\Facades\File::mimeType($path) ?? 'application/octet-stream';

            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . addslashes($filename) . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        }
    }
    abort(404, 'File tidak ditemukan');
})->name('informasi.lihat.file');

// Rute preview berkas permohonan dengan nama file asli pada URL
Route::get('/permohonan/file/{id}/{type}/{filename}', function (Request $request, $id, $type, $filename) {
    $permohonan = \App\Models\Permohonan::findOrFail($id);
    
    $filePath = ($type === 'identitas') ? $permohonan->file_identitas : $permohonan->file_pendukung;
    $namaAsli = ($type === 'identitas') ? $permohonan->nama_file_identitas_asli : $permohonan->nama_file_pendukung_asli;

    if ($filePath) {
        $path = null;
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
            $path = storage_path('app/public/' . $filePath);
        } elseif (\Illuminate\Support\Facades\Storage::disk('local')->exists($filePath)) {
            $path = storage_path('app/' . $filePath);
        } elseif (file_exists(public_path('storage/' . $filePath))) {
            $path = public_path('storage/' . $filePath);
        }

        if ($path && file_exists($path)) {
            $mimeType = \Illuminate\Support\Facades\File::mimeType($path) ?? 'application/octet-stream';
            $displayName = $namaAsli ?: $filename;

            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . addslashes($displayName) . '"',
            ]);
        }
    }

    abort(404, 'File lampiran tidak ditemukan');
})->name('permohonan.file');

// Rute preview berkas lampiran keberatan dengan nama file asli pada URL
Route::get('/keberatan/file/{id}/{filename}', function (Request $request, $id, $filename) {
    $keberatan = \App\Models\Keberatan::findOrFail($id);
    
    $filePath = $keberatan->file_pendukung;
    $namaAsli = $keberatan->nama_file_pendukung_asli;

    if ($filePath) {
        $path = null;
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
            $path = storage_path('app/public/' . $filePath);
        } elseif (\Illuminate\Support\Facades\Storage::disk('local')->exists($filePath)) {
            $path = storage_path('app/' . $filePath);
        } elseif (file_exists(public_path('storage/' . $filePath))) {
            $path = public_path('storage/' . $filePath);
        }

        if ($path && file_exists($path)) {
            $mimeType = \Illuminate\Support\Facades\File::mimeType($path) ?? 'application/octet-stream';
            $displayName = $namaAsli ?: $filename;

            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . addslashes($displayName) . '"',
            ]);
        }
    }

    abort(404, 'File lampiran keberatan tidak ditemukan');
})->name('keberatan.file');

// Rute Admin: Informasi Publik, Permohonan, & Keberatan
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function() { return redirect('/admin/informasi-publik'); })->name('admin.dashboard');
    Route::get('/dashboard', function() { return redirect('/admin/informasi-publik'); });

    Route::get('/informasi-publik', [AdminInformasiPublikController::class, 'index']);
    Route::post('/informasi-publik', [AdminInformasiPublikController::class, 'store']);
    Route::put('/informasi-publik/{id}', [AdminInformasiPublikController::class, 'update']);
    Route::delete('/informasi-publik/bulk-delete', [AdminInformasiPublikController::class, 'destroyBulk'])->name('admin.informasi.bulk');
    Route::delete('/informasi-publik/{id}', [AdminInformasiPublikController::class, 'destroy']);

    // Rute Admin: Daftar Informasi Dikecualikan (DIK)
    Route::get('/informasi-dikecualikan', [AdminInformasiDikecualikanController::class, 'index'])->name('admin.informasi-dikecualikan.index');
    Route::post('/informasi-dikecualikan', [AdminInformasiDikecualikanController::class, 'store'])->name('admin.informasi-dikecualikan.store');
    Route::put('/informasi-dikecualikan/{id}', [AdminInformasiDikecualikanController::class, 'update'])->name('admin.informasi-dikecualikan.update');
    Route::delete('/informasi-dikecualikan/bulk-delete', [AdminInformasiDikecualikanController::class, 'destroyBulk'])->name('admin.informasi-dikecualikan.bulk');
    Route::delete('/informasi-dikecualikan/{id}', [AdminInformasiDikecualikanController::class, 'destroy'])->name('admin.informasi-dikecualikan.destroy');

    // Rute Admin: Permohonan Informasi
    Route::get('/permohonan', [AdminPermohonanController::class, 'index'])->name('admin.permohonan.index');
    Route::get('/permohonan/{id}', [AdminPermohonanController::class, 'show'])->name('admin.permohonan.show');
    Route::put('/permohonan/{id}/status', [AdminPermohonanController::class, 'updateStatus'])->name('admin.permohonan.update-status');
    Route::delete('/permohonan/bulk-delete', [AdminPermohonanController::class, 'destroyBulk'])->name('admin.permohonan.bulk');
    Route::delete('/permohonan/{id}', [AdminPermohonanController::class, 'destroy'])->name('admin.permohonan.destroy');

    // Rute Admin: Pengajuan Keberatan Informasi
    Route::get('/keberatan', [AdminKeberatanController::class, 'index'])->name('admin.keberatan.index');
    Route::get('/keberatan/{id}', [AdminKeberatanController::class, 'show'])->name('admin.keberatan.show');
    Route::put('/keberatan/{id}/status', [AdminKeberatanController::class, 'updateStatus'])->name('admin.keberatan.update-status');
    Route::delete('/keberatan/bulk-delete', [AdminKeberatanController::class, 'destroyBulk'])->name('admin.keberatan.bulk');
    Route::delete('/keberatan/{id}', [AdminKeberatanController::class, 'destroy'])->name('admin.keberatan.destroy');

    // Rute Admin: Tanya Jawab (FAQ)
    Route::get('/faq', [AdminBerandaController::class, 'index'])->name('admin.faq.index');
    Route::post('/faq', [AdminBerandaController::class, 'storeFaq'])->name('admin.faq.store');
    Route::delete('/faq/{id}', [AdminBerandaController::class, 'destroyFaq'])->name('admin.faq.destroy');
    // Alias redirect rute lama
    Route::get('/beranda-konten', function () { return redirect()->route('admin.faq.index'); });

    // Rute Admin: Statistik Layanan
    Route::get('/statistik', [AdminStatistikController::class, 'index'])->name('admin.statistik.index');

    // Rute Admin: Ekspor Data (Excel / CSV & Cetak PDF)
    Route::controller(\App\Http\Controllers\Admin\ExportController::class)->prefix('export')->group(function () {
        Route::get('/informasi/excel', 'exportInformasiExcel')->name('admin.export.informasi.excel');
        Route::get('/informasi/pdf', 'exportInformasiPdf')->name('admin.export.informasi.pdf');
        
        Route::get('/statistik/excel', 'exportStatistikExcel')->name('admin.export.statistik.excel');
        Route::get('/statistik/pdf', 'exportStatistikPdf')->name('admin.export.statistik.pdf');

        Route::get('/permohonan/excel', 'exportPermohonanExcel')->name('admin.export.permohonan.excel');
        Route::get('/permohonan/pdf', 'exportPermohonanPdf')->name('admin.export.permohonan.pdf');

        Route::get('/keberatan/excel', 'exportKeberatanExcel')->name('admin.export.keberatan.excel');
        Route::get('/keberatan/pdf', 'exportKeberatanPdf')->name('admin.export.keberatan.pdf');
    });
});


// Utility Route
Route::post('/login/with-email', function (Request $request) {
    return redirect()->route('login')->with('auto_email', $request->input('email'));
})->name('login.with.email');