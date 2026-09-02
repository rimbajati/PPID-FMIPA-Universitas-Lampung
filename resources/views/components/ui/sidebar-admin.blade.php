<!-- Sidebar Container Navigasi Admin -->
<aside id="sidebar" class="w-[290px] bg-white border-r border-slate-200/80 text-slate-700 flex flex-col justify-between flex-shrink-0 h-full fixed inset-y-0 left-0 z-20 transform -translate-x-full lg:translate-x-0 lg:static transition-all duration-300 ease-in-out shadow-xs select-none">

    @php
        $sidebarPendingPermohonan = \App\Models\Permohonan::whereIn('status', ['Diajukan', 'Diproses', 'Proses', 'Perlu Tindakan', 'Perlu Hasil Akhir'])->count();
        $sidebarPendingKeberatan  = \App\Models\Keberatan::whereIn('status', ['Diajukan', 'Diproses', 'Proses', 'Perlu Tindakan'])->count();
        $isInformasiActive        = request()->is('admin/informasi-publik*');
        $isPermohonanActive       = request()->is('admin/permohonan*');
        $isKeberatanActive        = request()->is('admin/keberatan*');
    @endphp

    <div class="flex-1 overflow-y-auto px-3.5 py-6 space-y-5">

        <!-- 1. Grup Kelola Data -->
        <div class="space-y-2">
            <div class="px-2 text-[11px] font-black text-[#1B365D] uppercase tracking-wider">
                Pengelolaan Data
            </div>

            <a href="{{ url('/admin/informasi-publik') }}"
               class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 {{ $isInformasiActive ? 'bg-[#1B365D] text-white font-extrabold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-[#1B365D]' }}">
                <i class="fa-regular fa-folder-open text-base w-5 text-center shrink-0 {{ $isInformasiActive ? 'text-white' : 'text-slate-400' }}"></i>
                <span class="whitespace-nowrap">Informasi Publik</span>
            </a>
        </div>

        <!-- 2. Grup Layanan PPID -->
        <div class="space-y-2 pt-1">
            <div class="px-2 text-[11px] font-black text-[#1B365D] uppercase tracking-wider">
                Layanan Informasi 
            </div>

            <!-- Submenu 1: Permohonan Informasi -->
            <a href="{{ url('/admin/permohonan') }}"
               class="flex items-center justify-between gap-2 px-3.5 py-3 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 {{ $isPermohonanActive ? 'bg-[#1B365D] text-white font-extrabold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-[#1B365D]' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <i class="fa-regular fa-file-lines text-base w-5 text-center shrink-0 {{ $isPermohonanActive ? 'text-white' : 'text-slate-400' }}"></i>
                    <span class="whitespace-nowrap">Permohonan Informasi</span>
                </div>
                @if($sidebarPendingPermohonan > 0)
                    <span class="px-2 py-0.5 bg-rose-500 text-white font-black text-[11px] rounded-full shrink-0 shadow-2xs">
                        {{ $sidebarPendingPermohonan }}
                    </span>
                @endif
            </a>

            <!-- Submenu 2: Pengajuan Keberatan -->
            <a href="{{ url('/admin/keberatan') }}"
               class="flex items-center justify-between gap-2 px-3.5 py-3 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 {{ $isKeberatanActive ? 'bg-[#1B365D] text-white font-extrabold shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-[#1B365D]' }}">
                <div class="flex items-center gap-3 min-w-0">
                    <i class="fa-regular fa-circle-question text-base w-5 text-center shrink-0 {{ $isKeberatanActive ? 'text-white' : 'text-slate-400' }}"></i>
                    <span class="whitespace-nowrap">Pengajuan Keberatan</span>
                </div>
                @if($sidebarPendingKeberatan > 0)
                    <span class="px-2 py-0.5 bg-rose-500 text-white font-black text-[11px] rounded-full shrink-0 shadow-2xs">
                        {{ $sidebarPendingKeberatan }}
                    </span>
                @endif
            </a>
        </div>

    </div>

    <!-- Footer Sidebar (Profil Admin Interaktif dengan Dropdown Popover) -->
    <div class="p-3.5 border-t border-slate-100 bg-slate-50/50 relative" x-data="{ userMenuOpen: false }">
        <button type="button" @click="userMenuOpen = !userMenuOpen" class="w-full flex items-center justify-between p-2.5 rounded-xl hover:bg-white transition-all border border-transparent hover:border-slate-200 cursor-pointer group">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-[#1B365D] text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-xs">
                    <i class="fa-solid fa-user-gear text-xs"></i>
                </div>
                <div class="text-left min-w-0">
                    <p class="text-xs md:text-sm font-extrabold text-slate-900 truncate leading-tight">
                        {{ auth()->user()->nama_lengkap ?? 'Admin PPID' }}
                    </p>
                    <p class="text-[11px] font-medium text-slate-400 truncate">Administrator</p>
                </div>
            </div>
            <i class="fa-solid fa-chevron-up text-xs text-slate-400 shrink-0 ml-1 transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''"></i>
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
                <i class="fa-solid fa-house text-xs w-4 text-center text-slate-400"></i> Beranda Utama
            </a>
            
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs md:text-sm font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs w-4 text-center text-rose-500"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</aside>





