@extends('layout.utama')

@section('title', 'Daftar Akun - PPID FMIPA Unila')

@section('content')
<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-slate-50">

    <div class="bg-white shadow-xl flex flex-col md:flex-row rounded-3xl overflow-hidden w-full max-w-5xl min-h-[600px]">

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
                <h2 class="text-4xl font-black text-gray-900">DAFTAR</h2>
                <p class="text-gray-500 mt-2 text-lg">Sudah punya akun? <a href="/login" class="text-gray-900 font-black hover:underline">Masuk</a></p>
            </div>

            <a href="/auth/google" class="w-full flex justify-center items-center bg-white border-2 border-gray-300 text-gray-900 font-black py-3.5 px-4 hover:bg-slate-50 transition rounded-3xl shadow-sm text-base mb-6 uppercase tracking-widest">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-3">
                Google
            </a>

            <div class="my-3 flex items-center text-center">
                <div class="border-t-2 border-gray-300 flex-grow"></div>
                <span class="px-3 text-sm font-black text-gray-500 uppercase">atau</span>
                <div class="border-t-2 border-gray-300 flex-grow"></div>
            </div>

            <form action="/register/step1" method="POST" class="space-y-4" novalidate>
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-5 py-3.5 border-2 {{ $errors->has('email') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} outline-none rounded-3xl text-base transition"
                        placeholder="contoh: nama@email.com" required autofocus>
                    @error('email')
                        <p class="text-red-700 text-xs mt-2 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-[#1B365D] hover:bg-[#1B365D] text-white font-black py-4 transition rounded-3xl shadow-md text-base mt-2 uppercase tracking-widest">
                    Selanjutnya
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-700', 'border-red-500');
                this.classList.add('border-[#1B365D]');
                const container = this.closest('div');
                if (container) {
                    const errorMsg = container.querySelector('.text-red-700, .text-red-600, .text-red-500');
                    if (errorMsg) {
                        errorMsg.style.display = 'none';
                    }
                }
            });
        });
    });
</script>

@if($errors->has('email') && str_contains($errors->first('email'), 'terdaftar'))
    <div id="emailConflictModal" class="fixed inset-0 bg-[#1B365D]/60 z-50 flex items-center justify-center p-4">
        <div class="bg-white p-8 max-w-sm w-full rounded-3xl shadow-2xl text-center">
            <div class="mb-4 text-orange-500 text-4xl">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <h3 class="text-xl font-black text-gray-900 mb-2">Email Sudah Terdaftar</h3>
            <p class="text-sm text-gray-600 mb-8">
                Email <strong>{{ old('email') }}</strong> sudah terdaftar. Apakah Anda ingin masuk ke akun tersebut?
            </p>

            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('emailConflictModal').classList.add('hidden')"
                        class="flex-1 py-3.5 text-sm font-black text-gray-600 border-2 border-gray-300 rounded-3xl hover:bg-gray-50 transition">
                    Ubah
                </button>

                <form action="{{ route('login.with.email') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="email" value="{{ old('email') }}">
                    <button type="submit" class="w-full py-3.5 text-sm font-black bg-[#1B365D] text-white rounded-3xl hover:bg-[#1B365D] transition">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif

@endsection

