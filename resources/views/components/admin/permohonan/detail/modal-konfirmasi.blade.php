@props(['noTiket'])

<template x-teleport="body">
    <div x-show="showConfirmModal" x-cloak 
         class="fixed inset-0 z-[999999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity"
         @keydown.escape.window="showConfirmModal = false">
        <div class="bg-white rounded-3xl p-7 sm:p-8 max-w-md w-full shadow-2xl space-y-6 text-center border border-slate-100 animate-in fade-in zoom-in duration-150"
             @click.away="showConfirmModal = false">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto shadow-inner"
                 :class="{
                    'bg-orange-100 text-orange-600': statusSelect === 'Diproses',
                    'bg-emerald-100 text-emerald-600': statusSelect === 'Selesai',
                    'bg-rose-100 text-rose-600': statusSelect === 'Ditolak'
                 }">
                <i :class="{
                    'fa-solid fa-gears': statusSelect === 'Diproses',
                    'fa-solid fa-circle-check': statusSelect === 'Selesai',
                    'fa-solid fa-triangle-exclamation': statusSelect === 'Ditolak'
                }"></i>
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Konfirmasi Perubahan Status</h3>
                <p class="text-sm text-slate-600 leading-relaxed font-medium">
                    Apakah Anda yakin ingin mengubah status permohonan informasi ini menjadi 
                    <span class="font-black px-2 py-0.5 rounded text-xs inline-block"
                          :class="{
                            'bg-orange-100 text-orange-800': statusSelect === 'Diproses',
                            'bg-emerald-100 text-emerald-800': statusSelect === 'Selesai',
                            'bg-rose-100 text-rose-800': statusSelect === 'Ditolak'
                          }"
                          x-text="statusSelect"></span>?
                </p>
                <p class="text-xs text-slate-400 font-medium pt-1">
                    Perubahan ini akan langsung dicatat pada sistem dan mengirimkan notifikasi ke pemohon.
                </p>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="button" @click="showConfirmModal = false" 
                        class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-extrabold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="button" @click="$refs.statusForm.submit()" 
                        class="w-full py-3 text-white text-sm font-extrabold rounded-xl transition shadow-md cursor-pointer"
                        :class="{
                            'bg-orange-500 hover:bg-orange-600': statusSelect === 'Diproses',
                            'bg-emerald-600 hover:bg-emerald-700': statusSelect === 'Selesai',
                            'bg-rose-600 hover:bg-rose-700': statusSelect === 'Ditolak'
                        }">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>
</template>
