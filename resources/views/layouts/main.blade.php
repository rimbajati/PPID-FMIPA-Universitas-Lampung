<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPID FMIPA Unila')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0095e8',
                        unila: '#0f2b4a',
                        unilahover: '#0a1d33',
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        /* Proteksi form agar bersih dari auto-fill browser */
        input::-ms-reveal, input::-ms-clear { display: none; }
        input[type="password"]::-webkit-credentials-auto-fill-button { display: none !important; visibility: hidden; pointer-events: none; }
        input[type="password"]::-webkit-eye-off-button, input[type="password"]::-webkit-eye-button { display: none !important; visibility: hidden; }
    </style>

    @stack('styles')
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-800">

    @php
        // Daftar rute yang TIDAK menampilkan Navbar & Footer
        $pagesWithoutNav = [
            'login',
            'register',
            'register/step1', // Tambahkan jika ada path spesifik
            'forgot-password',
            'reset-password'
        ];

        // Cek apakah halaman saat ini ada di daftar hitam
        $showLayout = !request()->is($pagesWithoutNav) && !request()->is('register/*') && !request()->is('reset-password/*');
    @endphp

    {{-- NAVBAR --}}
    @if($showLayout)
        @include('partials.navbar')
    @endif

    {{-- MAIN CONTENT --}}
    <div class="flex-grow flex flex-col">
        @yield('content')
    </div>

    {{-- FOOTER --}}
    @if($showLayout)
        @include('partials.footer')
    @endif

    @stack('scripts')
</body>
</html>
