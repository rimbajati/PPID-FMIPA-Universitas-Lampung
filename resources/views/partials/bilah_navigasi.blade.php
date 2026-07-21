<div id="main-header" class="fixed top-0 left-0 w-full z-[999] transition-transform duration-300 ease-out translate-y-0">
    @if(request()->is('/'))
        <div id="homepage-header-banner" class="relative w-full h-[64px] md:h-[80px] bg-white flex justify-center items-center border-b border-slate-100">
            <img src="{{ asset('images/header_logo.png') }}" class="h-10 md:h-14 w-auto object-contain" alt="Header Logo">
        </div>
    @endif

    <nav id="main-navbar" class="w-full transition-all duration-300 border-b border-transparent">
    <div id="navbar-container" class="w-full px-6 md:px-16 lg:px-24 py-3 transition-all duration-300">
        <div class="flex justify-between items-center">

            <a href="/" class="flex items-center shrink-0 w-56">
                <img id="navbar-logo" src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 md:h-12 w-auto object-contain transition-all duration-300">
            </a>

            <div id="desktop-menu" class="hidden md:flex items-center justify-center flex-1 gap-8 lg:gap-10">
                @if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*'))
                    @php
                        $baseClass = "nav-link relative text-base font-bold transition-all duration-300 after:content-[''] after:absolute after:left-0 after:-bottom-2 after:h-[2.5px] after:transition-all after:duration-300 hover:after:w-full";
                    @endphp

                    <a href="/" class="{{ $baseClass }} {{ request()->is('/') ? 'after:w-full' : 'after:w-0' }}">Beranda</a>

                    <div class="relative group">
                        <button class="flex items-center gap-1 {{ $baseClass }} {{ request()->is('informasi-publik*') || request()->is('informasi-setiap-saat*') ? 'after:w-full' : 'after:w-0' }}">
                            Informasi Publik
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="absolute left-0 pt-3 w-72 hidden group-hover:block z-[9999]">
                            <div class="bg-white border border-slate-100 shadow-xl py-2 rounded-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                                @php
                                    $menuItems = [
                                        ['url' => '/informasi-publik', 'label' => 'Daftar Informasi Publik'],
                                        ['url' => '/informasi-setiap-saat', 'label' => 'Informasi Tersedia Setiap Saat'],
                                        ['url' => '/informasi-berkala', 'label' => 'Informasi Tersedia Secara Berkala'],
                                        ['url' => '/informasi-serta-merta', 'label' => 'Informasi Diumumkan Serta Merta'],
                                    ];
                                @endphp

                                @foreach($menuItems as $item)
                                    <a href="{{ $item['url'] }}"
                                    class="block px-6 py-3 text-sm font-semibold text-slate-700 hover:text-white hover:bg-[#1B365D] transition-all duration-200">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <button class="flex items-center gap-1 {{ $baseClass }} {{ request()->is('layanan*') || request()->is('prosedur-permohonan*') ? 'after:w-full' : 'after:w-0' }}">
                            Layanan Informasi
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div class="absolute left-0 pt-3 w-72 hidden group-hover:block z-[9999]">
                            <div class="bg-white border border-slate-100 shadow-xl py-2 rounded-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                                @php
                                    $menuLayanan = [
                                        ['url' => route('prosedur.permohonan'), 'label' => 'Prosedur Permohonan Informasi'],
                                        ['url' => route('layanan.index') . '?type=permohonan', 'label' => 'Formulir Permohonan Informasi'],
                                        ['url' => route('layanan.index') . '?type=keberatan', 'label' => 'Formulir Pengajuan Keberatan'],
                                    ];
                                @endphp

                                @foreach($menuLayanan as $item)
                                    <a href="{{ $item['url'] }}"
                                    class="block px-6 py-3 text-sm font-semibold text-slate-700 hover:text-white hover:bg-[#1B365D] transition-all duration-200">
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
                        <div class="relative ml-2">
                            <button id="profile-btn" type="button" class="nav-auth-text flex items-center gap-2 text-base font-semibold text-white transition-all focus:outline-none cursor-pointer whitespace-nowrap">
                                <span class="truncate max-w-[220px] inline-block">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] shrink-0"></i>
                            </button>
                            <div id="profile-dropdown" class="absolute right-0 top-full mt-2 w-56 bg-white border border-slate-100 shadow-xl py-2 rounded-2xl hidden z-[9999]">
                                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('layanan.index') }}"
                                    class="block px-6 py-3 text-sm font-medium text-slate-700 hover:text-white hover:bg-[#07597b] rounded-md transition-all duration-200">
                                    Dashboard
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-6 py-3 text-sm font-medium text-red-600 hover:text-white hover:bg-red-500 rounded-md transition-all duration-200">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="nav-auth-btn ml-4 px-8 py-2.5 bg-transparent border border-white/30 text-white text-sm font-bold uppercase tracking-wider transition-all shadow-sm hover:bg-white/10 rounded-3xl whitespace-nowrap">MASUK</a>
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-slate-900 border-t border-slate-800 px-6 py-4 transition-all">
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
            @else
                <a href="/" class="text-white font-medium py-1 inline-flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i> Kembali ke Beranda
                </a>
            @endif

            <div class="border-t border-slate-800 pt-3">
                @auth
                    <a href="{{ route('layanan.index') }}" class="block text-white font-medium py-1">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 font-medium py-1">Keluar</button>
                    </form>
                @else
                    <a href="/login" class="block w-full text-center py-2.5 bg-[#1B365D] hover:bg-[#1B365D] text-white font-bold rounded shadow transition-all">MASUK</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.getElementById('main-navbar');
        const mainHeader = document.getElementById('main-header');
        const navLogo = document.getElementById('navbar-logo');
        const navLinks = document.querySelectorAll('.nav-link');
        const navAuthBtn = document.querySelector('.nav-auth-btn');
        const navAuthText = document.querySelector('.nav-auth-text');
        const profileBtn = document.getElementById('profile-btn');
        const profileDropdown = document.getElementById('profile-dropdown');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        const authRoutes = ['login', 'register', 'password', 'forgot-password', 'reset-password'];
        const isAuthPage = authRoutes.some(route => window.location.pathname.includes(route));
        const isHome = document.body.classList.contains('is-home');

        function setNavbarStyle(isWhite) {
            if (isWhite) {
                navbar.classList.add('bg-white', 'shadow-md', 'border-gray-200');
                if (navLogo) navLogo.style.filter = 'none';
                if (mobileMenuBtn) {
                    mobileMenuBtn.classList.remove('text-white');
                    mobileMenuBtn.classList.add('text-gray-800');
                }
                navLinks.forEach(link => {
                    link.classList.remove('text-white', 'after:bg-white');
                    link.classList.add('text-gray-800', 'after:bg-[#1B365D]');
                });
                if (navAuthBtn) {
                    navAuthBtn.classList.remove('bg-transparent', 'border-white/30', 'text-white', 'hover:bg-white/10');
                    navAuthBtn.classList.add('bg-[#1B365D]', 'text-white', 'hover:bg-[#1B365D]');
                }
                if (navAuthText) {
                    navAuthText.classList.remove('text-white');
                    navAuthText.classList.add('text-gray-800');
                }
            } else {
                navbar.classList.remove('bg-white', 'shadow-md', 'border-gray-200');
                if (navLogo) navLogo.style.filter = 'drop-shadow(0px 0px 5px rgba(255, 255, 255, 0.95)) drop-shadow(0px 0px 2px rgba(255, 255, 255, 0.9))';
                if (mobileMenuBtn) {
                    mobileMenuBtn.classList.add('text-white');
                    mobileMenuBtn.classList.remove('text-gray-800');
                }
                navLinks.forEach(link => {
                    link.classList.add('text-white', 'after:bg-white');
                    link.classList.remove('text-gray-800', 'after:bg-[#1B365D]');
                });
                if (navAuthBtn) {
                    navAuthBtn.classList.add('bg-transparent', 'border-white/30', 'text-white', 'hover:bg-white/10');
                    navAuthBtn.classList.remove('bg-[#1B365D]', 'hover:bg-[#1B365D]');
                }
                if (navAuthText) {
                    navAuthText.classList.remove('text-gray-800');
                    navAuthText.classList.add('text-white');
                }
            }
        }

        if (!isHome || isAuthPage) {
            setNavbarStyle(true);
        } else {
            setNavbarStyle(false);
            const scrolled = window.scrollY > 40;
            if (scrolled) {
                mainHeader.classList.remove('translate-y-0');
                mainHeader.classList.add('-translate-y-[64px]', 'md:-translate-y-[80px]');
            } else {
                mainHeader.classList.remove('-translate-y-[64px]', 'md:-translate-y-[80px]');
                mainHeader.classList.add('translate-y-0');
            }
        }

        window.addEventListener('scroll', function () {
            if (isHome && !isAuthPage) {
                const scrolled = window.scrollY > 40;
                setNavbarStyle(scrolled);
                if (scrolled) {
                    mainHeader.classList.remove('translate-y-0');
                    mainHeader.classList.add('-translate-y-[64px]', 'md:-translate-y-[80px]');
                } else {
                    mainHeader.classList.remove('-translate-y-[64px]', 'md:-translate-y-[80px]');
                    mainHeader.classList.add('translate-y-0');
                }
            }
        });

        if (profileBtn) {
            profileBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (profileDropdown) profileDropdown.classList.toggle('hidden');
            });
            document.addEventListener('click', function (e) {
                if (profileDropdown && !profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });
        }

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', function (e) {
                if (!navbar.contains(e.target) && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    });

    function toggleMobileDropdown(dropdownId, iconId) {
        const dropdown = document.getElementById(dropdownId);
        const icon = document.getElementById(iconId);

        if (dropdown && icon) {
            dropdown.classList.toggle('hidden');
            icon.classList.toggle('rotate-90');
        }
    }
</script>

