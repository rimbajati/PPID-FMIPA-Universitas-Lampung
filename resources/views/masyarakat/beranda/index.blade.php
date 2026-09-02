@extends('components.layouts.app')

@section('title', 'Beranda - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-[124px] md:pt-[140px]">

    <!-- Hero Section Banner: Dekanat FMIPA & Konten Modern -->
    <x-masyarakat.beranda.hero />

    <!-- Kategori Informasi Publik Section -->
    <x-masyarakat.beranda.kategori-section />

</main>
@endsection
