<!-- Sidebar Container Navigasi Admin -->
<aside id="sidebar" class="w-[19rem] bg-primary border-r border-primary-light text-white flex flex-col justify-between flex-shrink-0 h-full fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 lg:static transition-all duration-300 ease-in-out shadow-xs select-none">

    <!-- Brand top sidebar biru full sampai atas -->
    <a href="/" class="flex items-center gap-3 px-4 h-14 md:h-16 shrink-0 border-b border-white/10 hover:bg-primary-light/50 transition">
        <img src="{{ asset('images/logo.png') }}" alt="Logo FMIPA Unila" class="h-9 w-auto shrink-0">
        <div class="text-left leading-tight min-w-0">
            <span class="block text-white font-extrabold text-[13px] tracking-tight truncate">PPID PELAKSANA</span>
            <span class="block text-secondary font-bold text-[10px] tracking-wider uppercase truncate">FMIPA UNIVERSITAS LAMPUNG</span>
        </div>
    </a>

    @php
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
    @endphp

    <div class="flex-1 overflow-y-auto px-3.5 py-6 space-y-1" x-data="{ dipOpen: {{ $isAnyDipActive ? 'true' : 'false' }}, layananOpen: {{ $isAnyLayananActive ? 'true' : 'false' }} }">

        <!-- 1. Informasi Publik (dropdown) — header tidak tutup yang lain, isi yang tutup -->
        <div class="space-y-1">
            <button type="button" @click="dipOpen = !dipOpen"
                    class="w-full flex items-center justify-between rounded-xl transition-all duration-200 px-3.5 py-2.5 font-bold text-xs md:text-sm {{ $isAnyDipActive ? 'text-white bg-primary-light' : 'text-white/90 hover:bg-primary-light hover:text-white' }}">
                <span class="flex items-center gap-3 min-w-0">
                    <i class="mdi mdi-folder-open-outline text-lg w-5 text-center shrink-0 text-secondary"></i>
                    <span class="whitespace-nowrap">Informasi Publik</span>
                </span>
                <i class="mdi mdi-chevron-down text-base transition-transform duration-200 text-secondary" :class="{ 'rotate-180': dipOpen }"></i>
            </button>
            <div x-show="dipOpen"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-1"
                 class="pt-0.5 pb-1 space-y-0.5 pl-3 border-l-2 border-secondary/30 ml-4" x-cloak>
                <a href="{{ url('/admin/informasi-publik') }}" @click="layananOpen = false"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 {{ $isDIPActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <i class="mdi mdi-format-list-bulleted text-sm w-4 text-center shrink-0 {{ $isDIPActive ? 'text-primary' : 'text-secondary' }}"></i>
                    <span class="whitespace-nowrap">Daftar Informasi Publik</span>
                </a>
                <a href="{{ url('/admin/informasi-publik?kategori=' . urlencode('Informasi Berkala')) }}" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 {{ $isBerkalaActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <i class="mdi mdi-clock-outline text-sm w-4 text-center shrink-0 {{ $isBerkalaActive ? 'text-primary' : 'text-secondary' }}"></i>
                    <span class="whitespace-nowrap">Informasi Berkala</span>
                </a>
                <a href="{{ url('/admin/informasi-publik?kategori=' . urlencode('Informasi Setiap Saat')) }}" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 {{ $isSetiapSaatActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <i class="mdi mdi-sync text-sm w-4 text-center shrink-0 {{ $isSetiapSaatActive ? 'text-primary' : 'text-secondary' }}"></i>
                    <span class="whitespace-nowrap">Informasi Setiap Saat</span>
                </a>
                <a href="{{ url('/admin/informasi-publik?kategori=' . urlencode('Informasi Serta-Merta')) }}" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 {{ $isSertaMertaActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <i class="mdi mdi-alert-outline text-sm w-4 text-center shrink-0 {{ $isSertaMertaActive ? 'text-primary' : 'text-secondary' }}"></i>
                    <span class="whitespace-nowrap">Informasi Serta-Merta</span>
                </a>
                <a href="{{ url('/admin/informasi-dikecualikan') }}" @click="layananOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 {{ $isDikecualikanActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <i class="mdi mdi-lock-outline text-sm w-4 text-center shrink-0 {{ $isDikecualikanActive ? 'text-primary' : 'text-secondary' }}"></i>
                    <span class="whitespace-nowrap">Informasi Dikecualikan</span>
                </a>
            </div>
        </div>

        <!-- 2. Layanan (dropdown) — header tidak tutup yang lain, isi yang tutup -->
        <div class="space-y-1">
            <button type="button" @click="layananOpen = !layananOpen"
                    class="w-full flex items-center justify-between rounded-xl transition-all duration-200 px-3.5 py-2.5 font-bold text-xs md:text-sm {{ $isAnyLayananActive ? 'text-white bg-primary-light' : 'text-white/90 hover:bg-primary-light hover:text-white' }}">
                <span class="flex items-center gap-3 min-w-0">
                    <i class="mdi mdi-layers-outline text-lg w-5 text-center shrink-0 text-secondary"></i>
                    <span class="whitespace-nowrap">Layanan</span>
                </span>
                <span class="flex items-center gap-1.5 shrink-0 ml-2">
                    @if($sidebarPendingLayanan > 0)
                        <span x-show="!layananOpen" class="px-1.5 py-0.5 bg-rose-500 text-white font-black text-[11px] rounded-full shadow-2xs leading-none">{{ $sidebarPendingLayanan }}</span>
                    @endif
                    <i class="mdi mdi-chevron-down text-base transition-transform duration-200 text-secondary" :class="{ 'rotate-180': layananOpen }"></i>
                </span>
            </button>
            <div x-show="layananOpen"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-1"
                 class="pt-0.5 pb-1 space-y-0.5 pl-3 border-l-2 border-secondary/30 ml-4" x-cloak>
                <a href="{{ url('/admin/permohonan') }}" @click="dipOpen = false"
                   class="flex items-center justify-between gap-2 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 overflow-hidden {{ $isPermohonanActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <span class="flex items-center gap-2 min-w-0 flex-1">
                        <i class="mdi mdi-email-open-outline text-sm w-4 text-center shrink-0 {{ $isPermohonanActive ? 'text-primary' : 'text-secondary' }}"></i>
                        <span class="whitespace-nowrap">Permohonan Informasi</span>
                    </span>
                    @if($sidebarPendingPermohonan > 0)
                        <span class="ml-1 px-1.5 py-0.5 bg-rose-500 text-white font-black text-[11px] rounded-full shrink-0 shadow-2xs leading-none">{{ $sidebarPendingPermohonan }}</span>
                    @endif
                </a>
                <a href="{{ url('/admin/keberatan') }}" @click="dipOpen = false"
                   class="flex items-center justify-between gap-2 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 overflow-hidden {{ $isKeberatanActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <span class="flex items-center gap-2 min-w-0 flex-1">
                        <i class="mdi mdi-gavel text-sm w-4 text-center shrink-0 {{ $isKeberatanActive ? 'text-primary' : 'text-secondary' }}"></i>
                        <span class="whitespace-nowrap">Pengajuan Keberatan</span>
                    </span>
                    @if($sidebarPendingKeberatan > 0)
                        <span class="ml-1 px-1.5 py-0.5 bg-rose-500 text-white font-black text-[11px] rounded-full shrink-0 shadow-2xs leading-none">{{ $sidebarPendingKeberatan }}</span>
                    @endif
                </a>
                <a href="{{ url('/admin/tata-cara-admin') }}" @click="dipOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 {{ $isTataCaraActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <i class="mdi mdi-compass-outline text-sm w-4 text-center shrink-0 {{ $isTataCaraActive ? 'text-primary' : 'text-secondary' }}"></i>
                    <span class="whitespace-nowrap">Tata Cara Layanan</span>
                </a>
                <a href="{{ url('/admin/statistik') }}" @click="dipOpen = false"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs md:text-sm transition-all duration-150 {{ $isStatistikActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'font-medium text-slate-300 hover:bg-primary-light hover:text-white' }}">
                    <i class="mdi mdi-chart-box-outline text-sm w-4 text-center shrink-0 {{ $isStatistikActive ? 'text-primary' : 'text-secondary' }}"></i>
                    <span class="whitespace-nowrap">Statistik Layanan</span>
                </a>
            </div>
        </div>

        <!-- 3. Profil PPID -->
        <a href="{{ url('/admin/profil-ppid') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 {{ $isProfilActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'text-white/90 hover:bg-primary-light hover:text-white' }}">
            <i class="mdi mdi-card-account-details-outline text-lg w-5 text-center shrink-0 {{ $isProfilActive ? 'text-primary' : 'text-secondary' }}"></i>
            <span class="whitespace-nowrap">Profil</span>
        </a>

        <!-- 4. FAQ -->
        <a href="{{ url('/admin/faq') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 {{ $isFaqActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'text-white/90 hover:bg-primary-light hover:text-white' }}">
            <i class="mdi mdi-help-circle-outline text-lg w-5 text-center shrink-0 {{ $isFaqActive ? 'text-primary' : 'text-secondary' }}"></i>
            <span class="whitespace-nowrap">FAQ</span>
        </a>

        <!-- 5. Regulasi -->
        <a href="{{ url('/admin/regulasi-admin') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 {{ $isRegulasiActive ? 'bg-secondary text-primary font-extrabold shadow-sm' : 'text-white/90 hover:bg-primary-light hover:text-white' }}">
            <i class="mdi mdi-scale-balance text-lg w-5 text-center shrink-0 {{ $isRegulasiActive ? 'text-primary' : 'text-secondary' }}"></i>
            <span class="whitespace-nowrap">Regulasi</span>
        </a>



    </div>

    <!-- Footer Sidebar (Profil Admin Interaktif dengan Dropdown Popover) -->
    <div class="p-3.5 border-t border-primary bg-primary-light/40 relative" x-data="{ userMenuOpen: false }">
        <button type="button" @click="userMenuOpen = !userMenuOpen" class="w-full flex items-center justify-between p-2.5 rounded-xl hover:bg-primary transition-all border border-transparent hover:border-secondary cursor-pointer group">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-white text-primary flex items-center justify-center font-bold text-sm shrink-0 shadow-xs">
                    <i class="mdi mdi-account-cog text-base"></i>
                </div>
                <div class="text-left min-w-0">
                    <p class="text-xs md:text-sm font-extrabold text-white truncate leading-tight">
                        {{ auth()->user()->nama_lengkap ?? 'Admin PPID' }}
                    </p>
                    <p class="text-[11px] font-medium text-secondary truncate">Administrator</p>
                </div>
            </div>
            <i class="mdi mdi-chevron-up text-base text-secondary shrink-0 ml-1 transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''"></i>
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
            
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs md:text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition">
                <i class="mdi mdi-home-outline text-base w-4 text-center text-slate-400"></i> Beranda Utama
            </a>
            
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs md:text-sm font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer">
                    <i class="mdi mdi-logout text-base w-4 text-center text-rose-500"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</aside>
