<!-- Strip Quick Search & Akses Langsung Dokumen -->
<div class="relative z-20 max-w-5xl mx-auto px-4 sm:px-6 -mt-8 mb-12">
    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl shadow-sky-950/5 border border-slate-200/90 p-3 sm:p-4 md:p-5 backdrop-blur-md">
        <form action="{{ url('/informasi-publik') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none text-slate-400">
                    <i class="mdi mdi-magnify text-xl"></i>
                </div>
                <input 
                    type="text" 
                    name="cari" 
                    placeholder="Cari berkas dokumen publik (misal: Rencana Kerja, DIPA, SOP, Kurikulum)..." 
                    class="w-full pl-11 sm:pl-13 pr-4 py-3 sm:py-3.5 bg-slate-50 border border-slate-200 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select name="kategori" class="w-full sm:w-auto px-4 py-3 sm:py-3.5 bg-slate-50 border border-slate-200 rounded-xl sm:rounded-2xl text-xs sm:text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="Informasi Berkala">Informasi Berkala</option>
                    <option value="Informasi Setiap Saat">Informasi Setiap Saat</option>
                    <option value="Informasi Serta-Merta">Informasi Serta-Merta</option>
                </select>

                <button type="submit" class="px-6 sm:px-8 py-3 sm:py-3.5 bg-primary hover:bg-primary-light text-white text-xs sm:text-sm font-bold rounded-xl sm:rounded-2xl transition-all shadow-md shadow-primary/20 hover:shadow-lg hover:shadow-sky-600/35 hover:-translate-y-0.5 flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                    <span>Cari</span>
                    <i class="mdi mdi-arrow-right text-base"></i>
                </button>
            </div>
        </form>

        <!-- Quick Tags / Keyword Populer -->
        <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-slate-100 text-[11px] sm:text-xs text-slate-500">
            <span class="font-bold text-slate-700 flex items-center gap-1.5">
                <i class="mdi mdi-fire text-amber-500 text-sm"></i> Populer:
            </span>
            <a href="{{ url('/informasi-publik?cari=Renstra') }}" class="px-2.5 py-1 bg-slate-100 hover:bg-secondary-light hover:text-primary rounded-lg transition-colors font-medium">Renstra</a>
            <a href="{{ url('/informasi-publik?cari=Laporan+Kinerja') }}" class="px-2.5 py-1 bg-slate-100 hover:bg-secondary-light hover:text-primary rounded-lg transition-colors font-medium">Laporan Kinerja</a>
            <a href="{{ url('/informasi-publik?cari=Anggaran') }}" class="px-2.5 py-1 bg-slate-100 hover:bg-secondary-light hover:text-primary rounded-lg transition-colors font-medium">DIPA / Anggaran</a>
            <a href="{{ url('/informasi-publik?cari=SOP') }}" class="px-2.5 py-1 bg-slate-100 hover:bg-secondary-light hover:text-primary rounded-lg transition-colors font-medium">SOP Akademik</a>
        </div>
    </div>
</div>
