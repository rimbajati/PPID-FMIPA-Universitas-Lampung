<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK (Bebas diakses tanpa perlu login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return view('public.beranda'); });
Route::get('/informasi-publik', function () { return view('public.informasi_publik'); });


/*
|--------------------------------------------------------------------------
| 2. RUTE GUEST - KHUSUS LOGIN & SSO (Hanya untuk yang belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Tampilan Form Login
    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::get('/admin-panel/login', function () { return view('admin.login'); })->name('admin.login');

    // Proses Login & SSO
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'publicLoginProcess');
        Route::post('/admin-panel/login', 'adminLoginProcess');
        Route::get('/auth/google', 'redirectToGoogle');
        Route::get('/auth/google/callback', 'handleGoogleCallback');
    });

    // Tambahkan di dalam Route::middleware('guest')->group(function () { ... })
    Route::get('/forgot-password', function () { return view('auth.forgot_password'); })->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', function ($token) { return view('auth.reset_password', ['token' => $token]); })->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

});


/*
|--------------------------------------------------------------------------
| 3. RUTE REGISTRASI ESTAFET (LEVEL TOKOPEDIA - SIGNED URL)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->controller(AuthController::class)->group(function () {

    // Langkah 1: Input Email
    Route::get('/register', 'showRegisterStep1')->name('register');
    Route::post('/register/step1', 'processRegisterStep1');

    // Langkah 2: Input Kode OTP 4-Angka (Gembok Kriptografi Level 1)
    Route::get('/register/verifikasi', 'showRegisterStep2')
        ->name('register.step2')
        ->middleware('signed'); // <--- PENGGANTI ENSURE.STEP
    Route::post('/register/verifikasi', 'processRegisterStep2'); // <-- Path disamakan dgn GET
    Route::post('/register/resend-otp', 'resendOtp')->name('register.resend');

    // Langkah 3: Input Nama Lengkap & Sandi (Gembok Kriptografi Level 2)
    Route::get('/register/lengkapi-profil', 'showRegisterStep3')
        ->name('register.step3')
        ->middleware('signed'); // <--- PENGGANTI ENSURE.STEP
    Route::post('/register/lengkapi-profil', 'processRegisterStep3'); // <-- Path disamakan dgn GET

});


/*
|--------------------------------------------------------------------------
| 4. RUTE TERPROTEKSI (Wajib LOGIN untuk bisa mengaksesnya)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::post('/profil/buat-sandi-manual', 'buatSandiManual')->name('profil.buat-sandi');
    });

    Route::get('/admin/dashboard', function () {
        return '<h1>Selamat Datang di Dasbor Admin PPID FMIPA Unila!</h1><p>Autentikasi Pintu Rahasia Berhasil.</p>';
    });

});

Route::post('/login/with-email', function (Request $request) {
    // Gunakan method input() yang lebih aman
    $email = $request->input('email');
    return redirect()->route('login')->with('auto_email', $email);
})->name('login.with.email');

// Catatan: Rute /bom-sesi saya matikan (comment), karena dengan Signed URL,
// keamanan tidak lagi diatur oleh Session browser, melainkan oleh rumus matematika di URL.
/*
Route::get('/bom-sesi', function () {
    session()->flush();
    return '<h1>Sesi pendaftaran sudah dibom nuklir.</h1>...';
});
*/
