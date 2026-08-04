@if(request()->query('live') == 1)
    @php
        $q = trim(request()->query('search', ''));
        $result = collect();
        $found = true;

        if ($q !== '' && strlen($q) >= 2) {
            $result = \App\Models\InformasiPublik::select('id', 'sub_informasi', 'tipe_informasi', 'jalur_informasi', 'created_at', 'kategori')
                ->where('sub_informasi', 'LIKE', "%$q%")
                ->latest()
                ->take(10)
                ->get();
            if ($result->isEmpty()) { $found = false; }
        }

        header('Content-Type: application/json');
        echo json_encode([
            'found' => $found,
            'data' => $result->map(fn($item) => [
                'sub_informasi' => $item->sub_informasi,
                'kategori'      => $item->kategori,
                'tanggal'       => $item->created_at->translatedFormat('j F Y'),
                'url'           => $item->tipe_informasi === 'link'
                    ? $item->jalur_informasi
                    : route('informasi.file', ['id' => $item->id, 'slug' => \Illuminate\Support\Str::slug($item->sub_informasi) . '.' . $item->tipe_informasi])
            ])
        ]);
        exit;
    @endphp
@endif

@extends('layouts.app')

@section('title', 'Informasi Publik - PPID FMIPA Unila')

@section('content')
@php
    $konten = \App\Models\KontenInformasiPublik::getData();
@endphp

<!-- Hero Section Banner -->
<div class="relative bg-[#1B365D] text-white pt-32 sm:pt-40 pb-16 sm:pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#1B365D] via-[#1B365D]/90 to-[#1B365D]/70"></div>
    
    <div class="relative max-w-7xl mx-auto px-6 sm:px-8 md:px-16 lg:px-24">
        <!-- Breadcrumb -->
        <nav class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-cyan-200 mb-6">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span>Layanan Informasi</span>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-white font-bold"> Daftar Informasi Publik</span>
        </nav>

        <div class="max-w-4xl space-y-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                {{ $konten['informasi_publik_judul'] }}
            </h1>
            <p class="text-slate-100 text-sm sm:text-lg md:text-xl leading-relaxed font-normal">
                {{ $konten['informasi_publik_subjudul'] }}
            </p>
        </div>
    </div>
</div>

@auth
    @if(Auth::user()->isAdmin())
    <div class="fixed bottom-6 right-6 z-[9999] transition-all transform hover:scale-105">
        <a href="{{ route('admin.halaman-informasi-publik.edit') }}"
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

