@props([
    'totalDokumen' => 0,
    'totalPermohonan' => 0,
    'totalPermohonanSelesai' => 0,
    'totalPermohonanDitolak' => 0,
    'totalKeberatan' => 0,
    'totalDilihat' => 0,
    'rataRataWaktuTeks' => '1 Hari',
    'chartTahunan' => [
        'years' => [2022, 2023, 2024, 2025, 2026],
        'permintaan' => [0, 0, 0, 0, 0],
        'disetujui' => [0, 0, 0, 0, 0],
        'ditolak' => [0, 0, 0, 0, 0],
        'keberatan' => [0, 0, 0, 0, 0],
    ],
    'chartBulanan' => [
        'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        'year' => 2026,
        'permintaan' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'disetujui' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'ditolak' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        'keberatan' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    ],
    'chartBulananPerTahun' => []
])

<!-- Seksi Statistik — Samakan dengan Gaya Admin -->
<section id="statistik-layanan" class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 mb-20 relative z-20 scroll-mt-24 sm:scroll-mt-28">

    <!-- HEADER SECTION -->
    <div class="text-center max-w-3xl mx-auto mb-6 sm:mb-8 space-y-2">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
            Statistik Layanan
        </h2>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
            Rekapitulasi berkala data permohonan dan penanganan keberatan informasi publik FMIPA Universitas Lampung.
        </p>
    </div>

    <div class="space-y-6">
        <!-- 6 Summary Overview Cards — Persis Admin -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3">
            <!-- Card 1: Total Layanan -->
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
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

            <!-- Card 2: Permohonan Masuk -->
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="p-3.5 sm:p-4 flex justify-between items-center min-h-[80px]">
                    <div>
                        <span class="text-2xl sm:text-3xl font-black block tracking-tight text-[#2563eb]">{{ $totalPermohonan }}</span>
                        <p class="text-[11px] font-extrabold text-slate-500 mt-0.5">Permohonan</p>
                    </div>
                    <div class="text-[#2563eb]/80">
                        <i class="fa-solid fa-envelope-open-text text-2xl sm:text-3xl"></i>
                    </div>
                </div>
                <div class="bg-[#2563eb] text-white text-[10px] sm:text-[11px] font-bold px-3 py-1 flex items-center justify-between">
                    <span class="truncate">Permohonan Masuk</span>
                    <i class="fa-solid fa-envelope-open-text text-[10px] shrink-0 ml-1"></i>
                </div>
            </div>

            <!-- Card 3: Permohonan Selesai -->
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
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
                    <span class="truncate">Permohonan Selesai</span>
                    <i class="fa-solid fa-check text-[10px] shrink-0 ml-1"></i>
                </div>
            </div>

            <!-- Card 4: Permohonan Ditolak -->
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
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
                    <span class="truncate">Permohonan Ditolak</span>
                    <i class="fa-solid fa-xmark text-[10px] shrink-0 ml-1"></i>
                </div>
            </div>

            <!-- Card 5: Pengajuan Keberatan -->
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                <div class="p-3.5 sm:p-4 flex justify-between items-center min-h-[80px]">
                    <div>
                        <span class="text-2xl sm:text-3xl font-black block tracking-tight text-[#d97706]">{{ $totalKeberatan }}</span>
                        <p class="text-[11px] font-extrabold text-slate-500 mt-0.5">Pengajuan Keberatan</p>
                    </div>
                    <div class="text-[#d97706]/80">
                        <i class="fa-solid fa-gavel text-2xl sm:text-3xl"></i>
                    </div>
                </div>
                <div class="bg-[#d97706] text-white text-[10px] sm:text-[11px] font-bold px-3 py-1 flex items-center justify-between">
                    <span class="truncate">Pengajuan Keberatan</span>
                    <i class="fa-solid fa-triangle-exclamation text-[10px] shrink-0 ml-1"></i>
                </div>
            </div>

            <!-- Card 6: Waktu Respon -->
            <div class="bg-white rounded-xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
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

        <!-- MAIN CHART CARD — Persis Admin -->
        <div class="bg-white rounded-xl border border-slate-200/90 shadow-2xs hover:shadow-md transition-all p-6 sm:p-7 space-y-4">
            <div class="relative flex items-center justify-center">
                <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight text-center">
                    Grafik Tren Layanan Informasi
                </h2>
            </div>
            <div class="relative h-[20rem] sm:h-[22.5rem] w-full pt-2">
                <canvas id="chartLaporanTahunan"></canvas>
            </div>
            <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-x-5 gap-y-2 font-semibold text-slate-700">
                    <div class="inline-flex items-center gap-2 cursor-default whitespace-nowrap">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0 bg-[#2563eb]"></span>
                        <span class="leading-none">Permohonan</span>
                    </div>
                    <div class="inline-flex items-center gap-2 cursor-default whitespace-nowrap">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0 bg-[#059669]"></span>
                        <span class="leading-none">Selesai</span>
                    </div>
                    <div class="inline-flex items-center gap-2 cursor-default whitespace-nowrap">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0 bg-[#e11d48]"></span>
                        <span class="leading-none">Ditolak</span>
                    </div>
                    <div class="inline-flex items-center gap-2 cursor-default whitespace-nowrap">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0 bg-[#f59e0b]"></span>
                        <span class="leading-none">Keberatan</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <div id="hintKlikTahun" class="inline-flex items-center gap-1.5 font-medium text-slate-400 text-[11px]">
                        <i class="fa-solid fa-circle-info text-sky-500 text-xs"></i>
                        <span>Klik batang tahun untuk melihat rincian per bulan</span>
                    </div>
                    <div id="containerModeBulan" class="hidden items-center gap-2.5 bg-sky-50 px-3 py-1.5 rounded-xl border border-sky-100 shadow-2xs">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-slate-700">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Rincian: <span id="labelTahunAktif" class="text-sky-600 font-extrabold">Tahun {{ date('Y') }}</span></span>
                        </div>
                        <button type="button" onclick="kembaliKeTahunan()" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-lg transition-all shadow-2xs cursor-pointer">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i>
                            <span>Kembali</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script — Samakan dengan Admin (gradient + behavior identik) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartLaporanTahunan');
    if (!ctx) return;

    const dataTahunan = {
        title: 'Tren Tahunan Layanan',
        badge: '{{ $chartTahunan['years'][0] ?? 2022 }} - {{ end($chartTahunan['years']) ?: 2026 }}',
        labels: @json($chartTahunan['years']),
        permintaan: @json($chartTahunan['permintaan']),
        disetujui: @json($chartTahunan['disetujui']),
        ditolak: @json($chartTahunan['ditolak']),
        keberatan: @json($chartTahunan['keberatan']),
    };
    const dataBulananPerTahun = @json($chartBulananPerTahun);
    let selectedYearForMonth = {{ $chartBulanan['year'] ?? date('Y') }};

    function calculateDynamicMax(permintaan, disetujui, ditolak, keberatan) {
        const allValues = [...permintaan, ...disetujui, ...ditolak, ...keberatan];
        const peakValue = Math.max(0, ...allValues);
        return Math.max(10, Math.ceil((peakValue === 0 ? 1 : peakValue) / 10) * 10);
    }

    let currentMode = 'tahun';
    const currentDynamicMax = calculateDynamicMax(dataTahunan.permintaan, dataTahunan.disetujui, dataTahunan.ditolak, dataTahunan.keberatan);

    const chartContext = ctx.getContext('2d');
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
                { label: 'Permohonan', data: dataTahunan.permintaan, backgroundColor: gradBlue, hoverBackgroundColor: '#2563eb', borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 }, borderSkipped: false, barPercentage: 0.75, categoryPercentage: 0.7 },
                { label: 'Selesai', data: dataTahunan.disetujui, backgroundColor: gradGreen, hoverBackgroundColor: '#059669', borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 }, borderSkipped: false, barPercentage: 0.75, categoryPercentage: 0.7 },
                { label: 'Ditolak', data: dataTahunan.ditolak, backgroundColor: gradRed, hoverBackgroundColor: '#e11d48', borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 }, borderSkipped: false, barPercentage: 0.75, categoryPercentage: 0.7 },
                { label: 'Keberatan', data: dataTahunan.keberatan, backgroundColor: gradAmber, hoverBackgroundColor: '#f59e0b', borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 }, borderSkipped: false, barPercentage: 0.75, categoryPercentage: 0.7 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 600, easing: 'easeOutQuart' },
            onHover: function(evt, elements) {
                if (currentMode === 'tahun') {
                    const pts = chartInstance.getElementsAtEventForMode(evt, 'index', { intersect: false }, false);
                    ctx.style.cursor = (pts.length > 0) ? 'pointer' : 'default';
                } else ctx.style.cursor = 'default';
            },
            onClick: function(evt) {
                if (currentMode !== 'tahun') return;
                const points = chartInstance.getElementsAtEventForMode(evt, 'index', { intersect: false }, false);
                if (points.length > 0) {
                    const clickedIndex = points[0].index;
                    const clickedYear = dataTahunan.labels[clickedIndex];
                    if (clickedYear) bukaGrafikBulan(clickedYear);
                }
            },
            plugins: {
                legend: { display: false },
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
                                const namaBulanLengkap = { 'Jan': 'Januari', 'Feb': 'Februari', 'Mar': 'Maret', 'Apr': 'April', 'Mei': 'Mei', 'Jun': 'Juni', 'Jul': 'Juli', 'Agu': 'Agustus', 'Sep': 'September', 'Okt': 'Oktober', 'Nov': 'November', 'Des': 'Desember' };
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
                    ticks: { stepSize: 10, precision: 0, color: '#64748b', font: { size: 11, weight: '600', family: 'Plus Jakarta Sans' } },
                    grid: { color: '#e2e8f0', drawBorder: false, lineWidth: 1 },
                    border: { display: false }
                },
                x: {
                    offset: true,
                    ticks: { color: '#334155', font: { size: 12, weight: 'bold', family: 'Plus Jakarta Sans' }, padding: 8 },
                    grid: { display: true, offset: true, color: '#e2e8f0', drawTicks: false, lineWidth: 1 },
                    border: { color: '#cbd5e1' }
                }
            }
        }
    });

    const containerBulan = document.getElementById('containerModeBulan');
    const labelTahunAktif = document.getElementById('labelTahunAktif');
    const defaultMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    window.bukaGrafikBulan = function(tahun) {
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
        chartInstance.data.labels = monthLabels;
        chartInstance.data.datasets[0].data = dataBulanTahun.permintaan || [];
        chartInstance.data.datasets[1].data = dataBulanTahun.disetujui || [];
        chartInstance.data.datasets[2].data = dataBulanTahun.ditolak || [];
        chartInstance.data.datasets[3].data = dataBulanTahun.keberatan || [];
        const maxVal = calculateDynamicMax(dataBulanTahun.permintaan || [], dataBulanTahun.disetujui || [], dataBulanTahun.ditolak || [], dataBulanTahun.keberatan || []);
        chartInstance.options.scales.y.max = maxVal;
        chartInstance.update();
        if (containerBulan) {
            if (labelTahunAktif) labelTahunAktif.textContent = 'Tahun ' + tahun;
            containerBulan.classList.remove('hidden');
            containerBulan.classList.add('flex');
        }
        const hintKlik = document.getElementById('hintKlikTahun');
        if (hintKlik) hintKlik.classList.add('hidden');
    };

    window.kembaliKeTahunan = function() {
        currentMode = 'tahun';
        chartInstance.data.labels = dataTahunan.labels;
        chartInstance.data.datasets[0].data = dataTahunan.permintaan;
        chartInstance.data.datasets[1].data = dataTahunan.disetujui;
        chartInstance.data.datasets[2].data = dataTahunan.ditolak;
        chartInstance.data.datasets[3].data = dataTahunan.keberatan;
        const maxVal = calculateDynamicMax(dataTahunan.permintaan, dataTahunan.disetujui, dataTahunan.ditolak, dataTahunan.keberatan);
        chartInstance.options.scales.y.max = maxVal;
        chartInstance.update();
        if (containerBulan) {
            containerBulan.classList.add('hidden');
            containerBulan.classList.remove('flex');
        }
        const hintKlik = document.getElementById('hintKlikTahun');
        if (hintKlik) hintKlik.classList.remove('hidden');
    };
});
</script>
