@extends('layouts.main')

@section('title', 'Reset Kata Sandi - PPID FMIPA Unila')

@section('content')
<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-sky-50">
    <div class="bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-5xl min-h-[600px]">

        <div class="w-full md:w-1/2 h-72 md:h-auto relative overflow-hidden">
            <img src="{{ asset('images/FMIPA.jpg') }}" alt="Gedung FMIPA Unila" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-full p-10 md:p-12 text-left">
                <h2 class="text-white text-3xl md:text-4xl font-black leading-tight drop-shadow-md">Pejabat Pengelola <br> Informasi & Dokumentasi (PPID)</h2>
                <div class="w-16 h-1.5 bg-[#0095e8] mt-4 mb-4 rounded-full"></div>
                <p class="text-blue-100 text-lg font-medium drop-shadow-md">FMIPA Universitas Lampung</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Reset Kata Sandi</h2>
                <p class="text-gray-500 mt-2 text-sm">Masukkan kata sandi baru untuk akun Anda.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-1.5">Email Akun</label>
                    <input type="email" value="{{ request()->email }}" disabled
                        class="w-full px-5 py-3.5 border border-gray-200 bg-gray-50 text-gray-500 rounded-xl text-base cursor-not-allowed font-semibold">
                    <input type="hidden" name="email" value="{{ request()->email }}">
                </div>

                <div class="relative">
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Kata Sandi Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-5 py-3.5 border {{ $errors->has('password') ? 'border-red-500 bg-red-50/20' : 'border-gray-300 focus:border-[#0095e8]' }} rounded-xl text-base outline-none transition"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 font-bold pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative">
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-5 py-3.5 border border-gray-300 focus:border-[#0095e8] rounded-xl text-base outline-none transition"
                            placeholder="Ulangi kata sandi baru" required>
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1.5 font-bold pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[#0095e8] hover:bg-[#0081c9] text-white font-extrabold py-4 rounded-xl transition shadow-md text-base mt-4 cursor-pointer">
                    Perbarui Kata Sandi
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id + '-icon');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
