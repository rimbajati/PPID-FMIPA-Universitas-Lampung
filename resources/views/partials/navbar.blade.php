<nav id="main-navbar" class="fixed top-0 left-0 w-full z-[999] transition-all duration-300 border-b border-transparent">
    <div id="navbar-container" class="w-full px-6 md:px-16 lg:px-24 py-3 transition-all duration-300">
        <div class="flex justify-between items-center">

            <a href="/" class="flex items-center shrink-0 w-48">
                <img id="navbar-logo" src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 md:h-12 w-auto object-contain brightness-0 invert transition-all duration-300">
            </a>

            <div id="desktop-menu" class="hidden md:flex items-center justify-center flex-1 gap-8 lg:gap-10">
                @if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*'))
                    @php
                        $baseClass = "nav-link relative text-base font-medium transition-all duration-300 after:content-[''] after:absolute after:left-0 after:-bottom-2 after:h-[2px] after:transition-all after:duration-300 hover:after:w-full";
                    @endphp
                    <a href="/" class="{{ $baseClass }} {{ request()->is('/') ? 'after:w-full' : 'after:w-0' }}">Beranda</a>
                    <a href="/informasi-publik" class="{{ $baseClass }} {{ request()->is('informasi-publik*') ? 'after:w-full' : 'after:w-0' }}">Informasi Publik</a>
                    <a href="https://fmipa.unila.ac.id/berita" target="_blank" class="{{ $baseClass }} after:w-0">Berita</a>
                    <a href="/statistik" class="{{ $baseClass }} {{ request()->is('statistik*') ? 'after:w-full' : 'after:w-0' }}">Statistik</a>
                @endif
            </div>

            <button id="mobile-menu-btn" type="button" class="md:hidden text-white text-2xl focus:outline-none transition-colors">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="hidden md:flex items-center justify-end shrink-0 w-auto">
                @if(request()->is('login*') || request()->is('register*') || request()->is('password*') || request()->is('forgot-password') || request()->is('reset-password*'))
                    <a href="/" class="inline-flex items-center gap-2 text-base font-semibold text-gray-700 hover:text-blue-900 transition-all nav-auth-text whitespace-nowrap">
                        <span class="hidden md:inline">Kembali ke Beranda</span> <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                @else
                    @auth
                        <div class="relative ml-2">
                            <button id="profile-btn" type="button" class="nav-auth-text flex items-center gap-2 text-base font-semibold text-white transition-all focus:outline-none cursor-pointer whitespace-nowrap">
                                <span class="truncate max-w-[220px] inline-block">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] shrink-0"></i>
                            </button>
                            <div id="profile-dropdown" class="absolute right-0 top-full mt-2 w-56 bg-white border border-slate-100 shadow-xl py-2 rounded-3xl hidden z-[9999]">
                                <a href="{{ url('/riwayat-layanan') }}" class="block px-6 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                    Dashboard
                                </a>

                                <div class="border-t border-slate-100 my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-6 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
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

    <div id="mobile-menu" class="md:hidden hidden bg-slate-900 border-t border-slate-800 px-6 py-4 transition-all">
        <div class="flex flex-col space-y-4">
            @if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*'))
                <a href="/" class="text-white hover:text-blue-400 font-medium py-1">Beranda</a>
                <a href="/informasi-publik" class="text-white hover:text-blue-400 font-medium py-1">Informasi Publik</a>
                <a href="https://fmipa.unila.ac.id/berita" target="_blank" class="text-white hover:text-blue-400 font-medium py-1">Berita</a>
                <a href="https://fmipa.unila.ac.id/statistik" target="_blank" class="text-white hover:text-blue-400 font-medium py-1">Statistik</a>
            @else
                <a href="/" class="text-white hover:text-blue-400 font-medium py-1 inline-flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-sm"></i> Kembali ke Beranda
                </a>
            @endif

            <div class="border-t border-slate-800 pt-3">
                @auth
                    <!-- <div class="text-slate-400 text-sm mb-2 truncate">Login sebagai: {{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</div> -->
                    <a href="{{ url('/riwayat-layanan') }}" class="block text-white hover:text-blue-400 font-medium py-1">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-400 hover:text-red-300 font-medium py-1">Keluar</button>
                    </form>
                @else
                    <a href="/login" class="block w-full text-center py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded shadow transition-all">MASUK</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.getElementById('main-navbar');
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
                if (navLogo) navLogo.classList.remove('brightness-0', 'invert');
                if (mobileMenuBtn) {
                    mobileMenuBtn.classList.remove('text-white');
                    mobileMenuBtn.classList.add('text-gray-800');
                }
                navLinks.forEach(link => {
                    link.classList.remove('text-white', 'after:bg-white');
                    link.classList.add('text-gray-800', 'after:bg-blue-900');
                });
                if (navAuthBtn) {
                    navAuthBtn.classList.remove('bg-transparent', 'border-white/30', 'text-white', 'hover:bg-white/10');
                    navAuthBtn.classList.add('bg-[#0f172a]', 'text-white', 'hover:bg-black');
                }
                if (navAuthText) {
                    navAuthText.classList.remove('text-white');
                    navAuthText.classList.add('text-gray-800');
                }
            } else {
                navbar.classList.remove('bg-white', 'shadow-md', 'border-gray-200');
                if (navLogo) navLogo.classList.add('brightness-0', 'invert');
                if (mobileMenuBtn) {
                    mobileMenuBtn.classList.add('text-white');
                    mobileMenuBtn.classList.remove('text-gray-800');
                }
                navLinks.forEach(link => {
                    link.classList.add('text-white', 'after:bg-white');
                    link.classList.remove('text-gray-800', 'after:bg-blue-900');
                });
                if (navAuthBtn) {
                    navAuthBtn.classList.add('bg-transparent', 'border-white/30', 'text-white', 'hover:bg-white/10');
                    navAuthBtn.classList.remove('bg-[#0f172a]', 'hover:bg-black');
                }
                if (navAuthText) {
                    navAuthText.classList.remove('text-gray-800');
                    navAuthText.classList.add('text-white');
                }
            }
        }

        if (!isHome || isAuthPage) setNavbarStyle(true);
        else setNavbarStyle(false);

        window.addEventListener('scroll', function () {
            if (isHome && !isAuthPage) setNavbarStyle(window.scrollY > 40);
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
</script>
