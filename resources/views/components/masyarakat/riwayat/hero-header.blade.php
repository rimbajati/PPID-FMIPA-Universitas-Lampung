<!-- Hero Header Pelacakan Terpadu -->
<section class="bg-slate-100/80 text-slate-800 py-10 border-b border-slate-200/80">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12 lg:px-16 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Text Header -->
            <div class="lg:col-span-7 space-y-2">
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                    Riwayat Layanan
                </h1>
                <p class="text-slate-600 text-sm md:text-base font-normal leading-relaxed max-w-2xl">
                    Pantau perkembangan permohonan informasi publik atau pengajuan keberatan Anda secara cepat, transparan, dan real-time.
                </p>
            </div>

            <!-- Live Search Box Card -->
            <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-200 shadow-xl space-y-4">
                <label class="block text-md font-extrabold text-slate-800">
                    <i class="fa-solid fa-magnifying-glass text-emerald-500 mr-1.5"></i> Lacak Nomor Tiket Layanan
                </label>
                <div class="relative">
                    <input type="text" 
                           x-model="searchQuery" 
                           @keyup.enter="lacakTiket()"
                           placeholder="Contoh: PER-20260826-0001" 
                           class="w-full pl-4 pr-24 py-3.5 bg-slate-50 text-slate-900 font-extrabold text-sm rounded-2xl border border-slate-200 focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 focus:outline-none placeholder-slate-400 shadow-inner">
                    <button type="button" 
                            @click="lacakTiket()" 
                            class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold text-xs rounded-xl transition shadow-md flex items-center gap-1.5 cursor-pointer">
                        <span>Lacak</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-500 font-medium flex items-center justify-between">
                    <span>Pilih dari daftar kartu di bawah untuk melihat detail.</span>
                    <span class="font-mono text-emerald-700 font-bold" x-text="allLayans.length + ' Data Tiket'"></span>
                </p>
            </div>
        </div>
    </div>
</section>

