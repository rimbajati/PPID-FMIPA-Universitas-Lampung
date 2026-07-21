@extends('layout.utama')

@section('title', 'Statistik - PPID FMIPA Unila')

@section('content')
<!-- Hero Section Banner -->
<div class="relative bg-[#1B365D] text-white pt-32 sm:pt-40 pb-16 sm:pb-20 overflow-hidden mb-12">
    <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#1B365D] via-[#1B365D]/90 to-[#1B365D]/70"></div>
    
    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 md:px-16 lg:px-24">
        <!-- Breadcrumb -->
        <nav class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-cyan-200 mb-6">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span>Layanan Informasi</span>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-white font-bold">Laporan & Statistik</span>
        </nav>

        <div class="max-w-4xl space-y-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                Statistik Permohonan Informasi
            </h1>
            <p class="text-slate-100 text-sm sm:text-lg md:text-xl leading-relaxed font-normal">
                Ringkasan laporan terhadap akses informasi publik FMIPA Universitas Lampung yang meliputi jumlah permohonan, status layanan, dan kategori keberatan secara terbuka.
            </p>
        </div>
    </div>
</div>

<div class="pb-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6 max-w-6xl">
        <div class="bg-white p-8 md:p-12 shadow-xl border border-slate-200">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-12">
                @php
                    $cards = [
                        ['label' => 'Total Permohonan', 'val' => $kpi['total']],
                        ['label' => 'Diterima', 'val' => $kpi['diterima']],
                        ['label' => 'Ditolak', 'val' => $kpi['ditolak']],
                        ['label' => 'Keberatan', 'val' => $kpi['keberatan']],
                        ['label' => 'Rata-rata Waktu', 'val' => $kpi['rata_rata']],
                    ];
                @endphp
                @foreach($cards as $card)
                <div class="border border-slate-200 rounded-3xl p-5">
                    <p class="text-slate-500 text-[11px] uppercase font-bold mb-2">{{ $card['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $card['val'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="w-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 id="year-label" class="text-xl font-bold text-slate-800">Statistik Permohonan Informasi Tahunan</h3>
                    <button id="resetChart" class="hidden text-xs font-bold text-blue-600 hover:text-blue-800 underline">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke periode tahun
                    </button>
                </div>
                <div class="h-96 w-full">
                    <canvas id="statistikBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const yearlyData = {!! json_encode($yearlyData) !!};
    const monthlyData = {!! json_encode($monthlyData) !!};
    const ctx = document.getElementById('statistikBarChart').getContext('2d');
    const resetBtn = document.getElementById('resetChart');
    const yearLabel = document.getElementById('year-label');

    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(yearlyData),
            datasets: [
                { label: 'Permohonan', data: Object.values(yearlyData).map(v => v.permohonan), backgroundColor: '#1B365D', borderRadius: 16 },
                { label: 'Diterima', data: Object.values(yearlyData).map(v => v.diterima), backgroundColor: '#22c55e', borderRadius: 16 },
                { label: 'Ditolak', data: Object.values(yearlyData).map(v => v.ditolak), backgroundColor: '#ef4444', borderRadius: 16 },
                { label: 'Keberatan', data: Object.values(yearlyData).map(v => v.keberatan), backgroundColor: '#f59e0b', borderRadius: 16 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, pointStyle: 'rect' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 10, // Memaksa batas atas minimal sampai angka 10
                    ticks: {
                        stepSize: 1   // Memaksa loncatan angka setiap kelipatan 1 (0, 1, 2, 3... 10)
                    }
                }
            },
            onClick: (e, elements) => {
                if (elements.length > 0) {
                    const year = chart.data.labels[elements[0].index];
                    if (monthlyData[year]) {
                        yearLabel.innerText = "Statistik Tahun " + year;
                        resetBtn.classList.remove('hidden');

                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                        chart.data.labels = months;
                        chart.data.datasets[0].data = Object.values(monthlyData[year]).map(v => v.permohonan);
                        chart.data.datasets[1].data = Object.values(monthlyData[year]).map(v => v.diterima);
                        chart.data.datasets[2].data = Object.values(monthlyData[year]).map(v => v.ditolak);
                        chart.data.datasets[3].data = Object.values(monthlyData[year]).map(v => v.keberatan);
                        chart.update();
                    }
                }
            }
        }
    });

    resetBtn.addEventListener('click', () => {
        yearLabel.innerText = "Statistik Permohonan Informasi Tahunan";
        resetBtn.classList.add('hidden');
        chart.data.labels = Object.keys(yearlyData);
        chart.data.datasets[0].data = Object.values(yearlyData).map(v => v.permohonan);
        chart.data.datasets[1].data = Object.values(yearlyData).map(v => v.diterima);
        chart.data.datasets[2].data = Object.values(yearlyData).map(v => v.ditolak);
        chart.data.datasets[3].data = Object.values(yearlyData).map(v => v.keberatan);
        chart.update();
    });
</script>
@endsection

