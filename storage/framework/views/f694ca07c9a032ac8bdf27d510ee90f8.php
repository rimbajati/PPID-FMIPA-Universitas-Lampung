<!-- Prosedur & Alur Layanan Sistem PPID Terpadu (Permohonan, Cek Riwayat, hingga Keberatan) -->
<section id="alur-layanan" class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 pt-16 sm:pt-24 mb-16 sm:mb-20 relative z-20 scroll-mt-24 sm:scroll-mt-28">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-12 space-y-2.5">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-black border border-sky-200/80 shadow-2xs">
            <i class="fa-solid fa-arrows-split-up-and-left text-sky-500"></i>
            <span>Mekanisme Layanan Terpadu</span>
        </div>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
            Alur Layanan <span class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 bg-clip-text text-transparent">PPID FMIPA</span>
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
            Panduan lengkap siklus layanan sistem mulai dari registrasi tiket, pelacakan riwayat real-time, penerimaan dokumen, hingga hak pengajuan keberatan.
        </p>
    </div>

    <!-- Stepper Container dengan Garis Timeline Penghubung -->
    <div class="relative">
        <!-- Connecting Line Bar (Hanya tampil di layar desktop lg+) -->
        <div class="hidden lg:block absolute top-1/2 -translate-y-12 left-[12%] right-[12%] h-1 bg-gradient-to-r from-sky-300 via-blue-300 via-emerald-300 to-amber-300 z-0"></div>

        <!-- 4 Steps Grid Sesuai Alur Sistem Nyata -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 relative z-10">
            
            <!-- Langkah 1: Ajukan Permohonan -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:shadow-sky-900/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="w-12 h-12 rounded-2xl bg-sky-600 text-white font-black flex items-center justify-center text-lg shadow-md shadow-sky-600/30 group-hover:scale-110 group-hover:bg-sky-500 transition-all">
                            01
                        </span>
                        <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-base group-hover:bg-sky-100 transition-colors">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 group-hover:text-sky-600 transition-colors">
                            Ajukan Permohonan
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed mt-2">
                            Login ke akun pemohon, isi formulir rincian informasi publik yang dibutuhkan, dan unggah identitas resmi.
                        </p>
                    </div>
                </div>

                <div class="pt-4 mt-5 border-t border-slate-100 text-[11px] text-sky-700 font-bold flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-sky-50 flex items-center justify-center text-[10px] text-sky-600 shrink-0">
                        <i class="fa-solid fa-ticket"></i>
                    </span>
                    <span>Dapat Nomor Tiket Unik</span>
                </div>
            </div>

            <!-- Langkah 2: Lacak & Cek Riwayat -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:shadow-blue-900/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="w-12 h-12 rounded-2xl bg-blue-600 text-white font-black flex items-center justify-center text-lg shadow-md shadow-blue-600/30 group-hover:scale-110 group-hover:bg-blue-500 transition-all">
                            02
                        </span>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base group-hover:bg-blue-100 transition-colors">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 group-hover:text-blue-600 transition-colors">
                            Lacak & Cek Riwayat
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed mt-2">
                            Pantau tahapan verifikasi berkas oleh admin secara langsung melalui menu <strong>Riwayat Layanan</strong>.
                        </p>
                    </div>
                </div>

                <div class="pt-4 mt-5 border-t border-slate-100 text-[11px] text-blue-700 font-bold flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-blue-50 flex items-center justify-center text-[10px] text-blue-600 shrink-0">
                        <i class="fa-solid fa-satellite-dish"></i>
                    </span>
                    <span>Monitoring Real-Time</span>
                </div>
            </div>

            <!-- Langkah 3: Terima Jawaban & Berkas -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:shadow-emerald-900/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="w-12 h-12 rounded-2xl bg-emerald-600 text-white font-black flex items-center justify-center text-lg shadow-md shadow-emerald-600/30 group-hover:scale-110 group-hover:bg-emerald-500 transition-all">
                            03
                        </span>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base group-hover:bg-emerald-100 transition-colors">
                            <i class="fa-solid fa-file-circle-check"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-600 transition-colors">
                            Terima Dokumen
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed mt-2">
                            Jika permohonan disetujui, unduh berkas salinan resmi atau dapatkan penjelasan tertulis dari petugas PPID.
                        </p>
                    </div>
                </div>

                <div class="pt-4 mt-5 border-t border-slate-100 text-[11px] text-emerald-700 font-bold flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-emerald-50 flex items-center justify-center text-[10px] text-emerald-600 shrink-0">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                    <span>Status Selesai / Siap Unduh</span>
                </div>
            </div>

            <!-- Langkah 4: Pengajuan Keberatan (Opsi Jika Ditolak) -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-7 shadow-sm hover:shadow-xl hover:shadow-amber-900/10 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="w-12 h-12 rounded-2xl bg-amber-500 text-white font-black flex items-center justify-center text-lg shadow-md shadow-amber-500/30 group-hover:scale-110 group-hover:bg-amber-600 transition-all">
                            04
                        </span>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base group-hover:bg-amber-100 transition-colors">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 group-hover:text-amber-600 transition-colors">
                            Pengajuan Keberatan
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed mt-2">
                            Apabila permohonan ditolak atau tidak ditanggapi, pemohon dapat mengajukan keberatan resmi ke Atasan PPID.
                        </p>
                    </div>
                </div>

                <div class="pt-4 mt-5 border-t border-slate-100 text-[11px] text-amber-700 font-bold flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-amber-50 flex items-center justify-center text-[10px] text-amber-600 shrink-0">
                        <i class="fa-solid fa-shield-halved"></i>
                    </span>
                    <span>Jaminan Hak Pemohon KIP</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Tombol Navigasi Cepat Terpadu di Bawah Alur -->
    <div class="flex flex-wrap items-center justify-center gap-4 mt-12 sm:mt-14">
        <a href="<?php echo e(url('/permohonan')); ?>" class="px-7 py-3.5 bg-gradient-to-r from-sky-600 to-blue-700 hover:from-sky-700 hover:to-blue-800 text-white text-xs sm:text-sm font-black rounded-2xl transition-all shadow-md shadow-sky-900/20 hover:shadow-xl hover:shadow-sky-900/30 hover:-translate-y-0.5 inline-flex items-center gap-2.5 cursor-pointer">
            <i class="fa-solid fa-plus-circle text-xs"></i>
            <span>Ajukan Permohonan Baru</span>
        </a>
        <a href="<?php echo e(url('/riwayat-layanan')); ?>" class="px-7 py-3.5 bg-white hover:bg-slate-50 text-slate-800 text-xs sm:text-sm font-black rounded-2xl transition-all border border-slate-200/90 shadow-sm hover:shadow-md hover:-translate-y-0.5 inline-flex items-center gap-2.5 cursor-pointer">
            <i class="fa-solid fa-clock-rotate-left text-xs text-sky-600"></i>
            <span>Cek Riwayat & Tracking Tiket</span>
        </a>
    </div>
</section>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/masyarakat/beranda/alur-prosedur.blade.php ENDPATH**/ ?>