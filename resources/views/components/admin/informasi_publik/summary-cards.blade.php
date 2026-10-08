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
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
    <!-- Card Total: Daftar Informasi Publik — icon fa-list sama dengan sidebar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
            <div>
                <span class="text-3xl sm:text-4xl font-black block tracking-tight text-indigo-600">{{ $totalInformasi }}</span>
                <p class="text-xs font-extrabold text-slate-500 mt-0.5">Total</p>
            </div>
            <div class="text-indigo-600/80">
                <i class="fa-solid fa-list text-3xl sm:text-4xl"></i>
            </div>
        </div>
        <div class="bg-indigo-600 text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
            <span class="truncate">Update: {{ $lastUpdateTotal ? \Carbon\Carbon::parse($lastUpdateTotal)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card Berkala: icon fa-clock sama dengan sidebar Informasi Berkala -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
            <div>
                <span class="text-3xl sm:text-4xl font-black block tracking-tight text-blue-600">{{ $totalBerkala }}</span>
                <p class="text-xs font-extrabold text-slate-500 mt-0.5">Berkala</p>
            </div>
            <div class="text-blue-600/80">
                <i class="fa-regular fa-clock text-3xl sm:text-4xl"></i>
            </div>
        </div>
        <div class="bg-blue-600 text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
            <span class="truncate">Update: {{ $lastUpdateBerkala ? \Carbon\Carbon::parse($lastUpdateBerkala)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card Setiap Saat: icon fa-arrows-rotate sama dengan sidebar Informasi Setiap Saat -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
            <div>
                <span class="text-3xl sm:text-4xl font-black block tracking-tight text-teal-600">{{ $totalSetiapSaat }}</span>
                <p class="text-xs font-extrabold text-slate-500 mt-0.5">Setiap Saat</p>
            </div>
            <div class="text-teal-600/80">
                <i class="fa-solid fa-arrows-rotate text-3xl sm:text-4xl"></i>
            </div>
        </div>
        <div class="bg-teal-600 text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
            <span class="truncate">Update: {{ $lastUpdateSetiapSaat ? \Carbon\Carbon::parse($lastUpdateSetiapSaat)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
        </div>
    </div>

    <!-- Card Serta-Merta: icon fa-triangle-exclamation sama dengan sidebar Informasi Serta-Merta -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
            <div>
                <span class="text-3xl sm:text-4xl font-black block tracking-tight text-orange-600">{{ $totalSertaMerta }}</span>
                <p class="text-xs font-extrabold text-slate-500 mt-0.5">Serta-Merta</p>
            </div>
            <div class="text-orange-600/80">
                <i class="fa-solid fa-triangle-exclamation text-3xl sm:text-4xl"></i>
            </div>
        </div>
        <div class="bg-orange-600 text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
            <span class="truncate">Update: {{ $lastUpdateSertaMerta ? \Carbon\Carbon::parse($lastUpdateSertaMerta)->translatedFormat('d M Y') : '-' }}</span>
            <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
        </div>
    </div>
</div>
