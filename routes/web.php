<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Masyarakat\InformasiPublikController as MasyarakatInformasiPublikController;
use App\Http\Controllers\Masyarakat\PermohonanController as MasyarakatPermohonanController;
use App\Http\Controllers\Masyarakat\KeberatanController as MasyarakatKeberatanController;
use App\Http\Controllers\Admin\InformasiPublikController as AdminInformasiPublikController;
use App\Http\Controllers\Admin\PermohonanController as AdminPermohonanController;
use App\Http\Controllers\Admin\KeberatanController as AdminKeberatanController;
use App\Http\Controllers\Masyarakat\RiwayatLayananController as MasyarakatRiwayatLayananController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| ITERASI 1: MODUL AUTENTIKASI (LOGIN & REGISTRASI)
|--------------------------------------------------------------------------
*/

// Rute Utama Beranda Publik
Route::get('/', function () { return view('masyarakat.beranda.index'); })->name('beranda');
Route::get('/home', function () { return redirect()->route('beranda'); });

// Rute Katalog Informasi Publik untuk Publik
Route::get('/informasi-publik', [MasyarakatInformasiPublikController::class, 'index'])->name('informasi.publik');
Route::get('/informasi-publik/{id}', [MasyarakatInformasiPublikController::class, 'show'])->name('informasi.detail');

// Rute Halaman Hub Layanan PPID Online
Route::get('/layanan', function () { return view('masyarakat.layanan.index'); })->name('layanan');

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
            ]);
        }
    }
    abort(404, 'File tidak ditemukan');
})->name('informasi.lihat');

// Rute alternatif dengan nama file asli pada URL (contoh: /informasi/file/20/Transkrip_Akademik.pdf)
Route::get('/informasi/file/{id}/{filename}', function (Request $request, $id, $filename) {
    $info = \App\Models\InformasiPublik::findOrFail($id);

    // Increment Counter Dilihat hanya jika dibuka dari bagian masyarakat (BUKAN dari panel admin)
    if (!$request->has('from_admin') && \Illuminate\Support\Facades\Schema::hasColumn('informasi_publik', 'dilihat')) {
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
            ]);
        }
    }
    abort(404, 'File tidak ditemukan');
})->name('informasi.lihat.file');

// Rute Admin: Informasi Publik, Permohonan, & Keberatan
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', function() { return redirect('/admin/informasi-publik'); })->name('admin.dashboard');
    Route::get('/dashboard', function() { return redirect('/admin/informasi-publik'); });

    Route::get('/informasi-publik', [AdminInformasiPublikController::class, 'index']);
    Route::post('/informasi-publik', [AdminInformasiPublikController::class, 'store']);
    Route::put('/informasi-publik/{id}', [AdminInformasiPublikController::class, 'update']);
    Route::delete('/informasi-publik/bulk-delete', [AdminInformasiPublikController::class, 'destroyBulk'])->name('admin.informasi.bulk');
    Route::delete('/informasi-publik/{id}', [AdminInformasiPublikController::class, 'destroy']);

    // Rute Admin: Permohonan Informasi
    Route::get('/permohonan', [AdminPermohonanController::class, 'index'])->name('admin.permohonan.index');
    Route::put('/permohonan/{id}/status', [AdminPermohonanController::class, 'updateStatus'])->name('admin.permohonan.update-status');
    Route::delete('/permohonan/bulk-delete', [AdminPermohonanController::class, 'destroyBulk'])->name('admin.permohonan.bulk');
    Route::delete('/permohonan/{id}', [AdminPermohonanController::class, 'destroy'])->name('admin.permohonan.destroy');

    // Rute Admin: Pengajuan Keberatan Informasi
    Route::get('/keberatan', [AdminKeberatanController::class, 'index'])->name('admin.keberatan.index');
    Route::put('/keberatan/{id}/status', [AdminKeberatanController::class, 'updateStatus'])->name('admin.keberatan.update-status');
    Route::delete('/keberatan/bulk-delete', [AdminKeberatanController::class, 'destroyBulk'])->name('admin.keberatan.bulk');
    Route::delete('/keberatan/{id}', [AdminKeberatanController::class, 'destroy'])->name('admin.keberatan.destroy');
});


// Utility Route
Route::post('/login/with-email', function (Request $request) {
    return redirect()->route('login')->with('auto_email', $request->input('email'));
})->name('login.with.email');