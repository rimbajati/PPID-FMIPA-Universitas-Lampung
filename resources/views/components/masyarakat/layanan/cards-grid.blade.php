<!-- Container Utama Grid Pilihan Layanan -->
<div class="space-y-10">
    <!-- Grid 3 Pilihan Layanan Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        
        <!-- CARD 1: PERMOHONAN INFORMASI PUBLIK -->
        <div class="bg-white border border-slate-200/90 rounded-3xl p-6 md:p-8 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group relative space-y-6">
            <div class="space-y-6">
                <!-- Icon Header Card -->
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-2xs">
                    <i class="fa-solid fa-file-signature"></i>
                </div>

                <div class="space-y-2">
                    <h3 class="text-xl md:text-2xl font-black text-slate-900 leading-snug group-hover:text-blue-600 transition-colors">
                        Permohonan Informasi
                    </h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-medium">
                        Ajukan permohonan informasi publik secara online sesuai dengan prosedur dan undang-undang KIP yang berlaku.
                    </p>
                </div>

                <ul class="space-y-2 text-xs text-slate-600 font-semibold pt-4 border-t border-slate-100">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-blue-600 text-xs"></i> Pengisian formulir online cepat
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-blue-600 text-xs"></i> Dilengkapi nomor tiket otomatis
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-blue-600 text-xs"></i> Tanggapan maks 10 hari kerja
                    </li>
                </ul>
            </div>

            <div class="pt-2">
                <a href="{{ url('/permohonan') }}" class="w-full py-3 px-5 bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-extrabold rounded-full transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2 cursor-pointer">
                    <span>Ajukan Permohonan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- CARD 2: PENGAJUAN KEBERATAN -->
        <div class="bg-white border border-slate-200/90 rounded-3xl p-6 md:p-8 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group relative space-y-6">
            <div class="space-y-6">
                <!-- Icon Header Card -->
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 shadow-2xs">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>

                <div class="space-y-2">
                    <h3 class="text-xl md:text-2xl font-black text-slate-900 leading-snug group-hover:text-amber-600 transition-colors">
                        Pengajuan Keberatan
                    </h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-medium">
                        Ajukan keberatan resmi apabila permohonan informasi Anda tidak ditanggapi, ditolak, atau tidak memuaskan.
                    </p>
                </div>

                <ul class="space-y-2 text-xs text-slate-600 font-semibold pt-4 border-t border-slate-100">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-amber-500 text-xs"></i> Perlindungan hak pemohon KIP
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-amber-500 text-xs"></i> Membutuhkan nomor tiket permohonan
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-amber-500 text-xs"></i> Penanganan langsung oleh Atasan PPID
                    </li>
                </ul>
            </div>

            <div class="pt-2">
                <a href="{{ url('/pengajuan-keberatan') }}" class="w-full py-3 px-5 bg-amber-500 hover:bg-amber-600 text-white text-xs md:text-sm font-extrabold rounded-full transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2 cursor-pointer">
                    <span>Ajukan Keberatan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- CARD 3: RIWAYAT & LACAK STATUS LAYANAN -->
        <div class="bg-white border border-slate-200/90 rounded-3xl p-6 md:p-8 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group relative space-y-6">
            <div class="space-y-6">
                <!-- Icon Header Card -->
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-2xs">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <div class="space-y-2">
                    <h3 class="text-xl md:text-2xl font-black text-slate-900 leading-snug group-hover:text-emerald-600 transition-colors">
                        Riwayat
                    </h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-medium">
                        Pantau progres penanganan permohonan atau keberatan Anda secara real-time berdasarkan nomor tiket.
                    </p>
                </div>

                <ul class="space-y-2 text-xs text-slate-600 font-semibold pt-4 border-t border-slate-100">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i> Lacak status real-time
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i> Lihat jawaban pengajuan
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-xs"></i> Histori pengajuan lengkap
                    </li>
                </ul>
            </div>

            <div class="pt-2">
                <a href="{{ url('/riwayat-layanan') }}" class="w-full py-3 px-5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs md:text-sm font-extrabold rounded-full transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2 cursor-pointer">
                    <span>Lihat Riwayat Layanan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- BANNER CONSULTATION / HELP DESK -->
    <div class="bg-gradient-to-r from-sky-500 via-sky-500 to-sky-600 text-white p-8 md:p-10 shadow-xl shadow-sky-500/15 border border-sky-400/30 rounded-3xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-center md:text-left relative z-10 max-w-2xl">
            <h3 class="text-xl md:text-2xl font-black text-white leading-tight">
                Butuh Bantuan Langsung dari Petugas PPID?
            </h3>
            <p class="text-xs md:text-sm text-sky-50 font-medium leading-relaxed">
                Tim helpdesk PPID FMIPA Unila siap melayani pertanyaan Anda pada jam kerja (Senin - Jumat, 08.00 - 16.00 WIB).
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3.5 relative z-10 w-full md:w-auto justify-end">
            <a href="https://wa.me/6282176666544" target="_blank" 
               class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs md:text-sm font-extrabold rounded-full transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2.5 cursor-pointer hover:scale-102">
                <i class="fa-brands fa-whatsapp text-lg"></i> WhatsApp
            </a>
            <a href="mailto:ppid@fmipa.unila.ac.id" 
               class="px-6 py-3.5 bg-white/20 hover:bg-white/30 border border-white/40 text-white text-xs md:text-sm font-extrabold rounded-full transition-all flex items-center justify-center gap-2.5 cursor-pointer hover:scale-102">
                <i class="fa-solid fa-envelope text-xs"></i> Hubungi Kami
            </a>
        </div>
    </div>
</div>
