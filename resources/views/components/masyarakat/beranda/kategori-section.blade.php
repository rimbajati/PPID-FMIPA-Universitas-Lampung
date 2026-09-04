<!-- Kategori Informasi Publik Section -->
<section id="kategori-informasi" class="max-w-7xl mx-auto px-6 md:px-16 lg:px-24 py-20">
    <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-700 text-xs font-extrabold border border-sky-100">
            <i class="fa-solid fa-layer-group"></i>
            <span>Klasifikasi UU KIP</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Kategori Informasi Publik</h2>
        <p class="text-base text-slate-600 font-medium">Akses seluruh dokumen publik sesuai kategorisasi Undang-Undang Keterbukaan Informasi Publik (KIP).</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Informasi Setiap Saat -->
        <div class="bg-white p-8 border border-slate-200/80 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
            <div class="space-y-5">
                <div class="w-14 h-14 bg-emerald-100/70 text-emerald-700 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-emerald-700 transition-colors">Informasi Setiap Saat</h3>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">Informasi yang wajib disediakan dan siap diakses kapan saja oleh publik secara mudah dan cepat.</p>
            </div>
            <div class="pt-6 mt-6 border-t border-slate-100">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Setiap+Saat') }}" class="inline-flex items-center justify-between w-full text-xs font-extrabold text-slate-800 group-hover:text-emerald-700 transition-all">
                    <span>Lihat Katalog Berkas</span>
                    <div class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-emerald-600 group-hover:text-white flex items-center justify-center transition-all">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Informasi Berkala -->
        <div class="bg-white p-8 border border-slate-200/80 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
            <div class="space-y-5">
                <div class="w-14 h-14 bg-sky-100/70 text-sky-700 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-sky-700 transition-colors">Informasi Berkala</h3>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">Informasi yang diperbarui secara berkala dalam kurun waktu tertentu, seperti laporan tahunan dan rencana kerja.</p>
            </div>
            <div class="pt-6 mt-6 border-t border-slate-100">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Berkala') }}" class="inline-flex items-center justify-between w-full text-xs font-extrabold text-slate-800 group-hover:text-sky-700 transition-all">
                    <span>Lihat Katalog Berkas</span>
                    <div class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-sky-600 group-hover:text-white flex items-center justify-center transition-all">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Informasi Serta-Merta -->
        <div class="bg-white p-8 border border-slate-200/80 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between group">
            <div class="space-y-5">
                <div class="w-14 h-14 bg-rose-100/70 text-rose-700 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-rose-700 transition-colors">Informasi Serta-Merta</h3>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">Informasi yang berkaitan dengan hajat hidup orang banyak dan ketertiban umum secara mendesak.</p>
            </div>
            <div class="pt-6 mt-6 border-t border-slate-100">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Serta-Merta') }}" class="inline-flex items-center justify-between w-full text-xs font-extrabold text-slate-800 group-hover:text-rose-700 transition-all">
                    <span>Lihat Katalog Berkas</span>
                    <div class="w-8 h-8 rounded-full bg-slate-100 group-hover:bg-rose-600 group-hover:text-white flex items-center justify-center transition-all">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
