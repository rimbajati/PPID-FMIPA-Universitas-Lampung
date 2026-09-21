@extends('components.layouts.admin')

@section('title', 'Statistik Layanan - Admin PPID')
@section('header_title', 'Statistik Layanan')

@section('content')
<div class="space-y-6">

    <!-- Section Header: Judul, Subjudul & Tombol Export -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Statistik Layanan</h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">Laporan dan tren permohonan informasi publik PPID FMIPA Universitas Lampung</p>
        </div>

        <!-- Tombol Export Rekapitulasi Layanan -->
        <div class="relative shrink-0" x-data="{ openExport: false }">
            <button type="button" @click="openExport = !openExport" @click.away="openExport = false"
                    class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                <i class="fa-solid fa-file-export text-slate-500"></i>
                <span>Export Laporan</span>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': openExport }"></i>
            </button>

            <div x-show="openExport" x-cloak 
                 class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-slate-100 py-1.5 z-30 animate-in fade-in zoom-in-95 duration-150">
                <div class="px-3.5 py-1.5 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Pilih Format Laporan</div>
                <a href="{{ route('admin.export.statistik.excel', ['tahun' => date('Y')]) }}" 
                   class="flex items-center gap-2.5 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 transition-colors">
                    <i class="fa-solid fa-file-excel text-emerald-600 w-4 text-center"></i>
                    <span>Export Excel (.csv)</span>
                </a>
                <a href="{{ route('admin.export.statistik.pdf', ['tahun' => date('Y')]) }}" target="_blank"
                   class="flex items-center gap-2.5 px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-rose-50 hover:text-rose-700 transition-colors">
                    <i class="fa-solid fa-file-pdf text-rose-600 w-4 text-center"></i>
                    <span>Cetak / Simpan PDF</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 6 Summary Overview Cards (Selaras dengan Tema Admin PPID) -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3">
        <!-- Card 1: Total Layanan (Sky Blue) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-3.5 sm:p-4 flex justify-between items-center min-h-[80px]">
                <div>
                    <span class="text-2xl sm:text-3xl font-black block tracking-tight text-[#0284c7]">{{ $totalPermohonan + $totalKeberatan }}</span>
                    <p class="text-[11px] font-extrabold text-slate-500 mt-0.5">Total Layanan</p>
                </div>
                <div class="text-[#0284c7]/80">
                    <i class="fa-solid fa-layer-group text-2xl sm:text-3xl"></i>
                </div>
            </div>
            <div class="bg-[#0284c7] text-white text-[10px] sm:text-[11px] font-bold px-3 py-1 flex items-center justify-between">
                <span class="truncate">Tiket Tercatat</span>
                <i class="fa-solid fa-ticket-simple text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 2: Permohonan Masuk (Biru Royal Vivid) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-3.5 sm:p-4 flex justify-between items-center min-h-[80px]">
                <div>
                    <span class="text-2xl sm:text-3xl font-black block tracking-tight text-[#2563eb]">{{ $totalPermohonan }}</span>
                    <p class="text-[11px] font-extrabold text-slate-500 mt-0.5">Permohonan</p>
                </div>
                <div class="text-[#2563eb]/80">
                    <i class="fa-regular fa-file-lines text-2xl sm:text-3xl"></i>
                </div>
            </div>
            <div class="bg-[#2563eb] text-white text-[10px] sm:text-[11px] font-bold px-3 py-1 flex items-center justify-between">
                <span class="truncate">Permintaan Masuk</span>
                <i class="fa-solid fa-inbox text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 3: Permohonan Selesai (Hijau Emerald) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-3.5 sm:p-4 flex justify-between items-center min-h-[80px]">
                <div>
                    <span class="text-2xl sm:text-3xl font-black block tracking-tight text-[#059669]">{{ $totalPermohonanSelesai }}</span>
                    <p class="text-[11px] font-extrabold text-slate-500 mt-0.5">Permohonan Selesai</p>
                </div>
                <div class="text-[#059669]/80">
                    <i class="fa-regular fa-circle-check text-2xl sm:text-3xl"></i>
                </div>
            </div>
            <div class="bg-[#059669] text-white text-[10px] sm:text-[11px] font-bold px-3 py-1 flex items-center justify-between">
                <span class="truncate">Telah Dipenuhi</span>
                <i class="fa-solid fa-check text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 4: Permohonan Ditolak (Merah Rose) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-3.5 sm:p-4 flex justify-between items-center min-h-[80px]">
                <div>
                    <span class="text-2xl sm:text-3xl font-black block tracking-tight text-[#e11d48]">{{ $totalPermohonanDitolak }}</span>
                    <p class="text-[11px] font-extrabold text-slate-500 mt-0.5">Permohonan Ditolak</p>
                </div>
                <div class="text-[#e11d48]/80">
                    <i class="fa-regular fa-circle-xmark text-2xl sm:text-3xl"></i>
                </div>
            </div>
            <div class="bg-[#e11d48] text-white text-[10px] sm:text-[11px] font-bold px-3 py-1 flex items-center justify-between">
                <span class="truncate">Dikecualikan</span>
                <i class="fa-solid fa-xmark text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 5: Pengajuan Keberatan (Amber / Warning) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-3.5 sm:p-4 flex justify-between items-center min-h-[80px]">
                <div>
                    <span class="text-2xl sm:text-3xl font-black block tracking-tight text-[#d97706]">{{ $totalKeberatan }}</span>
                    <p class="text-[11px] font-extrabold text-slate-500 mt-0.5">Pengajuan Keberatan</p>
                </div>
                <div class="text-[#d97706]/80">
                    <i class="fa-solid fa-scale-balanced text-2xl sm:text-3xl"></i>
                </div>
            </div>
            <div class="bg-[#d97706] text-white text-[10px] sm:text-[11px] font-bold px-3 py-1 flex items-center justify-between">
                <span class="truncate">Berkas Keberatan</span>
                <i class="fa-solid fa-triangle-exclamation text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>

        <!-- Card 6: Waktu Respon (Indigo / Slate) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-3.5 sm:p-4 flex justify-between items-center min-h-[80px]">
                <div>
                    <span class="text-2xl sm:text-3xl font-black block tracking-tight text-[#4f46e5]">{{ $rataRataWaktuTeks ?? '1 Hari' }}</span>
                    <p class="text-[11px] font-extrabold text-slate-500 mt-0.5">Waktu Respon</p>
                </div>
                <div class="text-[#4f46e5]/80">
                    <i class="fa-solid fa-bolt text-2xl sm:text-3xl"></i>
                </div>
            </div>
            <div class="bg-[#4f46e5] text-white text-[10px] sm:text-[11px] font-bold px-3 py-1 flex items-center justify-between">
                <span class="truncate">Rata-rata Layanan</span>
                <i class="fa-solid fa-clock-rotate-left text-[10px] shrink-0 ml-1"></i>
            </div>
        </div>
    </div>

    <!-- MAIN CHART CARD: Grafis Tren Permohonan & Keberatan (Clean Centered Style) -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-md transition-all p-6 sm:p-7 space-y-4">
        
        <!-- Header Grafik (Centered Clean) -->
        <div class="relative flex items-center justify-center">
            <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight text-center">
                Tren Permohonan & Keberatan Layanan
            </h2>
        </div>

        <!-- Canvas Grafik Utama (Satuan rem) -->
        <div class="relative h-[20rem] sm:h-[22.5rem] w-full pt-2">
            <canvas id="chartLaporanAdmin"></canvas>
        </div>

        <!-- Legend & Footer Controls (Clean Minimalist Style) -->
        <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <!-- Clean Horizontal Legend -->
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-5 gap-y-2 font-semibold text-slate-700">
                <div class="inline-flex items-center gap-2 cursor-default whitespace-nowrap">
                    <span class="w-2.5 h-2.5 rounded-xs shrink-0 bg-[#2563eb]"></span>
                    <span class="leading-none">Permohonan</span>
                </div>
                <div class="inline-flex items-center gap-2 cursor-default whitespace-nowrap">
                    <span class="w-2.5 h-2.5 rounded-xs shrink-0 bg-[#059669]"></span>
                    <span class="leading-none">Selesai</span>
                </div>
                <div class="inline-flex items-center gap-2 cursor-default whitespace-nowrap">
                    <span class="w-2.5 h-2.5 rounded-xs shrink-0 bg-[#e11d48]"></span>
                    <span class="leading-none">Ditolak</span>
                </div>
                <div class="inline-flex items-center gap-2 cursor-default whitespace-nowrap">
                    <span class="w-2.5 h-2.5 rounded-xs shrink-0 bg-[#f59e0b]"></span>
                    <span class="leading-none">Keberatan</span>
                </div>
            </div>

            <!-- Bagian Kanan Footer: Petunjuk Klik Saat Mode Tahun ATAU Tombol Kembali & Info Saat Mode Rincian Bulan -->
            <div class="flex items-center">
                <!-- Hint Klik Interaktif (Tampil saat mode tahun) -->
                <div id="hintKlikTahunAdmin" class="inline-flex items-center gap-1.5 font-medium text-slate-400 text-[11px]">
                    <i class="fa-solid fa-circle-info text-sky-500 text-xs"></i>
                    <span>Klik batang tahun pada grafik untuk me-drilldown per bulan</span>
                </div>

                <!-- Indicator & Button Toggle Back (Mode Rincian Bulanan di Bawah) -->
                <div id="containerModeBulanAdmin" class="hidden items-center gap-2.5 bg-sky-50 px-3 py-1.5 rounded-xl border border-sky-100 shadow-2xs">
                    <div class="flex items-center gap-1.5 text-xs font-bold text-slate-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Rincian: <span id="labelTahunAktifAdmin" class="text-sky-600 font-extrabold">Tahun {{ date('Y') }}</span></span>
                    </div>
                    <button type="button" 
                            onclick="kembaliKeTahunanAdmin()" 
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-lg transition-all shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali</span>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- SECTION DIAGRAM DONAT (1 BARIS DENGAN 3 KOLOM, SATUAN REM, & DESAIN CLEAN) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- 1. Kategori Pemohon Informasi -->
        <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-md transition-all flex flex-col items-center justify-between">
            <!-- Centered Header -->
            <div class="text-center mb-4">
                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Kategori Pemohon Informasi</h3>
            </div>

            <!-- Centered Doughnut Chart (Satuan rem) -->
            <div class="relative w-[13rem] h-[13rem] sm:w-[14.5rem] sm:h-[14.5rem] shrink-0 flex items-center justify-center my-auto">
                <canvas id="chartDonutPemohon"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                    <span class="text-3xl sm:text-4xl font-black text-slate-900 leading-none tracking-tight">
                        {{ array_sum($statPemohon) }}
                    </span>
                    <span class="text-xs font-semibold text-slate-400 mt-1">Total</span>
                </div>
            </div>

            <!-- Clean Bottom Legend (Sejajar ke Kanan / Horizontal Wrap) -->
            <div id="legendDonutPemohon" class="w-full flex flex-row flex-wrap items-center justify-center gap-x-5 gap-y-2.5 mt-5 pt-4 border-t border-slate-100 text-xs font-medium text-slate-700"></div>
        </div>

        <!-- 2. Cara Memperoleh Informasi -->
        <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-md transition-all flex flex-col items-center justify-between">
            <!-- Centered Header -->
            <div class="text-center mb-4">
                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Cara Memperoleh Informasi</h3>
            </div>

            <!-- Centered Doughnut Chart (Satuan rem) -->
            <div class="relative w-[13rem] h-[13rem] sm:w-[14.5rem] sm:h-[14.5rem] shrink-0 flex items-center justify-center my-auto">
                <canvas id="chartDonutCara"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                    <span class="text-3xl sm:text-4xl font-black text-slate-900 leading-none tracking-tight">
                        {{ array_sum($statCara) }}
                    </span>
                    <span class="text-xs font-semibold text-slate-400 mt-1">Total</span>
                </div>
            </div>

            <!-- Clean Bottom Legend (Sejajar ke Kanan / Horizontal Wrap) -->
            <div id="legendDonutCara" class="w-full flex flex-row flex-wrap items-center justify-center gap-x-5 gap-y-2.5 mt-5 pt-4 border-t border-slate-100 text-xs font-medium text-slate-700"></div>
        </div>

        <!-- 3. Alasan Pengajuan Keberatan -->
        <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-2xs hover:shadow-md transition-all flex flex-col items-center justify-between">
            <!-- Centered Header -->
            <div class="text-center mb-4">
                <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">Alasan Pengajuan Keberatan</h3>
            </div>

            <!-- Centered Doughnut Chart (Satuan rem) -->
            <div class="relative w-[13rem] h-[13rem] sm:w-[14.5rem] sm:h-[14.5rem] shrink-0 flex items-center justify-center my-auto">
                <canvas id="chartDonutKeberatan"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                    <span class="text-3xl sm:text-4xl font-black text-slate-900 leading-none tracking-tight">
                        {{ array_sum($statAlasanKeberatan) }}
                    </span>
                    <span class="text-xs font-semibold text-slate-400 mt-1">Total</span>
                </div>
            </div>

            <!-- Clean Bottom Legend (Sejajar ke Kanan / Horizontal Wrap) -->
            <div id="legendDonutKeberatan" class="w-full flex flex-row flex-wrap items-center justify-center gap-x-5 gap-y-2.5 mt-5 pt-4 border-t border-slate-100 text-xs font-medium text-slate-700"></div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartLaporanAdmin');
    if (!ctx) return;

    // Dataset Tahunan
    const dataTahunan = {
        title: 'Tren Tahunan Layanan',
        badge: '{{ $chartTahunan['years'][0] ?? 2022 }} - {{ end($chartTahunan['years']) ?: 2026 }}',
        labels: @json($chartTahunan['years']),
        permintaan: @json($chartTahunan['permintaan']),
        disetujui: @json($chartTahunan['disetujui']),
        ditolak: @json($chartTahunan['ditolak']),
        keberatan: @json($chartTahunan['keberatan']),
    };

    // Dataset Bulanan untuk Setiap Tahun (Drill-Down Interaktif)
    const dataBulananPerTahun = @json($chartBulananPerTahun);
    let selectedYearForMonth = {{ $chartBulanan['year'] ?? date('Y') }};

    function calculateDynamicMax(permintaan, disetujui, ditolak, keberatan) {
        const allValues = [...permintaan, ...disetujui, ...ditolak, ...keberatan];
        const peakValue = Math.max(0, ...allValues);
        return Math.max(10, Math.ceil((peakValue === 0 ? 1 : peakValue) / 10) * 10);
    }

    let currentMode = 'tahun';
    const currentDynamicMax = calculateDynamicMax(dataTahunan.permintaan, dataTahunan.disetujui, dataTahunan.ditolak, dataTahunan.keberatan);

    // Fungsi pembuat gradien warna bar chart
    const chartContext = ctx.getContext('2d');
    
    // Gradien Warna untuk Datasets
    const gradBlue = chartContext.createLinearGradient(0, 0, 0, 350);
    gradBlue.addColorStop(0, '#3b82f6');
    gradBlue.addColorStop(1, '#1d4ed8');

    const gradGreen = chartContext.createLinearGradient(0, 0, 0, 350);
    gradGreen.addColorStop(0, '#10b981');
    gradGreen.addColorStop(1, '#047857');

    const gradRed = chartContext.createLinearGradient(0, 0, 0, 350);
    gradRed.addColorStop(0, '#f43f5e');
    gradRed.addColorStop(1, '#be123c');

    const gradAmber = chartContext.createLinearGradient(0, 0, 0, 350);
    gradAmber.addColorStop(0, '#fbbf24');
    gradAmber.addColorStop(1, '#d97706');

    const chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dataTahunan.labels,
            datasets: [
                {
                    label: 'Permohonan',
                    data: dataTahunan.permintaan,
                    backgroundColor: gradBlue,
                    hoverBackgroundColor: '#2563eb',
                    borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 },
                    borderSkipped: false,
                    barPercentage: 0.75,
                    categoryPercentage: 0.7
                },
                {
                    label: 'Selesai',
                    data: dataTahunan.disetujui,
                    backgroundColor: gradGreen,
                    hoverBackgroundColor: '#059669',
                    borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 },
                    borderSkipped: false,
                    barPercentage: 0.75,
                    categoryPercentage: 0.7
                },
                {
                    label: 'Ditolak',
                    data: dataTahunan.ditolak,
                    backgroundColor: gradRed,
                    hoverBackgroundColor: '#e11d48',
                    borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 },
                    borderSkipped: false,
                    barPercentage: 0.75,
                    categoryPercentage: 0.7
                },
                {
                    label: 'Keberatan',
                    data: dataTahunan.keberatan,
                    backgroundColor: gradAmber,
                    hoverBackgroundColor: '#f59e0b',
                    borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 },
                    borderSkipped: false,
                    barPercentage: 0.75,
                    categoryPercentage: 0.7
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 600,
                easing: 'easeOutQuart'
            },
            onHover: function(evt, elements) {
                if (currentMode === 'tahun') {
                    const pts = chartInstance.getElementsAtEventForMode(evt, 'index', { intersect: false }, false);
                    ctx.style.cursor = (pts.length > 0) ? 'pointer' : 'default';
                } else {
                    ctx.style.cursor = 'default';
                }
            },
            onClick: function(evt) {
                if (currentMode !== 'tahun') return;
                
                const points = chartInstance.getElementsAtEventForMode(evt, 'index', { intersect: false }, false);
                if (points.length > 0) {
                    const clickedIndex = points[0].index;
                    const clickedYear = dataTahunan.labels[clickedIndex];
                    if (clickedYear) {
                        bukaGrafikBulanAdmin(clickedYear);
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    padding: 12,
                    cornerRadius: 10,
                    boxPadding: 4,
                    usePointStyle: true,
                    titleFont: { size: 13, weight: 'bold', family: 'Plus Jakarta Sans' },
                    bodyFont: { size: 12, family: 'Plus Jakarta Sans' },
                    callbacks: {
                        title: function(tooltipItems) {
                            if (!tooltipItems || tooltipItems.length === 0) return '';
                            const item = tooltipItems[0];
                            const label = item.label;
                            if (currentMode === 'bulan') {
                                const namaBulanLengkap = {
                                    'Jan': 'Januari', 'Feb': 'Februari', 'Mar': 'Maret',
                                    'Apr': 'April', 'Mei': 'Mei', 'Jun': 'Juni',
                                    'Jul': 'Juli', 'Agu': 'Agustus', 'Sep': 'September',
                                    'Okt': 'Oktober', 'Nov': 'November', 'Des': 'Desember'
                                };
                                const bulanLengkap = namaBulanLengkap[label] || label;
                                return selectedYearForMonth ? `${bulanLengkap} ${selectedYearForMonth}` : bulanLengkap;
                            }
                            return `Tahun ${label}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: currentDynamicMax,
                    ticks: {
                        stepSize: 10,
                        precision: 0,
                        color: '#64748b',
                        font: { size: 11, weight: '600', family: 'Plus Jakarta Sans' }
                    },
                    grid: {
                        color: '#e2e8f0',
                        drawBorder: false,
                        lineWidth: 1
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    offset: true,
                    ticks: {
                        color: '#334155',
                        font: { size: 12, weight: 'bold', family: 'Plus Jakarta Sans' },
                        padding: 8
                    },
                    grid: {
                        display: true,
                        offset: true,
                        color: '#e2e8f0',
                        drawTicks: false,
                        lineWidth: 1
                    },
                    border: {
                        color: '#cbd5e1'
                    }
                }
            }
        }
    });

    const containerBulan = document.getElementById('containerModeBulanAdmin');
    const labelTahunAktif = document.getElementById('labelTahunAktifAdmin');
    const defaultMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // Fungsi Ketika Batang Tahun Ditekan -> Berubah Jadi Grafik Bulan di Tahun Tersebut
    window.bukaGrafikBulanAdmin = function(tahun) {
        currentMode = 'bulan';
        selectedYearForMonth = tahun;
        const dataBulanTahun = (dataBulananPerTahun && dataBulananPerTahun[tahun]) ? dataBulananPerTahun[tahun] : {
            months: defaultMonths,
            permintaan: @json($chartBulanan['permintaan'] ?? array_fill(0, 12, 0)),
            disetujui: @json($chartBulanan['disetujui'] ?? array_fill(0, 12, 0)),
            ditolak: @json($chartBulanan['ditolak'] ?? array_fill(0, 12, 0)),
            keberatan: @json($chartBulanan['keberatan'] ?? array_fill(0, 12, 0)),
        };

        const monthLabels = dataBulanTahun.months || dataBulanTahun.labels || defaultMonths;

        // Update Data Grafik ke 12 Bulan
        chartInstance.data.labels = monthLabels;
        chartInstance.data.datasets[0].data = dataBulanTahun.permintaan || [];
        chartInstance.data.datasets[1].data = dataBulanTahun.disetujui || [];
        chartInstance.data.datasets[2].data = dataBulanTahun.ditolak || [];
        chartInstance.data.datasets[3].data = dataBulanTahun.keberatan || [];

        // Dynamic Sumbu Y
        const maxVal = calculateDynamicMax(
            dataBulanTahun.permintaan || [], 
            dataBulanTahun.disetujui || [], 
            dataBulanTahun.ditolak || [], 
            dataBulanTahun.keberatan || []
        );
        chartInstance.options.scales.y.max = maxVal;
        chartInstance.update();

        // Tampilkan Baris Keterangan Mode Bulan dengan Tombol Kembali
        if (containerBulan) {
            if (labelTahunAktif) labelTahunAktif.textContent = 'Tahun ' + tahun;
            containerBulan.classList.remove('hidden');
            containerBulan.classList.add('flex');
        }

        // Sembunyikan Petunjuk Klik Batang saat mode Bulan
        const hintKlik = document.getElementById('hintKlikTahunAdmin');
        if (hintKlik) hintKlik.classList.add('hidden');
    };

    // Fungsi Kembali ke Grafik Tahunan
    window.kembaliKeTahunanAdmin = function() {
        currentMode = 'tahun';

        // Kembalikan Data Grafik ke Tahunan
        chartInstance.data.labels = dataTahunan.labels;
        chartInstance.data.datasets[0].data = dataTahunan.permintaan;
        chartInstance.data.datasets[1].data = dataTahunan.disetujui;
        chartInstance.data.datasets[2].data = dataTahunan.ditolak;
        chartInstance.data.datasets[3].data = dataTahunan.keberatan;

        // Dynamic Sumbu Y
        const maxVal = calculateDynamicMax(dataTahunan.permintaan, dataTahunan.disetujui, dataTahunan.ditolak, dataTahunan.keberatan);
        chartInstance.options.scales.y.max = maxVal;
        chartInstance.update();

        // Sembunyikan Baris Keterangan Mode Bulan
        if (containerBulan) {
            containerBulan.classList.add('hidden');
            containerBulan.classList.remove('flex');
        }

        // Tampilkan kembali Petunjuk Klik Batang saat mode Tahun
        const hintKlik = document.getElementById('hintKlikTahunAdmin');
        if (hintKlik) hintKlik.classList.remove('hidden');
    };

    // ==========================================
    // DIAGRAM DONUT KATEGORI & ANALITIK (PREMIUM MODERN)
    // ==========================================
    function renderCustomLegend(containerId, labels, data, colors) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = '';
        const total = data.reduce((acc, val) => acc + val, 0);

        labels.forEach((label, idx) => {
            const color = colors[idx % colors.length];
            const item = document.createElement('div');
            item.className = 'inline-flex items-center gap-2 text-xs font-semibold text-slate-700 hover:text-slate-900 transition-colors cursor-default whitespace-nowrap';
            item.innerHTML = `
                <span class="w-2.5 h-2.5 rounded-xs shrink-0" style="background-color: ${color}"></span>
                <span class="leading-none">${label}</span>
            `;
            container.appendChild(item);
        });
    }

    // Helper untuk memproses chart doughnut dengan penanganan data kosong (total = 0)
    function createSmartDonutChart(ctx, labels, values, palette) {
        if (!ctx) return;
        const total = values.reduce((acc, v) => acc + v, 0);
        const isDataEmpty = total === 0;

        const displayData = isDataEmpty ? [1] : values;
        const displayColors = isDataEmpty ? ['#f1f5f9'] : palette;
        const displayLabels = isDataEmpty ? ['Belum ada data'] : labels;

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: displayLabels,
                datasets: [{
                    data: displayData,
                    backgroundColor: displayColors,
                    borderWidth: isDataEmpty ? 0 : 2.5,
                    borderColor: '#ffffff',
                    hoverBorderColor: '#ffffff',
                    hoverOffset: isDataEmpty ? 0 : 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                interaction: {
                    mode: 'nearest',
                    intersect: true
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 800
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: !isDataEmpty,
                        position: 'nearest',
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        padding: 10,
                        cornerRadius: 8,
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 11 },
                        displayColors: true,
                        boxPadding: 4,
                        callbacks: {
                            label: function(context) {
                                const val = context.raw || 0;
                                const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                return ` ${val} item (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Donut Kategori Pemohon Informasi
    const ctxPemohon = document.getElementById('chartDonutPemohon');
    if (ctxPemohon) {
        const dataPemohon = @json($statPemohon);
        const labelsPemohon = Object.keys(dataPemohon);
        const valuesPemohon = Object.values(dataPemohon);
        // Palette Kontras Tinggi & Cerah: Sky Blue, Emerald Green, Amber/Orange, Violet, Crimson
        const pemohonColors = ['#0284c7', '#10b981', '#f59e0b', '#8b5cf6', '#e11d48', '#06b6d4'];
        createSmartDonutChart(ctxPemohon, labelsPemohon, valuesPemohon, pemohonColors);
        renderCustomLegend('legendDonutPemohon', labelsPemohon, valuesPemohon, pemohonColors);
    }

    // 3. Donut Cara Memperoleh Informasi
    const ctxCara = document.getElementById('chartDonutCara');
    if (ctxCara) {
        const dataCara = @json($statCara);
        const labelsCara = Object.keys(dataCara);
        const valuesCara = Object.values(dataCara);
        // Palette Kontras: Royal Blue, Amber Gold, Teal Emerald
        const caraColors = ['#2563eb', '#f59e0b', '#059669', '#ec4899'];
        createSmartDonutChart(ctxCara, labelsCara, valuesCara, caraColors);
        renderCustomLegend('legendDonutCara', labelsCara, valuesCara, caraColors);
    }

    // 4. Donut Alasan Pengajuan Keberatan
    const ctxKeberatan = document.getElementById('chartDonutKeberatan');
    if (ctxKeberatan) {
        const dataKeberatan = @json($statAlasanKeberatan);
        const labelsKeberatan = Object.keys(dataKeberatan);
        const valuesKeberatan = Object.values(dataKeberatan);
        // Palette Kontras Tajam Beragam: Rose Red, Electric Blue, Amber Orange, Emerald, Purple, Cyan, Indigo
        const keberatanColors = [
            '#e11d48', '#2563eb', '#f59e0b', '#10b981', 
            '#8b5cf6', '#06b6d4', '#d97706', '#4f46e5'
        ];
        createSmartDonutChart(ctxKeberatan, labelsKeberatan, valuesKeberatan, keberatanColors);
        renderCustomLegend('legendDonutKeberatan', labelsKeberatan, valuesKeberatan, keberatanColors);
    }
});
</script>
@endpush
