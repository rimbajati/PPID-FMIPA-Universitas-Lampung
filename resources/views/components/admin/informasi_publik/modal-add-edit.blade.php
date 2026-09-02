<!-- Modal Tambah / Edit Informasi Publik -->
<div id="modalAddEdit" class="hidden fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl border border-slate-200/90 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[92vh]">
        <!-- Header Modal Navy -->
        <div class="bg-[#1B365D] text-white p-5 sm:p-6 flex items-center justify-between shrink-0">
            <div>
                <h3 id="modalTitle" class="text-xl sm:text-2xl font-extrabold text-white">Tambah Informasi Publik</h3>
                <p id="modalSubtitle" class="text-xs sm:text-sm text-white/80 mt-0.5">Isi data dibawah ini untuk menambahkan informasi</p>
            </div>
        </div>

        <!-- Form Body -->
        <form id="formAddEdit" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden" onsubmit="handleFormSubmit(event)">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="p-5 sm:p-6 space-y-5 overflow-y-auto flex-1 text-xs md:text-sm [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                <!-- 1. Judul Informasi -->
                <div class="space-y-1.5" x-data="{ len: 0 }" x-init="len = $refs.inputJ.value.length">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Judul Informasi <span class="text-rose-500">*</span></label>
                        <span class="text-[11px] font-bold text-slate-400" :class="len >= 100 ? 'text-rose-500 font-extrabold' : ''">
                            <span x-text="len">0</span>/100 karakter
                        </span>
                    </div>
                    <input type="text" id="inputJudul" name="judul_informasi" x-ref="inputJ" rows="2" maxlength="100" required placeholder="Tuliskan judul informasi yang akan ditambahkan..." 
                           @input="len = $el.value.length"
                           class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-[#1B365D] transition">
                </div>

                <!-- 2. Deskripsi Informasi -->
                <div class="space-y-1.5" x-data="{ len: 0 }" x-init="len = $refs.inputD.value.length">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Deskripsi Informasi <span class="text-rose-500">*</span></label>
                        <span class="text-[11px] font-bold text-slate-400" :class="len >= 200 ? 'text-rose-500 font-extrabold' : ''">
                            <span x-text="len">0</span>/200 karakter
                        </span>
                    </div>
                    <textarea id="inputDeskripsi" name="deskripsi_informasi" x-ref="inputD" rows="3" maxlength="200" required placeholder="Jelaskan deskripsi lengkap mengenai informasi publik ini..." 
                              @input="len = $el.value.length"
                              class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium focus:bg-white focus:outline-none focus:border-[#1B365D] transition leading-relaxed resize-none"></textarea>
                </div>

                <!-- 3. Kategori Informasi -->
                <div class="space-y-1.5">
                    <label class="block text-xs md:text-sm font-bold text-slate-800">Kategori Informasi <span class="text-rose-500">*</span></label>
                    <select id="inputKategori" name="kategori_informasi" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-[#1B365D] transition cursor-pointer">
                        <option value="">-- Pilih Kategori Informasi --</option>
                        <option value="Informasi Berkala">Informasi Berkala</option>
                        <option value="Informasi Serta-Merta">Informasi Serta-Merta</option>
                        <option value="Informasi Setiap Saat">Informasi Setiap Saat</option>
                        <option value="Informasi Dikecualikan">Informasi Dikecualikan</option>
                    </select>
                </div>

                <!-- 4 & 5. Grid 2 Kolom: Tahun Terbit Informasi & Jenis Informasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                    <!-- Tahun Terbit Informasi -->
                    <div class="space-y-1.5">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Tahun Terbit Informasi <span class="text-rose-500">*</span></label>
                        <input type="number" id="inputTahun" name="tahun_terbit" min="2000" max="2099" step="1" required placeholder="Contoh: 2025" 
                               class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-[#1B365D] transition">
                    </div>

                    <!-- Jenis Informasi (File PDF vs Link Drive) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Jenis Informasi <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2.5">
                            <label class="flex items-center justify-start gap-2.5 h-[48px] px-4 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                <input type="radio" name="jenis_informasi" value="file" checked onclick="toggleInputType('file')" class="text-[#1B365D] focus:ring-0">
                                <span class="font-bold text-slate-700 text-xs md:text-sm">File</span>
                            </label>
                            <label class="flex items-center justify-start gap-2.5 h-[48px] px-4 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                <input type="radio" name="jenis_informasi" value="link" onclick="toggleInputType('link')" class="text-[#1B365D] focus:ring-0">
                                <span class="font-bold text-slate-700 text-xs md:text-sm">Tautan</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 6. Upload File (Jika Jenisnya File) -->
                <div id="containerFile" class="space-y-1.5">
                    <label class="block text-xs md:text-sm font-bold text-slate-800">Upload File <span id="fileRequiredStar" class="text-rose-500">*</span></label>

                    <input type="file" id="inputFile" name="file_informasi" accept=".pdf,.doc,.docx,.xls,.xlsx"
                           class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-[#1B365D] file:text-white hover:file:bg-[#152a4a] transition">

                    <!-- Indicator Berkas yang Ter-upload Saat Ini (Mode Edit) -->
                    <div id="currentFileBox" class="hidden mb-2 p-3 bg-slate-50 border border-slate-200/90 rounded-xl flex items-center justify-between">
                        <div class="overflow-hidden text-ellipsis whitespace-nowrap pr-2">
                            <p class="text-[12px] font-normal text-slate-700">File Saat Ini :</p>
                            <span id="currentFileName" class="text-xs md:text-sm font-extrabold text-[#1B365D] truncate block"></span>
                        </div>
                        <a id="currentFileLink" href="#" target="_blank" class="px-3.5 py-1.5 bg-[#1B365D] hover:bg-[#152a4a] text-white text-xs font-bold rounded-lg transition shrink-0 inline-flex items-center gap-1.5 shadow-2xs">
                            <i class="fa-solid fa-eye text-[11px]"></i> Lihat
                        </a>
                    </div>
                    <p id="fileHelpText" class="text-[11px] text-slate-400 font-medium">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)</p>
                    
                </div>

                <!-- 6. Tautan (Jika Jenisnya Link) -->
                <div id="containerLink" class="space-y-1.5 hidden">
                    <label class="block text-xs md:text-sm font-bold text-slate-800">Taruh Tautan <span class="text-rose-500">*</span></label>
                    <input type="url" id="inputLink" name="link_informasi" placeholder="Contoh: https://drive.google.com/..." 
                           class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-[#1B365D] transition">
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeAddEditModal()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-extrabold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#1B365D] hover:bg-[#152a4a] text-white text-xs font-black rounded-xl transition shadow-md cursor-pointer flex items-center gap-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

