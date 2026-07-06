<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\KeberatanController;
use App\Http\Controllers\DashboardController; // Untuk Admin
use App\Http\Controllers\UserProfileController; // Untuk Pemohon/User
use App\Http\Controllers\RiwayatController; // Untuk History Layanan
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('public.beranda'); });
Route::get('/informasi-publik', [InformasiPublikController::class, 'index']);
Route::get('/akses-dokumen/{id}', [InformasiPublikController::class, 'hitungAkses'])->name('akses.dokumen');

/*
|--------------------------------------------------------------------------
| 2. RUTE GUEST (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::get('/admin-panel/login', function () { return view('admin.login'); })->name('admin.login');

    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'publicLoginProcess');
        Route::post('/admin-panel/login', 'adminLoginProcess');
        Route::get('/auth/google', 'redirectToGoogle');
        Route::get('/auth/google/callback', 'handleGoogleCallback');
    });

    Route::get('/forgot-password', function () { return view('auth.forgot_password'); })->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', function ($token) { return view('auth.reset_password', ['token' => $token]); })->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    Route::controller(AuthController::class)->group(function () {
        Route::get('/register', 'showRegisterStep1')->name('register');
        Route::post('/register/step1', 'processRegisterStep1')->name('register.step1.process');

        Route::get('/register/verifikasi', 'showRegisterStep2')->name('register.step2')->middleware('signed');
        Route::post('/register/verifikasi', 'processRegisterStep2')->name('register.step2.process'); // TAMBAHKAN INI

        Route::post('/register/resend-otp', 'resendOtp')->name('register.resend');

        Route::get('/register/lengkapi-profil', 'showRegisterStep3')->name('register.step3')->middleware('signed');
        Route::post('/register/lengkapi-profil', 'processRegisterStep3')->name('register.step3.process'); // TAMBAHKAN INI
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

    // Dashboard & Update Profile Pemohon
    Route::get('/dashboard', [UserProfileController::class, 'index'])->name('user.dashboard');
    Route::post('/dashboard/update', [UserProfileController::class, 'updateProfile'])->name('user.profile.update');

    // Riwayat & Detail Layanan (RUTE INI YANG DITAMBAHKAN)
    Route::get('/riwayat-layanan', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/permohonan/{id}', [RiwayatController::class, 'showPermohonan'])->name('riwayat.permohonan.detail');
    Route::get('/riwayat/keberatan/{id}', [RiwayatController::class, 'showKeberatan'])->name('riwayat.keberatan.detail');

    // Layanan PPID
    Route::get('/permohonan', [PermohonanController::class, 'create'])->name('permohonan.create');
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/keberatan', [KeberatanController::class, 'create'])->name('keberatan.create');
    Route::post('/keberatan', [KeberatanController::class, 'store'])->name('keberatan.store');
});

/*
|--------------------------------------------------------------------------
| 4. RUTE ADMIN (Terproteksi Middleware 'admin')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Manajemen Informasi Publik
    Route::get('/informasi-publik', [InformasiPublikController::class, 'adminIndex']);
    Route::get('/informasi-publik/create', [InformasiPublikController::class, 'create']);
    Route::post('/informasi-publik', [InformasiPublikController::class, 'store']);
    Route::get('/informasi-publik/{id}/edit', [InformasiPublikController::class, 'edit']);
    Route::put('/informasi-publik/{id}', [InformasiPublikController::class, 'update']);
    Route::delete('/informasi-publik/{id}', [InformasiPublikController::class, 'destroy']);

    // Manajemen Permohonan & Keberatan
    Route::get('/permohonan', [PermohonanController::class, 'adminIndex']);
    Route::get('/permohonan/{id}', [PermohonanController::class, 'show']);
    Route::put('/permohonan/{id}/status', [PermohonanController::class, 'updateStatus']);
    Route::get('/keberatan', function () { return view('admin.keberatan'); });
});

/* --- UTILITY ROUTE --- */
Route::post('/login/with-email', function (Request $request) {
    return redirect()->route('login')->with('auto_email', $request->input('email'));
})->name('login.with.email');
