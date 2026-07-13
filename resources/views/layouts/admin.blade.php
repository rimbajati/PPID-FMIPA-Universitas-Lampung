<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - PPID FMIPA Unila')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif !important; }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-slate-50 text-slate-800 antialiased font-sans">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between flex-shrink-0">
            <div>
                <!-- Logo Section -->
                <div class="px-8 py-8 flex items-center justify-between border-b border-gray-100">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto mx-auto">
                    </a>
                    <button onclick="toggleSidebar()" class="md:hidden text-2xl text-gray-600">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                <!-- Navigasi -->
                <nav class="px-4 space-y-1 text-sm">
                    @php
                        $navItems = [
                            ['url' => '/admin/dashboard', 'icon' => 'fa-chart-pie', 'label' => 'Dashboard'],
                            ['url' => '/admin/informasi-publik', 'icon' => 'fa-folder-open', 'label' => 'Informasi Publik'],
                            ['url' => '/admin/permohonan', 'icon' => 'fa-file-lines', 'label' => 'Permohonan'],
                            ['url' => '#', 'icon' => 'fa-scale-balanced', 'label' => 'Keberatan'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        <a href="{{ url($item['url']) }}"
                           class="flex items-center px-4 py-3 rounded-lg font-semibold transition-all duration-200
                           {{ request()->is(ltrim($item['url'], '/').'*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fa-solid {{ $item['icon'] }} w-5 mr-3"></i> {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- Footer Sidebar -->
            <div class="p-4 border-t border-gray-100">
                <a href="{{ url('/') }}" class="flex items-center px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg mb-1">
                    <i class="fa-solid fa-house mr-3"></i> Beranda
                </a>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-3"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white h-16 flex items-center justify-end px-8 border-b border-gray-100 shadow-sm flex-shrink-0">
                <div class="flex items-center text-sm font-bold text-slate-800">
                    <span class="mr-4">{{ auth()->user()->nama_lengkap ?? 'Admin PPID' }}</span>
                    <div class="w-8 h-8 bg-slate-900 text-white rounded-full flex items-center justify-center text-xs">
                        {{ substr(auth()->user()->nama_lengkap ?? 'A', 0, 1) }}
                    </div>
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
