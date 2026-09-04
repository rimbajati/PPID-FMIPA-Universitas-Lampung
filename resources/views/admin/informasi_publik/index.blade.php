@extends('components.layouts.admin')

@section('title', 'Manajemen Informasi Publik - Admin PPID')
@section('header_title', 'Informasi Publik')

@section('content')
<div class="space-y-6">

    <!-- Section Header: Informasi Publik Overview & Tombol Tambah Informasi -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Informasi Publik</h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">Kelola dan publikasikan informasi publik PPID FMIPA Universitas Lampung</p>
        </div>

        <!-- Tombol Tambah Utama -->
        <button type="button" onclick="openModalCreate()" 
                class="inline-flex items-center justify-center gap-2.5 px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer shrink-0">
            <i class="fa-solid fa-plus text-sm"></i>
            <span>Tambah</span>
        </button>
    </div>

    <!-- 5 Summary Cards -->
    <x-admin.informasi_publik.summary-cards 
        :totalInformasi="$totalInformasi"
        :totalBerkala="$totalBerkala"
        :totalSertaMerta="$totalSertaMerta"
        :totalSetiapSaat="$totalSetiapSaat"
        :totalDikecualikan="$totalDikecualikan"
        :lastUpdateTotal="$lastUpdateTotal"
        :lastUpdateBerkala="$lastUpdateBerkala"
        :lastUpdateSertaMerta="$lastUpdateSertaMerta"
        :lastUpdateSetiapSaat="$lastUpdateSetiapSaat"
        :lastUpdateDikecualikan="$lastUpdateDikecualikan"
    />

    <!-- Table Container & Filter Bar -->
    <x-admin.informasi_publik.table :informasi="$informasi" :listTahun="$listTahun" />

</div>
@endsection

@section('modals')
<x-admin.informasi_publik.modal-add-edit />
<x-modals.delete />
@endsection

<!-- Script Helper Admin Informasi Publik -->
<x-admin.informasi_publik.script />
