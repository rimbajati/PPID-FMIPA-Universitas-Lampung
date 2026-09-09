@props([
    'totalPermohonan' => 0,
    'totalMenunggu' => 0,
    'totalDiproses' => 0,
    'totalSelesai' => 0,
    'totalDitolak' => 0
])

<!-- Section Header & 5 Summary Overview Cards -->
<div class="space-y-4">
    <div>
        <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Permohonan Informasi</h1>
        <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">Kelola & tanggapi permohonan informasi publik dari pemohon</p>
    </div>

    <!-- 5 Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @php
            $lastUpdateTotal = \App\Models\Permohonan::max('created_at') ?? \App\Models\Permohonan::max('updated_at');
            $lastUpdateMenunggu = \App\Models\Permohonan::whereIn('status', ['Diajukan', 'Menunggu'])->max('created_at') ?? $lastUpdateTotal;
            $lastUpdateDiproses = \App\Models\Permohonan::whereIn('status', ['Diproses', 'Perlu Hasil Akhir', 'Perlu Tindakan', 'Proses'])->max('updated_at');
            $lastUpdateSelesai = \App\Models\Permohonan::whereIn('status', ['Selesai', 'Terima', 'Disetujui'])->max('updated_at');
            $lastUpdateDitolak = \App\Models\Permohonan::where('status', 'Ditolak')->max('updated_at');
        @endphp

        <!-- Card 0: Total (Biru Royal Vivid) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#2563eb]">{{ $totalPermohonan }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Total</p>
                </div>
                <div class="text-[#2563eb]/80">
                    <i class="fa-regular fa-file-lines text-4xl md:text-5xl"></i>
                </div>
            </div>
            <div class="bg-[#2563eb] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Masuk: {{ $lastUpdateTotal ? \Carbon\Carbon::parse($lastUpdateTotal)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 1: Diajukan (Slate/Abu) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#475569]">{{ $totalMenunggu }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Diajukan</p>
                </div>
                <div class="text-[#475569]/80">
                    <i class="fa-regular fa-paper-plane text-4xl md:text-5xl"></i>
                </div>
            </div>
            <div class="bg-[#475569] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Masuk: {{ $lastUpdateMenunggu ? \Carbon\Carbon::parse($lastUpdateMenunggu)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 2: Diproses (Orange) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-orange-500">{{ $totalDiproses }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Diproses</p>
                </div>
                <div class="text-orange-500/80">
                    <i class="fa-solid fa-gears text-4xl md:text-5xl"></i>
                </div>
            </div>
            <div class="bg-orange-500 text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Direspons: {{ $lastUpdateDiproses ? \Carbon\Carbon::parse($lastUpdateDiproses)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 3: Selesai (Hijau Emerald) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#059669]">{{ $totalSelesai }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Selesai</p>
                </div>
                <div class="text-[#059669]/80">
                    <i class="fa-regular fa-circle-check text-4xl md:text-5xl"></i>
                </div>
            </div>
            <div class="bg-[#059669] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Direspons: {{ $lastUpdateSelesai ? \Carbon\Carbon::parse($lastUpdateSelesai)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 4: Ditolak (Merah Rose) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-5 flex justify-between items-center min-h-[105px]">
                <div>
                    <span class="text-4xl md:text-5xl font-black block tracking-tight text-[#e11d48]">{{ $totalDitolak }}</span>
                    <p class="text-xs md:text-sm font-extrabold text-slate-500 mt-1">Ditolak</p>
                </div>
                <div class="text-[#e11d48]/80">
                    <i class="fa-regular fa-circle-xmark text-4xl md:text-5xl"></i>
                </div>
            </div>
            <div class="bg-[#e11d48] text-white text-xs font-bold px-4 py-2 flex items-center justify-between">
                <span class="truncate">Terakhir Direspons: {{ $lastUpdateDitolak ? \Carbon\Carbon::parse($lastUpdateDitolak)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-xs shrink-0 ml-1"></i>
            </div>
        </div>
    </div>
</div>
