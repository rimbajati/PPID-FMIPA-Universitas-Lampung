<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - PPID FMIPA Unila')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-gray-900 text-white flex flex-col justify-between flex-shrink-0">
            <div>
                <div class="p-6 border-b border-gray-800">
                    <h2 class="text-xl font-extrabold tracking-wide text-white">Panel Admin <span class="text-[#0095e8]">PPID</span></h2>
                    <p class="text-xs text-gray-400 mt-1">FMIPA Universitas Lampung</p>
                </div>

                <nav class="p-4 space-y-2 text-sm">

                    <a href="{{ url('/admin/dashboard') }}"
                       class="flex items-center px-4 py-3 rounded-xl font-bold transition {{ request()->is('admin/dashboard*') ? 'bg-[#0095e8] text-white shadow-lg' : 'text-gray-300 font-medium hover:bg-gray-800 hover:text-[#0095e8]' }}">
                        <i class="fa-solid fa-chart-pie w-6"></i> Dashboard
                    </a>

                    <a href="{{ url('/admin/informasi-publik') }}"
                       class="flex items-center px-4 py-3 rounded-xl font-bold transition {{ request()->is('admin/informasi-publik*') ? 'bg-[#0095e8] text-white shadow-lg' : 'text-gray-300 font-medium hover:bg-gray-800 hover:text-[#0095e8]' }}">
                        <i class="fa-solid fa-folder-open w-6"></i> Informasi Publik
                    </a>

                    <a href="{{ url('/admin/permohonan') }}"
                       class="flex items-center px-4 py-3 rounded-xl font-bold transition {{ request()->is('admin/permohonan*') ? 'bg-[#0095e8] text-white shadow-lg' : 'text-gray-300 font-medium hover:bg-gray-800 hover:text-[#0095e8]' }}">
                        <i class="fa-solid fa-file-lines w-6"></i> Permohonan
                    </a>
<!--
                    <a href="{{ url('/admin/keberatan') }}" -->
                    <a href="#"
                       class="flex items-center px-4 py-3 rounded-xl font-bold transition {{ request()->is('admin/keberatan*') ? 'bg-[#0095e8] text-white shadow-lg' : 'text-gray-300 font-medium hover:bg-gray-800 hover:text-[#0095e8]' }}">
                        <i class="fa-solid fa-scale-balanced w-6"></i> Keberatan
                    </a>

                </nav>
            </div>

            <div class="p-4 border-t border-gray-800">
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 px-4 bg-gray-800 hover:bg-red-500 text-gray-300 hover:text-white rounded-xl text-sm font-bold transition flex items-center justify-center cursor-pointer">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">

            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 flex-shrink-0">
                <div>
                    <span class="bg-[#0095e8]/10 text-[#0095e8] text-xs font-bold px-4 py-2 rounded-full uppercase tracking-wide">
                        <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </span>
                </div>

                <div class="flex items-center pl-6 border-l border-gray-200 text-sm font-bold text-gray-900">
                    <div class="w-8 h-8 bg-[#0095e8] text-white rounded-full flex items-center justify-center mr-3 shadow-md">
                        A
                    </div>
                    {{ auth()->user()->nama_lengkap ?? 'Admin PPID' }}
                </div>
            </header>

            <main class="p-8">
                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')
</body>
</html>
