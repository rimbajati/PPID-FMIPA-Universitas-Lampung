<!-- Modal Delete Single -->
<div id="modal-delete" class="hidden fixed inset-0 z-[2000] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full border border-slate-100 shadow-2xl">
        <h3 class="text-xl font-bold text-center mb-2">Hapus Data?</h3>
        <p class="text-sm text-slate-500 text-center mb-8 italic" id="delete-item-name"></p>
        <div class="flex gap-3">
            <button onclick="closeModal('modal-delete')" class="flex-1 py-3 bg-slate-100 rounded-xl font-bold text-sm">Batal</button>
            <form id="form-delete" action="" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="w-full py-3 bg-red-600 text-white rounded-xl font-bold text-sm">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Bulk -->
<div id="modal-bulk-delete" class="hidden fixed inset-0 z-[2000] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full border border-slate-100 shadow-2xl">
        <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl mb-6 mx-auto"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h3 class="text-xl font-bold text-center mb-2">Hapus <span id="bulk-count">0</span> Data?</h3>
        <p class="text-sm text-slate-500 text-center mb-8 leading-relaxed">
            Apakah Anda yakin ingin menghapus semua data yang terpilih secara permanen?
        </p>
        <div class="flex gap-3">
            <button onclick="closeModal('modal-bulk-delete')" class="flex-1 py-3 bg-slate-100 rounded-xl font-bold text-sm">Batal</button>
            <button onclick="document.getElementById('bulk-delete-form').submit()" class="flex-1 py-3 bg-red-600 text-white rounded-xl font-bold text-sm">Ya, Hapus Semua</button>
        </div>
    </div>
</div>
