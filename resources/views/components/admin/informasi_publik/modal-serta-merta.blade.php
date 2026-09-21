<!-- Modal Khusus Tambah / Edit Pengumuman Informasi Serta-Merta -->
<div id="modalSertaMerta" class="hidden fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl border-0 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[96vh]">
        
        <!-- Header Modal Sky-Blue (Sama persis dengan modal DIP) -->
        <div class="bg-sky-500 text-white px-6 py-3.5 shrink-0 rounded-t-2xl w-full">
            <h3 id="modalSertaMertaTitle" class="text-lg sm:text-xl font-extrabold text-white tracking-tight leading-snug">Tambah Pengumuman Serta-Merta</h3>
            <p id="modalSertaMertaSubtitle" class="text-xs text-white/90 font-medium mt-0.5 leading-normal">Publikasikan surat edaran atau pengumuman penting/mendesak bagi publik</p>
        </div>

        <!-- Form Body -->
        <form id="formSertaMerta" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" id="formMethodSertaMerta" name="_method" value="POST">
            <!-- Hidden Klasifikasi otomatis Informasi Serta-Merta -->
            <input type="hidden" name="jenis_informasi" value="Informasi Serta-Merta">
            <!-- Default field pendukung agar validasi database terpenuhi -->
            <input type="hidden" name="rincian_informasi" value="Pengumuman Serta-Merta">
            <input type="hidden" name="bentuk_informasi_yang_tersedia" value="Online">
            <input type="hidden" name="retensi_arsip" value="Selama Berlaku">

            <div class="p-6 text-xs md:text-sm overflow-y-auto flex-1 space-y-3.5">
                
                <!-- 1. Judul / Ringkasan Pengumuman (Dengan Char Counter persis modal DIP) -->
                <div class="space-y-1" x-data="{ len: 0 }" x-init="len = $refs.inputSertaMerta ? $refs.inputSertaMerta.value.length : 0">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">
                            Judul Pengumuman / Surat Edaran <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[11px] font-bold text-slate-400 shrink-0" :class="len >= 150 ? 'text-rose-500 font-extrabold' : ''">
                            <span x-text="len">0</span>/150
                        </span>
                    </div>
                    <input type="text" id="inputJudulSertaMerta" name="ringkasan_isi_informasi" x-ref="inputSertaMerta" maxlength="150" required 
                           placeholder="Contoh: Surat Edaran Kesiapsiagaan Bencana / Pengumuman Lelang Mendesak..." 
                           @input="len = $el.value.length"
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold placeholder:text-slate-400 focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                </div>

                <!-- 2. Waktu/Tanggal Pembuatan & Unit/Satker Penerbit (2 Kolom) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- Tanggal -->
                    <div class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">
                            Waktu / Tanggal Terbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputWaktuSertaMerta" name="waktu_pembuatan_informasi" required 
                               placeholder="Contoh: 18 September 2026" 
                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                    </div>

                    <!-- Pejabat / Satker Penerbit -->
                    <div class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">
                            Unit / Satker Penerbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputPejabatSertaMerta" name="pejabat_unit_yang_menguasai_informasi" required 
                               placeholder="Contoh: Dekanat FMIPA Universitas Lampung" 
                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                    </div>
                </div>

                <!-- 3. Akses & Berkas / Tautan (Persis Desain Modal DIP) -->
                <div class="space-y-3 pt-0.5">
                    <!-- Akses Radio Button -->
                    <div class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Akses Lampiran <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center justify-start gap-2 h-[38px] px-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                <input type="radio" name="format_serta_merta" id="radioFileSertaMerta" value="file" checked onclick="toggleFormatSertaMerta('file')" class="text-sky-600 focus:ring-0">
                                <span class="font-bold text-slate-700 text-xs truncate">Unggah Berkas</span>
                            </label>
                            <label class="flex items-center justify-start gap-2 h-[38px] px-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                <input type="radio" name="format_serta_merta" id="radioLinkSertaMerta" value="link" onclick="toggleFormatSertaMerta('link')" class="text-sky-600 focus:ring-0">
                                <span class="font-bold text-slate-700 text-xs truncate">Tautan Eksternal</span>
                            </label>
                        </div>
                    </div>

                    <!-- Upload File Serta Merta (Desain Persis Modal DIP) -->
                    <div id="containerFileSertaMerta" class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Upload File <span id="fileRequiredStarSertaMerta" class="text-rose-500">*</span></label>

                        <!-- Custom File Input Container -->
                        <div class="relative flex items-center w-full min-h-[38px] p-1 bg-slate-50 border border-slate-200 rounded-xl transition focus-within:border-sky-500 focus-within:bg-white">
                            <input type="file" id="inputFileSertaMerta" name="file_informasi" accept=".pdf,.doc,.docx,.xls,.xlsx" class="sr-only" onchange="handleFileChangeSertaMerta(this)">

                            <button type="button" onclick="document.getElementById('inputFileSertaMerta').click()"
                                    class="shrink-0 px-3 py-1 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white text-xs font-black rounded-lg transition shadow-2xs cursor-pointer">
                                Choose File
                            </button>

                            <div class="flex-1 min-w-0 px-2 flex items-center">
                                <span id="fileNameSertaMerta" class="text-xs text-slate-500 font-medium truncate">No file chosen</span>
                                <a id="currentFileLinkSertaMerta" href="#" target="_blank" title="Klik untuk melihat file saat ini" 
                                   class="hidden text-xs font-semibold text-sky-600 hover:text-sky-700 underline truncate block cursor-pointer max-w-full">
                                    <span id="currentFileNameSertaMerta" class="truncate"></span>
                                </a>
                            </div>
                        </div>

                        <p id="fileHelpTextSertaMerta" class="text-[10px] text-slate-400 font-medium">Format: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)</p>
                    </div>

                    <!-- Tautan Link Serta Merta -->
                    <div id="containerLinkSertaMerta" class="space-y-1 hidden">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Tautan Link <span class="text-rose-500">*</span></label>
                        <input type="url" id="inputLinkSertaMerta" name="link_informasi" placeholder="Contoh: https://drive.google.com/... atau https://unila.ac.id/..." 
                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                    </div>
                </div>

            </div>

            <!-- Footer Buttons (Persis Modal DIP) -->
            <div class="px-5 py-3 sm:px-6 bg-slate-50/90 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0 rounded-b-2xl">
                <button type="button" onclick="closeModalSertaMerta()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs sm:text-sm font-extrabold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs sm:text-sm font-extrabold rounded-xl transition shadow-xs cursor-pointer flex items-center gap-1.5">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
