<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - PPID FMIPA Unila</title>
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
    <div class="relative z-10 w-full max-w-lg mx-auto flex flex-col items-center py-6 space-y-6">

        <!-- Top Navigation Link (Kembali ke Register Step 1) -->
        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md text-xs font-extrabold text-white transition-all border border-white/20">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Kembali</span>
        </a>

        <!-- Floating Clean White Card -->
        <div class="w-full bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-6">

            <!-- Title & Subtitle Inside Card -->
            <div class="text-center space-y-1">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Verifikasi OTP</h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">
                    Kode verifikasi telah dikirim ke: <br>
                    <span class="font-extrabold text-slate-900">{{ $email }}</span>
                </p>
            </div>

            @if(session('success'))
                <div class="p-3.5 text-xs text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-2xl font-bold text-center flex items-center justify-center gap-2">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('register.step2.process', ['email' => $email]) }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-1">
                    <input type="text" name="otp" maxlength="4"
                        value=""
                        class="w-full text-center tracking-[0.6em] sm:tracking-[0.8em] font-black text-3xl sm:text-4xl py-3.5 border {{ $errors->has('otp') ? 'border-red-500 ring-2 ring-red-100' : 'border-slate-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-100' }} rounded-2xl bg-slate-50/50 focus:bg-white text-slate-800 outline-none transition"
                        placeholder="••••" required autofocus autocomplete="one-time-code">

                    @error('otp')
                        <p class="text-red-600 text-xs text-center font-bold pt-1 flex items-center justify-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-3.5 px-6 bg-sky-500 hover:bg-sky-600 text-white text-xs sm:text-sm font-extrabold rounded-full shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <span>Verifikasi</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="pt-2 text-center text-xs">
                <form action="{{ route('register.resend') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <span class="text-slate-400 font-medium">Belum menerima kode?</span>
                    <button type="submit" class="text-sky-600 font-bold hover:underline ml-1 cursor-pointer">
                        Kirim Ulang
                    </button>
                </form>
            </div>

        </div>

    </div>

</body>
</html>
