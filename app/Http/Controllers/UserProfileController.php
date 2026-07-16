<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('pemohon.profile', ['user' => Auth::user()]);
    }

    // app/Http/Controllers/UserProfileController.php

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'password' => ['nullable', 'confirmed', 'min:6'],
        ];

        if ($user->password) {
            $rules['current_password'] = ['nullable', 'required_with:password', 'current_password'];
        } else {
            $rules['current_password'] = ['nullable'];
        }

        $request->validate($rules, [
            'current_password.required_with' => 'Password lama wajib diisi jika ingin mengganti password.',
            'current_password.current_password' => 'Password lama yang Anda masukkan salah.',
            'password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('status', 'Profil berhasil diperbarui!');
    }
}
