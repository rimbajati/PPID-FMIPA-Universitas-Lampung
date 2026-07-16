<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - PPID FMIPA Unila')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif !important; }
        /* Scrollbar kustom untuk sidebar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased overflow-hidden">

    <!-- Overlay Latar Belakang (Muncul saat Sidebar dibuka di Mobile) -->
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden transition-opacity lg:hidden"></div>

    <div class="flex h-screen w-full">

        <!-- Sidebar Container -->
        <aside id="sidebar" class="w-[300px] bg-white border-r border-slate-200 flex flex-col justify-between flex-shrink-0 h-screen fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">

            <div class="flex-1 overflow-y-auto">
                <!-- Logo Section -->
                <div class="px-7 py-8 flex items-center justify-between">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo PPID" class="h-[46px] w-auto">
                    </a>
                    <!-- Tombol Tutup Mobile -->
                    <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-slate-500 hover:bg-slate-100 hover:text-slate-900 transition-all shadow-sm">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>

                <!-- Navigasi Utama -->
                <nav class="px-6 space-y-2.5 mt-2">
                    @php
                        $navItems = [
                            ['url' => '/admin/dashboard', 'icon' => 'fa-chart-pie', 'label' => 'Dashboard'],
                            ['url' => '/admin/informasi-publik', 'icon' => 'fa-folder-open', 'label' => 'Informasi Publik'],
                            ['url' => '/admin/pengajuan', 'icon' => 'fa-file-lines', 'label' => 'Pengajuan'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        <a href="{{ url($item['url']) }}"
                           class="flex items-center px-5 py-3.5 rounded-[14px] text-[15px] font-semibold transition-all duration-300
                           {{ request()->is(ltrim($item['url'], '/').'*') ? 'bg-[#0f172a] text-white shadow-lg shadow-slate-900/20' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fa-solid {{ $item['icon'] }} text-lg w-7 text-center mr-2"></i>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-6 border-t border-slate-100 bg-white">
                <a href="{{ url('/') }}" class="flex items-center px-5 py-3.5 text-[15px] font-bold text-slate-500 hover:bg-slate-100 hover:text-slate-900 rounded-[14px] transition-all mb-2">
                    <i class="fa-solid fa-house text-lg w-7 text-center mr-2"></i> Beranda
                </a>
                <form action="{{ url('/logout') }}" method="POST">
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
                <!-- Tombol Hamburger -->
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-600 hover:text-slate-900 text-2xl transition-colors">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="hidden lg:block"></div> <!-- Spacer -->

                <!-- Profil Info -->
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-slate-800 text-[15px]">{{ auth()->user()->nama_lengkap ?? 'Admin PPID' }}</p>
                    </div>
                    <!-- Avatar Lingkaran -->
                    <div class="w-10 h-10 bg-[#0f172a] text-white rounded-full flex items-center justify-center font-bold text-base shadow-md">
                        {{ substr(auth()->user()->nama_lengkap ?? 'A', 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Area Konten Utama -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 w-full">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                        <p class="text-sm font-semibold">{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation text-lg"></i>
                        <p class="text-sm font-semibold">{{ session('error') }}</p>
                    </div>
                @endif
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
    </script>
    @stack('scripts')
</body>
</html>

