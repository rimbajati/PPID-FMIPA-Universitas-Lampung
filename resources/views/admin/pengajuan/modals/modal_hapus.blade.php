<!-- Modal Delete Single -->
<div id="modal-delete" class="hidden fixed inset-0 z-[2000] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-none p-6 sm:p-8 max-w-sm w-full border border-slate-200 shadow-2xl">
        <div class="w-16 h-16 bg-red-50 text-red-600 rounded-none flex items-center justify-center text-3xl mb-5 mx-auto border border-red-100"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h3 class="text-xl font-extrabold text-slate-900 text-center mb-2">Hapus Data?</h3>
        <p class="text-sm text-slate-500 text-center mb-6 leading-relaxed italic" id="delete-item-name"></p>
        <div class="flex gap-3">
            <button onclick="closeModal('modal-delete')" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-none font-bold text-sm transition">Batal</button>
            <form id="form-delete" action="" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-none font-bold text-sm transition shadow-md">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Bulk -->
<div id="modal-bulk-delete" class="hidden fixed inset-0 z-[2000] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-none p-6 sm:p-8 max-w-sm w-full border border-slate-200 shadow-2xl">
        <div class="w-16 h-16 bg-red-50 text-red-600 rounded-none flex items-center justify-center text-3xl mb-5 mx-auto border border-red-100"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h3 class="text-xl font-extrabold text-slate-900 text-center mb-2">Hapus <span id="bulk-count">0</span> Data?</h3>
        <p class="text-sm text-slate-500 text-center mb-6 leading-relaxed">
            Apakah Anda yakin ingin menghapus semua data yang terpilih secara permanen?
        </p>
        <div class="flex gap-3">
            <button onclick="closeModal('modal-bulk-delete')" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-none font-bold text-sm transition">Batal</button>
            <button onclick="document.getElementById('bulk-delete-form').submit()" class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white rounded-none font-bold text-sm transition shadow-md">Ya, Hapus Semua</button>
        </div>
    </div>
</div>
