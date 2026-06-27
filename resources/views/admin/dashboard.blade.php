@extends('layouts.admin')

@section('title', 'Dashboard Admin - PPID FMIPA Unila')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Dashboard Admin</h1>
        <p class="text-sm text-gray-500">Ringkasan aktivitas dan pemantauan statistik pelayanan informasi publik</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 hover:shadow-xl transition flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-[#0095e8]/10 text-[#0095e8] flex items-center justify-center rounded-lg"><i class="fa-solid fa-folder-open text-lg"></i></div>
                <span class="text-xs font-bold text-gray-400 uppercase">Total</span>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $totalInformasi }}</h3>
                <p class="text-sm font-bold text-gray-500">Informasi Publik</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 hover:shadow-xl transition flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-gray-100 text-gray-600 flex items-center justify-center rounded-lg"><i class="fa-solid fa-file-lines text-lg"></i></div>
                <span class="text-xs font-bold text-gray-400 uppercase">Total</span>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-gray-900 mb-1">{{ $totalPermohonan }}</h3>
                <p class="text-sm font-bold text-gray-500">Semua Permohonan</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-blue-100 hover:shadow-xl transition flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#0095e8]/5 rounded-full"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-10 h-10 bg-[#0095e8] text-white flex items-center justify-center rounded-lg shadow-md"><i class="fa-solid fa-bell text-lg"></i></div>
                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-1 rounded">PENDING</span>
            </div>
            <div class="relative z-10">
                <h3 class="text-3xl font-extrabold text-[#0095e8] mb-1">{{ $permohonanBaru }}</h3>
                <p class="text-sm font-bold text-gray-600">Permohonan Baru</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-200 hover:shadow-xl transition flex flex-col justify-between">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 bg-amber-100 text-amber-500 flex items-center justify-center rounded-lg"><i class="fa-solid fa-scale-balanced text-lg"></i></div>
                <span class="bg-amber-100 text-amber-600 text-[10px] font-bold px-2 py-1 rounded">SENGKETA</span>
            </div>
            <div>
                <h3 class="text-3xl font-extrabold text-amber-500 mb-1">0</h3>
                <p class="text-sm font-bold text-gray-600">Keberatan Baru</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 bg-white p-8 rounded-2xl border border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Statistik Permohonan</h2>
            <div class="relative w-full h-72">
                <canvas id="statistikChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white p-8 rounded-2xl border border-gray-200">
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
    const stats = @json($statistik);
    const statusCounts = @json($statusCounts);

    // Proses Data Bar Chart
    let totalPerBulan = Array(12).fill(0), diterimaPerBulan = Array(12).fill(0), ditolakPerBulan = Array(12).fill(0);
    stats.forEach(item => {
        if(item.status === 'DITERIMA') diterimaPerBulan[item.bulan - 1] = item.total;
        if(item.status === 'DITOLAK') ditolakPerBulan[item.bulan - 1] = item.total;
        totalPerBulan[item.bulan - 1] += item.total;
    });

    // Bar Chart
    new Chart(document.getElementById('statistikChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                { label: 'Total', data: totalPerBulan, backgroundColor: '#9ca3af' },
                { label: 'Diterima', data: diterimaPerBulan, backgroundColor: '#0095e8' },
                { label: 'Ditolak', data: ditolakPerBulan, backgroundColor: '#ef4444' }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: { y: { ticks: { stepSize: 1, precision: 0 } } }
        }
    });

    // Donut Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Diterima', 'Diproses', 'Ditolak'],
            datasets: [{
                data: [statusCounts.DITERIMA, statusCounts.DIPROSES, statusCounts.Ditolak],
                backgroundColor: ['#0095e8', '#fbbf24', '#ef4444'],
                cutout: '75%'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush
