<div id="main-header" class="fixed top-0 left-0 w-full z-[999] transition-transform duration-300 ease-out translate-y-0">
    @if(request()->is('/'))
        <div id="homepage-header-banner" class="relative w-full h-[64px] md:h-[80px] bg-white flex justify-center items-center border-b border-slate-100">
            <img src="{{ asset('images/header_logo.png') }}?v=2.0" class="h-10 md:h-14 w-auto object-contain" alt="Header Logo">
        </div>
    @endif

    <nav id="main-navbar" class="w-full bg-sky-500 border-b-0 shadow-md transition-all duration-300">
        <div class="w-full max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12 lg:px-16 py-4">
            <div class="flex justify-between items-center">
                <!-- Left: Logo -->
                <a href="/" class="flex items-center shrink-0 gap-3 group">
                    <img id="navbar-logo" src="{{ asset('images/logoPPID.png') }}?v=2.0" alt="Logo Unila" class="h-9 md:h-11 w-auto object-contain">
                    <div class="text-left leading-tight hidden sm:block">
                        <span id="navbar-logo-text1" class="block text-white font-extrabold text-sm md:text-base tracking-wide">PPID FMIPA</span>
                        <span id="navbar-logo-text2" class="block text-sky-100 font-semibold text-[10px] md:text-[11px] tracking-wide uppercase">Universitas Lampung</span>
                    </div>
                </a>

                <!-- Center: Navigation Links in a Pill -->
                <div id="desktop-menu" class="hidden md:flex items-center justify-center flex-1">
                    @if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*'))
                        <div class="flex items-center gap-1 bg-white/20 backdrop-blur-md px-2 py-1.5 rounded-full border border-white/20">
                            @php
                                $baseClass = "nav-link text-[14.5px] font-semibold text-white hover:bg-white/20 px-5 py-2 rounded-full transition-all duration-200 flex items-center gap-1";
                                $activeClass = "bg-white/25 text-white font-bold shadow-sm";
                            @endphp
                           
                            <a href="/" class="{{ $baseClass }} {{ request()->is('/') ? $activeClass : '' }}">Beranda</a>

                            <a href="/informasi-publik" class="{{ $baseClass }} {{ request()->is('informasi-publik*') ? $activeClass : '' }}">Informasi Publik</a>
                            
                            <!-- Dropdown Menu Layanan (Desktop) dengan kontrol tutup instan saat diklik -->
                            <div class="relative" 
                                 x-data="{ open: false }" 
                                 @mouseenter="open = true" 
                                 @mouseleave="open = false" 
                                 @click.outside="open = false">
                                <button type="button" 
                                    @click="open = !open"
                                    class="{{ $baseClass }} {{ request()->is('layanan*') || request()->is('permohonan*') || request()->is('keberatan*') || request()->is('pengajuan-keberatan*') || request()->is('riwayat-layanan*') || request()->is('prosedur-permohonan*') ? $activeClass : '' }} cursor-pointer">
                                    <span>Layanan</span>
                                    <i class="fa-solid fa-chevron-down text-[10px] ml-0.5 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                </button>

                                <!-- Dropdown Card Solid Putih Elegan & Kontras Tinggi (Jelas di atas konten apa pun) -->
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-1"
                                     class="absolute left-1/2 -translate-x-1/2 top-full pt-3 w-72 z-[9999]"
                                     style="display: none;">
                                    <div class="bg-white border border-slate-200/80 shadow-2xl shadow-slate-900/15 rounded-2xl sm:rounded-3xl p-2 overflow-hidden text-slate-800 ring-1 ring-black/5">
                                        <!-- 1. Statistik Layanan -->
                                        <a href="{{ url('/#statistik-layanan') }}" 
                                           @click="open = false"
                                           class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl hover:bg-sky-50 transition-all duration-200 group/item">
                                            <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-xs shrink-0 group-hover/item:scale-110 group-hover:bg-sky-600 group-hover:text-white transition-all shadow-2xs">
                                                <i class="fa-solid fa-chart-simple"></i>
                                            </div>
                                            <div>
                                                <span class="block text-xs font-bold text-slate-900 leading-tight group-hover/item:text-sky-600 transition-colors">Statistik Layanan</span>
                                                <span class="block text-[10px] text-slate-500 font-medium mt-0.5">Grafik transparansi KIP</span>
                                            </div>
                                        </a>

                                        <!-- 2. Alur Layanan -->
                                        <a href="{{ url('/#alur-layanan') }}" 
                                           @click="open = false"
                                           class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl hover:bg-blue-50 transition-all duration-200 group/item">
                                            <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xs shrink-0 group-hover/item:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all shadow-2xs">
                                                <i class="fa-solid fa-route"></i>
                                            </div>
                                            <div>
                                                <span class="block text-xs font-bold text-slate-900 leading-tight group-hover/item:text-blue-600 transition-colors">Alur Layanan</span>
                                                <span class="block text-[10px] text-slate-500 font-medium mt-0.5">Mekanisme 4 langkah praktis</span>
                                            </div>
                                        </a>

                                        <!-- Divider Garis Halus -->
                                        <div class="my-1.5 border-t border-slate-100"></div>

                                        <!-- 3. Permohonan Informasi -->
                                        <a href="{{ url('/permohonan') }}" 
                                           @click="open = false"
                                           class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl hover:bg-sky-50 transition-all duration-200 group/item {{ request()->is('permohonan*') ? 'bg-sky-50 text-sky-600 font-bold' : '' }}">
                                            <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-xs shrink-0 group-hover/item:scale-110 group-hover:bg-sky-600 group-hover:text-white transition-all shadow-2xs">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </div>
                                            <div>
                                                <span class="block text-xs font-bold text-slate-900 leading-tight group-hover/item:text-sky-600 transition-colors">Permohonan Informasi</span>
                                                <span class="block text-[10px] text-slate-500 font-medium mt-0.5">Pengajuan berkas online</span>
                                            </div>
                                        </a>

                                        <!-- 4. Pengajuan Keberatan -->
                                        <a href="{{ url('/pengajuan-keberatan') }}" 
                                           @click="open = false"
                                           class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl hover:bg-amber-50 transition-all duration-200 group/item {{ request()->is('pengajuan-keberatan*') ? 'bg-amber-50 text-amber-600 font-bold' : '' }}">
                                            <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xs shrink-0 group-hover/item:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all shadow-2xs">
                                                <i class="fa-solid fa-scale-balanced"></i>
                                            </div>
                                            <div>
                                                <span class="block text-xs font-bold text-slate-900 leading-tight group-hover/item:text-amber-600 transition-colors">Pengajuan Keberatan</span>
                                                <span class="block text-[10px] text-slate-500 font-medium mt-0.5">Sanggahan berkas resmi</span>
                                            </div>
                                        </a>

                                        <!-- 5. Lacak & Riwayat Layanan -->
                                        <a href="{{ url('/riwayat-layanan') }}" 
                                           @click="open = false"
                                           class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-2xl hover:bg-emerald-50 transition-all duration-200 group/item {{ request()->is('riwayat-layanan*') ? 'bg-emerald-50 text-emerald-600 font-bold' : '' }}">
                                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs shrink-0 group-hover/item:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-2xs">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                            </div>
                                            <div>
                                                <span class="block text-xs font-bold text-slate-900 leading-tight group-hover/item:text-emerald-600 transition-colors">Lacak & Riwayat Layanan</span>
                                                <span class="block text-[10px] text-slate-500 font-medium mt-0.5">Monitoring tiket & status</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right: CTA / Auth -->
                <div class="hidden md:flex items-center justify-end shrink-0">
                    @auth
                        <div class="relative group">
                            <!-- Icon Profil Bulat -->
                            <div class="w-10 h-10 bg-white/20 hover:bg-white/30 text-white rounded-full flex items-center justify-center text-sm transition-all cursor-pointer shadow-sm border border-white/20">
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 top-full pt-3 w-48 hidden group-hover:block transition-all duration-300 z-[9999]">
                                <div class="bg-white border border-slate-100 shadow-xl py-2 rounded-xl overflow-hidden">
                                    <a href="{{ (Auth::user()->role ?? '') === 'admin' ? url('/admin/informasi-publik') : url('/login') }}"
                                        class="flex items-center gap-3 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:text-[#1B365D] hover:bg-slate-50 transition-all duration-200">
                                        <i class="fa-solid fa-gauge-high text-xs opacity-70 w-4 text-center"></i> Dashboard
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full text-left px-5 py-2.5 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 transition-all duration-200 cursor-pointer">
                                            <i class="fa-solid fa-right-from-bracket text-xs opacity-70 w-4 text-center"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        @if(request()->is('login*') || request()->is('register*') || request()->is('password*') || request()->is('forgot-password') || request()->is('reset-password*') || request()->is('admin-panel*'))
                            <a href="/" class="nav-auth-btn ml-4 px-6 py-2.5 bg-white/20 hover:bg-white/30 border border-white/20 text-white text-sm font-bold tracking-wide transition-all rounded-full flex items-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-arrow-left text-xs"></i> KEMBALI
                            </a>
                        @else
                            <a href="/login" class="nav-auth-btn ml-4 px-8 py-2.5 bg-white hover:bg-slate-100 text-sky-700 text-sm font-bold tracking-wide transition-all rounded-full whitespace-nowrap shadow-sm">
                                MASUK
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" type="button" class="md:hidden text-white text-2xl focus:outline-none transition-colors ml-4">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-sky-600 border-t border-white/10 px-6 py-5 shadow-lg absolute w-full left-0">
            <div class="flex flex-col space-y-2">
                @if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*'))
                    <a href="/" class="text-white font-semibold py-3 border-b border-white/10">Beranda</a>

                    <a href="/informasi-publik" class="text-sky-100 hover:text-white font-semibold py-3 transition-colors border-b border-white/10 {{ request()->is('informasi-publik*') ? 'text-white font-bold' : '' }}">Informasi Publik</a>

                    <!-- Accordion Submenu Layanan (Mobile) -->
                    <div class="border-b border-white/10 py-2">
                        <span class="text-xs font-bold text-sky-200 uppercase tracking-wider block mb-2">Layanan PPID:</span>
                        <div class="pl-3 space-y-2">
                            <a href="{{ url('/#statistik-layanan') }}" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-chart-simple text-xs text-sky-300 w-4"></i>
                                <span>Statistik Layanan</span>
                            </a>
                            <a href="{{ url('/#alur-layanan') }}" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-route text-xs text-sky-300 w-4"></i>
                                <span>Alur Layanan</span>
                            </a>
                            <div class="my-1 border-t border-white/10"></div>
                            <a href="{{ url('/permohonan') }}" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-file-signature text-xs text-blue-300 w-4"></i>
                                <span>Permohonan Informasi</span>
                            </a>
                            <a href="{{ url('/pengajuan-keberatan') }}" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-scale-balanced text-xs text-amber-300 w-4"></i>
                                <span>Pengajuan Keberatan</span>
                            </a>
                            <a href="{{ url('/riwayat-layanan') }}" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-clock-rotate-left text-xs text-emerald-300 w-4"></i>
                                <span>Lacak & Riwayat Layanan</span>
                            </a>
                        </div>
                    </div>

                    <div class="pt-4">
                        @auth
                            <div class="space-y-3">
                                <a href="{{ (Auth::user()->role ?? '') === 'admin' ? url('/admin/informasi-publik') : url('/login') }}"
                                   class="flex items-center gap-3 text-white font-semibold py-2 transition-colors">
                                    <i class="fa-solid fa-gauge-high text-sky-200 text-sm w-5 text-center"></i>
                                    <span>Dashboard</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full text-left text-red-200 hover:text-red-100 font-semibold py-2 transition-colors cursor-pointer">
                                        <i class="fa-solid fa-right-from-bracket text-red-200 text-sm w-5 text-center"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="/login" class="flex items-center justify-center w-full px-6 py-3.5 bg-white hover:bg-slate-100 text-sky-700 text-sm font-bold tracking-wide transition-all shadow-md rounded-full mt-2">
                                MASUK
                            </a>
                        @endauth
                    </div>
                @else
                    <a href="/" class="text-white font-semibold py-3 inline-flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left text-sm"></i> Kembali ke Beranda
                    </a>
                @endif
            </div>
        </div>
    </nav>
</div>

<script>
    function updateNavbarStyle() {
        const isHome = {{ request()->is('/') ? 'true' : 'false' }};
        const header = document.getElementById('main-header');
        const scrollPosition = window.scrollY;

        const bannerHeight = isHome ? (window.innerWidth < 768 ? 64 : 80) : 0;
        const isPassedBanner = scrollPosition > bannerHeight;

        if (isPassedBanner) {
            header.style.transform = `translateY(-${bannerHeight}px)`;
        } else {
            header.style.transform = 'translateY(0)';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateNavbarStyle();
        window.addEventListener('scroll', updateNavbarStyle);
        window.addEventListener('resize', updateNavbarStyle);

        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>
