@extends('layout.utama')

@section('title', 'Beranda - PPID FMIPA Unila')

@section('content')
@php
    $beranda = \App\Models\Beranda::getData();

    $waktuCache = app()->environment('local') ? 5 : 60;
    $seringDiakses = \Illuminate\Support\Facades\Cache::remember('sering_diakses_beranda', $waktuCache, function () {
        return \App\Models\InformasiPublik::select('id', 'sub_informasi', 'tipe_informasi', 'jalur_informasi')
               ->orderBy('dilihat', 'desc')->take(6)->get();
    });

    // --- Data Statistik (Dinamis dari database) ---
    $oldestPengajuan = \App\Models\Pengajuan::oldest()->first();
    $minYearDB = $oldestPengajuan ? (int)$oldestPengajuan->created_at->format('Y') : null;
    $currentYear = (int)date('Y');

    // Jika belum ada data, gunakan hanya tahun sekarang agar tidak error
    $minYear = $minYearDB ?: $currentYear;
    $years = range($minYear, $currentYear);

    $yearlyData = [];
    $monthlyData = [];

    foreach ($years as $y) {
        $yearlyData[$y] = [
            'permohonan' => \App\Models\Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->count(),
            'diterima'   => \App\Models\Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->where('status', 'DITERIMA')->count(),
            'ditolak'    => \App\Models\Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->where('status', 'DITOLAK')->count(),
            'keberatan'  => \App\Models\Pengajuan::where('jenis_layanan', 'Keberatan')->whereYear('created_at', $y)->count(),
        ];

        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[$y][$m] = [
                'permohonan' => \App\Models\Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->whereMonth('created_at', $m)->count(),
                'diterima'   => \App\Models\Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'DITERIMA')->count(),
                'ditolak'    => \App\Models\Pengajuan::where('jenis_layanan', 'Permohonan')->whereYear('created_at', $y)->whereMonth('created_at', $m)->where('status', 'DITOLAK')->count(),
                'keberatan'  => \App\Models\Pengajuan::where('jenis_layanan', 'Keberatan')->whereYear('created_at', $y)->whereMonth('created_at', $m)->count(),
            ];
        }
    }
@endphp

