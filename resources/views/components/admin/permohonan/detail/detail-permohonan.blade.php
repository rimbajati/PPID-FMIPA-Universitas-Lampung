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
@endphp

<div class="divide-y divide-slate-200">
    {{-- Data Pemohon & Kontak — 1 bagian --}}
    <div class="pb-6">
        <div class="flex items-center justify-between gap-3 mb-4">
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
        <dl class="space-y-0 divide-y divide-slate-200">
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">Nama Lengkap</dt>
                <dd class="text-[15px] font-bold text-slate-900">{{ trim($permohonan->nama_lengkap) ?: '-' }}</dd>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">No. WhatsApp / Telepon</dt>
                <dd class="text-[15px] font-bold text-slate-900">{{ trim($permohonan->no_telepon ?? ($permohonan->no_hp ?? '-')) ?: '-' }}</dd>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">Email</dt>
                <dd class="text-[15px] font-semibold text-slate-900 break-all">{{ trim($permohonan->email ?? '-') ?: '-' }}</dd>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">Jenis Identitas</dt>
                <dd><span class="inline-flex px-3 py-1 text-xs font-bold bg-slate-100 border border-slate-200 text-slate-700 rounded-full">{{ $jenisId }}</span></dd>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">{{ $labelNomorId }}</dt>
                <dd class="text-[15px] font-mono font-bold text-slate-900 break-all">{{ trim($permohonan->no_identitas ?? ($permohonan->nik ?? '-')) ?: '-' }}</dd>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">{{ $labelSalinanId }}</dt>
                <dd>
                    @if($permohonan->file_identitas)
                        @php
                            $namaIdTampil = $permohonan->nama_file_identitas_asli ?: basename($permohonan->file_identitas);
                            $urlIdentitas = route('permohonan.file', ['id' => $permohonan->id, 'type' => 'identitas', 'filename' => rawurlencode($namaIdTampil)]);
                        @endphp
                        <a href="{{ $urlIdentitas }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-lg transition">
                            <i class="fa-regular fa-file text-slate-400"></i>
                            <span class="truncate max-w-[200px]">{{ $namaIdTampil }}</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-400"></i>
                        </a>
                    @else
                        <span class="text-sm text-slate-400">Tidak ada lampiran</span>
                    @endif
                </dd>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">Pekerjaan</dt>
                <dd class="text-[15px] font-semibold text-slate-900">{{ trim($permohonan->pekerjaan ?? '-') ?: '-' }}</dd>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3">
                <dt class="text-[13px] font-semibold text-slate-600">Alamat Lengkap</dt>
                <dd class="text-[15px] font-medium leading-relaxed text-slate-800">{{ trim($permohonan->alamat_lengkap ?? '-') ?: '-' }}</dd>
            </div>
        </dl>
    </div>

    {{-- Detail Permohonan --}}
    <div class="pt-6">
        <h3 class="text-sm font-bold tracking-widest uppercase text-slate-500 mb-4">Detail Permohonan</h3>
        <div class="space-y-4">
            <div>
                <p class="text-[13px] font-semibold text-slate-600 mb-1.5">Informasi yang Diminta</p>
                <div class="rounded-lg bg-slate-50 border border-slate-200 px-4 py-3.5 text-[15px] leading-relaxed font-medium text-slate-900 whitespace-pre-wrap">{{ trim($permohonan->informasi_yang_diminta) ?: '-' }}</div>
            </div>
            <div>
                <p class="text-[13px] font-semibold text-slate-600 mb-1.5">Tujuan Penggunaan Informasi</p>
                <div class="rounded-lg bg-slate-50 border border-slate-200 px-4 py-3.5 text-[15px] leading-relaxed font-medium text-slate-900 whitespace-pre-wrap">{{ trim($permohonan->tujuan_penggunaan_informasi) ?: '-' }}</div>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <span class="text-[13px] font-semibold text-slate-600">Cara Memperoleh Informasi</span>
                <span class="inline-flex w-fit items-center px-3.5 py-1.5 bg-white border border-slate-200 text-slate-800 text-sm font-bold rounded-full">{{ trim($permohonan->cara_memperoleh_informasi ?? '-') ?: '-' }}</span>
            </div>
        </div>
    </div>
</div>
