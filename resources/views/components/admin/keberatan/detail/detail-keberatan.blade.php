@props(['keberatan'])

<div class="divide-y divide-slate-200">
    {{-- Rincian Keberatan --}}
    <div class="pb-6">
        <div class="flex items-center justify-between gap-3 mb-4">
            <h3 class="text-sm font-bold tracking-widest uppercase text-slate-500">Rincian Keberatan</h3>
            @if($keberatan->status === 'Diajukan')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>Diajukan</span>
            @elseif($keberatan->status === 'Diproses')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Diproses</span>
            @elseif($keberatan->status === 'Selesai')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Selesai</span>
            @elseif($keberatan->status === 'Ditolak')
                <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Ditolak</span>
            @endif
        </div>
        <dl class="space-y-0 divide-y divide-slate-200">
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">Permohonan Asal</dt>
                <dd>
                    @if($keberatan->permohonan)
                        <a href="{{ route('admin.permohonan.show', $keberatan->permohonan->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-white border border-slate-200 hover:bg-slate-50 text-slate-800 font-mono text-xs font-bold rounded-lg transition">
                            {{ $keberatan->permohonan->no_tiket }}
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                        </a>
                    @else
                        <span class="text-sm text-slate-400">-</span>
                    @endif
                </dd>
            </div>
            <div class="py-3">
                <dt class="text-[13px] font-semibold text-slate-600 mb-1.5">Alasan Penolakan dari PPID</dt>
                <dd class="rounded-lg bg-slate-50 border border-slate-200 px-4 py-3.5 text-[15px] leading-relaxed font-medium text-slate-900 whitespace-pre-wrap">{{ trim($keberatan->permohonan->alasan_ditolak ?? '-') ?: '-' }}</dd>
            </div>
            <div class="py-3">
                <dt class="text-[13px] font-semibold text-slate-600 mb-1.5">Alasan Pengajuan Keberatan</dt>
                <dd class="rounded-lg bg-slate-50 border border-slate-200 px-4 py-3.5 text-[15px] leading-relaxed font-medium text-slate-900 whitespace-pre-wrap">{{ trim($keberatan->alasan_keberatan) ?: '-' }}</dd>
            </div>
            <div class="py-3">
                <dt class="text-[13px] font-semibold text-slate-600 mb-1.5">Kronologi Pengajuan Keberatan</dt>
                <dd class="rounded-lg bg-slate-50 border border-slate-200 px-4 py-3.5 text-[15px] leading-relaxed font-medium text-slate-900 whitespace-pre-wrap">{{ trim($keberatan->kronologi_keberatan ?: 'Pemohon tidak menyertakan kronologi tambahan.') }}</dd>
            </div>
            <div class="grid grid-cols-[180px_1fr] gap-3 py-3 items-center">
                <dt class="text-[13px] font-semibold text-slate-600">Lampiran</dt>
                <dd>
                    @if($keberatan->file_pendukung)
                        @php
                            $namaPendukungTampil = $keberatan->nama_file_pendukung_asli ?: basename($keberatan->file_pendukung);
                            $urlPendukung = route('keberatan.file', ['id' => $keberatan->id, 'filename' => rawurlencode($namaPendukungTampil)]);
                        @endphp
                        <a href="{{ $urlPendukung }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 font-medium text-sm rounded-lg transition">
                            <i class="fa-regular fa-file text-slate-400"></i>
                            <span class="truncate max-w-[200px]">{{ $namaPendukungTampil }}</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-400"></i>
                        </a>
                    @else
                        <span class="text-sm text-slate-400">Tidak ada lampiran</span>
                    @endif
                </dd>
            </div>
        </dl>
    </div>
</div>
