@extends('layouts.admin')

@section('title', 'Detail Pengajuan - PPID FMIPA Unila')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Detail Pengajuan</h1>
            <p class="text-sm text-gray-500">Tiket: <span class="font-bold text-[#0095e8]">{{ $permohonan->no_tiket }}</span></p>
        </div>
        <a href="{{ url('/admin/pengajuan') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold text-sm transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
                <h2 class="text-lg font-extrabold text-gray-900 mb-6">Data {{ $permohonan->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}</h2>

                @if($permohonan->jenis_layanan == 'Permohonan')
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Rincian Informasi</label>
                            <p class="p-4 bg-gray-50 rounded-xl mt-1 text-gray-700">{{ $permohonan->info_diminta }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase mt-4">Tujuan Permohonan</label>
                            <p class="p-4 bg-gray-50 rounded-xl mt-1 text-gray-700">{{ $permohonan->tujuan_permohonan }}</p>
                        </div>
                    </div>
                @else
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Alasan Keberatan</label>
                            <p class="p-4 bg-gray-50 rounded-xl mt-1 text-gray-700">{{ $permohonan->tujuan_keberatan }}</p>
                        </div>
                        @if($permohonan->permohonan_terkait_id)
                        <div class="p-4 border border-blue-100 bg-blue-50 rounded-xl">
                            <label class="text-[10px] font-bold text-blue-400 uppercase">Terkait dengan Permohonan</label>
                            <p class="font-bold text-blue-700">Tiket: {{ $permohonan->permohonanTerkait->no_tiket ?? 'N/A' }}</p>
                        </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Form Proses Status (Untuk Admin) -->
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
                <h2 class="text-lg font-extrabold text-gray-900 mb-6">Proses Pengajuan</h2>
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl text-sm font-semibold flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ url('/admin/pengajuan/' . $permohonan->id . '/status') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase block mb-2">Ubah Status</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach(['DIAJUKAN', 'DIPROSES', 'DITERIMA', 'DITOLAK'] as $s)
                                <label class="status-radio-label border rounded-2xl p-4 flex flex-col items-center justify-center gap-2 cursor-pointer transition-all hover:bg-slate-50 relative {{ $permohonan->status == $s ? 'border-[#0095e8] bg-blue-50/20 ring-1 ring-[#0095e8]' : 'border-slate-200' }}">
                                    <input type="radio" name="status" value="{{ $s }}" {{ $permohonan->status == $s ? 'checked' : '' }} class="sr-only" onchange="updateRadioSelection(this)">
                                    <span class="h-2 w-2 rounded-full 
                                        {{ $s == 'DIAJUKAN' ? 'bg-amber-500' : '' }}
                                        {{ $s == 'DIPROSES' ? 'bg-blue-500' : '' }}
                                        {{ $s == 'DITERIMA' ? 'bg-emerald-500' : '' }}
                                        {{ $s == 'DITOLAK' ? 'bg-rose-500' : '' }}"></span>
                                    <span class="text-xs font-bold text-slate-800">{{ $s }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="catatan_admin" class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Catatan Admin / Tanggapan</label>
                        <textarea name="catatan_admin" id="catatan_admin" rows="4" class="w-full border border-slate-200 rounded-2xl p-4 outline-none focus:border-[#0095e8] transition-colors text-sm" placeholder="Tuliskan tanggapan atau alasan penolakan/penerimaan...">{{ old('catatan_admin', $permohonan->catatan_admin) }}</textarea>
                    </div>

                    <div>
                        <label for="file_jawaban" class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Upload File Jawaban (PDF/Gambar/Zip, max 5MB)</label>
                        @if($permohonan->file_jawaban)
                            <div class="mb-2 text-xs font-semibold text-slate-500">
                                File saat ini: <a href="{{ asset('storage/' . $permohonan->file_jawaban) }}" target="_blank" class="text-[#0095e8] hover:underline">Lihat File</a>
                            </div>
                        @endif
                        <input type="file" name="file_jawaban" id="file_jawaban" class="w-full border border-slate-200 rounded-2xl p-3 text-sm focus:border-[#0095e8]">
                    </div>

                    <button type="submit" class="w-full bg-[#0095e8] text-white py-4 rounded-2xl font-bold text-sm hover:bg-blue-700 transition shadow-md">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <script>
        function updateRadioSelection(input) {
            document.querySelectorAll('.status-radio-label').forEach(label => {
                label.classList.remove('border-[#0095e8]', 'bg-blue-50/20', 'ring-1', 'ring-[#0095e8]');
                label.classList.add('border-slate-200');
            });
            const label = input.closest('label');
            if (label) {
                label.classList.remove('border-slate-200');
                label.classList.add('border-[#0095e8]', 'bg-blue-50/20', 'ring-1', 'ring-[#0095e8]');
            }
        }
        </script>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
                <h2 class="text-lg font-extrabold text-gray-900 mb-6">Data Pemohon</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Nama Lengkap</label>
                        <p class="font-bold text-gray-900">{{ $permohonan->nama }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Kontak</label>
                        <p class="text-sm text-gray-600">{{ $permohonan->email }}</p>
                        <p class="text-sm text-gray-600">{{ $permohonan->no_hp }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
                <h2 class="text-lg font-extrabold text-gray-900 mb-4">Lampiran Dokumen</h2>
                <div class="space-y-4">
                    @php $hasAnyFile = false; @endphp
                    
                    @if($permohonan->lampiran_identitas)
                        @php $hasAnyFile = true; @endphp
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Identitas (KTP)</label>
                            <a href="{{ asset('storage/'.$permohonan->lampiran_identitas) }}" target="_blank"
                               class="flex items-center gap-2 w-full p-3 bg-slate-50 border border-slate-200 text-slate-700 rounded-xl font-bold text-xs hover:bg-slate-100 hover:border-slate-300 transition">
                                <i class="fa-solid fa-file-pdf text-red-500 text-sm"></i> Lihat Identitas (KTP)
                            </a>
                        </div>
                    @endif

                    @if($permohonan->akta_pendirian)
                        @php $hasAnyFile = true; @endphp
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Akta Pendirian Badan Hukum</label>
                            <a href="{{ asset('storage/'.$permohonan->akta_pendirian) }}" target="_blank"
                               class="flex items-center gap-2 w-full p-3 bg-slate-50 border border-slate-200 text-slate-700 rounded-xl font-bold text-xs hover:bg-slate-100 hover:border-slate-300 transition">
                                <i class="fa-solid fa-file-pdf text-red-500 text-sm"></i> Lihat Akta Pendirian
                            </a>
                        </div>
                    @endif

                    @if($permohonan->lampiran_pendukung)
                        @php $hasAnyFile = true; @endphp
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase block mb-1">Lampiran Pendukung</label>
                            <a href="{{ asset('storage/'.$permohonan->lampiran_pendukung) }}" target="_blank"
                               class="flex items-center gap-2 w-full p-3 bg-slate-50 border border-slate-200 text-slate-700 rounded-xl font-bold text-xs hover:bg-slate-100 hover:border-slate-300 transition">
                                <i class="fa-solid fa-file-pdf text-red-500 text-sm"></i> Lihat Lampiran Pendukung
                            </a>
                        </div>
                    @endif

                    @if(!$hasAnyFile)
                        <p class="text-center text-gray-400 font-bold text-sm bg-gray-50 p-4 rounded-xl">Tidak ada lampiran</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
