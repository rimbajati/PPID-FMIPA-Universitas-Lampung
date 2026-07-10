@if(request()->query('live') == 1)
    @php
        $q = trim(request()->query('search', ''));
        $result = collect();
        $found = true;
        if ($q !== '') {
            if (strlen($q) >= 2) {
                $result = \App\Models\InformasiPublik::select('id', 'judul_informasi')
                    ->where('judul_informasi', 'LIKE', "$q%")
                    ->orWhere('judul_informasi', 'LIKE', "%$q%")
                    ->orderByRaw("CASE WHEN judul_informasi LIKE ? THEN 1 ELSE 2 END", ["$q%"])
                    ->latest()->take(6)->get();
                if ($result->isEmpty()) { $found = false; }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['found' => $found, 'data' => $result->map(fn($item) => ['judul' => $item->judul_informasi, 'url' => route('akses.dokumen', $item->id)])]);
        exit;
    @endphp
@endif

@extends('layouts.main')

@section('title', 'Beranda - PPID FMIPA Unila')

@section('content')
@php
    $waktuCache = app()->environment('local') ? 5 : 60;
    $seringDiakses = \Illuminate\Support\Facades\Cache::remember('sering_diakses_beranda', $waktuCache, function () {
        return \App\Models\InformasiPublik::select('id', 'judul_informasi')->orderBy('dilihat', 'desc')->take(6)->get();
    });

    // --- Data Statistik (Dinamis dari database) ---
    $minYear = (int)(\App\Models\Permohonan::min(\Illuminate\Support\Facades\DB::raw('YEAR(created_at)')) ?? date('Y'));
    $currentYear = (int)date('Y');
    $years = range($minYear, $currentYear);

    $yearlyData = [];
    $monthlyData = [];

    foreach ($years as $y) {
        $yearlyData[$y] = [
            'permohonan' => \App\Models\Permohonan::whereYear('created_at', $y)->count(),
            'diterima'   => \App\Models\Permohonan::whereYear('created_at', $y)->where('status', 'DITERIMA')->count(),
            'ditolak'    => \App\Models\Permohonan::whereYear('created_at', $y)->where('status', 'DITOLAK')->count(),
            'keberatan'  => \App\Models\Keberatan::whereYear('created_at', $y)->count(),
        ];

        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[$y][$m] = [
                'permohonan' => \App\Models\Permohonan::whereYear('created_at', $y)->whereMonth('created_at', $m)->count(),
                'diterima'   => \App\Models\Permohonan::whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'DITERIMA')->count(),
                'ditolak'    => \App\Models\Permohonan::whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'DITOLAK')->count(),
                'keberatan'  => \App\Models\Keberatan::whereYear('created_at', $y)->whereMonth('created_at', $m)->count(),
            ];
        }
    }
@endphp

