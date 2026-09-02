@extends('components.layouts.app')

@section('title', 'Katalog Informasi Publik - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-[64px] md:pt-[70px] bg-slate-50 min-h-screen pb-20">

    <!-- Header Hero Banner Katalog Informasi Publik -->
    <x-masyarakat.informasi_publik.hero-header />

    <!-- Main Content Container (Layout Horizontal Modern Full-Width) -->
    <div class="px-6 md:px-16 lg:px-24 mt-8">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Top Horizontal Filter & Full Search Bar -->
            <x-masyarakat.informasi_publik.top-filter-bar :years="$years" :totalCount="$totalCount" :kategoryCounts="$kategoryCounts" />

            <!-- Catalog Grid / List View Full-Width -->
            <x-masyarakat.informasi_publik.catalog-grid :informasiList="$informasiList" />

        </div>
    </div>

</main>

<!-- Helper Script Scroll & Click Counter -->
<x-masyarakat.informasi_publik.script />
@endsection
