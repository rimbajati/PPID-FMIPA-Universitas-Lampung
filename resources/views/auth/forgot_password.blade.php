@extends('layouts.main')

@section('title', 'Lupa Kata Sandi - PPID FMIPA Unila')

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
                <h2 class="text-3xl font-extrabold text-gray-900">Lupa Kata Sandi</h2>
                <p class="text-gray-500 mt-2 text-sm">Masukkan email Anda dan kami akan mengirimkan link untuk mereset kata sandi.</p>
            </div>

            @if (session('status'))
                <div class="mb-5 p-4 bg-green-50 text-green-700 rounded-xl text-sm font-bold text-center border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4" novalidate>
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-5 py-3.5 border {{ $errors->has('email') ? 'border-red-500 bg-red-50/20' : 'border-gray-300 focus:border-[#0095e8]' }} rounded-xl text-base outline-none transition"
                        placeholder="Masukkan email akun Anda">

                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 font-bold pl-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[#0095e8] hover:bg-[#0081c9] text-white font-extrabold py-4 rounded-xl transition shadow-md text-base mt-4 cursor-pointer">
                    Kirim Link Reset
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-[#0095e8] font-bold text-sm hover:underline">Kembali ke Login</a>
            </div>
        </div>
    </div>
</main>
@endsection
