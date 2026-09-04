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

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Inter"', 'system-ui', '-apple-system', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; font-size: 17px; }
        body { font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important; font-size: 1rem; }

        /* Siakad Table Style (Global Table Design) */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
            border-spacing: 0 !important;
            border: 1px solid #cbd5e1 !important;
            background-color: #ffffff !important;
            border-radius: 0px !important;
        }
        table thead tr {
            background-color: #2c3e50 !important;
            color: #ffffff !important;
        }
        table thead th {
            background-color: #2c3e50 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            padding: 12px 14px !important;
            font-size: 0.9rem !important;
            border: 1px solid #cbd5e1 !important;
        }
        table tbody tr:nth-child(odd) {
            background-color: #f8fafc !important;
        }
        table tbody tr:nth-child(even) {
            background-color: #ffffff !important;
        }
        table tbody tr:hover {
            background-color: #e2e8f0 !important;
        }
        table tbody td {
            padding: 10px 14px !important;
            border: 1px solid #cbd5e1 !important;
            color: #334155 !important;
            font-size: 0.875rem !important;
            vertical-align: middle !important;
        }
        table th.text-center, table td.text-center {
            text-align: center !important;
        }
        table th.text-right, table td.text-right {
            text-align: right !important;
        }
        table th.text-left, table td.text-left {
            text-align: left !important;
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
