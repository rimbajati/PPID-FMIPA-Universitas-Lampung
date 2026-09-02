<!-- MODAL POPUP SUKSES PERMOHONAN DENGAN NOMOR TIKET -->
@if(session('success_tiket'))
<div x-data="{ openSuccessModal: true, copied: false }" 
     x-show="openSuccessModal" 
     x-cloak 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95">
    
    <div class="bg-white border border-slate-200 shadow-2xl max-w-lg w-full overflow-hidden text-center space-y-5 p-6 sm:p-8 relative" style="border-radius: 12px !important;">
        
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-3xl shadow-inner">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <div class="space-y-1.5">
            <h3 class="text-xl sm:text-2xl font-black text-slate-900">Permohonan Berhasil Dikirim!</h3>
            <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed max-w-md mx-auto">
                Permohonan informasi Anda telah kami terima dan akan segera diproses oleh admin PPID FMIPA Unila.
            </p>
        </div>

        <div class="bg-slate-50 border border-slate-200 p-4 rounded-xl space-y-2" style="border-radius: 8px !important;">
            <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor Tiket Anda</span>
            <div class="flex items-center justify-center gap-2">
                <span class="font-mono text-xl sm:text-2xl font-black text-[#1B365D] tracking-wider select-all" id="noTiketText">{{ session('success_tiket') }}</span>
                <button type="button" 
                        @click="navigator.clipboard.writeText('{{ session('success_tiket') }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="px-2.5 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold transition cursor-pointer flex items-center gap-1"
                        style="border-radius: 6px !important;"
                        title="Salin Nomor Tiket">
                    <i class="fa-solid" :class="copied ? 'fa-check text-emerald-600' : 'fa-copy'"></i>
                    <span x-text="copied ? 'Tersalin' : 'Salin'"></span>
                </button>
            </div>
            <p class="text-[11px] text-slate-400 italic">Simpan nomor tiket ini untuk mengecek status permohonan Anda.</p>
        </div>

        <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ url('/riwayat-layanan') }}" class="w-full sm:w-auto px-6 py-3 bg-[#1B365D] hover:bg-[#102a45] text-white text-xs sm:text-sm font-bold transition flex items-center justify-center gap-2 cursor-pointer shadow-md" style="border-radius: 6px !important;">
                <i class="fa-solid fa-clock-rotate-left"></i> Cek Status Layanan
            </a>
            <button type="button" @click="openSuccessModal = false" class="w-full sm:w-auto px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-bold transition cursor-pointer" style="border-radius: 6px !important;">
                Tutup
            </button>
        </div>

    </div>
</div>
@endif
