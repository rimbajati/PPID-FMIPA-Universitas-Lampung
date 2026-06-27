<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /* =======================================================
       LOGIKA LOGIN (ADMIN & MASYARAKAT)
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

        throw ValidationException::withMessages([
            'email' => 'Akses ditolak. Kredensial tidak valid atau Anda bukan Admin.',
        ]);
    }

    public function publicLoginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'masyarakat'])) {
            $request->session()->regenerate();

            // INTENDED: Langsung kembali ke halaman yang tadi diakses (misal: /permohonan)
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login_gagal' => 'Email atau kata sandi yang Anda masukkan salah.'
        ])->onlyInput('email');
    }

    /* =======================================================
       LOGIKA RESET PASSWORD
       ======================================================= */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset kata sandi telah dikirim.')
            : back()->withErrors(['email' => 'Gagal mengirim link reset.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            });

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('status', 'Sandi berhasil diubah.')
            : back()->withErrors(['email' => 'Token tidak valid.']);
    }

    /* =======================================================
       LOGIKA REGISTRASI ESTAFET (SIGNED URL)
       ======================================================= */
    public function showRegisterStep1() { return view('auth.register_step1'); }

    public function processRegisterStep1(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255|unique:users,email']);

        $email = $request->email;
        $otp = rand(1000, 9999);

        Cache::put('otp_' . $email, $otp, now()->addMinutes(5));

        $urlStep2 = URL::temporarySignedRoute('register.step2', now()->addMinutes(15), ['email' => $email]);

        try {
            Mail::send('emails.otp', ['otp' => $otp], function($m) use ($email) {
                $m->to($email)->subject('Kode Verifikasi Pendaftaran PPID FMIPA Unila');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email verifikasi.'])->withInput();
        }

        return redirect($urlStep2);
    }

    public function showRegisterStep2(Request $request) { return view('auth.register_step2', ['email' => $request->query('email')]); }

    public function processRegisterStep2(Request $request)
    {
        $email = $request->query('email');

        if (RateLimiter::tooManyAttempts('otp-check:' . $email, 5)) {
            return back()->withErrors(['otp' => 'Terlalu banyak percobaan. Tunggu 1 menit.']);
        }

        $request->validate(['otp' => 'required|digits:4']);
        $cachedOtp = Cache::get('otp_' . $email);

        if (!$cachedOtp || (int)$request->otp !== (int)$cachedOtp) {
            RateLimiter::hit('otp-check:' . $email);
            return back()->withErrors(['otp' => 'Kode OTP salah atau kedaluwarsa.']);
        }

        Cache::forget('otp_' . $email);
        RateLimiter::clear('otp-check:' . $email);

        $urlStep3 = URL::temporarySignedRoute('register.step3', now()->addMinutes(15), ['email' => $email]);
        return redirect($urlStep3);
    }

    public function resendOtp(Request $request)
    {
        $email = $request->input('email');
        if (!$email) return redirect()->route('register');

        $otp = rand(1000, 9999);
        Cache::put('otp_' . $email, $otp, now()->addMinutes(5));

        Mail::send('emails.otp', ['otp' => $otp], function($m) use ($email) {
            $m->to($email)->subject('Kode Verifikasi Pendaftaran PPID FMIPA Unila');
        });

        return redirect()->back()->with('success', 'OTP baru telah dikirim.');
    }

    public function showRegisterStep3(Request $request) { return view('auth.register_step3', ['email' => $request->query('email')]); }

    public function processRegisterStep3(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->query('email'),
            'password' => Hash::make($request->password),
            'role' => 'masyarakat',
        ]);

        Auth::login($user);
        return redirect('/')->with('success', 'Akun berhasil dibuat.');
    }

    /* =======================================================
       GOOGLE SSO & LOGOUT
       ======================================================= */
    public function redirectToGoogle() { return Socialite::driver('google')->redirect(); }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                ['nama_lengkap' => $googleUser->getName(), 'google_id' => $googleUser->getId(), 'role' => 'masyarakat']
            );

            Auth::login($user);
            // Fitur intended otomatis membawa user kembali ke halaman yang mereka coba akses
            return redirect()->intended('/');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Google Login gagal.']);
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
