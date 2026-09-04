@extends('components.layouts.app')

@section('title', 'Layanan Informasi Publik - PPID FMIPA Unila')

@section('content')
<main class="pt-[64px] md:pt-[70px] bg-slate-50 min-h-screen pb-20">

    <!-- Header Hero Portal Layanan -->
    <x-masyarakat.layanan.hero-header />

    <!-- Container Utama Grid Pilihan Layanan & Helpdesk -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12 lg:px-16 pt-8">
        <x-masyarakat.layanan.cards-grid />
    </div>

</main>

<!-- Modal Notifikasi Sukses Pengajuan Tiket -->
<x-masyarakat.layanan.modal-success-tiket />
@endsection
