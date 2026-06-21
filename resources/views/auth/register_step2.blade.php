@extends('layouts.main')

@section('title', 'Verifikasi Kode OTP - PPID FMIPA Unila')

@section('content')
<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-sky-50">

    <!-- CARD UTAMA: 50% Gambar, 50% Form -->
    <div class="bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-5xl min-h-[600px]">

        <!-- SISI KIRI: GAMBAR (50% Lebar) -->
        <div class="w-full md:w-1/2 h-72 md:h-auto relative overflow-hidden">
            <img src="{{ asset('images/FMIPA.jpg') }}"
                alt="Gedung FMIPA Unila"
                class="w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

            <div class="absolute bottom-0 left-0 w-full p-10 md:p-12 text-left">
                <h2 class="text-white text-3xl md:text-4xl font-black leading-tight drop-shadow-md">
                    Pejabat Pengelola <br> Informasi & Dokumentasi (PPID)
                </h2>
                <div class="w-16 h-1.5 bg-[#0095e8] mt-4 mb-4 rounded-full"></div>
                <p class="text-blue-100 text-lg font-medium drop-shadow-md">
                    FMIPA Universitas Lampung
                </p>
            </div>
        </div>

        <!-- SISI KANAN: FORM VERIFIKASI (50% Lebar) -->
        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">

            <a href="{{ route('register') }}" class="text-gray-400 hover:text-gray-600 transition mb-6 block font-medium">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>

            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-blue-50 text-[#0095e8] rounded-full flex items-center justify-center mx-auto mb-5 text-3xl">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <!-- TULISAN SESUAI DESAIN -->
                <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Masukkan Kode Verifikasi</h2>
                <p class="text-gray-500 leading-relaxed text-sm">
                    Kode verifikasi telah dikirim melalui e-mail ke <br>
                    <span class="font-bold text-gray-800">{{ $email }}</span>
                </p>
            </div>

            @if(session('success'))
                <div class="mb-5 p-4 bg-green-50 text-green-700 rounded-xl text-sm font-bold text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="" method="POST" class="space-y-6">
                @csrf
                <div>
                    <!-- INPUT OTP DENGAN TRACKING AGAR LEBIH LUAS -->
                    <input type="text" name="otp" maxlength="4"
                        class="w-full text-center tracking-[1em] font-black text-4xl py-4 border @error('otp') border-red-500 bg-red-50/20 @else border-gray-300 focus:border-[#0095e8] @enderror rounded-2xl outline-none transition shadow-inner"
                        placeholder="••••" required autofocus autocomplete="one-time-code">
                    @error('otp')
                        <p class="text-red-500 text-xs mt-2 text-center font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[#0095e8] hover:bg-[#0081c9] text-white font-extrabold py-4 rounded-2xl transition shadow-md text-base mt-2 cursor-pointer">
                    Verifikasi
                </button>
            </form>

            <div class="mt-8 text-center text-sm">
                <form action="{{ route('register.resend') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <span class="text-gray-500">Belum menerima kode?</span>
                    <button type="submit" class="text-blue-600 font-semibold hover:underline">
                        Kirim Ulang
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
