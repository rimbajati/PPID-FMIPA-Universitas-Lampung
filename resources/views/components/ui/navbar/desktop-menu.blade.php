                <div id="desktop-menu" class="hidden md:flex items-center justify-end flex-1">
                    @if(!request()->is('admin-panel/login'))
                        <div class="flex items-center gap-8 lg:gap-12">
                            <!-- 1. Beranda -->
                            @php
                                $isHome = request()->is('/');
                            @endphp
                            <a href="/" 
                               class="group relative py-2 text-base lg:text-lg tracking-wide transition-all duration-200 flex flex-col items-center
                                      {{ $isHome ? 'text-white font-extrabold' : 'text-white/90 hover:text-white font-bold' }}">
                                <span>Beranda</span>
                                <!-- Garis Bawah Aktif / Hover -->
                                <span class="absolute bottom-0 h-1 rounded-full transition-all duration-200
                                             {{ $isHome ? 'w-full bg-white shadow-xs' : 'w-0 group-hover:w-full bg-white/80' }}"></span>
                            </a>

                            <!-- 2. Profil PPID -->
                            <a href="{{ url('/#profil-ppid') }}" 
                               class="group relative py-2 text-base lg:text-lg tracking-wide transition-all duration-200 flex flex-col items-center text-white/90 hover:text-white font-bold">
                                <span>Profil PPID</span>
                                <span class="absolute bottom-0 h-1 rounded-full transition-all duration-200 w-0 group-hover:w-full bg-white/80"></span>
                            </a>

                            <!-- 3. Dropdown Menu Klasifikasi Informasi -->
                            @php
                                $isInfo = request()->is('informasi-publik*') || request()->is('informasi-dikecualikan*');
                            @endphp
                            <div class="relative" 
                                 x-data="{ openInfo: false }" 
                                 @mouseenter="openInfo = true" 
                                 @mouseleave="openInfo = false" 
                                 @click.outside="openInfo = false">
                                <button type="button" 
                                    @click="openInfo = !openInfo"
                                    class="group relative py-2 text-base lg:text-lg tracking-wide transition-all duration-200 flex items-center gap-2 cursor-pointer
                                           {{ $isInfo ? 'text-white font-extrabold' : 'text-white/90 hover:text-white font-bold' }}">
                                    <span>Informasi Publik</span>
                                    <i class="fa-solid fa-chevron-down text-xs ml-0.5 opacity-80 transition-transform duration-200" :class="{ 'rotate-180': openInfo }"></i>
                                    <!-- Garis Bawah Aktif / Hover -->
                                    <span class="absolute bottom-0 left-0 h-1 rounded-full transition-all duration-200
                                                 {{ $isInfo ? 'w-full bg-white shadow-xs' : 'w-0 group-hover:w-full bg-white/80' }}"></span>
                                </button>

                                <div x-show="openInfo" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-1"
                                     class="absolute right-0 top-full pt-2 w-max max-w-[calc(100vw-2rem)] z-[9999]"
                                     style="display: none;">
                                    <div class="bg-white border border-slate-200/90 shadow-2xl shadow-slate-900/15 rounded-xl p-2 text-slate-800 ring-1 ring-black/5 whitespace-nowrap">
                                        <!-- 1. Daftar Informasi Publik -->
                                        <a href="{{ url('/informasi-publik') }}" 
                                           @click="openInfo = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 mt-0.5 border border-sky-100 group-hover/item:bg-sky-500 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-list text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Daftar Informasi Publik</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Seluruh data informasi PPID</span>
                                            </div>
                                        </a>

                                        <!-- 2. Informasi Tersedia Secara Berkala -->
                                        <a href="{{ url('/informasi-publik/kategori/berkala') }}" 
                                           @click="openInfo = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 mt-0.5 border border-blue-100 group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">
                                                <i class="fa-regular fa-clock text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Informasi Berkala</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Update informasi periodik</span>
                                            </div>
                                        </a>

                                        <!-- 3. Informasi Tersedia Setiap Saat -->
                                        <a href="{{ url('/informasi-publik/kategori/setiap-saat') }}" 
                                           @click="openInfo = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5 border border-emerald-100 group-hover/item:bg-emerald-600 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-arrows-rotate text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Informasi Setiap Saat</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Tersedia untuk publik kapanpun</span>
                                            </div>
                                        </a>

                                        <!-- 4. Informasi Diumumkan Serta-Merta -->
                                        <a href="{{ url('/informasi-publik/kategori/serta-merta') }}" 
                                           @click="openInfo = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 mt-0.5 border border-amber-100 group-hover/item:bg-amber-500 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-triangle-exclamation text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Informasi Serta-Merta</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Informasi darurat atau mendesak</span>
                                            </div>
                                        </a>

                                        <div class="my-2 border-t-2 border-slate-200"></div>

                                        <!-- 5. Daftar Informasi yang Dikecualikan -->
                                        <a href="{{ url('/informasi-dikecualikan') }}" 
                                           @click="openInfo = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 mt-0.5 border border-rose-100 group-hover/item:bg-rose-600 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-lock text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Daftar Informasi Dikecualikan</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Informasi yang tidak dibuka</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 4. Dropdown Menu Standar Layanan -->
                            @php
                                $isLayanan = request()->is('layanan*') || request()->is('permohonan*') || request()->is('keberatan*') || request()->is('pengajuan-keberatan*') || request()->is('riwayat-layanan*') || request()->is('tata-cara*');
                            @endphp
                            <div class="relative" 
                                 x-data="{ open: false }" 
                                 @mouseenter="open = true" 
                                 @mouseleave="open = false" 
                                 @click.outside="open = false">
                                <button type="button" 
                                    @click="open = !open"
                                    class="group relative py-2 text-base lg:text-lg tracking-wide transition-all duration-200 flex items-center gap-2 cursor-pointer
                                           {{ $isLayanan ? 'text-white font-extrabold' : 'text-white/90 hover:text-white font-bold' }}">
                                    <span>Layanan</span>
                                    <i class="fa-solid fa-chevron-down text-xs ml-0.5 opacity-80 transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                                    <!-- Garis Bawah Aktif / Hover -->
                                    <span class="absolute bottom-0 left-0 h-1 rounded-full transition-all duration-200
                                                 {{ $isLayanan ? 'w-full bg-white shadow-xs' : 'w-0 group-hover:w-full bg-white/80' }}"></span>
                                </button>

                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-1"
                                     class="absolute right-0 top-full pt-2 w-max max-w-[calc(100vw-2rem)] z-[9999]"
                                     style="display: none;">
                                    <div class="bg-white border border-slate-200/90 shadow-2xl shadow-slate-900/15 rounded-xl p-2 text-slate-800 ring-1 ring-black/5 whitespace-nowrap">
                                        <a href="{{ url('/tata-cara-permohonan-dan-keberatan') }}" 
                                           @click="open = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item {{ request()->is('tata-cara*') ? 'bg-sky-50 text-sky-600 font-bold' : '' }}">
                                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 mt-0.5 border border-sky-100 group-hover/item:bg-sky-500 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-compass text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Tata Cara Permohonan</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Panduan permohonan & keberatan</span>
                                            </div>
                                        </a>

                                        <div class="my-2 border-t-2 border-slate-200"></div>

                                        <a href="{{ url('/permohonan') }}" 
                                           @click="open = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item {{ request()->is('permohonan*') ? 'bg-sky-50 text-sky-600 font-bold' : '' }}">
                                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 mt-0.5 border border-blue-100 group-hover/item:bg-blue-600 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-envelope-open-text text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Form Permohonan Informasi</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Isi dan kirim permohonan daring</span>
                                            </div>
                                        </a>

                                        <a href="{{ url('/pengajuan-keberatan') }}" 
                                           @click="open = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item {{ request()->is('pengajuan-keberatan*') ? 'bg-sky-50 text-sky-600 font-bold' : '' }}">
                                            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0 mt-0.5 border border-orange-100 group-hover/item:bg-orange-500 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-gavel text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Form Pengajuan Keberatan</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Sampaikan keberatan atas layanan</span>
                                            </div>
                                        </a>

                                        <div class="my-2 border-t-2 border-slate-200"></div>

                                        <a href="{{ url('/riwayat-layanan') }}" 
                                           @click="open = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item {{ request()->is('riwayat-layanan*') ? 'bg-sky-50 text-sky-600 font-bold' : '' }}">
                                            <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0 mt-0.5 border border-violet-100 group-hover/item:bg-violet-600 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-ticket text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Lacak Tiket Layanan</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Periksa progres tiket Anda</span>
                                            </div>
                                        </a>

                                        <div class="my-2 border-t-2 border-slate-200"></div>

                                        <a href="{{ url('/#statistik-layanan') }}" 
                                           @click="open = false"
                                           class="flex items-start gap-3.5 px-4 py-3 rounded-xl hover:bg-sky-50 text-slate-800 hover:text-sky-600 transition-all duration-150 group/item">
                                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 mt-0.5 border border-sky-100 group-hover/item:bg-sky-500 group-hover/item:text-white transition-colors">
                                                <i class="fa-solid fa-chart-simple text-base"></i>
                                            </div>
                                            <div>
                                                <span class="block text-base font-bold leading-tight">Statistik Layanan</span>
                                                <span class="block text-xs text-slate-500 font-medium mt-0.5">Rekapitulasi data layanan PPID</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Regulasi -->
                            @php
                                $isRegulasi = request()->is('regulasi*');
                            @endphp
                            <a href="{{ url('/regulasi') }}" 
                               class="group relative py-2 text-base lg:text-lg tracking-wide transition-all duration-200 flex flex-col items-center
                                      {{ $isRegulasi ? 'text-white font-extrabold' : 'text-white/90 hover:text-white font-bold' }}">
                                <span>Regulasi</span>
                                <span class="absolute bottom-0 h-1 rounded-full transition-all duration-200
                                             {{ $isRegulasi ? 'w-full bg-white shadow-xs' : 'w-0 group-hover:w-full bg-white/80' }}"></span>
                            </a>

                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <!-- Admin User Profile / Logout (Hanya Tampil Jika Sedang Login Admin) -->
                                <div class="relative group ml-2">
                                    <div class="w-9 h-9 bg-white/20 hover:bg-white/30 text-white rounded-full flex items-center justify-center text-sm transition-all cursor-pointer shadow-xs border border-white/20">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="absolute right-0 top-full pt-3 w-52 hidden group-hover:block transition-all duration-300 z-[9999]">
                                        <div class="bg-white border border-slate-100 shadow-xl py-2 rounded-xl overflow-hidden">
                                            @if((Auth::user()->role ?? '') === 'admin')
                                                <a href="{{ url('/admin/informasi-publik') }}"
                                                    class="flex items-center gap-3 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:text-sky-600 hover:bg-slate-50 transition-all duration-200">
                                                    <i class="fa-solid fa-gauge-high text-xs opacity-70 w-4 text-center"></i> Dashboard Admin
                                                </a>
                                            @endif
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="flex items-center gap-3 w-full text-left px-5 py-2.5 text-sm font-semibold text-red-600 hover:text-red-700 hover:bg-red-50 transition-all duration-200 cursor-pointer">
                                                    <i class="fa-solid fa-right-from-bracket text-xs opacity-70 w-4 text-center"></i> Keluar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
