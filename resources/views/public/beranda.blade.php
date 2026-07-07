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
                        class="w-full h-16 pl-14 pr-32 bg-white text-gray-900 placeholder-gray-700 text-base rounded-none focus:outline-none border-0 transition-all shadow-lg" autocomplete="off">
                    <div class="absolute right-2">
                        <button type="submit" class="h-12 px-8 bg-[#0a192f] hover:bg-blue-900 text-white font-medium text-xs uppercase tracking-wider transition-colors cursor-pointer">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="live-results-list" class="w-full flex flex-wrap items-center gap-2.5"></div>

        <div class="space-y-6 pt-6 border-t border-white/20">
            <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                <span class="text-sm font-bold uppercase tracking-widest text-blue-300 shrink-0">Informasi yang sering dicari:</span>
                @foreach ($seringDiakses as $doc)
                <a href="{{ route('akses.dokumen', $doc->id) }}" target="_blank" rel="noopener noreferrer"
                   class="text-base font-medium text-gray-200 hover:text-white underline decoration-white/30 hover:decoration-white underline-offset-4 transition-all">
                    {{ $doc->judul_informasi }}
                </a>
                @endforeach
            </div>

            <div class="w-fit">
                <div class="bg-[#0a192f] border border-white/10 p-8 flex flex-col items-start gap-5 shadow-xl rounded-none">
                    <div>
                        <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Tidak menemukan yang Anda cari?</h3>
                        <p class="text-gray-300 text-sm md:text-base">Anda dapat mengajukan permohonan informasi publik melalui formulir resmi kami.</p>
                    </div>
                    <a href="{{ route('permohonan.create') }}"
                       class="bg-white hover:bg-gray-100 text-[#0a192f] font-bold px-8 py-4 transition-all shadow-lg text-sm uppercase tracking-wider text-center rounded-none w-full md:w-auto">
                       Ajukan Permohonan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-24 bg-gray-50">
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
            <div class="relative bg-white p-8 rounded-none shadow-sm border border-gray-100 hover:shadow-xl transition-all group">
                <div class="w-16 h-16 bg-blue-900 text-white rounded-none flex items-center justify-center text-2xl mb-6 group-hover:scale-110 transition-transform">
                    <i class="fa-solid {{ $step['icon'] }}"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">{{ $index + 1 }}. {{ $step['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
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
                        resultsList.innerHTML = `<div class="px-5 py-3 bg-red-950/90 border border-red-500/50 text-red-200 text-sm shadow-lg flex items-center gap-3"><i class="fa-solid fa-circle-exclamation"></i> Informasi tidak ditemukan.</div>`;
                        return;
                    }
                    resultsList.innerHTML = res.data.map(item => `
                        <a href="${item.url}" target="_blank" rel="noopener noreferrer" title="Buka: ${item.judul}"
                           class="inline-flex items-center gap-2.5 px-4 py-3 bg-white text-gray-900 hover:bg-gray-100 text-sm font-medium shadow-md transition-all border border-gray-200 whitespace-normal leading-relaxed">
                            <i class="fa-solid fa-file-lines text-blue-900 shrink-0"></i>
                            <span>${item.judul}</span>
                        </a>
                    `).join('');
                });
        }, 300);
    });
</script>
@endsection
