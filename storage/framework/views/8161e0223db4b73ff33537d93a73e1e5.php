<div id="main-header" class="fixed top-0 left-0 w-full z-[999] transition-transform duration-300 ease-out translate-y-0">
    <?php if(request()->is('/')): ?>
        <div id="homepage-header-banner" class="relative w-full h-16 md:h-20 bg-white flex justify-center items-center border-b border-slate-100">
            <img src="<?php echo e(asset('images/header_logo.png')); ?>?v=2.0" class="h-10 md:h-14 w-auto object-contain" alt="Header Logo">
        </div>
    <?php endif; ?>

    <nav id="main-navbar" class="w-full bg-sky-500 border-b-0 shadow-md transition-all duration-300">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 md:py-3.5">
            <div class="flex justify-between items-center">
                <!-- Left: Logo -->
                <a href="/" class="flex items-center shrink-0 gap-3 group">
                    <img id="navbar-logo" src="<?php echo e(asset('images/logoPPID.png')); ?>?v=2.0" alt="Logo Unila" class="h-8 md:h-10 w-auto object-contain">
                    <div class="text-left leading-tight hidden sm:block">
                        <span id="navbar-logo-text1" class="block text-white font-extrabold text-sm md:text-base tracking-wide">PPID FMIPA</span>
                        <span id="navbar-logo-text2" class="block text-sky-100 font-semibold text-[10px] md:text-[11px] tracking-wide uppercase">Universitas Lampung</span>
                    </div>
                </a>

                <!-- Right: Navigation Links (Rata Kanan & Ukuran Teks Jauh Lebih Besar) -->
                <div id="desktop-menu" class="hidden md:flex items-center justify-end flex-1">
                    <?php if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*')): ?>
                        <div class="flex items-center gap-8 lg:gap-12">
                            <!-- 1. Beranda -->
                            <?php
                                $isHome = request()->is('/');
                            ?>
                            <a href="/" 
                               class="group relative py-2 text-base lg:text-lg tracking-wide transition-all duration-200 flex flex-col items-center
                                      <?php echo e($isHome ? 'text-white font-extrabold' : 'text-white/90 hover:text-white font-bold'); ?>">
                                <span>Beranda</span>
                                <!-- Garis Bawah Aktif / Hover -->
                                <span class="absolute bottom-0 h-1 rounded-full transition-all duration-200
                                             <?php echo e($isHome ? 'w-full bg-white shadow-xs' : 'w-0 group-hover:w-full bg-white/80'); ?>"></span>
                            </a>

                            <!-- 2. Dropdown Menu Klasifikasi Informasi -->
                            <?php
                                $isInfo = request()->is('informasi-publik*');
                            ?>
                            <div class="relative" 
                                 x-data="{ openInfo: false }" 
                                 @mouseenter="openInfo = true" 
                                 @mouseleave="openInfo = false" 
                                 @click.outside="openInfo = false">
                                <button type="button" 
                                    @click="openInfo = !openInfo"
                                    class="group relative py-2 text-base lg:text-lg tracking-wide transition-all duration-200 flex items-center gap-2 cursor-pointer
                                           <?php echo e($isInfo ? 'text-white font-extrabold' : 'text-white/90 hover:text-white font-bold'); ?>">
                                    <span>Klasifikasi Informasi</span>
                                    <i class="fa-solid fa-chevron-down text-xs ml-0.5 opacity-80 transition-transform duration-200" :class="{ 'rotate-180': openInfo }"></i>
                                    <!-- Garis Bawah Aktif / Hover -->
                                    <span class="absolute bottom-0 left-0 h-1 rounded-full transition-all duration-200
                                                 <?php echo e($isInfo ? 'w-full bg-white shadow-xs' : 'w-0 group-hover:w-full bg-white/80'); ?>"></span>
                                </button>

                                <div x-show="openInfo" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-1"
                                     class="absolute right-0 top-full pt-2 w-72 z-[9999]"
                                     style="display: none;">
                                    <div class="bg-white border border-slate-200/90 shadow-2xl shadow-slate-900/15 rounded-2xl p-2 text-slate-800 ring-1 ring-black/5">
                                        <!-- 1. Daftar Informasi Publik -->
                                        <a href="<?php echo e(url('/informasi-publik')); ?>" 
                                           @click="openInfo = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <span class="block text-base font-bold leading-tight">Daftar Informasi Publik</span>
                                        </a>

                                        <div class="my-1 border-t border-slate-100"></div>

                                        <!-- 2. Informasi Tersedia Secara Berkala -->
                                        <a href="<?php echo e(url('/informasi-publik/kategori/berkala')); ?>" 
                                           @click="openInfo = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <span class="block text-base font-bold leading-tight">Informasi Tersedia Secara Berkala</span>
                                        </a>

                                        <!-- 3. Informasi Diumumkan Serta Merta -->
                                        <a href="<?php echo e(url('/informasi-publik/kategori/serta-merta')); ?>" 
                                           @click="openInfo = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <span class="block text-base font-bold leading-tight">Informasi Diumumkan Serta-Merta</span>
                                        </a>

                                        <!-- 4. Informasi Tersedia Setiap Saat -->
                                        <a href="<?php echo e(url('/informasi-publik/kategori/setiap-saat')); ?>" 
                                           @click="openInfo = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <span class="block text-base font-bold leading-tight">Informasi Tersedia Setiap Saat</span>
                                        </a>

                                        <div class="my-1 border-t border-slate-100"></div>

                                        <!-- 5. Daftar Informasi Publik yang Dikecualikan -->
                                        <a href="<?php echo e(url('/informasi-dikecualikan')); ?>" 
                                           @click="openInfo = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <span class="block text-base font-bold leading-tight">Daftar Informasi Publik yang Dikecualikan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 3. Dropdown Menu Standar Layanan -->
                            <?php
                                $isLayanan = request()->is('layanan*') || request()->is('permohonan*') || request()->is('keberatan*') || request()->is('pengajuan-keberatan*') || request()->is('riwayat-layanan*') || request()->is('prosedur-permohonan*');
                            ?>
                            <div class="relative" 
                                 x-data="{ open: false }" 
                                 @mouseenter="open = true" 
                                 @mouseleave="open = false" 
                                 @click.outside="open = false">
                                <button type="button" 
                                    @click="open = !open"
                                    class="group relative py-2 text-base lg:text-lg tracking-wide transition-all duration-200 flex items-center gap-2 cursor-pointer
                                           <?php echo e($isLayanan ? 'text-white font-extrabold' : 'text-white/90 hover:text-white font-bold'); ?>">
                                    <span>Standar Layanan</span>
                                    <i class="fa-solid fa-chevron-down text-xs ml-0.5 opacity-80 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                    <!-- Garis Bawah Aktif / Hover -->
                                    <span class="absolute bottom-0 left-0 h-1 rounded-full transition-all duration-200
                                                 <?php echo e($isLayanan ? 'w-full bg-white shadow-xs' : 'w-0 group-hover:w-full bg-white/80'); ?>"></span>
                                </button>

                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-1"
                                     class="absolute right-0 top-full pt-2 w-72 z-[9999]"
                                     style="display: none;">
                                    <div class="bg-white border border-slate-200/90 shadow-2xl shadow-slate-900/15 rounded-2xl p-2 text-slate-800 ring-1 ring-black/5">
                                        <a href="<?php echo e(url('/#statistik-layanan')); ?>" 
                                           @click="open = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <span class="block text-base font-bold leading-tight">Statistik Layanan</span>
                                        </a>

                                        <a href="<?php echo e(url('/#alur-layanan')); ?>" 
                                           @click="open = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <span class="block text-base font-bold leading-tight">Alur Layanan</span>
                                        </a>

                                        <div class="my-1 border-t border-slate-100"></div>

                                        <a href="<?php echo e(url('/permohonan')); ?>" 
                                           @click="open = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item <?php echo e(request()->is('permohonan*') ? 'bg-sky-50 text-sky-600 font-bold' : ''); ?>">
                                            <span class="block text-base font-bold leading-tight">Permohonan Informasi</span>
                                        </a>

                                        <a href="<?php echo e(url('/pengajuan-keberatan')); ?>" 
                                           @click="open = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item <?php echo e(request()->is('pengajuan-keberatan*') ? 'bg-sky-50 text-sky-600 font-bold' : ''); ?>">
                                            <span class="block text-base font-bold leading-tight">Pengajuan Keberatan</span>
                                        </a>

                                        <a href="<?php echo e(url('/riwayat-layanan')); ?>" 
                                           @click="open = false"
                                           class="block px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item <?php echo e(request()->is('riwayat-layanan*') ? 'bg-sky-50 text-sky-600 font-bold' : ''); ?>">
                                            <span class="block text-base font-bold leading-tight">Lacak & Riwayat Layanan</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php if(auth()->guard()->check()): ?>
                                <!-- Admin User Profile / Logout (Hanya Tampil Jika Sedang Login Admin) -->
                                <div class="relative group ml-2">
                                    <div class="w-9 h-9 bg-white/20 hover:bg-white/30 text-white rounded-full flex items-center justify-center text-sm transition-all cursor-pointer shadow-xs border border-white/20">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="absolute right-0 top-full pt-3 w-48 hidden group-hover:block transition-all duration-300 z-[9999]">
                                        <div class="bg-white border border-slate-100 shadow-xl py-2 rounded-xl overflow-hidden">
                                            <a href="<?php echo e((Auth::user()->role ?? '') === 'admin' ? url('/admin/informasi-publik') : url('/')); ?>"
                                                class="flex items-center gap-3 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:text-[#1B365D] hover:bg-slate-50 transition-all duration-200">
                                                <i class="fa-solid fa-gauge-high text-xs opacity-70 w-4 text-center"></i> Dashboard Admin
                                            </a>
                                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="flex items-center gap-3 w-full text-left px-5 py-2.5 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 transition-all duration-200 cursor-pointer">
                                                    <i class="fa-solid fa-right-from-bracket text-xs opacity-70 w-4 text-center"></i> Keluar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
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
                <?php if(!request()->is('login*') && !request()->is('register*') && !request()->is('password*') && !request()->is('forgot-password') && !request()->is('reset-password*')): ?>
                    <a href="/" class="text-white font-semibold py-3 border-b border-white/10">Beranda</a>

                    <!-- Accordion Submenu Klasifikasi Informasi (Mobile) -->
                    <div class="border-b border-white/10 py-2">
                        <span class="text-xs font-bold text-sky-200 uppercase tracking-wider block mb-2">Klasifikasi Informasi:</span>
                        <div class="pl-3 space-y-2">
                            <a href="<?php echo e(url('/informasi-publik')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-table-list text-xs text-sky-300 w-4"></i>
                                <span>Daftar Informasi Publik</span>
                            </a>
                            <a href="<?php echo e(url('/informasi-publik/kategori/berkala')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-clock-rotate-left text-xs text-emerald-300 w-4"></i>
                                <span>Informasi Tersedia Secara Berkala</span>
                            </a>
                            <a href="<?php echo e(url('/informasi-publik/kategori/serta-merta')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-triangle-exclamation text-xs text-amber-300 w-4"></i>
                                <span>Informasi Diumumkan Serta-Merta</span>
                            </a>
                            <a href="<?php echo e(url('/informasi-publik/kategori/setiap-saat')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-folder-open text-xs text-sky-300 w-4"></i>
                                <span>Informasi Tersedia Setiap Saat</span>
                            </a>
                            <a href="<?php echo e(url('/informasi-dikecualikan')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-lock text-xs text-sky-300 w-4"></i>
                                <span>Daftar Informasi Publik yang Dikecualikan</span>
                            </a>
                        </div>
                    </div>

                    <!-- Accordion Submenu Standar Layanan (Mobile) -->
                    <div class="border-b border-white/10 py-2">
                        <span class="text-xs font-bold text-sky-200 uppercase tracking-wider block mb-2">Standar Layanan PPID:</span>
                        <div class="pl-3 space-y-2">
                            <a href="<?php echo e(url('/#statistik-layanan')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-chart-simple text-xs text-sky-300 w-4"></i>
                                <span>Statistik Layanan</span>
                            </a>
                            <a href="<?php echo e(url('/#alur-layanan')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-route text-xs text-sky-300 w-4"></i>
                                <span>Alur Layanan</span>
                            </a>
                            <div class="my-1 border-t border-white/10"></div>
                            <a href="<?php echo e(url('/permohonan')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-file-signature text-xs text-blue-300 w-4"></i>
                                <span>Permohonan Informasi</span>
                            </a>
                            <a href="<?php echo e(url('/pengajuan-keberatan')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-scale-balanced text-xs text-amber-300 w-4"></i>
                                <span>Pengajuan Keberatan</span>
                            </a>
                            <a href="<?php echo e(url('/riwayat-layanan')); ?>" class="flex items-center gap-2.5 text-white text-sm py-1.5 font-medium hover:text-sky-100">
                                <i class="fa-solid fa-clock-rotate-left text-xs text-emerald-300 w-4"></i>
                                <span>Lacak & Riwayat Layanan</span>
                            </a>
                        </div>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                        <div class="pt-4">
                            <div class="space-y-3">
                                <a href="<?php echo e((Auth::user()->role ?? '') === 'admin' ? url('/admin/informasi-publik') : url('/login')); ?>"
                                   class="flex items-center gap-3 text-white font-semibold py-2 transition-colors">
                                    <i class="fa-solid fa-gauge-high text-sky-200 text-sm w-5 text-center"></i>
                                    <span>Dashboard Admin</span>
                                </a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="flex items-center gap-3 w-full text-left text-red-200 hover:text-red-100 font-semibold py-2 transition-colors cursor-pointer">
                                        <i class="fa-solid fa-right-from-bracket text-red-200 text-sm w-5 text-center"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="/" class="text-white font-semibold py-3 inline-flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left text-sm"></i> Kembali ke Beranda
                    </a>
                <?php endif; ?>
            </div>
        </div>
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
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/ui/navbar.blade.php ENDPATH**/ ?>