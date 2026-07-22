<!-- ================= MODAL CREATE ================= -->
<div id="modal-create" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl w-full max-w-5xl max-h-[95vh] flex flex-col shadow-2xl">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center shrink-0">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Tambah Informasi Baru</h1>
            </div>
            <button type="button" onclick="closeModal('modal-create')" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:text-red-500 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto">
            <form id="form-create" action="{{ url('/admin/informasi-publik') }}" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Rincian Informasi <span class="text-red-500">*</span></label>
                        <select id="create_rincian_select" name="rincian_informasi" class="input-field w-full border border-gray-300 rounded-lg p-3 text-base bg-gray-50 focus:border-[#0095e8] transition" onchange="toggleRincian('create', this.value)" required>
                            <option value="">-- Pilih Rincian Informasi --</option>
                            @foreach($listRincian as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                            <option value="baru" class="font-bold text-[#0095e8]">+ Buat Rincian Informasi Baru</option>
                        </select>
                        <input type="text" id="create_rincian_baru" name="rincian_informasi_baru" placeholder="Tuliskan rincian informasi baru..." class="input-field w-full border border-blue-300 rounded-lg p-3 text-base bg-blue-50 hidden mt-2">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Sub/Ringkasan Informasi <span class="text-red-500">*</span></label>
                        <input type="text" id="create_sub" name="sub_informasi" placeholder="Contoh: Rencana Strategis Tahun 2025-2029" class="input-field w-full border border-gray-300 rounded-lg p-3 text-base bg-gray-50 focus:border-[#0095e8] transition" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Klasifikasi Jenis Informasi <span class="text-red-500">*</span></label>
                        <select id="create_kategori" name="kategori" class="input-field w-full border border-gray-300 rounded-lg p-3 text-base bg-gray-50 focus:border-[#0095e8] transition" required>
                            <option value="">-- Pilih Jenis Informasi --</option>
                            <option value="Informasi Tersedia Setiap Saat">Informasi Tersedia Setiap Saat</option>
                            <option value="Informasi Tersedia Secara Berkala">Informasi Tersedia Secara Berkala</option>
                            <option value="Informasi Diumumkan Serta-Merta">Informasi Diumumkan Serta-Merta</option>
                        </select>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <label class="block text-sm font-bold text-gray-900 mb-3">Format Penyajian Informasi <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex-1 border border-gray-200 rounded-lg p-3.5 flex items-center cursor-pointer hover:bg-blue-50 transition">
                            <input type="radio" name="opsi_format" value="file" class="mr-3 w-4 h-4 text-[#0095e8]" onclick="toggleFormat('create', 'file')" checked>
                            <div>
                                <span class="block font-bold text-base text-gray-900">Unggah Berkas</span>
                                <span class="block text-xs text-gray-400 mt-0.5">PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG (Max 2MB)</span>
                            </div>
                        </label>
                        <label class="flex-1 border border-gray-200 rounded-lg p-3.5 flex items-center cursor-pointer hover:bg-amber-50 transition">
                            <input type="radio" name="opsi_format" value="link" class="mr-3 w-4 h-4 text-[#0095e8]" onclick="toggleFormat('create', 'link')">
                            <div>
                                <span class="block font-bold text-base text-gray-900">Tautan Eksternal</span>
                                <span class="block text-xs text-gray-400 mt-0.5">Link URL</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div id="create_zona_file" class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Pilih Berkas Dokumen <span class="text-red-500">*</span></label>
                    <input type="file" name="berkas" id="create_input_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" onchange="validateAdminInformasiFile(this)" class="input-field w-full text-base file:mr-3 file:py-2 file:px-5 file:rounded-lg file:border-0 file:bg-[#0095e8] file:text-white cursor-pointer">
                    <p class="text-xs text-gray-400 mt-1.5">(Format: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG | Maks: 2 MB)</p>
                    <p id="create_input_file_error" class="text-red-600 text-xs font-bold mt-1.5 hidden flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-xs"></i> <span></span></p>
                    @error('berkas')
                        <p class="text-red-600 text-xs font-bold mt-1.5 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}</p>
                    @enderror
                </div>
                <div id="create_zona_link" class="bg-amber-50 p-4 rounded-xl border border-amber-200 hidden">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Masukkan Alamat URL Lengkap <span class="text-red-500">*</span></label>
                    <input type="url" name="url_link" id="create_input_link" placeholder="https://..."
                        class="input-field w-full border border-amber-300 rounded-lg p-3 text-base bg-white placeholder-gray-400 focus:border-amber-500 focus:ring-0 transition"
                        disabled>
                </div>
                <div class="flex gap-4 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal('modal-create')" class="flex-1 py-3.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-bold text-base transition">Batal</button>
                    <button type="submit" class="flex-1 py-3.5 bg-[#0095e8] hover:bg-blue-600 text-white rounded-lg font-bold text-base transition">Simpan Informasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl w-full max-w-5xl max-h-[95vh] flex flex-col shadow-2xl">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center shrink-0">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Edit Informasi</h1>
            </div>
            <button type="button" onclick="closeModal('modal-edit')" class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:text-red-500 transition">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <div class="p-6 overflow-y-auto">
            <form id="form-edit" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
                @csrf @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Rincian Informasi <span class="text-red-500">*</span></label>
                        <select id="edit_rincian_select" name="rincian_informasi" class="input-field w-full border border-gray-300 rounded-lg p-3 text-base bg-gray-50 focus:border-amber-500 transition" onchange="toggleRincian('edit', this.value)" required>
                            @foreach($listRincian as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                            <option value="baru" class="font-bold text-amber-500">+ Buat Rincian Informasi Baru</option>
                        </select>
                        <input type="text" id="edit_rincian_baru" name="rincian_informasi_baru" placeholder="Tuliskan nama rincian informasi baru..." class="input-field w-full border border-amber-300 rounded-lg p-3 text-base bg-amber-50 hidden mt-2">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Sub/Ringkasan Informasi <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_sub" name="sub_informasi" class="input-field w-full border border-gray-300 rounded-lg p-3 text-base bg-gray-50 focus:border-amber-500 transition" required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Klasifikasi Jenis Informasi <span class="text-red-500">*</span></label>
                        <select id="edit_kategori" name="kategori" class="input-field w-full border border-gray-300 rounded-lg p-3 text-base bg-gray-50 focus:border-amber-500 transition" required>
                            <option value="Informasi Tersedia Setiap Saat">Informasi Tersedia Setiap Saat</option>
                            <option value="Informasi Tersedia Secara Berkala">Informasi Tersedia Secara Berkala</option>
                            <option value="Informasi Diumumkan Serta-Merta">Informasi Diumumkan Serta-Merta</option>
                        </select>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <label class="block text-sm font-bold text-gray-900 mb-3">Format Penyajian Informasi (Abaikan jika tidak ada perubahan isi informasi)</label>
                    <div class="flex gap-4">
                        <label class="flex-1 border border-gray-200 rounded-lg p-3.5 flex items-center cursor-pointer hover:bg-amber-50 transition">
                            <input type="radio" id="edit_format_file" name="opsi_format" value="file" class="mr-3 w-4 h-4 text-amber-500" onclick="toggleFormat('edit', 'file')">
                            <div>
                                <span class="block font-bold text-base text-gray-900">Perbarui Berkas</span>
                                <span class="block text-xs text-gray-400 mt-0.5">PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG (Max 2MB)</span>
                            </div>
                        </label>
                        <label class="flex-1 border border-gray-200 rounded-lg p-3.5 flex items-center cursor-pointer hover:bg-amber-50 transition">
                            <input type="radio" id="edit_format_link" name="opsi_format" value="link" class="mr-3 w-4 h-4 text-amber-500" onclick="toggleFormat('edit', 'link')">
                            <div>
                                <span class="block font-bold text-base text-gray-900">Perbarui Tautan Eksternal</span>
                                <span class="block text-xs text-gray-400 mt-0.5">Link URL</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div id="edit_zona_file" class="bg-amber-50/30 p-4 rounded-lg border border-amber-200 hidden">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Pilih Berkas Baru</label>
                    <input type="file" name="berkas" id="edit_input_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" onchange="validateAdminInformasiFile(this)" class="input-field w-full text-base file:mr-3 file:py-2 file:px-5 file:rounded-lg file:border-0 file:bg-amber-500 file:text-white cursor-pointer">
                    <p class="text-xs text-gray-400 mt-1.5">(Format: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG | Maks: 2 MB)</p>
                    <p id="edit_input_file_error" class="text-red-600 text-xs font-bold mt-1.5 hidden flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-xs"></i> <span></span></p>
                    @error('berkas')
                        <p class="text-red-600 text-xs font-bold mt-1.5 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}</p>
                    @enderror
                </div>
                <div id="edit_zona_link" class="bg-amber-50 p-4 rounded-xl border border-amber-200 hidden">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Masukkan Alamat URL Lengkap</label>
                    <input type="url" name="url_link" id="edit_input_link" placeholder="https://..."
                        class="input-field w-full border border-amber-300 rounded-lg p-3 text-base bg-white placeholder-gray-400 focus:border-amber-500 focus:ring-0 transition"
                        disabled>
                </div>
                <div class="flex gap-4 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal('modal-edit')" class="flex-1 py-3.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-bold text-base transition">Batal</button>
                    <button type="submit" class="flex-1 py-3.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-bold text-base transition">Update Informasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateAdminInformasiFile(input) {
        const errorEl = document.getElementById(input.id + '_error');
        if (input.files && input.files.length > 0) {
            const file = input.files[0];
            const maxMB = 2;
            const maxSize = maxMB * 1024 * 1024;
            if (file.size > maxSize) {
                const actualMB = (file.size / (1024 * 1024)).toFixed(2);
                if (errorEl) {
                    errorEl.querySelector('span').textContent = `Ukuran berkas terlalu besar! Maksimal ${maxMB} MB (Ukuran berkas Anda: ${actualMB} MB).`;
                    errorEl.classList.remove('hidden');
                }
                input.value = '';
                return false;
            }
        }
        if (errorEl) errorEl.classList.add('hidden');
        return true;
    }
</script>
