<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPID Pelaksana FMIPA Universitas Lampung')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=3.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logoPPID.png') }}?v=3.0">
    <link rel="apple-touch-icon" href="{{ asset('images/logoPPID.png') }}?v=3.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Material Design Icons (MDI) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                            DEFAULT: '#c5a253',
                            light: '#d4b76a',
                            dark: '#a8893e',
                        },
                        accent: {
                            DEFAULT: '#0ea5e9',
                            light: '#38bdf8',
                            dark: '#0284c7',
                        },
                        'primary-light': '#1a3a5c',
                        'secondary-light': '#f8f5ee',
                        'accent-light': '#e0f2fe',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'system-ui', '-apple-system', 'sans-serif'],
                        serif: ['Plus Jakarta Sans', 'sans-serif'],
                        poppins: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    borderRadius: {
                        'DEFAULT': '0.375rem',
                        'sm': '0.25rem',
                        'md': '0.375rem',
                        'lg': '0.5rem',
                        'xl': '0.5rem',
                        '2xl': '0.5rem',
                        '3xl': '0.75rem',
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
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important; 
            font-size: 1rem; 
        }
        h1, h2, h3, .font-display {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        /* Samakan tipografi semua tabel masyarakat, termasuk isi, status, dan pagination. */
        table th, table td,
        table th :not(i):not(svg), table td :not(i):not(svg),
        [data-dip-info], [data-dip-pagination] *,
        [data-admin-dip-info], [data-admin-dip-pagination] *,
        #table-kat-info, #table-kat-pagination *,
        #select-per-page-kat, #input-search-kat, label[for="input-search-kat"] {
            font-size: 15px !important;
        }
        table thead th {
            text-align: left !important;
        }
        table thead th.consequence-group-header {
            text-align: center !important;
        }
        table tbody td {
            text-align: left !important;
        }
        table tbody td .flex {
            justify-content: flex-start !important;
        }
        table thead th > div {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between !important;
            text-align: left !important;
        }
        /* Semua tabel masyarakat memakai pemisah horizontal tanpa garis vertikal. */
        table {
            border-left: 0 !important;
            border-right: 0 !important;
        }
        table th,
        table td {
            border-left: 0 !important;
            border-right: 0 !important;
        }
        table tbody tr:not(:last-child) td {
            border-bottom: 1px solid #d1d5db;
        }
        /* Pada tabel kategori masyarakat, garis hanya membatasi rincian yang berbeda. */
        table tbody[data-category-table="true"] > tr > td {
            border-bottom: 0 !important;
        }
        table tbody[data-category-table="true"] > tr.category-group-end > td,
        table tbody[data-category-table="true"] > tr > td.category-group-boundary-cell {
            border-bottom: 1px solid #d1d5db !important;
        }
        table tbody td[colspan] {
            padding: 0.625rem 0.75rem !important;
            text-align: left !important;
            color: #0f172a !important;
            font-weight: 500 !important;
        }
        /* Mencegah pemotongan suku kata di tengah kata (seperti: penyimpa - nan) */
        th, td, p, span, h1, h2, h3, h4, h5, h6, a, div {
            word-break: normal !important;
            overflow-wrap: break-word;
            hyphens: none !important;
            -webkit-hyphens: none !important;
        }

        /* Semua tabel masyarakat tetap siku 90 derajat — statistik dikecualikan agar tetap melengkung */
        table, table th, table td, table tr,
        .overflow-x-auto,
        [class*="table-container"] {
            border-radius: 0px !important;
        }
        div[class*="rounded"]:has(table),
        section[class*="rounded"]:has(table),
        div:has(> .overflow-x-auto),
        div:has(> table) {
            border-radius: 0px !important;
        }
        /* Statistik boleh melengkung — override siku di atas */
        #statistik-layanan,
        #statistik-layanan .bg-white.rounded-xl {
            border-radius: 0.75rem !important;
        }
    </style>
</head>

<body class="antialiased text-gray-800 bg-slate-50 min-h-screen flex flex-col {{ request()->is('/') ? 'is-home' : '' }}">

    <x-ui.navbar />

    <main class="flex-grow">
        @yield('content')
    </main>

    @php
        $footerProfil = \App\Http\Controllers\Admin\KontenController::getProfil();
    @endphp
    <x-ui.footer :profil="$footerProfil" />
</body>
</html>
