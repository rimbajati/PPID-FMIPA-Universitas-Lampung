@props(['keberatan'])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-2">
    <div>
        <div class="inline-block px-5 py-2.5 bg-amber-500 text-white font-black text-xl sm:text-2xl tracking-wide rounded-md shadow-sm">
            {{ $keberatan->no_tiket }}
        </div>
        <p class="text-sm font-semibold text-slate-500 mt-2 flex items-center gap-1.5">
            <!-- <i class="fa-regular fa-calendar-check text-amber-600 text-xs"></i> -->
            <span>Diajukan pada {{ $keberatan->created_at ? $keberatan->created_at->translatedFormat('l, d F Y - H:i') . ' WIB' : '-' }}</span>
        </p>
    </div>

    <div class="flex items-center gap-2.5">
        <a href="{{ route('admin.keberatan.index') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-extrabold text-xs sm:text-sm rounded-xl transition shadow-sm hover:shadow cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>
</div>
