<!-- Modal Konfirmasi Kirim -->
<div id="modal-confirm-submit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-none w-full max-w-md p-6 sm:p-8 shadow-2xl border border-slate-200 animate-in fade-in zoom-in duration-300">
        <div class="text-center">
            <h3 class="text-xl font-extrabold text-slate-900 mb-2">Konfirmasi Pengajuan</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed">Apakah data pengajuan yang Anda masukkan sudah sesuai?</p>
            <div class="flex gap-3">
                <button type="button" onclick="toggleModal('modal-confirm-submit', false)" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-none font-bold text-sm transition">Batal</button>
                <button type="button" id="confirm-submit-btn" class="flex-1 py-3 bg-[#1B365D] hover:bg-[#162c4c] text-white rounded-none font-bold text-sm transition shadow-md">Ya, Kirim</button>
            </div>
        </div>
    </div>
</div>

