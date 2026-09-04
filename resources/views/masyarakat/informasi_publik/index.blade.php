@extends('components.layouts.app')

@section('title', 'Katalog Informasi Publik - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-[64px] md:pt-[70px] bg-slate-100/70 min-h-screen pb-20">

    <!-- Header Hero Banner (Matching Reference UI Title & Subtitle) -->
    <x-masyarakat.informasi_publik.hero-header />

    <!-- Main 2-Column Grid Container (Matching Reference Layout) -->
    <div class="px-4 sm:px-8 md:px-12 lg:px-16 mt-4">
        <div class="max-w-[1600px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT COLUMN: Filter Bar & Table View (lg:col-span-9) -->
            <div class="lg:col-span-9 space-y-6">
                
                <!-- Pill Filter Bar & Search Box Card -->
                <x-masyarakat.informasi_publik.top-filter-bar :years="$years" :totalCount="$totalCount" :kategoryCounts="$kategoryCounts" />

                <!-- Catalog Table List with Dark Navy Header Bar -->
                <x-masyarakat.informasi_publik.catalog-grid :informasiList="$informasiList" />

            </div>

            <!-- RIGHT COLUMN: Tag Cloud & Permohonan (lg:col-span-3) -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Sidebar Card: Total Informasi Publik Quick Filter -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-xs space-y-4">
                    <h3 class="text-md font-extrabold text-slate-700">
                        Total Informasi Publik
                    </h3>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ url('/informasi-publik') }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-800 text-xs font-bold rounded-full transition shadow-2xs group">
                            <span>Semua</span>
                            <span class="px-2 py-0.5 bg-white group-hover:bg-white/20 text-sky-700 group-hover:text-white text-[11px] font-black rounded-full shadow-2xs">{{ $totalCount }}</span>
                        </a>

                        @foreach($kategoryCounts as $cName => $cCount)
                            <a href="{{ url('/informasi-publik?kategori=' . urlencode($cName)) }}" 
                               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 {{ request('kategori') === $cName ? 'bg-[#1B365D] text-white' : 'bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-800' }} text-xs font-bold rounded-full transition shadow-2xs group">
                                <span>{{ Str::replace('Informasi ', '', $cName) }}</span>
                                <span class="px-2 py-0.5 {{ request('kategori') === $cName ? 'bg-white/20 text-white' : 'bg-white group-hover:bg-white/20 text-sky-700 group-hover:text-white' }} text-[11px] font-black rounded-full shadow-2xs">{{ $cCount }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Ajukan Permohonan Card -->
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white rounded-3xl p-6 shadow-lg shadow-blue-600/20 space-y-3 border border-blue-500/20">
                    <h4 class="font-extrabold text-base">Tidak Menemukan Informasi?</h4>
                    <p class="text-xs text-blue-100 leading-relaxed">
                        Anda dapat mengajukan permohonan informasi publik secara online melalui formulir permohonan resmi.
                    </p>
                    <a href="{{ url('/permohonan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-blue-600 hover:bg-blue-50 font-extrabold text-xs rounded-full transition shadow-sm cursor-pointer">
                        <i class="fa-solid fa-file-circle-plus"></i> Ajukan Permohonan
                    </a>
                </div>
            </div>

        </div>
    </div>

</main>

<!-- Helper Script Scroll & Click Counter -->
<x-masyarakat.informasi_publik.script />
@endsection

