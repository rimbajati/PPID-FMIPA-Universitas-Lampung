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
                <p class="text-lg font-bold text-white mb-1">Memproses Permohonan Anda</p>
                <p class="text-sm text-slate-200">Mohon tunggu sebentar...</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[minmax(0,2fr)_minmax(260px,0.95fr)]">
        <form action="{{ url('/permohonan') }}" method="POST" enctype="multipart/form-data" novalidate @submit="submitForm($event)" class="space-y-4">
            @csrf

            <!-- CARD 1: INFORMASI PEMOHON -->
            <section class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-6 flex items-center gap-3.5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-lg">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">1. Informasi Pemohon</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Isi data sesuai identitas agar tim kami dapat menghubungi Anda bila diperlukan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- BARIS 1: Nama Lengkap (Full Width) -->
                    <div class="sm:col-span-2" data-field="nama_lengkap">
                        <label for="nama_lengkap" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-user text-sm"></i>
                            </span>
                            <input id="nama_lengkap" type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" x-model="nama_lengkap" autocomplete="name"
                                   placeholder="Tulis nama lengkap tanpa gelar, sama dengan kartu identitas"
                                   :class="hasError('nama_lengkap') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50'"
                                   class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none">
                        </div>
                        <p x-show="hasError('nama_lengkap')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('nama_lengkap')"></span>
                        </p>
                        <p x-show="!hasError('nama_lengkap')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Tulis nama lengkap sesuai kartu identitas yang Anda unggah.</p>
                        @error('nama_lengkap') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- BARIS 2: Nomor WhatsApp/Telepon -->
                    <div data-field="no_telepon">
                        <label for="no_telepon" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Nomor WhatsApp / Telepon <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-phone text-sm"></i>
                            </span>
                            <input id="no_telepon" type="text" name="no_telepon" value="{{ old('no_telepon') }}" inputmode="numeric" pattern="[0-9]*" maxlength="15" x-model="no_hp" oninput="this.value = this.value.replace(/[^0-9]/g, ''); no_hp = this.value;"
                                   placeholder="Contoh: 0812 3456 7890"
                                   :class="hasError('no_telepon') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50'"
                                   class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none">
                        </div>
                        <p x-show="hasError('no_telepon')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('no_telepon')"></span>
                        </p>
                        <p x-show="!hasError('no_telepon')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Untuk konfirmasi cepat bila permohonan perlu diperjelas.</p>
                        @error('no_telepon') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- BARIS 2: Email -->
                    <div data-field="email">
                        <label for="email" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" x-model="email" autocomplete="email"
                                   placeholder="nama@contoh.ac.id"
                                   :class="hasError('email') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-50'"
                                   class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none">
                        </div>
                        <p x-show="hasError('email')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('email')"></span>
                        </p>
                        <p x-show="!hasError('email')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Jawaban dan nomor tiket dikirim ke alamat email ini.</p>
                        @error('email') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- BARIS 3: Jenis Identitas -->
                    <div data-field="jenis_identitas">
                        <label for="jenis_identitas" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Jenis Identitas <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-id-badge text-sm"></i>
                            </span>
                            <select id="jenis_identitas" name="jenis_identitas" x-model="jenis_identitas"
                                    :class="hasError('jenis_identitas') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50'"
                                    class="w-full appearance-none rounded-xl border bg-white py-3 pl-10 pr-10 text-sm text-slate-800 transition focus:outline-none cursor-pointer">
                                <option value="KTP">KTP</option>
                                <option value="Paspor">Paspor</option>
                                <option value="Badan hukum">Badan hukum</option>
                            </select>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                        <p x-show="hasError('jenis_identitas')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('jenis_identitas')"></span>
                        </p>
                        <div x-show="!hasError('jenis_identitas')">
                            <p class="mt-1.5 text-[11px] sm:text-xs text-slate-400" x-show="jenis_identitas === 'Badan hukum'">Badan hukum: gunakan akta notaris atau SK pendirian.</p>
                            <p class="mt-1.5 text-[11px] sm:text-xs text-slate-400" x-show="jenis_identitas === 'Paspor'">Gunakan paspor resmi yang masih berlaku.</p>
                            <p class="mt-1.5 text-[11px] sm:text-xs text-slate-400" x-show="jenis_identitas === 'KTP'">Gunakan KTP resmi Republik Indonesia.</p>
                        </div>
                        @error('jenis_identitas') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- BARIS 3: Nomor Identitas (Dinamis) -->
                    <div data-field="no_identitas">
                        <label for="no_identitas" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            <span x-text="labelNomorIdentitas">Nomor Identitas</span> <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-id-card text-sm"></i>
                            </span>
                            <input id="no_identitas" type="text" name="no_identitas" value="{{ old('no_identitas') }}"
                                   :inputmode="jenis_identitas === 'KTP' ? 'numeric' : 'text'"
                                   :maxlength="jenis_identitas === 'KTP' ? 16 : 40"
                                   x-model="nik"
                                   @input="handleIdentitasInput($event)"
                                   :placeholder="placeholderNomorIdentitas"
                                   :class="hasError('no_identitas') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50'"
                                   class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none">
                        </div>
                        <p x-show="hasError('no_identitas')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('no_identitas')"></span>
                        </p>
                        <p x-show="!hasError('no_identitas')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400" x-text="hintNomorIdentitas">Nomor pada kartu identitas yang Anda unggah.</p>
                        @error('no_identitas') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- BARIS 4: Salinan Identitas -->
                    <div data-field="file_identitas">
                        <label class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            <span x-text="labelSalinanIdentitas">Salinan Identitas</span> <span class="text-rose-500">*</span>
                        </label>
                        <input type="file" id="file_identitas" name="file_identitas" accept=".jpg,.jpeg,.png,.webp,.pdf" @change="handleIdentitasFileChange($event)" class="sr-only">
                        <div @click="document.getElementById('file_identitas').click()"
                             :class="hasError('file_identitas') ? 'border-rose-300 ring-2 ring-rose-100' : 'border-slate-200 hover:border-slate-300'"
                             class="flex items-center gap-2 w-full rounded-xl border bg-white p-2 pr-2 cursor-pointer transition">
                            <span class="shrink-0 inline-flex items-center justify-center rounded-full bg-blue-600 px-4 py-2 text-xs font-extrabold text-white">Pilih File</span>
                            <span class="flex-1 min-w-0 truncate text-sm" :class="ktpName ? 'text-slate-800' : 'text-slate-400'" x-text="ktpName || 'Belum ada berkas dipilih'"></span>
                            <template x-if="ktpName">
                                <button type="button" @click.stop="clearIdentitasFile()" class="shrink-0 ml-1 inline-flex h-7 w-7 items-center justify-center rounded-full text-rose-500 hover:bg-rose-50 transition"><i class="fa-regular fa-trash-can text-sm"></i></button>
                            </template>
                        </div>
                        <template x-if="ktpName">
                            <div class="mt-2 flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-3 py-2.5">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600"><i class="fa-regular fa-file text-sm"></i></span>
                                <div class="flex-1 min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-800" x-text="ktpName"></p>
                                    <p class="text-xs text-slate-500" x-text="ktpSize"></p>
                                </div>
                                <a :href="ktpUrl" target="_blank" class="shrink-0 inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3.5 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"><i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Lihat</a>
                            </div>
                        </template>
                        <template x-if="ktpErrorMsg">
                            <p class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600"><i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="ktpErrorMsg"></span></p>
                        </template>
                        <p x-show="hasError('file_identitas')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('file_identitas')"></span>
                        </p>
                        <p x-show="!hasError('file_identitas') && !ktpErrorMsg" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">JPG/PNG/WebP/PDF, maks 2 MB. Disimpan aman, hanya dibuka petugas pemroses.</p>
                        @error('file_identitas') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- BARIS 4: Pekerjaan -->
                    <div data-field="pekerjaan">
                        <label for="pekerjaan" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Pekerjaan <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-briefcase text-sm"></i>
                            </span>
                            <input id="pekerjaan" type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" x-model="pekerjaan" autocomplete="organization-title"
                                   placeholder="Contoh: Mahasiswa, Dosen, Pegawai, Wiraswasta"
                                   :class="hasError('pekerjaan') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50'"
                                   class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none">
                        </div>
                        <p x-show="hasError('pekerjaan')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('pekerjaan')"></span>
                        </p>
                        <p x-show="!hasError('pekerjaan')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Pekerjaan atau profesi pemohon saat ini.</p>
                        @error('pekerjaan') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- BARIS 5: Alamat Lengkap (Full Width) -->
                    <div class="sm:col-span-2" data-field="alamat_lengkap">
                        <label for="alamat_lengkap" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Alamat Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute top-3.5 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-location-dot text-sm"></i>
                            </span>
                            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="2" x-model="alamat_lengkap" autocomplete="street-address"
                                      placeholder="Masukkan alamat lengkap sesuai identitas atau domisili saat ini"
                                      :class="hasError('alamat_lengkap') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50'"
                                      class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none">{{ old('alamat_lengkap') }}</textarea>
                        </div>
                        <p x-show="hasError('alamat_lengkap')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('alamat_lengkap')"></span>
                        </p>
                        <p x-show="!hasError('alamat_lengkap')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Alamat domisili saat ini atau alamat kantor bagi badan hukum.</p>
                        @error('alamat_lengkap') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <!-- CARD 2: DETAIL PERMOHONAN -->
            <section class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-6 flex items-center gap-3.5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-lg">
                        <i class="fa-regular fa-file-lines"></i>
                    </span>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">2. Detail Permohonan</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Jelaskan informasi yang diperlukan secara singkat, jelas, dan spesifik.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Informasi yang Diminta -->
                    <div class="sm:col-span-2" data-field="informasi_yang_diminta">
                        <div class="mb-1.5 flex items-center justify-between gap-3">
                            <label for="informasi_yang_diminta" class="block text-xs sm:text-sm font-semibold text-slate-800">
                                Informasi yang Diminta <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-xs text-slate-400 font-medium"><span x-text="rincian.length">0</span>/500</span>
                        </div>
                        <div class="relative">
                            <span class="pointer-events-none absolute top-3.5 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-folder-open text-sm"></i>
                            </span>
                            <textarea id="informasi_yang_diminta" name="informasi_yang_diminta" x-model="rincian" rows="2" maxlength="500"
                                      placeholder="Contoh: Laporan realisasi anggaran FMIPA tahun 2025"
                                      :class="hasError('informasi_yang_diminta') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 hover:border-slate-300'"
                                      class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none"></textarea>
                        </div>
                        <p x-show="hasError('informasi_yang_diminta')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('informasi_yang_diminta')"></span>
                        </p>
                        @error('informasi_yang_diminta') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tujuan Penggunaan Informasi -->
                    <div class="sm:col-span-2" data-field="tujuan_penggunaan_informasi">
                        <div class="mb-1.5 flex items-center justify-between gap-3">
                            <label for="tujuan_penggunaan_informasi" class="block text-xs sm:text-sm font-semibold text-slate-800">
                                Tujuan Penggunaan Informasi <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-xs text-slate-400 font-medium"><span x-text="tujuan.length">0</span>/1000</span>
                        </div>
                        <div class="relative">
                            <span class="pointer-events-none absolute top-3.5 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-comment-dots text-sm"></i>
                            </span>
                            <textarea id="tujuan_penggunaan_informasi" name="tujuan_penggunaan_informasi" x-model="tujuan" rows="2" maxlength="1000"
                                      placeholder="Contoh: Penelitian skripsi, karya ilmiah, atau kebutuhan evaluasi akademik"
                                      :class="hasError('tujuan_penggunaan_informasi') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 hover:border-slate-300'"
                                      class="w-full rounded-xl border bg-white py-3 pl-10 pr-3.5 text-sm text-slate-800 placeholder:text-slate-400 transition focus:outline-none"></textarea>
                        </div>
                        <p x-show="hasError('tujuan_penggunaan_informasi')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('tujuan_penggunaan_informasi')"></span>
                        </p>
                        @error('tujuan_penggunaan_informasi') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Cara Memperoleh Informasi (1 Kolom Tunggal - 2 Opsi) -->
                    <div class="sm:col-span-2" data-field="cara_memperoleh_informasi">
                        <label for="cara_memperoleh_informasi" class="mb-1.5 block text-xs sm:text-sm font-semibold text-slate-800">
                            Cara Memperoleh Informasi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-hand-holding-hand text-sm"></i>
                            </span>
                            <select id="cara_memperoleh_informasi" name="cara_memperoleh_informasi" x-model="cara_memperoleh"
                                    :class="hasError('cara_memperoleh_informasi') ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-50 hover:border-slate-300'"
                                    class="w-full appearance-none rounded-xl border bg-white py-3 pl-10 pr-10 text-sm text-slate-800 transition focus:outline-none cursor-pointer">
                                <option value="Salinan Digital (Dikirim melalui Email)">
                                    Salinan Digital (Dikirim melalui Email)
                                </option>
                                <option value="Datang Langsung ke Dekanat FMIPA Universitas Lampung">
                                    Datang Langsung ke Dekanat FMIPA Universitas Lampung
                                </option>
                            </select>
                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </span>
                        </div>
                        <p x-show="hasError('cara_memperoleh_informasi')" x-cloak class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600">
                            <i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="getErrorMsg('cara_memperoleh_informasi')"></span>
                        </p>
                        <p x-show="!hasError('cara_memperoleh_informasi')" class="mt-1.5 text-[11px] sm:text-xs text-slate-400">Pilih Salinan Digital via email, atau datang langsung ke dekanat (untuk mengambil salinan cetak / melihat & membaca dokumen di tempat).</p>
                        @error('cara_memperoleh_informasi') <p class="mt-1 text-xs text-rose-600 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            <!-- CARD 3: PERSETUJUAN -->
            <section class="rounded-2xl border bg-blue-50/60 p-4 sm:p-5 transition"
                     data-field="disetujui"
                     :class="hasError('disetujui') ? 'border-rose-400 bg-rose-50/50 ring-2 ring-rose-100' : 'border-blue-100'">
                <label class="flex items-start gap-3 text-xs sm:text-sm leading-relaxed text-slate-700 cursor-pointer">
                    <input type="checkbox" name="disetujui" id="checkbox_disetujui" x-model="disetujui" class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Saya menyatakan bahwa data dan permohonan yang disampaikan benar serta dapat dipertanggungjawabkan sesuai ketentuan yang berlaku.</span>
                </label>
            </section>

            <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center pt-2">
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-blue-700 active:scale-[0.99] shadow-sm">
                    <i class="fa-solid fa-paper-plane text-xs"></i> Kirim Permohonan
                </button>
                <p class="text-xs sm:text-sm text-slate-500">Nomor tiket akan dikirim ke email untuk melacak status permohonan Anda.</p>
            </div>
        </form>

        <!-- TIPS ASIDE -->
        <aside class="rounded-2xl border border-blue-100 bg-blue-50/50 p-5 sm:p-6 lg:sticky lg:top-24">
            <div class="mb-3 flex items-center gap-2.5 text-blue-800">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    <i class="fa-regular fa-lightbulb text-sm"></i>
                </span>
                <h2 class="text-sm font-bold text-slate-800">Tips Mengajukan Permohonan</h2>
            </div>
            <p class="mb-4 text-xs sm:text-sm leading-relaxed text-slate-600">Informasi yang jelas membantu petugas menemukan dokumen yang Anda perlukan secara cepat.</p>
            <ol class="space-y-3">
                <li class="flex gap-2.5 text-xs sm:text-sm leading-relaxed text-slate-600">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-200/70 text-[10px] font-bold text-blue-800">1</span>
                    <span>Sebutkan nama dokumen, topik, atau unit kerja terkait secara rinci.</span>
                </li>
                <li class="flex gap-2.5 text-xs sm:text-sm leading-relaxed text-slate-600">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-200/70 text-[10px] font-bold text-blue-800">2</span>
                    <span>Tuliskan periode atau tahun dokumen yang dibutuhkan.</span>
                </li>
                <li class="flex gap-2.5 text-xs sm:text-sm leading-relaxed text-slate-600">
                    <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-200/70 text-[10px] font-bold text-blue-800">3</span>
                    <span>Pastikan email dan nomor kontak aktif dan dapat dihubungi.</span>
                </li>
            </ol>
            <div class="mt-4 border-t border-blue-100 pt-3 text-xs sm:text-sm leading-relaxed text-slate-600">
                <p><i class="fa-regular fa-clock mr-1.5 text-blue-600"></i>Permohonan dijawab paling lambat 10 hari kerja dan dapat diperpanjang 7 hari kerja dengan pemberitahuan resmi.</p>
            </div>
        </aside>
    </div>
</div>
