@extends('components.layouts.app')

@section('title', 'Lacak & Riwayat Layanan - PPID FMIPA Unila')

@section('content')
<main class="pt-14 md:pt-[4.25rem] bg-slate-50 min-h-screen pb-24"
      x-data="lacakRiwayatApp({{ json_encode($allLayans) }})">



    <!-- Hero Header Pelacakan Terpadu -->
    <x-masyarakat.riwayat.hero-header />

    <!-- Main Container Content -->
    <div class="max-w-7xl mx-auto px-4 md:px-8 lg:px-12 pt-10 space-y-8">

        <!-- SECTION 1: FORM CARI TIKET -->
        <x-masyarakat.riwayat.list-grid :ticket="$ticket" :not-found="$notFound" />

        <!-- SECTION 2: DETAIL HASIL TRACKING REAL-TIME -->
        <x-masyarakat.riwayat.detail-card />

    </div>

</main>

<!-- Helper Script Lacak Riwayat -->
<x-masyarakat.riwayat.script />

<!-- Modal Notifikasi Sukses Pengajuan Tiket (Permohonan / Keberatan) -->
<x-masyarakat.layanan.modal-success-tiket />
@endsection
