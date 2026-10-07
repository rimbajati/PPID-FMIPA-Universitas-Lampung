<!-- DETAIL Rincian Permohonan -->
<div class="space-y-4 text-xs md:text-sm">

    <div class="p-5 bg-white rounded-2xl border border-slate-200/90 shadow-sm space-y-4">
        
        <div class="pb-3 border-b border-slate-100">
            <span class="block font-bold text-slate-900 text-xs sm:text-sm mb-1">Nama Pemohon</span>
            <span class="block font-normal text-slate-700 text-sm md:text-base" x-text="activeItem.nama_pemohon || '-'"></span>
        </div>

        <div class="pb-3 border-b border-slate-100">
            <span class="block font-bold text-slate-900 text-xs sm:text-sm mb-1">Waktu Pengajuan</span>
            <span class="block font-normal text-slate-700 text-sm md:text-base" x-text="activeItem.waktu_pengajuan || '-'"></span>
        </div>

        <template x-if="activeItem.type !== 'keberatan'">
            <div class="pb-3 border-b border-slate-100">
                <span class="block font-bold text-slate-900 text-xs sm:text-sm mb-1">Cara Memperoleh Informasi</span>
                <span class="block font-normal text-slate-700 text-sm leading-snug" x-text="activeItem.cara_memperoleh || '-'"></span>
            </div>
        </template>

        <template x-if="activeItem.type !== 'keberatan'">
            <div class="pb-3 border-b border-slate-100">
                <span class="block font-bold text-slate-900 text-xs sm:text-sm mb-1">Informasi yang Diminta</span>
                <p class="font-normal text-slate-700 text-sm md:text-base leading-relaxed break-words [word-break:normal] [overflow-wrap:break-word]"
                   x-text="activeItem.info_diminta || '-'"></p>
            </div>
        </template>

        <template x-if="activeItem.type !== 'keberatan'">
            <div>
                <span class="block font-bold text-slate-900 text-xs sm:text-sm mb-1">Tujuan Penggunaan Informasi</span>
                <p class="font-normal text-slate-700 text-sm md:text-base leading-relaxed break-words [word-break:normal] [overflow-wrap:break-word]"
                   x-text="activeItem.tujuan_penggunaan || '-'"></p>
            </div>
        </template>

        <template x-if="activeItem.type === 'keberatan'">
            <div class="pb-3 border-b border-slate-100">
                <span class="block font-bold text-slate-900 text-xs sm:text-sm mb-1">Alasan Pengajuan Keberatan</span>
                <p class="font-normal text-slate-700 text-sm md:text-base leading-relaxed break-words [word-break:normal] [overflow-wrap:break-word]"
                   x-text="activeItem.alasan_keberatan || activeItem.judul || '-'"></p>
            </div>
        </template>

        <template x-if="activeItem.type === 'keberatan'">
            <div>
                <span class="block font-bold text-slate-900 text-xs sm:text-sm mb-1">Kronologi Pengajuan Keberatan</span>
                <p class="font-normal text-slate-700 text-sm md:text-base leading-relaxed break-words [word-break:normal] [overflow-wrap:break-word] whitespace-pre-wrap"
                   x-text="activeItem.kronologi_keberatan || '-'"></p>
            </div>
        </template>

    </div>

</div>
