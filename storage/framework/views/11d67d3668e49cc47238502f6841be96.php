<!-- Sidebar Container Navigasi Admin -->
<aside id="sidebar" class="w-[19rem] bg-sky-600 border-r border-sky-700 text-white flex flex-col justify-between flex-shrink-0 h-full fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 lg:static transition-all duration-300 ease-in-out shadow-xs select-none">

    <!-- Brand top sidebar biru full sampai atas -->
    <a href="/" class="flex items-center gap-3 px-4 h-14 md:h-16 shrink-0 border-b border-sky-500 hover:bg-sky-500/50 transition">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo FMIPA Unila" class="h-9 w-auto shrink-0">
        <div class="text-left leading-tight min-w-0">
            <span class="block text-white font-extrabold text-[13px] tracking-tight truncate">PPID PELAKSANA</span>
            <span class="block text-sky-100 font-bold text-[10px] tracking-wider uppercase truncate">FMIPA UNIVERSITAS LAMPUNG</span>
        </div>
    </a>

    <?php
        $sidebarPendingPermohonan = \App\Models\Permohonan::whereIn('status', ['Diajukan', 'Diproses', 'Proses', 'Perlu Tindakan', 'Perlu Hasil Akhir'])->count();
        $sidebarPendingKeberatan  = \App\Models\Keberatan::whereIn('status', ['Diajukan', 'Diproses', 'Proses', 'Perlu Tindakan'])->count();
        $isDIPActive              = request()->is('admin/informasi-publik*') && !request()->filled('kategori');
        $isBerkalaActive          = request()->is('admin/informasi-publik*') && request('kategori') === 'Informasi Berkala';
        $isSertaMertaActive       = request()->is('admin/informasi-publik*') && request('kategori') === 'Informasi Serta-Merta';
        $isSetiapSaatActive       = request()->is('admin/informasi-publik*') && request('kategori') === 'Informasi Setiap Saat';
        $isDikecualikanActive     = request()->is('admin/informasi-dikecualikan*');
        $isProfilActive           = request()->is('admin/profil-ppid*') || request()->is('admin/profil-ppid-admin*') || request()->is('admin/beranda-konten*');
        $isFaqActive              = request()->is('admin/faq*');
        $isRegulasiActive         = request()->is('admin/regulasi-admin*');
        $isPermohonanActive       = request()->is('admin/permohonan*');
        $isKeberatanActive        = request()->is('admin/keberatan*');
        $isStatistikActive        = request()->is('admin/statistik*');
        $isTataCaraActive         = request()->is('admin/tata-cara-admin*');
        $isAnyDipActive           = $isDIPActive || $isBerkalaActive || $isSetiapSaatActive || $isSertaMertaActive || $isDikecualikanActive;
        $isAnyLayananActive       = $isPermohonanActive || $isKeberatanActive || $isStatistikActive || $isTataCaraActive;
        $sidebarPendingLayanan    = $sidebarPendingPermohonan + $sidebarPendingKeberatan;
    ?>

    <div class="flex-1 overflow-y-auto px-3.5 py-6 space-y-1" x-data="{ dipOpen: <?php echo e($isAnyDipActive ? 'true' : 'false'); ?>, layananOpen: <?php echo e($isAnyLayananActive ? 'true' : 'false'); ?> }">

        <!-- 1. Informasi Publik (dropdown) — header tidak tutup yang lain, isi yang tutup -->
        <div class="space-y-1">
            <button type="button" @click="dipOpen = !dipOpen"
                    class="w-full flex items-center justify-between rounded-xl transition-all duration-200 px-3.5 py-2.5 font-bold text-xs md:text-sm <?php echo e($isAnyDipActive ? 'text-white bg-sky-500' : 'text-white/90 hover:bg-sky-500 hover:text-white'); ?>">
                <span class="flex items-center gap-3 min-w-0">
                    <i class="fa-regular fa-folder-open text-base w-5 text-center shrink-0 <?php echo e($isAnyDipActive ? 'text-white' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Informasi Publik</span>
                </span>
                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 <?php echo e($isAnyDipActive ? 'text-white' : 'text-sky-200'); ?>" :class="{ 'rotate-180': dipOpen }"></i>
            </button>
            <div x-show="dipOpen"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-1"
                 class="pt-0.5 pb-1 space-y-0.5 pl-3 border-l-2 border-sky-400/50 ml-4" x-cloak>
                <a href="<?php echo e(url('/admin/informasi-publik')); ?>" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 <?php echo e($isDIPActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <i class="fa-solid fa-list text-xs w-4 text-center shrink-0 <?php echo e($isDIPActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Daftar Informasi Publik</span>
                </a>
                <a href="<?php echo e(url('/admin/informasi-publik?kategori=' . urlencode('Informasi Berkala'))); ?>" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 <?php echo e($isBerkalaActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <i class="fa-regular fa-clock text-xs w-4 text-center shrink-0 <?php echo e($isBerkalaActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Informasi Berkala</span>
                </a>
                <a href="<?php echo e(url('/admin/informasi-publik?kategori=' . urlencode('Informasi Setiap Saat'))); ?>" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 <?php echo e($isSetiapSaatActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <i class="fa-solid fa-arrows-rotate text-xs w-4 text-center shrink-0 <?php echo e($isSetiapSaatActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Informasi Setiap Saat</span>
                </a>
                <a href="<?php echo e(url('/admin/informasi-publik?kategori=' . urlencode('Informasi Serta-Merta'))); ?>" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 <?php echo e($isSertaMertaActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <i class="fa-solid fa-triangle-exclamation text-xs w-4 text-center shrink-0 <?php echo e($isSertaMertaActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Informasi Serta-Merta</span>
                </a>
                <a href="<?php echo e(url('/admin/informasi-dikecualikan')); ?>" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 <?php echo e($isDikecualikanActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <i class="fa-solid fa-lock text-xs w-4 text-center shrink-0 <?php echo e($isDikecualikanActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Informasi Dikecualikan</span>
                </a>
            </div>
        </div>

        <!-- 2. Layanan (dropdown) — header tidak tutup yang lain, isi yang tutup -->
        <div class="space-y-1">
            <button type="button" @click="layananOpen = !layananOpen"
                    class="w-full flex items-center justify-between rounded-xl transition-all duration-200 px-3.5 py-2.5 font-bold text-xs md:text-sm <?php echo e($isAnyLayananActive ? 'text-white bg-sky-500' : 'text-white/90 hover:bg-sky-500 hover:text-white'); ?>">
                <span class="flex items-center gap-3 min-w-0">
                    <i class="fa-solid fa-headset text-base w-5 text-center shrink-0 <?php echo e($isAnyLayananActive ? 'text-white' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Layanan</span>
                </span>
                <span class="flex items-center gap-1.5 shrink-0 ml-2">
                    <?php if($sidebarPendingLayanan > 0): ?>
                        <span x-show="!layananOpen" class="px-1.5 py-0.5 bg-rose-500 text-white font-black text-[11px] rounded-full shadow-2xs leading-none"><?php echo e($sidebarPendingLayanan); ?></span>
                    <?php endif; ?>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200 <?php echo e($isAnyLayananActive ? 'text-white' : 'text-sky-200'); ?>" :class="{ 'rotate-180': layananOpen }"></i>
                </span>
            </button>
            <div x-show="layananOpen"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-1"
                 class="pt-0.5 pb-1 space-y-0.5 pl-3 border-l-2 border-sky-400/50 ml-4" x-cloak>
                <a href="<?php echo e(url('/admin/permohonan')); ?>" @click="dipOpen = false"
                   class="flex items-center justify-between gap-2 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 overflow-hidden <?php echo e($isPermohonanActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <span class="flex items-center gap-2 min-w-0 flex-1">
                        <i class="fa-regular fa-file-lines text-xs w-4 text-center shrink-0 <?php echo e($isPermohonanActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                        <span class="whitespace-nowrap">Permohonan Informasi</span>
                    </span>
                    <?php if($sidebarPendingPermohonan > 0): ?>
                        <span class="ml-1 px-1.5 py-0.5 bg-rose-500 text-white font-black text-[11px] rounded-full shrink-0 shadow-2xs leading-none"><?php echo e($sidebarPendingPermohonan); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(url('/admin/keberatan')); ?>" @click="dipOpen = false"
                   class="flex items-center justify-between gap-2 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 overflow-hidden <?php echo e($isKeberatanActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <span class="flex items-center gap-2 min-w-0 flex-1">
                        <i class="fa-solid fa-scale-balanced text-xs w-4 text-center shrink-0 <?php echo e($isKeberatanActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                        <span class="whitespace-nowrap">Pengajuan Keberatan</span>
                    </span>
                    <?php if($sidebarPendingKeberatan > 0): ?>
                        <span class="ml-1 px-1.5 py-0.5 bg-rose-500 text-white font-black text-[11px] rounded-full shrink-0 shadow-2xs leading-none"><?php echo e($sidebarPendingKeberatan); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(url('/admin/tata-cara-admin')); ?>" @click="dipOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 <?php echo e($isTataCaraActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <i class="fa-solid fa-list-ol text-xs w-4 text-center shrink-0 <?php echo e($isTataCaraActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Tata Cara Layanan</span>
                </a>
                <a href="<?php echo e(url('/admin/statistik')); ?>" @click="dipOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 <?php echo e($isStatistikActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'font-medium text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
                    <i class="fa-solid fa-chart-simple text-xs w-4 text-center shrink-0 <?php echo e($isStatistikActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
                    <span class="whitespace-nowrap">Statistik Layanan</span>
                </a>
            </div>
        </div>

        <!-- 3. Profil PPID -->
        <a href="<?php echo e(url('/admin/profil-ppid')); ?>"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 <?php echo e($isProfilActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
            <i class="fa-solid fa-id-card text-base w-5 text-center shrink-0 <?php echo e($isProfilActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
            <span class="whitespace-nowrap">Profil PPID</span>
        </a>

        <!-- 4. FAQ -->
        <a href="<?php echo e(url('/admin/faq')); ?>"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 <?php echo e($isFaqActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
            <i class="fa-regular fa-circle-question text-base w-5 text-center shrink-0 <?php echo e($isFaqActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
            <span class="whitespace-nowrap">FAQ</span>
        </a>

        <!-- 5. Regulasi -->
        <a href="<?php echo e(url('/admin/regulasi-admin')); ?>"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 <?php echo e($isRegulasiActive ? 'bg-white text-sky-600 font-extrabold shadow-sm' : 'text-sky-100 hover:bg-sky-500 hover:text-white'); ?>">
            <i class="fa-solid fa-scale-balanced text-base w-5 text-center shrink-0 <?php echo e($isRegulasiActive ? 'text-sky-600' : 'text-sky-200'); ?>"></i>
            <span class="whitespace-nowrap">Regulasi</span>
        </a>



    </div>

    <!-- Footer Sidebar (Profil Admin Interaktif dengan Dropdown Popover) -->
    <div class="p-3.5 border-t border-sky-500 bg-sky-700/40 relative" x-data="{ userMenuOpen: false }">
        <button type="button" @click="userMenuOpen = !userMenuOpen" class="w-full flex items-center justify-between p-2.5 rounded-xl hover:bg-sky-500 transition-all border border-transparent hover:border-sky-400 cursor-pointer group">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-white text-sky-600 flex items-center justify-center font-bold text-sm shrink-0 shadow-xs">
                    <i class="fa-solid fa-user-gear text-xs"></i>
                </div>
                <div class="text-left min-w-0">
                    <p class="text-xs md:text-sm font-extrabold text-white truncate leading-tight">
                        <?php echo e(auth()->user()->nama_lengkap ?? 'Admin PPID'); ?>

                    </p>
                    <p class="text-[11px] font-medium text-sky-200 truncate">Administrator</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-up text-xs text-sky-200 shrink-0 ml-1 transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''"></i>
        </button>

        <!-- Popover Menu Opsi (Beranda Utama & Keluar) -->
        <div x-show="userMenuOpen" 
             @click.outside="userMenuOpen = false" 
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
             class="absolute bottom-full left-3.5 right-3.5 mb-2 bg-white rounded-2xl border border-slate-200 shadow-xl p-1.5 z-50 space-y-1" x-cloak>
            
            <a href="<?php echo e(url('/')); ?>" class="flex items-center gap-2.5 px-3 py-2 text-xs md:text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                <i class="fa-solid fa-house text-xs w-4 text-center text-slate-400"></i> Beranda Utama
            </a>
            
            <form action="<?php echo e(url('/logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs md:text-sm font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs w-4 text-center text-rose-500"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</aside>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/ui/sidebar-admin.blade.php ENDPATH**/ ?>