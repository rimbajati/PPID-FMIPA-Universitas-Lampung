@props([
    'totalInformasi',
    'totalBerkala',
    'totalSertaMerta',
    'totalSetiapSaat',
    'totalDikecualikan',
    'lastUpdateTotal' => null,
    'lastUpdateBerkala' => null,
    'lastUpdateSertaMerta' => null,
    'lastUpdateSetiapSaat' => null,
    'lastUpdateDikecualikan' => null,
])

<!-- 5 Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
    <!-- Card 1: Total Informasi (Sky Blue / Cyan #0284c7) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#0284c7]">{{ $totalInformasi }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Total</p>
            </div>
            <div class="text-[#0284c7]/80">
                <i class="fa-regular fa-folder-open text-4xl md:text-5xl"></i>
            </div>
        </div>
        <div class="bg-[#0284c7] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateTotal ? \Carbon\Carbon::parse($lastUpdateTotal)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 2: Berkala (Biru Tua #1B365D) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#1B365D]">{{ $totalBerkala }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Berkala</p>
            </div>
            <div class="text-[#1B365D]/80">
                <i class="fa-regular fa-calendar-days text-4xl md:text-5xl"></i>
            </div>
        </div>
        <div class="bg-[#1B365D] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateBerkala ? \Carbon\Carbon::parse($lastUpdateBerkala)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 3: Serta-Merta (Merah Rose-500) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-rose-600">{{ $totalSertaMerta }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Serta-Merta</p>
            </div>
            <div class="text-rose-600/80">
                <i class="fa-regular fa-bell text-4xl md:text-5xl"></i>
            </div>
        </div>
        <div class="bg-rose-500 text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateSertaMerta ? \Carbon\Carbon::parse($lastUpdateSertaMerta)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 4: Setiap Saat (Hijau Emerald-600) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-emerald-600">{{ $totalSetiapSaat }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Setiap Saat</p>
            </div>
            <div class="text-emerald-600/80">
                <i class="fa-regular fa-clock text-4xl md:text-5xl"></i>
            </div>
        </div>
        <div class="bg-emerald-600 text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateSetiapSaat ? \Carbon\Carbon::parse($lastUpdateSetiapSaat)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 5: Dikecualikan (Abu-abu Slate-500) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-slate-500">{{ $totalDikecualikan }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Dikecualikan</p>
            </div>
            <div class="text-slate-500/80">
                <i class="fa-solid fa-lock text-4xl md:text-5xl"></i>
            </div>
        </div>
        <div class="bg-slate-500 text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateDikecualikan ? \Carbon\Carbon::parse($lastUpdateDikecualikan)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>
</div>
