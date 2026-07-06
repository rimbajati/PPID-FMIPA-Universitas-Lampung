@extends('layouts.main')

@section('title', 'Reset Kata Sandi - PPID FMIPA Unila')

@section('content')
<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-slate-50">

    <div class="bg-white shadow-xl flex flex-col md:flex-row overflow-hidden w-full max-w-5xl min-h-[600px]">

        <div class="w-full md:w-1/2 h-72 md:h-auto relative overflow-hidden">
            <img src="{{ asset('images/FMIPA.jpg') }}" alt="Gedung FMIPA Unila" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#0a192f]/80"></div>
            <div class="absolute bottom-0 left-0 w-full p-10 md:p-12 text-left">
                <h2 class="text-white text-3xl md:text-4xl font-black leading-tight">
                    Pejabat Pengelola <br> Informasi & Dokumentasi (PPID)
                </h2>
                <div class="w-16 h-1.5 bg-[#0095e8] mt-4 mb-4"></div>
                <p class="text-blue-100 text-lg font-medium">FMIPA Universitas Lampung</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">
            <div class="mb-8">
                <h2 class="text-3xl font-black text-[#0a192f] uppercase tracking-tight">Reset Kata Sandi</h2>
                <p class="text-gray-500 mt-2 text-sm">Masukkan kata sandi baru untuk akun Anda.</p>
            </div>

            <!-- @if ($errors->any())
                <div class="mb-6 p-4 text-sm text-red-800 bg-red-50 border-2 border-red-700 font-black text-center">
                    {{ $errors->first() }}
                </div>
            @endif -->

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5" novalidate autocomplete="off">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-1.5">Email Akun</label>
                    <input type="email" value="{{ request()->email }}" disabled
                        class="w-full px-5 py-3.5 border-2 border-gray-300 bg-gray-100 text-gray-500 text-base cursor-not-allowed font-black">
                    <input type="hidden" name="email" value="{{ request()->email }}">
                </div>

                <div>
                    <label class="block text-xs font-black text-[#0a192f] uppercase tracking-wider mb-1.5">Kata Sandi Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" value=""
                            class="w-full px-5 py-3.5 border-2 {{ $errors->has('password') ? 'border-red-700' : 'border-[#0a192f] focus:border-[#0095e8]' }} outline-none text-base transition"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-3.5 text-[#0a192f] hover:text-gray-600 focus:outline-none">
                            <i class="fa-solid fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-red-700 text-xs mt-1 font-black">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-[#0a192f] uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" value=""
                            class="w-full px-5 py-3.5 border-2 border-[#0a192f] focus:border-[#0095e8] outline-none text-base transition"
                            placeholder="Ulangi kata sandi baru" required>
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-3.5 text-[#0a192f] hover:text-gray-600 focus:outline-none">
                            <i class="fa-solid fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#0a192f] hover:bg-[#1a2e4d] text-white font-black py-4 transition text-base mt-4 uppercase tracking-widest">
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
