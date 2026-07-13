<!-- ================= MODAL CREATE ================= -->
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[95vh] flex flex-col shadow-2xl">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
            <div>
                <h1 class="text-xl font-extrabold text-gray-900">Tambah Informasi Baru</h1>
            </div>
            <button type="button" onclick="closeModal('modal-create')" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:text-red-500">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto">
            <form action="{{ url('/admin/informasi-publik') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-900 mb-1">Rincian Informasi <span class="text-red-500">*</span></label>
                        <select id="create_rincian_select" name="rincian_informasi" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 focus:border-[#0095e8] transition" onchange="toggleRincian('create', this.value)" required>
                            <option value="">-- Pilih Rincian Informasi --</option>
                            @foreach($kategori_tersedia as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                            <option value="baru" class="font-bold text-[#0095e8]">+ Buat Rincian Informasi Baru</option>
                        </select>
                        <input type="text" id="create_rincian_baru" name="rincian_informasi_baru" placeholder="Tuliskan rincian informasi baru..." class="w-full border border-blue-300 rounded-lg p-3 text-sm bg-blue-50 hidden mt-2">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-900 mb-1">Sub/Ringkasan Informasi <span class="text-red-500">*</span></label>
                        <input type="text" name="sub_informasi" placeholder="Contoh: Rencana Strategis Tahun 2025-2029" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 focus:border-[#0095e8] transition" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-900 mb-1">Klasifikasi Jenis Informasi <span class="text-red-500">*</span></label>
                        <select name="kategori" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 focus:border-[#0095e8] transition" required>
                            <option value="">-- Pilih Jenis Informasi --</option>
                            <option value="Informasi Tersedia Setiap Saat">Informasi Tersedia Setiap Saat</option>
                            <option value="Informasi Tersedia Secara Berkala">Informasi Tersedia Secara Berkala</option>
                            <option value="Informasi Diumumkan Serta-Merta">Informasi Diumumkan Serta-Merta</option>
                        </select>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-3">
                    <label class="block text-xs font-bold text-gray-900 mb-2">Format Penyajian Informasi <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex-1 border border-gray-200 rounded-lg p-3 flex items-center cursor-pointer hover:bg-blue-50">
                            <input type="radio" name="opsi_format" value="file" class="mr-3" onclick="toggleFormat('create', 'file')" checked>
                            <div>
                                <span class="block font-bold text-sm text-gray-900">Unggah Berkas</span>
                                <span class="block text-[11px] text-gray-400">PDF, DOCX, XLSX (Max 10MB)</span>
                            </div>
                        </label>
                        <label class="flex-1 border border-gray-200 rounded-lg p-3 flex items-center cursor-pointer hover:bg-amber-50">
                            <input type="radio" name="opsi_format" value="link" class="mr-3" onclick="toggleFormat('create', 'link')">
                            <div>
                                <span class="block font-bold text-sm text-gray-900">Tautan Eksternal</span>
                                <span class="block text-[11px] text-gray-400">Link URL halaman web</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div id="create_zona_file" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-xs font-bold text-gray-900 mb-1">Pilih Berkas Dokumen <span class="text-red-500">*</span></label>
                    <input type="file" name="berkas" id="create_input_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" class="w-full text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded file:border-0 file:bg-[#0095e8] file:text-white cursor-pointer">
                </div>
                <!-- Zona Link (Masukkan Alamat URL) - PERBAIKAN DI SINI -->
                <div id="create_zona_link" class="bg-amber-50 p-3 rounded-xl border border-amber-200 hidden">
                    <label class="block text-[10px] font-bold text-gray-900 mb-1">Masukkan Alamat URL Lengkap <span class="text-red-500">*</span></label>
                    <input type="url" name="url_link" id="create_input_link" placeholder="https://..."
                        class="w-full border border-amber-300 rounded-lg p-2 text-sm bg-white placeholder-gray-400 focus:border-amber-500 focus:ring-0 transition"
                        disabled>
                </div>
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeModal('modal-create')" class="flex-1 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-bold text-sm transition">Batal</button>
                    <button type="submit" class="flex-1 py-3 bg-[#0095e8] hover:bg-blue-600 text-white rounded-lg font-bold text-sm transition">Simpan Informasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[95vh] flex flex-col shadow-2xl">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center shrink-0">
            <div>
                <h1 class="text-xl font-extrabold text-gray-900">Edit Informasi</h1>
            </div>
            <button type="button" onclick="closeModal('modal-edit')" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:text-red-500">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto">
            <form id="form-edit" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-900 mb-1">Rincian Informasi <span class="text-red-500">*</span></label>
                        <select id="edit_rincian_select" name="rincian_informasi" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 focus:border-amber-500 transition" onchange="toggleRincian('edit', this.value)" required>
                            @foreach($kategori_tersedia as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                            <option value="baru" class="font-bold text-amber-500">+ Buat Rincian Informasi Baru</option>
                        </select>
                        <input type="text" id="edit_rincian_baru" name="rincian_informasi_baru" placeholder="Tuliskan nama rincian informasi baru..." class="w-full border border-amber-300 rounded-lg p-3 text-sm bg-amber-50 hidden mt-2">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-900 mb-1">Sub/Ringkasan Informasi <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_sub" name="sub_informasi" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 focus:border-amber-500 transition" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-900 mb-1">Klasifikasi Jenis Informasi <span class="text-red-500">*</span></label>
                        <select id="edit_kategori" name="kategori" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-gray-50 focus:border-amber-500 transition" required>
                            <option value="Informasi Tersedia Setiap Saat">Informasi Tersedia Setiap Saat</option>
                            <option value="Informasi Tersedia Secara Berkala">Informasi Tersedia Secara Berkala</option>
                            <option value="Informasi Diumumkan Serta-Merta">Informasi Diumumkan Serta-Merta</option>
                        </select>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-3">
                    <label class="block text-xs font-bold text-gray-900 mb-2">Format Penyajian Informasi (Abaikan jika tidak ada perubahan isi informasi)</label>
                    <div class="flex gap-4">
                        <label class="flex-1 border border-gray-200 rounded-lg p-3 flex items-center cursor-pointer hover:bg-amber-50">
                            <input type="radio" id="edit_format_file" name="opsi_format" value="file" class="mr-3" onclick="toggleFormat('edit', 'file')">
                            <span class="font-bold text-sm">Perbarui Berkas</span>
                        </label>
                        <label class="flex-1 border border-gray-200 rounded-lg p-3 flex items-center cursor-pointer hover:bg-amber-50">
                            <input type="radio" id="edit_format_link" name="opsi_format" value="link" class="mr-3" onclick="toggleFormat('edit', 'link')">
                            <span class="font-bold text-sm">Perbarui Tautan</span>
                        </label>
                    </div>
                </div>
                <div id="edit_zona_file" class="bg-amber-50/30 p-4 rounded-lg border border-amber-200 hidden">
                    <label class="block text-xs font-bold text-gray-900 mb-1">Pilih Berkas Baru</label>
                    <input type="file" name="berkas" id="edit_input_file" class="w-full text-sm file:mr-3 file:py-1.5 file:px-4 file:rounded file:border-0 file:bg-amber-500 file:text-white cursor-pointer">
                </div>
                <!-- Zona Link (Masukkan Alamat URL) - PERBAIKAN DI SINI -->
                <div id="edit_zona_link" class="bg-amber-50 p-3 rounded-xl border border-amber-200 hidden">
                    <label class="block text-[10px] font-bold text-gray-900 mb-1">Masukkan Alamat URL Lengkap</label>
                    <input type="url" name="url_link" id="edit_input_link" placeholder="https://..."
                        class="w-full border border-amber-300 rounded-lg p-2 text-sm bg-white placeholder-gray-400 focus:border-amber-500 focus:ring-0 transition"
                        disabled>
                </div>
                <div class="flex gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeModal('modal-edit')" class="flex-1 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-bold text-sm transition">Batal</button>
                    <button type="submit" class="flex-1 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-bold text-sm transition">Update Informasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
