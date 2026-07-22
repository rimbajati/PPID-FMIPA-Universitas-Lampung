@extends('layout.admin')

@section('title', 'Dashboard Admin - PPID FMIPA Unila')

@section('content')
    <div class="mb-6 flex flex-wrap justify-between items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Dashboard Admin</h1>
            <p class="text-sm text-gray-500">Ringkasan aktivitas dan pemantauan statistik pelayanan informasi publik</p>
        </div>
    </div>

    <!-- BANNER NOTIFIKASI TINDAK LANJUT ADMIN (Eye-Catching & Pulsating Attention Alert) -->
    @if($pengajuanBaru > 0 || $pengajuanDiproses > 0)
        <a href="{{ url('/admin/pengajuan') }}"
           class="mb-8 relative bg-amber-50 border-2 border-amber-400 hover:border-amber-600 p-4.5 sm:p-5 flex items-center gap-4 transition-all block group cursor-pointer shadow-md hover:shadow-lg animate-pulse">
            <!-- Pulsating Warning Icon Badge with Radar Beacon -->
            <div class="relative flex items-center justify-center shrink-0">
                <span class="animate-ping absolute inline-flex h-10 w-10 bg-amber-400 opacity-75"></span>
                <div class="w-10 h-10 bg-amber-600 text-white flex items-center justify-center text-lg font-black shadow-md relative z-10">
                    <i class="fa-solid fa-bell text-base animate-pulse"></i>
                </div>
            </div>

            <!-- Text Alert with Underlined Numbers -->
            <div>
                <span class="text-xs font-extrabold uppercase tracking-widest text-amber-800 block mb-0.5 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
                    Perhatian Perlu Tindak Lanjut
                </span>
                <span class="text-base sm:text-lg font-extrabold text-amber-950 group-hover:text-amber-900 tracking-tight leading-snug">
                    @if($pengajuanBaru > 0 && $pengajuanDiproses > 0)
                        Terdapat <span class="underline decoration-red-500 font-black text-red-700">{{ $pengajuanBaru }} pengajuan baru</span> yang belum diproses & <span class="underline decoration-amber-600 font-black text-amber-900">{{ $pengajuanDiproses }} pengajuan</span> sedang diproses.
                    @elseif($pengajuanBaru > 0)
                        Terdapat <span class="underline decoration-red-500 font-black text-red-700">{{ $pengajuanBaru }} pengajuan baru</span> yang belum diproses.
                    @else
                        Terdapat <span class="underline decoration-amber-600 font-black text-amber-900">{{ $pengajuanDiproses }} pengajuan</span> dengan status sedang diproses yang belum diberikan hasil akhir.
                    @endif
                </span>
            </div>
        </a>
    @endif

    <!-- Statistik Grid (4 Cards Siakad Style - Kompak & Siku 90 Deg) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <!-- 1. Total Informasi Publik -->
        <div class="relative bg-[#0d9488] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalInformasi }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Total Informasi Publik</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-folder-open"></i>
            </div>
        </div>

        <!-- 2. Total Pengajuan -->
        <div class="relative bg-[#2C3E50] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalPengajuan }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Total Seluruh Pengajuan</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-inbox"></i>
            </div>
        </div>

        <!-- 3. Total Permohonan Informasi -->
        <a href="{{ url('/admin/pengajuan?jenis=Permohonan') }}" class="relative bg-[#2563EB] hover:bg-[#1D4ED8] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px] transition-colors block cursor-pointer group">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalPermohonan }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Permohonan Informasi</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 group-hover:scale-110 transition-transform select-none pointer-events-none">
                <i class="fa-solid fa-file-signature"></i>
            </div>
        </a>

        <!-- 4. Total Pengajuan Keberatan -->
        <a href="{{ url('/admin/pengajuan?jenis=Keberatan') }}" class="relative bg-[#d97706] hover:bg-[#b45309] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px] transition-colors block cursor-pointer group">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalKeberatan }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Pengajuan Keberatan</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 group-hover:scale-110 transition-transform select-none pointer-events-none">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </a>

    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">

        <!-- Bar Chart (Interactive Drill-down & Filter) -->
        <div class="lg:col-span-8 bg-white p-6 sm:p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div class="flex flex-wrap justify-between items-center gap-3 mb-4 pb-4 border-b border-slate-100">
                <div>
                    <h2 id="chart-main-title" class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-[#1B365D]"></i> Statistik Layanan Informasi
                    </h2>
                    <p id="chart-sub-title" class="text-xs text-slate-400">Statistik permohonan & keberatan per tahun</p>
                </div>

                <!-- Control Filters (Tahun & Mode Switcher) -->
                <div class="flex items-center gap-2">
                    <select id="chartYearFilter" class="px-3 py-1.5 bg-slate-50 border border-slate-300 text-xs font-bold text-slate-700 outline-none focus:border-[#1B365D] cursor-pointer">
                        @foreach(array_keys($monthlyData) as $y)
                            <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>Tahun {{ $y }}</option>
                        @endforeach
                    </select>

                    <div class="inline-flex border border-slate-300 p-0.5 bg-slate-50">
                        <button type="button" id="btnModeYear" onclick="switchChartMode('yearly')" class="px-3 py-1 text-xs font-bold bg-[#1B365D] text-white transition">
                            Tahunan
                        </button>
                        <button type="button" id="btnModeMonth" onclick="switchChartMode('monthly')" class="px-3 py-1 text-xs font-bold text-slate-600 hover:text-slate-900 transition">
                            Bulanan
                        </button>
                    </div>
                </div>
            </div>

            <div class="relative w-full h-72">
                <canvas id="statistikBarChart"></canvas>
            </div>
        </div>

        <!-- Persentase Penyelesaian (Authentic Siakad Executive Card) -->
        <div class="lg:col-span-4 bg-white p-6 sm:p-7 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-[#00a65a]"></i> Penyelesaian Layanan
                    </h2>
                    <span class="px-2.5 py-0.5 bg-emerald-50 text-[#00a65a] border border-emerald-200 text-[11px] font-bold">
                        {{ $completionRate }}% Tuntas
                    </span>
                </div>

                <!-- Donut Canvas dengan Center Overlay -->
                <div class="relative w-full h-44 mb-4">
                    <canvas id="statusChart"></canvas>
                </div>

                <!-- Breakdown Progress Bars Per Status (Authentic Human Design) -->
                <div class="space-y-3 pt-2">
                    @php
                        $totalCount = max($totalPengajuanAll, 1);
                        $diterimaPct = round(($statusCounts['DITERIMA'] / $totalCount) * 100);
                        $diprosesPct = round(($statusCounts['DIPROSES'] / $totalCount) * 100);
                        $diajukanPct = round(($statusCounts['DIAJUKAN'] / $totalCount) * 100);
                        $ditolakPct  = round(($statusCounts['DITOLAK']  / $totalCount) * 100);
                    @endphp

                    <!-- Diterima -->
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 bg-[#00a65a] inline-block"></span> Diterima</span>
                            <span>{{ $statusCounts['DITERIMA'] }} <span class="text-slate-400 font-normal">({{ $diterimaPct }}%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 overflow-hidden">
                            <div class="bg-[#00a65a] h-2 transition-all duration-500" style="width: {{ $diterimaPct }}%"></div>
                        </div>
                    </div>

                    <!-- Diproses -->
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 bg-[#f39c12] inline-block"></span> Diproses</span>
                            <span>{{ $statusCounts['DIPROSES'] }} <span class="text-slate-400 font-normal">({{ $diprosesPct }}%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 overflow-hidden">
                            <div class="bg-[#f39c12] h-2 transition-all duration-500" style="width: {{ $diprosesPct }}%"></div>
                        </div>
                    </div>

                    <!-- Diajukan -->
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 bg-[#1B365D] inline-block"></span> Diajukan</span>
                            <span>{{ $statusCounts['DIAJUKAN'] }} <span class="text-slate-400 font-normal">({{ $diajukanPct }}%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 overflow-hidden">
                            <div class="bg-[#1B365D] h-2 transition-all duration-500" style="width: {{ $diajukanPct }}%"></div>
                        </div>
                    </div>

                    <!-- Ditolak -->
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 bg-[#dd4b39] inline-block"></span> Ditolak</span>
                            <span>{{ $statusCounts['DITOLAK'] }} <span class="text-slate-400 font-normal">({{ $ditolakPct }}%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 overflow-hidden">
                            <div class="bg-[#dd4b39] h-2 transition-all duration-500" style="width: {{ $ditolakPct }}%"></div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 text-center mt-3">
                <a href="{{ url('/admin/pengajuan') }}" class="text-xs font-bold text-[#1B365D] hover:underline inline-flex items-center gap-1">
                    Kelola Seluruh Pengajuan <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Section Bawah: Pengajuan Terbaru & Akses Cepat Admin -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Tabel Pengajuan Terbaru (8 cols) -->
        <div class="lg:col-span-8 bg-white border border-slate-200 shadow-sm">

            <!-- Card Header -->
            <div class="p-5 border-b border-slate-100 flex flex-wrap justify-between items-center gap-4 bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#1B365D]/10 text-[#1B365D] flex items-center justify-center font-bold">
                        <i class="fa-solid fa-clock-rotate-left text-base"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Pengajuan Terbaru</h2>
                        <p class="text-xs text-slate-500">5 transaksi pelayanan permohonan & keberatan terakhir</p>
                    </div>
                </div>
                <a href="{{ url('/admin/pengajuan') }}" class="px-4 py-2 bg-[#1B365D] hover:bg-[#066787] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-list-check"></i> Kelola Semua Pengajuan
                </a>
            </div>

            <!-- Table Body -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-100/80 text-slate-700 uppercase font-bold border-b border-slate-200">
                            <th class="py-3.5 px-4">No. Tiket</th>
                            <th class="py-3.5 px-4">Pemohon</th>
                            <th class="py-3.5 px-4">Layanan</th>
                            <th class="py-3.5 px-4">Tanggal</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                        @forelse($recentPengajuan as $p)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-4 font-bold text-[#1B365D]">
                                    #{{ $p->nomor_tiket ?? $p->id }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-900">{{ $p->nama_pemohon ?? ($p->user->name ?? '-') }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $p->pekerjaan ?? ($p->user->email ?? '-') }}</div>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($p->jenis_layanan == 'Keberatan')
                                        <span class="px-2 py-1 bg-amber-50 text-amber-700 font-bold border border-amber-200 inline-block text-[11px]">
                                            <i class="fa-solid fa-triangle-exclamation mr-1"></i> Keberatan
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-cyan-50 text-[#1B365D] font-bold border border-cyan-200 inline-block text-[11px]">
                                            <i class="fa-solid fa-file-lines mr-1"></i> Permohonan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">
                                    {{ $p->created_at ? $p->created_at->translatedFormat('j F Y') : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @php
                                        $st = strtoupper($p->status ?? 'DIAJUKAN');
                                        $bgMap = [
                                            'DIAJUKAN'  => 'bg-slate-100 text-slate-700 border-slate-200',
                                            'DIPROSES'  => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'PERBAIKAN' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'DITERIMA'  => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            'DITOLAK'   => 'bg-rose-100 text-rose-700 border-rose-200',
                                        ];
                                        $cls = $bgMap[$st] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                    @endphp
                                    <span class="px-2.5 py-1 text-[11px] font-bold border inline-block uppercase {{ $cls }}">
                                        {{ $st }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    <a href="{{ url('/admin/pengajuan/'.$p->id) }}" class="px-3 py-1.5 bg-[#1B365D] hover:bg-[#1B365D] text-white font-bold text-[11px] inline-flex items-center gap-1 transition">
                                        Detail <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-semibold">
                                    Belum ada data pengajuan terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column: Akses Cepat Admin & Monitoring Status (4 cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Box Akses Cepat -->
            <div class="bg-white border border-slate-200 shadow-sm p-6">
                <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-[#1B365D]"></i> Akses Cepat Admin
                </h3>
                <div class="space-y-3">
                    <a href="{{ url('/admin/informasi-publik') }}" class="flex items-center justify-between p-3.5 bg-slate-50 hover:bg-[#1B365D]/5 border border-slate-200 hover:border-[#1B365D]/30 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-[#1B365D] text-white flex items-center justify-center font-bold text-sm">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-800 group-hover:text-[#1B365D]">Tambah Informasi Publik</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-[#1B365D]"></i>
                    </a>

                    <a href="{{ url('/admin/pengajuan?status=DIAJUKAN') }}" class="flex items-center justify-between p-3.5 bg-slate-50 hover:bg-amber-500/5 border border-slate-200 hover:border-amber-500/30 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-[#f39c12] text-white flex items-center justify-center font-bold text-sm">
                                <i class="fa-solid fa-bell"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-800 group-hover:text-[#f39c12]">Verifikasi Pengajuan Baru ({{ $pengajuanBaru }})</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-[#f39c12]"></i>
                    </a>

                    <a href="{{ url('/admin/pengajuan?status=DIPROSES') }}" class="flex items-center justify-between p-3.5 bg-slate-50 hover:bg-rose-500/5 border border-slate-200 hover:border-rose-500/30 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-[#dd4b39] text-white flex items-center justify-center font-bold text-sm">
                                <i class="fa-solid fa-gears"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-800 group-hover:text-[#dd4b39]">Proses Pengajuan ({{ $pengajuanDiproses }})</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-[#dd4b39]"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const yearlyData = {!! json_encode($yearlyData) !!};
    const monthlyData = {!! json_encode($monthlyData) !!};
    const statusCounts = {!! json_encode($statusCounts) !!};

    const ctx = document.getElementById('statistikBarChart').getContext('2d');
    const yearSelect = document.getElementById('chartYearFilter');
    const btnYear = document.getElementById('btnModeYear');
    const btnMonth = document.getElementById('btnModeMonth');
    const chartMainTitle = document.getElementById('chart-main-title');
    const chartSubTitle = document.getElementById('chart-sub-title');

    let currentMode = 'yearly';

    // Bar Chart Modern (Siakad Style)
    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(yearlyData),
            datasets: [
                { label: 'Permohonan', data: Object.values(yearlyData).map(v => v.permohonan), backgroundColor: '#1B365D', borderRadius: 0, barPercentage: 0.65 },
                { label: 'Keberatan', data: Object.values(yearlyData).map(v => v.keberatan), backgroundColor: '#f39c12', borderRadius: 0, barPercentage: 0.65 },
                { label: 'Diterima', data: Object.values(yearlyData).map(v => v.diterima), backgroundColor: '#00a65a', borderRadius: 0, barPercentage: 0.65 },
                { label: 'Ditolak', data: Object.values(yearlyData).map(v => v.ditolak), backgroundColor: '#dd4b39', borderRadius: 0, barPercentage: 0.65 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 600, easing: 'easeInOutQuart' },
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'rect',
                        padding: 16,
                        font: { family: 'Poppins', size: 12, weight: '600' }
                    }
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Poppins', size: 13, weight: 'bold' },
                    bodyFont: { family: 'Poppins', size: 12 },
                    padding: 12,
                    cornerRadius: 0
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Poppins', size: 12, weight: '600' } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: { stepSize: 1, font: { family: 'Poppins', size: 12 } }
                }
            },
            onClick: (e, elements) => {
                if (currentMode === 'yearly' && elements.length > 0) {
                    const year = chart.data.labels[elements[0].index];
                    if (monthlyData[year]) {
                        yearSelect.value = year;
                        switchChartMode('monthly', year);
                    }
                }
            }
        }
    });

    // Function Mode Switcher (Tahunan vs Bulanan)
    window.switchChartMode = function(mode, selectedYear = null) {
        currentMode = mode;
        const targetYear = selectedYear || yearSelect.value || new Date().getFullYear();

        if (mode === 'monthly') {
            btnMonth.className = "px-3 py-1 text-xs font-bold bg-[#1B365D] text-white transition";
            btnYear.className = "px-3 py-1 text-xs font-bold text-slate-600 hover:text-slate-900 transition";

            chartMainTitle.innerHTML = `<i class="fa-solid fa-chart-column text-[#1B365D]"></i> Rincian Bulanan (Tahun ${targetYear})`;
            chartSubTitle.innerText = "Grafik distribusi statistik per bulan Jan - Des";

            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const dataYear = monthlyData[targetYear] || {};

            chart.data.labels = months;
            chart.data.datasets[0].data = Object.values(dataYear).map(v => v ? v.permohonan : 0);
            chart.data.datasets[1].data = Object.values(dataYear).map(v => v ? v.keberatan : 0);
            chart.data.datasets[2].data = Object.values(dataYear).map(v => v ? v.diterima : 0);
            chart.data.datasets[3].data = Object.values(dataYear).map(v => v ? v.ditolak : 0);
        } else {
            btnYear.className = "px-3 py-1 text-xs font-bold bg-[#1B365D] text-white transition";
            btnMonth.className = "px-3 py-1 text-xs font-bold text-slate-600 hover:text-slate-900 transition";

            chartMainTitle.innerHTML = `<i class="fa-solid fa-chart-column text-[#1B365D]"></i> Statistik Layanan Informasi`;
            chartSubTitle.innerText = "Statistik permohonan & keberatan per tahun";

            chart.data.labels = Object.keys(yearlyData);
            chart.data.datasets[0].data = Object.values(yearlyData).map(v => v.permohonan);
            chart.data.datasets[1].data = Object.values(yearlyData).map(v => v.keberatan);
            chart.data.datasets[2].data = Object.values(yearlyData).map(v => v.diterima);
            chart.data.datasets[3].data = Object.values(yearlyData).map(v => v.ditolak);
        }

        chart.update();
    };

    // Filter Dropdown Change
    yearSelect.addEventListener('change', function() {
        if (currentMode === 'monthly') {
            switchChartMode('monthly', this.value);
        }
    });

    // Plugin Text di Tengah Donut Chart
    const centerTextPlugin = {
        id: 'centerText',
        beforeDraw(chart) {
            const { width, height, ctx } = chart;
            ctx.restore();
            const total = statusCounts.DIAJUKAN + statusCounts.DIPROSES + statusCounts.DITERIMA + statusCounts.DITOLAK;

            ctx.font = "bold 22px Poppins";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "#1e293b";

            const text = total.toString();
            const textX = Math.round((width - ctx.measureText(text).width) / 2);
            const textY = height / 2 - 8;
            ctx.fillText(text, textX, textY);

            ctx.font = "600 10px Poppins";
            ctx.fillStyle = "#94a3b8";
            const subtext = "TOTAL PENGAJUAN";
            const subtextX = Math.round((width - ctx.measureText(subtext).width) / 2);
            const subtextY = height / 2 + 12;
            ctx.fillText(subtext, subtextX, subtextY);

            ctx.save();
        }
    };

    // Donut Chart Status Penyelesaian
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Diajukan', 'Diproses', 'Diterima', 'Ditolak'],
            datasets: [{
                data: [
                    statusCounts.DIAJUKAN,
                    statusCounts.DIPROSES,
                    statusCounts.DITERIMA,
                    statusCounts.DITOLAK
                ],
                backgroundColor: ['#1B365D', '#f39c12', '#00a65a', '#dd4b39'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4,
                cutout: '74%'
            }]
        },
        plugins: [centerTextPlugin],
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { family: 'Poppins', size: 12, weight: 'bold' },
                    bodyFont: { family: 'Poppins', size: 11 },
                    cornerRadius: 0
                }
            }
        }
    });
</script>
@endpush
