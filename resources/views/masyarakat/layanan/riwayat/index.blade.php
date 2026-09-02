@extends('components.layouts.app')

@section('title', 'Lacak & Riwayat Layanan - PPID FMIPA Unila')

@section('content')
<main class="pt-[64px] md:pt-[70px] bg-slate-50 min-h-screen pb-24" 
      x-data="lacakRiwayatApp({{ json_encode($allLayans) }})">

    <!-- Hero Header Pelacakan Terpadu -->
    <x-masyarakat.riwayat.hero-header />

    <!-- Main Container Content -->
    <div class="max-w-7xl mx-auto px-4 md:px-8 lg:px-12 pt-10 space-y-12">

        <!-- DETAIL HASIL TRACKING REAL-TIME -->
        <x-masyarakat.riwayat.detail-card />

        <!-- SECTION 2: GRID KARTU DAFTAR RIWAYAT LAYANAN SAYA -->
        <x-masyarakat.riwayat.list-grid />

    </div>

</main>

<!-- Helper Script Lacak Riwayat -->
<x-masyarakat.riwayat.script />
@endsection
