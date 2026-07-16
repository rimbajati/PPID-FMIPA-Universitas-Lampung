<!-- Modal Form -->
<div id="modal-form" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-5xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="sticky top-0 bg-white px-8 py-6 border-b border-slate-100 flex justify-between items-center z-10">
            <h2 class="text-2xl font-extrabold text-slate-900">Buat Pengajuan</h2>
            <button onclick="toggleModal('modal-form', false)" class="text-slate-400 hover:text-slate-600 text-2xl"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6" novalidate>
            @csrf

            <div>
                <label class="block text-base font-bold text-slate-700 mb-1">Jenis Layanan Informasi <span class="text-red-500">*</span></label>
                <select name="jenis_layanan" id="jenis_layanan" onchange="toggleFormFields()" class="input-field w-full border {{ $errors->has('jenis_layanan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none">
                    <option value="" disabled {{ !old('jenis_layanan') ? 'selected' : '' }}>Pilih Jenis Layanan</option>
                    <option value="Permohonan" {{ old('jenis_layanan') == 'Permohonan' ? 'selected' : '' }}>Permohonan Informasi</option>
                    <option value="Keberatan" {{ old('jenis_layanan') == 'Keberatan' ? 'selected' : '' }}>Pengajuan Keberatan</option>
                </select>
                @error('jenis_layanan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="section-keberatan-pilih" class="mb-6 {{ old('jenis_layanan') == 'Keberatan' ? '' : 'hidden' }}">
                <label class="block text-base font-bold text-slate-700 mb-1">Pilih Permohonan yang akan diajukan keberatan <span class="text-red-500">*</span></label>
                <select name="permohonan_terkait_id" id="permohonan_terkait_id" onchange="fillRelatedPermohonanData()" class="input-field w-full border {{ $errors->has('permohonan_terkait_id') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none">
                    <option value="" disabled selected>Pilih Permohonan Informasi</option>
                    @foreach($permohonans as $item)
                        <option value="{{ $item->id }}" {{ old('permohonan_terkait_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->no_tiket }} - {{ Str::limit($item->info_diminta, 60) }}
                        </option>
                    @endforeach
                </select>
                @error('permohonan_terkait_id') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="form-body-wrapper" class="space-y-6 {{ old('jenis_layanan') == 'Permohonan' || (old('jenis_layanan') == 'Keberatan' && old('permohonan_terkait_id')) ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ auth()->user()->nama_lengkap }}" class="w-full border border-slate-300 rounded-xl p-3.5 text-base bg-gray-50" readonly>
                    </div>
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Nomor Identitas (KTP / SIM / KTM) <span class="text-red-500">*</span></label>
                        <input type="text" name="no_identitas" id="no_identitas" value="{{ old('no_identitas') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-required class="input-field w-full border {{ $errors->has('no_identitas') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none">
                        @error('no_identitas') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full border border-slate-300 rounded-xl p-3.5 text-base bg-gray-50" readonly>
                    </div>
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" data-required class="input-field w-full border {{ $errors->has('telepon') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none">
                        @error('telepon') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-base font-bold text-slate-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" id="alamat" data-required class="input-field w-full border {{ $errors->has('alamat') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none" rows="2">{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Pekerjaan <span class="text-red-500">*</span></label>
                        <select name="pekerjaan" id="pekerjaan" data-required class="input-field w-full border {{ $errors->has('pekerjaan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none">
                            <option value="" disabled selected>Pilih Pekerjaan</option>
                            <option value="Mahasiswa" {{ old('pekerjaan') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Dosen" {{ old('pekerjaan') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="Staf/Tenaga Pendidik" {{ old('pekerjaan') == 'Staff/Tenaga Pendidik' ? 'selected' : '' }}>Staf/Tenaga Pendidik</option>
                            <option value="Masyarakat Umum" {{ old('pekerjaan') == 'Masyarakat Umum' ? 'selected' : '' }}>Masyarakat Umum</option>
                        </select>
                        @error('pekerjaan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Kategori Pemohon <span class="text-red-500">*</span></label>
                        <select name="kategori_pemohon" id="kategori_pemohon" onchange="checkKategori()" data-required class="input-field w-full border {{ $errors->has('kategori_pemohon') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Perorangan" {{ old('kategori_pemohon') == 'Perorangan' ? 'selected' : '' }}>Perorangan</option>
                            <option value="Kelompok" {{ old('kategori_pemohon') == 'Kelompok' ? 'selected' : '' }}>Kelompok</option>
                            <option value="LSM/NGO" {{ old('kategori_pemohon') == 'LSM/NGO' ? 'selected' : '' }}>LSM/NGO</option>
                            <option value="Instansi Pemerintah" {{ old('kategori_pemohon') == 'Instansi Pemerintah' ? 'selected' : '' }}>Instansi Pemerintah</option>
                            <option value="Lembaga Pemerintah" {{ old('kategori_pemohon') == 'Lembaga Pemerintah' ? 'selected' : '' }}>Lembaga Pemerintah</option>
                            <option value="Lainnya" {{ old('kategori_pemohon') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori_pemohon') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div id="section-identitas" class="space-y-1">
                    <label class="block text-base font-bold text-slate-700">Lampiran Identitas (KTP / SIM / KTM) <span class="text-red-500">*</span></label>
                    <input type="file" name="identitas" id="identitas" data-required class="input-field w-full border {{ $errors->has('identitas') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-900 file:text-white hover:file:bg-blue-950 file:transition-all cursor-pointer">
                    <p class="text-xs text-slate-400 font-medium mt-1.5">(Format: JPG, JPEG, PNG | Maks: 2 MB)</p>
                    @error('identitas') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="section-akta" class="{{ in_array(old('kategori_pemohon'), ['LSM/NGO', 'Instansi Pemerintah', 'Lembaga Pemerintah']) ? '' : 'hidden' }} space-y-1">
                    <label class="block text-base font-bold text-slate-700">Lampiran Akta Pendirian Badan Hukum <span class="text-red-500">*</span></label>
                    <input type="file" name="akta_pendirian" id="akta_pendirian" data-required class="input-field w-full border {{ $errors->has('akta_pendirian') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-900 file:text-white hover:file:bg-blue-950 file:transition-all cursor-pointer">
                    <p class="text-xs text-slate-400 font-medium mt-1.5">(Format: JPG, PNG, PDF | Maks: 2 MB)</p>
                    @error('akta_pendirian') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="section-permohonan" class="{{ old('jenis_layanan') == 'Permohonan' ? '' : 'hidden' }} space-y-4">
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Rincian Informasi <span class="text-red-500">*</span></label>
                        <textarea name="info_diminta" id="info_diminta" data-required class="input-field w-full border {{ $errors->has('info_diminta') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none" rows="3" placeholder="Tuliskan informasi publik yang ingin Anda minta secara jelas dan lengkap...">{{ old('info_diminta') }}</textarea>
                        @error('info_diminta') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Tujuan Permohonan <span class="text-red-500">*</span></label>
                        <textarea name="tujuan" id="tujuan" data-required class="input-field w-full border {{ $errors->has('tujuan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none" rows="3" placeholder="Jelaskan tujuan penggunaan informasi publik yang Anda minta...">{{ old('tujuan') }}</textarea>
                        @error('tujuan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block text-base font-bold text-slate-700">Lampiran Data Pendukung (Opsional)</label>
                        <input type="file" name="lampiran_pendukung" id="lampiran_pendukung" class="input-field w-full border {{ $errors->has('lampiran_pendukung') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-900 file:text-white hover:file:bg-blue-950 file:transition-all cursor-pointer">
                        <p class="text-xs text-slate-400 font-medium mt-1.5">(Format: JPG, PNG, PDF | Maks: 2 MB | jika file lebih dari satu, silahkan digabungkan (merge) menjadi 1 file pdf)</p>
                        @error('lampiran_pendukung') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-2.5">Cara Memperoleh Informasi <span class="text-red-500">*</span></label>
                        
                        <div class="space-y-3.5 pl-1 mb-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="cara_ambil_radio" value="Mengambil langsung ke FMIPA" class="w-5 h-5 text-blue-900 border-slate-350 focus:ring-blue-900 cursor-pointer" {{ old('cara_ambil') == 'Mengambil langsung ke FMIPA' ? 'checked' : '' }} onchange="selectCaraAmbil(this.value)">
                                <span class="text-base font-semibold text-slate-700 group-hover:text-slate-900 transition-colors">Mengambil langsung ke FMIPA</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="cara_ambil_radio" value="Melalui Email atau Website" class="w-5 h-5 text-blue-900 border-slate-350 focus:ring-blue-900 cursor-pointer" {{ old('cara_ambil') == 'Melalui Email atau Website' ? 'checked' : '' }} onchange="selectCaraAmbil(this.value)">
                                <span class="text-base font-semibold text-slate-700 group-hover:text-slate-900 transition-colors">Melalui Email atau Website</span>
                            </label>
                        </div>
                        
                        <!-- Hidden Input untuk validasi JS & penempatan pesan error di bawah -->
                        <input type="hidden" name="cara_ambil" id="cara_ambil" data-required value="{{ old('cara_ambil') }}">
                        @error('cara_ambil') <p class="error-msg text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div id="section-keberatan" class="{{ old('jenis_layanan') == 'Keberatan' ? '' : 'hidden' }} space-y-4">
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Tujuan Mengajukan Keberatan <span class="text-red-500">*</span></label>
                        <textarea name="tujuan_keberatan" id="tujuan_keberatan" data-required class="input-field w-full border {{ $errors->has('tujuan_keberatan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none" rows="3" placeholder="Jelaskan maksud atau tujuan Anda dalam mengajukan keberatan ini...">{{ old('tujuan_keberatan') }}</textarea>
                        @error('tujuan_keberatan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-base font-bold text-slate-700 mb-1">Alasan Mengajukan Keberatan <span class="text-red-500">*</span></label>
                        <textarea name="alasan_keberatan" id="alasan_keberatan" data-required class="input-field w-full border {{ $errors->has('alasan_keberatan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3.5 text-base outline-none" rows="3" placeholder="Sebutkan alasan detail mengapa Anda mengajukan keberatan terhadap tanggapan permohonan informasi...">{{ old('alasan_keberatan') }}</textarea>
                        @error('alasan_keberatan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="block text-base font-bold text-slate-700">Lampiran Data Pendukung (Opsional)</label>
                        <input type="file" name="lampiran_pendukung" id="lampiran_pendukung_keberatan" class="input-field w-full border {{ $errors->has('lampiran_pendukung') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-900 file:text-white hover:file:bg-blue-950 file:transition-all cursor-pointer">
                        <p class="text-xs text-slate-400 font-medium mt-1.5">(Format: JPG, JPEG, PNG, PDF | Maks: 2 MB | jika file lebih dari satu, silahkan digabungkan (merge) menjadi 1 file pdf)</p>
                        <div id="keberatan-existing-file-info" class="mt-2 text-sm text-slate-600 bg-slate-50 p-2.5 rounded-lg border border-slate-100 flex items-center justify-between hidden">
                            <span class="flex items-center gap-1.5 text-xs">
                                <i class="fa-solid fa-file text-blue-900 text-sm"></i>
                                <span>Terdapat file pendukung bawaan dari permohonan terkait.</span>
                            </span>
                            <a id="keberatan-existing-file-link" href="#" target="_blank" class="text-blue-600 font-semibold hover:underline text-xs flex items-center gap-1">
                                <i class="fa-solid fa-eye text-xs"></i> Lihat File
                            </a>
                        </div>
                        @error('lampiran_pendukung') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border {{ $errors->has('pernyataan') ? 'border-red-500' : 'border-slate-200' }}">
                    <input type="checkbox" name="pernyataan" id="pernyataan" value="1" data-required class="w-5 h-5 rounded border-gray-300 text-blue-900" {{ old('pernyataan') ? 'checked' : '' }}>
                    <label for="pernyataan" class="text-base text-slate-700 font-medium">Saya menyatakan bahwa seluruh informasi adalah benar.</label>
                </div>
                @error('pernyataan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                <button type="submit" class="w-full bg-blue-900 text-white py-4 rounded-xl font-bold text-lg hover:bg-blue-950 transition-all shadow-xl">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>

