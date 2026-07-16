<!-- Modal Summary -->
<div id="modal-summary" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-7xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300 flex flex-col max-h-[90vh]">
        <div class="p-6 border-b flex justify-between items-center bg-slate-50 flex-shrink-0">
            <h2 class="text-2xl font-bold text-slate-800">Detail Pengajuan</h2>
            <button onclick="toggleModal('modal-summary', false)" class="text-slate-400 hover:text-slate-600 text-2xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="p-10 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                <div class="space-y-5">
                    <h4 class="text-xl font-bold text-slate-900 border-b pb-3 mb-6">Informasi Pemohon</h4>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Nama Lengkap</span> <span id="modal-nama" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">No. Tiket</span> <span id="modal-tiket" class="font-bold text-blue-700 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">No. Identitas</span> <span id="modal-no-identitas" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Email</span> <span id="modal-email" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">No. HP</span> <span id="modal-hp" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Pekerjaan</span> <span id="modal-pekerjaan" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Alamat</span> <span id="modal-alamat" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                </div>
                <div class="space-y-5">
                    <h4 class="text-xl font-bold text-slate-900 border-b pb-3 mb-6">Informasi Pengajuan</h4>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Jenis Layanan</span> <span id="modal-jenis" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Kategori</span> <span id="modal-kategori" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-start"><span id="lbl-modal-info" class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Rincian Informasi</span> <span id="modal-info" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words whitespace-pre-wrap"></span></div>
                    <div class="flex items-start"><span id="lbl-modal-tujuan" class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Tujuan</span> <span id="modal-tujuan" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words whitespace-pre-wrap"></span></div>
                    <div id="row-modal-cara" class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Cara Memperoleh</span> <span id="modal-cara" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-center"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Lampiran Identitas</span> <span id="modal-identitas-doc" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div id="row-modal-akta" class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Lampiran Akta Pendirian Badan Hukum</span> <span id="modal-akta-doc" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                    <div class="flex items-center"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Lampiran Data Pendukung</span> <span id="modal-pendukung-doc" class="font-semibold text-slate-900 text-base md:text-lg min-w-0 break-words"></span></div>
                </div>
            </div>
            <div class="border rounded-2xl overflow-hidden mt-12">
                <table class="w-full text-base">
                    <thead class="bg-slate-100 text-slate-600"><tr><th class="p-5 text-left font-bold text-slate-700">Status Terkini</th><th class="p-5 text-left font-bold text-slate-700">Waktu</th><th class="p-5 text-left font-bold text-slate-700">Catatan</th></tr></thead>
                    <tbody id="modal-status-history-body" class="divide-y text-slate-800 font-semibold text-lg bg-white"><tr><td class="p-5 font-bold">-</td><td class="p-5">-</td><td class="p-5">-</td></tr></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

