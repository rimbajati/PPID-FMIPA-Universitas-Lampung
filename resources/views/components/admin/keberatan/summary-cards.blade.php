@props([
    'totalKeberatan',
    'totalMenunggu',
    'totalDiproses',
    'totalSelesai',
    'totalDitolak'
])

@php
    $lastUpdateTotal = \App\Models\Keberatan::max('created_at') ?? \App\Models\Keberatan::max('updated_at');
    $lastUpdateMenunggu = \App\Models\Keberatan::whereIn('status', ['Diajukan', 'Menunggu'])->max('created_at') ?? $lastUpdateTotal;
    $lastUpdateDiproses = \App\Models\Keberatan::whereIn('status', ['Diproses', 'Perlu Tindakan', 'Proses'])->max('updated_at');
    $lastUpdateSelesai = \App\Models\Keberatan::whereIn('status', ['Selesai', 'Terima', 'Disetujui'])->max('updated_at');
    $lastUpdateDitolak = \App\Models\Keberatan::where('status', 'Ditolak')->max('updated_at');
@endphp

<!-- Section Header: Keberatan Overview -->
<div class="space-y-4">
    <div>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Pengajuan Keberatan</h1>
        <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">Kelola & tanggapi pengajuan keberatan atas permintaan informasi publik</p>
    </div>

    <!-- 5 Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Card 0: Total (Amber Keberatan) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#f59e0b]">{{ $totalKeberatan }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Total</p>
                </div>
                <div class="text-[#f59e0b]/80 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 md:w-14 md:h-14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-[#f59e0b] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Masuk: {{ $lastUpdateTotal ? \Carbon\Carbon::parse($lastUpdateTotal)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 1: Diajukan (Slate/Abu) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#475569]">{{ $totalMenunggu }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Diajukan</p>
                </div>
                <div class="text-[#475569]/80 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-regular fa-paper-plane text-4xl md:text-5xl"></i>
                </div>
            </div>
            <div class="bg-[#475569] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Masuk: {{ $lastUpdateMenunggu ? \Carbon\Carbon::parse($lastUpdateMenunggu)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 2: Diproses (Amber/Orange) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#d97706]">{{ $totalDiproses }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Diproses</p>
                </div>
                <div class="text-[#d97706]/80 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 md:w-14 md:h-14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-[#d97706] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Direspons: {{ $lastUpdateDiproses ? \Carbon\Carbon::parse($lastUpdateDiproses)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 3: Selesai (Emerald/Hijau) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#059669]">{{ $totalSelesai }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Selesai</p>
                </div>
                <div class="text-[#059669]/80 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 md:w-14 md:h-14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-[#059669] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Direspons: {{ $lastUpdateSelesai ? \Carbon\Carbon::parse($lastUpdateSelesai)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 4: Ditolak (Rose/Merah) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#e11d48]">{{ $totalDitolak }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Ditolak</p>
                </div>
                <div class="text-[#e11d48]/80 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 md:w-14 md:h-14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="bg-[#e11d48] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Direspons: {{ $lastUpdateDitolak ? \Carbon\Carbon::parse($lastUpdateDitolak)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>
    </div>
</div>
