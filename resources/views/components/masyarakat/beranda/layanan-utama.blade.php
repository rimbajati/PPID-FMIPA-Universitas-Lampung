<!-- Layanan Utama & Akses Cepat Section (3 Kartu Layanan Inti PPID) -->
<section class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 mb-24">
    <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-700 text-xs font-black border border-sky-200/80 shadow-2xs">
            <i class="fa-solid fa-bolt-lightning text-amber-500"></i>
            <span>Akses Cepat</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
            Layanan <span class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 bg-clip-text text-transparent">PPID Online</span>
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
            Pusat terpadu pengajuan permohonan informasi, penanganan keberatan, hingga pemantauan status tiket secara daring, transparan, dan akuntabel.
        </p>
    </div>

    <!-- Grid 3 Card Layanan Elegan & Berimbang -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        
        <!-- CARD 1: Permohonan Informasi -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-7 lg:p-8 shadow-sm hover:shadow-xl hover:shadow-sky-900/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            <!-- Subtle Accent Glow -->
            <div class="absolute -top-16 -right-16 w-32 h-32 bg-sky-100 rounded-full blur-2xl group-hover:bg-sky-200 transition-colors pointer-events-none"></div>

            <div class="space-y-5 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-50 to-blue-100 border border-sky-200/70 text-sky-600 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:from-sky-600 group-hover:to-blue-700 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 group-hover:text-sky-600 transition-colors">
                        Permohonan Informasi
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed mt-2.5">
                        Ajukan permintaan salinan data, berkas publik, dan informasi resmi FMIPA Universitas Lampung secara daring dengan proses verifikasi cepat.
                    </p>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-100 relative z-10">
                <a href="{{ url('/permohonan') }}" class="inline-flex items-center justify-between w-full py-2.5 px-4 rounded-xl bg-slate-50 hover:bg-sky-600 group-hover:bg-sky-600 text-xs font-black text-slate-800 hover:text-white group-hover:text-white transition-all duration-300 border border-slate-200/70 hover:border-sky-600 group-hover:border-sky-600 shadow-2xs">
                    <span>Ajukan Sekarang</span>
                    <div class="w-6 h-6 rounded-lg bg-white/80 group-hover:bg-white text-sky-600 flex items-center justify-center transition-all shadow-2xs">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- CARD 2: Pengajuan Keberatan -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-7 lg:p-8 shadow-sm hover:shadow-xl hover:shadow-amber-900/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            <!-- Subtle Accent Glow -->
            <div class="absolute -top-16 -right-16 w-32 h-32 bg-amber-100/60 rounded-full blur-2xl group-hover:bg-amber-200 transition-colors pointer-events-none"></div>

            <div class="space-y-5 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-100 border border-amber-200/70 text-amber-600 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:from-amber-500 group-hover:to-orange-600 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 group-hover:text-amber-600 transition-colors">
                        Pengajuan Keberatan
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed mt-2.5">
                        Ajukan sanggahan resmi atas tanggapan atau alasan penolakan permohonan yang tidak sesuai dengan ketentuan regulasi UU KIP.
                    </p>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-100 relative z-10">
                <a href="{{ url('/pengajuan-keberatan') }}" class="inline-flex items-center justify-between w-full py-2.5 px-4 rounded-xl bg-slate-50 hover:bg-amber-600 group-hover:bg-amber-600 text-xs font-black text-slate-800 hover:text-white group-hover:text-white transition-all duration-300 border border-slate-200/70 hover:border-amber-600 group-hover:border-amber-600 shadow-2xs">
                    <span>Formulir Keberatan</span>
                    <div class="w-6 h-6 rounded-lg bg-white/80 group-hover:bg-white text-amber-600 flex items-center justify-center transition-all shadow-2xs">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- CARD 3: Lacak Status Tiket -->
        <div class="bg-white border border-slate-200/80 rounded-3xl p-7 lg:p-8 shadow-sm hover:shadow-xl hover:shadow-emerald-900/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            <!-- Subtle Accent Glow -->
            <div class="absolute -top-16 -right-16 w-32 h-32 bg-emerald-100/60 rounded-full blur-2xl group-hover:bg-emerald-200 transition-colors pointer-events-none"></div>

            <div class="space-y-5 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-100 border border-emerald-200/70 text-emerald-600 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:from-emerald-600 group-hover:to-teal-700 group-hover:text-white transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-900 group-hover:text-emerald-600 transition-colors">
                        Lacak Status Tiket
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed mt-2.5">
                        Pantau riwayat progres verifikasi, catatan petugas, serta disposisi jawaban dokumen permohonan informasi Anda secara real-time.
                    </p>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-slate-100 relative z-10">
                <a href="{{ url('/riwayat-layanan') }}" class="inline-flex items-center justify-between w-full py-2.5 px-4 rounded-xl bg-slate-50 hover:bg-emerald-600 group-hover:bg-emerald-600 text-xs font-black text-slate-800 hover:text-white group-hover:text-white transition-all duration-300 border border-slate-200/70 hover:border-emerald-600 group-hover:border-emerald-600 shadow-2xs">
                    <span>Cek Progres Tiket</span>
                    <div class="w-6 h-6 rounded-lg bg-white/80 group-hover:bg-white text-emerald-600 flex items-center justify-center transition-all shadow-2xs">
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </div>
                </a>
            </div>
        </div>

    </div>
</section>
