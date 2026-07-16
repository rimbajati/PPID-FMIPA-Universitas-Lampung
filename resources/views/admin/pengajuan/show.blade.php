@extends('layout.admin')

@section('title', 'Detail Pengajuan - PPID FMIPA Unila')

@section('content')
    <!-- Header Section -->
    <div class="mb-8 flex flex-wrap gap-4 justify-between items-center bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider
                    {{ $permohonan->jenis_layanan == 'Keberatan' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                    {{ $permohonan->jenis_layanan }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider
                    {{ $permohonan->status == 'DIAJUKAN' ? 'bg-slate-100 text-slate-700 border border-slate-200' : '' }}
                    {{ $permohonan->status == 'DIPROSES' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                    {{ $permohonan->status == 'DITERIMA' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '' }}
                    {{ $permohonan->status == 'DITOLAK' ? 'bg-rose-100 text-rose-700 border border-rose-200' : '' }}">
                    {{ $permohonan->status }}
                </span>
            </div>
            <h1 class="text-2xl font-black text-slate-850 mt-2">Detail Pengajuan #{{ $permohonan->no_tiket }}</h1>
            <p class="text-xs text-slate-400 mt-1 flex items-center gap-2">
                <i class="fa-regular fa-calendar-days"></i> Diajukan pada {{ $permohonan->created_at->translatedFormat('d F Y H:i') }} WIB
            </p>
        </div>
        <a href="{{ url('/admin/pengajuan') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-bold text-sm transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>



    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri & Tengah: Informasi Detail Pengajuan -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Card Data Pengajuan -->
            <div class="bg-white rounded-3xl border border-slate-150 shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-150 flex justify-between items-center">
                    <h2 class="text-base font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-folder-open text-[#0095e8]"></i> Isi Form Pengajuan
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    
                    @if($permohonan->jenis_layanan == 'Permohonan')
                        <!-- Rincian Permohonan Informasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">Klasifikasi Jenis Informasi</label>
                                <div class="p-4 bg-slate-50 rounded-2xl text-sm font-bold text-slate-800 border border-slate-100">{{ $permohonan->kategori }}</div>
                            </div>
                            <div class="col-span-2">
                                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">Rincian Informasi Yang Diminta</label>
                                <div class="p-5 bg-slate-50 rounded-2xl text-sm text-slate-700 leading-relaxed border border-slate-100 break-words whitespace-pre-wrap font-medium">{{ $permohonan->info_diminta }}</div>
                            </div>
                            <div class="col-span-2">
                                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">Tujuan Penggunaan Informasi</label>
                                <div class="p-5 bg-slate-50 rounded-2xl text-sm text-slate-700 leading-relaxed border border-slate-100 break-words whitespace-pre-wrap font-medium">{{ $permohonan->tujuan_permohonan }}</div>
                            </div>
                            <div>
                                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">Cara Memperoleh Informasi</label>
                                <div class="p-4 bg-slate-50 rounded-2xl text-sm font-semibold text-slate-800 border border-slate-100">{{ $permohonan->cara_memperoleh }}</div>
                            </div>
                            <div>
                                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">Cara Mendapatkan Salinan Informasi</label>
                                <div class="p-4 bg-slate-50 rounded-2xl text-sm font-semibold text-slate-800 border border-slate-100">{{ $permohonan->cara_mendapatkan }}</div>
                            </div>
                        </div>
                    @else
                        <!-- Rincian Keberatan -->
                        <div class="space-y-6">
                            <div>
                                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1.5">Alasan Pengajuan Keberatan</label>
                                <div class="p-5 bg-slate-50 rounded-2xl text-sm text-slate-700 leading-relaxed border border-slate-100 break-words whitespace-pre-wrap font-medium">{{ $permohonan->tujuan_keberatan }}</div>
                            </div>
                            @if($permohonan->permohonan_terkait_id)
                                <div class="p-5 border border-blue-100 bg-blue-50/40 rounded-2xl flex items-center justify-between">
                                    <div>
                                        <label class="text-[10px] font-bold text-blue-500 uppercase tracking-wider block mb-1">Terkait dengan Permohonan</label>
                                        <p class="font-black text-blue-800 text-sm">Nomor Tiket: {{ $permohonan->permohonanTerkait->no_tiket ?? 'N/A' }}</p>
                                    </div>
                                    <a href="{{ url('/admin/pengajuan/' . $permohonan->permohonan_terkait_id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">
                                        Lihat Permohonan Asal
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card Proses & Tanggapan Admin -->
            <div class="bg-white rounded-3xl border border-slate-150 shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-150">
                    <h2 class="text-base font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-[#0095e8]"></i> Proses Pengajuan
                    </h2>
                </div>
                <div class="p-8">
                    <form action="{{ url('/admin/pengajuan/' . $permohonan->id . '/status') }}" method="POST" enctype="multipart/form-data" class="space-y-6" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerText = 'Menyimpan...';">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="status" class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Alur Status Pengajuan <span class="text-red-500">*</span></label>
                            
                            @if(in_array($permohonan->status, ['DITERIMA', 'DITOLAK']))
                                <div class="relative">
                                    <select id="status_display" class="w-full border border-slate-200 bg-slate-50 text-slate-500 rounded-2xl p-4 text-sm font-bold outline-none cursor-not-allowed appearance-none" disabled>
                                        <option selected>{{ $permohonan->status }} (Status Final)</option>
                                    </select>
                                    <div class="absolute right-4 top-4.5 text-slate-400 pointer-events-none">
                                        <i class="fa-solid fa-lock"></i>
                                    </div>
                                </div>
                                <input type="hidden" name="status" value="{{ $permohonan->status }}">
                                <p class="text-[11px] text-slate-450 mt-1.5 italic">Status pengajuan yang telah diterima atau ditolak bersifat final dan tidak dapat diubah kembali.</p>
                            @else
                                <div class="relative">
                                    <select name="status" id="status" class="w-full border border-slate-200 bg-white rounded-2xl p-4 pr-10 text-sm font-bold text-slate-800 outline-none focus:border-[#0095e8] focus:ring-1 focus:ring-[#0095e8] transition appearance-none" onchange="toggleCatatanAsterisk(this.value)">
                                        @if($permohonan->status == 'DIAJUKAN')
                                            <option value="DIAJUKAN" selected>DIAJUKAN</option>
                                            <option value="DIPROSES">DIPROSES</option>
                                            <option value="DITERIMA">DITERIMA (Selesai & Disetujui)</option>
                                            <option value="DITOLAK">DITOLAK (Ditolak)</option>
                                        @elseif($permohonan->status == 'DIPROSES')
                                            <option value="DIPROSES" selected>DIPROSES</option>
                                            <option value="DITERIMA">DITERIMA (Selesai & Disetujui)</option>
                                            <option value="DITOLAK">DITOLAK (Ditolak)</option>
                                        @endif
                                    </select>
                                    <div class="absolute right-4 top-5 text-slate-450 pointer-events-none">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="catatan_admin" class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">
                                Catatan Admin / Tanggapan Resmi <span id="catatan-asterisk" class="text-red-500 hidden">*</span>
                            </label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="5" class="w-full border {{ $errors->has('catatan_admin') ? 'border-red-500' : 'border-slate-200' }} rounded-2xl p-4 outline-none focus:border-[#0095e8] focus:ring-1 focus:ring-[#0095e8] transition text-sm font-medium leading-relaxed" placeholder="Tuliskan tanggapan atau alasan penolakan/penerimaan resmi di sini...">{{ old('catatan_admin', $permohonan->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <p class="text-xs text-red-500 mt-1.5 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="file_jawaban" class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Unggah File Jawaban / Dokumen Pendukung Admin</label>
                            @if($permohonan->file_jawaban)
                                <div class="mb-3.5 p-3.5 bg-slate-50 border border-slate-150 rounded-xl flex items-center justify-between text-xs">
                                    <span class="font-semibold text-slate-600 flex items-center gap-2">
                                        <i class="fa-solid fa-file-shield text-slate-400 text-sm"></i> Berkas Jawaban Saat Ini
                                    </span>
                                    <a href="{{ asset('storage/' . $permohonan->file_jawaban) }}" target="_blank" class="px-3.5 py-1.5 bg-[#0095e8] hover:bg-blue-600 text-white rounded-lg font-bold transition flex items-center gap-1.5">
                                        <i class="fa-solid fa-download text-[10px]"></i> Lihat File
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="file_jawaban" id="file_jawaban" class="w-full border border-slate-200 rounded-2xl p-3 text-sm focus:border-[#0095e8] file:mr-3 file:py-1.5 file:px-4 file:rounded-xl file:border-0 file:bg-slate-100 file:hover:bg-slate-200 file:text-slate-700 file:font-bold cursor-pointer transition">
                            <span class="block text-[10px] text-slate-400 mt-1.5">Format berkas: PDF, JPG, PNG, ZIP, DOCX (Maksimal 5MB)</span>
                        </div>

                        <button type="submit" class="w-full bg-[#0095e8] text-white py-4 rounded-2xl font-black text-sm hover:bg-blue-600 transition shadow-md flex items-center justify-center gap-2">
                            <i class="fa-solid fa-floppy-disk text-base"></i> Simpan Perubahan Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Data Pemohon & Lampiran -->
        <div class="space-y-8">
            
            <!-- Card Data Pemohon -->
            <div class="bg-white rounded-3xl border border-slate-150 shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-150">
                    <h2 class="text-base font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-[#0095e8]"></i> Profil Pemohon
                    </h2>
                </div>
                <div class="p-8 space-y-5">
                    <div>
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Nama Lengkap</label>
                        <p class="font-black text-slate-800 text-base">{{ $permohonan->nama }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Nomor Identitas</label>
                        <p class="font-bold text-slate-800 text-sm">{{ $permohonan->no_identitas }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Kategori Pemohon</label>
                        <span class="inline-block px-3 py-1 bg-slate-100 text-slate-700 border border-slate-200 rounded-full text-xs font-bold mt-1">
                            {{ $permohonan->kategori_pemohon }}
                        </span>
                    </div>
                    <div>
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Alamat Email</label>
                        <p class="font-semibold text-slate-700 text-sm flex items-center gap-1.5 mt-0.5">
                            <i class="fa-regular fa-envelope text-slate-400 text-sm"></i> {{ $permohonan->email }}
                        </p>
                    </div>
                    <div>
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Nomor WhatsApp / HP</label>
                        <p class="font-semibold text-slate-700 text-sm flex items-center gap-1.5 mt-0.5">
                            <i class="fa-brands fa-whatsapp text-emerald-500 text-base"></i> {{ $permohonan->no_hp }}
                        </p>
                    </div>
                    <div>
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Pekerjaan</label>
                        <p class="font-bold text-slate-800 text-sm">{{ $permohonan->pekerjaan }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Alamat Lengkap</label>
                        <p class="text-sm text-slate-650 leading-relaxed font-semibold">{{ $permohonan->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Card Lampiran Dokumen -->
            <div class="bg-white rounded-3xl border border-slate-150 shadow-sm overflow-hidden">
                <div class="bg-slate-50 px-8 py-5 border-b border-slate-150">
                    <h2 class="text-base font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-paperclip text-[#0095e8]"></i> Lampiran Dokumen
                    </h2>
                </div>
                <div class="p-8 space-y-6">
                    @php $hasAnyFile = false; @endphp

                    @if($permohonan->lampiran_identitas)
                        @php $hasAnyFile = true; @endphp
                        <div class="space-y-2">
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block">Identitas (KTP / SIM / KTM)</label>
                            
                            <!-- Thumbnail Preview Identitas (Foto KTP) -->
                            <div class="relative group overflow-hidden rounded-2xl border border-slate-200 cursor-pointer shadow-sm" onclick="openModal('modal-preview-identitas')">
                                <img src="{{ asset('storage/'.$permohonan->lampiran_identitas) }}" alt="Preview KTP" class="w-full h-36 object-cover group-hover:scale-105 transition duration-300">
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300">
                                    <span class="bg-white/95 text-slate-800 font-bold px-3 py-1.5 rounded-xl text-xs flex items-center gap-1 shadow-md">
                                        <i class="fa-solid fa-magnifying-glass-plus"></i> Perbesar
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($permohonan->akta_pendirian)
                        @php $hasAnyFile = true; @endphp
                        <div>
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Akta Pendirian Badan Hukum</label>
                            <a href="{{ asset('storage/'.$permohonan->akta_pendirian) }}" target="_blank"
                               class="flex items-center justify-between w-full p-4 bg-slate-50 border border-slate-200 text-slate-700 rounded-2xl font-bold text-xs hover:bg-slate-100 hover:border-slate-300 transition">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-file-pdf text-red-500 text-base"></i> Dokumen Akta Pendirian
                                </span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-slate-400"></i>
                            </a>
                        </div>
                    @endif

                    @if($permohonan->lampiran_pendukung)
                        @php $hasAnyFile = true; @endphp
                        <div>
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block mb-2">Lampiran Data Pendukung</label>
                            <a href="{{ asset('storage/'.$permohonan->lampiran_pendukung) }}" target="_blank"
                               class="flex items-center justify-between w-full p-4 bg-slate-50 border border-slate-200 text-slate-700 rounded-2xl font-bold text-xs hover:bg-slate-100 hover:border-slate-300 transition">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-file-pdf text-red-500 text-base"></i> Berkas Pendukung
                                </span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-slate-400"></i>
                            </a>
                        </div>
                    @endif

                    @if(!$hasAnyFile)
                        <div class="text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <i class="fa-solid fa-box-open text-slate-300 text-3xl mb-2 block"></i>
                            <p class="text-xs text-slate-400 font-bold">Tidak ada file lampiran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($permohonan->lampiran_identitas)
        <!-- Modal Preview Gambar Identitas (Pop-up) -->
        <div id="modal-preview-identitas" class="hidden fixed inset-0 z-[3000] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm animate-in fade-in duration-200">
            <div class="relative max-w-4xl w-full bg-white rounded-3xl overflow-hidden shadow-2xl p-4 flex flex-col items-center animate-in zoom-in-95 duration-200">
                <button onclick="closeModal('modal-preview-identitas')" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-100 hover:bg-red-100 hover:text-red-600 flex items-center justify-center text-slate-500 text-xl font-bold transition z-50">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="w-full max-h-[75vh] overflow-auto flex justify-center items-center p-2 mt-8">
                    <img src="{{ asset('storage/' . $permohonan->lampiran_identitas) }}" class="max-w-full max-h-[70vh] object-contain rounded-2xl shadow-sm">
                </div>
                <div class="py-4 text-center text-sm font-black text-slate-800 border-t border-slate-100 w-full mt-2">
                    Lampiran Identitas: {{ $permohonan->nama }} ({{ $permohonan->no_identitas }})
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

    function toggleCatatanAsterisk(statusValue) {
        const notesTextarea = document.getElementById('catatan_admin');
        const notesLabelAsterisk = document.getElementById('catatan-asterisk');
        if (statusValue === 'DITOLAK') {
            notesTextarea.setAttribute('required', 'required');
            if (notesLabelAsterisk) {
                notesLabelAsterisk.classList.remove('hidden');
            }
        } else {
            notesTextarea.removeAttribute('required');
            if (notesLabelAsterisk) {
                notesLabelAsterisk.classList.add('hidden');
            }
        }
    }

    // Set initial state on load
    window.addEventListener('DOMContentLoaded', () => {
        const statusSelect = document.getElementById('status');
        if (statusSelect) {
            toggleCatatanAsterisk(statusSelect.value);
        }
    });
    </script>
@endsection
