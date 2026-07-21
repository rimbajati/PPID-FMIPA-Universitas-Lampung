@extends('layout.utama')

@section('title', 'Informasi Tersedia Secara Berkala - PPID FMIPA Unila')

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
            <a href="/informasi-publik" class="hover:text-white transition-colors">Layanan Informasi</a>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
            <span class="text-white font-bold">Informasi Tersedia SecaraBerkala</span>
        </nav>

@php
    $konten = \App\Models\KontenInformasiPublik::getData();
@endphp

        <div class="max-w-4xl space-y-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                {{ $konten['berkala_judul'] }}
            </h1>
            <p class="text-slate-100 text-sm sm:text-lg md:text-xl leading-relaxed font-normal">
                {{ $konten['berkala_subjudul'] }}
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

<div class="container mx-auto px-6 sm:px-8 md:px-16 lg:px-24 max-w-7xl pb-16">

    <!-- Search Form -->
    <form id="searchForm" action="{{ url('/informasi-berkala') }}" method="GET" class="bg-white p-4 md:p-6 border border-gray-100 shadow-xl mb-8 flex flex-col md:flex-row gap-4 items-center rounded-3xl" onsubmit="event.preventDefault(); performLiveSearch(this);">
        <input type="hidden" name="perPage" id="perPage_input" value="{{ request('perPage', 10) }}">

        <div class="relative w-full md:w-auto flex-[2]">
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Cari rincian atau sub informasi..."
                class="w-full border border-gray-200 rounded-2xl p-3 outline-none text-sm text-gray-600 focus:border-blue-500 transition" autocomplete="off">
        </div>
        <button type="submit" class="w-full md:w-auto px-8 py-3 bg-[#1B365D] text-white rounded-2xl font-bold text-sm hover:bg-[#1B365D] transition">Cari</button>
    </form>

    <!-- Data Table Container -->
    <div id="data-table-container" class="transition-opacity duration-200">
        <div class="bg-white border border-gray-100 shadow-lg rounded-3xl overflow-hidden mb-10">
            <div class="overflow-x-auto w-full">
                <table class="w-full min-w-[700px] text-left border-collapse">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Rincian Informasi</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Sub Informasi</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Tanggal Upload</th>
                            <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($informasi->groupBy('rincian_informasi') as $grup => $items)
                            @foreach($items as $index => $item)
                                <tr class="hover:bg-gray-50 transition {{ $loop->last ? 'border-b-2 border-gray-300' : 'border-b border-gray-100' }}">

                                    @if($index === 0)
                                        <td rowspan="{{ $items->count() }}" class="p-5 pl-8 font-bold text-gray-900 align-top">
                                            {{ $grup }}
                                        </td>
                                    @endif

                                    <td class="p-5 text-gray-700">{{ $item->sub_informasi }}</td>
                                    <td class="p-5 text-gray-500 text-sm">{{ $item->created_at->translatedFormat('j F Y') }}</td>
                                    <td class="p-5 text-center">
                                        <a href="{{ url('/informasi/akses/'.$item->id) }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-block bg-[#1B365D] text-white text-[11px] font-bold px-6 py-2.5 rounded-full hover:bg-[#1B365D] transition shadow-sm whitespace-nowrap">
                                        LIHAT
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr><td colspan="4" class="p-10 text-center text-gray-400">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-center mt-8">
            {{ $informasi->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
    function performLiveSearch(formElement) {
        const url = new URL(formElement.action, window.location.origin);
        const formData = new FormData(formElement);
        for (const [key, value] of formData.entries()) {
            if (value) url.searchParams.set(key, value);
        }
        
        const dataContainer = document.getElementById('data-table-container');
        if (dataContainer) dataContainer.classList.add('opacity-50', 'pointer-events-none');

        fetch(url.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            const newTable = doc.getElementById('data-table-container');
            if (newTable && dataContainer) {
                dataContainer.innerHTML = newTable.innerHTML;
            }
            
            window.history.replaceState(null, '', url.toString());
        })
        .catch(err => console.error("Search fetch failed:", err))
        .finally(() => {
            if (dataContainer) dataContainer.classList.remove('opacity-50', 'pointer-events-none');
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let timer = null;
            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    const searchForm = document.getElementById('searchForm');
                    if (searchForm) performLiveSearch(searchForm);
                }, 400);
            });
        }
    });
</script>
@endsection

