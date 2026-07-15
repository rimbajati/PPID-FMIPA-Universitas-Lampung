@extends('layouts.admin')

@section('title', 'Dashboard Admin - PPID FMIPA Unila')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Dashboard Admin</h1>
        <p class="text-sm text-gray-500">Ringkasan aktivitas dan pemantauan statistik pelayanan informasi publik</p>
    </div>

    <!-- Statistik Grid (Responsive Horizontal Scroll) -->
    <div class="flex gap-4 overflow-x-auto pb-2 lg:grid lg:grid-cols-4 lg:gap-6 lg:pb-0 mb-10">

        <!-- 1. Total Informasi -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-6 text-white shadow-xl shadow-blue-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-folder-open text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Total Informasi</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalInformasi }}
            </div>
        </div>

        <!-- 2. Total Permohonan -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-slate-600 to-slate-800 rounded-3xl p-6 text-white shadow-xl shadow-slate-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-file-lines text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Total Permohonan</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalPermohonan }}
            </div>
        </div>

        <!-- 3. Permohonan Baru -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-sky-500 to-blue-600 rounded-3xl p-6 text-white shadow-xl shadow-blue-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-bell  text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Permohonan Baru</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $permohonanBaru }}
            </div>
        </div>

        <!-- 4. Sengketa/Keberatan -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl p-6 text-white shadow-xl shadow-amber-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-scale-balanced  text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Sengketa/Keberatan</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                0
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Bar Chart (Drill-down) -->
        <div class="lg:col-span-8 bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 id="year-label" class="text-xl font-bold text-gray-900">Statistik Permohonan Informasi Tahunan</h2>
                <button id="resetChart" class="hidden px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-bold transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </button>
            </div>
            <div class="relative w-full h-72">
                <canvas id="statistikBarChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart -->
        <div class="lg:col-span-4 bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Penyelesaian</h2>
            <div class="relative w-full h-52">
                <canvas id="statusChart"></canvas>
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
    const resetBtn = document.getElementById('resetChart');
    const yearLabel = document.getElementById('year-label');

    // Bar Chart
    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(yearlyData),
            datasets: [
                { label: 'Permohonan', data: Object.values(yearlyData).map(v => v.permohonan), backgroundColor: '#5986d4', borderRadius: 6 },
                { label: 'Diterima', data: Object.values(yearlyData).map(v => v.diterima), backgroundColor: '#22c55e', borderRadius: 6 },
                { label: 'Ditolak', data: Object.values(yearlyData).map(v => v.ditolak), backgroundColor: '#ef4444', borderRadius: 6 },
                { label: 'Keberatan', data: Object.values(yearlyData).map(v => v.keberatan), backgroundColor: '#f59e0b', borderRadius: 6 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, pointStyle: 'rect' } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
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

    // Reset Button Logic
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

    // Donut Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Diterima', 'Diproses', 'Ditolak'],
            datasets: [{
                data: [statusCounts.DITERIMA, statusCounts.DIPROSES, statusCounts.Ditolak],
                backgroundColor: ['#0095e8', '#fbbf24', '#ef4444'],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush
