<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
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
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
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
]); ?>
<?php foreach (array_filter(([
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
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<!-- Seksi Laporan & Statistik Keterbukaan Informasi (Desain Kustom Tema PPID FMIPA Unila) -->
<section id="statistik-layanan" class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 mb-20 relative z-20 scroll-mt-24 sm:scroll-mt-28">

    <!-- HEADER SECTION (Di Atas Kotak & Rata Tengah Sesuai Permintaan) -->
    <div class="text-center max-w-3xl mx-auto mb-6 sm:mb-8 space-y-2">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-black border border-sky-200 shadow-2xs">
            <i class="fa-solid fa-chart-simple text-sky-500"></i>
            <span>Laporan Keterbukaan Informasi</span>
        </div>

        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
            Statistik <span class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 bg-clip-text text-transparent">Permohonan Informasi</span>
        </h2>

        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
            Rekapitulasi berkala data permohonan dan penanganan keberatan informasi publik di lingkungan FMIPA Universitas Lampung.
        </p>
    </div>

    <!-- Card Container dengan tema Sky Blue lembut & Ambient Gradient khas PPID FMIPA -->
    <div class="bg-gradient-to-br from-[#F0F9FF] via-[#F8FAFC] to-[#E0F2FE] rounded-3xl sm:rounded-[30px] p-3.5 sm:p-5 lg:p-5 border border-sky-200/80 shadow-lg shadow-sky-900/5 relative overflow-hidden">
        
        <!-- Ambient Watermark / Glows khas FMIPA -->
        <div class="absolute -top-24 -right-24 w-80 h-80 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-3 sm:space-y-3.5">
            
            <!-- BAGIAN METRIK RINGKASAN ATAS: 6 KARTU BERSIH (TERMASUK WAKTU RESPON DI PALING KANAN) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2 sm:gap-2.5">
                <!-- 1. Total Layanan -->
                <div class="bg-white p-3 sm:p-3.5 rounded-xl sm:rounded-2xl border border-sky-100 shadow-xs flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 block truncate">Total Layanan</span>
                        <span class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-0.5 block">
                            <?php echo e($totalPermohonan + $totalKeberatan); ?>

                        </span>
                    </div>
                    <span class="text-[10px] sm:text-[11px] text-slate-700 font-semibold mt-1 flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-ticket-simple text-[9px] text-slate-500"></i> Tiket Tercatat
                    </span>
                </div>

                <!-- 2. Total Permohonan -->
                <div class="bg-white p-3 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 block truncate">Total Permohonan</span>
                        <span class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-0.5 block">
                            <?php echo e($totalPermohonan); ?>

                        </span>
                    </div>
                    <span class="text-[10px] sm:text-[11px] text-slate-700 font-semibold mt-1 flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-inbox text-[9px] text-slate-500"></i> Permintaan Masuk
                    </span>
                </div>

                <!-- 3. Total Permohonan Selesai -->
                <div class="bg-white p-3 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 block truncate">Permohonan Selesai</span>
                        <span class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-0.5 block">
                            <?php echo e($totalPermohonanSelesai); ?>

                        </span>
                    </div>
                    <span class="text-[10px] sm:text-[11px] text-slate-700 font-semibold mt-1 flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-circle-check text-[9px] text-slate-500"></i> Telah Dipenuhi
                    </span>
                </div>

                <!-- 4. Total Permohonan Ditolak -->
                <div class="bg-white p-3 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 block truncate">Permohonan Ditolak</span>
                        <span class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-0.5 block">
                            <?php echo e($totalPermohonanDitolak); ?>

                        </span>
                    </div>
                    <span class="text-[10px] sm:text-[11px] text-slate-700 font-semibold mt-1 flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-circle-xmark text-[9px] text-slate-500"></i> Ditolak Resmi
                    </span>
                </div>

                <!-- 5. Total Keberatan -->
                <div class="bg-white p-3 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 block truncate">Total Keberatan</span>
                        <span class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-0.5 block">
                            <?php echo e($totalKeberatan); ?>

                        </span>
                    </div>
                    <span class="text-[10px] sm:text-[11px] text-slate-700 font-semibold mt-1 flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-triangle-exclamation text-[9px] text-slate-500"></i> Berkas Keberatan
                    </span>
                </div>

                <!-- 6. Waktu Respon Rata-Rata (Paling Kanan) -->
                <div class="bg-white p-3 sm:p-3.5 rounded-xl sm:rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-slate-500 block truncate">Waktu Respon</span>
                        <span class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-0.5 block">
                            <?php echo e($rataRataWaktuTeks ?? '1 Hari'); ?>

                        </span>
                    </div>
                    <span class="text-[10px] sm:text-[11px] text-slate-700 font-semibold mt-1 flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-bolt text-[9px] text-slate-500"></i> Rata-rata Layanan
                    </span>
                </div>
            </div>

            <!-- BAGIAN BAWAH: WADAH CHART ELEGAN RAMPING DENGAN LEGENDA RATA TENGAH DI BAWAH -->
            <div class="bg-white p-3.5 sm:p-4.5 lg:p-5 rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-sm flex flex-col justify-between w-full">
                
                <!-- Canvas Grafik Batang Tahunan / Bulanan -->
                <div class="relative h-[260px] sm:h-[290px] lg:h-[320px] w-full">
                    <canvas id="chartLaporanTahunan"></canvas>
                </div>

                <!-- Baris Keterangan Saat Mode Bulan Aktif (Dengan Tombol Kembali ke Tahunan) -->
                <div id="containerModeBulan" class="hidden items-center justify-between px-4 sm:px-6 pt-2.5 pb-1 border-t border-slate-100">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Rincian Bulanan: <span id="labelTahunAktif" class="text-sky-600 font-extrabold">Tahun 2026</span></span>
                    </div>
                    <button type="button" 
                            onclick="kembaliKeTahunan()" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition-all shadow-xs cursor-pointer">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali ke Tahunan</span>
                    </button>
                </div>

                <!-- Keterangan Legenda & Petunjuk Interaksi di Luar Grafik -->
                <div class="mt-3 pt-3 border-t border-slate-100 flex flex-col items-center gap-2">
                    <!-- Keterangan Legenda Warna Rata Tengah Sempurna -->
                    <div class="flex flex-wrap items-center justify-center gap-2.5 sm:gap-4 text-xs font-bold text-slate-700">
                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200/60 shadow-2xs">
                            <span class="w-3 h-3 rounded-md bg-[#2563eb] inline-block"></span>
                            <span>Permohonan</span>
                        </div>
                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200/60 shadow-2xs">
                            <span class="w-3 h-3 rounded-md bg-[#059669] inline-block"></span>
                            <span>Selesai</span>
                        </div>
                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200/60 shadow-2xs">
                            <span class="w-3 h-3 rounded-md bg-[#e11d48] inline-block"></span>
                            <span>Ditolak</span>
                        </div>
                        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200/60 shadow-2xs">
                            <span class="w-3 h-3 rounded-md bg-[#f59e0b] inline-block"></span>
                            <span>Keberatan</span>
                        </div>
                    </div>

                    <!-- Petunjuk Interaksi di Bawah Legenda (Hanya tampil saat mode tahun) -->
                    <div id="hintKlikTahun" class="inline-flex items-center gap-1.5 text-[11px] font-medium text-slate-400 mt-0.5">
                        <i class="fa-solid fa-arrow-pointer text-sky-500 text-[10px]"></i>
                        <span>Klik batang tahun pada grafik untuk melihat rincian per bulan</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- Script Inisialisasi Chart.js Sesuai Warna Tema Sistem & Mode Toggle (Tahun / Bulan) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartLaporanTahunan');
    if (!ctx) return;

    // Dataset Tahunan
    const dataTahunan = {
        title: 'Tren Tahunan Layanan',
        badge: '<?php echo e($chartTahunan['years'][0] ?? 2022); ?> - <?php echo e(end($chartTahunan['years']) ?: 2026); ?>',
        labels: <?php echo json_encode($chartTahunan['years'], 15, 512) ?>,
        permintaan: <?php echo json_encode($chartTahunan['permintaan'], 15, 512) ?>,
        disetujui: <?php echo json_encode($chartTahunan['disetujui'], 15, 512) ?>,
        ditolak: <?php echo json_encode($chartTahunan['ditolak'], 15, 512) ?>,
        keberatan: <?php echo json_encode($chartTahunan['keberatan'], 15, 512) ?>,
    };

    // Dataset Bulanan untuk Setiap Tahun (Drill-Down Interaktif)
    const dataBulananPerTahun = <?php echo json_encode($chartBulananPerTahun, 15, 512) ?>;
    let selectedYearForMonth = <?php echo e($chartBulanan['year'] ?? date('Y')); ?>;

    function calculateDynamicMax(permintaan, disetujui, ditolak, keberatan) {
        const allValues = [...permintaan, ...disetujui, ...ditolak, ...keberatan];
        const peakValue = Math.max(0, ...allValues);
        return Math.max(10, Math.ceil((peakValue === 0 ? 1 : peakValue) / 10) * 10);
    }

    let currentMode = 'tahun';
    const currentDynamicMax = calculateDynamicMax(dataTahunan.permintaan, dataTahunan.disetujui, dataTahunan.ditolak, dataTahunan.keberatan);

    const chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dataTahunan.labels,
            datasets: [
                {
                    label: 'Permohonan',
                    data: dataTahunan.permintaan,
                    backgroundColor: '#2563eb', // Biru Royal Permohonan (#2563eb)
                    borderRadius: 4,
                    barPercentage: 0.9,
                    categoryPercentage: 0.85
                },
                {
                    label: 'Selesai',
                    data: dataTahunan.disetujui,
                    backgroundColor: '#059669', // Hijau Selesai (#059669)
                    borderRadius: 4,
                    barPercentage: 0.9,
                    categoryPercentage: 0.85
                },
                {
                    label: 'Ditolak',
                    data: dataTahunan.ditolak,
                    backgroundColor: '#e11d48', // Merah Ditolak (#e11d48)
                    borderRadius: 4,
                    barPercentage: 0.9,
                    categoryPercentage: 0.85
                },
                {
                    label: 'Keberatan',
                    data: dataTahunan.keberatan,
                    backgroundColor: '#f59e0b', // Kuning/Amber Keberatan (#f59e0b)
                    borderRadius: 4,
                    barPercentage: 0.9,
                    categoryPercentage: 0.85
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 400
            },
            onHover: function(evt, elements) {
                if (currentMode === 'tahun') {
                    // Cek apakah kursor tepat berada di bar / kolom tahun
                    const pts = chartInstance.getElementsAtEventForMode(evt, 'index', { intersect: false }, false);
                    ctx.style.cursor = (pts.length > 0) ? 'pointer' : 'default';
                } else {
                    ctx.style.cursor = 'default';
                }
            },
            onClick: function(evt) {
                if (currentMode !== 'tahun') return;
                
                // Ambil elemen batang/kolom tahun yang diklik
                const points = chartInstance.getElementsAtEventForMode(evt, 'index', { intersect: false }, false);
                if (points.length > 0) {
                    const clickedIndex = points[0].index;
                    const clickedYear = dataTahunan.labels[clickedIndex];
                    if (clickedYear) {
                        bukaGrafikBulan(clickedYear);
                    }
                }
            },
            plugins: {
                legend: {
                    display: false // Menggunakan legenda HTML kustom di bawah
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 10,
                    cornerRadius: 8,
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 12 },
                    callbacks: {
                        title: function(tooltipItems) {
                            if (!tooltipItems || tooltipItems.length === 0) return '';
                            const item = tooltipItems[0];
                            const label = item.label;
                            if (currentMode === 'bulan') {
                                const namaBulanLengkap = {
                                    'Jan': 'Januari',
                                    'Feb': 'Februari',
                                    'Mar': 'Maret',
                                    'Apr': 'April',
                                    'Mei': 'Mei',
                                    'Jun': 'Juni',
                                    'Jul': 'Juli',
                                    'Agu': 'Agustus',
                                    'Sep': 'September',
                                    'Okt': 'Oktober',
                                    'Nov': 'November',
                                    'Des': 'Desember'
                                };
                                const bulanLengkap = namaBulanLengkap[label] || label;
                                return selectedYearForMonth ? `${bulanLengkap} ${selectedYearForMonth}` : bulanLengkap;
                            }
                            return label;
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
                        stepSize: 10, // Tetap kelipatan 10 murni
                        precision: 0,
                        color: '#64748b',
                        font: { size: 11 }
                    },
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    ticks: {
                        color: '#334155',
                        font: { size: 12, weight: 'bold' },
                        padding: 8
                    },
                    grid: {
                        display: true,
                        color: '#D1EAE0',
                        lineWidth: 1
                    },
                    border: {
                        color: '#D1EAE0'
                    }
                }
            }
        }
    });

    const containerBulan = document.getElementById('containerModeBulan');
    const labelTahunAktif = document.getElementById('labelTahunAktif');

    // Daftar 12 Bulan Standar
    const defaultMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // Fungsi Ketika Batang Tahun Ditekan -> Berubah Jadi Grafik Bulan di Tahun Tersebut
    window.bukaGrafikBulan = function(tahun) {
        currentMode = 'bulan';
        selectedYearForMonth = tahun;
        const dataBulanTahun = (dataBulananPerTahun && dataBulananPerTahun[tahun]) ? dataBulananPerTahun[tahun] : {
            months: defaultMonths,
            permintaan: <?php echo json_encode($chartBulanan['permintaan'] ?? array_fill(0, 12, 0)) ?>,
            disetujui: <?php echo json_encode($chartBulanan['disetujui'] ?? array_fill(0, 12, 0)) ?>,
            ditolak: <?php echo json_encode($chartBulanan['ditolak'] ?? array_fill(0, 12, 0)) ?>,
            keberatan: <?php echo json_encode($chartBulanan['keberatan'] ?? array_fill(0, 12, 0)) ?>,
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

        // Sembunyikan Petunjuk Klik Batang saat sudah di mode Bulan
        const hintKlik = document.getElementById('hintKlikTahun');
        if (hintKlik) hintKlik.classList.add('hidden');
    };

    // Fungsi Kembali ke Grafik Tahunan
    window.kembaliKeTahunan = function() {
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

        // Tampilkan kembali Petunjuk Klik Batang saat di mode Tahun
        const hintKlik = document.getElementById('hintKlikTahun');
        if (hintKlik) hintKlik.classList.remove('hidden');
    };
});
</script>



<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/masyarakat/beranda/statistik-section.blade.php ENDPATH**/ ?>