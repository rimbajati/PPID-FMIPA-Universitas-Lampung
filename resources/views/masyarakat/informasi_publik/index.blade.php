@extends('components.layouts.app')

@section('title', 'Katalog Informasi Publik - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-100/70 min-h-screen pb-20">

    <!-- Header Hero Banner (Matching Reference UI Title & Subtitle) -->
    <x-masyarakat.informasi_publik.hero-header />

    <!-- Main Content Container: Tabel Informasi Publik (Matching Admin DIP Table) -->
    <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="space-y-4">

            <!-- Bar Kontrol Tabel: Show Entries di Kiri & Search di Kanan (DataTables Style) -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
                <!-- Dropdown Show Entries -->
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                    <span>Show</span>
                    <select id="select-per-page-dip" onchange="changePerPageDip(this.value)" 
                            class="px-3 py-1.5 bg-white border border-slate-900 rounded-2xl text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                        <option value="10" {{ (int)request('per_page', 10) === 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ (int)request('per_page', 10) === 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ (int)request('per_page', 10) === 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ (int)request('per_page', 10) === 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>entries</span>
                </div>

                <!-- Search Bar Pencarian Seluruh Isi Tabel (Format DataTables Style: Search: [_____ x]) -->
                <form id="form-search-dip" onsubmit="event.preventDefault();" class="flex items-center gap-2">
                    <label for="input-search-dip" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">
                        Search:
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="input-search-dip"
                               value="{{ request('search') }}" 
                               autocomplete="off"
                               oninput="debounceSearchDip()"
                               class="w-48 sm:w-56 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-2xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                        <button type="button" id="btn-clear-search" onclick="clearSearchDip()" title="Hapus pencarian" 
                                class="{{ request('search') ? '' : 'hidden' }} absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Informasi Publik dengan Filter Terpadu (Akses Hanya Tautan Berkas) -->
            <div id="table-dip-wrapper" class="relative transition-opacity duration-150">
                <x-masyarakat.informasi_publik.table 
                    :informasi="$informasiList" 
                    :listJenis="$listJenis ?? []" 
                    :listTahun="$listTahun ?? []" 
                    :listSatker="$listSatker ?? []" 
                    :listBentuk="$listBentuk ?? []" 
                    :listRetensi="$listRetensi ?? []" 
                />
            </div>

            <!-- Card Bantuan / Ajukan Permohonan Jika Tidak Menemukan Informasi -->
            <div class="bg-gradient-to-r from-sky-600 via-sky-700 to-blue-800 text-white rounded-2xl p-6 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <h4 class="font-extrabold text-base sm:text-lg">Tidak Menemukan Informasi yang Anda Cari?</h4>
                    <p class="text-xs sm:text-sm text-sky-100">
                        Anda dapat mengajukan permohonan informasi publik secara online melalui formulir permohonan resmi PPID FMIPA Unila.
                    </p>
                </div>
                <a href="{{ url('/permohonan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-sky-700 hover:bg-sky-50 font-extrabold text-xs sm:text-sm rounded-xl transition shadow-sm cursor-pointer shrink-0 whitespace-nowrap">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <span>Ajukan Permohonan</span>
                </a>
            </div>

        </div>
    </div>

</main>

<!-- Helper Script Scroll & Click Counter -->
<x-masyarakat.informasi_publik.script />
@endsection

