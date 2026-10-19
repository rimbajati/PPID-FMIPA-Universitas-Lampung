<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PPID Pelaksana FMIPA Universitas Lampung</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logoPPID.png') }}?v=3.0">
    <link rel="apple-touch-icon" href="{{ asset('images/logoPPID.png') }}?v=3.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#0f2a44',
                            light: '#1a3a5c',
                            dark: '#0a1d30',
                        },
                        secondary: {
                            DEFAULT: '#0ea5e9',
                            light: '#38bdf8',
                            dark: '#0284c7',
                        },
                        accent: {
                            DEFAULT: '#0284c7',
                            light: '#38bdf8',
                            dark: '#0369a1',
                        },
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', '-apple-system', 'sans-serif'],
                        poppins: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        };
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <style>
        html { 
            font-size: 15px; 
        }
        @media (min-width: 1600px) {
            html { font-size: 16px; }
        }
        @media (max-width: 1280px) {
            html { font-size: 14px; }
        }
        body { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important; }
    </style>
</head>
<body class="relative flex items-center justify-center min-h-screen bg-[#1B365D] p-4 sm:p-6 overflow-y-auto">

    <!-- Background Layer -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#1B365D]/85 via-[#1B365D]/45 to-transparent"></div>

    <!-- Login Container -->
    <div class="relative z-10 w-full max-w-md mx-auto my-auto">

        <!-- White Card -->
        <div class="bg-white p-7 sm:p-10 shadow-2xl border border-gray-100 rounded-2xl">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-block mb-3">
                    <img src="{{ asset('images/logoPPID.png') }}?v=3.0" alt="Logo PPID" class="h-16 w-auto mx-auto object-contain drop-shadow">
                </a>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0f2a44] mb-1.5 tracking-tight">LOGIN ADMIN</h1>
                <p class="text-sm font-medium text-gray-500">PPID Pelaksana FMIPA Universitas Lampung</p>
            </div>

            <form action="{{ url('/login') }}" method="POST" class="space-y-4" novalidate autocomplete="off">
                @csrf

                <!-- Input Email -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Email Admin</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="mdi mdi-email-outline text-lg"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full pl-11 pr-4 py-3 border-2 {{ $errors->has('email') ? 'border-red-500 bg-red-50/30' : 'border-gray-200 focus:border-[#0f2a44]' }} outline-none text-sm transition rounded-xl focus:ring-2 focus:ring-[#0f2a44]/10"
                            placeholder="Masukan email admin" required autofocus>
                    </div>
                    @error('email')
                        <p class="text-red-600 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <i class="mdi mdi-alert-circle text-sm"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="mdi mdi-lock-outline text-lg"></i>
                        </span>
                        <input type="password" name="password" id="password"
                            class="w-full pl-11 pr-11 py-3 border-2 {{ $errors->has('password') ? 'border-red-500 bg-red-50/30' : 'border-gray-200 focus:border-[#0f2a44]' }} outline-none text-sm transition rounded-xl focus:ring-2 focus:ring-[#0f2a44]/10"
                            placeholder="Masukan kata sandi admin" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-700 focus:outline-none cursor-pointer">
                            <i class="mdi mdi-eye text-lg leading-none" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs mt-1.5 font-medium flex items-center gap-1">
                            <i class="mdi mdi-alert-circle text-sm"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                @if ($errors->has('login_gagal'))
                    <div class="mt-4 p-3.5 text-xs sm:text-sm text-red-700 bg-red-50 border border-red-200 font-medium rounded-xl flex items-center gap-2">
                        <i class="mdi mdi-alert-circle-outline text-lg shrink-0"></i>
                        <span>{{ $errors->first('login_gagal') }}</span>
                    </div>
                @endif

                <!-- Button Submit -->
                <button type="submit" class="w-full bg-[#0f2a44] hover:bg-[#1a3a5c] text-white font-bold py-3.5 px-4 transition text-sm mt-3 cursor-pointer uppercase tracking-wider rounded-xl shadow-lg shadow-[#0f2a44]/20 flex items-center justify-center gap-2 active:scale-[0.99]">
                    <i class="mdi mdi-login text-base"></i>
                    <span>Masuk ke dashboard</span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-gray-500 hover:text-[#0f2a44] transition">
                    <i class="mdi mdi-arrow-left text-base"></i> kembali ke portal publik
                </a>
            </div>

            <script>
                function togglePassword(id) {
                    const input = document.getElementById(id);
                    const icon = document.getElementById(id + '-icon');
                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.remove('mdi-eye');
                        icon.classList.add('mdi-eye-off');
                    } else {
                        input.type = "password";
                        icon.classList.remove('mdi-eye-off');
                        icon.classList.add('mdi-eye');
                    }
                }
            </script>

        </div>
    </div>

</body>
</html>
