@extends('layout.utama')

@section('title', 'Lupa Kata Sandi - PPID FMIPA Unila')

@section('content')
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
            <div class="mb-8">
                <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Lupa Kata Sandi</h2>
                <p class="text-gray-500 mt-2 text-sm">Masukan email Anda dan kami akan mengirimkan link untuk mereset kata sandi.</p>
            </div>

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4" novalidate autocomplete="off">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ session('status') ? '' : old('email') }}" required autofocus
                        class="w-full px-5 py-3.5 border-2 {{ $errors->has('email') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} rounded-3xl outline-none text-base transition"
                        placeholder="Masukan email akun Anda">
                    @error('email')
                        <p class="text-red-700 text-xs mt-2 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                @if (session('status'))
                    <div class="mt-4 p-4 text-sm text-emerald-900 bg-emerald-50 border-2 border-emerald-600 rounded-3xl font-bold text-center flex items-center justify-center gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xl shrink-0"></i>
                        <div class="text-left">
                            <p class="font-extrabold text-emerald-950">{{ session('status') }}</p>
                            <p class="text-xs text-emerald-700 font-medium mt-0.5">Periksa folder Inbox atau Spam. Belum menerima? Klik kirim ulang di bawah.</p>
                        </div>
                    </div>
                @endif

                <button type="submit" class="w-full bg-[#1B365D] hover:bg-[#1B365D] text-white font-black py-4 transition rounded-3xl text-base mt-4 uppercase tracking-widest cursor-pointer">
                    {{ session('status') ? 'Kirim Ulang Link Reset' : 'Kirim Link Reset' }}
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="text-gray-900 font-black text-sm hover:underline uppercase tracking-widest">
                    Kembali ke Login
                </a>
            </div>
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
@endsection

