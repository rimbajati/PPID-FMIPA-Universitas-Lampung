<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard User - PPID FMIPA Unila')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important; }
        /* Scrollbar kustom untuk sidebar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 0px !important; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

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

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased overflow-hidden">

    <!-- Overlay Latar Belakang (Muncul saat Sidebar dibuka di Mobile) -->
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden transition-opacity lg:hidden"></div>

    <div class="flex h-screen w-full">

        <!-- Sidebar Container -->
        <aside id="sidebar" class="w-[300px] bg-white border-r border-slate-200 flex flex-col justify-between flex-shrink-0 h-screen fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">

            <div class="flex-1 overflow-y-auto flex flex-col">
                <!-- Logo Section -->
                <div class="px-7 py-8 flex items-center justify-between">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo PPID" class="h-[46px] w-auto">
                    </a>
                    <!-- Tombol Tutup Mobile (Tampilan Hamburger Premium) -->
                    <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-all shadow-sm">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>

                <!-- Navigasi Utama -->
                <nav class="px-6 space-y-2.5 mt-2">
                    <a href="{{ route('layanan.index') }}"
                       class="flex items-center px-5 py-3.5 rounded-[14px] text-[15px] font-semibold transition-all duration-300
                       {{ request()->routeIs('layanan.index') ? 'bg-[#1B365D] text-white shadow-lg shadow-sky-900/20' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-inbox text-lg w-7 text-center mr-2"></i>
                        Pengajuan
                    </a>

                    <a href="{{ route('user.profile') }}"
                       class="flex items-center px-5 py-3.5 rounded-[14px] text-[15px] font-semibold transition-all duration-300
                       {{ request()->routeIs('user.profile') ? 'bg-[#1B365D] text-white shadow-lg shadow-sky-900/20' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-user-pen text-lg w-7 text-center mr-2"></i>
                        Update Profile
                    </a>
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-6 border-t border-slate-100 bg-white shrink-0">
                <a href="/" class="flex items-center px-5 py-3.5 text-[15px] font-bold text-slate-500 hover:bg-slate-100 hover:text-slate-900 rounded-[14px] transition-all mb-2">
                    <i class="fa-solid fa-house text-lg w-7 text-center mr-2"></i> Beranda
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-5 py-3.5 text-[15px] font-bold text-red-500 hover:bg-red-50 hover:text-red-700 rounded-[14px] transition-all">
                        <i class="fa-solid fa-arrow-right-from-bracket text-lg w-7 text-center mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 h-screen">

            <!-- Header (Topbar) -->
            <header class="bg-white/80 backdrop-blur-md h-[76px] flex items-center justify-between px-8 border-b border-slate-200 shadow-sm flex-shrink-0 z-30 sticky top-0">
                <!-- Tombol Hamburger (Hanya muncul di Mobile/Tablet untuk membuka) -->
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-600 hover:text-slate-900 text-2xl transition-colors">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="hidden lg:block"></div> <!-- Spacer -->

                <!-- Profil Info -->
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-[#1B365D] shrink-0">
                        <i class="fa-solid fa-circle-user text-lg"></i>
                    </div>
                    <div class="text-left hidden sm:block">
                        <p class="font-bold text-slate-800 text-[15px] flex items-center gap-2">
                            <span>{{ Auth::user()->nama_lengkap ?? 'User' }}</span>
                        </p>
                    </div>
                </div>
            </header>

            <!-- Area Konten Utama -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 w-full">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script Kontrol Sidebar Mobile -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        function toggleSubmenu(id, icon) {
            document.getElementById(id).classList.toggle('hidden');
            document.getElementById(icon).classList.toggle('rotate-180');
        }
    </script>
</body>
</html>

