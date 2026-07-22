@extends('layout.admin')

@section('title', 'Detail ' . $permohonan->jenis_layanan . ' #' . $permohonan->no_tiket . ' - PPID FMIPA Unila')

@section('content')

    @php
        $isKeberatan = $permohonan->jenis_layanan == 'Keberatan';
    @endphp

    <!-- Page Title & Top Action Header (SIAKAD Style) -->
    <div class="mb-5 flex flex-col md:flex-row md:items-center md:justify-between gap-3 border-b border-slate-200 pb-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">
                {{ $isKeberatan ? 'Detail Pengajuan Keberatan' : 'Detail Permohonan Informasi' }}
            </h1>
            @if(Str::startsWith($permohonan->no_tiket, 'KEB'))
                <div class="text-lg font-bold font-mono mt-0.5" style="color: #d97706 !important;">
                    #{{ $permohonan->no_tiket }}
                </div>
            @else
                <div class="text-lg font-bold font-mono mt-0.5" style="color: #2563eb !important;">
                    #{{ $permohonan->no_tiket }}
                </div>
            @endif
        </div>
        <div>
            <a href="{{ url('/admin/pengajuan') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#1B365D] hover:bg-[#1B365D]/90 text-white rounded font-bold text-sm shadow-sm transition">
                <i class="fa-solid fa-chevron-left text-xs"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Main Outer Container Card with Navy Accent Bar (SIAKAD Style) -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-sm overflow-hidden mb-8">
        <!-- Top Accent Bar -->
        <div class="border-t-4 border-[#1B365D] px-6 py-3.5 bg-slate-50/50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
            <span class="text-sm font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-file-circle-check text-[#1B365D] text-base"></i> Detail Layanan PPID
            </span>
            <div class="flex items-center gap-3 text-xs md:text-sm">
                <span class="text-slate-500 font-medium"><i class="fa-regular fa-clock mr-1"></i> Diajukan: {{ $permohonan->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                <span class="inline-block px-3 py-1 rounded text-xs font-bold uppercase tracking-wider border
                    {{ match($permohonan->status) {
                        'DIAJUKAN' => 'bg-slate-100 text-slate-700 border-slate-300',
                        'DIPROSES' => 'bg-blue-100 text-blue-800 border-blue-300',
                        'PERBAIKAN' => 'bg-amber-100 text-amber-900 border-amber-300',
                        'DITERIMA' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                        'DITOLAK'  => 'bg-rose-100 text-rose-800 border-rose-300',
                        default    => 'bg-slate-100 text-slate-700 border-slate-300'
                    } }}">
                    {{ $permohonan->status }}
                </span>
            </div>
        </div>

        <div class="p-6 space-y-6">

            <!-- 1. INFORMASI PEMOHON (Blue/Slate Tinted Summary Box - SIAKAD Style) -->
            <div class="bg-[#F4F8FC] border border-[#D0E2F4] rounded-lg p-5 text-sm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3.5 gap-x-8">
                    <!-- Column 1 -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-12 items-baseline">
                            <span class="col-span-5 font-semibold text-slate-600">Nama Pemohon : </span>
                            <span class="col-span-7 font-bold text-slate-900 text-base">{{ $permohonan->nama }}</span>
                        </div>
                        <div class="grid grid-cols-12 items-baseline">
                            <span class="col-span-5 font-semibold text-slate-600">Nomor Identitas : </span>
                            <span class="col-span-7 font-bold text-slate-900 text-base">{{ $permohonan->no_identitas }}</span>
                        </div>
                        <div class="grid grid-cols-12 items-center">
                            <span class="col-span-5 font-semibold text-slate-600">Lampiran Identitas : </span>
                            <div class="col-span-7 flex items-center gap-2">
                                <button type="button" onclick="openModal('modal-preview-identitas')" class="px-2.5 py-1 bg-[#1B365D] hover:bg-[#1B365D]/90 text-white rounded text-xs font-bold transition inline-flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-id-card text-xs"></i> Lihat Identitas
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 items-baseline">
                            <span class="col-span-5 font-semibold text-slate-600">Pekerjaan : </span>
                            <span class="col-span-7 font-semibold text-slate-80 0">{{ $permohonan->pekerjaan }}</span>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="space-y-3">
                        <div class="grid grid-cols-12 items-baseline">
                            <span class="col-span-5 font-semibold text-slate-600">Email : </span>
                            <span class="col-span-7 font-semibold text-slate-800 break-all">{{ $permohonan->email }}</span>
                        </div>
                        <div class="grid grid-cols-12 items-center">
                            <span class="col-span-5 font-semibold text-slate-600">Nomor Telepon : </span>
                            <div class="col-span-7 flex items-center gap-2">
                                <span class="font-semibold text-slate-800">{{ $permohonan->no_hp }}</span>
                                @php
                                    $cleanHp = preg_replace('/[^0-9]/', '', $permohonan->no_hp);    
                                    if (str_starts_with($cleanHp, '0')) {
                                        $cleanHp = '62' . substr($cleanHp, 1);
                                    }
                                @endphp
                            </div>
                        </div>
                        <div class="grid grid-cols-12 items-baseline">
                            <span class="col-span-5 font-semibold text-slate-600">Alamat Pemohon : </span>
                            <span class="col-span-7 font-semibold text-slate-800">{{ $permohonan->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. RINCIAN PENGAJUAN (Navy Header Table - SIAKAD Style) -->
            <div class="space-y-2.5">
                <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-[#1B365D]"></i> 
                    {{ $isKeberatan ? 'Rincian Pengajuan Keberatan' : 'Rincian Permohonan Informasi' }}
                </h2>

                <div class="overflow-x-auto border border-slate-200 rounded-lg">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="bg-[#1B365D] text-white font-bold uppercase tracking-wider text-xs md:text-sm">
                                <th class="py-3 px-4 w-1/4 border-r border-white/20">Pengajuan</th>
                                <th class="py-3 px-4 w-3/4">Isi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <tr>
                                <td class="py-3.5 px-4 font-semibold text-slate-700 bg-slate-50/70 border-r border-slate-200">Kategori Pemohon</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $permohonan->kategori_pemohon }}</td>
                            </tr>
                            @if(!$isKeberatan)
                                <tr>
                                    <td class="py-3.5 px-4 font-semibold text-slate-700 bg-slate-50/70 border-r border-slate-200">Rincian Informasi Diminta</td>
                                    <td class="py-3.5 px-4 font-medium text-slate-900 whitespace-pre-wrap leading-relaxed">{{ $permohonan->info_diminta }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 px-4 font-semibold text-slate-700 bg-slate-50/70 border-r border-slate-200">Tujuan Penggunaan Informasi</td>
                                    <td class="py-3.5 px-4 font-medium text-slate-900 whitespace-pre-wrap leading-relaxed">{{ $permohonan->tujuan_permohonan }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3.5 px-4 font-semibold text-slate-700 bg-slate-50/70 border-r border-slate-200">Cara Memperoleh Informasi</td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-900">{{ $permohonan->cara_memperoleh }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="py-3.5 px-4 font-semibold text-slate-700 bg-slate-50/70 border-r border-slate-200">Alasan Pengajuan Keberatan</td>
                                    <td class="py-3.5 px-4 font-medium text-slate-900 whitespace-pre-wrap leading-relaxed">{{ $permohonan->tujuan_keberatan }}</td>
                                </tr>
                                @if($permohonan->permohonan_terkait_id && $permohonan->permohonanTerkait)
                                    <tr>
                                        <td class="py-3.5 px-4 font-semibold text-slate-700 bg-slate-50/70 border-r border-slate-200">Tiket Permohonan Asal</td>
                                        <td class="py-3.5 px-4 font-medium text-slate-900">
                                            <span class="font-mono font-bold text-[#1B365D]">#{{ $permohonan->permohonanTerkait->no_tiket }}</span>
                                            <span class="text-slate-500 mx-2">-</span>
                                            <a href="{{ url('/admin/pengajuan/' . $permohonan->permohonan_terkait_id) }}" class="text-[#1B365D] font-bold underline hover:text-blue-800">
                                                Buka Permohonan Asal <i class="fa-solid fa-arrow-up-right-from-square text-xs ml-0.5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endif

                            <!-- Row Akta Pendirian Badan Hukum -->
                            <tr>
                                <td class="py-3.5 px-4 font-semibold text-slate-700 bg-slate-50/70 border-r border-slate-200">Akta Pendirian Badan Hukum</td>
                                <td class="py-3.5 px-4 font-medium text-slate-900">
                                    @if($permohonan->akta_pendirian)
                                        <a href="{{ asset('storage/'.$permohonan->akta_pendirian) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-800 rounded text-xs font-bold transition inline-flex items-center gap-1.5 shadow-xs">
                                            <i class="fa-solid fa-file-pdf text-red-600 text-sm"></i> Lihat Akta Pendirian Badan Hukum
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic"> - (khusus kategori pemohon Lembaga / Organisasi)</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Row Dokumen Pendukung -->
                            <tr>
                                <td class="py-3.5 px-4 font-semibold text-slate-700 bg-slate-50/70 border-r border-slate-200">Dokumen Pendukung</td>
                                <td class="py-3.5 px-4 font-medium text-slate-900">
                                    @if($permohonan->lampiran_pendukung)
                                        <a href="{{ asset('storage/'.$permohonan->lampiran_pendukung) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-800 rounded text-xs font-bold transition inline-flex items-center gap-1.5 shadow-xs">
                                            <i class="fa-solid fa-file-lines text-blue-600 text-sm"></i> Lihat Dokumen Pendukung
                                        </a>
                                    @else
                                        <span class="text-slate-400 italic">Tidak ada dokumen pendukung</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 3. FORM TINDAK LANJUT ADMINISTRATOR (Navy Header Table / Box - SIAKAD Style) -->
            <div class="space-y-2.5 pt-3">
                <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-user-gear text-[#1B365D]"></i> Tindak Lanjut 
                </h2>

                <div class="border border-slate-200 rounded-lg overflow-hidden bg-white">
                    <div class="bg-[#1B365D] text-white px-4 py-3 text-xs md:text-sm font-bold uppercase tracking-wider">
                        Tanggapan & Perubahan Status
                    </div>

                    <form action="{{ url('/admin/pengajuan/' . $permohonan->id . '/status') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerText = 'Menyimpan...';">
                        @csrf
                        @method('PUT')

                        <!-- 1. Status Dropdown (Top Level) -->
                        <div>
                            <label for="status" class="text-sm font-bold text-slate-800 block mb-1.5">
                                Status Pengajuan <span class="text-red-500">*</span>
                            </label>
                            
                            @if(in_array($permohonan->status, ['DITERIMA', 'DITOLAK']))
                                <div class="relative">
                                    <select id="status_display" class="w-full border border-slate-300 bg-slate-100 text-slate-500 rounded px-3.5 py-2.5 text-sm font-bold cursor-not-allowed appearance-none" disabled>
                                        <option selected>{{ $permohonan->status }} (Status Final Selesai)</option>
                                    </select>
                                    <div class="absolute right-3.5 top-3 text-slate-400 pointer-events-none">
                                        <i class="fa-solid fa-lock text-sm"></i>
                                    </div>
                                </div>
                                <input type="hidden" name="status" id="status" value="{{ $permohonan->status }}">
                                <p class="text-xs text-slate-400 mt-1 italic">Status final tidak dapat diubah kembali.</p>
                            @else
                                <div class="relative">
                                    <select name="status" id="status" class="w-full border border-slate-300 bg-white rounded px-3.5 py-2.5 text-sm font-bold text-slate-800 outline-none focus:border-[#1B365D] focus:ring-1 focus:ring-[#1B365D] appearance-none cursor-pointer" onchange="handleStatusChange(this.value)">
                                        <option value="DIPROSES" {{ $permohonan->status == 'DIPROSES' ? 'selected' : '' }}>DIPROSES</option>
                                        <option value="PERBAIKAN" {{ $permohonan->status == 'PERBAIKAN' ? 'selected' : '' }}>PERBAIKAN</option>
                                        <option value="DITERIMA" {{ $permohonan->status == 'DITERIMA' ? 'selected' : '' }}>TERIMA</option>
                                        <option value="DITOLAK" {{ $permohonan->status == 'DITOLAK' ? 'selected' : '' }}>TOLAK</option>
                                    </select>
                                    <div class="absolute right-3.5 top-3 text-slate-400 pointer-events-none">
                                        <i class="fa-solid fa-chevron-down text-sm"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- 2. Catatan Admin Section (Hidden when DIPROSES, Visible for PERBAIKAN, DITERIMA, DITOLAK) -->
                        <div id="container_catatan_admin" class="space-y-1.5 hidden">
                            <label for="catatan_admin" class="text-sm font-bold text-slate-800 block">
                                Catatan <span id="catatan-asterisk" class="text-red-500 hidden">*</span> <span id="catatan-opsional" class="text-slate-600 font-normal text-md hidden">(Opsional)</span>
                            </label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="4" class="w-full border {{ $errors->has('catatan_admin') ? 'border-red-500' : 'border-slate-300' }} rounded p-3.5 text-sm outline-none focus:border-[#1B365D] focus:ring-1 focus:ring-[#1B365D] font-medium leading-relaxed" placeholder="Tuliskan jawaban resmi, penjelasan, atau alasan penolakan/perbaikan di sini...">{{ old('catatan_admin', $permohonan->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <p class="text-xs text-red-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 3. Berikan Informasi Yang Diminta (Hidden except when status is DITERIMA) -->
                        <div id="container_informasi_jawaban" class="space-y-4 pt-3 border-t border-slate-200 hidden">
                            <label class="block text-sm font-bold text-slate-800">
                                Berikan Informasi Yang Diminta <span class="text-red-500">*</span>
                            </label>

                            <!-- Format Choice (Radio Options like Form Informasi Publik) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="border border-slate-200 rounded-lg p-3.5 flex items-center cursor-pointer hover:bg-slate-50 transition">
                                    <input type="radio" name="opsi_format" id="opsi_format_file" value="file" class="mr-3 w-4 h-4 text-[#1B365D]" onclick="toggleFormatJawaban('file')" {{ old('opsi_format', $permohonan->file_jawaban ? 'file' : ($permohonan->link_jawaban ? 'link' : 'file')) == 'file' ? 'checked' : '' }}>
                                    <div>
                                        <span class="block font-bold text-sm text-slate-800">Unggah Berkas Dokumen</span>
                                        <span class="block text-xs text-slate-500">File PDF, JPG, PNG, ZIP, DOCX (Maks 5MB)</span>
                                    </div>
                                </label>
                                <label class="border border-slate-200 rounded-lg p-3.5 flex items-center cursor-pointer hover:bg-slate-50 transition">
                                    <input type="radio" name="opsi_format" id="opsi_format_link" value="link" class="mr-3 w-4 h-4 text-[#1B365D]" onclick="toggleFormatJawaban('link')" {{ old('opsi_format', $permohonan->link_jawaban ? 'link' : '') == 'link' ? 'checked' : '' }}>
                                    <div>
                                        <span class="block font-bold text-sm text-slate-800">Tautan / Link Online (URL)</span>
                                        <span class="block text-xs text-slate-500">Link Google Drive, Website, dll.</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Zona File -->
                            <div id="zona_file_jawaban" class="bg-slate-50 p-4 rounded-lg border border-slate-200 space-y-2">
                                <label class="block text-xs font-bold text-slate-700">Pilih Berkas File Jawaban</label>
                                @if($permohonan->file_jawaban)
                                    <div class="mb-2 p-2 bg-white border border-slate-200 rounded flex items-center justify-between text-xs">
                                        <span class="font-semibold text-slate-700 truncate">
                                            <i class="fa-solid fa-file-circle-check text-emerald-600 mr-1 text-sm"></i> Berkas Terlampir Saat Ini
                                        </span>
                                        <a href="{{ asset('storage/' . $permohonan->file_jawaban) }}" target="_blank" class="px-2.5 py-1 bg-[#1B365D] text-white rounded text-xs font-bold hover:bg-[#1B365D]/90">
                                            Unduh Berkas
                                        </a>
                                    </div>
                                @endif
                                <input type="file" name="file_jawaban" id="file_jawaban" class="w-full border border-slate-300 rounded p-2 text-xs text-slate-700 bg-white focus:border-[#1B365D] file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:bg-[#1B365D] file:text-white file:font-semibold cursor-pointer" onchange="validateFileSize(this)">
                                <span class="block text-xs text-slate-500 mt-1">(Format: PDF, JPG, PNG, ZIP, DOCX | Maksimal: 5 MB)</span>
                                <p id="file_jawaban_error" class="text-red-600 text-xs font-bold mt-1.5 hidden flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-xs"></i> <span></span></p>
                                @error('file_jawaban')
                                    <p class="text-red-600 text-xs font-bold mt-1.5 flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Zona Link -->
                            <div id="zona_link_jawaban" class="bg-slate-50 p-4 rounded-lg border border-slate-200 space-y-2 hidden">
                                <label class="block text-xs font-bold text-slate-700">Masukkan Alamat URL Lengkap</label>
                                <input type="url" name="link_jawaban" id="link_jawaban" value="{{ old('link_jawaban', $permohonan->link_jawaban) }}" placeholder="https://..." class="w-full border {{ $errors->has('link_jawaban') ? 'border-red-500' : 'border-slate-300' }} rounded px-3.5 py-2.5 text-sm font-medium bg-white outline-none focus:border-[#1B365D] focus:ring-1 focus:ring-[#1B365D]">
                                @error('link_jawaban')
                                    <p class="text-xs text-red-500 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-[#1B365D] hover:bg-[#1B365D]/90 text-white rounded font-bold text-sm shadow transition inline-flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan Tanggapan Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Preview Gambar Identitas -->
    @if($permohonan->lampiran_identitas)
        <div id="modal-preview-identitas" class="hidden fixed inset-0 z-[3000] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="relative max-w-2xl w-full bg-white rounded-lg overflow-hidden shadow-xl p-4 flex flex-col items-center">
                <button onclick="closeModal('modal-preview-identitas')" class="absolute top-3 right-3 w-7 h-7 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 font-bold text-xs transition z-50">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="w-full max-h-[75vh] overflow-auto flex justify-center items-center p-2 mt-4">
                    <img src="{{ asset('storage/' . $permohonan->lampiran_identitas) }}" class="max-w-full max-h-[70vh] object-contain rounded border border-slate-200">
                </div>
                <div class="py-2.5 text-center text-xs font-bold text-slate-700 border-t border-slate-100 w-full mt-2">
                    Foto Identitas: {{ $permohonan->nama }} ({{ $permohonan->no_identitas }})
                </div>
            </div>
        </div>
    @endif

    <script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function handleStatusChange(statusValue) {
        const containerCatatan = document.getElementById('container_catatan_admin');
        const notesTextarea = document.getElementById('catatan_admin');
        const notesLabelAsterisk = document.getElementById('catatan-asterisk');
        const notesLabelOpsional = document.getElementById('catatan-opsional');
        const containerJawaban = document.getElementById('container_informasi_jawaban');

        if (statusValue === 'DIPROSES') {
            if (containerCatatan) containerCatatan.classList.add('hidden');
            if (containerJawaban) containerJawaban.classList.add('hidden');
            if (notesTextarea) notesTextarea.removeAttribute('required');
        } else if (statusValue === 'PERBAIKAN') {
            if (containerCatatan) containerCatatan.classList.remove('hidden');
            if (containerJawaban) containerJawaban.classList.add('hidden');
            if (notesTextarea) {
                notesTextarea.setAttribute('required', 'required');
                notesTextarea.placeholder = "Tuliskan rincian bagian atau dokumen yang perlu diperbaiki oleh pemohon (misal: Nama di form tidak sesuai KTP, Nomor identitas keliru, atau file lampiran tidak terbaca)...";
            }
            if (notesLabelAsterisk) notesLabelAsterisk.classList.remove('hidden');
            if (notesLabelOpsional) notesLabelOpsional.classList.add('hidden');
        } else if (statusValue === 'DITOLAK') {
            if (containerCatatan) containerCatatan.classList.remove('hidden');
            if (containerJawaban) containerJawaban.classList.add('hidden');
            if (notesTextarea) {
                notesTextarea.setAttribute('required', 'required');
                notesTextarea.placeholder = "Tuliskan jawaban resmi, penjelasan, atau alasan penolakan permohonan informasi di sini...";
            }
            if (notesLabelAsterisk) notesLabelAsterisk.classList.remove('hidden');
            if (notesLabelOpsional) notesLabelOpsional.classList.add('hidden');
        } else if (statusValue === 'DITERIMA') {
            if (containerCatatan) containerCatatan.classList.remove('hidden');
            if (containerJawaban) containerJawaban.classList.remove('hidden');
            if (notesTextarea) {
                notesTextarea.removeAttribute('required');
                notesTextarea.placeholder = "Tuliskan pesan / tanggapan resmi penerimaan permohonan (opsional)...";
            }
            if (notesLabelAsterisk) notesLabelAsterisk.classList.add('hidden');
            if (notesLabelOpsional) notesLabelOpsional.classList.remove('hidden');

            // Toggle format file vs link
            const isLinkChecked = document.getElementById('opsi_format_link')?.checked;
            toggleFormatJawaban(isLinkChecked ? 'link' : 'file');
        }
    }

    function toggleFormatJawaban(jenis) {
        const zonaFile = document.getElementById('zona_file_jawaban');
        const zonaLink = document.getElementById('zona_link_jawaban');
        const inputFile = document.getElementById('file_jawaban');
        const inputLink = document.getElementById('link_jawaban');

        if (jenis === 'file') {
            if (zonaFile) zonaFile.classList.remove('hidden');
            if (zonaLink) zonaLink.classList.add('hidden');
            if (inputFile) inputFile.disabled = false;
            if (inputLink) inputLink.disabled = true;
        } else {
            if (zonaFile) zonaFile.classList.add('hidden');
            if (zonaLink) zonaLink.classList.remove('hidden');
            if (inputFile) inputFile.disabled = true;
            if (inputLink) inputLink.disabled = false;
        }
    }

    function validateFileSize(input) {
        const errorEl = document.getElementById(input.id + '_error');
        if (input.files && input.files.length > 0) {
            const file = input.files[0];
            const maxMB = 5;
            const maxSize = maxMB * 1024 * 1024;
            if (file.size > maxSize) {
                const actualMB = (file.size / (1024 * 1024)).toFixed(2);
                if (errorEl) {
                    errorEl.querySelector('span').textContent = `Ukuran file terlalu besar! Maksimal ${maxMB} MB (Ukuran file Anda: ${actualMB} MB).`;
                    errorEl.classList.remove('hidden');
                }
                input.value = '';
                return false;
            }
        }
        if (errorEl) errorEl.classList.add('hidden');
        return true;
    }

    window.addEventListener('DOMContentLoaded', () => {
        const statusSelect = document.getElementById('status');
        if (statusSelect) {
            handleStatusChange(statusSelect.value);
        }
    });
    </script>
@endsection

