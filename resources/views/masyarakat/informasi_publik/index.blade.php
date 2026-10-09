@extends('components.layouts.app')

@section('title', 'Katalog Informasi Publik - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-100/70 min-h-screen pb-20">

    <!-- Header Hero Banner (Matching Reference UI Title & Subtitle) -->
    <x-masyarakat.informasi_publik.hero-header />

    <!-- Tabel Unified DIP Masyarakat -->
    <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="space-y-6">
            <!-- Filter Bar Tunggal -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                    <span>Tampilkan</span>
                    <select id="select-per-page-main" data-dip-per-page="main" onchange="changePerPageDip('main', this.value)" class="px-3 py-1.5 bg-white border border-slate-900 rounded-lg text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                        <option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                    </select>
                    <span>baris</span>
                </div>
                <form onsubmit="event.preventDefault();" class="flex items-center gap-2">
                    <label for="cari-main" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">Cari:</label>
                    <div class="relative">
                        <input type="text" id="cari-main" data-dip-search="main" oninput="document.getElementById('btn-clear-search-main')?.classList.toggle('hidden', !this.value.trim()); searchDipTable('main', this.value)" value="{{ request('search') }}" autocomplete="off" class="w-64 sm:w-80 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-lg text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                        <button type="button" id="btn-clear-search-main" onclick="const i=document.getElementById('cari-main'); if(i){i.value=''; i.focus();} this.classList.add('hidden'); searchDipTable('main', '');" title="Hapus pencarian" class="{{ request('search') ? '' : 'hidden' }} absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </form>
            </div>

            <x-masyarakat.informasi_publik.table :informasi="$informasiList" tableKey="main" unified="true" />

            <!-- Card Bantuan -->
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
    </div>

</main>

<!-- Helper Script Scroll & Click Counter -->
<x-masyarakat.informasi_publik.script />
@endsection

