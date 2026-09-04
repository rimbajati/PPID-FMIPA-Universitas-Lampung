<!-- DETAIL HASIL TRACKING REAL-TIME -->
<template x-if="activeItem">
    <div id="hasil-tracking" class="max-w-7xl mx-auto space-y-7 scroll-mt-28">
        
        <!-- Clean Light Theme Header Banner Tiket -->
        <div class="border rounded-3xl p-6 md:p-7 shadow-xl relative overflow-hidden transition-all duration-300"
             :class="activeItem.type === 'keberatan' 
                     ? 'bg-gradient-to-r from-amber-50/90 via-amber-50/30 to-white border-amber-200/90 shadow-amber-500/5' 
                     : 'bg-gradient-to-r from-blue-50/90 via-blue-50/30 to-white border-blue-200/90 shadow-blue-500/5'">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                
                <!-- Left Column: Icon + Type + Ticket Number -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl flex items-center justify-center text-xl md:text-2xl font-black shadow-xs border shrink-0 transition"
                         :class="activeItem.type === 'keberatan' ? 'bg-amber-500 text-white border-amber-600 shadow-amber-500/20' : 'bg-blue-600 text-white border-blue-700 shadow-blue-600/20'">
                        <i :class="activeItem.type === 'keberatan' ? 'fa-solid fa-scale-balanced' : 'fa-solid fa-file-lines'"></i>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-[10px] sm:text-xs font-extrabold tracking-wide border shadow-2xs"
                                  :class="activeItem.type === 'keberatan' ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-blue-50 text-blue-600 border-blue-200'"
                                  x-text="activeItem.type === 'keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi'"></span>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-black text-slate-900 font-mono tracking-tight" 
                            x-text="activeItem.no_tiket.startsWith('REQ-') || activeItem.no_tiket.startsWith('OBJ-') ? activeItem.no_tiket : '#' + activeItem.no_tiket"></h3>
                    </div>
                </div>

                <!-- Right Column: Glow Status Badge -->
                <div class="self-start sm:self-center shrink-0">
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl text-xs sm:text-sm font-black uppercase tracking-wider border shadow-2xs"
                         :class="{
                             'bg-emerald-50 text-emerald-700 border-emerald-200/80': activeItem.status === 'Terima' || activeItem.status === 'Selesai',
                             'bg-amber-50 text-amber-700 border-amber-200/80': activeItem.status === 'Diproses' || activeItem.status === 'Verifikasi' || activeItem.status === 'Pemeriksaan',
                             'bg-rose-50 text-rose-700 border-rose-200/80': activeItem.status === 'Ditolak',
                             'bg-slate-100 text-slate-700 border-slate-200/80': activeItem.status === 'Menunggu' || activeItem.status === 'Diajukan'
                         }">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"
                                  :class="{
                                      'bg-emerald-400': activeItem.status === 'Terima' || activeItem.status === 'Selesai',
                                      'bg-amber-400': activeItem.status === 'Diproses' || activeItem.status === 'Verifikasi' || activeItem.status === 'Pemeriksaan',
                                      'bg-rose-400': activeItem.status === 'Ditolak',
                                      'bg-slate-400': activeItem.status === 'Menunggu' || activeItem.status === 'Diajukan'
                                  }"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5"
                                  :class="{
                                      'bg-emerald-500': activeItem.status === 'Terima' || activeItem.status === 'Selesai',
                                      'bg-amber-500': activeItem.status === 'Diproses' || activeItem.status === 'Verifikasi' || activeItem.status === 'Pemeriksaan',
                                      'bg-rose-500': activeItem.status === 'Ditolak',
                                      'bg-slate-500': activeItem.status === 'Menunggu' || activeItem.status === 'Diajukan'
                                  }"></span>
                        </span>
                        <span x-text="activeItem.status"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid 2 Kolom Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">
            
            <!-- KIRI (7/12): TIMELINE RIWAYAT PROSES VERTIKAL ELEGANT -->
            <div class="lg:col-span-7 bg-white border border-slate-200/80 p-6 md:p-8 rounded-3xl shadow-xl shadow-slate-200/50 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3 text-slate-900 font-black text-lg">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-base shadow-xs border border-emerald-100">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <span>Riwayat Proses</span>
                    </div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Waktu Pembaruan</span>
                </div>

                <x-masyarakat.riwayat.timeline />
            </div>

            <!-- KANAN (5/12): RINCIAN DATA TIKET -->
            <div class="lg:col-span-5 bg-white border border-slate-200/80 p-6 md:p-8 rounded-3xl shadow-xl shadow-slate-200/50 space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100 text-slate-900 font-black text-lg">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-base shadow-xs border border-emerald-100">
                        <i class="fa-solid fa-circle-info"></i>
                    </div>
                    <span>Rincian Layanan</span>
                </div>

                <x-masyarakat.riwayat.detail-info />
            </div>

        </div>

    </div>
</template>
