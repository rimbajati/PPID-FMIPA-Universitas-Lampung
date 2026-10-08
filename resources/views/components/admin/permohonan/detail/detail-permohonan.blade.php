@props(['permohonan'])
@php
    $jenisId = $permohonan->jenis_identitas ?? 'KTP';
    $labelNomorId = match($jenisId) {
        'Paspor' => 'Nomor Paspor',
        'Badan hukum' => 'Nomor Akta / SK Pendirian',
        default => 'NIK',
    };
    $labelSalinanId = match($jenisId) {
        'Paspor' => 'Salinan Paspor',
        'Badan hukum' => 'Salinan Akta / SK Pendirian',
        default => 'Salinan KTP',
    };
    $hasIdentitas = !empty($permohonan->file_identitas);
    if ($hasIdentitas) {
        $namaIdTampil = $permohonan->nama_file_identitas_asli ?: basename($permohonan->file_identitas);
        $urlIdentitas = route('permohonan.file', ['id' => $permohonan->id, 'type' => 'identitas', 'filename' => rawurlencode($namaIdTampil)]);
    }
@endphp

<div class="space-y-6">
    {{-- Data Pemohon — isi sama seperti sebelumnya --}}
    <div>
        <div class="flex items-center justify-between gap-3 mb-3">
            <h3 class="text-sm font-bold tracking-widest uppercase text-slate-500">Data Pemohon</h3>
            @if($permohonan->status === 'Diajukan')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>Diajukan</span>
            @elseif($permohonan->status === 'Diproses')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Diproses</span>
            @elseif($permohonan->status === 'Selesai')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Selesai</span>
            @elseif($permohonan->status === 'Ditolak')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Ditolak</span>
            @endif
        </div>

        <div class="border border-slate-200 rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr]">
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-bold text-slate-800">Nama Lengkap</span></div>
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-semibold text-slate-900">{{ trim($permohonan->nama_lengkap) ?: '-' }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-white flex items-center"><span class="text-[13px] font-bold text-slate-800">No. WhatsApp / Telepon</span></div>
                <div class="px-4 py-3 bg-white flex items-center"><span class="text-[13px] font-medium text-slate-700">{{ trim($permohonan->no_telepon ?? ($permohonan->no_hp ?? '-')) ?: '-' }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-bold text-slate-800">Email</span></div>
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-medium text-slate-700 break-all">{{ trim($permohonan->email ?? '-') ?: '-' }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-white flex items-center"><span class="text-[13px] font-bold text-slate-800">Jenis Identitas</span></div>
                <div class="px-4 py-3 bg-white flex items-center"><span class="inline-flex px-3 py-1 text-xs font-bold bg-slate-100 border border-slate-200 text-slate-700 rounded-full">{{ $jenisId }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-bold text-slate-800">{{ $labelNomorId }}</span></div>
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-mono font-bold text-slate-900 break-all">{{ trim($permohonan->no_identitas ?? ($permohonan->nik ?? '-')) ?: '-' }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-white flex items-center"><span class="text-[13px] font-bold text-slate-800">{{ $labelSalinanId }}</span></div>
                <div class="px-4 py-3 bg-white flex items-center">
                    @if($hasIdentitas)
                        <a href="{{ $urlIdentitas }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-lg transition">
                            <i class="fa-regular fa-file text-slate-400"></i>
                            <span class="truncate max-w-[220px]">{{ $namaIdTampil }}</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-400"></i>
                        </a>
                    @else
                        <span class="text-[13px] text-slate-400">Tidak ada lampiran</span>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-bold text-slate-800">Pekerjaan</span></div>
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-medium text-slate-700">{{ trim($permohonan->pekerjaan ?? '-') ?: '-' }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-white"><span class="text-[13px] font-bold text-slate-800">Alamat Lengkap</span></div>
                <div class="px-4 py-3 bg-white"><span class="text-[13px] font-medium leading-relaxed text-slate-700">{{ trim($permohonan->alamat_lengkap ?? '-') ?: '-' }}</span></div>
            </div>
        </div>
    </div>

    {{-- Detail Permohonan — isi sama seperti sebelumnya --}}
    <div>
        <h3 class="text-sm font-bold tracking-widest uppercase text-slate-500 mb-3">Detail Permohonan</h3>
        <div class="border border-slate-200 rounded-lg overflow-hidden">
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr]">
                <div class="px-4 py-3 bg-[#f1f5f9]"><span class="text-[13px] font-bold text-slate-800">Informasi yang Diminta</span></div>
                <div class="px-4 py-3 bg-[#f1f5f9]"><span class="text-[13px] font-medium leading-relaxed text-slate-700 whitespace-pre-wrap">{{ trim($permohonan->informasi_yang_diminta) ?: '-' }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-white"><span class="text-[13px] font-bold text-slate-800">Tujuan Penggunaan Informasi</span></div>
                <div class="px-4 py-3 bg-white"><span class="text-[13px] font-medium leading-relaxed text-slate-700 whitespace-pre-wrap">{{ trim($permohonan->tujuan_penggunaan_informasi) ?: '-' }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-bold text-slate-800">Cara Memperoleh Informasi</span></div>
                <div class="px-4 py-3 bg-[#f1f5f9] flex items-center"><span class="text-[13px] font-medium text-slate-700">{{ trim($permohonan->cara_memperoleh_informasi ?? '-') ?: '-' }}</span></div>
            </div>
        </div>
    </div>
</div>
