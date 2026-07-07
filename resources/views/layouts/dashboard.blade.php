<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - PPID FMIPA Unila')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Poppins', 'sans-serif'] } } } }
    </script>
</head>

<body class="antialiased text-gray-800 bg-slate-50 min-h-screen flex w-full overflow-x-hidden">

    <aside id="sidebar" class="w-80 bg-white border-r border-gray-200 shrink-0 h-screen fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto md:static">
        <div>
            <div class="px-8 py-8 flex items-center justify-between md:hidden border-b border-gray-100">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                </a>
                <button onclick="toggleSidebar()" class="text-2xl text-gray-600 hover:text-gray-900">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>

            <div class="px-8 py-12 border-b border-gray-100 hidden md:block">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto mx-auto">
                </a>
            </div>

            <nav class="p-6 space-y-0">
                <a href="{{ route('riwayat.index') }}" class="flex items-center gap-4 px-6 py-4 text-sm font-bold transition {{ request()->routeIs('riwayat.index') ? 'bg-[#0a192f] text-white' : 'text-gray-600 hover:bg-slate-50 hover:text-gray-900' }}">
                    <i class="fa-solid fa-clock-rotate-left text-lg w-6 text-center"></i>
                    <span>Riwayat Layanan</span>
                </a>

                <div>
                    <button onclick="toggleSubmenu('submenu-layanan', 'icon-layanan')" type="button" class="w-full flex items-center justify-between px-6 py-4 text-sm font-bold transition {{ request()->routeIs('permohonan.*', 'keberatan.*') ? 'bg-[#0a192f] text-white' : 'text-gray-600 hover:bg-slate-50 hover:text-gray-900' }}">
                        <div class="flex items-center gap-4">
                            <i class="fa-solid fa-layer-group text-lg w-6 text-center"></i>
                            <span>Layanan</span>
                        </div>
                        <i id="icon-layanan" class="fa-solid fa-chevron-down text-xs transition-transform duration-200 {{ request()->routeIs('permohonan.*', 'keberatan.*') ? 'rotate-180' : '' }}"></i>
                    </button>

                    <div id="submenu-layanan" class="{{ request()->routeIs('permohonan.*', 'keberatan.*') ? 'block' : 'hidden' }} bg-gray-50/50 space-y-0">
                        <a href="{{ route('permohonan.create') }}" class="flex items-center gap-3 px-12 py-4 text-sm font-bold transition {{ request()->routeIs('permohonan.*') ? 'bg-[#1e3a8a] text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            <i class="fa-solid fa-file-circle-question text-base w-5 text-center"></i>
                            <span>Formulir Permohonan Informasi Publik</span>
                        </a>
                        <a href="{{ route('keberatan.create') }}" class="flex items-center gap-3 px-12 py-4 text-sm font-bold transition {{ request()->routeIs('keberatan.*') ? 'bg-[#1e3a8a] text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            <i class="fa-solid fa-scale-balanced text-base w-5 text-center"></i>
                            <span>Formulir Keberatan Informasi Publik</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-4 px-6 py-4 text-sm font-bold transition {{ request()->routeIs('user.dashboard') ? 'bg-[#0a192f] text-white' : 'text-gray-600 hover:bg-slate-50 hover:text-gray-900' }}">
                    <i class="fa-solid fa-user-pen text-lg w-6 text-center"></i>
                    <span>Update Profile</span>
                </a>
            </nav>
        </div>

        <div class="border-t border-gray-100">
            <a href="/" class="flex items-center gap-4 px-6 py-4 text-sm font-bold text-gray-600 hover:bg-slate-50 hover:text-gray-900 transition">
                <i class="fa-solid fa-house text-lg w-6 text-center"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-6 py-4 text-sm font-bold text-red-600 hover:bg-red-50 transition">
                    <i class="fa-solid fa-right-from-bracket text-lg w-6 text-center"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-8 py-5 flex justify-between items-center z-30">
            <button onclick="toggleSidebar()" class="md:hidden text-gray-700 text-2xl">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="hidden md:block"></div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="font-bold text-gray-900 text-lg leading-tight">{{ Auth::user()->nama_lengkap ?? 'User' }}</p>
                </div>
            </div>
        </header>

        <main class="flex-1 w-full overflow-y-auto p-6 md:p-10">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
        }
        function toggleSubmenu(id, icon) {
            document.getElementById(id).classList.toggle('hidden');
            document.getElementById(icon).classList.toggle('rotate-180');
        }
    </script>
</body>
</html>
