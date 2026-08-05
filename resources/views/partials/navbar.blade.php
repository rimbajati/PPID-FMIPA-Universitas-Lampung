<div id="main-header" class="fixed top-0 left-0 w-full z-[999] transition-transform duration-300 ease-out translate-y-0">
    @if(request()->is('/'))
        <div id="homepage-header-banner" class="relative w-full h-[64px] md:h-[80px] bg-white flex justify-center items-center border-b border-slate-100">
            <img src="{{ asset('images/header_logo.png') }}" class="h-10 md:h-14 w-auto object-contain" alt="Header Logo">
        </div>
    @endif

    <nav id="main-navbar" class="w-full transition-all duration-300 border-b border-transparent">
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
                        $baseClass = "nav-link relative text-base font-bold transition-all duration-300 after:content-[''] after:absolute after:left-0 after:-bottom-2 after:h-[2.5px] after:transition-all after:duration-300 hover:after:w-full";
                    @endphp

                    <a href="/" class="{{ $baseClass }} {{ request()->is('/') ? 'after:w-full' : 'after:w-0' }}">Beranda</a>

                    <div class="relative group">
                        <button class="flex items-center gap-1 {{ $baseClass }} {{ request()->is('informasi-publik*') || request()->is('informasi-setiap-saat*') ? 'after:w-full' : 'after:w-0' }}">
                            Informasi Publik <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                        </button>
                        <div class="absolute left-0 top-full pt-4 w-72 hidden group-hover:block transition-all duration-300 z-50">
                            <div class="bg-white rounded-none shadow-xl border border-slate-100 py-2.5 overflow-hidden">
                                <a href="/informasi-publik" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-[#1B365D] hover:text-white transition-colors">Daftar Informasi Publik</a>
                                <a href="/informasi-setiap-saat" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-[#1B365D] hover:text-white transition-colors">Informasi Tersedia Setiap Saat</a>
                                <a href="/informasi-berkala" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-[#1B365D] hover:text-white transition-colors">Informasi Tersedia Secara Berkala</a>
                                <a href="/informasi-serta-merta" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-[#1B365D] hover:text-white transition-colors">Informasi Diumumkan Serta Merta</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <button class="flex items-center gap-1 {{ $baseClass }} {{ request()->is('prosedur-permohonan*') || request()->is('layanan*') ? 'after:w-full' : 'after:w-0' }}">
                            Layanan Informasi <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300 group-hover:rotate-180"></i>
                        </button>
                        <div class="absolute left-0 top-full pt-4 w-72 hidden group-hover:block transition-all duration-300 z-50">
                            <div class="bg-white rounded-none shadow-xl border border-slate-100 py-2.5 overflow-hidden">
                                @foreach([
                                    ['url' => route('prosedur.permohonan'), 'label' => 'Prosedur Permohonan Informasi'],
                                    ['url' => route('layanan.index') . '?type=permohonan', 'label' => 'Formulir Permohonan Informasi'],
                                    ['url' => route('layanan.index') . '?type=keberatan', 'label' => 'Formulir Pengajuan Keberatan'],
                                ] as $item)
                                    <a href="{{ $item['url'] }}" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-[#1B365D] hover:text-white transition-colors">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <a href="https://fmipa.unila.ac.id/berita" target="_blank" class="{{ $baseClass }} after:w-0">Berita</a>
                    <a href="/statistik" class="{{ $baseClass }} {{ request()->is('statistik*') ? 'after:w-full' : 'after:w-0' }}">Statistik</a>
                @endif
            </div>

            <button id="mobile-menu-btn" type="button" class="md:hidden text-white text-2xl focus:outline-none transition-colors">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="hidden md:flex items-center justify-end shrink-0 w-56">
                @if(request()->is('login*') || request()->is('register*') || request()->is('password*') || request()->is('forgot-password') || request()->is('reset-password*'))
                    <a href="/" class="inline-flex items-center gap-2 text-base font-semibold text-gray-700 hover:text-[#1B365D] transition-all nav-auth-text whitespace-nowrap">
                        <span class="hidden md:inline">Kembali ke Beranda</span> <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                @else
                    @auth
                        <div class="relative group ml-2">
                            <div class="nav-auth-text flex items-center gap-1.5 text-base font-semibold text-white transition-all cursor-pointer whitespace-nowrap py-1">
                                <span class="truncate max-w-[220px] inline-block">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] shrink-0 transition-transform duration-300 group-hover:rotate-180"></i>
                            </div>
                            <div class="absolute right-0 top-full pt-3 w-56 hidden group-hover:block transition-all duration-300 z-[9999]">
                                <div class="bg-white border border-slate-100 shadow-xl py-2 rounded-none overflow-hidden">
                                    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('layanan.index') }}"
                                        class="block px-6 py-3 text-sm font-medium text-slate-700 hover:text-white hover:bg-[#1B365D] transition-all duration-200">
                                        Dashboard
                                    </a>
                                    <div class="border-t border-slate-100 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-6 py-3 text-sm font-medium text-red-600 hover:text-white hover:bg-red-500 transition-all duration-200 cursor-pointer">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="nav-auth-btn ml-4 px-8 py-2.5 bg-transparent border border-white/30 text-white text-sm font-bold uppercase tracking-wider transition-all shadow-sm hover:bg-white/10 whitespace-nowrap" style="border-radius: 12px !important;">MASUK</a>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-slate-900 border-t border-slate-800 px-6 py-5 transition-all">
        <div class="flex flex-col space-y-4">
            @if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*'))
                <a href="/" class="text-white font-medium py-1">Beranda</a>

                <div class="py-1">
                    <button onclick="toggleMobileDropdown('dropdown-info', 'icon-info')" class="w-full flex items-center justify-between text-white font-medium transition-colors">
                        Informasi Publik
                        <i id="icon-info" class="fa-solid fa-chevron-right text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="dropdown-info" class="hidden flex flex-col pl-4 mt-3 space-y-3 border-l-2 border-slate-700">
                        <a href="/informasi-publik" class="text-slate-300 hover:text-white text-sm transition-colors">Daftar Informasi Publik</a>
                        <a href="/informasi-setiap-saat" class="text-slate-300 hover:text-white text-sm transition-colors">Informasi Tersedia Setiap Saat</a>
                        <a href="/informasi-berkala" class="text-slate-300 hover:text-white text-sm transition-colors">Informasi Tersedia Secara Berkala</a>
                        <a href="/informasi-serta-merta" class="text-slate-300 hover:text-white text-sm transition-colors">Informasi Diumumkan Serta Merta</a>
                    </div>
                </div>

                <div class="py-1">
                    <button onclick="toggleMobileDropdown('dropdown-layanan', 'icon-layanan')" class="w-full flex items-center justify-between text-white font-medium transition-colors">
                        Layanan Informasi
                        <i id="icon-layanan" class="fa-solid fa-chevron-right text-xs transition-transform duration-300"></i>
                    </button>
                    <div id="dropdown-layanan" class="hidden flex flex-col pl-4 mt-3 space-y-3 border-l-2 border-slate-700">
                        <a href="{{ route('prosedur.permohonan') }}" class="text-slate-300 hover:text-white text-sm transition-colors {{ request()->is('prosedur-permohonan*') ? 'text-white font-bold' : '' }}">Prosedur Permohonan Informasi</a>
                        <a href="{{ route('layanan.index') }}?type=permohonan" class="text-slate-300 hover:text-white text-sm transition-colors">Formulir Permohonan Informasi</a>
                        <a href="{{ route('layanan.index') }}?type=keberatan" class="text-slate-300 hover:text-white text-sm transition-colors">Formulir Pengajuan Keberatan</a>
                    </div>
                </div>

                <a href="https://fmipa.unila.ac.id/berita" target="_blank" class="text-white font-medium py-1">Berita</a>
                <a href="/statistik" class="text-white font-medium py-1">Statistik</a>

                <div class="pt-4 border-t border-slate-800">
                    @auth
                        <div class="py-1">
                            <button onclick="toggleMobileDropdown('dropdown-user-account', 'icon-user-account')" class="w-full flex items-center justify-between text-white font-extrabold text-base transition-colors py-1">
                                <span class="truncate pr-2">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</span>
                                <i id="icon-user-account" class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                            </button>
                            <div id="dropdown-user-account" class="hidden mt-3 bg-white shadow-xl rounded-none border border-slate-100 overflow-hidden">
                                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('layanan.index') }}"
                                   class="block px-6 py-3.5 text-sm font-semibold text-slate-800 hover:bg-slate-50 transition-all">
                                    Dashboard
                                </a>
                                <div class="border-t border-slate-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-6 py-3.5 text-sm font-semibold text-red-600 hover:bg-red-50 transition-all cursor-pointer">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="flex items-center justify-center w-full px-6 py-3 bg-[#1B365D] hover:bg-[#162c4c] text-white text-sm font-bold uppercase tracking-wider transition-all shadow-md" style="border-radius: 12px !important;">
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

            navbar.classList.remove('bg-transparent', 'border-transparent', 'bg-[#1B365D]');
            navbar.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'border-slate-200');

            if (logoText1) {
                logoText1.classList.remove('text-white');
                logoText1.classList.add('text-slate-900');
            }
            if (logoText2) {
                logoText2.classList.remove('text-white');
                logoText2.classList.add('text-[#1B365D]');
            }

            if (authBtn) {
                authBtn.classList.remove('bg-transparent', 'text-slate-800', 'border-slate-300', 'border-white/30', 'hover:bg-white/10', 'hover:bg-slate-100');
                authBtn.classList.add('bg-[#1B365D]', 'text-white', 'border-white', 'hover:bg-[#152a4a]');
            }
            if (authText) {
                authText.classList.remove('text-white', 'hover:text-cyan-200');
                authText.classList.add('text-slate-800');
            }
            if (mobileBtn) {
                mobileBtn.classList.remove('text-white');
                mobileBtn.classList.add('text-slate-800');
            }

            links.forEach(link => {
                link.classList.remove('text-white', 'after:bg-white', 'hover:text-cyan-200');
                link.classList.add('text-slate-800', 'after:bg-[#1B365D]', 'hover:text-[#1B365D]');
            });

        } else {
            header.style.transform = 'translateY(0)';

            if (isHome) {
                navbar.classList.remove('bg-[#1B365D]', 'bg-white/95', 'backdrop-blur-md', 'shadow-md', 'border-slate-200');
                navbar.classList.add('bg-transparent', 'border-transparent');

                if (logoText1) {
                    logoText1.classList.remove('text-slate-900');
                    logoText1.classList.add('text-white');
                }
                if (logoText2) {
                    logoText2.classList.remove('text-[#1B365D]');
                    logoText2.classList.add('text-white');
                }

                if (authBtn) {
                    authBtn.classList.remove('bg-[#1B365D]', 'text-slate-800', 'border-slate-300', 'hover:bg-slate-100', 'hover:bg-[#152a4a]');
                    authBtn.classList.add('bg-transparent', 'text-white', 'border-white', 'hover:bg-white/10');
                }
                if (authText) {
                    authText.classList.remove('text-slate-800', 'hover:text-[#1B365D]');
                    authText.classList.add('text-white');
                }
                if (mobileBtn) {
                    mobileBtn.classList.remove('text-slate-800');
                    mobileBtn.classList.add('text-white');
                }

                links.forEach(link => {
                    link.classList.remove('text-slate-800', 'after:bg-[#1B365D]', 'hover:text-[#1B365D]', 'hover:text-cyan-200');
                    link.classList.add('text-white', 'after:bg-white');
                });
            } else {
                navbar.classList.remove('bg-transparent', 'border-transparent', 'bg-[#1B365D]');
                navbar.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-md', 'border-slate-200');

                if (logoText1) {
                    logoText1.classList.remove('text-white');
                    logoText1.classList.add('text-slate-900');
                }
                if (logoText2) {
                    logoText2.classList.remove('text-white');
                    logoText2.classList.add('text-[#1B365D]');
                }

                if (authBtn) {
                    authBtn.classList.remove('bg-transparent', 'text-slate-800', 'border-slate-300', 'border-white/30', 'hover:bg-white/10', 'hover:bg-slate-100');
                    authBtn.classList.add('bg-[#1B365D]', 'text-white', 'border-white', 'hover:bg-[#152a4a]');
                }
                if (authText) {
                    authText.classList.remove('text-white', 'hover:text-cyan-200');
                    authText.classList.add('text-slate-800');
                }
                if (mobileBtn) {
                    mobileBtn.classList.remove('text-white');
                    mobileBtn.classList.add('text-slate-800');
                }

                links.forEach(link => {
                    link.classList.remove('text-white', 'after:bg-white', 'hover:text-cyan-200');
                    link.classList.add('text-slate-800', 'after:bg-[#1B365D]', 'hover:text-[#1B365D]');
                });
            }
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
