<!-- DETAIL Rincian Layanan Tiket -->
<div class="space-y-4 text-xs md:text-sm">
    
    <!-- Row 1: Tanggal Pengajuan & Selesai Paling Lambat -->
    <div class="grid grid-cols-2 gap-3 p-3.5 bg-slate-50/80 rounded-2xl border border-slate-100">
        <div>
            <span class="block font-bold text-slate-500 text-xs">Tanggal Pengajuan</span>
            <span class="block font-black text-slate-900 text-xs sm:text-sm md:text-base mt-1" x-text="activeItem.tanggal_pengajuan || '-'"></span>
        </div>

        <div>
            <span class="block font-bold text-slate-500 text-xs">Selesai Paling Lambat</span>
            <span class="block font-black text-slate-900 text-xs sm:text-sm md:text-base mt-1" x-text="activeItem.estimasi_selesai || '-'"></span>
        </div>
    </div>

    <!-- Pengecekan agar Cara Memperoleh Informasi tidak muncul saat tipe keberatan -->
    <template x-if="activeItem.type !== 'keberatan'">
        <div class="p-3.5 bg-slate-50/80 rounded-2xl border border-slate-100">
            <span class="block font-bold text-slate-500 text-xs">Cara Memperoleh Informasi</span>
            <span class="block font-black text-slate-900 text-xs sm:text-sm md:text-base mt-1 leading-snug" 
                  x-text="!activeItem.cara_memperoleh_informasi ? '-' : (
                      activeItem.cara_memperoleh_informasi.toLowerCase().includes('email') 
                      ? 'Dikirim melalui Email' 
                      : (activeItem.cara_memperoleh_informasi.toLowerCase().includes('dekanat') || activeItem.cara_memperoleh_informasi.toLowerCase().includes('langsung')
                          ? 'Datang langsung ke Dekanat FMIPA Universitas Lampung' 
                          : activeItem.cara_memperoleh_informasi)
                  )"></span>
        </div>
    </template>

    <!-- Informasi yang Diminta / Alasan Keberatan -->
    <div class="p-4 bg-white rounded-2xl border border-slate-200/90 space-y-1 shadow-sm">
        <span class="block font-extrabold text-slate-500 text-xs" x-text="activeItem.type === 'keberatan' ? 'Alasan Keberatan' : 'Informasi Yang Diminta'"></span>
        <p class="font-black text-slate-900 text-sm md:text-base leading-relaxed break-words [word-break:break-word] break-all" x-text="activeItem.type === 'keberatan' ? (activeItem.alasan_keberatan || activeItem.judul) : (activeItem.informasi_yang_diminta || activeItem.judul)"></p>
    </div>

    <!-- Kronologi / Tujuan Penggunaan -->
    <template x-if="activeItem.deskripsi || activeItem.tujuan_penggunaan_informasi || activeItem.kronologi_keberatan">
        <div class="p-4 bg-white rounded-2xl border border-slate-200/90 space-y-1 shadow-sm">
            <span class="block font-extrabold text-slate-500 text-xs" x-text="activeItem.type === 'keberatan' ? 'Kronologi Keberatan' : 'Tujuan Penggunaan Informasi'"></span>
            <p class="font-semibold text-slate-800 text-xs md:text-sm leading-relaxed break-words [word-break:break-word] break-all" x-text="activeItem.type === 'keberatan' ? (activeItem.kronologi_keberatan || activeItem.deskripsi) : (activeItem.tujuan_penggunaan_informasi || activeItem.deskripsi)"></p>
        </div>
    </template>

    <!-- Dokumen Identitas (KTP / SIM) -->
    <template x-if="activeItem.type !== 'keberatan'">
        <div class="pt-2">
            <span class="block font-bold text-slate-500 text-xs mb-1.5">Dokumen Identitas (KTP / SIM)</span>
            <div>
                <template x-if="activeItem.file_identitas || activeItem.identitas_file || activeItem.identitas_file_url">
                    <a :href="activeItem.identitas_file_url || ('/storage/' + (activeItem.file_identitas || activeItem.identitas_file))" target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-50 hover:bg-sky-100 text-sky-700 font-extrabold rounded-xl border border-sky-200/80 transition text-xs sm:text-sm shadow-xs">
                        <i class="fa-solid fa-id-card text-sky-600"></i>
                        <span>Lihat Identitas</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-sky-500"></i>
                    </a>
                </template>
                <template x-if="!activeItem.file_identitas && !activeItem.identitas_file && !activeItem.identitas_file_url">
                    <span class="font-black text-slate-400">-</span>
                </template>
            </div>
        </div>
    </template>

    <!-- Dokumen Pendukung -->
    <div class="pt-2">
        <span class="block font-bold text-slate-500 text-xs mb-1.5" x-text="activeItem.type === 'keberatan' ? 'Dokumen Pendukung Keberatan' : 'Dokumen Pendukung Permohonan'"></span>
        <div>
            <template x-if="activeItem.file_pendukung || activeItem.pendukung_file || activeItem.file_pendukung_url">
                <a :href="activeItem.file_pendukung_url || ('/storage/' + (activeItem.file_pendukung || activeItem.pendukung_file))" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-50 hover:bg-sky-100 text-sky-700 font-extrabold rounded-xl border border-sky-200/80 transition text-xs sm:text-sm shadow-xs">
                    <i class="fa-solid fa-file-lines text-sky-600"></i>
                    <span>Lihat Dokumen Pendukung</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-sky-500"></i>
                </a>
            </template>
            <template x-if="!activeItem.file_pendukung && !activeItem.pendukung_file && !activeItem.file_pendukung_url">
                <span class="font-black text-slate-400">-</span>
            </template>
        </div>
    </div>
</div>