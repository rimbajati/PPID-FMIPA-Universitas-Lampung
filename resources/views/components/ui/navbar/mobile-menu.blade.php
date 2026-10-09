        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-sky-500 border-t border-white/20 px-4 py-3 shadow-lg absolute w-full left-0">
            <div class="flex flex-col">
                @if(!request()->is('admin-panel/login'))
                    <a href="/" class="group relative text-white font-bold text-base tracking-wide py-3 border-b border-white/20 {{ request()->is('/') ? 'font-extrabold' : '' }}">Beranda</a>

                    <a href="{{ url('/#profil-ppid') }}" class="text-white/90 hover:text-white font-bold text-base tracking-wide py-3 border-b border-white/20">
                        <span>Profil PPID</span>
                    </a>

                    <!-- Accordion Submenu Klasifikasi Informasi (Mobile) -->
                    <details class="group border-b border-white/20 py-0">
                        <summary class="list-none cursor-pointer text-white/90 hover:text-white font-bold text-base tracking-wide py-3 flex items-center justify-between [&::-webkit-details-marker]:hidden">
                            <span>Informasi Publik</span><i class="fa-solid fa-chevron-down text-xs opacity-80 transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="pb-3 pl-3 space-y-1">
                            <a href="{{ url('/informasi-publik') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-list w-4 text-center text-sky-100"></i><span>Daftar Informasi Publik</span>
                            </a>
                            <a href="{{ url('/informasi-publik/kategori/berkala') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-regular fa-clock w-4 text-center text-sky-100"></i><span>Informasi Berkala</span>
                            </a>
                            <a href="{{ url('/informasi-publik/kategori/setiap-saat') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-arrows-rotate w-4 text-center text-sky-100"></i><span>Informasi Setiap Saat</span>
                            </a>
                            <a href="{{ url('/informasi-publik/kategori/serta-merta') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-triangle-exclamation w-4 text-center text-sky-100"></i><span>Informasi Serta-Merta</span>
                            </a>
                            <div class="my-2 border-t border-white/20"></div>
                            <a href="{{ url('/informasi-dikecualikan') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-lock w-4 text-center text-sky-100"></i><span>Daftar Informasi Dikecualikan</span>
                            </a>
                        </div>
                    </details>

                    <!-- Accordion Submenu Standar Layanan (Mobile) -->
                    <details class="group border-b border-white/20 py-0">
                        <summary class="list-none cursor-pointer text-white/90 hover:text-white font-bold text-base tracking-wide py-3 flex items-center justify-between [&::-webkit-details-marker]:hidden">
                            <span>Layanan</span><i class="fa-solid fa-chevron-down text-xs opacity-80 transition-transform group-open:rotate-180"></i>
                        </summary>
                        <div class="pb-3 pl-3 space-y-1">
                            <a href="{{ url('/tata-cara-permohonan-dan-keberatan') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-compass w-4 text-center text-sky-100"></i><span>Tata Cara Permohonan</span>
                            </a>
                            <div class="my-2 border-t border-white/20"></div>
                            <a href="{{ url('/permohonan') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-envelope-open-text w-4 text-center text-sky-100"></i><span>Form Permohonan Informasi</span>
                            </a>
                            <a href="{{ url('/pengajuan-keberatan') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-gavel w-4 text-center text-sky-100"></i><span>Form Pengajuan Keberatan</span>
                            </a>
                            <div class="my-2 border-t border-white/20"></div>
                            <a href="{{ url('/riwayat-layanan') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-ticket w-4 text-center text-sky-100"></i><span>Lacak Tiket Layanan</span>
                            </a>
                            <div class="my-2 border-t-2 border-white/40"></div>
                            <a href="{{ url('/#statistik-layanan') }}" class="flex items-center gap-2.5 text-white text-sm py-2 font-semibold hover:text-sky-100">
                                <i class="fa-solid fa-chart-simple w-4 text-center text-sky-100"></i><span>Statistik Layanan</span>
                            </a>
                        </div>
                    </details>

                    <a href="{{ url('/regulasi') }}" class="text-white/90 hover:text-white font-bold text-base tracking-wide py-3 border-b border-white/20 {{ request()->is('regulasi*') ? 'text-white' : '' }}">
                        <span>Regulasi</span>
                    </a>

                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <div class="pt-4">
                            <div class="space-y-3">
                                @if((Auth::user()->role ?? '') === 'admin')
                                    <a href="{{ url('/admin/informasi-publik') }}"
                                       class="flex items-center gap-3 text-white font-semibold py-2 transition-colors">
                                        <i class="fa-solid fa-gauge-high text-sky-200 text-sm w-5 text-center"></i>
                                        <span>Dashboard Admin</span>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full text-left text-red-200 hover:text-red-100 font-semibold py-2 transition-colors cursor-pointer">
                                        <i class="fa-solid fa-right-from-bracket text-red-200 text-sm w-5 text-center"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <a href="/" class="text-white font-semibold py-3 inline-flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left text-sm"></i> Kembali ke Beranda
                    </a>
                @endif
            </div>
        </div>
