@extends('layouts.main')

@section('title', 'Verifikasi Kode OTP - PPID FMIPA Unila')

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

            <a href="{{ route('register') }}" class="text-gray-400 hover:text-[#0a192f] transition mb-6 block font-black uppercase text-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>

            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-[#0a192f] text-white flex items-center justify-center mx-auto mb-5 text-3xl">
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <h2 class="text-3xl font-black text-[#0a192f] mb-3 uppercase tracking-tight">Verifikasi OTP</h2>
                <p class="text-gray-500 leading-relaxed text-sm">
                    Kode verifikasi telah dikirim ke: <br>
                    <span class="font-black text-[#0a192f]">{{ $email }}</span>
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 text-sm text-green-800 bg-green-50 border-2 border-green-700 font-bold text-center">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 text-sm text-red-800 bg-red-50 border-2 border-red-700 font-bold text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-4 bg-green-50 text-green-800 border-2 border-green-700 font-black text-sm text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('register.step2.process', ['email' => $email]) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <input type="text" name="otp" maxlength="4"
                        value=""
                        class="w-full text-center tracking-[1em] font-black text-4xl py-4 border-2 {{ $errors->has('otp') ? 'border-[#0a192f]' : 'border-[#0a192f] focus:border-[#0095e8]' }} outline-none transition"
                        placeholder="••••" required autofocus autocomplete="one-time-code">

                    <!-- @error('otp')
                        <p class="text-red-700 text-xs mt-2 text-center font-black">{{ $message }}</p>
                    @enderror -->
                </div>

                <button type="submit" class="w-full bg-[#0a192f] hover:bg-[#1a2e4d] text-white font-black py-4 transition text-base mt-2 uppercase tracking-widest">
                    Verifikasi
                </button>
            </form>

            <div class="mt-8 text-center text-sm">
                <form action="{{ route('register.resend') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <span class="text-gray-500">Belum menerima kode?</span>
                    <button type="submit" class="text-[#0a192f] font-black hover:underline uppercase ml-1">
                        Kirim Ulang
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
