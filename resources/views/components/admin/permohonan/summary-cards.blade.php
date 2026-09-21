@props([
    'totalPermohonan' => 0,
    'totalMenunggu' => 0,
    'totalDiproses' => 0,
    'totalSelesai' => 0,
    'totalDitolak' => 0
])

<!-- Section Header & 5 Summary Overview Cards -->
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Permohonan Informasi</h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">Kelola & tanggapi permohonan informasi publik dari pemohon</p>
        </div>

        <!-- Tombol Export Permohonan -->
        <div class="relative shrink-0" x-data="{ openExport: false }">
            <button type="button" @click="openExport = !openExport" @click.away="openExport = false"
                    class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                <i class="fa-solid fa-file-export text-slate-500"></i>
                <span>Export Data</span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': openExport }"></i>
            </button>

            <div x-show="openExport" x-cloak 
                 class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-30 animate-in fade-in zoom-in-95 duration-150">
                <div class="px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Pilih Format</div>
                <a href="{{ route('admin.export.permohonan.excel', request()->query()) }}" 
                   class="flex items-center gap-2.5 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                    <i class="fa-solid fa-file-excel text-emerald-600 w-4 text-center"></i>
                    <span>Export Excel (.csv)</span>
                </a>
                <a href="{{ route('admin.export.permohonan.pdf', request()->query()) }}" target="_blank"
                   class="flex items-center gap-2.5 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-rose-50 hover:text-rose-700 transition-colors">
                    <i class="fa-solid fa-file-pdf text-rose-600 w-4 text-center"></i>
                    <span>Cetak / Simpan PDF</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 5 Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3">
        @php
            $lastUpdateTotal = \App\Models\Permohonan::max('created_at') ?? \App\Models\Permohonan::max('updated_at');
            $lastUpdateMenunggu = \App\Models\Permohonan::whereIn('status', ['Diajukan', 'Menunggu'])->max('created_at') ?? $lastUpdateTotal;
            $lastUpdateDiproses = \App\Models\Permohonan::whereIn('status', ['Diproses', 'Perlu Hasil Akhir', 'Perlu Tindakan', 'Proses'])->max('updated_at');
            $lastUpdateSelesai = \App\Models\Permohonan::whereIn('status', ['Selesai', 'Terima', 'Disetujui'])->max('updated_at');
            $lastUpdateDitolak = \App\Models\Permohonan::where('status', 'Ditolak')->max('updated_at');
        @endphp

        <!-- Card 0: Total (Biru Royal Vivid) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
                <div>
                    <span class="text-3xl sm:text-4xl font-black block tracking-tight text-[#2563eb]">{{ $totalPermohonan }}</span>
                    <p class="text-xs font-extrabold text-slate-500 mt-0.5">Total</p>
                </div>
                <div class="text-[#2563eb]/80">
                    <i class="fa-regular fa-file-lines text-3xl sm:text-4xl"></i>
                </div>
            </div>
            <div class="bg-[#2563eb] text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
                <span class="truncate">Terakhir Masuk: {{ $lastUpdateTotal ? \Carbon\Carbon::parse($lastUpdateTotal)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 1: Diajukan (Slate/Abu) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
                <div>
                    <span class="text-3xl sm:text-4xl font-black block tracking-tight text-[#475569]">{{ $totalMenunggu }}</span>
                    <p class="text-xs font-extrabold text-slate-500 mt-0.5">Diajukan</p>
                </div>
                <div class="text-[#475569]/80">
                    <i class="fa-regular fa-paper-plane text-3xl sm:text-4xl"></i>
                </div>
            </div>
            <div class="bg-[#475569] text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
                <span class="truncate">Terakhir Masuk: {{ $lastUpdateMenunggu ? \Carbon\Carbon::parse($lastUpdateMenunggu)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 2: Diproses (Orange) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
                <div>
                    <span class="text-3xl sm:text-4xl font-black block tracking-tight text-orange-500">{{ $totalDiproses }}</span>
                    <p class="text-xs font-extrabold text-slate-500 mt-0.5">Diproses</p>
                </div>
                <div class="text-orange-500/80">
                    <i class="fa-solid fa-gears text-3xl sm:text-4xl"></i>
                </div>
            </div>
            <div class="bg-orange-500 text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
                <span class="truncate">Terakhir Respon: {{ $lastUpdateDiproses ? \Carbon\Carbon::parse($lastUpdateDiproses)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 3: Selesai (Hijau Emerald) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
                <div>
                    <span class="text-3xl sm:text-4xl font-black block tracking-tight text-[#059669]">{{ $totalSelesai }}</span>
                    <p class="text-xs font-extrabold text-slate-500 mt-0.5">Selesai</p>
                </div>
                <div class="text-[#059669]/80">
                    <i class="fa-regular fa-circle-check text-3xl sm:text-4xl"></i>
                </div>
            </div>
            <div class="bg-[#059669] text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
                <span class="truncate">Terakhir Respon: {{ $lastUpdateSelesai ? \Carbon\Carbon::parse($lastUpdateSelesai)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 4: Ditolak (Merah Rose) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-4 sm:p-4.5 flex justify-between items-center min-h-[5.5rem]">
                <div>
                    <span class="text-3xl sm:text-4xl font-black block tracking-tight text-[#e11d48]">{{ $totalDitolak }}</span>
                    <p class="text-xs font-extrabold text-slate-500 mt-0.5">Ditolak</p>
                </div>
                <div class="text-[#e11d48]/80">
                    <i class="fa-regular fa-circle-xmark text-3xl sm:text-4xl"></i>
                </div>
            </div>
            <div class="bg-[#e11d48] text-white text-[11px] font-bold px-3 py-1.5 flex items-center justify-between">
                <span class="truncate">Terakhir Respon: {{ $lastUpdateDitolak ? \Carbon\Carbon::parse($lastUpdateDitolak)->translatedFormat('d M Y') : '-' }}</span>
                <i class="fa-solid fa-rotate text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>
    </div>
</div>
