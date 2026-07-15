@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Layanan</h1>
            <p class="text-slate-500 mt-1">Kelola dan pantau permohonan informasi Anda.</p>
        </div>
        <button onclick="toggleModal('modal-form', true)" class="self-end md:self-auto group flex items-center gap-2 bg-blue-900 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-blue-800 transition-all shadow-lg">
            <i class="fa-solid fa-plus"></i> Buat Pengajuan Baru
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr class="text-xs uppercase text-slate-500 font-bold tracking-wider">
                        <th class="px-6 py-5">No Tiket</th>
                        <th class="px-6 py-5 whitespace-nowrap">Jenis Layanan</th>
                        <th class="px-6 py-5">Rincian Pengajuan</th>
                        <th class="px-6 py-5 whitespace-nowrap">Tanggal Pengajuan</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-blue-900 whitespace-nowrap">{{ $item->no_tiket }}</td>
                        <td class="px-6 py-5 text-slate-800 text-sm font-semibold whitespace-nowrap">
                            {{ $item->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}
                        </td>
                        <td class="px-6 py-5 text-slate-600 text-sm max-w-xs">
                            <span class="truncate block" title="{{ $item->info_diminta ?? $item->tujuan_keberatan }}">
                                {{ Str::limit($item->info_diminta ?? $item->tujuan_keberatan, 45) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-slate-500 text-sm whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold border
                                    {{ $item->status == 'DIAJUKAN' ? 'bg-amber-50/60 text-amber-800 border-amber-200/50' : '' }}
                                    {{ $item->status == 'DIPROSES' ? 'bg-blue-50/60 text-blue-800 border-blue-200/50' : '' }}
                                    {{ $item->status == 'DITERIMA' ? 'bg-emerald-50/60 text-emerald-800 border-emerald-200/50' : '' }}
                                    {{ $item->status == 'DITOLAK' ? 'bg-rose-50/60 text-rose-800 border-rose-200/50' : '' }}">
                                <span class="h-1.5 w-1.5 rounded-full
                                    {{ $item->status == 'DIAJUKAN' ? 'bg-amber-500' : '' }}
                                    {{ $item->status == 'DIPROSES' ? 'bg-blue-500' : '' }}
                                    {{ $item->status == 'DITERIMA' ? 'bg-emerald-500' : '' }}
                                    {{ $item->status == 'DITOLAK' ? 'bg-rose-500' : '' }}"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openSummaryModal({{ json_encode($item) }})"
                                        class="w-9 h-9 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition flex items-center justify-center hover:-translate-y-0.5 hover:shadow-sm"
                                        title="Lihat Detail">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                                
                                @if($item->status == 'DIAJUKAN')
                                    <button onclick="openEditModal({{ json_encode($item) }})"
                                            class="w-9 h-9 bg-blue-50/50 hover:bg-blue-50 border border-blue-200/60 text-blue-600 rounded-xl transition flex items-center justify-center hover:-translate-y-0.5 hover:shadow-sm"
                                            title="Edit Pengajuan">
                                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                                    </button>
                                    <button onclick="deletePengajuan({{ $item->id }}, '{{ $item->no_tiket }}')"
                                            class="w-9 h-9 bg-rose-50/50 hover:bg-rose-50 border border-rose-200/60 text-rose-600 rounded-xl transition flex items-center justify-center hover:-translate-y-0.5 hover:shadow-sm"
                                            title="Hapus Pengajuan">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                @else
                                    <button class="w-9 h-9 bg-slate-50 border border-slate-200/60 text-slate-400 rounded-xl cursor-not-allowed flex items-center justify-center" disabled title="Pengajuan Terkunci (Sedang Diproses)">
                                        <i class="fa-solid fa-lock text-xs"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-slate-400">Belum ada riwayat pengajuan.</td></tr>
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

        <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data" class="p-8" novalidate>
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-1">Pilih Jenis Layanan <span class="text-red-500">*</span></label>
                <select name="jenis_layanan" id="jenis_layanan" onchange="toggleFormFields()" class="input-field w-full border {{ $errors->has('jenis_layanan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
                    <option value="" disabled {{ !old('jenis_layanan') ? 'selected' : '' }}>Pilih Jenis Layanan</option>
                    <option value="Permohonan" {{ old('jenis_layanan') == 'Permohonan' ? 'selected' : '' }}>Permohonan Informasi</option>
                    <option value="Keberatan" {{ old('jenis_layanan') == 'Keberatan' ? 'selected' : '' }}>Pengajuan Keberatan</option>
                </select>
                @error('jenis_layanan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div id="section-keberatan-pilih" class="mb-6 {{ old('jenis_layanan') == 'Keberatan' ? '' : 'hidden' }}">
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
                        <option value="Staf/Tenaga Pendidik" {{ old('pekerjaan') == 'Staff/Tenaga Pendidik' ? 'selected' : '' }}>Staf/Tenaga Pendidik</option>
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
                    <textarea name="info_diminta" id="info_diminta" class="input-field w-full border {{ $errors->has('info_diminta') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="3">{{ old('info_diminta') }}</textarea>
                    @error('info_diminta') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Tujuan Permohonan <span class="text-red-500">*</span></label>
                    <textarea name="tujuan" id="tujuan" class="input-field w-full border {{ $errors->has('tujuan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="3">{{ old('tujuan') }}</textarea>
                    @error('tujuan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Lampiran Pendukung (Opsional)</label>
                    <input type="file" name="lampiran_pendukung" id="lampiran_pendukung" class="w-full border border-slate-300 rounded-xl p-3">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Cara Memperoleh <span class="text-red-500">*</span></label>
                    <select name="cara_ambil" id="cara_ambil" class="input-field w-full border {{ $errors->has('cara_ambil') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none">
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
                    <textarea name="tujuan_keberatan" id="tujuan_keberatan" class="input-field w-full border {{ $errors->has('tujuan_keberatan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="3">{{ old('tujuan_keberatan') }}</textarea>
                    @error('tujuan_keberatan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Alasan Mengajukan Keberatan <span class="text-red-500">*</span></label>
                    <textarea name="alasan_keberatan" id="alasan_keberatan" class="input-field w-full border {{ $errors->has('alasan_keberatan') ? 'border-red-500' : 'border-slate-300' }} rounded-xl p-3 outline-none" rows="3">{{ old('alasan_keberatan') }}</textarea>
                    @error('alasan_keberatan') <p class="error-msg text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Lampiran Pendukung (Opsional)</label>
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
    <div class="bg-white rounded-3xl w-full max-w-7xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-6 border-b flex justify-between items-center bg-slate-50">
            <h2 class="text-2xl font-bold text-slate-800">Summary Pengajuan</h2>
            <button onclick="toggleModal('modal-summary', false)" class="text-slate-400 hover:text-slate-600 text-2xl"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                <div class="space-y-5">
                    <h4 class="text-xl font-bold text-slate-900 border-b pb-3 mb-6">Informasi Pemohon</h4>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Nama Lengkap</span> <span id="modal-nama" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">No. Tiket</span> <span id="modal-tiket" class="font-bold text-blue-700 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">No. Identitas</span> <span id="modal-no-identitas" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Email</span> <span id="modal-email" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">No. HP</span> <span id="modal-hp" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Pekerjaan</span> <span id="modal-pekerjaan" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Alamat</span> <span id="modal-alamat" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                </div>
                <div class="space-y-5">
                    <h4 class="text-xl font-bold text-slate-900 border-b pb-3 mb-6">Informasi Pengajuan</h4>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Jenis Layanan</span> <span id="modal-jenis" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Kategori</span> <span id="modal-kategori" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span id="lbl-modal-info" class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Rincian Informasi</span> <span id="modal-info" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-start"><span id="lbl-modal-tujuan" class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Tujuan</span> <span id="modal-tujuan" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div id="row-modal-cara" class="flex items-start"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Cara Memperoleh</span> <span id="modal-cara" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    
                    <div class="flex items-center"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Lampiran Identitas</span> <span id="modal-identitas-doc" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div id="row-modal-akta" class="flex items-center"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Lampiran Akta Pendirian Badan Hukum</span> <span id="modal-akta-doc" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                    <div class="flex items-center"><span class="text-slate-500 text-sm md:text-base uppercase w-56 md:w-64 flex-shrink-0 font-medium">Lampiran Pendukung</span> <span id="modal-pendukung-doc" class="font-semibold text-slate-900 text-base md:text-lg"></span></div>
                </div>
            </div>
            <div class="border rounded-2xl overflow-hidden mt-12">
                <table class="w-full text-base">
                    <thead class="bg-slate-100 text-slate-600"><tr><th class="p-5 text-left font-bold text-slate-700">Status Terkini</th><th class="p-5 text-left font-bold text-slate-700">Tanggal</th><th class="p-5 text-left font-bold text-slate-700">Catatan Admin</th></tr></thead>
                    <tbody class="divide-y text-slate-800 font-semibold text-lg bg-white"><tr><td class="p-5 font-bold" id="modal-status-cell">-</td><td class="p-5" id="modal-tanggal">-</td><td class="p-5" id="modal-catatan">-</td></tr></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div id="modal-delete" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-4 border border-red-100">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Konfirmasi Hapus</h3>
            <p class="text-slate-500 text-sm mb-6">Apakah Anda yakin ingin menghapus pengajuan dengan nomor tiket <span id="delete-ticket-display" class="font-bold text-slate-800"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-center">
                <button onclick="toggleModal('modal-delete', false)" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-sm transition-all">
                    Batal
                </button>
                <button id="confirm-delete-btn" class="px-5 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold text-sm transition-all shadow-lg shadow-red-200">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const permohonansData = @json($permohonans->keyBy('id'));

    function toggleModal(id, show) {
        document.getElementById(id).classList.toggle('hidden', !show);
        if (id === 'modal-form' && !show) {
            resetForm();
        }
    }

    function resetForm() {
        const form = document.querySelector('#modal-form form');
        if (form) {
            form.reset();
            form.action = "{{ route('layanan.store') }}";
            
            // Remove PUT override
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
            
            // Reset submit button text
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Kirim Pengajuan';
            }
        }
        
        // Reset Title
        const titleEl = document.querySelector('#modal-form h2');
        if (titleEl) titleEl.innerText = 'Formulir Pengajuan Baru';
        
        // Re-enable select fields
        const jenisLayanan = document.getElementById('jenis_layanan');
        if (jenisLayanan) {
            jenisLayanan.value = "";
            jenisLayanan.disabled = false;
        }
        
        const permohonanTerkait = document.getElementById('permohonan_terkait_id');
        if (permohonanTerkait) {
            permohonanTerkait.value = "";
            permohonanTerkait.disabled = false;
        }
        
        document.querySelectorAll('.error-msg').forEach(el => el.remove());
        document.querySelectorAll('.input-field').forEach(el => {
            el.classList.remove('border-red-500');
            el.classList.add('border-slate-300');
        });
        
        toggleFormFields();
    }
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
        const urlParams = new URLSearchParams(window.location.search);
        const typeParam = urlParams.get('type');
        
        if (typeParam === 'permohonan' || typeParam === 'keberatan') {
            const val = typeParam === 'permohonan' ? 'Permohonan' : 'Keberatan';
            document.getElementById('jenis_layanan').value = val;
            
            toggleModal('modal-form', true);
            
            const url = new URL(window.location);
            url.searchParams.delete('type');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }

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

    const form = document.querySelector('#modal-form form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous error messages
            document.querySelectorAll('.error-msg').forEach(el => el.remove());
            document.querySelectorAll('.input-field').forEach(el => {
                el.classList.remove('border-red-500');
                el.classList.add('border-slate-300');
            });
            
            // Show loading state or disable button
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Mengirim...';
            }
            
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const isJson = response.headers.get('content-type')?.includes('application/json');
                const data = isJson ? await response.json() : null;
                
                if (response.status === 422) {
                    // Validation errors
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                    
                    if (data && data.errors) {
                        for (const [field, messages] of Object.entries(data.errors)) {
                            // Find the input element by id first, then by name
                            let inputEl = document.getElementById(field) || form.querySelector(`[name="${field}"]`);
                            
                            if (inputEl) {
                                inputEl.classList.remove('border-slate-300');
                                inputEl.classList.add('border-red-500');
                                
                                // Create error message paragraph
                                const errorP = document.createElement('p');
                                errorP.className = 'error-msg text-red-500 text-xs mt-1';
                                errorP.innerText = messages[0];
                                
                                // Insert error message after the element
                                if (field === 'pernyataan') {
                                    const container = inputEl.closest('.flex');
                                    if (container) {
                                        container.after(errorP);
                                    } else {
                                        inputEl.after(errorP);
                                    }
                                } else {
                                    inputEl.after(errorP);
                                }
                            }
                        }
                        
                        // Scroll to the first error
                        const firstError = form.querySelector('.border-red-500');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                } else if (response.ok) {
                    // Success! Reload page to display success flash message
                    window.location.reload();
                } else {
                    // System errors
                    alert(data && data.message ? data.message : 'Terjadi kesalahan sistem. Silakan coba lagi.');
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                }
            })
            .catch(error => {
                console.error(error);
                alert('Gagal mengirim pengajuan. Periksa koneksi internet Anda.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            });
        });
    }

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
        
        if (data.jenis_layanan === 'Keberatan') {
            document.getElementById('lbl-modal-info').innerText = 'Alasan Keberatan';
            document.getElementById('modal-info').innerText = data.alasan_keberatan || '-';
            
            document.getElementById('lbl-modal-tujuan').innerText = 'Tujuan Keberatan';
            document.getElementById('modal-tujuan').innerText = data.tujuan_keberatan || '-';
            
            document.getElementById('row-modal-cara').classList.add('hidden');
        } else {
            document.getElementById('lbl-modal-info').innerText = 'Rincian Informasi';
            document.getElementById('modal-info').innerText = data.info_diminta || '-';
            
            document.getElementById('lbl-modal-tujuan').innerText = 'Tujuan';
            document.getElementById('modal-tujuan').innerText = data.tujuan_permohonan || '-';
            
            document.getElementById('row-modal-cara').classList.remove('hidden');
            document.getElementById('modal-cara').innerText = data.cara_memperoleh || '-';
        }
        
        document.getElementById('modal-status-cell').innerText = data.status;
        document.getElementById('modal-tanggal').innerText = new Date(data.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('modal-catatan').innerText = data.catatan_admin || '-';

        // Setup Identitas Link
        const identitasContainer = document.getElementById('modal-identitas-doc');
        if(data.lampiran_identitas && data.lampiran_identitas !== '-') {
            identitasContainer.innerHTML = `<a href="/storage/${data.lampiran_identitas}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1 rounded-lg text-xs font-semibold transition-colors"><i class="fa-solid fa-file-pdf"></i> Lihat Identitas (KTP)</a>`;
        } else {
            identitasContainer.innerText = '-';
        }
        
        // Setup Akta Link
        const aktaRow = document.getElementById('row-modal-akta');
        const aktaContainer = document.getElementById('modal-akta-doc');
        const showAkta = ['LSM/NGO', 'Instansi Pemerintah', 'Lembaga Pemerintah'].includes(data.kategori_pemohon);
        if (showAkta) {
            aktaRow.classList.remove('hidden');
            if (data.akta_pendirian && data.akta_pendirian !== '-') {
                aktaContainer.innerHTML = `<a href="/storage/${data.akta_pendirian}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1 rounded-lg text-xs font-semibold transition-colors"><i class="fa-solid fa-file-pdf"></i> Lihat Akta Pendirian</a>`;
            } else {
                aktaContainer.innerText = '-';
            }
        } else {
            aktaRow.classList.add('hidden');
        }

        // Setup Pendukung Link
        const pendukungContainer = document.getElementById('modal-pendukung-doc');
        if(data.lampiran_pendukung && data.lampiran_pendukung !== '-') {
            pendukungContainer.innerHTML = `<a href="/storage/${data.lampiran_pendukung}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-3 py-1 rounded-lg text-xs font-semibold transition-colors"><i class="fa-solid fa-file-pdf"></i> Lihat Lampiran Pendukung</a>`;
        } else {
            pendukungContainer.innerText = '-';
        }

        toggleModal('modal-summary', true);
    }

    function openEditModal(item) {
        // Reset form first
        resetForm();
        
        const form = document.querySelector('#modal-form form');
        if (!form) return;
        
        // Update Title and Action
        const titleEl = document.querySelector('#modal-form h2');
        if (titleEl) titleEl.innerText = 'Edit Pengajuan: ' + item.no_tiket;
        
        form.action = `/layanan/${item.id}`;
        
        // Add PUT method override
        let methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            form.appendChild(methodInput);
        }
        methodInput.value = 'PUT';
        
        // Update submit button text
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.innerText = 'Simpan Perubahan';
        
        // Populate fields
        const jenisLayanan = document.getElementById('jenis_layanan');
        if (jenisLayanan) {
            jenisLayanan.value = item.jenis_layanan;
            jenisLayanan.disabled = true; // Disable editing service type
        }
        
        // Trigger field visibility based on jenis_layanan
        toggleFormFields();
        
        // Populate permohonan_terkait_id if Keberatan
        if (item.jenis_layanan === 'Keberatan') {
            const permohonanTerkait = document.getElementById('permohonan_terkait_id');
            if (permohonanTerkait) {
                permohonanTerkait.value = item.permohonan_terkait_id;
                permohonanTerkait.disabled = true; // Disable editing related ticket
            }
            // Populate Keberatan specific fields
            const tujuanKeberatan = document.getElementById('tujuan_keberatan');
            if (tujuanKeberatan) tujuanKeberatan.value = item.tujuan_keberatan;
            
            const alasanKeberatan = document.getElementById('alasan_keberatan');
            if (alasanKeberatan) alasanKeberatan.value = item.alasan_keberatan;
        } else {
            // Populate Permohonan specific fields
            const infoDiminta = document.getElementById('info_diminta');
            if (infoDiminta) infoDiminta.value = item.info_diminta;
            
            const tujuan = document.getElementById('tujuan');
            if (tujuan) tujuan.value = item.tujuan_permohonan;
            
            const caraAmbil = document.getElementById('cara_ambil');
            if (caraAmbil) caraAmbil.value = item.cara_memperoleh;
        }
        
        // Populate lockable personal info
        const noIdentitas = document.getElementById('no_identitas');
        if (noIdentitas) noIdentitas.value = item.no_identitas;
        
        const telepon = document.getElementById('telepon');
        if (telepon) telepon.value = item.no_hp;
        
        const alamat = document.getElementById('alamat');
        if (alamat) alamat.value = item.alamat;
        
        const pekerjaan = document.getElementById('pekerjaan');
        if (pekerjaan) pekerjaan.value = item.pekerjaan;
        
        const kategoriPemohon = document.getElementById('kategori_pemohon');
        if (kategoriPemohon) {
            kategoriPemohon.value = item.kategori_pemohon;
            // Trigger checkKategori to show/hide akta pendirian section
            checkKategori();
        }
        
        // Auto fill locked/unlocked state
        if (item.jenis_layanan === 'Keberatan') {
            setFieldsLockState(true);
        } else {
            setFieldsLockState(false);
        }
        
        // Make sure body wrapper is shown
        const wrapper = document.getElementById('form-body-wrapper');
        if (wrapper) wrapper.classList.remove('hidden');
        
        // Show modal
        toggleModal('modal-form', true);
    }

    let pengajuanIdToDelete = null;

    function deletePengajuan(id, ticketNo) {
        pengajuanIdToDelete = id;
        document.getElementById('delete-ticket-display').innerText = ticketNo;
        
        // Show modal delete
        toggleModal('modal-delete', true);
        
        // Set action for confirm button
        const confirmBtn = document.getElementById('confirm-delete-btn');
        if (confirmBtn) {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Ya, Hapus';
            confirmBtn.onclick = function() {
                // Disable button and show spinner
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Menghapus...';
                
                fetch(`/layanan/${pengajuanIdToDelete}`, {
                    method: 'POST', // Use POST with _method = DELETE for Laravel CSRF compatibility
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(async response => {
                    const data = await response.json();
                    if (response.ok) {
                        toggleModal('modal-delete', false);
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus pengajuan.');
                        confirmBtn.disabled = false;
                        confirmBtn.innerHTML = 'Ya, Hapus';
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Terjadi kesalahan jaringan.');
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = 'Ya, Hapus';
                });
            };
        }
    }
</script>
@endsection
