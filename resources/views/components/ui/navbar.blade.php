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
                            
                            <a href="/layanan" class="{{ $baseClass }} {{ request()->is('layanan*') || request()->is('permohonan*') || request()->is('keberatan*') || request()->is('pengajuan-keberatan*') || request()->is('riwayat-layanan*') || request()->is('prosedur-permohonan*') ? $activeClass : '' }}">Layanan</a>
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

                    <a href="/layanan" class="text-sky-100 hover:text-white font-semibold py-3 transition-colors border-b border-white/10 {{ request()->is('layanan*') || request()->is('permohonan*') || request()->is('keberatan*') || request()->is('pengajuan-keberatan*') || request()->is('riwayat-layanan*') ? 'text-white font-bold' : '' }}">Layanan</a>

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
