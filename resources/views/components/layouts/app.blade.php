<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/logoPPID.png') }}?v=2.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logoPPID.png') }}?v=2.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logoPPID.png') }}?v=2.0">
    <link rel="apple-touch-icon" href="{{ asset('images/logoPPID.png') }}?v=2.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Inter"', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    borderRadius: {
                        'DEFAULT': '0.625rem',
                        'sm': '0.375rem',
                        'md': '0.5rem',
                        'lg': '0.625rem',
                        'xl': '0.625rem',
                        '2xl': '0.625rem',
                        '3xl': '0.625rem',
                        'full': '9999px',
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        html { 
            scroll-behavior: smooth; 
            font-size: 14px; 
        }
        @media (min-width: 1700px) {
            html { font-size: 16px; }
        }
        @media (min-width: 1400px) and (max-width: 1699px) {
            html { font-size: 14.5px; }
        }
        @media (max-width: 1200px) {
            html { font-size: 13.5px; }
        }
        body { 
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important; 
            font-size: 1rem; 
        }
    </style>
</head>

<body class="antialiased text-gray-800 bg-slate-50 min-h-screen flex flex-col {{ request()->is('/') ? 'is-home' : '' }}">

    <x-ui.navbar />

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-ui.footer />
</body>
</html>
