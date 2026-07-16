@extends('layout.utama')

@section('title', 'Lupa Kata Sandi - PPID FMIPA Unila')

@section('content')
<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-slate-50">

    <div class="bg-white shadow-xl flex flex-col md:flex-row overflow-hidden rounded-3xl w-full max-w-5xl min-h-[600px]">

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
                <h2 class="text-3xl font-black text-[#0a192f] uppercase tracking-tight">Lupa Kata Sandi</h2>
                <p class="text-gray-500 mt-2 text-sm">Masukan email Anda dan kami akan mengirimkan link untuk mereset kata sandi.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 text-sm text-green-800 bg-green-50 border-2 border-green-700 rounded-3xl font-black text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4" novalidate autocomplete="off">
                @csrf
                <div>
                    <label class="block text-xs font-black text-[#0a192f] uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-5 py-3.5 border-2 {{ $errors->has('email') ? 'border-red-700' : 'border-[#0a192f] focus:border-[#0095e8]' }} rounded-3xl outline-none text-base transition"
                        placeholder="Masukan email akun Anda">
                    @error('email')
                        <p class="text-red-700 text-xs mt-1.5 font-black">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[#0a192f] hover:bg-[#1a2e4d] text-white font-black py-4 transition rounded-3xl text-base mt-4 uppercase tracking-widest">
                    Kirim Link Reset
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="text-[#0a192f] font-black text-sm hover:underline uppercase tracking-widest">
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</main>
@endsection