<div class="relative min-h-[100vh] w-full flex items-center pt-32 pb-20 overflow-hidden bg-[#0a192f]">
    <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-luminosity" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#0a192f] via-[#0a192f]/80 to-transparent"></div>

    <div class="relative z-10 w-full px-8 md:px-16 lg:px-24 space-y-6">
        <div class="max-w-4xl space-y-8">
            <div class="space-y-4">
                <p class="text-lg font-semibold tracking-widest uppercase text-blue-300">Pejabat Pengelola Informasi & Dokumentasi (PPID)</p>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white tracking-tight leading-[1.15]">
                    Fakultas Matematika &<br>Ilmu Pengetahuan Alam<br>
                    <span class="font-light text-gray-300">Universitas Lampung</span>
                </h1>
            </div>

            <div class="max-w-3xl">
                    <form action="{{ url('/informasi-publik') }}" method="GET" class="relative flex items-center shadow-2xl">
                        <div class="absolute left-6 text-gray-700 pointer-events-none"><i class="fa-solid fa-magnifying-glass text-base"></i></div>
                        <input id="live-search-input" type="text" name="search" placeholder="Masukan Informasi yang Anda cari..."
                            class="w-full h-16 pl-14 pr-32 bg-white text-gray-900 placeholder-gray-700 text-base rounded-3xl focus:outline-none border-0 transition-all shadow-lg" autocomplete="off">
                        <div class="absolute right-2">
                            <button type="submit" class="h-12 px-8 bg-[#0a192f] hover:bg-blue-900 text-white font-medium text-xs uppercase rounded-3xl tracking-wider transition-colors cursor-pointer">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="live-results-list" class="w-full flex flex-wrap items-center gap-2.5"></div>

            <div class="space-y-6">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                    <span class="text-md font-bold uppercase tracking-widest text-blue-300 shrink-0">Informasi yang sering dicari:</span>
                    @foreach ($seringDiakses as $doc)
                    <a href="{{ route('akses.dokumen', $doc->id) }}" target="_blank" rel="noopener noreferrer"
                    class="text-lg font-medium text-gray-200 hover:text-white underline decoration-white/30 hover:decoration-white underline-offset-4 transition-all">
                        {{ $doc->judul_informasi }}
                    </a>
                    @endforeach
                </div>

                <div class="space-y-4">
                    <p class="text-md text-gray-300">Jika informasi yang Anda cari tidak ditemukan, Anda dapat mengajukan permohonan baru di bawah ini.</p>
                    <a href="{{ route('layanan.create') }}"
                    class="inline-block bg-white hover:bg-gray-100 text-[#0a192f] font-bold px-8 py-4 uppercase text-sm rounded-3xl tracking-wider transition-all shadow-lg">
                        Buat Permohonan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-20 bg-white">
    <div class="container mx-auto px-8 md:px-16 lg:px-24">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Alur Permohonan Informasi</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Ikuti langkah mudah berikut untuk mengajukan permohonan informasi publik di lingkungan FMIPA Unila.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @php
                $steps = [
                    ['icon' => 'fa-user-plus', 'title' => 'Registrasi/Login', 'desc' => 'Daftar akun atau masuk ke sistem untuk memulai permohonan.'],
                    ['icon' => 'fa-file-signature', 'title' => 'Isi Formulir', 'desc' => 'Lengkapi form permohonan dengan data diri dan tujuan informasi.'],
                    ['icon' => 'fa-paper-plane', 'title' => 'Kirim Permohonan', 'desc' => 'Submit formulir dan dapatkan nomor registrasi permohonan.'],
                    ['icon' => 'fa-envelope-open-text', 'title' => 'Terima Jawaban', 'desc' => 'Tunggu respon dari admin PPID melalui sistem atau email Anda.']
                ];
            @endphp
            @foreach($steps as $index => $step)
            <div class="relative bg-white p-8 rounded-3xl shadow-md border border-gray-100 hover:shadow-xl transition-all group">
                <div class="w-16 h-16 bg-blue-900 text-white rounded-3xl flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid {{ $step['icon'] }}"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">{{ $index + 1 }}. {{ $step['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-14 bg-gray-50">
    <div class="container mx-auto px-8 md:px-16 lg:px-24">
        <div class="bg-[#172a45] rounded-3xl p-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-start shadow-3xl">
            <div class="text-white mt-12">
                <p class="text-xs font-bold text-blue-300 uppercase tracking-widest mb-3">LAPORAN KETERBUKAAN INFORMASI</p>
                <h2 id="stats-title" class="text-4xl font-bold mb-6">Statistik Permohonan Informasi</h2>
                <div id="stats-content">
                    <p class="text-gray-300 mb-8 leading-relaxed text-lg">
                        Data ini menyajikan statistik keterbukaan informasi publik FMIPA Unila secara transparan. Masyarakat dapat memantau tren permohonan, status layanan, hingga perkembangan proses yang sedang berlangsung.
                    </p>
                    <a href="/statistik" class="inline-flex items-center gap-2 font-bold text-white hover:text-blue-300 transition-all">
                        <i class="fa-solid fa-arrow-right"></i> Selengkapnya
                    </a>
                </div>
            </div>

            <div class="w-full">
                <div class="flex justify-between items-center mb-6 min-h-[30px]">
                    <span id="year-label" class="text-white font-bold text-xl"></span>
                    <button id="resetChart" class="hidden text-xs font-bold text-blue-200 hover:text-white transition-all underline">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke periode tahun
                    </button>
                </div>
                <div class="h-80 w-full">
                    <canvas id="statistikBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Live Search
    const searchInput = document.getElementById('live-search-input');
    const resultsList = document.getElementById('live-results-list');
    let debounceTimer;
    searchInput.addEventListener('input', function() {
        const q = this.value.trim();
        clearTimeout(debounceTimer);
        if (q.length < 2) { resultsList.innerHTML = ''; return; }
        debounceTimer = setTimeout(() => {
            fetch(`{{ url('/') }}?live=1&search=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(res => {
                    if (!res.found) {
                        resultsList.innerHTML = `<div class="px-5 py-3 bg-red-950/90 border border-red-500/50 text-red-200 text-sm shadow-lg flex rounded-3xl items-center gap-3"><i class="fa-solid fa-circle-exclamation"></i> Informasi tidak ditemukan.</div>`;
                        return;
                    }
                    resultsList.innerHTML = res.data.map(item => `
                        <a href="${item.url}" target="_blank" rel="noopener noreferrer" title="Buka: ${item.judul}"
                            class="inline-flex items-center gap-2.5 px-4 py-3 bg-white text-gray-900 hover:bg-gray-100 text-sm font-medium shadow-md transition-all rounded-3xl border border-gray-200 whitespace-normal leading-relaxed">
                            <i class="fa-solid fa-file-lines text-blue-900 shrink-0"></i>
                            <span>${item.judul}</span>
                        </a>
                    `).join('');
                });
        }, 300);
    });

    // Statistik Chart
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
                { label: 'Permohonan', data: Object.values(yearlyData).map(v => v.permohonan), backgroundColor: '#5986d4', borderRadius: 16 },
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
                    labels: {
                        color: '#ffffff',
                        usePointStyle: true,
                        pointStyle: 'rect'
                    }
                }
                // tooltip: {
                //     callbacks: {
                //         label: function(context) {
                //             let label = context.dataset.label || '';
                //             let xLabel = context.label;
                //             let value = context.parsed.y;
                //             return [label, `${xLabel}: ${value}`];
                //         }
                //     }
                // }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 5, color: '#e2e8f0' },
                    grid: { color: '#ffffff61' }
                },
                x: {
                    ticks: { color: '#e2e8f0' },
                    grid: { display: true, color: '#ffffff61' }
                }
            },
            onClick: (e, elements) => {
                if (elements.length > 0) {
                    const year = chart.data.labels[elements[0].index];
                    if (monthlyData[year]) {
                        // Update UI
                        yearLabel.innerText = "Tahun " + year;
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
        // Reset UI
        yearLabel.innerText = "";
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
