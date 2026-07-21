<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPID FMIPA Universitas Lampung')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '0px',
                        'DEFAULT': '0px',
                        'md': '0px',
                        'lg': '0px',
                        'xl': '0px',
                        '2xl': '0px',
                        '3xl': '0px',
                        'full': '0px',
                    }
                }
            }
        }
    </script>

    <style>
        html { scroll-behavior: smooth; }
        /* Force 90-degree sharp corners globally across the entire system */
        *, ::before, ::after {
            border-radius: 0px !important;
        }

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
            padding: 10px 14px !important;
            border: 1px solid #233545 !important;
            border-right: 1px solid rgba(255, 255, 255, 0.25) !important;
            border-bottom: 1px solid #cbd5e1 !important;
            font-size: 0.8125rem !important;
            letter-spacing: 0.025em !important;
        }
        table thead th:last-child {
            border-right: 1px solid #233545 !important;
        }
        table tbody tr {
            transition: background-color 0.15s ease-in-out;
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

    @include('partials.bilah_navigasi')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.kaki_halaman')
</body>
</html>

