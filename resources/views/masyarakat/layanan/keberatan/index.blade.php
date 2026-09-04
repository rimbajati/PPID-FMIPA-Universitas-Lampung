@extends('components.layouts.app')

@section('title', 'Pengajuan Keberatan Informasi - PPID FMIPA Unila')

@section('content')
<main class="pt-[75px] md:pt-[85px] bg-slate-50 min-h-screen pb-24">

    <!-- Breadcrumb Bar Component -->
    <x-masyarakat.keberatan.breadcrumb />

    <!-- Header Hero Banner & Dasar Hukum -->
    <x-masyarakat.keberatan.hero-header />

    <!-- Main Container Form Pengajuan Keberatan Single Page -->
    <div id="keberatan-form-container" class="max-w-7xl mx-auto px-4 md:px-8 lg:px-12 pt-8" x-data="keberatanForm()">
        
        <!-- Box Pemberitahuan Peringatan -->
        <x-masyarakat.keberatan.alert-warning />

        <!-- Form Utama Pengajuan Keberatan -->
        <x-masyarakat.keberatan.form />

    </div>

</main>

<!-- Helper Alpine.js Logic -->
<x-masyarakat.keberatan.script :user="$user" :permohonanUser="$permohonanUser" />
@endsection
