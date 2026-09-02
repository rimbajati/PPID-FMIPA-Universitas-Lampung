<!-- Timeline Vertikal Garis Terhubung -->
<div class="relative pl-6 space-y-8">
    
    <!-- STEP 1: DIAJUKAN -->
    <div class="relative flex items-start gap-4">
        <!-- Garis ke Step 2 (Diproses) -->
        <template x-if="activeItem.status === 'Diproses' || activeItem.status === 'Selesai' || activeItem.status === 'Ditolak'">
            <div class="absolute -left-[13px] top-3 bottom-[-2rem] w-0.5 bg-slate-200"></div>
        </template>

        <div class="absolute -left-6 w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0 bg-emerald-500 ring-4 ring-emerald-100 z-10">
            <i class="fa-solid fa-check text-[10px]"></i>
        </div>
        <div class="space-y-1.5 pl-3 w-full">
            <div class="flex items-center justify-between gap-2 flex-wrap">
                <h4 class="text-sm md:text-base font-black text-slate-900 leading-none">Diajukan</h4>
                <span class="text-xs font-medium text-slate-400" x-text="activeItem.created_at_formatted || '-'"></span>
            </div>
            <p class="text-xs md:text-sm text-slate-500 font-medium leading-relaxed" 
               x-text="(activeItem.type === 'keberatan' ? 'Keberatan' : 'Permohonan') + ' masuk ke sistem'"></p>
        </div>
    </div>

    <!-- STEP 2: DIPROSES -->
    <template x-if="activeItem.status === 'Diproses' || activeItem.status === 'Selesai' || activeItem.status === 'Ditolak'">
        <div class="relative flex items-start gap-4">
            <!-- Garis ke Step 3 (Selesai / Ditolak) -->
            <template x-if="activeItem.status === 'Selesai' || activeItem.status === 'Ditolak'">
                <div class="absolute -left-[13px] top-3 bottom-[-2rem] w-0.5 bg-slate-200"></div>
            </template>

            <div class="absolute -left-6 w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0 z-10"
                 :class="activeItem.status === 'Selesai' ? 'bg-emerald-500 ring-4 ring-emerald-100' : (activeItem.status === 'Ditolak' ? 'bg-rose-500 ring-4 ring-rose-100' : 'bg-amber-500 ring-4 ring-amber-100')">
                <i :class="activeItem.status === 'Selesai' ? 'fa-solid fa-check text-[10px]' : (activeItem.status === 'Ditolak' ? 'fa-solid fa-xmark text-[10px]' : 'fa-solid fa-spinner animate-spin text-[10px]')"></i>
            </div>
            <div class="space-y-2.5 pl-3 w-full">
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    <h4 class="text-sm md:text-base font-black text-slate-900 leading-none" 
                        x-text="activeItem.status === 'Selesai' ? 'Telah Diproses' : 'Diproses'"></h4>
                    <span class="text-xs font-medium text-slate-400" x-text="activeItem.updated_at_formatted || '-'"></span>
                </div>
                <p class="text-xs md:text-sm text-slate-500 font-medium leading-relaxed">Informasi sedang disiapkan</p>

                <template x-if="activeItem.pesan_diproses">
                    <div class="p-4 bg-amber-50/90 rounded-2xl text-xs md:text-sm text-amber-950 space-y-1.5 border border-amber-200/90 font-medium">
                        <div class="text-[11px] font-black text-amber-900 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-comment-dots text-amber-700"></i> PESAN PPID:
                        </div>
                        <p class="leading-relaxed text-slate-800 font-semibold whitespace-pre-line" x-text="activeItem.pesan_diproses"></p>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- STEP 3: SELESAIKAN (FINAL - TANPA GARIS KE BAWAH) -->
    <template x-if="activeItem.status === 'Selesai'">
        <div class="relative flex items-start gap-4">
            <div class="absolute -left-6 w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0 bg-emerald-600 ring-4 ring-emerald-100 z-10">
                <i class="fa-solid fa-flag-checkered text-[10px]"></i>
            </div>
            <div class="space-y-3 pl-3 w-full">
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    <h4 class="text-sm md:text-base font-black text-emerald-900 leading-none">Selesai</h4>
                    <span class="text-xs font-medium text-slate-400" x-text="activeItem.updated_at_formatted || '-'"></span>
                </div>
                <p class="text-xs md:text-sm text-slate-500 font-medium leading-relaxed">Permohonan dipenuhi.</p>

                <template x-if="activeItem.pesan_selesai">
                    <div class="p-4 bg-emerald-50/90 rounded-2xl text-xs md:text-sm text-emerald-950 space-y-1.5 border border-emerald-200/90 font-medium">
                        <div class="text-[11px] font-black text-emerald-900 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-comment-dots text-emerald-700"></i> PESAN PPID:
                        </div>
                        <p class="leading-relaxed text-slate-800 font-semibold whitespace-pre-line" x-text="activeItem.pesan_selesai"></p>
                    </div>
                </template>

                <!-- <div class="flex flex-wrap gap-3 pt-1">
                    <template x-if="activeItem.file_jawaban_permohonan || activeItem.file_jawaban || activeItem.file_informasi_yang_diminta">
                        <a :href="'/storage/' + (activeItem.file_jawaban_permohonan || activeItem.file_jawaban || activeItem.file_informasi_yang_diminta)" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-xl transition text-xs md:text-sm shadow-md">
                            <i class="fa-solid fa-download"></i> Lihat Jawaban
                        </a>
                    </template>
                    <template x-if="activeItem.link_jawaban_permohonan || activeItem.link_jawaban || activeItem.link_informasi_yang_diminta">
                        <a :href="activeItem.link_jawaban_permohonan || activeItem.link_jawaban || activeItem.link_informasi_yang_diminta" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-[#1B365D] hover:bg-[#152a4a] text-white font-extrabold rounded-xl transition text-xs md:text-sm shadow-md">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Jawaban
                        </a>
                    </template>
                </div> -->
            </div>
        </div>
    </template>

    <!-- STEP 3: DITOLAK (FINAL - TANPA GARIS KE BAWAH) -->
    <template x-if="activeItem.status === 'Ditolak'">
        <div class="relative flex items-start gap-4">
            <div class="absolute -left-6 w-6 h-6 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0 bg-rose-600 ring-4 ring-rose-100 z-10">
                <i class="fa-solid fa-xmark text-[10px]"></i>
            </div>
            <div class="space-y-3 pl-3 w-full">
                <div class="flex items-center justify-between gap-2 flex-wrap">
                    <h4 class="text-sm md:text-base font-black text-rose-900 leading-none">Ditolak</h4>
                    <span class="text-xs font-medium text-slate-400" x-text="activeItem.updated_at_formatted || '-'"></span>
                </div>
                <p class="text-xs md:text-sm text-slate-500 font-medium leading-relaxed">Permohonan tidak dipenuhi</p>

                <div class="p-4 bg-rose-50/90 rounded-2xl text-xs md:text-sm text-rose-950 space-y-1.5 border border-rose-200/90 font-medium">
                    <div class="text-[14px] font-black text-rose-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i> Alasan Penolakan:
                    </div>
                    <p class="leading-relaxed text-slate-800 font-semibold whitespace-pre-line" x-text="activeItem.alasan_ditolak || activeItem.pesan_ditolak || activeItem.catatan_final || 'Tidak ada catatan alasan penolakan.'"></p>
                </div>

                <div class="pt-1">
                    <template x-if="activeItem.type === 'permohonan'">
                        <div>
                            <template x-if="activeItem.has_keberatan">
                                <div class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-200 text-slate-700 font-extrabold text-xs rounded-xl">
                                    <i class="fa-solid fa-check-circle text-emerald-600"></i> Keberatan Sudah Diajukan Untuk Permohonan Ini
                                </div>
                            </template>
                            <template x-if="!activeItem.has_keberatan">
                                <a :href="'{{ url('/pengajuan-keberatan') }}?tiket=' + activeItem.no_tiket" class="inline-flex items-center gap-2 px-5 py-3 bg-rose-600 hover:bg-rose-700 text-white font-extrabold text-xs md:text-sm rounded-xl shadow-md transition">
                                    <i class="fa-solid fa-scale-balanced"></i> Ajukan Keberatan
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </template>

</div>
