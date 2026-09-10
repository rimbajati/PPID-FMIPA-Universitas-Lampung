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
                            {{ $totalPermohonan + $totalKeberatan }}
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
                            {{ $totalPermohonan }}
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
                            {{ $totalPermohonanSelesai }}
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
                            {{ $totalPermohonanDitolak }}
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
                            {{ $totalKeberatan }}
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
                            {{ $rataRataWaktuTeks ?? '1 Hari' }}
                        </span>
                    </div>
                    <span class="text-[10px] sm:text-[11px] text-slate-700 font-semibold mt-1 flex items-center gap-1.5 truncate">
                        <i class="fa-solid fa-bolt text-[9px] text-slate-500"></i> Rata-rata Layanan
                    </span>
                </div>
            </div>

            <!-- BAGIAN BAWAH: WADAH CHART ELEGAN DENGAN TINGGI LEGA & LEGENDA DI ATAS -->
            <div class="bg-white p-4 sm:p-5 lg:p-6 rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-sm flex flex-col justify-between w-full">
                
                <!-- Chart Top Bar: Keterangan Legenda Warna (Kiri) & Toggle Rentang Waktu (Kanan) -->
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 gap-3">
                    <!-- Keterangan Legenda Warna (Di Posisi Kiri Menggantikan Tulisan Tren) -->
                    <div class="flex flex-wrap items-center gap-2 sm:gap-2.5 text-xs font-bold text-slate-700">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/60 shadow-2xs">
                            <span class="w-2.5 h-2.5 rounded-sm bg-[#2563eb] inline-block"></span>
                            <span>Permohonan</span>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/60 shadow-2xs">
                            <span class="w-2.5 h-2.5 rounded-sm bg-[#059669] inline-block"></span>
                            <span>Selesai</span>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/60 shadow-2xs">
                            <span class="w-2.5 h-2.5 rounded-sm bg-[#e11d48] inline-block"></span>
                            <span>Ditolak</span>
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/60 shadow-2xs">
                            <span class="w-2.5 h-2.5 rounded-sm bg-[#f59e0b] inline-block"></span>
                            <span>Keberatan</span>
                        </div>
                    </div>

                    <!-- Bagian Kanan: Badge Periode Tahun (saat mode Bulan) & Tombol Toggle Switch -->
                    <div class="flex items-center gap-2 shrink-0">
                        <!-- Badge Penunjuk Tahun (Otomatis tampil dinamis saat mode Bulan aktif) -->
                        <span id="chartYearBadge" class="hidden items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 border border-sky-200/70 text-xs font-bold transition-all duration-200">
                            <i class="fa-regular fa-calendar text-[11px] text-sky-500"></i>
                            <span id="chartYearText">Tahun {{ $chartBulanan['year'] ?? date('Y') }}</span>
                        </span>

                        <!-- Tombol Toggle Switch (Tahun / Bulan) di Kanan -->
                        <div class="inline-flex p-0.5 bg-slate-100/90 rounded-lg border border-slate-200/80 text-xs font-bold">
                            <button type="button" id="btnModeTahun" class="px-3.5 py-1.5 rounded-md transition-all duration-200 bg-white text-sky-700 shadow-xs cursor-pointer text-xs">
                                Tahun
                            </button>
                            <button type="button" id="btnModeBulan" class="px-3.5 py-1.5 rounded-lg transition-all duration-200 text-slate-500 hover:text-slate-900 cursor-pointer text-xs">
                                Bulan
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Canvas Grafik Batang Tahunan / Bulanan (Tinggi Lega, Proporsional & Sama Sekali Tidak Gepeng) -->
                <div class="relative h-[340px] sm:h-[380px] lg:h-[420px] w-full pt-2">
                    <canvas id="chartLaporanTahunan"></canvas>
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
    let currentDynamicMax = calculateDynamicMax(dataTahunan.permintaan, dataTahunan.disetujui, dataTahunan.ditolak, dataTahunan.keberatan);

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
            onClick: function(evt, elements) {
                // Saat berada di mode Tahun, klik pada batang tahun manapun akan langsung membuka rincian Bulan untuk tahun tersebut!
                if (currentMode === 'tahun' && elements.length > 0) {
                    const clickedIndex = elements[0].index;
                    const clickedYear = dataTahunan.labels[clickedIndex];
                    if (clickedYear && dataBulananPerTahun[clickedYear]) {
                        selectedYearForMonth = clickedYear;
                        switchMode('bulan', clickedYear);
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
                        afterTitle: function() {
                            return currentMode === 'tahun' ? '💡 Klik batang untuk lihat rincian bulan' : '';
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
                        font: { size: 12, weight: 'bold' }
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

    // Event Handler Tombol Switch (Tahun / Bulan)
    const btnTahun = document.getElementById('btnModeTahun');
    const btnBulan = document.getElementById('btnModeBulan');
    const yearBadge = document.getElementById('chartYearBadge');
    const yearText = document.getElementById('chartYearText');

    function switchMode(mode, specificYear = null) {
        if (mode === currentMode && !specificYear) return;
        currentMode = mode;

        if (specificYear) {
            selectedYearForMonth = specificYear;
        }

        const activeDataset = (mode === 'tahun') 
            ? dataTahunan 
            : (dataBulananPerTahun[selectedYearForMonth] || {
                labels: @json($chartBulanan['months']),
                permintaan: @json($chartBulanan['permintaan']),
                disetujui: @json($chartBulanan['disetujui']),
                ditolak: @json($chartBulanan['ditolak']),
                keberatan: @json($chartBulanan['keberatan']),
              });

        // Update Button Active Styling & Year Badge Visibility
        if (mode === 'tahun') {
            btnTahun.className = 'px-3.5 py-1.5 rounded-md transition-all duration-200 bg-white text-sky-700 shadow-xs cursor-pointer text-xs';
            btnBulan.className = 'px-3.5 py-1.5 rounded-lg transition-all duration-200 text-slate-500 hover:text-slate-900 cursor-pointer text-xs';
            if (yearBadge) {
                yearBadge.classList.add('hidden');
                yearBadge.classList.remove('inline-flex');
            }
        } else {
            btnBulan.className = 'px-3.5 py-1.5 rounded-md transition-all duration-200 bg-white text-sky-700 shadow-xs cursor-pointer text-xs';
            btnTahun.className = 'px-3.5 py-1.5 rounded-lg transition-all duration-200 text-slate-500 hover:text-slate-900 cursor-pointer text-xs';
            if (yearBadge) {
                if (yearText) yearText.textContent = 'Tahun ' + selectedYearForMonth;
                yearBadge.classList.remove('hidden');
                yearBadge.classList.add('inline-flex');
            }
        }

        // Update Chart Labels & Data
        chartInstance.data.labels = activeDataset.labels;
        chartInstance.data.datasets[0].data = activeDataset.permintaan;
        chartInstance.data.datasets[1].data = activeDataset.disetujui;
        chartInstance.data.datasets[2].data = activeDataset.ditolak;
        chartInstance.data.datasets[3].data = activeDataset.keberatan;

        // Update Dynamic Max Sumbu Y
        const newMax = calculateDynamicMax(activeDataset.permintaan, activeDataset.disetujui, activeDataset.ditolak, activeDataset.keberatan);
        chartInstance.options.scales.y.max = newMax;

        chartInstance.update();
    }

    if (btnTahun) {
        btnTahun.addEventListener('click', () => switchMode('tahun'));
    }
    if (btnBulan) {
        btnBulan.addEventListener('click', () => switchMode('bulan'));
    }
});
</script>



