<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\KeberatanController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('public.beranda'); });
Route::get('/informasi-publik', [InformasiPublikController::class, 'index']);


/*
|--------------------------------------------------------------------------
| 2. RUTE GUEST
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
        Route::post('/register/step1', 'processRegisterStep1');
        Route::get('/register/verifikasi', 'showRegisterStep2')->name('register.step2')->middleware('signed');
        Route::post('/register/verifikasi', 'processRegisterStep2');
        Route::post('/register/resend-otp', 'resendOtp')->name('register.resend');
        Route::get('/register/lengkapi-profil', 'showRegisterStep3')->name('register.step3')->middleware('signed');
        Route::post('/register/lengkapi-profil', 'processRegisterStep3');
    });
});


/*
|--------------------------------------------------------------------------
| 3. RUTE TERPROTEKSI
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/profil/buat-sandi-manual', 'buatSandiManual')->name('profil.buat-sandi');
    });

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware('auth');

    // Manajemen Informasi Publik
    Route::get('/admin/informasi-publik', [InformasiPublikController::class, 'adminIndex']);
    Route::get('/admin/informasi-publik/create', [InformasiPublikController::class, 'create']);
    Route::post('/admin/informasi-publik', [InformasiPublikController::class, 'store']);
    Route::get('/admin/informasi-publik/{id}/edit', [InformasiPublikController::class, 'edit']);
    Route::put('/admin/informasi-publik/{id}', [InformasiPublikController::class, 'update']);
    Route::delete('/admin/informasi-publik/{id}', [InformasiPublikController::class, 'destroy']);

    // Manajemen Permohonan (Dinamis)
    Route::get('/admin/permohonan', [PermohonanController::class, 'adminIndex']);
    Route::get('/admin/permohonan/{id}', [PermohonanController::class, 'show']); // Detail
    Route::put('/admin/permohonan/{id}/status', [PermohonanController::class, 'updateStatus']); // Eksekusi Status

    // Manajemen Keberatan
    Route::get('/admin/keberatan', function () { return view('admin.keberatan'); });

    // Layanan Permohonan Masyarakat
    Route::get('/permohonan', [PermohonanController::class, 'create'])->name('permohonan.create');
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');

    // Layanan Keberatan Masyarakat
    Route::get('/keberatan', [KeberatanController::class, 'create'])->name('keberatan.create');
    Route::post('/keberatan', [KeberatanController::class, 'store'])->name('keberatan.store');
});


/*
|--------------------------------------------------------------------------
| 4. RUTE UTILITY
|--------------------------------------------------------------------------
*/
Route::post('/login/with-email', function (Request $request) {
    return redirect()->route('login')->with('auto_email', $request->input('email'));
})->name('login.with.email');
