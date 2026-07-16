<!-- Modal Delete Confirmation -->
<div id="modal-delete" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-4 border border-red-100">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Konfirmasi Hapus</h3>
            <p class="text-slate-500 text-sm mb-6">Apakah Anda yakin ingin menghapus pengajuan dengan nomor tiket <span id="delete-ticket-display" class="font-bold text-slate-800"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-center">
                <button onclick="toggleModal('modal-delete', false)" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-sm transition-all">
                    Batal
                </button>
                <button id="confirm-delete-btn" class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-red-200">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