<div class="container mx-auto px-6 sm:px-8 md:px-16 lg:px-24 max-w-7xl pt-10 sm:pt-12 pb-16">

    <!-- Search & Filter Form (Standar HTML Select & Spasi Rapi dari Banner) -->
    <form id="searchForm" action="{{ url('/informasi-publik') }}" method="GET" class="mb-8 flex flex-col md:flex-row gap-4 items-center">
        <!-- Filter Jumlah Per Halaman (HTML Select Standard) -->
        <div class="relative w-full md:w-auto flex items-center gap-2">
            <label class="text-xs text-gray-500 font-bold whitespace-nowrap">Menampilkan</label>
            <select name="perPage" onchange="this.form.submit()" class="border border-slate-200 bg-white rounded-lg p-3 text-sm font-medium text-slate-700 outline-none cursor-pointer hover:border-[#1B365D] focus:border-[#1B365D] transition shadow-sm">
                @foreach([10, 25, 50, 100, 9999] as $val)
                    <option value="{{ $val }}" {{ request('perPage', 10) == $val ? 'selected' : '' }}>
                        {{ $val == 9999 ? 'Semua' : $val }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Jenis Informasi (HTML Select Standard) -->
        <div class="w-full md:w-auto flex-1">
            <select name="kategori" onchange="this.form.submit()" class="w-full border border-slate-200 bg-white rounded-lg p-3 text-sm font-medium text-slate-700 outline-none cursor-pointer hover:border-[#1B365D] focus:border-[#1B365D] transition shadow-sm">
                <option value="">-- Semua Jenis Informasi --</option>
                <option value="Informasi Tersedia Setiap Saat" {{ request('kategori') == 'Informasi Tersedia Setiap Saat' ? 'selected' : '' }}>Informasi Tersedia Setiap Saat</option>
                <option value="Informasi Tersedia Secara Berkala" {{ request('kategori') == 'Informasi Tersedia Secara Berkala' ? 'selected' : '' }}>Informasi Tersedia Secara Berkala</option>
                <option value="Informasi Diumumkan Serta-Merta" {{ request('kategori') == 'Informasi Diumumkan Serta-Merta' ? 'selected' : '' }}>Informasi Diumumkan Serta-Merta</option>
            </select>
        </div>

        <!-- Pencarian -->
        <div class="relative w-full md:w-auto flex-[2]">
            <input type="text" id="searchInput" name="search" value="{{ request('search') }}" autocomplete="off" placeholder="Masukan kata kunci..."
                class="w-full border border-slate-200 bg-white rounded-lg p-3 outline-none text-sm text-slate-700 font-medium shadow-sm pr-10 hover:border-[#1B365D] focus:border-[#1B365D] transition">
            <button type="submit" class="absolute right-4 top-3.5 text-slate-400 hover:text-[#1B365D]">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>

    <!-- Data Display Table Container (Sudut Siku 90 Deg) -->
    <div class="bg-white border border-gray-100 shadow-lg rounded-none overflow-hidden mb-10">
        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[700px] text-left border-collapse">
                <thead class="bg-[#1B365D] border-b border-gray-200">
                    <tr>
                        <th class="px-8 py-5 text-[12px] font-extrabold text-white tracking-wider">Ringkasan Informasi</th>
                        <th class="px-8 py-5 text-[12px] font-extrabold text-white tracking-wider text-center">Jenis Informasi</th>
                        <th class="px-8 py-5 text-[12px] font-extrabold text-white tracking-wider">Tanggal Upload</th>
                        <th class="px-8 py-5 text-[12px] font-extrabold text-white tracking-wider text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="data-tbody">
                    @forelse($informasi as $dok)
                    <tr class="hover:bg-gray-50 transition-colors group border-b border-gray-100">
                        <td class="px-8 py-5"><div class="text-md text-gray-900 font-medium">{{ $dok->sub_informasi }}</div></td>
                        <td class="px-8 py-5 text-center whitespace-nowrap">
                            @php
                                $style = [
                                    'Informasi Tersedia Setiap Saat' => 'bg-[#605ca8] text-white',
                                    'Informasi Tersedia Secara Berkala' => 'bg-[#2563eb] text-white',
                                    'Informasi Diumumkan Serta-Merta' => 'bg-[#0284c7] text-white',
                                ][$dok->kategori] ?? 'bg-slate-600 text-white';
                            @endphp
                            <span class="px-3.5 py-1.5 text-xs sm:text-sm font-bold inline-block text-center shadow-xs {{ $style }}" style="border-radius: 12px !important;">{{ $dok->kategori }}</span>
                        </td>
                        <td class="px-8 py-5 text-sm text-gray-600">{{ $dok->created_at->translatedFormat('j F Y') }}</td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('informasi.file', ['id' => $dok->id, 'slug' => \Illuminate\Support\Str::slug($dok->sub_informasi) . '.' . $dok->tipe_informasi]) }}"
                                target="_blank" class="inline-block bg-[#1B365D] text-white text-[12px] font-bold px-5 py-2 shadow-xs hover:bg-[#162c4c] transition" style="border-radius: 12px !important;">LIHAT</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-10 text-center text-gray-500">Informasi tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div id="pagination-links" class="flex justify-center mt-8">
        {{ $informasi->appends(request()->query())->links() }}
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('data-tbody');
    const pagination = document.getElementById('pagination-links');
    const searchForm = document.getElementById('searchForm');
    let debounceTimer;

    // Live Search AJAX
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        clearTimeout(debounceTimer);

        if (query === '') {
            searchForm.submit();
            return;
        }

        if (query.length < 2) return;

        debounceTimer = setTimeout(() => {
            fetch(`{{ url('/informasi-publik') }}?live=1&search=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    pagination.style.display = 'none'; // Sembunyikan pagination saat live search
                    if (data.found && data.data.length > 0) {
                        tableBody.innerHTML = data.data.map(item => `
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-8 py-5 text-md text-gray-900 font-medium">${item.sub_informasi}</td>
                                <td class="px-8 py-5 text-sm text-gray-600">${item.kategori}</td>
                                <td class="px-8 py-5 text-sm text-gray-600">${item.tanggal}</td>
                                <td class="px-8 py-5 text-center">
                                    <a href="${item.url}" target="_blank" class="inline-block bg-[#1B365D] text-white text-[11px] font-bold px-6 py-2.5 rounded-full hover:bg-[#1B365D] transition">LIHAT</a>
                                </td>
                            </tr>
                        `).join('');
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="4" class="p-10 text-center text-gray-500">Informasi tidak ditemukan.</td></tr>';
                    }
                });
        }, 500);
    });

    // Toggle Dropdowns
    document.getElementById('perPageTrigger').addEventListener('click', (e) => { e.stopPropagation(); document.getElementById('perPageMenu').classList.toggle('hidden'); });
    document.getElementById('dropdownTrigger').addEventListener('click', (e) => { e.stopPropagation(); document.getElementById('dropdownMenu').classList.toggle('hidden'); });

    function selectPerPage(value, label) {
        document.getElementById('perPage_input').value = value;
        document.getElementById('perPageTriggerText').innerText = label;
        searchForm.submit();
    }

    function selectOption(value, label) {
        document.getElementById('kategori_input').value = value;
        document.getElementById('triggerText').innerText = label;
        searchForm.submit();
    }
</script>
@endsection