<div class="relative min-h-[100vh] w-full flex items-center pt-44 md:pt-48 pb-20 overflow-hidden bg-[#1B365D]">
    <div class="absolute inset-0 bg-cover bg-center opacity-75" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#1B365D] via-[#1B365D]/70 to-transparent"></div>

    <div class="relative z-10 w-full px-8 md:px-16 lg:px-24 space-y-6">
        <div class="max-w-4xl space-y-8">
            <div class="space-y-4">
                <p class="text-lg font-semibold tracking-widest uppercase text-cyan-100">{{ $beranda['hero_tagline'] }}</p>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white tracking-tight leading-[1.15]">
                    {{ $beranda['hero_judul_1'] }}<br>
                    @if(!empty($beranda['hero_judul_2']))
                        {{ $beranda['hero_judul_2'] }}<br>
                    @endif
                    <span class="font-light text-cyan-100">{{ $beranda['hero_subjudul'] }}</span>
                </h1>
            </div>

            <div class="max-w-3xl">
                <form action="{{ url('/informasi-publik') }}" method="GET" class="relative flex items-center shadow-2xl">
                    <div class="absolute left-6 text-gray-700 pointer-events-none"><i class="fa-solid fa-magnifying-glass text-base"></i></div>
                    <input id="live-search-input" type="text" name="search" placeholder="{{ $beranda['hero_search_placeholder'] }}"
                        class="w-full h-16 pl-14 pr-32 bg-white text-gray-900 placeholder-gray-700 text-base rounded-3xl focus:outline-none border-0 transition-all shadow-lg" autocomplete="off">
                    <div class="absolute right-2">
                        <button type="submit" class="h-12 px-8 bg-[#1B365D] hover:bg-[#1B365D] text-white font-medium text-xs uppercase rounded-3xl tracking-wider transition-colors cursor-pointer">Cari</button>
                    </div>
                </form>
            </div>

            <!-- Tempat memunculkan hasil Live Search -->
            <div id="live-results-list" class="w-full flex flex-wrap items-center gap-2.5"></div>

            <div class="space-y-6">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                    <span class="text-md font-bold uppercase tracking-widest text-cyan-100 shrink-0">Informasi yang sering dicari:</span>
                    @foreach($seringDiakses as $doc)
                        @if($doc->tipe_informasi === 'link')
                            <a href="{{ $doc->jalur_informasi }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-lg font-medium text-white hover:text-cyan-100 underline decoration-white/30">
                                {{ $doc->sub_informasi }}
                            </a>
                        @else
                            <a href="{{ route('informasi.file', ['id' => $doc->id, 'slug' => \Illuminate\Support\Str::slug($doc->sub_informasi) . '.' . $doc->tipe_informasi]) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-lg font-medium text-white hover:text-cyan-100 underline decoration-white/30">
                                {{ $doc->sub_informasi }}
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="space-y-4">
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <p class="text-md text-white">Anda adalah Admin. Silakan masuk ke panel admin untuk mengelola informasi dan pengajuan.</p>
                        <a href="{{ route('admin.dashboard') }}"
                          class="inline-block bg-white hover:bg-gray-100 text-[#1B365D] font-bold px-8 py-4 uppercase text-sm rounded-2xl tracking-wider transition-all shadow-lg">
                            Dashboard Admin
                        </a>
                    @else
                        <p class="text-md text-white">{{ $beranda['hero_cta_user_text'] }}</p>
                        <a href="{{ route('layanan.index') }}"
                          class="inline-block bg-white hover:bg-gray-100 text-[#1B365D] font-bold px-8 py-4 uppercase text-sm rounded-2xl tracking-wider transition-all shadow-lg">
                            Buat Permohonan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-6 sm:px-8 md:px-16 lg:px-24">
        <div class="text-center mb-16 space-y-3">
            <span class="text-xs sm:text-sm font-extrabold uppercase tracking-widest text-[#07597b]">Langkah Mudah Layanan</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">{{ $beranda['alur_judul'] }}</h2>
            <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto">{{ $beranda['alur_subjudul'] }}</p>
        </div>

        @php
            $prosedurData = \App\Models\ProsedurPermohonan::getData();
            $alurSteps = $prosedurData['tahapan_permohonan'] ?? $beranda['alur_steps'];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach($alurSteps as $index => $step)
            <div class="relative bg-[#1B365D] hover:bg-[#162c4c] text-white p-8 sm:p-10 shadow-xl border border-white/10 flex flex-col justify-between overflow-hidden min-h-[260px] group transition-all duration-300 hover:-translate-y-1">
                <!-- Decorative Top Geometric Shapes -->
                <div class="flex items-center gap-1.5 opacity-40 mb-6">
                    <span class="w-3 h-3 bg-cyan-300"></span>
                    <span class="w-3 h-3 bg-cyan-100"></span>
                    <span class="w-3 h-3 bg-white"></span>
                </div>

                <!-- Title & Description -->
                <div class="relative z-10 space-y-3 pr-6 mb-6">
                    <h3 class="text-xl sm:text-2xl font-extrabold text-white leading-tight">
                        {{ $step['judul'] ?? $step['title'] }}
                    </h3>
                    <p class="text-xs sm:text-sm text-cyan-100/90 leading-relaxed font-medium">
                        {{ $step['deskripsi'] ?? $step['desc'] }}
                    </p>
                </div>

                <!-- Huge Watermark Step Number -->
                <span class="absolute -right-2 -bottom-4 text-7xl sm:text-8xl md:text-9xl font-black text-white/20 pointer-events-none select-none group-hover:text-white/30 transition-colors leading-none">
                    {{ $index + 1 }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-14 bg-gray-50">
    <div class="container mx-auto px-8 md:px-16 lg:px-24">
        <div class="bg-[#1B365D] rounded-3xl p-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-start shadow-3xl">
            <div class="text-white mt-12">
                <p class="text-xs font-bold text-cyan-200 uppercase tracking-widest mb-3">{{ $beranda['stats_tagline'] }}</p>
                <h2 id="stats-title" class="text-4xl font-bold mb-6">{{ $beranda['stats_judul'] }}</h2>
                <div id="stats-content">
                    <p class="text-gray-100 mb-8 leading-relaxed text-lg">
                        {{ $beranda['stats_deskripsi'] }}
                    </p>
                    <a href="/statistik" class="inline-flex items-center gap-2 font-bold text-white hover:text-cyan-200 transition-all">
                        <i class="fa-solid fa-arrow-right"></i> Selengkapnya
                    </a>
                </div>
            </div>

            <div class="w-full">
                <div class="flex justify-between items-center mb-6 min-h-[30px]">
                    <span id="year-label" class="text-white font-bold text-xl"></span>
                    <button id="resetChart" class="hidden text-xs font-bold text-cyan-200 hover:text-white transition-all underline">
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

<!-- Floating Quick Edit Widget (Hanya Muncul Saat Admin Login) -->
@auth
    @if(Auth::user()->isAdmin())
    <div class="fixed bottom-6 right-6 z-[9999] transition-all transform hover:scale-105">
        <a href="{{ route('admin.beranda.edit') }}"
           class="inline-flex items-center gap-3 px-6 py-4 bg-[#1B365D] hover:bg-[#07597b] text-white text-xs sm:text-sm font-extrabold uppercase tracking-wider shadow-2xl border-2 border-white/20">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-500"></span>
            </span>
            <i class="fa-solid fa-pen-to-square text-base"></i>
            <span>Edit Halaman Ini (Admin)</span>
        </a>
    </div>
    @endif
@endauth

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const searchInput = document.getElementById('live-search-input');
    const resultsList = document.getElementById('live-results-list');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        const q = this.value.trim();
        clearTimeout(debounceTimer);

        if (q.length < 2) {
            resultsList.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`/informasi-publik?live=1&search=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.found) {
                        resultsList.innerHTML = `<div class="px-5 py-3 bg-red-950/90 border border-red-500/50 text-red-200 text-sm shadow-lg flex rounded-3xl items-center gap-3"><i class="fa-solid fa-circle-exclamation"></i> Informasi tidak ditemukan.</div>`;
                        return;
                    }

                    resultsList.innerHTML = data.data.map(item => `
                        <a href="${item.url}" target="_blank" rel="noopener noreferrer" title="Buka: ${item.sub_informasi}"
                            class="inline-flex items-center gap-2.5 px-4 py-3 bg-white text-gray-900 hover:bg-gray-100 text-sm font-medium shadow-md transition-all rounded-3xl border border-gray-200 whitespace-normal leading-relaxed">
                            <i class="fa-solid fa-file-lines text-[#1B365D] shrink-0"></i>
                            <span>${item.sub_informasi}</span>
                        </a>
                    `).join('');
                })
                .catch(err => {
                    console.error("Gagal mengambil data pencarian:", err);
                });
        }, 300);
    });

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
                { label: 'Permohonan', data: Object.values(yearlyData).map(v => v.permohonan), backgroundColor: '#ffffff', borderRadius: 16 },
                { label: 'Diterima', data: Object.values(yearlyData).map(v => v.diterima), backgroundColor: '#4ade80', borderRadius: 16 },
                { label: 'Ditolak', data: Object.values(yearlyData).map(v => v.ditolak), backgroundColor: '#f87171', borderRadius: 16 },
                { label: 'Keberatan', data: Object.values(yearlyData).map(v => v.keberatan), backgroundColor: '#fbbf24', borderRadius: 16 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { color: '#ffffff', usePointStyle: true, pointStyle: 'rect' } } },

            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 10,
                    ticks: {
                        stepSize: 5,
                        color: '#e2e8f0'
                    },
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
