<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL; // <--- PERBAIKAN PRO: Wajib diimpor untuk fitur URL Terenkripsi
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    /* =======================================================
       BAGIAN 1: LOGIKA ADMIN (JALUR RAHASIA)
       ======================================================= */
    public function adminLoginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials['role'] = 'admin';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Akses ditolak. Kredensial tidak valid atau Anda bukan Admin.',
        ])->onlyInput('email');
    }


    /* =======================================================
       BAGIAN 2: LOGIKA MASYARAKAT (TANPA LIMITER SIDANG)
       ======================================================= */
    public function publicLoginProcess(Request $request)
    {
        // 1. Validasi wajib isi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak sah.',
            'password.required' => 'Kata sandi wajib diisi.'
        ]);

        // 2. Siapkan kunci (hanya untuk role masyarakat)
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'masyarakat'
        ];

        // 3. Eksekusi Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Aman dari penyadapan Wi-Fi kampus
            return redirect()->intended('/');
        }

        // 4. Jika gagal, kembalikan pesan ambigu tanpa hukuman waktu
        return back()->withErrors([
            'login_gagal' => 'Email atau kata sandi yang Anda masukkan salah.'
        ])->onlyInput('email');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email'
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak sah.'
        ]);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset kata sandi telah dikirim ke email Anda.')
            : back()->withErrors(['email' => 'Gagal mengirim link reset.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.required'   => 'Kata sandi wajib diisi.',
            'password.min'        => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'  => 'Konfirmasi kata sandi tidak cocok.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) { $user->password = Hash::make($password); $user->save(); });

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('status', 'Sandi berhasil diubah.')
            : back()->withErrors(['email' => 'Token tidak valid.']);
    }


    /* =======================================================
       BAGIAN 3: REGISTRASI ESTAFET (ENTERPRISE SIGNED-URL)
       ======================================================= */
    public function showRegisterStep1()
    {
        return view('auth.register_step1');
    }

    public function processRegisterStep1(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:users,email'
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak sah.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan masuk.'
        ]);

        $email = $request->email;
        $otp = rand(1000, 9999);

        // Simpan angka OTP di Cache selama 3 menit
        Cache::put('otp_' . $email, $otp, now()->addMinutes(3));

        // DETIK BERSEJARAH: Buat URL Verifikasi yang disegel dengan Kriptografi (Valid 15 menit)
        $urlTerenkripsiStep2 = URL::temporarySignedRoute(
            'register.step2',
            now()->addMinutes(15),
            ['email' => $email] // <--- Menitipkan email di dalam segel rahasia
        );

        // Kirim email lewat Tukang Pos Google
        try {
            Mail::send('emails.otp', ['otp' => $otp], function($message) use ($email) {
                $message->to($email)->subject('Kode Verifikasi Pendaftaran PPID FMIPA Unila');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim OTP. Periksa koneksi internet Anda.'])->withInput();
        }

        // Lempar pemohon ke URL panjang yang bersegel
        return redirect($urlTerenkripsiStep2);
    }


    /* --- LANGKAH 2: COCOKKAN OTP --- */
    public function showRegisterStep2(Request $request)
    {
        // Karena sudah dipagari @signed di web.php, parameter 'email' di URL ini 100% dijamin ASLI
        $email = $request->query('email');
        return view('auth.register_step2', ['email' => $email]);
    }

    public function processRegisterStep2(Request $request)
    {
        $request->validate(['otp' => 'required|digits:4'], [
            'otp.required' => 'Kode OTP harus diisi',
            'otp.digits' => 'Kode OTP harus 4 angka'
        ]);

        $email = $request->query('email'); // Ambil email dari URL bersegel
        $cachedOtp = Cache::get('otp_' . $email);

        if (!$cachedOtp) {
            return back()->withErrors(['otp' => 'Kode OTP telah kedaluwarsa. Silakan klik Kirim Ulang.']);
        }

        if ((int)$request->otp !== (int)$cachedOtp) {
            return back()->withErrors(['otp' => 'Kode OTP yang Anda masukkan salah.']);
        }

        // JIKA OTP BENAR: Hapus memori OTP, lalu buatkan Segel URL baru untuk masuk ke Step 3
        Cache::forget('otp_' . $email);

        $urlTerenkripsiStep3 = URL::temporarySignedRoute(
            'register.step3',
            now()->addMinutes(15),
            ['email' => $email]
        );

        return redirect($urlTerenkripsiStep3);
    }

    public function resendOtp(Request $request)
    {
        // 1. Tangkap email dari form
        $email = $request->input('email');

        if (!$email) {
            return redirect()->route('register')->withErrors(['email' => 'Sesi tidak valid, silakan ulangi.']);
        }

        // 2. Buat angka OTP baru
        $otp = rand(1000, 9999);
        Cache::put('otp_' . $email, $otp, now()->addMinutes(3));

        // 3. Kirim ulang email
        try {
            Mail::send('emails.otp', ['otp' => $otp], function($m) use ($email) {
                $m->to($email)->subject('Kode Verifikasi Pendaftaran PPID FMIPA Unila');
            });
        } catch (\Exception $e) {
            // Abaikan jika gagal koneksi agar web tidak crash
        }

        // 4. KUNCI ANTI MENTAL: Buatkan segel URL Step 2 yang baru, lalu redirect ke sana!
        $urlStep2Baru = URL::temporarySignedRoute(
            'register.step2',
            now()->addMinutes(15),
            ['email' => $email]
        );

        return redirect($urlStep2Baru)->with('success', 'Kode OTP baru berhasil dikirim ulang ke email Anda.');
    }


    /* --- LANGKAH 3: FINALISASI --- */
    public function showRegisterStep3(Request $request)
    {
        $email = $request->query('email');
        return view('auth.register_step3', ['email' => $email]);
    }

    public function processRegisterStep3(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama Lengkap harus diisi',
            'password.required' => 'Kata Sandi harus diisi',
            'password.min' => 'Kata sandi minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok'
        ]);

        $email = $request->query('email'); // Ambil email dari segel terakhir

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $email,
            'password' => Hash::make($request->password),
            'role' => 'masyarakat',
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Selamat! Akun Anda berhasil diverifikasi dan didaftarkan.');
    }


    /* =======================================================
       BAGIAN 4: GOOGLE SSO & LOGOUT
       ======================================================= */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'nama_lengkap' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'role' => 'masyarakat',
                ]);
            } else {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            Auth::login($user);
            return redirect()->intended('/');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Terjadi kesalahan saat terhubung ke Google. Silakan coba lagi.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
