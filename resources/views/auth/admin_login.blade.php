<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PPID FMIPA Unila</title>
    <link rel="shortcut icon" href="{{ asset('images/logoPPID.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logoPPID.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logoPPID.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoPPID.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
    </style>
</head>
<body class="relative flex items-center justify-center min-h-screen bg-[#1B365D]">

    <!-- Background Layer -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#1B365D]/85 via-[#1B365D]/45 to-transparent"></div>

    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-lg px-6">

        <!-- White Card -->
        <div class="bg-white p-10 sm:p-12 shadow-2xl border border-gray-100" style="border-radius: 6px !important;">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <img src="{{ asset('images/logoPPID.png') }}" alt="Logo PPID FMIPA" class="h-16 w-auto mx-auto mb-4 object-contain">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-1.5">Login Admin</h1>
                <p class="text-base text-gray-500">PPID FMIPA Universitas Lampung</p>
            </div>

            <form action="/admin-panel/login" method="POST" class="space-y-4" novalidate autocomplete="off">
                @csrf

                <!-- Input Email -->
                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Email Admin</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-5 py-3.5 border-2 {{ $errors->has('email') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} outline-none text-base transition" style="border-radius: 6px !important;"
                        placeholder="Masukan email admin Anda" required autofocus>
                    @error('email')
                        <p class="text-red-700 text-xs mt-2 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-5 py-3.5 border-2 {{ $errors->has('password') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} outline-none text-base transition" style="border-radius: 6px !important;"
                            placeholder="Masukan kata sandi Anda" required>
                        @error('password')
                            <p class="text-red-700 text-xs mt-2 font-bold flex items-center gap-1.5">
                                <i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}
                            </p>
                        @enderror
                        <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-3.5 text-gray-500 hover:text-gray-800 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>

                @if ($errors->has('login_gagal'))
                    <div class="mt-4 p-4 text-sm text-red-800 bg-red-50 border-2 border-red-700 font-bold text-center" style="border-radius: 6px !important;">
                        {{ $errors->first('login_gagal') }}
                    </div>
                @endif

                <!-- Button Submit -->
                <button type="submit" class="w-full bg-[#1B365D] hover:bg-[#162c4c] text-white font-black py-4 transition text-base mt-4 cursor-pointer uppercase tracking-widest shadow-md" style="border-radius: 6px !important;">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-gray-600 hover:text-[#1B365D] transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Beranda
                </a>
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
            </script>

        </div>
    </div>

</body>
</html>
