<!-- Kategori Informasi Publik Section -->
<section id="kategori-informasi" class="max-w-7xl mx-auto px-6 md:px-16 lg:px-24 py-20">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-4">Kategori Informasi Publik</h2>
        <p class="text-base text-slate-600">Akses seluruh dokumen publik sesuai kategorisasi Undang-Undang Keterbukaan Informasi Publik (KIP).</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Informasi Setiap Saat -->
        <div class="bg-white p-8 border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between" style="border-radius: 6px !important;">
            <div class="space-y-4">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl" style="border-radius: 6px !important;">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-900">Informasi Setiap Saat</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Informasi yang wajib disediakan dan siap diakses kapan saja oleh publik secara mudah.</p>
            </div>
            <div class="pt-6 mt-6 border-t border-slate-100">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Setiap+Saat') }}" class="inline-flex items-center text-sm font-bold text-[#1B365D] hover:text-[#0284c7] transition gap-2">
                    Lihat Berkas <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Informasi Berkala -->
        <div class="bg-white p-8 border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between" style="border-radius: 6px !important;">
            <div class="space-y-4">
                <div class="w-14 h-14 bg-sky-100 text-sky-700 flex items-center justify-center text-2xl" style="border-radius: 6px !important;">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-900">Informasi Berkala</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Informasi yang diperbarui secara berkala dalam kurun waktu tertentu, seperti laporan tahunan.</p>
            </div>
            <div class="pt-6 mt-6 border-t border-slate-100">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Berkala') }}" class="inline-flex items-center text-sm font-bold text-[#1B365D] hover:text-[#0284c7] transition gap-2">
                    Lihat Berkas <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Informasi Serta-Merta -->
        <div class="bg-white p-8 border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between" style="border-radius: 6px !important;">
            <div class="space-y-4">
                <div class="w-14 h-14 bg-rose-100 text-rose-700 flex items-center justify-center text-2xl" style="border-radius: 6px !important;">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-900">Informasi Serta-Merta</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Informasi yang berkaitan dengan kepentingan publik secara langsung dan mendesak.</p>
            </div>
            <div class="pt-6 mt-6 border-t border-slate-100">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Serta-Merta') }}" class="inline-flex items-center text-sm font-bold text-[#1B365D] hover:text-[#0284c7] transition gap-2">
                    Lihat Berkas <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</section>
