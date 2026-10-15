@props(['keberatan'])
@php
    $hasLampiran = !empty($keberatan->file_pendukung);
    if ($hasLampiran) {
        $namaPendukungTampil = $keberatan->nama_file_pendukung_asli ?: basename($keberatan->file_pendukung);
        $urlPendukung = route('keberatan.file', ['id' => $keberatan->id, 'filename' => rawurlencode($namaPendukungTampil)]);
    }
@endphp

<div class="space-y-6">
    <div class="border border-slate-200 rounded-xl overflow-hidden shadow-xs">
        <div class="flex items-center justify-between gap-3 px-5 py-3.5 bg-primary text-white border-b border-primary-light">
            <h3 class="text-sm font-extrabold tracking-tight flex items-center gap-2">
                <i class="mdi mdi-alert-circle-outline text-secondary text-base"></i>
                <span>Rincian Keberatan</span>
            </h3>
            @if($keberatan->status === 'Diajukan')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 text-white border border-white/20 text-xs font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>Diajukan</span>
            @elseif($keberatan->status === 'Diproses')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>Diproses</span>
            @elseif($keberatan->status === 'Selesai')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 text-xs font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Selesai</span>
            @elseif($keberatan->status === 'Ditolak')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-400/20 text-rose-300 border border-rose-400/30 text-xs font-semibold"><span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>Ditolak</span>
            @endif
        </div>

        <div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr]">
                <div class="px-4 py-3 bg-slate-50 flex items-center"><span class="text-[13px] font-bold text-slate-800">Permohonan Asal</span></div>
                <div class="px-4 py-3 bg-slate-50 flex items-center">
                    @if($keberatan->permohonan)
                        <a href="{{ route('admin.permohonan.show', $keberatan->permohonan->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 hover:bg-slate-50 text-slate-800 font-mono text-xs font-bold rounded-lg transition">
                            {{ $keberatan->permohonan->no_tiket }}
                            <i class="mdi mdi-open-in-new text-[10px] text-slate-400"></i>
                        </a>
                    @else
                        <span class="text-[13px] font-medium text-slate-700">-</span>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-white"><span class="text-[13px] font-bold text-slate-800">Alasan Pengajuan Keberatan</span></div>
                <div class="px-4 py-3 bg-white"><span class="text-[13px] font-medium leading-relaxed text-slate-700 whitespace-pre-wrap">{{ trim($keberatan->alasan_keberatan) ?: '-' }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-white"><span class="text-[13px] font-bold text-slate-800">Kronologi Pengajuan Keberatan</span></div>
                <div class="px-4 py-3 bg-white"><span class="text-[13px] font-medium leading-relaxed text-slate-700 whitespace-pre-wrap">{{ trim($keberatan->kronologi_keberatan ?: 'Pemohon tidak menyertakan kronologi tambahan.') }}</span></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-[220px_1fr] border-t border-slate-200">
                <div class="px-4 py-3 bg-slate-50 flex items-center"><span class="text-[13px] font-bold text-slate-800">Dokumen Pendukung</span></div>
                <div class="px-4 py-3 bg-slate-50 flex items-center">
                    @if($hasLampiran)
                        <a href="{{ $urlPendukung }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-sm rounded-lg transition">
                            <i class="mdi mdi-file-outline text-slate-400"></i>
                            <span class="truncate max-w-[220px]">{{ $namaPendukungTampil }}</span>
                            <i class="mdi mdi-open-in-new text-[11px] text-slate-400"></i>
                        </a>
                    @else
                        <span class="text-[13px] font-medium text-slate-500">Tidak ada dokumen pendukung</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
