@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Layanan</h1>
            <p class="text-slate-500 mt-1">Kelola dan pantau permohonan informasi Anda.</p>
        </div>
        <button onclick="toggleModal('modal-form', true)" class="group flex items-center gap-2 bg-blue-900 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-blue-800 transition-all shadow-lg">
            <i class="fa-solid fa-plus"></i> Buat Pengajuan Baru
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr class="text-xs uppercase text-slate-500 font-bold tracking-wider">
                        <th class="px-6 py-5">No Tiket</th>
                        <th class="px-6 py-5">Jenis</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-blue-900">{{ $item->no_tiket }}</td>
                        <td class="px-6 py-5 text-slate-700 font-medium">{{ $item->jenis_layanan }}</td>
                        <td class="px-6 py-5">
                            <button onclick="openSummaryModal({{ json_encode($item) }})"
                                    class="px-4 py-2 rounded-full text-xs font-bold uppercase transition hover:scale-105 shadow-sm
                                    {{ $item->status == 'DIAJUKAN' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $item->status }}
                            </button>
                        </td>
                        <td class="px-6 py-5 text-slate-500 text-sm">{{ $item->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada riwayat pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div id="modal-form" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="sticky top-0 bg-white px-8 py-6 border-b border-slate-100 flex justify-between items-center z-10">
            <h2 class="text-xl font-bold text-slate-900">Formulir Pengajuan Baru</h2>
            <button onclick="toggleModal('modal-form', false)" class="text-slate-400 hover:text-slate-600 text-2xl"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6" novalidate>
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Pilih Jenis Layanan <span class="text-red-500">*</span></label>
                <select name="jenis_layanan" id="jenis_layanan" onchange="toggleFormFields()" class="input-field w-full border {{ $errors->has('jenis_layanan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
                    <option value="" disabled selected>Pilih Jenis Layanan</option>
                    <option value="Permohonan" {{ old('jenis_layanan') == 'Permohonan' ? 'selected' : '' }}>Permohonan Informasi</option>
                    <option value="Keberatan" {{ old('jenis_layanan') == 'Keberatan' ? 'selected' : '' }}>Keberatan Informasi</option>
                </select>
                @error('jenis_layanan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="section-keberatan-pilih" class="{{ old('jenis_layanan') == 'Keberatan' ? '' : 'hidden' }}">
                <label class="block text-sm font-bold text-slate-700 mb-1">Pilih Informasi yang Diajukan Keberatannya <span class="text-red-500">*</span></label>
                <select name="permohonan_terkait_id" id="permohonan_terkait_id" onchange="fillRelatedPermohonanData()" class="input-field w-full border {{ $errors->has('permohonan_terkait_id') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
                    <option value="" disabled selected>Pilih Pengajuan Informasi</option>
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
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ auth()->user()->nama_lengkap }}" class="w-full border border-slate-300 rounded-xl p-3 bg-gray-50" readonly>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">No. Identitas (KTP) <span class="text-red-500">*</span></label>
                    <input type="text" name="no_identitas" id="no_identitas" value="{{ old('no_identitas') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="input-field w-full border {{ $errors->has('no_identitas') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
                    @error('no_identitas') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full border border-slate-300 rounded-xl p-3 bg-gray-50" readonly>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">No. HP <span class="text-red-500">*</span></label>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="input-field w-full border {{ $errors->has('telepon') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
                    @error('telepon') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                <textarea name="alamat" id="alamat" class="input-field w-full border {{ $errors->has('alamat') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="2">{{ old('alamat') }}</textarea>
                @error('alamat') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Pekerjaan <span class="text-red-500">*</span></label>
                    <select name="pekerjaan" id="pekerjaan" class="input-field w-full border {{ $errors->has('pekerjaan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
                        <option value="" disabled selected>Pilih Pekerjaan</option>
                        <option value="Mahasiswa" {{ old('pekerjaan') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="Dosen" {{ old('pekerjaan') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                        <option value="Staff/Tenaga Pendidik" {{ old('pekerjaan') == 'Staff/Tenaga Pendidik' ? 'selected' : '' }}>Staff/Tenaga Pendidik</option>
                        <option value="Masyarakat Umum" {{ old('pekerjaan') == 'Masyarakat Umum' ? 'selected' : '' }}>Masyarakat Umum</option>
                    </select>
                    @error('pekerjaan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Kategori Pemohon <span class="text-red-500">*</span></label>
                    <select name="kategori_pemohon" id="kategori_pemohon" onchange="checkKategori()" class="input-field w-full border {{ $errors->has('kategori_pemohon') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
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

            <div id="section-identitas">
                <label class="block text-sm font-bold text-slate-700 mb-1">Lampiran Identitas (KTP) <span class="text-red-500">*</span></label>
                <input type="file" name="identitas" id="identitas" class="input-field w-full border {{ $errors->has('identitas') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3">
                @error('identitas') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="section-akta" class="{{ in_array(old('kategori_pemohon'), ['LSM/NGO', 'Instansi Pemerintah', 'Lembaga Pemerintah']) ? '' : 'hidden' }}">
                <label class="block text-sm font-bold text-slate-700 mb-1">Lampiran Akta Pendirian Badan Hukum <span class="text-red-500">*</span></label>
                <input type="file" name="akta_pendirian" id="akta_pendirian" class="input-field w-full border {{ $errors->has('akta_pendirian') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3">
                @error('akta_pendirian') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="section-permohonan" class="{{ old('jenis_layanan') == 'Permohonan' ? '' : 'hidden' }} space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Rincian Informasi <span class="text-red-500">*</span></label>
                    <textarea name="info_diminta" class="input-field w-full border {{ $errors->has('info_diminta') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="3">{{ old('info_diminta') }}</textarea>
                    @error('info_diminta') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Tujuan Permohonan <span class="text-red-500">*</span></label>
                    <textarea name="tujuan" class="input-field w-full border {{ $errors->has('tujuan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="3">{{ old('tujuan') }}</textarea>
                    @error('tujuan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Lampiran Data Pendukung (Opsional)</label>
                    <input type="file" name="lampiran_pendukung" class="w-full border border-slate-300 rounded-xl p-3">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Cara Memperoleh <span class="text-red-500">*</span></label>
                    <select name="cara_ambil" class="input-field w-full border {{ $errors->has('cara_ambil') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
                        <option value="" disabled selected>Pilih Cara Memperoleh</option>
                        <option value="Mengambil Langsung" {{ old('cara_ambil') == 'Mengambil Langsung' ? 'selected' : '' }}>Mengambil Langsung</option>
                        <option value="Email" {{ old('cara_ambil') == 'Email' ? 'selected' : '' }}>Email</option>
                        <option value="WhatsApp" {{ old('cara_ambil') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                    </select>
                    @error('cara_ambil') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div id="section-keberatan" class="{{ old('jenis_layanan') == 'Keberatan' ? '' : 'hidden' }} space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Tujuan Mengajukan Keberatan <span class="text-red-500">*</span></label>
                    <textarea name="tujuan_keberatan" class="input-field w-full border {{ $errors->has('tujuan_keberatan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="3">{{ old('tujuan_keberatan') }}</textarea>
                    @error('tujuan_keberatan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Alasan Mengajukan Keberatan <span class="text-red-500">*</span></label>
                    <textarea name="alasan_keberatan" class="input-field w-full border {{ $errors->has('alasan_keberatan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="3">{{ old('alasan_keberatan') }}</textarea>
                    @error('alasan_keberatan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Lampiran Data Pendukung (Opsional)</label>
                    <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" class="w-full border border-slate-300 rounded-xl p-3">
                    @error('dokumen_pendukung') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border {{ $errors->has('pernyataan') ? 'border-red-500' : 'border-slate-200' }}">
                <input type="checkbox" name="pernyataan" id="pernyataan" value="1" class="w-5 h-5 rounded border-gray-300 text-blue-900" {{ old('pernyataan') ? 'checked' : '' }}>
                <label for="pernyataan" class="text-sm text-slate-700 font-medium">Saya menyatakan bahwa seluruh informasi adalah benar. <span class="text-red-500">*</span></label>
            </div>
            @error('pernyataan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

            <button type="submit" class="w-full bg-blue-900 text-white py-4 rounded-xl font-bold text-lg hover:bg-blue-950 transition-all shadow-xl">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Summary -->
<div id="modal-summary" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-6xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-6 border-b flex justify-between items-center bg-slate-50">
            <h2 class="text-xl font-bold text-slate-800">Summary Pengajuan</h2>
            <button onclick="toggleModal('modal-summary', false)" class="text-slate-400 hover:text-slate-600 text-xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                <div class="space-y-4">
                    <h4 class="font-bold text-slate-900 border-b pb-2 mb-6">Informasi Pemohon</h4>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Nama Lengkap</span> <span id="modal-nama" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">No. Tiket</span> <span id="modal-tiket" class="font-bold text-blue-700 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">No. Identitas</span> <span id="modal-no-identitas" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Email</span> <span id="modal-email" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">No. HP</span> <span id="modal-hp" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Pekerjaan</span> <span id="modal-pekerjaan" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Alamat</span> <span id="modal-alamat" class="font-bold text-slate-900 text-sm"></span></div>
                </div>
                <div class="space-y-4">
                    <h4 class="font-bold text-slate-900 border-b pb-2 mb-6">Informasi Pengajuan</h4>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Jenis Layanan</span> <span id="modal-jenis" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Kategori</span> <span id="modal-kategori" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Rincian Informasi</span> <span id="modal-info" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Tujuan</span> <span id="modal-tujuan" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Cara Memperoleh</span> <span id="modal-cara" class="font-bold text-slate-900 text-sm"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm uppercase w-40 flex-shrink-0">Lampiran</span> <div id="modal-dokumen" class="flex gap-2"></div></div>
                </div>
            </div>
            <div class="border rounded-2xl overflow-hidden mt-10">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 text-slate-600"><tr><th class="p-4">Status Terkini</th><th class="p-4">Tanggal</th><th class="p-4">Catatan Admin</th></tr></thead>
                    <tbody class="divide-y text-slate-800 font-semibold text-base"><tr><td class="p-4 font-bold" id="modal-status-cell">-</td><td class="p-4" id="modal-tanggal">-</td><td class="p-4" id="modal-catatan">-</td></tr></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const permohonansData = @json($permohonans->keyBy('id'));

    function toggleModal(id, show) { document.getElementById(id).classList.toggle('hidden', !show); }
    function toggleFormFields() {
        const type = document.getElementById('jenis_layanan').value;
        document.getElementById('section-permohonan').classList.toggle('hidden', type !== 'Permohonan');
        document.getElementById('section-keberatan').classList.toggle('hidden', type !== 'Keberatan');
        document.getElementById('section-keberatan-pilih').classList.toggle('hidden', type !== 'Keberatan');
        
        const wrapper = document.getElementById('form-body-wrapper');
        
        if (type === 'Keberatan') {
            setFieldsLockState(true);
            document.getElementById('section-identitas').classList.add('hidden');
            document.getElementById('identitas').disabled = true;
            document.getElementById('section-akta').classList.add('hidden');
            document.getElementById('akta_pendirian').disabled = true;
            
            const relatedId = document.getElementById('permohonan_terkait_id').value;
            wrapper.classList.toggle('hidden', !relatedId);
        } else if (type === 'Permohonan') {
            setFieldsLockState(false);
            document.getElementById('section-identitas').classList.remove('hidden');
            document.getElementById('identitas').disabled = false;
            checkKategori();
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }
    function setFieldsLockState(isLocked) {
        const textInputs = ['no_identitas', 'telepon', 'alamat'];
        const selectInputs = ['pekerjaan', 'kategori_pemohon'];

        textInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.readOnly = isLocked;
                if (isLocked) {
                    el.classList.add('bg-slate-100', 'cursor-not-allowed');
                } else {
                    el.classList.remove('bg-slate-100', 'cursor-not-allowed');
                }
            }
        });

        selectInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                if (isLocked) {
                    el.style.pointerEvents = 'none';
                    el.classList.add('bg-slate-100', 'cursor-not-allowed');
                } else {
                    el.style.pointerEvents = 'auto';
                    el.classList.remove('bg-slate-100', 'cursor-not-allowed');
                }
            }
        });
    }
    function fillRelatedPermohonanData() {
        const id = document.getElementById('permohonan_terkait_id').value;
        const item = permohonansData[id];
        const wrapper = document.getElementById('form-body-wrapper');
        
        if (item) {
            document.getElementById('no_identitas').value = item.no_identitas || '';
            document.getElementById('telepon').value = item.no_hp || '';
            document.getElementById('alamat').value = item.alamat || '';
            document.getElementById('pekerjaan').value = item.pekerjaan || '';
            document.getElementById('kategori_pemohon').value = item.kategori_pemohon || '';
            checkKategori();
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }
    function checkKategori() {
        const type = document.getElementById('jenis_layanan').value;
        if (type === 'Keberatan') {
            document.getElementById('section-akta').classList.add('hidden');
            const aktaInput = document.getElementById('akta_pendirian');
            if (aktaInput) aktaInput.disabled = true;
            return;
        }

        const kategori = document.getElementById('kategori_pemohon').value;
        const sectionAkta = document.getElementById('section-akta');
        const aktaInput = document.getElementById('akta_pendirian');
        const wajibAkta = ['LSM/NGO', 'Instansi Pemerintah', 'Lembaga Pemerintah'];
        
        if (wajibAkta.includes(kategori)) {
            sectionAkta.classList.remove('hidden');
            if (aktaInput) aktaInput.disabled = false;
        } else {
            sectionAkta.classList.add('hidden');
            if (aktaInput) aktaInput.disabled = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleFormFields();
        if (document.getElementById('permohonan_terkait_id').value) {
            fillRelatedPermohonanData();
        }
    });

    document.querySelectorAll('.input-field').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            this.classList.add('border-slate-300');
            const nextElement = this.nextElementSibling;
            if (nextElement && nextElement.classList.contains('error-msg')) {
                nextElement.classList.add('hidden');
            }
        });
        input.addEventListener('change', function() {
            this.classList.remove('border-red-500');
            this.classList.add('border-slate-300');
            const nextElement = this.nextElementSibling;
            if (nextElement && nextElement.classList.contains('error-msg')) {
                nextElement.classList.add('hidden');
            }
        });
    });

    @if ($errors->any()) toggleModal('modal-form', true); @endif

    function openSummaryModal(data) {
        document.getElementById('modal-nama').innerText = data.nama;
        document.getElementById('modal-tiket').innerText = data.no_tiket;
        document.getElementById('modal-no-identitas').innerText = data.no_identitas;
        document.getElementById('modal-email').innerText = data.email;
        document.getElementById('modal-hp').innerText = data.no_hp;
        document.getElementById('modal-pekerjaan').innerText = data.pekerjaan;
        document.getElementById('modal-alamat').innerText = data.alamat;
        document.getElementById('modal-jenis').innerText = data.jenis_layanan;
        document.getElementById('modal-kategori').innerText = data.kategori_pemohon;
        document.getElementById('modal-info').innerText = data.info_diminta || data.alasan_keberatan || '-';
        document.getElementById('modal-tujuan').innerText = data.tujuan_permohonan || data.tujuan_keberatan || '-';
        document.getElementById('modal-cara').innerText = data.cara_memperoleh || '-';
        document.getElementById('modal-status-cell').innerText = data.status;
        document.getElementById('modal-tanggal').innerText = new Date(data.created_at).toLocaleDateString();
        document.getElementById('modal-catatan').innerText = data.catatan_admin || '-';

        const docContainer = document.getElementById('modal-dokumen');
        docContainer.innerHTML = '';
        if(data.lampiran_identitas) docContainer.innerHTML += `<a href="/storage/${data.lampiran_identitas}" target="_blank" class="text-blue-600 text-xs bg-blue-50 px-3 py-1 rounded border border-blue-200">Identitas</a>`;
        if(data.akta_pendirian) docContainer.innerHTML += `<a href="/storage/${data.akta_pendirian}" target="_blank" class="text-blue-600 text-xs bg-blue-50 px-3 py-1 rounded border border-blue-200">Akta</a>`;
        if(data.lampiran_pendukung) docContainer.innerHTML += `<a href="/storage/${data.lampiran_pendukung}" target="_blank" class="text-blue-600 text-xs bg-blue-50 px-3 py-1 rounded border border-blue-200">Pendukung</a>`;

        toggleModal('modal-summary', true);
    }
</script>
@endsection
