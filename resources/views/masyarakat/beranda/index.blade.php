@extends('components.layouts.app')

@section('title', 'Beranda - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-[6.875rem] md:pt-32 bg-slate-50/50">

    <!-- 1. Hero Section Banner: Dekanat FMIPA & Konten Modern -->
    <x-masyarakat.beranda.hero />

    <!-- 3. Alur & Prosedur Permohonan Layanan -->
    <x-masyarakat.beranda.alur-prosedur />

    <!-- 4. Statistik Transparansi PPID FMIPA Unila -->
    <x-masyarakat.beranda.statistik-section 
        :totalDokumen="$totalDokumen"
        :totalPermohonan="$totalPermohonan"
        :totalPermohonanSelesai="$totalPermohonanSelesai"
        :totalPermohonanDitolak="$totalPermohonanDitolak"
        :totalKeberatan="$totalKeberatan"
        :totalDilihat="$totalDilihat"
        :kategoriCount="$kategoriCount"
        :chartTahunan="$chartTahunan"
        :chartBulanan="$chartBulanan"
        :chartBulananPerTahun="$chartBulananPerTahun"
        :rataRataWaktuTeks="$rataRataWaktuTeks"
    />

    <!-- 5. Tanya Jawab / FAQ Seputar PPID (Accordion) -->
    <x-masyarakat.beranda.faq-section :faqs="$faqs" />

    <!-- Banner Call to Action & Bantuan Helpdesk -->
    <x-masyarakat.beranda.cta-helpdesk />

</main>
@endsection

