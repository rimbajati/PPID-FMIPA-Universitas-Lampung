@props(['currentPage' => 'Permohonan Informasi'])

<div class="bg-white border-b border-slate-200/80 py-4">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12 lg:px-16 flex items-center justify-between gap-4">
        <div class="flex items-center gap-2.5 text-sm font-bold text-slate-500">
            <a href="{{ url('/layanan') }}" class="hover:text-slate-900 transition flex items-center gap-1.5">
                <span>Layanan</span>
            </a>
            <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
            <span class="text-slate-900 font-extrabold truncate max-w-[350px] sm:max-w-xl">{{ $currentPage }}</span>
        </div>
    </div>
</div>
