<!-- Modal Summary -->
<div id="modal-summary" class="fixed inset-0 bg-slate-900/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-6xl shadow-xl overflow-hidden flex flex-col max-h-[92vh]">
        <div class="px-8 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50 flex-shrink-0">
            <h2 class="text-2xl font-bold text-slate-800">Detail Pengajuan Informasi</h2>
            <button onclick="toggleModal('modal-summary', false)" class="text-slate-400 hover:text-slate-600 text-2xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="p-8 overflow-y-auto space-y-8">
            <div class="space-y-6">
                <!-- 1. Pemohon (Di Atas) -->
                <div class="space-y-4 bg-slate-50/50 p-6 border border-slate-200/80 rounded-2xl">
                    <h4 class="text-lg font-extrabold text-slate-800 border-b border-slate-200 pb-2.5">Pemohon</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Nama Lengkap:</span> <span id="modal-nama" class="font-semibold text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Nomor Identitas:</span> <span id="modal-no-identitas" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-center text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Lampiran Identitas:</span> <span id="modal-identitas-doc" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Email:</span> <span id="modal-email" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Nomor Telepon:</span> <span id="modal-hp" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Pekerjaan:</span> <span id="modal-pekerjaan" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-start text-base col-span-1 md:col-span-2"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Alamat:</span> <span id="modal-alamat" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                    </div>
                </div>

                <!-- 2. Pengajuan (Di Bawahnya) -->
                <div class="space-y-4 bg-slate-50/50 p-6 border border-slate-200/80 rounded-2xl">
                    <h4 class="text-lg font-extrabold text-slate-800 border-b border-slate-200 pb-2.5">Pengajuan</h4>
                    <div class="space-y-3.5">
                        <div class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Nomor Tiket:</span> <span id="modal-tiket" class="font-bold text-[#1B365D] min-w-0 break-words"></span></div>
                        <div class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Jenis Layanan:</span> <span id="modal-jenis" class="font-semibold text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Kategori Pemohon:</span> <span id="modal-kategori" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-start text-base"><span id="lbl-modal-info" class="text-slate-500 w-48 flex-shrink-0 font-medium">Rincian Informasi:</span> <span id="modal-info" class="font-medium text-slate-900 min-w-0 break-words whitespace-pre-wrap"></span></div>
                        <div class="flex items-start text-base"><span id="lbl-modal-tujuan" class="text-slate-500 w-48 flex-shrink-0 font-medium">Tujuan Penggunaan Informasi:</span> <span id="modal-tujuan" class="font-medium text-slate-900 min-w-0 break-words whitespace-pre-wrap"></span></div>
                        <div id="row-modal-akta" class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Lampiran Akta Pendirian Badan Hukum:</span> <span id="modal-akta-doc" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                        <div class="flex items-center text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Dokumen Pendukung:</span> <span id="modal-pendukung-doc" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                        <div id="row-modal-cara" class="flex items-start text-base"><span class="text-slate-500 w-48 flex-shrink-0 font-medium">Cara Memperoleh Informasi:</span> <span id="modal-cara" class="font-medium text-slate-900 min-w-0 break-words"></span></div>
                    </div>
                </div>
            </div>
            
            <div class="border border-slate-200 rounded-xl overflow-hidden">
                <div class="bg-slate-50 px-5 py-3 border-b border-slate-200 font-bold text-slate-800 text-base">Perkembangan Status</div>
                <table class="w-full text-base">
                    <thead class="bg-slate-100 text-slate-700 border-b border-slate-200">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold">Status</th>
                            <th class="px-5 py-3 text-left font-semibold">Waktu</th>
                            <th class="px-5 py-3 text-left font-semibold">Catatan</th>
                        </tr>
                    </thead>
                    <tbody id="modal-status-history-body" class="divide-y divide-slate-100 text-slate-800 bg-white">
                        <tr><td class="px-5 py-3.5 font-medium">-</td><td class="px-5 py-3.5">-</td><td class="px-5 py-3.5">-</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Footer Actions -->
        <div class="px-8 py-5 border-t border-slate-200 bg-slate-50 flex flex-wrap items-center justify-between gap-4 flex-shrink-0">
            <div class="flex flex-wrap items-center gap-3">
                <button id="modal-btn-keberatan" onclick="actionAjukanKeberatanFromModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-semibold transition shadow-sm hidden">
                    <i class="fa-solid fa-triangle-exclamation"></i> Ajukan Keberatan
                </button>
                <button id="modal-btn-edit" onclick="actionEditFromModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1B365D] hover:bg-[#1B365D] text-white rounded-xl text-sm font-semibold transition shadow-sm hidden">
                    <i class="fa-regular fa-pen-to-square"></i> Edit Pengajuan
                </button>
                <button id="modal-btn-delete" onclick="actionDeleteFromModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-sm font-semibold transition shadow-sm hidden">
                    <i class="fa-regular fa-trash-can"></i> Hapus Pengajuan
                </button>
            </div>
            <button onclick="toggleModal('modal-summary', false)" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-sm font-semibold transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar / Dokumen Identitas (Pop-up) -->
<div id="modal-preview-identitas" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-xs">
    <div class="relative max-w-2xl w-full bg-white rounded-2xl overflow-hidden shadow-2xl p-6 flex flex-col items-center">
        <div class="w-full flex justify-between items-center pb-3 border-b border-slate-200 mb-4">
            <h3 id="preview-identitas-title" class="font-bold text-slate-800 text-base">Preview Lampiran Identitas</h3>
            <button onclick="toggleModal('modal-preview-identitas', false)" class="text-slate-400 hover:text-slate-600 text-xl font-bold">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div id="preview-identitas-content" class="w-full max-h-[60vh] overflow-auto flex justify-center items-center p-2">
            <img id="preview-identitas-img" src="" class="max-w-full max-h-[50vh] object-contain rounded-xl shadow-xs hidden">
            <iframe id="preview-identitas-iframe" src="" class="w-full h-[55vh] rounded-xl hidden"></iframe>
        </div>
        <div class="mt-4 pt-3 text-center border-t border-slate-100 w-full space-y-1">
            <div class="text-sm text-slate-800">
                <span class="text-slate-500 font-medium">Nama Lengkap :</span> <span id="preview-nama-lengkap" class="font-bold text-slate-900"></span>
            </div>
            <div class="text-sm text-slate-800">
                <span class="text-slate-500 font-medium">Nomor Identitas :</span> <span id="preview-no-identitas" class="font-bold text-slate-900"></span>
            </div>
        </div>
    </div>
</div>

