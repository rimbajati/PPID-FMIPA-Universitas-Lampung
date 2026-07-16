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
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private function getValidationMessages()
    {
        return [
            'email.required'    => 'Email harus diisi.',
            'email.email'       => 'Masukkan email dengan format yang benar.',
            'email.unique'      => 'Email telah terdaftar.',
            'password.required' => 'Kata sandi harus diisi.',
            'password.min'      => 'Kata sandi minimal 8 karakter.',
            'otp.required'      => 'Kode OTP harus diisi.',
            'otp.digits'        => 'Kode OTP harus 4 digit.',
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ];
    }

    public function adminLoginProcess(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required'], $this->getValidationMessages());
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard');
        }
        return back()->withErrors(['login_gagal' => 'Akses ditolak. Kredensial salah.']);
    }

    public function publicLoginProcess(Request $request)
    {
        $request->validate(['email' => 'required|email', 'password' => 'required'], $this->getValidationMessages());
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'masyarakat'])) {
            $request->session()->regenerate();
            return redirect()->intended('/layanan');
        }
        return back()->withErrors(['login_gagal' => 'Email atau kata sandi salah.']);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email'], $this->getValidationMessages());
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
        ], $this->getValidationMessages());

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('status', 'Kata sandi berhasil diubah. Silakan masuk kembali.')
            : back()->withErrors(['email' => 'Token tidak valid atau sudah kedaluwarsa.']);
    }

    public function showRegisterStep1() { return view('auth.daftar_tahap1'); }

    public function processRegisterStep1(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255|unique:users,email'], $this->getValidationMessages());
        $email = $request->email;
        $otp = rand(1000, 9999);
        Cache::put('otp_' . $email, $otp, now()->addMinutes(5));
        $urlStep2 = URL::temporarySignedRoute('register.step2', now()->addMinutes(15), ['email' => $email]);
        try {
            Mail::send('email.otp', ['otp' => $otp], function($m) use ($email) {
                $m->to($email)->subject('Kode Verifikasi Pendaftaran PPID FMIPA Unila');
            });
        } catch (\Exception $e) { return back()->withErrors(['email' => 'Gagal mengirim email.']); }
        return redirect($urlStep2);
    }

    public function showRegisterStep2(Request $request) { return view('auth.daftar_tahap2', ['email' => $request->query('email')]); }

    public function processRegisterStep2(Request $request)
    {
        $email = $request->query('email');
        if (RateLimiter::tooManyAttempts('otp-check:' . $email, 5)) return back()->withErrors(['otp' => 'Terlalu banyak percobaan.']);
        $request->validate(['otp' => 'required|digits:4'], $this->getValidationMessages());
        $cachedOtp = Cache::get('otp_' . $email);
        if (!$cachedOtp || (int)$request->otp !== (int)$cachedOtp) {
            RateLimiter::hit('otp-check:' . $email);
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }
        Cache::forget('otp_' . $email);
        return redirect(URL::temporarySignedRoute('register.step3', now()->addMinutes(15), ['email' => $email]));
    }

    // FUNGSI INI DITAMBAHKAN KEMBALI KARENA TADI HILANG
    public function resendOtp(Request $request)
    {
        $email = $request->input('email');
        if (!$email) return redirect()->route('register');
        $otp = rand(1000, 9999);
        Cache::put('otp_' . $email, $otp, now()->addMinutes(5));
        Mail::send('email.otp', ['otp' => $otp], function($m) use ($email) {
            $m->to($email)->subject('Kode Verifikasi Pendaftaran PPID FMIPA Unila');
        });
        return redirect()->back()->with('success', 'OTP baru telah dikirim.');
    }

    public function showRegisterStep3(Request $request) { return view('auth.daftar_tahap3', ['email' => $request->query('email')]); }

    public function processRegisterStep3(Request $request)
    {
        $request->validate(['nama_lengkap' => 'required|string|max:255', 'password' => 'required|string|min:8|confirmed'], $this->getValidationMessages());
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->query('email'),
            'password' => Hash::make($request->password),
            'role' => 'masyarakat',
        ]);
        Auth::login($user);
        return redirect('/')->with('success', 'Akun berhasil dibuat.');
    }

    public function redirectToGoogle() { return Socialite::driver('google')->redirect(); }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::firstOrCreate(['email' => $googleUser->getEmail()], [
                'nama_lengkap' => $googleUser->getName(),
                'google_id'    => $googleUser->getId(),
                'role'         => 'masyarakat'
            ]);
            if (!$user->wasRecentlyCreated) $user->update(['google_id' => $googleUser->getId()]);
            Auth::login($user);
            return redirect()->intended('/layanan');
        } catch (\Exception $e) { return redirect('/login')->withErrors(['email' => 'Google Login gagal.']); }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
