<!-- Modal Konfirmasi Hapus Data (Single / Bulk) -->
<div id="modalConfirmDelete" class="hidden fixed inset-0 z-[999999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border-0 space-y-6 text-center animate-in fade-in zoom-in duration-200">
        <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center text-2xl mx-auto shadow-inner">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="space-y-2">
            <h3 class="text-xl font-black text-slate-900">Konfirmasi Hapus</h3>
            <p id="deleteConfirmText" class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        <div class="flex items-center justify-center gap-3 pt-2">
            <button type="button" onclick="closeDeleteModal()" 
                    class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-extrabold rounded-xl transition cursor-pointer">
                Batal
            </button>
            <button type="button" onclick="executeDelete()" 
                    class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white text-xs sm:text-sm font-extrabold rounded-xl transition shadow-md cursor-pointer">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>
