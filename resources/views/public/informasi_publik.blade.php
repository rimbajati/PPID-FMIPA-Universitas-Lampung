@extends('layouts.main')

@section('title', 'Informasi Publik - PPID FMIPA Unila')

@section('content')
<div class="container mx-auto px-4 py-12 pt-32 max-w-7xl">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Informasi Publik</h1>
        <p class="text-gray-600 max-w-2xl text-sm md:text-base">
            Penetapan Daftar Informasi Publik Universitas Lampung mengacu pada aturan yang berlaku. Kebijakan ini mengatur jenis informasi yang wajib diumumkan dan disediakan untuk menjamin akses informasi yang akurat bagi masyarakat.
        </p>
    </div>

    <!-- Search Form -->
    <form id="searchForm" action="{{ url('/informasi-publik') }}" method="GET" class="bg-white p-4 md:p-6 border border-gray-100 shadow-xl mb-8 flex flex-col md:flex-row gap-4 items-center rounded-3xl">
        <!-- Filter Jumlah Per Halaman -->
        <div class="relative w-full md:w-auto flex items-center gap-2">
            <label class="text-xs text-gray-500 font-bold whitespace-nowrap pl-2">Menampilkan</label>
            <div class="relative">
                <input type="hidden" name="perPage" id="perPage_input" value="{{ request('perPage', 10) }}">
                <button type="button" id="perPageTrigger"
                    class="border border-gray-200 rounded-2xl p-3 bg-gray-50 text-sm text-gray-600 focus:border-blue-500 transition outline-none w-20 flex justify-between items-center">
                    <span id="perPageTriggerText">{{ request('perPage') == 9999 ? 'Semua' : (request('perPage') ?: 10) }}</span>
                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                </button>
                <ul id="perPageMenu" class="absolute z-50 w-20 mt-2 bg-white border border-gray-100 shadow-xl rounded-2xl hidden overflow-hidden">
                    @foreach([10, 25, 50, 100, 9999] as $val)
                        <li class="cursor-pointer px-4 py-3 text-sm hover:bg-gray-100 transition text-center"
                            onclick="selectPerPage('{{ $val }}', '{{ $val == 9999 ? 'Semua' : $val }}')">
                            {{ $val == 9999 ? 'Semua' : $val }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Filter Kategori -->
        <div class="w-full md:w-auto flex-1">
            <input type="hidden" name="kategori" id="kategori_input" value="{{ request('kategori') }}">
            <div class="relative">
                <button type="button" id="dropdownTrigger"
                    class="w-full flex justify-between items-center border border-gray-200 rounded-2xl p-3 bg-gray-50 text-sm text-gray-600 focus:border-blue-500 transition outline-none">
                    <span id="triggerText">{{ request('kategori') ?: '-- Jenis Informasi --' }}</span>
                    <i class="fa-solid fa-chevron-down text-xs text-gray-400"></i>
                </button>
                <ul id="dropdownMenu" class="absolute z-50 w-full mt-2 bg-white border border-gray-100 shadow-xl rounded-2xl hidden overflow-hidden">
                    <li class="cursor-pointer px-4 py-3 text-sm hover:bg-gray-100 transition" onclick="selectOption('', 'Semua Kategori')">Semua Kategori</li>
                    <li class="cursor-pointer px-4 py-3 text-sm hover:bg-gray-100 transition" onclick="selectOption('Informasi Tersedia Setiap Saat', 'Informasi Tersedia Setiap Saat')">Informasi Tersedia Setiap Saat</li>
                    <li class="cursor-pointer px-4 py-3 text-sm hover:bg-gray-100 transition" onclick="selectOption('Informasi Tersedia Secara Berkala', 'Informasi Tersedia Secara Berkala')">Informasi Tersedia Secara Berkala</li>
                    <li class="cursor-pointer px-4 py-3 text-sm hover:bg-gray-100 transition" onclick="selectOption('Informasi Diumumkan Serta-Merta', 'Informasi Diumumkan Serta-Merta')">Informasi Diumumkan Serta-Merta</li>
                </ul>
            </div>
        </div>

        <!-- Pencarian -->
        <div class="relative w-full md:w-auto flex-[2]">
            <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Masukan kata kunci..."
                class="w-full border border-gray-200 rounded-2xl p-3 outline-none text-sm text-gray-600 pr-10 focus:border-blue-500 transition">
            <button type="submit" class="absolute right-4 top-3.5 text-gray-400 hover:text-blue-600">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>

    <!-- Data Display Table -->
    <div class="bg-white border border-gray-100 shadow-lg rounded-3xl overflow-hidden mb-10">
        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[700px] text-left border-collapse">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Ringkasan Informasi</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Jenis Informasi</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Tanggal Upload</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @forelse($informasi as $dok)
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <!-- Menampilkan rincian_informasi dan sub_informasi secara bersamaan -->
                        <td class="px-8 py-5">
                            <div class="text-md text-gray-900">{{ $dok->sub_informasi }}<div>
                        </td>
                        <td class="px-8 py-5 text-sm text-gray-600 whitespace-nowrap">{{ $dok->kategori }}</td>
                        <td class="px-8 py-5 text-sm text-gray-600">{{ $dok->created_at->format('d/m/Y') }}</td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('akses.dokumen', $dok->id) }}" target="_blank" rel="noopener noreferrer"
                                class="inline-block bg-[#0a192f] text-white text-[11px] font-bold px-6 py-2.5 rounded-full hover:bg-black transition shadow-sm whitespace-nowrap">
                                LIHAT
                            </a>
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
    <div class="flex justify-center mt-8">
        {{ $informasi->appends(request()->query())->links() }}
    </div>
</div>

<script>
    const trigger = document.getElementById('dropdownTrigger');
    const menu = document.getElementById('dropdownMenu');
    const input = document.getElementById('kategori_input');
    const triggerText = document.getElementById('triggerText');
    const ppTrigger = document.getElementById('perPageTrigger');
    const ppMenu = document.getElementById('perPageMenu');
    const ppInput = document.getElementById('perPage_input');
    const ppText = document.getElementById('perPageTriggerText');
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    let debounceTimer;

    ppTrigger.addEventListener('click', (e) => { e.stopPropagation(); ppMenu.classList.toggle('hidden'); });
    trigger.addEventListener('click', (e) => { e.stopPropagation(); menu.classList.toggle('hidden'); });

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => { searchForm.submit(); }, 500);
    });

    function selectPerPage(value, label) {
        ppInput.value = value;
        ppText.innerText = label;
        ppMenu.classList.add('hidden');
        searchForm.submit();
    }

    function selectOption(value, label) {
        input.value = value;
        triggerText.innerText = label;
        menu.classList.add('hidden');
        searchForm.submit();
    }

    document.addEventListener('click', (e) => {
        if (!ppTrigger.contains(e.target) && !ppMenu.contains(e.target)) ppMenu.classList.add('hidden');
        if (!trigger.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
    });
</script>
@endsection
