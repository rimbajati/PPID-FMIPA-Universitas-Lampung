<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - PPID FMIPA Unila</title>
    <link rel="shortcut icon" href="{{ asset('images/logoPPID.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logoPPID.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="relative min-h-screen bg-[#1B365D] flex flex-col items-center justify-center p-4 sm:p-6 select-none overflow-x-hidden">

    <!-- Background Layer Gedung Dekanat FMIPA -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#1B365D]/90 via-[#1B365D]/50 to-transparent"></div>

    <!-- Container Utama -->
    <div class="relative z-10 w-full max-w-xl mx-auto flex flex-col items-center py-6 space-y-6">

        <!-- Top Navigation Link (Beranda) -->
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md text-sm font-extrabold text-white transition-all border border-white/20">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Beranda</span>
        </a>

        <!-- Floating Clean White Card -->
        <div class="w-full bg-white border border-slate-200/90 rounded-3xl p-8 sm:p-12 shadow-2xl space-y-7">

            <!-- Title & Subtitle Inside Card -->
            <div class="text-center space-y-2.5">
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">Lupa Kata Sandi</h1>
                <p class="text-sm sm:text-base text-slate-600 font-semibold pt-1">
                    Masukkan email Anda untuk menerima tautan reset kata sandi.
                </p>
            </div>

            @if (session('status'))
                <div class="p-4 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-2xl font-bold flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5 shrink-0"></i>
                    <div class="space-y-0.5">
                        <p class="font-extrabold text-base">{{ session('status') }}</p>
                        <p class="text-xs sm:text-sm text-emerald-700 font-medium">Periksa inbox atau folder spam email Anda.</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5" novalidate autocomplete="off">
                @csrf

                <!-- Input Email -->
                <div class="space-y-2 text-left">
                    <label class="block text-sm font-black text-slate-800 tracking-wide uppercase">Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="email" name="email" id="email" value="{{ session('status') ? '' : old('email') }}"
                            class="w-full pl-12 pr-4 py-3.5 border {{ $errors->has('email') ? 'border-red-500 ring-2 ring-red-100' : 'border-slate-300 focus:border-sky-500 focus:ring-4 focus:ring-sky-100' }} rounded-2xl bg-slate-50/50 focus:bg-white text-base font-semibold text-slate-800 outline-none transition"
                            placeholder="Masukan email akun Anda" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-red-600 text-xs sm:text-sm font-bold flex items-center gap-1.5 pt-1">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-4 px-6 bg-sky-500 hover:bg-sky-600 text-white text-base font-black rounded-full shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <span>{{ session('status') ? 'Kirim Ulang Link Reset' : 'Kirim Link Reset' }}</span>
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                    </button>
                </div>
            </form>

            <div class="pt-2 text-center">
                <a href="{{ route('login') }}" class="text-sm font-extrabold text-sky-600 hover:underline">
                    Kembali ke Login
                </a>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500', 'ring-2', 'ring-red-100');
                    this.classList.add('border-slate-200');
                    const container = this.closest('div');
                    if (container) {
                        const errorMsg = container.querySelector('.text-red-600, .text-red-500');
                        if (errorMsg) {
                            errorMsg.style.display = 'none';
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
