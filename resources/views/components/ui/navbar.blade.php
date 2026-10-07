<div id="main-header" class="fixed top-0 left-0 w-full z-[999] transition-transform duration-300 ease-out translate-y-0">
    @if(request()->is('/'))
        <div id="homepage-header-banner" class="relative w-full h-16 md:h-20 bg-white flex justify-center items-center border-b border-slate-100">
            <img src="{{ asset('images/header_logo.png') }}?v=2.0" class="h-10 md:h-14 w-auto object-contain" alt="Header Logo">
        </div>
    @endif

    <nav id="main-navbar" class="w-full bg-sky-500 border-b-0 shadow-md transition-all duration-300">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-3.5">
            <div class="flex justify-between items-center">
                <!-- Left: Logo -->
                <a href="/" class="flex items-center shrink-0 gap-3 group">
                    <img id="navbar-logo" src="{{ asset('images/logoPPID.png') }}?v=2.0" alt="Logo Unila" class="h-8 md:h-10 w-auto object-contain">
                    <div class="text-left leading-tight">
                        <span id="navbar-logo-text1" class="block text-white font-extrabold text-sm md:text-base tracking-wide uppercase">PPID Pelaksana</span>
                        <span id="navbar-logo-text2" class="block text-sky-100 font-semibold text-[10px] md:text-[11px] tracking-wide uppercase">FMIPA Universitas Lampung</span>
                    </div>
                </a>

                <!-- Right: Navigation Links (Rata Kanan & Ukuran Teks Jauh Lebih Besar) -->
                @include('components.ui.navbar.desktop-menu')

                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" type="button" class="md:hidden text-white text-2xl focus:outline-none transition-colors ml-4">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        @include('components.ui.navbar.mobile-menu')
    </nav>
</div>

<script>
    function updateNavbarStyle() {
        const header = document.getElementById('main-header');
        if (!header) return;

        const banner = document.getElementById('homepage-header-banner');
        const scrollPosition = window.scrollY;

        if (banner) {
            const bannerHeight = banner.offsetHeight;
            if (scrollPosition > bannerHeight) {
                header.style.transform = `translateY(-${bannerHeight}px)`;
            } else {
                header.style.transform = `translateY(-${scrollPosition}px)`;
            }
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

