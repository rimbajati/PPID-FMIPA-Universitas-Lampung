<!-- SECTION 2: GRID KARTU DAFTAR RIWAYAT LAYANAN SAYA -->
<div id="daftar-riwayat-grid" class="space-y-6 pt-4">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <h3 class="text-xl md:text-2xl font-black text-slate-900 flex items-center gap-3">
                <span>Daftar Riwayat Layanan Saya</span>
            </h3>
            <p class="text-xs md:text-sm text-slate-500 font-medium mt-1">Pilih salah satu kartu di bawah ini untuk melihat detail dan status pelacakannya</p>
        </div>
        <span class="px-4 py-1.5 bg-emerald-50 text-emerald-800 font-black text-xs md:text-sm rounded-full border border-emerald-200" x-text="allLayans.length + ' Total Layanan'"></span>
    </div>

    <!-- Grid Card Riwayat -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="item in paginatedLayans" :key="item.no_tiket">
            <div @click="selectTiket(item)"
                 class="bg-white border p-6 rounded-3xl shadow-xs hover:shadow-xl transition-all duration-300 cursor-pointer flex flex-col justify-between space-y-6 group relative overflow-hidden"
                 :class="activeItem && activeItem.no_tiket === item.no_tiket ? 'ring-2 ring-emerald-500 border-emerald-500 bg-emerald-50/20' : 'border-slate-200/90 hover:border-emerald-500'">

                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-xl border"
                              :class="item.type === 'keberatan' ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-blue-50 text-blue-600 border-blue-200'"
                              x-text="item.jenis_label">
                        </span>

                        <span class="inline-flex items-center px-3 py-1 font-black text-[10px] uppercase tracking-wider rounded-xl border"
                              :class="{
                                  'bg-emerald-100 text-emerald-900 border-emerald-300': item.status === 'Selesai',
                                  'bg-amber-100 text-amber-900 border-amber-300': item.status === 'Diproses',
                                  'bg-rose-100 text-rose-900 border-rose-300': item.status === 'Ditolak',
                                  'bg-slate-100 text-slate-700 border-slate-300': item.status === 'Diajukan'
                              }" x-text="item.status">
                        </span>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-base font-black text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug line-clamp-2"
                            x-text="item.judul || item.deskripsi || item.informasi_yang_diminta"></h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed line-clamp-2"
                           x-text="item.deskripsi || item.tujuan_penggunaan_informasi || '-'"></p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-semibold">
                    <span x-text="item.created_at_formatted || '-'"></span>
                    <span class="font-mono font-black text-emerald-800 bg-slate-100 group-hover:bg-emerald-600 group-hover:text-white transition-colors px-2.5 py-1 rounded-lg border border-slate-200"
                          x-text="'#' + item.no_tiket"></span>
                </div>

            </div>
        </template>

        <template x-if="allLayans.length === 0">
            <div class="col-span-full bg-white border border-slate-200 p-12 md:p-16 text-center space-y-5 rounded-3xl shadow-xs">
                <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center text-4xl mx-auto shadow-xs border border-emerald-100">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div class="space-y-2 max-w-md mx-auto">
                    <h4 class="text-lg md:text-xl font-black text-slate-900">Belum Ada Riwayat Layanan</h4>
                    <p class="text-xs md:text-sm text-slate-500 font-medium leading-relaxed">
                        Anda belum memiliki riwayat permohonan informasi publik. Silakan ajukan permohonan baru di bawah ini.
                    </p>
                </div>
                <div class="pt-3 flex justify-center">
                    <a href="{{ url('/permohonan') }}" class="w-full sm:w-auto px-7 py-3.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-black uppercase tracking-wider transition-all duration-200 shadow-md shadow-blue-600/20 rounded-2xl flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i> Buat Permohonan Informasi
                    </a>
                </div>
            </div>
        </template>
    </div>

    <!-- Pagination Bar (Identik dengan UI Pagination Sistem) -->
    <div x-show="allLayans.length > perPage" x-cloak class="pt-6">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full">
            <!-- Counter Left -->
            <div class="text-xs md:text-sm font-semibold text-slate-500">
                Menampilkan <span class="font-extrabold text-slate-900" x-text="firstItem + '–' + lastItem"></span> dari <span class="font-black text-sky-600" x-text="allLayans.length"></span> layanan
            </div>

            <!-- Unified Connected Pagination Box -->
            <div class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white">
                <!-- Tombol Prev -->
                <button type="button"
                        @click="prevPage()"
                        :disabled="currentPage === 1"
                        class="px-3.5 py-2 text-xs font-bold transition flex items-center justify-center cursor-pointer select-none"
                        :class="currentPage === 1 ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50'">
                    ‹
                </button>

                <!-- Nomor Halaman -->
                <template x-for="p in pageNumbers" :key="p">
                    <div>
                        <!-- Ellipsis (...) -->
                        <template x-if="p === '...'">
                            <span class="px-3 py-2 text-xs font-bold bg-slate-100/70 text-slate-400 select-none block">
                                ...
                            </span>
                        </template>
                        <!-- Angka Halaman -->
                        <template x-if="p !== '...'">
                            <button type="button"
                                    @click="goToPage(p)"
                                    class="px-3.5 py-2 min-w-[38px] text-center text-xs font-bold transition cursor-pointer select-none block"
                                    :class="currentPage === p ? 'bg-sky-500 text-white font-extrabold shadow-2xs' : 'bg-white text-sky-500 hover:bg-sky-50'">
                                <span x-text="p"></span>
                            </button>
                        </template>
                    </div>
                </template>

                <!-- Tombol Next -->
                <button type="button"
                        @click="nextPage()"
                        :disabled="currentPage === totalPages"
                        class="px-3.5 py-2 text-xs font-bold transition flex items-center justify-center cursor-pointer select-none"
                        :class="currentPage === totalPages ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50'">
                    ›
                </button>
            </div>
        </div>
    </div>
</div>
