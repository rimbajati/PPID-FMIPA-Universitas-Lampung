<!-- DETAIL HASIL TRACKING REAL-TIME -->
<template x-if="activeItem">
    <div id="hasil-tracking" class="max-w-7xl mx-auto space-y-6 scroll-mt-28">
        
        <!-- Header Banner Tiket -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden">
            <div class="p-6 md:p-8 text-white relative overflow-hidden"
                 :class="activeItem.type === 'keberatan' ? 'bg-gradient-to-r from-orange-500 via-orange-600 to-amber-700' : 'bg-gradient-to-r from-sky-600 via-sky-700 to-blue-800'">
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-white text-2xl font-black shadow-inner border border-white/20 shrink-0">
                            <i :class="activeItem.type === 'keberatan' ? 'fa-solid fa-scale-balanced' : 'fa-solid fa-file-lines'"></i>
                        </div>
                        <div>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/20 text-white border border-white/25 mb-1"
                                  x-text="activeItem.type === 'keberatan' ? 'PENGAJUAN KEBERATAN' : 'PERMOHONAN INFORMASI'"></span>
                            <h3 class="text-2xl md:text-3xl font-black text-white font-mono tracking-tight" x-text="activeItem.no_tiket.startsWith('REQ-') || activeItem.no_tiket.startsWith('OBJ-') ? activeItem.no_tiket : '#' + activeItem.no_tiket"></h3>
                        </div>
                    </div>

                    <!-- Badge Status Right Top -->
                    <div class="self-end sm:self-center">
                        <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl text-xs font-black uppercase tracking-wider shadow-md bg-white"
                              :class="{
                                  'text-emerald-700': activeItem.status === 'Terima' || activeItem.status === 'Selesai',
                                  'text-amber-700': activeItem.status === 'Diproses' || activeItem.status === 'Verifikasi' || activeItem.status === 'Pemeriksaan',
                                  'text-rose-700': activeItem.status === 'Ditolak',
                                  'text-slate-700': activeItem.status === 'Menunggu' || activeItem.status === 'Diajukan'
                              }">
                            <i :class="activeItem.status === 'Ditolak' ? 'fa-solid fa-circle-xmark text-rose-600' : 'fa-solid fa-circle text-[8px]'"></i>
                            <span x-text="activeItem.status"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid 2 Kolom Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- KIRI (7/12): TIMELINE RIWAYAT PROSES VERTIKAL ELEGANT -->
            <div class="lg:col-span-7 bg-white border border-slate-200/90 p-6 md:p-8 rounded-3xl shadow-xl space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3 text-slate-900 font-black text-lg">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#1B365D] flex items-center justify-center text-base">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <span>Riwayat Proses</span>
                    </div>
                    <span class="text-sm font-bold text-slate-600 ">Waktu Pembaruan</span>
                </div>

                <x-masyarakat.riwayat.timeline />
            </div>

            <!-- KANAN (5/12): RINCIAN DATA TIKET -->
            <div class="lg:col-span-5 bg-white border border-slate-200/90 p-6 md:p-8 rounded-3xl shadow-xl space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100 text-slate-900 font-black text-lg">
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-[#1B365D] flex items-center justify-center text-base">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <span>Rincian Layanan</span>
                </div>

                <x-masyarakat.riwayat.detail-info />
            </div>

        </div>

    </div>
</template>
