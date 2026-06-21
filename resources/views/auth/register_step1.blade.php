@extends('layouts.main')

@section('title', 'Daftar Akun - PPID FMIPA Unila')

@section('content')
<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-sky-50">

    <div class="bg-white rounded-3xl shadow-2xl flex flex-col md:flex-row overflow-hidden w-full max-w-5xl min-h-[600px]">

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

        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">
            <div class="mb-8 text-center">
                <h2 class="text-4xl font-extrabold text-gray-900">Daftar Sekarang</h2>
                <p class="text-gray-500 mt-2 text-lg">Sudah punya akun? <a href="/login" class="text-[#0095e8] font-bold hover:underline">Masuk</a></p>
            </div>

            <a href="/auth/google" class="w-full flex justify-center items-center bg-white border border-gray-300 text-gray-700 font-bold py-3.5 px-4 rounded-xl hover:bg-gray-50 transition shadow-sm text-base mb-6">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-3">
                Google
            </a>

            <div class="my-3 flex items-center text-center">
                <div class="border-t border-gray-200 flex-grow"></div>
                <span class="px-3 text-[14px] font-bold text-gray-500">atau</span>
                <div class="border-t border-gray-200 flex-grow"></div>
            </div>

            @if ($errors->any() && !$errors->has('email'))
                <div class="mb-5 p-4 bg-red-50 text-red-600 rounded-xl text-sm font-semibold text-center">{{ $errors->first() }}</div>
            @endif

            <form action="/register/step1" method="POST" class="space-y-4" novalidate>
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-5 py-3.5 border @error('email') border-red-500 bg-red-50/20 @else border-gray-300 focus:border-[#0095e8] @enderror rounded-xl text-base outline-none transition"
                        placeholder="contoh: nama@email.com" required autofocus>
                    @error('email') <p class="text-red-500 text-xs mt-1.5 font-bold pl-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full bg-[#0095e8] hover:bg-[#0081c9] text-white font-extrabold py-3.5 rounded-xl transition shadow-md text-base mt-2">
                    Selanjutnya
                </button>
            </form>
        </div>
    </div>
</main>

@if($errors->has('email') && str_contains($errors->first('email'), 'sudah terdaftar'))
    <div id="emailConflictModal" class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 backdrop-blur-xs">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full shadow-2xl text-center">
            <h3 class="text-xl font-extrabold text-gray-900 mb-2">Email sudah terdaftar</h3>
            <p class="text-sm text-gray-600 mb-8">Masuk dengan email <span class="font-bold text-gray-800 break-all">{{ old('email') }}</span>?</p>

            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('emailConflictModal').style.display='none'"
                        class="flex-1 py-3.5 text-sm font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition cursor-pointer">
                    Ubah
                </button>

                <form action="{{ route('login.with.email') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="email" value="{{ old('email') }}">
                    <button type="submit"
                            class="w-full py-3.5 text-sm font-bold bg-[#0095e8] text-white rounded-xl shadow-md hover:bg-[#0081c9] transition cursor-pointer">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
