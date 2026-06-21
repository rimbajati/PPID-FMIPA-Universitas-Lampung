@extends('layouts.main')

@section('title', 'Masuk - PPID FMIPA Unila')

@section('content')
<!-- CSS pembunuh mata ganda bawaan browser Edge / Chrome -->
<style>
    input::-ms-reveal, input::-ms-clear { display: none; }
    input[type="password"]::-webkit-credentials-auto-fill-button { display: none !important; }
    input[type="password"]::-webkit-eye-off-button, input[type="password"]::-webkit-eye-button { display: none !important; }
</style>

<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-sky-50">

    <div class="bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-5xl min-h-[600px]">

        <!-- BAGIAN KIRI: Gambar Gedung FMIPA -->
        <div class="w-full md:w-1/2 h-72 md:h-auto relative overflow-hidden">
            <img src="{{ asset('images/FMIPA.jpg') }}" alt="Gedung FMIPA Unila" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-full p-10 md:p-12 text-left">
                <h2 class="text-white text-3xl md:text-4xl font-black leading-tight drop-shadow-md">
                    Pejabat Pengelola <br> Informasi & Dokumentasi (PPID)
                </h2>
                <div class="w-16 h-1.5 bg-[#0095e8] mt-4 mb-4 rounded-full"></div>
                <p class="text-blue-100 text-lg font-medium drop-shadow-md">FMIPA Universitas Lampung</p>
            </div>
        </div>

        <!-- BAGIAN KANAN: Form Login -->
        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">

            <div class="mb-8 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900">Masuk Sekarang</h2>
                <p class="text-gray-500 mt-2 text-lg">Belum punya akun? <a href="{{ route('register') }}" class="text-[#0095e8] font-bold hover:underline">Daftar</a></p>
            </div>

            <!-- FORM LOGIN UTAMA -->
            <form action="{{ url('/login') }}" method="POST" class="space-y-4" novalidate autocomplete="off">
                @csrf

                <!-- 1. INPUT EMAIL -->
                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" id="email"
                        value="{{ old('email', session('auto_email')) }}"
                        class="w-full px-5 py-3.5 border {{ ($errors->has('email') || $errors->has('login_gagal')) ? 'border-red-500 bg-red-50/20' : 'border-gray-300 focus:border-[#0095e8] ' }} rounded-xl text-base outline-none transition"
                        placeholder="Masukkan email Anda" required autofocus>

                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 font-bold pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. INPUT PASSWORD -->
                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-5 py-3.5 border {{ ($errors->has('password') || $errors->has('login_gagal')) ? 'border-red-500 bg-red-50/20' : 'border-gray-300 focus:border-[#0095e8]' }} rounded-xl text-base outline-none transition"
                            placeholder="Masukkan kata sandi Anda" required>

                        <!-- Tombol Mata FontAwesome (Kloning 100% dari Step 3) -->
                        <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye" id="password-icon"></i>
                        </button>
                    </div>

                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 font-bold pl-1">{{ $message }}</p>
                    @enderror

                    @if($errors->has('login_gagal'))
                        <p class="text-red-500 text-xs mt-1.5 font-bold pl-1">{{ $errors->first('login_gagal') }}</p>
                    @endif
                </div>

                <div class="flex justify-end mt-1">
                    <a href="{{ route('password.request') }}" class="text-sm font-bold text-[#0095e8] hover:underline">
                        Lupa kata sandi?
                    </a>
                </div>

                <button type="submit" class="w-full bg-[#0095e8] hover:bg-[#0081c9] text-white font-extrabold py-4 rounded-xl transition shadow-md text-base mt-4 cursor-pointer">
                    Masuk
                </button>
            </form>

            <!-- SEPARATOR ATAU -->
            <div class="my-5 flex items-center text-center">
                <div class="border-t border-gray-200 flex-grow"></div>
                <span class="px-3 text-[14px] font-bold text-gray-500">atau</span>
                <div class="border-t border-gray-200 flex-grow"></div>
            </div>

            <!-- TOMBOL GOOGLE SSO -->
            <a href="{{ url('/auth/google') }}" class="w-full flex justify-center items-center bg-white border border-gray-300 text-gray-700 font-bold py-3.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-base cursor-pointer">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-3">
                Masuk dengan Google
            </a>

        </div>
    </div>
</main>

<!-- Script Mata Sandi (Kloning 100% dari Step 3) -->
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
