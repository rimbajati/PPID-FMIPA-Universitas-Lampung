<!-- DETAIL HASIL TRACKING REAL-TIME -->
<template x-if="activeItem">
    <div id="hasil-tracking" class="max-w-7xl mx-auto space-y-7 scroll-mt-28">
        
        <!-- Ticket Sheet — mirip referensi, isi data sistem -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <!-- Dynamic header bar -->
            <div class="flex items-center justify-between px-6 sm:px-8 py-5 text-white"
                 :class="activeItem.type === 'keberatan' ? 'bg-amber-500' : 'bg-[#1e4bd8]'">
                <span class="text-lg sm:text-xl font-bold">Tiket : <span class="font-mono font-black tracking-wide text-xl sm:text-2xl ml-1" x-text="activeItem.no_tiket || '-'"></span></span>
            </div>
            <!-- Body: dashed fields -->
            <div class="px-5 sm:px-8 py-6 space-y-6">
                <!-- Baris 1 -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 sm:gap-8">
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-1.5">Pemohon :</p>
                        <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5 break-words" x-text="activeItem.nama_pemohon || '-'"></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-1.5">Layanan :</p>
                        <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5" x-text="activeItem.type === 'keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi'"></p>
                        <template x-if="activeItem.type === 'keberatan' && activeItem.tiket_permohonan_asal">
                            <p class="text-xs text-slate-500 mt-1.5">Permohonan asal: <span class="font-mono font-semibold" x-text="activeItem.tiket_permohonan_asal"></span></p>
                        </template>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-1.5">Tanggal Pengajuan :</p>
                        <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5" x-text="activeItem.waktu_pengajuan || activeItem.created_at_formatted || activeItem.tanggal_pengajuan || '-'"></p>
                    </div>
                </div>
                <!-- Baris 2: tanggal/status -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 sm:gap-8">
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-1.5">Tanggal Diproses :</p>
                        <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5" x-text="activeItem.status !== 'Diajukan' ? (activeItem.updated_at_formatted || '-') : '-'"></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-1.5">Tanggal Selesai :</p>
                        <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5" x-text="(activeItem.status === 'Selesai' || activeItem.status === 'Ditolak') ? (activeItem.updated_at_formatted || '-') : '-'"></p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-1.5">Status :</p>
                        <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5" x-text="activeItem.status || '-'"></p>
                    </div>
                </div>
                <!-- Baris 3: Alasan / Informasi yang Diminta (full width) -->
                <div>
                    <p class="text-sm font-semibold text-slate-700 mb-1.5" x-text="activeItem.type === 'keberatan' ? 'Alasan Pengajuan Keberatan :' : 'Informasi yang Diminta :'"></p>
                    <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5 break-words leading-relaxed whitespace-pre-wrap" x-text="activeItem.type === 'keberatan' ? (activeItem.alasan_keberatan || activeItem.judul || '-') : (activeItem.info_diminta || '-')"></p>
                </div>
                <!-- Baris 4: Kronologi -->
                <div>
                    <p class="text-sm font-semibold text-slate-700 mb-1.5" x-text="activeItem.type === 'keberatan' ? 'Kronologi Pengajuan Keberatan :' : 'Tujuan Penggunaan Informasi :'"></p>
                    <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5 break-words leading-relaxed whitespace-pre-wrap" x-text="activeItem.type === 'keberatan' ? (activeItem.kronologi_keberatan || '-') : (activeItem.tujuan_penggunaan || '-')"></p>
                </div>
                <!-- Baris 5: Cara memperoleh (permohonan saja) -->
                <template x-if="activeItem.type !== 'keberatan'">
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-1.5">Cara Memperoleh Informasi :</p>
                        <p class="text-base text-slate-800 font-medium border-b border-dashed border-slate-300 pb-2.5 break-words leading-relaxed whitespace-pre-wrap" x-text="activeItem.cara_memperoleh || '-'"></p>
                    </div>
                </template>
                <!-- Baris 6: Pesan PPID — tampil di Diproses/Selesai/Ditolak -->
                <div>
                    <p class="text-sm font-semibold text-slate-700 mb-1.5">Pesan PPID :</p>
                    <div class="text-base text-slate-800 font-medium leading-relaxed space-y-1 border-b border-dashed border-slate-300 pb-2.5">
                        <template x-if="activeItem.status === 'Diproses'">
                            <p :class="!activeItem.catatan_diproses ? 'text-slate-400 font-normal' : ''" x-text="activeItem.catatan_diproses || '-'"></p>
                        </template>
                        <template x-if="activeItem.status === 'Selesai' || activeItem.status === 'Ditolak'">
                            <p :class="!activeItem.catatan_selesai ? 'text-slate-400 font-normal' : ''" x-text="activeItem.catatan_selesai || '-'"></p>
                        </template>
                        <template x-if="activeItem.status === 'Diajukan'">
                            <p class="text-slate-400 font-normal">-</p>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
