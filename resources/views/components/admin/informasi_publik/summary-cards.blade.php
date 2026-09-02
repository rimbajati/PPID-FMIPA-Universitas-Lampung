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
    <!-- Card 1: Total Informasi (Biru) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#2563eb]">{{ $totalInformasi }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Total</p>
            </div>
            <div class="text-[#2563eb]/80 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-12 h-12 md:w-14 md:h-14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.75A1.5 1.5 0 015.25 8.25h4.379a1.5 1.5 0 011.06.44l1.34 1.34a.75.75 0 00.53.22h6.191a1.5 1.5 0 011.5 1.5v6.75a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5V9.75z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-[#2563eb] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateTotal ? \Carbon\Carbon::parse($lastUpdateTotal)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 2: Berkala (Biru Muda) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#0284c7]">{{ $totalBerkala }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Berkala</p>
            </div>
            <div class="text-[#0284c7]/80 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-12 h-12 md:w-14 md:h-14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path>
                </svg>
            </div>
        </div>
        <div class="bg-[#0284c7] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateBerkala ? \Carbon\Carbon::parse($lastUpdateBerkala)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 3: Serta-Merta (Merah) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#e11d48]">{{ $totalSertaMerta }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Serta-Merta</p>
            </div>
            <div class="text-[#e11d48]/80 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-regular fa-bell text-4xl md:text-5xl"></i>
            </div>
        </div>
        <div class="bg-[#e11d48] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateSertaMerta ? \Carbon\Carbon::parse($lastUpdateSertaMerta)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 4: Setiap Saat (Hijau) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#059669]">{{ $totalSetiapSaat }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Setiap Saat</p>
            </div>
            <div class="text-[#059669]/80 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-regular fa-clock text-4xl md:text-5xl"></i>
            </div>
        </div>
        <div class="bg-[#059669] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateSetiapSaat ? \Carbon\Carbon::parse($lastUpdateSetiapSaat)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card 5: Dikecualikan (Slate/Abu) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
        <div class="p-5 flex justify-between items-center min-h-[105px]">
            <div>
                <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#475569]">{{ $totalDikecualikan }}</span>
                <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Dikecualikan</p>
            </div>
            <div class="text-[#475569]/80 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-12 h-12 md:w-14 md:h-14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-[#475569] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
            <span class="truncate">Terakhir diperbarui: {{ $lastUpdateDikecualikan ? \Carbon\Carbon::parse($lastUpdateDikecualikan)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
        </div>
    </div>
</div>
