@extends('layout.utama')

@section('title', 'Masuk - PPID FMIPA Unila')

@section('content')
<style>
    input::-ms-reveal, input::-ms-clear { display: none; }
    input[type="password"]::-webkit-credentials-auto-fill-button { display: none !important; }
    input[type="password"]::-webkit-eye-off-button, input[type="password"]::-webkit-eye-button { display: none !important; }
</style>

<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-slate-50">

    <div class="bg-white shadow-xl flex flex-col md:flex-row overflow-hidden rounded-3xl w-full max-w-5xl min-h-[600px]">

        <div class="w-full md:w-1/2 h-72 md:h-auto relative overflow-hidden">
            <img src="{{ asset('images/FMIPA.jpg') }}" alt="Gedung FMIPA Unila" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#1B365D]/85 via-[#1B365D]/45 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-full p-10 md:p-12 text-left">
                <h2 class="text-white text-3xl md:text-4xl font-black leading-tight">
                    Pejabat Pengelola <br> Informasi & Dokumentasi (PPID)
                </h2>
                <div class="w-16 h-1.5 bg-white mt-4 mb-4"></div>
                <p class="text-cyan-100 text-lg font-medium">FMIPA Universitas Lampung</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">

            <div class="mb-8 text-center">
                <h2 class="text-4xl font-black text-gray-900">MASUK</h2>
                <p class="text-gray-500 mt-2 text-lg">Belum punya akun? <a href="{{ route('register') }}" class="text-gray-900 font-black hover:underline">Daftar</a></p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 text-sm text-green-800 bg-green-50 border-2 border-green-700 rounded-3xl font-bold text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->has('login_gagal'))
                <div class="mb-6 p-4 text-sm text-red-800 bg-red-50 border-2 border-red-700 rounded-3xl font-bold text-center">
                    {{ $errors->first('login_gagal') }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-4" novalidate autocomplete="off">
                @csrf

                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', session('auto_email')) }}"
                        class="w-full px-5 py-3.5 border-2 {{ $errors->has('email') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} outline-none rounded-3xl text-base transition"
                        placeholder="Masukan email Anda" required autofocus>
                        @error('email') <p class="text-red-700 text-xs mt-1 font-black">{{ $errors->first() }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-5 py-3.5 border-2 {{ $errors->has('password') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} outline-none rounded-3xl text-base transition"
                            placeholder="Masukan kata sandi Anda" required>
                            @error('password') <p class="text-red-700 text-xs mt-1 font-black">{{ $message }}</p> @enderror
                        <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-3.5 text-gray-500 hover:text-gray-800 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end mt-1">
                    <a href="{{ route('password.request') }}" class="text-sm font-black text-gray-900 hover:underline">
                        Lupa kata sandi?
                    </a>
                </div>

                <button type="submit" class="w-full bg-[#1B365D] hover:bg-[#1B365D] text-white font-black py-4 transition text-base mt-4 cursor-pointer uppercase tracking-widest rounded-3xl">
                    Masuk
                </button>
            </form>

            <div class="my-5 flex items-center text-center">
                <div class="border-t-2 border-gray-300 flex-grow"></div>
                <span class="px-3 text-sm font-black text-gray-500 uppercase">atau</span>
                <div class="border-t-2 border-gray-300 flex-grow"></div>
            </div>

            <a href="{{ url('/auth/google') }}" class="w-full flex justify-center items-center bg-white border-2 border-gray-300 text-gray-900 font-black py-3.5 px-4 hover:bg-slate-50 transition rounded-3xl text-base cursor-pointer uppercase tracking-widest">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-3">
                Masuk dengan Google
            </a>

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

