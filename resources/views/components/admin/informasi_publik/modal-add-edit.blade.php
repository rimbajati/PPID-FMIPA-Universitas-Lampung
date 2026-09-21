
@props([
    'listRincian' => [],
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => []
])

<!-- Modal Tambah / Edit Informasi Publik -->
<div id="modalAddEdit" class="hidden fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        <div id="modalAddEditBox" class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border-0 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[96vh] transition-all duration-300 ease-in-out">
            
            <!-- Header Modal Sky-Blue tanpa tombol X (cukup tombol Batal di footer) -->
            <div class="bg-sky-500 text-white px-6 py-3.5 shrink-0 rounded-t-2xl w-full">
                <h3 id="modalTitle" class="text-lg sm:text-xl font-extrabold text-white tracking-tight leading-snug">Tambah Informasi Publik</h3>
                <p id="modalSubtitle" class="text-xs text-white/90 font-medium mt-0.5 leading-normal">Pilih klasifikasi informasi untuk melanjutkan pengisian</p>
            </div>

            <!-- Form Body -->
            <form id="formAddEdit" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0" onsubmit="handleFormSubmit(event)">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="p-6 text-xs md:text-sm overflow-y-auto flex-1 space-y-4">
                    <!-- 1. Klasifikasi Informasi (Selector Utama) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">
                            Klasifikasi Informasi <span class="text-rose-500">*</span>
                        </label>
                        <select id="inputJenisInformasi" name="jenis_informasi" required onchange="handleJenisInformasiChange(this.value)" 
                                class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-bold focus:bg-white focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition cursor-pointer text-xs sm:text-sm">
                            <option value="">-- Pilih Klasifikasi Informasi --</option>
                            <option value="Informasi Berkala">Informasi Berkala</option>
                            <option value="Informasi Serta-Merta">Informasi Serta-Merta</option>
                            <option value="Informasi Setiap Saat">Informasi Setiap Saat</option>
                        </select>
                    </div>

                    <!-- Form Fields Lanjutan (Muncul setelah klasifikasi dipilih) -->
                    <div id="section-form-fields" class="hidden pt-2 border-t border-slate-100 grid grid-cols-1 lg:grid-cols-2 gap-x-6 gap-y-3.5 animate-in fade-in duration-200">
                        
                        <!-- KOLOM KIRI: 2 s/d 5 -->
                        <div class="space-y-3.5 flex flex-col justify-start">
                            
                            <!-- 2. Rincian Informasi -->
                            <div class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Rincian Informasi <span class="text-rose-500">*</span></label>
                                <input type="text" id="inputRincianInformasi" name="rincian_informasi" list="list-rincian-dynamic" autocomplete="off" required placeholder="Contoh: Profil Institusi" 
                                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                                
                                {{-- Single Datalist Dinamis yang diisi via JavaScript sesuai kategori aktif --}}
                                <datalist id="list-rincian-dynamic"></datalist>
                            </div>

                            <!-- 3. Sub Informasi -->
                            <div class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">
                                    Sub Informasi
                                </label>
                                <input type="text" id="inputSubInformasi" name="sub_informasi" maxlength="150" placeholder="Kosongkan jika dokumen sedang dilengkapi unit..." 
                                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold placeholder:text-slate-400 focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                                <p class="text-[11px] text-slate-400 font-medium">Bila dikosongkan, otomatis berstatus <span class="font-semibold text-amber-600 italic">"Dokumen sedang dilengkapi unit"</span>.</p>
                            </div>

                            <!-- 4. Ringkasan Isi Informasi -->
                            <div class="space-y-1" x-data="{ len: 0 }" x-init="len = $refs.inputRingkasan ? $refs.inputRingkasan.value.length : 0">
                                <div class="flex items-center justify-between">
                                    <label class="block text-xs md:text-sm font-bold text-slate-800">
                                        Ringkasan Isi Informasi
                                    </label>
                                    <span class="text-[11px] font-bold text-slate-400 shrink-0" :class="len >= 500 ? 'text-rose-500 font-extrabold' : ''">
                                        <span x-text="len">0</span>/500
                                    </span>
                                </div>
                                <textarea id="inputRingkasanIsi" name="ringkasan_isi_informasi" x-ref="inputRingkasan" rows="2" maxlength="500" placeholder="Ringkasan atau penjelasan singkat mengenai isi dokumen..." 
                                          @input="len = $el.value.length"
                                          class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold placeholder:text-slate-400 focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm resize-none"></textarea>
                            </div>

                            <!-- 4. Pejabat/Unit/Satker yang Menguasai Informasi -->
                            <div class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Pejabat/Unit/Satker yang Menguasai Informasi <span class="text-rose-500">*</span></label>
                                <input type="text" id="inputPejabatPenguasa" name="pejabat_unit_yang_menguasai_informasi" required placeholder="Contoh: Dekan / Wakil Dekan I / Bagian Tata Usaha / dsb..." 
                                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            </div>

                            <!-- 5. Penanggung jawab pembuatan atau penerbitan informasi -->
                            <div class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Penanggung jawab pembuatan atau penerbitan informasi</label>
                                <input type="text" id="inputPenanggungJawab" name="penanggung_jawab_pembuatan_informasi" placeholder="Contoh: Subbag Akademik / Tim Humas FMIPA / dsb..." 
                                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            </div>

                        </div>

                        <!-- KOLOM KANAN: 6 s/d 10 -->
                        <div class="space-y-3.5 flex flex-col justify-start">
                            
                            <!-- 6. Waktu dan Tempat Pembuatan Informasi -->
                            <div class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Waktu dan Tempat Pembuatan Informasi <span class="text-rose-500">*</span></label>
                                <input type="text" id="inputTahun" name="waktu_pembuatan_informasi" 
                                       required placeholder="Contoh: 2026, Dekanat FMIPA" 
                                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            </div>

                            <!-- 7. Jangka Waktu Penyimpanan atau Retensi Arsip -->
                            <div class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Jangka Waktu Penyimpanan atau Retensi Arsip <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       id="inputRetensiArsip" 
                                       name="retensi_arsip" 
                                       required
                                       placeholder="Contoh: 2 Tahun / Selama Berlaku / Permanen / dsb..."
                                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            </div>

                            <!-- 8. Bentuk Informasi yang Tersedia (Cetak dan Online, Cetak, Online) -->
                            <div class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Bentuk Informasi yang Tersedia <span class="text-rose-500">*</span></label>
                                <select id="inputBentukInformasi" name="bentuk_informasi_yang_tersedia" required onchange="handleBentukInformasiChange(this.value)" class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition cursor-pointer text-xs sm:text-sm">
                                    <option value="Cetak dan Online">Cetak dan Online</option>
                                    <option value="Cetak">Cetak</option>
                                    <option value="Online">Online</option>
                                </select>
                            </div>

                            <!-- 9. Akses & 10. Upload File / Link -->
                            <div id="sectionAksesOnline" class="space-y-3 pt-0.5">
                                <!-- 9. Akses -->
                                <div class="space-y-1">
                                    <label class="block text-xs md:text-sm font-bold text-slate-800">Akses</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <label class="flex items-center justify-start gap-2 h-[38px] px-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                            <input type="radio" name="jenis_informasi_format" id="radioFile" value="file" checked onclick="toggleInputType('file')" class="text-sky-600 focus:ring-0">
                                            <span class="font-bold text-slate-700 text-xs truncate">Unggah Berkas</span>
                                        </label>
                                        <label class="flex items-center justify-start gap-2 h-[38px] px-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                            <input type="radio" name="jenis_informasi_format" id="radioLink" value="link" onclick="toggleInputType('link')" class="text-sky-600 focus:ring-0">
                                            <span class="font-bold text-slate-700 text-xs truncate">Tautan Eksternal</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- 10. Upload File / Link -->
                                <!-- Upload File (Jika Jenisnya File) -->
                                <div id="containerFile" class="space-y-1">
                                    <label class="block text-xs md:text-sm font-bold text-slate-800">Upload File</label>

                                    <!-- Custom File Input Container -->
                                    <div class="relative flex items-center w-full min-h-[38px] p-1 bg-slate-50 border border-slate-200 rounded-xl transition focus-within:border-sky-500 focus-within:bg-white">
                                        <input type="file" id="inputFile" name="file_informasi" accept=".pdf,.doc,.docx,.xls,.xlsx" class="sr-only" onchange="handleFileChange(this)">

                                        <button type="button" onclick="document.getElementById('inputFile').click()"
                                                class="shrink-0 px-3 py-1 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white text-xs font-black rounded-lg transition shadow-2xs cursor-pointer">
                                            Choose File
                                        </button>

                                        <div class="flex-1 min-w-0 px-2 flex items-center">
                                            <span id="fileDisplayName" class="text-xs text-slate-500 font-medium truncate">No file chosen</span>
                                            <a id="currentFileLink" href="#" target="_blank" title="Klik untuk melihat file saat ini" 
                                               class="hidden text-xs font-semibold text-sky-600 hover:text-sky-700 underline truncate block cursor-pointer max-w-full">
                                                <span id="currentFileName" class="truncate"></span>
                                            </a>
                                        </div>
                                    </div>

                                    <p id="fileHelpText" class="text-[10px] text-slate-400 font-medium">Format: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)</p>
                                </div>

                                <!-- Taruh Tautan (Jika Jenisnya Link) -->
                                <div id="containerLink" class="space-y-1 hidden">
                                    <label class="block text-xs md:text-sm font-bold text-slate-800">Tautan Link <span class="text-rose-500">*</span></label>
                                    <input type="url" id="inputLink" name="link_informasi" placeholder="Contoh: https://drive.google.com/..." 
                                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Footer Buttons (Kompak & Bersih) -->
                <div class="px-5 py-3 sm:px-6 bg-slate-50/90 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0 rounded-b-2xl">
                    <button type="button" onclick="closeAddEditModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs sm:text-sm font-extrabold rounded-xl transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitAddEdit" class="hidden px-5 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs sm:text-sm font-extrabold rounded-xl transition shadow-xs cursor-pointer flex items-center gap-1.5">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

