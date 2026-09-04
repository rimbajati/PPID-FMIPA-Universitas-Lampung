<!-- Modal Tambah / Edit Informasi Publik -->
<div id="modalAddEdit" class="hidden fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl border-0 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[92vh]">
        
        <!-- Header Modal Sky-Blue tanpa celah/garis tepi -->
        <div class="bg-sky-500 text-white p-5 sm:p-6 flex items-center justify-between shrink-0 rounded-t-2xl w-full">
            <div>
                <h3 id="modalTitle" class="text-xl sm:text-2xl font-extrabold text-white tracking-tight leading-snug">Tambah Informasi Publik</h3>
                <p id="modalSubtitle" class="text-xs sm:text-sm text-white font-medium mt-1 leading-normal">Isi data dibawah ini untuk menambahkan informasi publik baru</p>
            </div>
            <button type="button" onclick="closeAddEditModal()" class="w-9 h-9 rounded-xl bg-white/15 hover:bg-white/25 text-white flex items-center justify-center transition cursor-pointer shrink-0 ml-4">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Form Body -->
        <form id="formAddEdit" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden" onsubmit="handleFormSubmit(event)">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="p-5 sm:p-6 space-y-5 overflow-y-auto flex-1 text-xs md:text-sm [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                
                <!-- 1. Judul Informasi -->
                <div class="space-y-1.5" x-data="{ len: 0 }" x-init="len = $refs.inputJ ? $refs.inputJ.value.length : 0">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Judul Informasi <span class="text-rose-500">*</span></label>
                        <span class="text-[11px] font-bold text-slate-400" :class="len >= 100 ? 'text-rose-500 font-extrabold' : ''">
                            <span x-text="len">0</span>/100 karakter
                        </span>
                    </div>
                    <input type="text" id="inputJudul" name="judul_informasi" x-ref="inputJ" maxlength="100" required placeholder="Tuliskan judul informasi yang akan ditambahkan..." 
                           @input="len = $el.value.length"
                           class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold placeholder:text-slate-400 focus:bg-white focus:outline-none focus:border-sky-500 transition">
                </div>

                <!-- 2. Deskripsi Informasi -->
                <div class="space-y-1.5" x-data="{ len: 0 }" x-init="len = $refs.inputD ? $refs.inputD.value.length : 0">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Deskripsi Informasi <span class="text-rose-500">*</span></label>
                        <span class="text-[11px] font-bold text-slate-400" :class="len >= 200 ? 'text-rose-500 font-extrabold' : ''">
                            <span x-text="len">0</span>/200 karakter
                        </span>
                    </div>
                    <textarea id="inputDeskripsi" name="deskripsi_informasi" x-ref="inputD" rows="3" maxlength="200" required placeholder="Jelaskan deskripsi lengkap mengenai informasi publik ini..." 
                              @input="len = $el.value.length"
                              class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-medium placeholder:text-slate-400 focus:bg-white focus:outline-none focus:border-sky-500 transition leading-relaxed resize-none"></textarea>
                </div>

                <!-- 3. Kategori Informasi -->
                <div class="space-y-1.5">
                    <label class="block text-xs md:text-sm font-bold text-slate-800">Kategori Informasi <span class="text-rose-500">*</span></label>
                    <select id="inputKategori" name="kategori_informasi" required class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition cursor-pointer">
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
                        <input type="number" id="inputTahun" name="tahun_terbit" min="2000" max="2099" step="1" required placeholder="Contoh: 2026" 
                               class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition">
                    </div>

                    <!-- Jenis Informasi (File PDF vs Link Drive) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Jenis Informasi <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2.5">
                            <label class="flex items-center justify-start gap-2.5 h-[48px] px-4 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                <input type="radio" name="jenis_informasi" value="file" checked onclick="toggleInputType('file')" class="text-sky-600 focus:ring-0">
                                <span class="font-bold text-slate-700 text-xs md:text-sm">File</span>
                            </label>
                            <label class="flex items-center justify-start gap-2.5 h-[48px] px-4 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                <input type="radio" name="jenis_informasi" value="link" onclick="toggleInputType('link')" class="text-sky-600 focus:ring-0">
                                <span class="font-bold text-slate-700 text-xs md:text-sm">Tautan</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 6. Upload File (Jika Jenisnya File) -->
                <div id="containerFile" class="space-y-1.5">
                    <label class="block text-xs md:text-sm font-bold text-slate-800">Upload File <span id="fileRequiredStar" class="text-rose-500">*</span></label>

                    <input type="file" id="inputFile" name="file_informasi" accept=".pdf,.doc,.docx,.xls,.xlsx"
                           class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-sky-500 file:text-white hover:file:bg-sky-600 transition">

                    <!-- Indicator Berkas yang Ter-upload Saat Ini (Mode Edit) -->
                    <div id="currentFileBox" class="hidden mb-2 p-3 bg-slate-50 border border-slate-200/90 rounded-xl space-y-0.5">
                        <p class="text-[12px] font-normal text-slate-700">File Saat Ini :</p>
                        <a id="currentFileLink" href="#" target="_blank" class="text-xs md:text-sm font-extrabold text-sky-600 hover:text-sky-700 underline truncate block cursor-pointer">
                            <span id="currentFileName"></span>
                        </a>
                    </div>
                    <p id="fileHelpText" class="text-[11px] text-slate-400 font-medium">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)</p>
                </div>

                <!-- 7. Tautan (Jika Jenisnya Link) -->
                <div id="containerLink" class="space-y-1.5 hidden">
                    <label class="block text-xs md:text-sm font-bold text-slate-800">Taruh Tautan <span class="text-rose-500">*</span></label>
                    <input type="url" id="inputLink" name="link_informasi" placeholder="Contoh: https://drive.google.com/..." 
                           class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition">
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="p-4 sm:p-5 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="closeAddEditModal()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs md:text-sm font-extrabold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-xl transition shadow-md cursor-pointer flex items-center gap-2">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
