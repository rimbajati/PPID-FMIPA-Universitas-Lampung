<!-- DETAIL HASIL TRACKING REAL-TIME -->
<template x-if="activeItem">
    <div id="hasil-tracking" class="max-w-7xl mx-auto space-y-7 scroll-mt-28">
        
        <!-- Ticket Sheet — mirip referensi, isi data sistem -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <!-- Dynamic header bar -->
            <div class="flex items-center justify-between px-5 sm:px-7 py-4 text-white"
                 :class="activeItem.type === 'keberatan' ? 'bg-amber-500' : 'bg-[#1e4bd8]'">
                <span class="text-base sm:text-lg font-bold">Tiket : <span class="font-mono font-black tracking-wide text-lg sm:text-xl ml-1" x-text="activeItem.no_tiket || '-'"></span></span>
            </div>
            <!-- Body: dashed fields -->
            <div class="px-4 sm:px-6 py-5 space-y-5">
                <!-- Baris 1 -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Pemohon :</p>
                        <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2 break-words" x-text="activeItem.nama_pemohon || '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Layanan :</p>
                        <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2" x-text="activeItem.type === 'keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi'"></p>
                        <template x-if="activeItem.type === 'keberatan' && activeItem.tiket_permohonan_asal">
                            <p class="text-[11px] text-slate-500 mt-1">Permohonan asal: <span class="font-mono font-semibold" x-text="activeItem.tiket_permohonan_asal"></span></p>
                        </template>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Tanggal Pengajuan :</p>
                        <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2" x-text="activeItem.waktu_pengajuan || activeItem.created_at_formatted || activeItem.tanggal_pengajuan || '-'"></p>
                    </div>
                </div>
                <!-- Baris 2: tanggal/status -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Tanggal Diproses :</p>
                        <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2" x-text="activeItem.status !== 'Diajukan' ? (activeItem.updated_at_formatted || '-') : '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Tanggal Selesai :</p>
                        <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2" x-text="(activeItem.status === 'Selesai' || activeItem.status === 'Ditolak') ? (activeItem.updated_at_formatted || '-') : '-'"></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Status :</p>
                        <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2" x-text="activeItem.status || '-'"></p>
                    </div>
                </div>
                <!-- Baris 3: Alasan (full width) -->
                <div>
                    <p class="text-xs text-slate-600 mb-1">Alasan Pengajuan Keberatan :</p>
                    <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2 break-words leading-relaxed whitespace-pre-wrap" x-text="activeItem.type === 'keberatan' ? (activeItem.alasan_keberatan || activeItem.judul || '-') : (activeItem.info_diminta || '-')"></p>
                </div>
                <!-- Baris 4: Kronologi -->
                <div>
                    <p class="text-xs text-slate-600 mb-1" x-text="activeItem.type === 'keberatan' ? 'Kronologi Pengajuan Keberatan :' : 'Tujuan Penggunaan Informasi :'"></p>
                    <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2 break-words leading-relaxed whitespace-pre-wrap" x-text="activeItem.type === 'keberatan' ? (activeItem.kronologi_keberatan || '-') : (activeItem.tujuan_penggunaan || '-')"></p>
                </div>
                <!-- Baris 5: Cara memperoleh (permohonan saja) -->
                <template x-if="activeItem.type !== 'keberatan'">
                    <div>
                        <p class="text-xs text-slate-600 mb-1">Cara Memperoleh Informasi :</p>
                        <p class="text-sm text-slate-600 border-b border-dashed border-slate-300 pb-2 break-words leading-relaxed whitespace-pre-wrap" x-text="activeItem.cara_memperoleh || '-'"></p>
                    </div>
                </template>
                <!-- Baris 6: catatan full width -->
                <div>
                    <p class="text-xs text-slate-600 mb-1" x-text="activeItem.status === 'Ditolak' ? 'Alasan Penolakan :' : 'Catatan PPID :'"></p>
                    <div class="text-sm text-slate-600 leading-relaxed space-y-1 border-b border-dashed border-slate-300 pb-2">
                        <template x-if="activeItem.status === 'Ditolak'">
                            <p :class="!activeItem.alasan_ditolak ? 'text-slate-400' : ''" x-text="activeItem.alasan_ditolak || '-'"></p>
                        </template>
                        <template x-if="activeItem.status === 'Selesai'">
                            <p :class="!(activeItem.catatan_selesai || activeItem.catatan_diproses) ? 'text-slate-400' : ''" x-text="activeItem.catatan_selesai || activeItem.catatan_diproses || '-'"></p>
                        </template>
                        <template x-if="activeItem.status === 'Diproses'">
                            <p :class="!activeItem.catatan_diproses ? 'text-slate-400' : ''" x-text="activeItem.catatan_diproses || '-'"></p>
                        </template>
                        <template x-if="activeItem.status === 'Diajukan'">
                            <p class="text-slate-400">-</p>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
