<!-- WIDE LAYOUT SINGLE FORM CONTAINER (/keberatan) -->
<main class="w-full bg-white border border-slate-200/90 rounded-3xl shadow-xl overflow-hidden">

    <form action="{{ route('layanan.keberatan.store') }}" method="POST" enctype="multipart/form-data"
          @submit="if(!isValidForm()) { $event.preventDefault(); scrollToFirstError(); }">
        @csrf

        <!-- SECTION HEADER UTAMA (Warm Amber / Orange Header) -->
        <div class="bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 text-white p-6 md:p-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 border border-white/30 rounded-2xl flex items-center justify-center text-2xl shrink-0 text-white shadow-inner">
                    <i class="fa-solid fa-file-circle-exclamation"></i>
                </div>
                <div>
                    <h2 class="text-xl md:text-2xl font-black text-white tracking-tight">Formulir Pengajuan Keberatan</h2>
                    <p class="text-xs md:text-sm text-amber-100 font-medium mt-0.5">Lengkapi data berikut untuk mengajukan keberatan informasi publik.</p>
                </div>
            </div>
        </div>

        <!-- Hidden Inputs Data Pemohon -->
        <input type="hidden" name="permohonan_id" :value="permohonan_id">
        <input type="hidden" name="kategori_pemohon" :value="selectedKategori || 'Perorangan'">
        <input type="hidden" name="nama_organisasi_lembaga" :value="nama_organisasi_lembaga">
        <input type="hidden" name="nik" :value="nik || '1234567890123456'">
        <input type="hidden" name="no_hp" :value="no_hp || '-'">
        <input type="hidden" name="alamat" :value="alamat || '-'">
        <input type="hidden" name="pekerjaan" :value="pekerjaan || 'Lainnya'">

        <div class="p-6 md:p-10 space-y-8">

            <!-- LAYOUT 2 KOLOM PARALEL UNTUK MENGHEMAT VERTIKAL SCROLLING -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">

                <!-- KOLOM KIRI: TIKET ASAL & ALASAN KEBERATAN -->
                <div class="space-y-5">

                    <!-- Pilihan Tiket Permohonan Asal -->
                    <div class="space-y-2 relative" @click.away="dropdownOpen = false">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-black text-slate-700 tracking-wide uppercase">
                                Nomor Tiket Permohonan Asal <span class="text-rose-500">*</span>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="hidden" name="nomor_tracking_asal" :value="nomor_tracking_asal" required>

                            <!-- Tombol Trigger Dropdown Murni (Tanpa Input Teks / Autofill Browser) -->
                            <button type="button"
                                    @click="dropdownOpen = !dropdownOpen"
                                    class="w-full p-3.5 text-left text-sm bg-slate-50/50 border border-slate-200 hover:bg-slate-100/60 focus:border-amber-500 focus:ring-4 focus:ring-amber-100 focus:outline-none transition rounded-2xl flex items-center justify-between gap-2 cursor-pointer"
                                    :class="submitted && !nomor_tracking_asal.trim() ? 'border-rose-500 ring-2 ring-rose-100' : ''">
                                <span class="font-mono font-bold"
                                      :class="nomor_tracking_asal ? 'text-slate-800 text-sm md:text-base' : 'text-slate-400 font-sans font-medium text-xs md:text-sm'"
                                      x-text="nomor_tracking_asal ? ('#' + nomor_tracking_asal) : '-- Pilih Tiket Permohonan Asal --'"></span>
                                <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200 shrink-0" :class="dropdownOpen ? 'rotate-180' : ''"></i>
                            </button>

                            <!-- Dropdown List Tiket Permohonan User -->
                            <div x-show="dropdownOpen" x-transition
                                 class="absolute z-30 left-0 right-0 mt-1.5 bg-white border border-slate-200 shadow-xl max-h-72 overflow-y-auto rounded-2xl divide-y divide-slate-100">
                                <template x-if="permohonanList.length === 0">
                                    <div class="p-5 text-center text-xs sm:text-sm text-slate-400 italic">
                                        Belum ada permohonan informasi yang memenuhi syarat untuk diajukan keberatan.
                                    </div>
                                </template>
                                <template x-for="item in permohonanList" :key="item.id">
                                     <div @click="selectPermohonan(item)"
                                          class="p-4 hover:bg-amber-50/60 cursor-pointer transition flex items-center justify-between gap-3"
                                          :class="nomor_tracking_asal === item.no_tiket ? 'bg-amber-50/80' : ''">
                                         <div class="flex-1 min-w-0">
                                             <div class="flex items-center gap-2 flex-wrap">
                                                 <span class="font-extrabold text-slate-900 font-mono text-sm sm:text-base" x-text="'#' + item.no_tiket"></span>
                                                 <span class="text-[11px] px-2.5 py-0.5 rounded-full font-black uppercase tracking-wide border"
                                                       :class="{
                                                           'bg-slate-100 text-slate-700 border-slate-200': item.status === 'Diajukan' || item.status === 'Menunggu',
                                                           'bg-amber-100 text-amber-900 border-amber-300': item.status === 'Diproses' || item.status === 'Proses',
                                                           'bg-emerald-100 text-emerald-900 border-emerald-300': item.status === 'Selesai' || item.status === 'Terima',
                                                           'bg-rose-100 text-rose-900 border-rose-300': item.status === 'Ditolak'
                                                       }"
                                                       x-text="item.status"></span>
                                             </div>
                                             <span class="block text-xs sm:text-sm text-slate-600 line-clamp-2 font-medium mt-1 leading-relaxed" x-text="item.informasi_yang_diminta"></span>
                                         </div>
                                         <span class="text-xs sm:text-sm bg-slate-100 text-slate-700 px-3 py-1 rounded-full font-extrabold shrink-0 ml-2" x-text="item.tgl_diajukan"></span>
                                     </div>
                                 </template>
                            </div>
                        </div>
                        <p x-show="submitted && !nomor_tracking_asal.trim()" x-cloak class="text-xs font-bold text-rose-500 mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> Silakan pilih nomor tiket permohonan terlebih dahulu.
                        </p>
                    </div>

                    <!-- Detail Informasi Yang Diminta Permohonan Asal -->
                    <div x-show="rincian_informasi_asal" x-transition class="space-y-1.5 pt-1">
                        <label class="block text-xs font-bold text-slate-500 tracking-wider uppercase">
                            Permohonan Asal yang Akan Diajukan Keberatan
                        </label>
                        <p class="text-sm text-slate-800 font-medium leading-relaxed"
                           x-text="rincian_informasi_asal"></p>
                    </div>

                    <!-- Alasan Pengajuan Keberatan -->
                    <div>
                        <label class="block text-xs font-black text-slate-700 tracking-wide uppercase mb-2">
                            Alasan Pengajuan Keberatan <span class="text-rose-500">*</span>
                        </label>
                        <select name="alasan_keberatan" x-model="alasan_keberatan" required
                                class="w-full p-3.5 text-sm bg-slate-50/50 border border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-100 focus:bg-white focus:outline-none transition rounded-2xl text-slate-800 font-semibold cursor-pointer"
                                :class="submitted && !alasan_keberatan ? 'border-rose-500 ring-2 ring-rose-100' : ''">
                            <option value="">-- Pilih Alasan Pengajuan Keberatan --</option>
                            <option value="Permohonan Informasi Ditolak">Permohonan Informasi Ditolak</option>
                            <option value="Informasi Berkala Tidak Disediakan">Informasi Berkala Tidak Disediakan</option>
                            <option value="Permohonan Informasi Tidak Ditanggapi">Permohonan Informasi Tidak Ditanggapi</option>
                            <option value="Permohonan Informasi Ditanggapi Tidak Sebagaimana Yang Diminta">Permohonan Informasi Ditanggapi Tidak Sebagaimana Yang Diminta</option>
                            <option value="Permohonan Informasi Tidak Dipenuhi">Permohonan Informasi Tidak Dipenuhi</option>
                            <option value="Biaya Yang Dikenakan Tidak Wajar">Biaya Yang Dikenakan Tidak Wajar</option>
                            <option value="Penyampaian Informasi Melebihi Waktu Yang Ditentukan">Penyampaian Informasi Melebihi Waktu Yang Ditentukan</option>
                        </select>
                        <p x-show="submitted && !alasan_keberatan" x-cloak class="text-xs font-bold text-rose-500 mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> Alasan pengajuan keberatan wajib dipilih.
                        </p>
                    </div>

                </div>

                <!-- KOLOM KANAN: RINCIAN KRONOLOGI & BERKAS PENDUKUNG -->
                <div class="space-y-5">

                    <!-- Rincian Alasan & Kronologi Keberatan -->
                    <div x-data="{ len: 0 }" x-init="len = kronologi_keberatan.length">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-black text-slate-700 tracking-wide uppercase">
                                Kronologi Pengajuan Keberatan <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] font-bold text-slate-400" :class="kronologi_keberatan.length >= 1000 ? 'text-rose-500 font-extrabold' : ''">
                                <span x-text="kronologi_keberatan.length">0</span>/1000 Karakter
                            </span>
                        </div>
                        <textarea name="kronologi_keberatan" x-model="kronologi_keberatan" rows="5" required maxlength="1000"
                                  class="w-full p-3.5 text-sm bg-slate-50/50 border border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-100 focus:bg-white focus:outline-none transition rounded-2xl font-semibold text-slate-800"
                                  :class="submitted && !kronologi_keberatan.trim() ? 'border-rose-500 ring-2 ring-rose-100' : ''"
                                  placeholder="Jelaskan rincian dan kronologi pengajuan keberatan atau tuntutan yang Anda ajukan sedetail mungkin agar mudah diproses."></textarea>
                        <p x-show="submitted && !kronologi_keberatan.trim()" x-cloak class="text-xs font-bold text-rose-500 mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> Rincian kronologi keberatan wajib diisi.
                        </p>
                    </div>

                    <!-- Dokumen Pendukung Keberatan -->
                    <div>
                        <label class="block text-xs font-black text-slate-700 tracking-wide uppercase mb-2">
                            Dokumen Pendukung Keberatan <span class="text-slate-400 font-semibold uppercase">(Opsional)</span>
                        </label>
                        <input type="file" id="pendukung_file_input" name="pendukung_file" accept=".jpg,.jpeg,.png,.pdf,.docx"
                               @change="handlePendukungFileChange($event)"
                               class="w-full text-xs text-slate-600 font-semibold file:mr-3 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-extrabold file:bg-amber-500 file:text-white hover:file:bg-amber-600 file:cursor-pointer border border-slate-200 rounded-2xl bg-slate-50/50 p-1.5 focus:outline-none">
                        <span class="block text-[10px] text-slate-400 mt-1 font-medium">Format: PDF, DOCX, JPG, PNG (Maksimal 5 MB)</span>
                        <template x-if="pendukungErrorMsg">
                            <p class="text-xs font-bold text-rose-500 mt-1 flex items-center gap-1" x-text="pendukungErrorMsg"></p>
                        </template>
                    </div>

                </div>

            </div>

            <!-- BAGIAN PERNYATAAN & TOMBOL SUBMIT -->
            <div class="pt-6 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                <label class="flex items-center gap-3 cursor-pointer bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80 w-fit">
                    <input type="checkbox" x-model="disetujui" required class="w-4 h-4 text-amber-600 rounded focus:ring-amber-500 border-slate-300 shrink-0">
                    <span class="text-xs text-slate-700 leading-relaxed font-extrabold">
                        Saya menyatakan bahwa seluruh informasi yang diserahkan adalah benar dan sah serta dapat dipertanggungjawabkan.
                    </span>
                </label>

                <button type="submit" @click="submitted = true" :disabled="!disetujui"
                        class="w-full sm:w-auto px-9 py-4 bg-amber-500 hover:bg-amber-600 disabled:bg-slate-200 disabled:text-slate-400 disabled:shadow-none text-white text-xs md:text-sm font-extrabold transition rounded-full flex items-center justify-center gap-2 shadow-lg shadow-amber-500/25 hover:shadow-xl cursor-pointer shrink-0">
                    <i class="fa-solid fa-paper-plane text-xs"></i> Kirim Pengajuan Keberatan
                </button>
            </div>

        </div>

    </form>

</main>
