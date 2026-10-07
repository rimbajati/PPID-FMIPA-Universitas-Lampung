<div class="w-full">
    <!-- Loading Splash Overlay -->
    <div x-show="isLoading" 
         class="fixed inset-0 z-[999999] flex items-center justify-center bg-slate-900/70 backdrop-blur-sm"
         x-cloak>
        <div class="flex flex-col items-center justify-center gap-4">
            <!-- Spinner -->
            <div class="relative w-16 h-16">
                <div class="absolute inset-0 rounded-full border-4 border-slate-300/30"></div>
                <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-white border-r-white animate-spin"></div>
            </div>
            <!-- Text -->
            <div class="text-center">
                <p class="text-lg font-bold text-white mb-1">Memproses Pengajuan Keberatan</p>
                <p class="text-sm text-slate-200">Mohon tunggu sebentar...</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[minmax(0,2fr)_minmax(260px,0.95fr)]">
        <form action="{{ route('layanan.keberatan.store') }}" method="POST" enctype="multipart/form-data" novalidate @submit="submitForm($event)" class="space-y-4">
            @csrf

            <!-- CARD 1: DATA PERMOHONAN ASAL -->
            <section class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-6 flex items-center gap-3.5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-amber-50 text-amber-600 text-lg">
                        <i class="fa-regular fa-file-lines"></i>
                    </span>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">1. Data Permohonan Asal</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Masukkan nomor tiket permohonan yang ingin diajukan keberatan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Nomor Tiket Permohonan -->
                    <div class="sm:col-span-2" data-field="no_tiket_permohonan">
                        <label for="no_tiket_permohonan" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Nomor Tiket Permohonan <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-clipboard text-sm"></i>
                            </span>
                            <input id="no_tiket_permohonan" type="text" name="no_tiket_permohonan" value="{{ old('no_tiket_permohonan') }}" x-model="no_tiket_permohonan" autocomplete="off"
                                   placeholder="Contoh: PPID-20261006-A3B5"
                                   :class="hasError('no_tiket_permohonan') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-50'"
                                   class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none">
                        </div>
                        <p x-show="hasError('no_tiket_permohonan')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('no_tiket_permohonan')"></span>
                        </p>
                        <p x-show="!hasError('no_tiket_permohonan')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Nomor tiket diberikan saat Anda mengajukan permohonan informasi.</p>
                        @error('no_tiket_permohonan') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email Pemohon -->
                    <div class="sm:col-span-2" data-field="email">
                        <label for="email_pemohon" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Email yang Digunakan Saat Pengajuan <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </span>
                            <input id="email_pemohon" type="email" name="email" value="{{ old('email') }}" x-model="email" autocomplete="email"
                                   placeholder="nama@contoh.ac.id"
                                   :class="hasError('email') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-50'"
                                   class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none">
                        </div>
                        <p x-show="hasError('email')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('email')"></span>
                        </p>
                        <p x-show="!hasError('email')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Email harus sama dengan saat mengajukan permohonan untuk verifikasi.</p>
                        @error('email') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <!-- CARD 2: ALASAN & KRONOLOGI KEBERATAN -->
            <section class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-6 flex items-center gap-3.5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-amber-50 text-amber-600 text-lg">
                        <i class="fa-regular fa-comment"></i>
                    </span>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">2. Alasan & Kronologi</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Pilih alasan pengajuan keberatan dan jelaskan kronologinya.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Alasan Keberatan -->
                    <div data-field="alasan_keberatan">
                        <label for="alasan_keberatan" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Alasan Pengajuan Keberatan <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select id="alasan_keberatan" name="alasan_keberatan" x-model="alasan_keberatan" required
                                    :class="hasError('alasan_keberatan') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-50'"
                                    class="w-full appearance-none rounded-xl border bg-white py-3 pl-10 pr-10 text-sm text-slate-800 transition focus:outline-none cursor-pointer">
                                <option value="">-- Pilih Alasan Keberatan --</option>
                                <option value="Permohonan Informasi Ditolak">Permohonan Informasi Ditolak</option>
                                <option value="Informasi Berkala Tidak Disediakan">Informasi Berkala Tidak Disediakan</option>
                                <option value="Permohonan Informasi Tidak Ditanggapi">Permohonan Informasi Tidak Ditanggapi</option>
                                <option value="Permohonan Informasi Ditanggapi Tidak Sebagaimana Yang Diminta">Permohonan Informasi Ditanggapi Tidak Sebagaimana Yang Diminta</option>
                                <option value="Permohonan Informasi Tidak Dipenuhi">Permohonan Informasi Tidak Dipenuhi</option>
                                <option value="Biaya Yang Dikenakan Tidak Wajar">Biaya Yang Dikenakan Tidak Wajar</option>
                                <option value="Penyampaian Informasi Melebihi Waktu Yang Ditentukan">Penyampaian Informasi Melebihi Waktu Yang Ditentukan</option>
                            </select>
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                        <p x-show="hasError('alasan_keberatan')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('alasan_keberatan')"></span>
                        </p>
                        @error('alasan_keberatan') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Kronologi Keberatan -->
                    <div data-field="kronologi_keberatan">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="kronologi_keberatan" class="block text-xs sm:text-sm font-semibold text-slate-800">
                                Kronologi Pengajuan Keberatan <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-[11px] font-semibold text-slate-400" :class="kronologi_keberatan.length >= 1000 ? 'text-rose-500' : ''" x-text="`${kronologi_keberatan.length}/1000`"></span>
                        </div>
                        <textarea id="kronologi_keberatan" name="kronologi_keberatan" x-model="kronologi_keberatan" rows="4" required maxlength="1000"
                                  placeholder="Jelaskan rincian dan kronologi pengajuan keberatan Anda sedetail mungkin agar mudah diproses."
                                  :class="hasError('kronologi_keberatan') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-50'"
                                  class="w-full rounded-xl border bg-white py-3 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none resize-none"></textarea>
                        <p x-show="hasError('kronologi_keberatan')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('kronologi_keberatan')"></span>
                        </p>
                        @error('kronologi_keberatan') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Dokumen Pendukung -->
                    <div data-field="pendukung_file">
                        <label class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Dokumen Pendukung <span class="text-slate-400 text-xs font-normal">(Opsional)</span>
                        </label>
                        <input type="file" id="pendukung_file_input" name="pendukung_file" accept=".jpg,.jpeg,.png,.pdf,.docx,.doc"
                               @change="handlePendukungFileChange($event)" class="sr-only">
                        <div @click="document.getElementById('pendukung_file_input').click()"
                             class="flex items-center gap-2 w-full rounded-xl border border-slate-200 bg-white p-2 pr-2 cursor-pointer transition hover:border-slate-300">
                            <span class="shrink-0 inline-flex items-center justify-center rounded-full bg-amber-600 px-4 py-2 text-xs font-extrabold text-white">Pilih File</span>
                            <span class="flex-1 min-w-0 truncate text-sm" :class="pendukungFileName ? 'text-slate-800' : 'text-slate-400'" x-text="pendukungFileName || 'Belum ada berkas dipilih'"></span>
                            <template x-if="pendukungFileName">
                                <button type="button" @click.stop="clearPendukungFile()" class="shrink-0 ml-1 inline-flex h-7 w-7 items-center justify-center rounded-full text-rose-500 hover:bg-rose-50 transition"><i class="fa-regular fa-trash-can text-sm"></i></button>
                            </template>
                        </div>
                        <template x-if="pendukungFileName">
                            <div class="mt-2 flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2.5">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600"><i class="fa-regular fa-file text-sm"></i></span>
                                <div class="flex-1 min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-800" x-text="pendukungFileName"></p>
                                    <p class="text-xs text-slate-500" x-text="pendukungFileSize"></p>
                                </div>
                                <a :href="pendukungFileUrl" target="_blank" class="shrink-0 inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3.5 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"><i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Lihat</a>
                            </div>
                        </template>
                        <template x-if="pendukungErrorMsg">
                            <p class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                                <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="pendukungErrorMsg"></span>
                            </p>
                        </template>
                        <p x-show="!pendukungErrorMsg" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Format: PDF, DOCX, JPG, PNG (Maksimal 5 MB)</p>
                    </div>
                </div>
            </section>

            <!-- CARD 3: PERNYATAAN & SUBMIT -->
            <section class="rounded-2xl border bg-amber-50/60 p-4 sm:p-5 transition"
                     data-field="disetujui"
                     :class="hasError('disetujui') ? 'border-rose-400 bg-rose-50/50 ring-2 ring-rose-100' : 'border-amber-100'">
                <label class="flex items-start gap-3 text-xs sm:text-sm leading-relaxed text-slate-700 cursor-pointer">
                    <input type="checkbox" name="disetujui" id="checkbox_disetujui" x-model="disetujui" class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                    <span>Saya menyatakan bahwa seluruh informasi yang diserahkan adalah benar dan sah serta dapat dipertanggungjawabkan sesuai dengan ketentuan hukum yang berlaku.</span>
                </label>
                <p x-show="hasError('disetujui')" x-cloak class="mt-2.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                </p>
            </section>

            <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center pt-2">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-amber-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-amber-700 active:scale-[0.99] shadow-sm">
                    <i class="fa-solid fa-paper-plane text-xs"></i> Kirim Keberatan
                </button>
                <p class="text-xs sm:text-sm text-slate-500">Keberatan akan diproses sesuai ketentuan UU KIP.</p>
            </div>
        </form>

        <!-- TIPS ASIDE -->
        <aside class="rounded-2xl border border-amber-100 bg-amber-50/50 p-5 sm:p-6 lg:sticky lg:top-24">
            <div class="mb-3 flex items-center gap-2.5 text-amber-800">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                    <i class="fa-regular fa-lightbulb text-sm"></i>
                </span>
                <h2 class="text-sm font-bold text-slate-800">Ketentuan Keberatan</h2>
            </div>
            <p class="mb-4 text-xs sm:text-sm leading-relaxed text-slate-600">Keberatan dapat diajukan apabila permohonan informasi tidak ditanggapi sesuai ketentuan UU KIP.</p>
            <ol class="space-y-3">
                <li class="flex gap-2.5 text-xs sm:text-sm leading-relaxed text-slate-600">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-amber-200/70 text-[10px] font-bold text-amber-800">1</span>
                    <span>Pastikan nomor tiket permohonan asal valid dan terdaftar.</span>
                </li>
                <li class="flex gap-2.5 text-xs sm:text-sm leading-relaxed text-slate-600">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-amber-200/70 text-[10px] font-bold text-amber-800">2</span>
                    <span>Jelaskan kronologi keberatan secara rinci dan kronologis.</span>
                </li>
                <li class="flex gap-2.5 text-xs sm:text-sm leading-relaxed text-slate-600">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-amber-200/70 text-[10px] font-bold text-amber-800">3</span>
                    <span>Lampirkan dokumen pendukung jika diperlukan.</span>
                </li>
            </ol>
            <div class="mt-4 border-t border-amber-100 pt-3 text-xs sm:text-sm leading-relaxed text-slate-600">
                <p><i class="fa-regular fa-clock mr-1.5 text-amber-600"></i>Keberatan akan ditanggapi maksimal 30 hari kerja sejak pengajuan sesuai UU No. 14 Tahun 2008.</p>
            </div>
        </aside>
    </div>
</div>
