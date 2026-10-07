@extends('components.layouts.app')

@section('title', 'Katalog Informasi Publik - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-100/70 min-h-screen pb-20">

    <!-- Header Hero Banner (Matching Reference UI Title & Subtitle) -->
    <x-masyarakat.informasi_publik.hero-header />

    <!-- Tiga daftar terpisah berdasarkan jenis informasi -->
    <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 mt-6 space-y-10">
        @php
            $jenisPublik = [
                ['nama' => 'Informasi Berkala', 'judul' => 'A. Informasi Publik yang Wajib Disediakan secara Berkala', 'key' => 'berkala', 'deskripsi' => 'informasi yang wajib disediakan dan dapat diakses secara berkala.'],
                ['nama' => 'Informasi Setiap Saat', 'judul' => 'B. Informasi Publik yang Wajib Tersedia Setiap Saat', 'key' => 'setiap-saat', 'deskripsi' => 'informasi yang wajib tersedia dan dapat diakses setiap saat.'],
                ['nama' => 'Informasi Serta-Merta', 'judul' => 'C. Informasi Publik yang Wajib Diumumkan secara Serta-Merta', 'key' => 'serta-merta', 'deskripsi' => 'informasi yang wajib diumumkan segera tanpa penundaan.'],
            ];
        @endphp

        @foreach($jenisPublik as $jenis)
            @php $daftarJenis = $informasiGroups->get($jenis['nama'], collect()); @endphp
            <section class="space-y-4" aria-labelledby="judul-{{ $jenis['key'] }}">
                <header class="space-y-1">
                    <h2 id="judul-{{ $jenis['key'] }}" class="text-xl md:text-2xl font-extrabold text-slate-900">{{ $jenis['judul'] }}</h2>
                    <p class="text-sm md:text-base text-slate-600">{{ number_format($daftarJenis->count(), 0, ',', '.') }} informasi {{ $jenis['deskripsi'] }}</p>
                </header>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
                    <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                        <span>Tampilkan</span>
                        <select data-dip-per-page="{{ $jenis['key'] }}" onchange="changePerPageDip('{{ $jenis['key'] }}', this.value)" class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500/30 cursor-pointer">
                            <option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                        </select>
                        <span>baris</span>
                    </div>
                    <form onsubmit="event.preventDefault();" class="flex items-center gap-2">
                        <label for="cari-{{ $jenis['key'] }}" class="text-sm font-semibold text-slate-800">Cari:</label>
                        <input id="cari-{{ $jenis['key'] }}" data-dip-search="{{ $jenis['key'] }}" oninput="searchDipTable('{{ $jenis['key'] }}', this.value)" value="{{ request('search') }}" autocomplete="off" class="w-48 sm:w-64 px-3 py-2 text-sm bg-white border border-slate-300 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-sky-500/30">
                    </form>
                </div>

                <x-masyarakat.informasi_publik.table :informasi="$daftarJenis" :tableKey="$jenis['key']" />
            </section>
        @endforeach

            <!-- Card Bantuan / Ajukan Permohonan Jika Tidak Menemukan Informasi -->
            <div class="bg-gradient-to-r from-sky-600 via-sky-700 to-blue-800 text-white rounded-2xl p-6 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <h4 class="font-extrabold text-base sm:text-lg">Tidak Menemukan Informasi yang Anda Cari?</h4>
                    <p class="text-xs sm:text-sm text-sky-100">
                        Anda dapat mengajukan permohonan informasi publik secara online melalui formulir permohonan resmi PPID FMIPA Unila.
                    </p>
                </div>
                <a href="{{ url('/permohonan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-sky-700 hover:bg-sky-50 font-extrabold text-xs sm:text-sm rounded-xl transition shadow-sm cursor-pointer shrink-0 whitespace-nowrap">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <span>Ajukan Permohonan</span>
                </a>
            </div>

        </div>
    </div>

</main>

<!-- Helper Script Scroll & Click Counter -->
<x-masyarakat.informasi_publik.script />
@endsection

