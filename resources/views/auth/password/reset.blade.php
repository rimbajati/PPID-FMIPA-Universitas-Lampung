<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - PPID FMIPA Unila</title>
    <link rel="shortcut icon" href="{{ asset('images/logoPPID.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logoPPID.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        input::-ms-reveal, input::-ms-clear { display: none; }
        input[type="password"]::-webkit-credentials-auto-fill-button { display: none !important; }
        input[type="password"]::-webkit-eye-off-button, input[type="password"]::-webkit-eye-button { display: none !important; }
    </style>
</head>
<body class="relative min-h-screen bg-[#1B365D] flex flex-col items-center justify-center p-4 sm:p-6 select-none overflow-x-hidden">

    <!-- Background Layer Gedung Dekanat FMIPA -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#1B365D]/90 via-[#1B365D]/50 to-transparent"></div>

    <!-- Container Utama -->
    <div class="relative z-10 w-full max-w-lg mx-auto flex flex-col items-center py-6 space-y-6">

        <!-- Top Navigation Link (Beranda) -->
        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md text-xs font-extrabold text-white transition-all border border-white/20">
            <i class="fa-solid fa-arrow-left text-[10px]"></i>
            <span>Beranda</span>
        </a>

        <!-- Floating Clean White Card -->
        <div class="w-full bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-6">

            <!-- Title & Subtitle Inside Card -->
            <div class="text-center space-y-1">
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Reset Kata Sandi</h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">Masukkan kata sandi baru untuk akun Anda.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4" novalidate autocomplete="off">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email (Disabled) -->
                <div class="space-y-1.5 text-left">
                    <label class="block text-xs font-black text-slate-400 tracking-wide uppercase">Email Akun</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="email" value="{{ request()->email }}" disabled
                            class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl bg-slate-100/70 text-slate-500 text-sm font-semibold cursor-not-allowed">
                        <input type="hidden" name="email" value="{{ request()->email }}">
                    </div>
                </div>

                <!-- Input Kata Sandi Baru -->
                <div class="space-y-1.5 text-left">
                    <label class="block text-xs font-black text-slate-700 tracking-wide uppercase">Kata Sandi Baru</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" name="password" id="password" value=""
                            class="w-full pl-11 pr-11 py-3 border {{ $errors->has('password') ? 'border-red-500 ring-2 ring-red-100' : 'border-slate-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-100' }} rounded-2xl bg-slate-50/50 focus:bg-white text-sm font-semibold text-slate-800 outline-none transition"
                            placeholder="Minimal 8 karakter" required autofocus>
                        <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye text-sm" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs font-bold flex items-center gap-1.5 pt-1">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Input Konfirmasi Kata Sandi -->
                <div class="space-y-1.5 text-left">
                    <label class="block text-xs font-black text-slate-700 tracking-wide uppercase">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" value=""
                            class="w-full pl-11 pr-11 py-3 border border-slate-200 focus:border-sky-500 focus:ring-4 focus:ring-sky-100 rounded-2xl bg-slate-50/50 focus:bg-white text-sm font-semibold text-slate-800 outline-none transition"
                            placeholder="Ulangi kata sandi baru" required>
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye text-sm" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                @if ($errors->has('email') && !$errors->has('password'))
                    <div class="p-3.5 text-xs text-red-700 bg-red-50 border border-red-200 rounded-2xl font-bold text-center flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-sm"></i>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 px-6 bg-sky-500 hover:bg-sky-600 text-white text-xs sm:text-sm font-extrabold rounded-full shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <span>Perbarui Kata Sandi</span>
                        <i class="fa-solid fa-check text-xs"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500', 'ring-2', 'ring-red-100');
                    this.classList.add('border-slate-200');
                    let parent = this.parentElement;
                    while (parent && !parent.classList.contains('space-y-4') && parent.tagName !== 'FORM') {
                        const errorMsg = parent.querySelector('.text-red-600, .text-red-500');
                        if (errorMsg) {
                            errorMsg.style.display = 'none';
                        }
                        parent = parent.parentElement;
                    }
                    const alertBox = document.querySelector('.bg-red-50');
                    if (alertBox) {
                        alertBox.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>
