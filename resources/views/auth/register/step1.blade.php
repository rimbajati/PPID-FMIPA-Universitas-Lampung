<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - PPID FMIPA Unila</title>
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
            <div class="text-center space-y-3">
                <h1 class="text-2xl sm:text-3xl lg:text-[32px] font-black text-slate-900 tracking-tight leading-snug">
                    Daftar Akun PPID <br>
                    <span class="whitespace-nowrap">FMIPA Universitas Lampung</span>
                </h1>
                <p class="text-sm sm:text-base text-slate-600 font-semibold">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-sky-600 font-extrabold hover:underline">Masuk sekarang</a>
                </p>
            </div>

            <!-- Google Register Button -->
            <a href="{{ url('/auth/google') }}" class="w-full py-3.5 px-4 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 text-sm sm:text-base font-extrabold rounded-full transition-all flex items-center justify-center gap-3 shadow-2xs cursor-pointer">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                <span>Daftar dengan Google</span>
            </a>

            <!-- Divider -->
            <div class="relative flex items-center justify-center my-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <span class="relative px-4 bg-white text-xs font-black text-slate-400 uppercase tracking-wider">atau</span>
            </div>

            <form action="{{ url('/register/step1') }}" method="POST" class="space-y-5" novalidate autocomplete="off">
                @csrf

                <!-- Input Email -->
                <div class="space-y-2 text-left">
                    <label class="block text-sm font-black text-slate-800 tracking-wide uppercase">Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full pl-12 pr-4 py-3.5 border {{ $errors->has('email') ? 'border-red-500 ring-2 ring-red-100' : 'border-slate-300 focus:border-sky-500 focus:ring-4 focus:ring-sky-100' }} rounded-2xl bg-slate-50/50 focus:bg-white text-base font-semibold text-slate-800 outline-none transition"
                            placeholder="contoh: nama@email.com" required autofocus>
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
                        <span>Selanjutnya</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </form>

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

    @if($errors->has('email') && str_contains($errors->first('email'), 'terdaftar'))
        <div id="emailConflictModal" class="fixed inset-0 bg-[#1B365D]/80 backdrop-blur-xs z-50 flex items-center justify-center p-4">
            <div class="bg-white p-8 max-w-sm w-full rounded-3xl shadow-2xl text-center space-y-4">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto text-xl">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">Email Sudah Terdaftar</h3>
                <p class="text-xs text-slate-500">
                    Email <strong>{{ old('email') }}</strong> sudah terdaftar. Apakah Anda ingin masuk ke akun tersebut?
                </p>

                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('emailConflictModal').remove()" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 font-bold text-xs text-slate-700 rounded-full transition">Batal</button>

                    <form action="{{ route('login.with.email') }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="email" value="{{ old('email') }}">
                        <button type="submit" class="w-full py-3 bg-sky-500 hover:bg-sky-600 text-white font-extrabold text-xs rounded-full transition">
                            Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

</body>
</html>
