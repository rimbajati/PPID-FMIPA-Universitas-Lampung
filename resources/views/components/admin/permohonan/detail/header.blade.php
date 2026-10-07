@props(['permohonan'])

<div class="flex flex-wrap items-center justify-between gap-3">
    <div>
        <span class="font-mono font-bold text-lg sm:text-xl tracking-tight text-slate-900">{{ $permohonan->no_tiket }}</span>
        <p class="text-xs text-slate-500 mt-1">Diajukan {{ $permohonan->created_at ? $permohonan->created_at->translatedFormat('l, d F Y — H:i') . ' WIB' : '-' }}</p>
    </div>
    <a href="{{ route('admin.permohonan.index') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold text-sm rounded-lg transition">
        <i class="fa-solid fa-arrow-left text-xs"></i>
        Kembali
    </a>
</div>
