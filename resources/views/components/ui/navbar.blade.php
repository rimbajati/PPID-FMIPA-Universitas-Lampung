<div id="main-header" class="fixed top-0 left-0 w-full z-[999] transition-transform duration-300 ease-out translate-y-0">
    @if(request()->is('/'))
        <div id="homepage-header-banner" class="relative w-full h-[64px] md:h-[80px] bg-white flex justify-center items-center border-b border-slate-100">
            <img src="{{ asset('images/header_logo.png') }}" class="h-10 md:h-14 w-auto object-contain" alt="Header Logo">
        </div>
    @endif

    <nav id="main-navbar" class="w-full transition-all duration-300 border-b-0 bg-[#1B365D]">
    <div id="navbar-container" class="w-full px-6 md:px-16 lg:px-24 py-3 transition-all duration-300">
        <div class="flex justify-between items-center">

            <a href="/" class="flex items-center shrink-0 gap-2.5 group">
                <img id="navbar-logo" src="{{ asset('images/logoPPID.png') }}" alt="Logo Unila" class="h-10 md:h-12 w-auto object-contain transition-all duration-300">
                <div class="text-left leading-snug hidden sm:block">
                    <span id="navbar-logo-text1" class="block text-white font-extrabold text-base md:text-lg tracking-wider uppercase">PPID FMIPA</span>
                    <span id="navbar-logo-text2" class="block text-white font-bold text-[11px] md:text-xs tracking-wider uppercase">Universitas Lampung</span>
                </div>
            </a>

            <div id="desktop-menu" class="hidden md:flex items-center justify-center flex-1 gap-8 lg:gap-10">
                @if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*'))
                    @php
                        $baseClass = "nav-link relative text-base font-bold text-white transition-all duration-300 after:content-[''] after:absolute after:left-0 after:-bottom-2 after:h-[2.5px] after:bg-white after:transition-all after:duration-300 hover:after:w-full";
                    @endphp

                    <!-- <a href="/" class="{{ $baseClass }} {{ request()->is('/') ? 'after:w-full' : 'after:w-0' }}">Beranda</a> -->
                    <a href="/informasi-publik" class="{{ $baseClass }} {{ request()->is('informasi-publik*') ? 'after:w-full' : 'after:w-0' }}">Informasi Publik</a>

                        <a href="/layanan" class="{{ $baseClass }} {{ request()->is('layanan*') || request()->is('permohonan*') || request()->is('keberatan*') || request()->is('pengajuan-keberatan*') || request()->is('riwayat-layanan*') || request()->is('prosedur-permohonan*') ? 'after:w-full' : 'after:w-0' }}">Layanan</a>
                    @endif
            </div>

            <button id="mobile-menu-btn" type="button" class="md:hidden text-white text-2xl focus:outline-none transition-colors">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="hidden md:flex items-center justify-end shrink-0">
                @auth
                    <div class="relative group ml-2">
                        <!-- Icon Profil Bulat -->
                        <div class="w-10 h-10 bg-white/15 hover:bg-white/25 border border-white/30 text-white rounded-full flex items-center justify-center text-lg transition-all cursor-pointer shadow-xs">
                            <i class="fa-solid fa-user"></i>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 top-full pt-3 w-48 hidden group-hover:block transition-all duration-300 z-[9999]">
                            <div class="bg-white border border-slate-100 shadow-2xl py-1.5 rounded-lg overflow-hidden">
                                <a href="{{ (Auth::user()->role ?? '') === 'admin' ? url('/admin/informasi-publik') : url('/login') }}"
                                    class="flex items-center gap-2.5 px-5 py-3 text-sm font-bold text-slate-700 hover:text-white hover:bg-[#1B365D] transition-all duration-200">
                                    <i class="fa-solid fa-gauge-high text-xs opacity-70"></i> Dashboard
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2.5 w-full text-left px-5 py-3 text-sm font-bold text-red-600 hover:text-white hover:bg-red-500 transition-all duration-200 cursor-pointer">
                                        <i class="fa-solid fa-right-from-bracket text-xs opacity-70"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    @if(request()->is('login*') || request()->is('register*') || request()->is('password*') || request()->is('forgot-password') || request()->is('reset-password*') || request()->is('admin-panel*'))
                        <a href="/" class="nav-auth-btn ml-4 px-6 py-2.5 bg-white/10 hover:bg-white/20 border border-white/30 text-white text-xs md:text-sm font-bold uppercase tracking-wider transition-all shadow-sm flex items-center gap-2 whitespace-nowrap" style="border-radius: 6px !important;">
                            <i class="fa-solid fa-arrow-left text-xs"></i> BERANDA
                        </a>
                    @else
                        <a href="/login" class="nav-auth-btn ml-4 px-8 py-2.5 bg-transparent border border-white/30 text-white text-sm font-bold uppercase tracking-wider transition-all shadow-sm hover:bg-white/10 whitespace-nowrap" style="border-radius: 6px !important;">MASUK</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-[#1B365D] border-t border-white/10 px-6 py-5 transition-all">
        <div class="flex flex-col space-y-4">
            @if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*'))
                <a href="/" class="text-white font-medium py-1">Beranda</a>

                <a href="/informasi-publik" class="text-slate-300 hover:text-white text-sm font-medium py-1 transition-colors {{ request()->is('informasi-publik*') ? 'text-white font-bold' : '' }}">Informasi Publik</a>

                <a href="/layanan" class="text-slate-300 hover:text-white text-sm font-medium py-1 transition-colors {{ request()->is('layanan*') || request()->is('permohonan*') || request()->is('keberatan*') || request()->is('pengajuan-keberatan*') || request()->is('riwayat-layanan*') ? 'text-white font-bold' : '' }}">Layanan</a>

                <a href="https://fmipa.unila.ac.id/berita" target="_blank" class="text-white font-medium py-1">Berita</a>
                <a href="/statistik" class="text-white font-medium py-1">Statistik</a>

                <div class="pt-4 border-t border-white/15">
                    @auth
                        <div class="space-y-3 pt-1">
                            <a href="{{ (Auth::user()->role ?? '') === 'admin' ? url('/admin/informasi-publik') : url('/login') }}"
                               class="flex items-center gap-3 text-slate-200 hover:text-white text-sm font-bold py-1.5 transition-colors">
                                <i class="fa-solid fa-gauge-high text-sky-400 text-sm w-5 text-center"></i>
                                <span>Dashboard</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full text-left text-red-400 hover:text-red-300 text-sm font-bold py-1.5 transition-colors cursor-pointer">
                                    <i class="fa-solid fa-right-from-bracket text-red-400 text-sm w-5 text-center"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="/login" class="flex items-center justify-center w-full px-6 py-3 bg-[#1B365D] hover:bg-[#162c4c] text-white text-sm font-bold uppercase tracking-wider transition-all shadow-md" style="border-radius: 6px !important;">
                            MASUK
                        </a>
                    @endauth
                </div>
            @else
                <a href="/" class="text-white font-medium py-1 inline-flex items-center gap-2">
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
        const navbar = document.getElementById('main-navbar');
        const navbarLogo = document.getElementById('navbar-logo');
        const logoText1 = document.getElementById('navbar-logo-text1');
        const logoText2 = document.getElementById('navbar-logo-text2');
        const links = document.querySelectorAll('.nav-link');
        const authBtn = document.querySelector('.nav-auth-btn');
        const authText = document.querySelector('.nav-auth-text');
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const scrollPosition = window.scrollY;

        const bannerHeight = isHome ? (window.innerWidth < 768 ? 64 : 80) : 0;
        const isPassedBanner = scrollPosition > bannerHeight;

        if (isPassedBanner) {
            header.style.transform = `translateY(-${bannerHeight}px)`;

            navbar.classList.remove('bg-transparent', 'border-transparent', 'border-slate-800', 'border-white/10');
            navbar.classList.add('bg-[#1B365D]', 'shadow-md', 'border-b-0');

            if (logoText1) {
                logoText1.classList.remove('text-slate-900');
                logoText1.classList.add('text-white');
            }
            if (logoText2) {
                logoText2.classList.remove('text-[#1B365D]');
                logoText2.classList.add('text-white');
            }

            if (authBtn) {
                authBtn.classList.remove('bg-transparent', 'text-slate-800', 'border-slate-300', 'hover:bg-slate-100');
                authBtn.classList.add('bg-transparent', 'text-white', 'border-white', 'hover:bg-white/10');
            }
            if (authText) {
                authText.classList.remove('text-slate-800');
                authText.classList.add('text-white');
            }
            if (mobileBtn) {
                mobileBtn.classList.remove('text-slate-800');
                mobileBtn.classList.add('text-white');
            }

            links.forEach(link => {
                link.classList.remove('text-slate-800', 'after:bg-[#1B365D]');
                link.classList.add('text-white', 'after:bg-white');
            });

        } else {
            header.style.transform = 'translateY(0)';

            navbar.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'border-slate-200', 'bg-transparent', 'border-transparent');
            navbar.classList.add('bg-[#1B365D]', 'border-b-0');

            if (logoText1) {
                logoText1.classList.remove('text-slate-900');
                logoText1.classList.add('text-white');
            }
            if (logoText2) {
                logoText2.classList.remove('text-[#1B365D]');
                logoText2.classList.add('text-white');
            }

            if (authBtn) {
                authBtn.classList.remove('bg-white', 'text-slate-800', 'border-slate-300', 'hover:bg-slate-100');
                authBtn.classList.add('bg-transparent', 'text-white', 'border-white/30', 'hover:bg-white/10');
            }
            if (authText) {
                authText.classList.remove('text-slate-800');
                authText.classList.add('text-white');
            }
            if (mobileBtn) {
                mobileBtn.classList.remove('text-slate-800');
                mobileBtn.classList.add('text-white');
            }

            links.forEach(link => {
                link.classList.remove('text-slate-800', 'after:bg-[#1B365D]');
                link.classList.add('text-white', 'after:bg-white');
            });
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

    function toggleMobileDropdown(id, iconId) {
        const dropdown = document.getElementById(id);
        const icon = document.getElementById(iconId);
        if (dropdown) dropdown.classList.toggle('hidden');
        if (icon) icon.classList.toggle('rotate-90');
    }
</script>
