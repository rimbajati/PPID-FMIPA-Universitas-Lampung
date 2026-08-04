<!-- Modal Delete Confirmation -->
<div id="modal-delete" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-none w-full max-w-md shadow-2xl border border-slate-200 overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-6 sm:p-8 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-none bg-red-50 mb-5 border border-red-100">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 mb-2">Konfirmasi Hapus</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed">Apakah Anda yakin ingin menghapus pengajuan dengan nomor tiket <span id="delete-ticket-display" class="font-bold text-slate-900"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="toggleModal('modal-delete', false)" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-none font-bold text-sm transition">
                    Batal
                </button>
                <button type="button" id="confirm-delete-btn" class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white rounded-none font-bold text-sm transition shadow-md">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

