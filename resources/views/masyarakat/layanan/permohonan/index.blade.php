@extends('components.layouts.app')

@section('title', 'Ajukan Permohonan Informasi - PPID FMIPA Unila')

@section('content')
<main class="pt-[64px] md:pt-[70px] bg-slate-50 min-h-screen pb-24">

    <!-- Header Hero Banner Permohonan Informasi -->
    <x-masyarakat.permohonan.hero-header />

    <!-- Main Container Content (Wide Layout 2 Kolom) -->
    <div id="permohonan-form-container" class="max-w-7xl mx-auto px-4 md:px-8 lg:px-12 pt-8" x-data="permohonanSingleForm()">
        
        <!-- SINGLE UNIFIED FORM CONTAINER -->
        <x-masyarakat.permohonan.form />
    </div>

</main>

<!-- Helper Alpine.js Form Logic -->
<x-masyarakat.permohonan.script :user="$user" />
@endsection
