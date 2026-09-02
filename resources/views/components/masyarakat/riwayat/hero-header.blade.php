<!-- Hero Header Pelacakan Terpadu Tema Unila Dark Navy (#1B365D) -->
<section class="bg-gradient-to-br from-[#0B1E36] via-[#1B365D] to-[#0F2B52] text-white py-12 px-6 md:px-16 lg:px-24 relative overflow-hidden shadow-lg">
    <div class="max-w-7xl mx-auto space-y-6 relative z-10">
        
        <!-- Breadcrumb Navigation -->
        <div class="flex items-center gap-2 text-xs md:text-sm text-slate-300 font-medium">
            <a href="{{ url('/') }}" class="hover:text-white transition">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <a href="{{ url('/layanan') }}" class="hover:text-white transition">Layanan</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-white font-bold">Riwayat</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <!-- Text Header -->
            <div class="lg:col-span-7 space-y-2.5">
                <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight leading-tight">
                    <span class="text-slate-400">Riwayat</span> Layanan
                </h1>
                <p class="text-slate-200 text-sm md:text-base leading-relaxed max-w-2xl font-medium">
                    Pantau perkembangan permohonan informasi publik atau pengajuan keberatan Anda secara cepat, transparan, dan real-time.
                </p>
            </div>

            <!-- Live Search Box Card -->
            <div class="lg:col-span-5 bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-3xl shadow-2xl space-y-4">
                <label class="block text-md font-extrabold text-slate-200">
                    <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Lacak Nomor Tiket Layanan
                </label>
                <div class="relative">
                    <input type="text" 
                           x-model="searchQuery" 
                           @keyup.enter="lacakTiket()"
                           placeholder="Contoh: PER-20260826-0001" 
                           class="w-full pl-4 pr-24 py-3.5 bg-white/95 text-slate-900 font-extrabold text-sm rounded-2xl border-0 focus:ring-4 focus:ring-sky-400 focus:outline-none placeholder-slate-400 shadow-inner">
                    <button type="button" 
                            @click="lacakTiket()" 
                            class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-[#1B365D] hover:bg-[#152a4a] text-white font-extrabold text-xs rounded-xl transition shadow-md flex items-center gap-1.5 cursor-pointer">
                        <span>Lacak</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                </div>
                <p class="text-[11px] text-slate-300 font-medium flex items-center justify-between">
                    <span>Pilih dari daftar kartu di bawah untuk melihat detail.</span>
                    <span class="font-mono text-slate-300 font-bold" x-text="allLayans.length + ' Data Tiket'"></span>
                </p>
            </div>
        </div>

    </div>
</section>
