<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PengajuanController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('public.beranda'); });
Route::get('/informasi-publik', [InformasiPublikController::class, 'index']);
Route::get('/informasi-setiap-saat', [App\Http\Controllers\InformasiPublikController::class, 'indexSetiapSaat']);
Route::get('/informasi-berkala', [App\Http\Controllers\InformasiPublikController::class, 'indexBerkala']);
Route::get('/informasi-serta-merta', [App\Http\Controllers\InformasiPublikController::class, 'indexSertaMerta']);
Route::get('/informasi/akses/{id}', [InformasiPublikController::class, 'hitungAkses']);
// Rute khusus untuk melihat berkas privat (Inline Streaming PDF)
Route::get('/informasi/lihat/{id}/{slug?}', [App\Http\Controllers\InformasiPublikController::class, 'lihatFile'])->name('informasi.file');

// Rute khusus untuk jembatan/proxy link luar (Redirect Gateway)
Route::get('/informasi/kunjungi/{id}/{slug?}', [App\Http\Controllers\InformasiPublikController::class, 'kunjungiLink'])->name('informasi.link');
Route::get('/statistik', [StatistikController::class, 'index'])->name('public.statistik.index');
Route::get('/prosedur-permohonan', function () { return view('public.prosedur_permohonan'); })->name('prosedur.permohonan');

/*
|--------------------------------------------------------------------------
| 2. RUTE GUEST (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.masuk'); })->name('login');
    Route::get('/admin-panel/login', function () { return view('admin.masuk'); })->name('admin.login');

    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'publicLoginProcess');
        Route::post('/admin-panel/login', 'adminLoginProcess');
        Route::get('/auth/google', 'redirectToGoogle');
        Route::get('/auth/google/callback', 'handleGoogleCallback');
    });

    Route::get('/forgot-password', function () { return view('auth.lupa_sandi'); })->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', function ($token) { return view('auth.atur_ulang_sandi', ['token' => $token]); })->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

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

/*
|--------------------------------------------------------------------------
| 3. RUTE TERPROTEKSI (User Pemohon)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/profil/buat-sandi-manual', 'buatSandiManual')->name('profil.buat-sandi');
    });

    Route::middleware('redirect.admin')->group(function () {
        Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
        Route::post('/profile/update', [UserProfileController::class, 'updateProfile'])->name('user.profile.update');

        Route::get('/layanan', [LayananController::class, 'index'])->name('layanan.index');
        Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
        Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
        Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| 4. RUTE ADMIN (Terproteksi Middleware 'admin')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Manajemen Informasi Publik
    Route::get('/informasi-publik', [InformasiPublikController::class, 'adminIndex']);
    Route::get('/informasi-publik/create', [InformasiPublikController::class, 'create']);
    Route::post('/informasi-publik', [InformasiPublikController::class, 'store']);
    Route::get('/informasi-publik/{id}/edit', [InformasiPublikController::class, 'edit']);
    Route::put('/informasi-publik/{id}', [InformasiPublikController::class, 'update']);
    Route::delete('/informasi-publik/bulk-delete', [App\Http\Controllers\InformasiPublikController::class, 'destroyBulk'])->name('admin.informasi.bulk');
    Route::delete('/informasi-publik/{id}', [InformasiPublikController::class, 'destroy']);

    // Manajemen Pengajuan (Penyatuan Permohonan & Keberatan)
    Route::get('/pengajuan', [PengajuanController::class, 'index']);
    Route::get('/pengajuan/{id}', [PengajuanController::class, 'show']);
    Route::put('/pengajuan/{id}/status', [PengajuanController::class, 'updateStatus']);
    Route::delete('/pengajuan/bulk-delete', [PengajuanController::class, 'destroyBulk'])->name('admin.pengajuan.bulk');
    Route::delete('/pengajuan/{id}', [PengajuanController::class, 'destroy'])->name('admin.pengajuan.destroy');

    // Manajemen Prosedur Permohonan
    Route::get('/prosedur-permohonan', [App\Http\Controllers\ProsedurPermohonanController::class, 'edit'])->name('admin.prosedur-permohonan.edit');
    Route::put('/prosedur-permohonan', [App\Http\Controllers\ProsedurPermohonanController::class, 'update'])->name('admin.prosedur-permohonan.update');

    // Manajemen Beranda Utama
    Route::get('/beranda', [App\Http\Controllers\BerandaController::class, 'edit'])->name('admin.beranda.edit');
    Route::put('/beranda', [App\Http\Controllers\BerandaController::class, 'update'])->name('admin.beranda.update');

    // Manajemen Halaman Informasi Publik
    Route::get('/halaman-informasi-publik', [App\Http\Controllers\KontenInformasiPublikController::class, 'edit'])->name('admin.halaman-informasi-publik.edit');
    Route::put('/halaman-informasi-publik', [App\Http\Controllers\KontenInformasiPublikController::class, 'update'])->name('admin.halaman-informasi-publik.update');
});

/* --- UTILITY ROUTE --- */
Route::post('/login/with-email', function (Request $request) {
    return redirect()->route('login')->with('auto_email', $request->input('email'));
})->name('login.with.email');
