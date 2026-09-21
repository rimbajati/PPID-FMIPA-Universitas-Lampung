@props([
    'totalInformasi',
    'totalBerkala',
    'totalSertaMerta',
    'totalSetiapSaat',
    'lastUpdateTotal' => null,
    'lastUpdateBerkala' => null,
    'lastUpdateSertaMerta' => null,
    'lastUpdateSetiapSaat' => null,
])

<!-- 4 Summary Cards DIP -->
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
    <!-- Card 1: Total Informasi (Sky Blue / Cyan #0284c7) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
            <div>
                <span class="text-3xl sm:text-4xl font-black block tracking-tight text-[#0284c7]">{{ $totalInformasi }}</span>
                <p class="text-xs font-extrabold text-slate-500 mt-0.5">Total</p>
            </div>
            <div class="text-[#0284c7]/80">
                <i class="fa-regular fa-folder-open text-3xl sm:text-4xl"></i>
            </div>
        </div>
        <div class="bg-[#0284c7] text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
            <span class="truncate">Update: {{ $lastUpdateTotal ? \Carbon\Carbon::parse($lastUpdateTotal)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 2: Berkala (Biru Tua #1B365D) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
            <div>
                <span class="text-3xl sm:text-4xl font-black block tracking-tight text-[#1B365D]">{{ $totalBerkala }}</span>
                <p class="text-xs font-extrabold text-slate-500 mt-0.5">Berkala</p>
            </div>
            <div class="text-[#1B365D]/80">
                <i class="fa-regular fa-calendar-days text-3xl sm:text-4xl"></i>
            </div>
        </div>
        <div class="bg-[#1B365D] text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
            <span class="truncate">Update: {{ $lastUpdateBerkala ? \Carbon\Carbon::parse($lastUpdateBerkala)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 3: Serta-Merta (Merah Rose-500) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
            <div>
                <span class="text-3xl sm:text-4xl font-black block tracking-tight text-rose-600">{{ $totalSertaMerta }}</span>
                <p class="text-xs font-extrabold text-slate-500 mt-0.5">Serta-Merta</p>
            </div>
            <div class="text-rose-600/80">
                <i class="fa-regular fa-bell text-3xl sm:text-4xl"></i>
            </div>
        </div>
        <div class="bg-rose-500 text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
            <span class="truncate">Update: {{ $lastUpdateSertaMerta ? \Carbon\Carbon::parse($lastUpdateSertaMerta)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 4: Setiap Saat (Hijau Emerald-600) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
            <div>
                <span class="text-3xl sm:text-4xl font-black block tracking-tight text-emerald-600">{{ $totalSetiapSaat }}</span>
                <p class="text-xs font-extrabold text-slate-500 mt-0.5">Setiap Saat</p>
            </div>
            <div class="text-emerald-600/80">
                <i class="fa-regular fa-clock text-3xl sm:text-4xl"></i>
            </div>
        </div>
        <div class="bg-emerald-600 text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
            <span class="truncate">Update: {{ $lastUpdateSetiapSaat ? \Carbon\Carbon::parse($lastUpdateSetiapSaat)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
        </div>
    </div>
</div>
