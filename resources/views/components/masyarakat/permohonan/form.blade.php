<!-- WIDE LAYOUT SINGLE FORM CONTAINER (/permohonan) -->
<main class="w-full bg-white border border-slate-200 shadow-sm overflow-hidden" style="border-radius: 16px !important;">
    
    <form action="{{ url('/permohonan') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- SECTION HEADER UTAMA -->
        <div class="bg-[#1B365D] text-white p-6 md:p-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-2xl shrink-0">
                    <i class="fa-solid fa-file-pen text-white"></i>
                </div>
                <div>
                    <h2 class="text-xl md:text-2xl font-black text-white tracking-tight">Formulir Pengajuan Permohonan Informasi</h2>
                    <p class="text-sm md:text-md text-slate-200 font-semibold mt-0.5">Tuliskan data diri dan detail permohonan informasi Anda dalam satu formulir ini.</p>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-10 space-y-8">

            <!-- LAYOUT 2 KOLOM PARALEL UNTUK MENGHEMAT VERTIKAL SCROLLING -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                
                <!-- KOLOM KIRI: BAGIAN 1 - DATA DIRI PEMOHON & BERKAS IDENTITAS -->
                <div class="space-y-5">

                    <!-- Kategori Pemohon & Nama Lengkap -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-extrabold text-slate-800 mb-2">
                                Kategori Pemohon <span class="text-rose-500">*</span>
                            </label>
                            <select name="kategori_pemohon" x-model="selectedKategori" required
                                    class="w-full p-3.5 text-sm bg-slate-50 border border-slate-300 focus:border-[#1B365D] focus:bg-white focus:outline-none transition rounded-xl text-slate-800 font-bold cursor-pointer shadow-2xs">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Perorangan">Perorangan</option>
                                <option value="Kelompok">Kelompok</option>
                                <option value="Organisasi">Organisasi</option>
                                <option value="Lembaga">Lembaga</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-extrabold text-slate-800 mb-2">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" x-model="nama_lengkap" readonly
                                   class="w-full p-3.5 text-sm bg-slate-100 border border-slate-300 text-slate-700 font-bold focus:outline-none rounded-xl cursor-not-allowed"
                                   placeholder="Nama Pemohon">
                        </div>
                    </div>

                    <!-- Nama Organisasi / Lembaga (Opsional jika dipilih) -->
                    <div x-show="['Organisasi', 'Lembaga'].includes(selectedKategori)" x-cloak x-transition>
                        <label class="block text-sm font-extrabold text-slate-800 mb-2">
                            <span x-text="'Nama ' + (selectedKategori || 'Organisasi / Lembaga')"></span> <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_organisasi_lembaga" x-model="nama_organisasi_lembaga"
                               class="w-full p-3.5 text-sm bg-slate-50 border border-slate-300 focus:border-[#1B365D] focus:bg-white focus:outline-none transition rounded-xl font-normal text-slate-800"
                               :placeholder="'Masukkan Nama ' + (selectedKategori || 'Organisasi / Lembaga')">
                    </div>

                    <!-- NIK & UPLOAD KTP/SIM (DISEBALAHKAN LANGSUNG PARALEL) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                        <div>
                            <label class="block text-sm font-extrabold text-slate-800 mb-2" for="no_identitas">
                                Nomor Identitas (NIK) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   id="no_identitas"
                                   name="no_identitas" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   maxlength="16" 
                                   minlength="16"
                                   x-model="nik" 
                                   required
                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); nik = this.value;"
                                   class="w-full p-3.5 text-sm bg-slate-50 border border-slate-300 focus:border-[#1B365D] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1B365D]/20 transition rounded-xl font-normal text-slate-800"
                                   placeholder="Masukan 16 digit NIK Anda">
                        </div>

                        <div>
                            <label class="block text-sm font-extrabold text-slate-800 mb-2">
                                Identitas (KTP / SIM) <span class="text-rose-500">*</span>
                            </label>
                            <input type="file" id="identitas_file_input" name="file_identitas" accept=".jpg,.jpeg,.png,.pdf" required
                                   @change="handleIdentitasFileChange($event)"
                                   class="w-full text-xs text-slate-600 font-semibold file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-[#1B365D] file:text-white hover:file:bg-[#152a4a] file:cursor-pointer border border-slate-300 rounded-xl bg-slate-50 p-1.5 focus:outline-none">
                            <span class="block text-[10px] text-slate-400 mt-1 font-medium">Format: JPG, PNG, PDF (Maks 2MB)</span>
                        </div>
                    </div>

                    <!-- Email & No Telepon / WA (Grid 2 Kolom) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-extrabold text-slate-800 mb-2">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" x-model="email" readonly
                                   class="w-full p-3.5 text-sm bg-slate-100 border border-slate-300 text-slate-700 font-bold focus:outline-none rounded-xl cursor-not-allowed"
                                   placeholder="nama@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-extrabold text-slate-800 mb-2" for="no_telepon">
                                Nomor Telepon / Whatsapp <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" 
                                   id="no_telepon"
                                   name="no_telepon" 
                                   inputmode="numeric" 
                                   pattern="[0-9]*" 
                                   maxlength="15" 
                                   x-model="no_hp" 
                                   required
                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); no_hp = this.value;"
                                   class="w-full p-3.5 text-sm bg-slate-50 border border-slate-300 focus:border-[#1B365D] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#1B365D]/20 transition rounded-xl font-normal text-slate-800"
                                   placeholder="Masukan Nomor Telepon Anda">
                        </div>
                    </div>

                    <!-- Pekerjaan -->
                    <div>
                        <label class="block text-sm font-extrabold text-slate-800 mb-2">
                            Pekerjaan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="pekerjaan" x-model="pekerjaan" required
                               class="w-full p-3.5 text-sm bg-slate-50 border border-slate-300 focus:border-[#1B365D] focus:bg-white focus:outline-none transition rounded-xl font-normal text-slate-800"
                               placeholder="Masukan Pekerjaan Anda. Contoh: Mahasiswa, Dosen, dll.">
                    </div>

                    <!-- Alamat Lengkap (Rows: 4) -->
                    <div>
                        <label class="block text-sm font-extrabold text-slate-800 mb-2">
                            Alamat Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="alamat_lengkap" x-model="alamat" rows="3" required
                                  class="w-full p-3.5 text-sm bg-slate-50 border border-slate-300 focus:border-[#1B365D] focus:bg-white focus:outline-none transition rounded-xl font-normal text-slate-800"
                                  placeholder="Masukkan alamat lengkap Anda sesuai identitas / domisili saat ini"></textarea>
                    </div>
                </div>

                <!-- KOLOM KANAN: BAGIAN 2 - RINCIAN PERMOHONAN & DOKUMEN PENDUKUNG -->
                <div class="space-y-5">

                    <!-- Detail Informasi (Rows: 5) -->
                    <div x-data="{ len: 0 }" x-init="len = rincian.length">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-extrabold text-slate-800">
                                Informasi yang Diminta <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] font-bold text-slate-400" :class="rincian.length >= 500 ? 'text-rose-500 font-extrabold' : ''">
                                <span x-text="rincian.length">0</span>/500 Karakter
                            </span>
                        </div>
                        <textarea name="informasi_yang_diminta" x-model="rincian" rows="4" required maxlength="500"
                                  class="w-full p-3.5 text-sm bg-slate-50 border border-slate-300 focus:border-[#1B365D] focus:bg-white focus:outline-none transition rounded-xl font-normal text-slate-800"
                                  placeholder="Tuliskan secara spesifik informasi yang Anda butuhkan. Contoh: Laporan Keuangan FMIPA Unila Tahun 2026"></textarea>
                    </div>

                    <!-- Tujuan Penggunaan (Rows: 8 - Sangat Tinggi & Luas) -->
                    <div x-data="{ len: 0 }" x-init="len = tujuan.length">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-extrabold text-slate-800">
                                Tujuan Penggunaan Informasi <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] font-bold text-slate-400" :class="tujuan.length >= 1000 ? 'text-rose-500 font-extrabold' : ''">
                                <span x-text="tujuan.length">0</span>/1000 Karakter
                            </span>
                        </div>
                        <textarea name="tujuan_penggunaan_informasi" x-model="tujuan" rows="7" required maxlength="1000"
                                  class="w-full p-3.5 text-sm bg-slate-50 border border-slate-300 focus:border-[#1B365D] focus:bg-white focus:outline-none transition rounded-xl font-normal text-slate-800"
                                  placeholder="Jelaskan tujuan penggunaan informasi ini. Contoh: Penelitian Skripsi, Tugas Akhir, dsb."></textarea>
                    </div>

                    <!-- Cara Memperoleh Informasi -->
                    <div>
                        <label class="block text-sm font-extrabold text-slate-800 mb-2">
                            Cara Memperoleh Informasi <span class="text-rose-500">*</span>
                        </label>
                        <input type="hidden" name="cara_memperoleh_informasi" :value="cara_memperoleh" required>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-stretch">
                            <div @click="cara_memperoleh = 'Dikirim melalui Email'"
                                 class="p-3.5 border-2 rounded-xl flex items-center justify-center text-center gap-3 cursor-pointer transition-all h-full"
                                 :class="cara_memperoleh === 'Dikirim melalui Email' ? 'border-[#1B365D] bg-sky-50/50 text-[#1B365D] font-bold shadow-xs' : 'border-slate-200 hover:border-slate-300 text-slate-700 bg-white'">
                                <i class="fa-solid fa-envelope text-lg shrink-0"></i>
                                <span class="text-xs font-extrabold leading-snug">Dikirim melalui Email</span>
                            </div>
                            <div @click="cara_memperoleh = 'Datang langsung ke Dekanat FMIPA Universitas Lampung'"
                                 class="p-3.5 border-2 rounded-xl flex items-center justify-center text-center gap-3 cursor-pointer transition-all h-full"
                                 :class="cara_memperoleh === 'Datang langsung ke Dekanat FMIPA Universitas Lampung' ? 'border-[#1B365D] bg-sky-50/50 text-[#1B365D] font-bold shadow-xs' : 'border-slate-200 hover:border-slate-300 text-slate-700 bg-white'">
                                <i class="fa-solid fa-building-columns text-lg shrink-0"></i>
                                <span class="text-xs font-extrabold leading-snug">Datang langsung ke Dekanat FMIPA Universitas Lampung</span>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Pendukung (Opsional) -->
                    <div>
                        <label class="block text-sm font-extrabold text-slate-800 mb-2">
                            Dokumen Pendukung <span class="text-slate-400 font-semibold">(Opsional)</span>
                        </label>
                        <input type="file" id="pendukung_file_input" name="file_pendukung" accept=".pdf,.docx"
                               @change="handlePendukungFileChange($event)"
                               class="w-full text-xs text-slate-600 font-semibold file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-slate-700 file:text-white hover:file:bg-slate-800 file:cursor-pointer border border-slate-300 rounded-xl bg-slate-50 p-1.5 focus:outline-none">
                        <span class="block text-[10px] text-slate-400 mt-1 font-medium">Format: PDF, DOCX (Maksimal 5 MB)</span>
                    </div>

                </div>
            </div>

            <!-- ==================== BAGIAN PERNYATAAN & TOMBOL SUBMIT ==================== -->
            <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <label class="flex items-center gap-3 cursor-pointer bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 w-fit">
                    <input type="checkbox" x-model="disetujui" required class="w-4 h-4 text-[#1B365D] rounded focus:ring-[#1B365D] border-slate-300 shrink-0">
                    <span class="text-xs text-slate-700 leading-relaxed font-extrabold">
                        Saya menyatakan bahwa seluruh data dan permohonan ini adalah benar dan sah serta dapat dipertanggungjawabkan.
                    </span>
                </label>

                <button type="submit" :disabled="!disetujui"
                        class="w-full sm:w-auto px-8 py-3.5 bg-[#1B365D] hover:bg-[#152a4a] disabled:bg-slate-300 disabled:cursor-not-allowed text-white text-xs md:text-sm font-black uppercase tracking-wider transition rounded-xl flex items-center justify-center gap-2 shadow-md cursor-pointer shrink-0">
                    <i class="fa-solid fa-paper-plane text-xs"></i> Kirim Permohonan
                </button>
            </div>

        </div>

    </form>

</main>
