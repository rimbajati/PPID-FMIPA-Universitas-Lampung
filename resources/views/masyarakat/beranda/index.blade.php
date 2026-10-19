@extends('components.layouts.app')

@section('title', 'Beranda - PPID Pelaksana FMIPA Universitas Lampung')

@section('content')
<main class="bg-slate-50/50" style="padding-top:var(--header-h)">

    <!-- 1. Hero Section Banner: Dekanat FMIPA & Konten Modern -->
    <x-masyarakat.beranda.hero />

    <!-- 2. Tentang Kami & Nilai Pelayanan Kami -->
    <x-masyarakat.beranda.tentang-kami />

    <!-- DUPLICATE PREVENTION: Route profil sekarang halaman sendiri; link footer/navbar sudah ke /profil-ppid -->

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
    <x-masyarakat.beranda.cta-helpdesk :profil="$profil" />

</main>
@endsection

