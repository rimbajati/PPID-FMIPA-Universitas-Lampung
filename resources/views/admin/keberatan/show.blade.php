@extends('components.layouts.admin')

@section('title', 'Detail Keberatan - ' . ($keberatan->no_tiket ?? 'PPID FMIPA'))
@section('header_title', 'Detail Pengajuan Keberatan')

@section('content')
<div class="space-y-6 pb-12">

    <!-- Top Action Bar / Header Navigasi -->
    <x-admin.keberatan.detail.header :keberatan="$keberatan" />



    <!-- 2-COLUMN MAIN LAYOUT (Persis Referensi: Kiri Data ~68%, Kanan Status & Aksi ~32%) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- KOLOM KIRI: DATA KEBERATAN & BERKAS (Card Terpadu ala Referensi) -->
        <div class="lg:col-span-8 bg-white rounded border border-slate-200/90 shadow-2xs overflow-hidden">
            <!-- Header Kartu: Background abu-abu terang, bergaris bawah tipis, ikon timbangan + teks di kiri, badge tiket hitam/slate di kanan -->
            <div class="bg-slate-50/80 px-5 py-3 border-b border-slate-200/90 flex items-center justify-between">
                <div class="flex items-center gap-2 text-slate-900 font-extrabold text-sm sm:text-base">
                    <i class="fa-solid fa-scale-balanced text-slate-900 text-sm"></i>
                    <span>Detail Keberatan</span>
                </div>
            </div>

            <div class="p-5">
                <!-- Data Detail Keberatan & Berkas Lampiran Terpadu -->
                <x-admin.keberatan.detail.detail-keberatan :keberatan="$keberatan" />
            </div>
        </div>

        <!-- KOLOM KANAN: STATUS & PANEL AKSI ATASAN PPID (STICKY) -->
        <div class="lg:col-span-4 space-y-4 lg:sticky lg:top-6">
            <!-- Komponen 4: Panel Status & Form Pemrosesan Atasan PPID -->
            <x-admin.keberatan.detail.status-panel :keberatan="$keberatan" />
        </div>

    </div>

</div>
@endsection
