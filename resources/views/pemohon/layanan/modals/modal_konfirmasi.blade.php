<!-- Modal Konfirmasi Kirim -->
<div id="modal-confirm-submit" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl animate-in fade-in zoom-in duration-300">
        <div class="text-center">
            <div class="w-16 h-16 bg-blue-50 text-blue-900 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-100">
                <i class="fa-solid fa-circle-question text-3xl"></i>
            </div>
            <h3 class="text-xl font-extrabold text-slate-900 mb-2">Konfirmasi Pengajuan</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed">Apakah data pengajuan yang Anda masukkan sudah sesuai?</p>
            <div class="flex gap-3">
                <button type="button" onclick="toggleModal('modal-confirm-submit', false)" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold transition">Batal</button>
                <button type="button" id="confirm-submit-btn" class="flex-1 py-3 bg-blue-900 hover:bg-blue-950 text-white rounded-xl font-bold transition shadow-md">Ya, Kirim</button>
            </div>
        </div>
    </div>
</div>

