<!-- Container Utama Grid Pilihan Layanan -->
<div class="space-y-12">
    <!-- Grid 3 Pilihan Layanan Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- CARD 1: PERMOHONAN INFORMASI PUBLIK -->
        <div class="bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group relative" style="border-radius: 12px !important;">
            <div class="p-8 space-y-6">
                <!-- Icon Header Card -->
                <div class="w-16 h-16 bg-sky-100 text-sky-600 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-sky-500 group-hover:text-white transition-all duration-300 shadow-inner" style="border-radius: 10px !important;">
                    <i class="fa-solid fa-file-signature"></i>
                </div>

                <div class="space-y-3">
                    <h3 class="text-xl md:text-2xl font-black text-slate-900 leading-snug group-hover:text-sky-600 transition-colors">
                        Permohonan Informasi
                    </h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-medium">
                        Ajukan permohonan informasi publik secara online sesuai dengan prosedur dan undang-undang KIP yang berlaku.
                    </p>
                </div>

                <ul class="space-y-2 text-xs text-slate-500 font-semibold pt-2 border-t border-slate-100">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Pengisian formulir online cepat
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Dilengkapi nomor tiket otomatis
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Tanggapan maks 10 hari kerja
                    </li>
                </ul>
            </div>

            <div class="p-8 pt-0">
                <a href="{{ url('/permohonan') }}" class="w-full py-3.5 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer" style="border-radius: 6px !important;">
                    <span>Ajukan Permohonan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- CARD 2: PENGAJUAN KEBERATAN -->
        <div class="bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group relative" style="border-radius: 12px !important;">
            <div class="p-8 space-y-6">
                <!-- Icon Header Card -->
                <div class="w-16 h-16 bg-amber-100 text-amber-700 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 shadow-inner" style="border-radius: 10px !important;">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>

                <div class="space-y-3">
                    <h3 class="text-xl md:text-2xl font-black text-slate-900 leading-snug group-hover:text-amber-700 transition-colors">
                        Pengajuan Keberatan
                    </h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-medium">
                        Ajukan keberatan resmi apabila permohonan informasi Anda tidak ditanggapi, ditolak, atau tidak memuaskan.
                    </p>
                </div>

                <ul class="space-y-2 text-xs text-slate-500 font-semibold pt-2 border-t border-slate-100">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Perlindungan hak pemohon KIP
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Membutuhkan nomor tiket permohonan
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Penanganan langsung oleh Atasan PPID
                    </li>
                </ul>
            </div>

            <div class="p-8 pt-0">
                <a href="{{ url('/pengajuan-keberatan') }}" class="w-full py-3.5 bg-amber-600 hover:bg-amber-700 text-white text-xs md:text-sm font-extrabold transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer" style="border-radius: 6px !important;">
                    <span>Ajukan Keberatan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- CARD 3: RIWAYAT & LACAK STATUS LAYANAN -->
        <div class="bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group relative" style="border-radius: 12px !important;">
            <div class="p-8 space-y-6">
                <!-- Icon Header Card -->
                <div class="w-16 h-16 bg-slate-100 text-slate-700 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:bg-slate-700 group-hover:text-white transition-all duration-300 shadow-inner" style="border-radius: 10px !important;">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>

                <div class="space-y-3">
                    <h3 class="text-xl md:text-2xl font-black text-slate-900 leading-snug group-hover:text-slate-700 transition-colors">
                        Riwayat
                    </h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed font-medium">
                        Pantau progres penanganan permohonan atau keberatan Anda secara real-time berdasarkan nomor tiket.
                    </p>
                </div>

                <ul class="space-y-2 text-xs text-slate-500 font-semibold pt-2 border-t border-slate-100">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Lacak status real-time
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Lihat jawaban pengajuan
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-[10px]"></i> Histori pengajuan lengkap
                    </li>
                </ul>
            </div>

            <div class="p-8 pt-0">
                <a href="{{ url('/riwayat-layanan') }}" class="w-full py-3.5 bg-slate-700 hover:bg-slate-800 text-white text-xs md:text-sm font-extrabold transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer" style="border-radius: 6px !important;">
                    <span>Lihat Riwayat Layanan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- BANNER CONSULTATION / HELP DESK -->
    <div class="bg-gradient-to-r from-[#1B365D] via-[#244677] to-[#1B365D] text-white p-8 md:p-10 shadow-xl border border-white/10 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6" style="border-radius: 16px !important;">
        <div class="space-y-2 text-center md:text-left relative z-10 max-w-2xl">
            <h3 class="text-xl md:text-2xl font-black text-white leading-tight">
                Butuh Bantuan Langsung dari Petugas PPID?
            </h3>
            <p class="text-xs md:text-sm text-slate-200 font-medium leading-relaxed">
                Tim helpdesk PPID FMIPA Unila siap melayani pertanyaan Anda pada jam kerja (Senin - Jumat, 08.00 - 16.00 WIB).
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3.5 relative z-10 w-full md:w-auto justify-end">
            <a href="https://wa.me/6282176666544" target="_blank" 
               class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs md:text-sm font-extrabold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2.5 cursor-pointer hover:scale-102" style="border-radius: 12px !important;">
                <i class="fa-brands fa-whatsapp text-lg"></i> WhatsApp
            </a>
            <a href="mailto:ppid@fmipa.unila.ac.id" 
               class="px-6 py-3.5 bg-white/15 hover:bg-white/25 border border-white/25 text-white text-xs md:text-sm font-extrabold transition-all flex items-center justify-center gap-2.5 cursor-pointer hover:scale-102" style="border-radius: 12px !important;">
                <i class="fa-solid fa-envelope text-xs"></i> Hubungi Kami
            </a>
        </div>
    </div>
</div>
