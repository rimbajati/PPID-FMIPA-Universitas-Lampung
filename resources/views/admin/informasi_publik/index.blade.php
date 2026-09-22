@extends('components.layouts.admin')

@section('title', 'Daftar Informasi Publik (DIP) - Admin PPID')
@section('header_title', 'Daftar Informasi Publik (DIP)')

@section('content')
<div class="space-y-6">

    <!-- Section Header: Dinamis sesuai Klasifikasi yang Dipilih -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                {{ request('kategori') ? request('kategori') : 'Daftar Informasi Publik' }}
            </h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">
                @if(request('kategori'))
                    Kelola rincian informasi dan sub informasi untuk klasifikasi {{ request('kategori') }}
                @else
                    Kelola dan publikasikan informasi publik PPID FMIPA Universitas Lampung
                @endif
            </p>
        </div>

            <!-- Tombol Aksi Header (Cetak PDF & Tambah) -->
            <div class="flex items-center gap-2.5 shrink-0">
                <!-- Tombol Export PDF Sesuai Kategori, Filter, dan Sort Header Aktif -->
                <a id="btn-export-pdf" href="{{ route('admin.export.informasi.pdf', request()->only(['kategori', 'tahun', 'satker', 'search', 'sort_by', 'sort_direction'])) }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                    <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i>
                    <span>Export PDF</span>
                </a>

                <!-- Tombol Export Excel/CSV Sesuai Kategori, Filter, dan Sort Header Aktif -->
                <a id="btn-export-excel" href="{{ route('admin.export.informasi.excel', request()->only(['kategori', 'tahun', 'satker', 'search', 'sort_by', 'sort_direction'])) }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-emerald-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                    <i class="fa-solid fa-file-excel text-emerald-600 text-sm"></i>
                    <span>Export Excel</span>
                </a>

                <!-- Tombol Tambah Utama -->
                <button type="button" onclick="openModalCreate()" 
                        class="inline-flex items-center justify-center gap-2.5 px-5 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer">
                    <i class="fa-solid fa-plus text-sm"></i>
                    <span>Tambah</span>
                </button>
            </div>
    </div>

    <!-- Bar Kontrol Tabel: Mode Pilih & Show Entries di Kiri, Search di Kanan -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
        <!-- Sisi Kiri: Tombol Mode Pilih, Tombol Hapus Bulk, dan Show Entries Dropdown -->
        <div class="flex items-center gap-3 flex-wrap">
            <!-- Tombol Mode Hapus -->
            <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition shadow-2xs hover:shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-list-check"></i> <span id="text-select-mode">Hapus</span>
            </button>

            <!-- Tombol Hapus Bulk (Muncul saat mode pilih aktif & ada item dicentang) -->
            <button type="button" id="btn-bulk-delete" onclick="triggerBulkDelete()"
                    class="hidden inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-2xl transition shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-trash"></i> <span>Hapus (<span id="selected-count">0</span>) data terpilih</span>
            </button>

            <!-- Dropdown Show Entries -->
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                <span>Show</span>
                <select id="select-per-page-admin-dip" onchange="changePerPageAdminDip(this.value)" 
                        class="px-3 py-1.5 bg-white border border-slate-900 rounded-2xl text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                    <option value="10" {{ (int)request('per_page', 10) === 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ (int)request('per_page', 10) === 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ (int)request('per_page', 10) === 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ (int)request('per_page', 10) === 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>entries</span>
            </div>
        </div>

        <!-- Sisi Kanan: Search Bar Pencarian Seluruh Isi Tabel (Format DataTables: Search: [_____ x]) -->
        <form id="form-search-admin-dip" onsubmit="event.preventDefault();" class="flex items-center gap-2">
            <label for="input-search-admin-dip" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">
                Search:
            </label>
            <div class="relative">
                <input type="text" 
                       name="search" 
                       id="input-search-admin-dip"
                       value="{{ request('search') }}" 
                       autocomplete="off"
                       oninput="debounceSearchAdminDip()"
                       class="w-48 sm:w-56 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-2xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                <button type="button" id="btn-clear-search-admin-dip" onclick="clearSearchAdminDip()" title="Hapus pencarian" 
                        class="{{ request('search') ? '' : 'hidden' }} absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Container & Data Tabel -->
    <x-admin.informasi_publik.table :informasi="$informasi" :listJenis="$listJenis ?? []" :listTahun="$listTahun" :listSatker="$listSatker" :listBentuk="$listBentuk ?? []" :listRetensi="$listRetensi ?? []" />

</div>
@endsection

@section('modals')
<x-admin.informasi_publik.modal-add-edit 
    :listRincian="$listRincian ?? []" 
    :listRincianBerkala="$listRincianBerkala ?? []" 
    :listRincianSetiapSaat="$listRincianSetiapSaat ?? []" 
    :listRincianSertaMerta="$listRincianSertaMerta ?? []" 
    :listJudul="$listJudul ?? []"
    :listSatker="$listSatker ?? []"
    :listPenanggungJawab="$listPenanggungJawab ?? []"
    :listTahun="$listTahun ?? []"
    :listRetensi="$listRetensi ?? []"
/>
<x-modals.delete />
@endsection

@push('scripts')
<x-admin.informasi_publik.script 
    :listRincianBerkala="$listRincianBerkala ?? []" 
    :listRincianSetiapSaat="$listRincianSetiapSaat ?? []" 
    :listRincianSertaMerta="$listRincianSertaMerta ?? []" 
    :listRincian="$listRincian ?? []"
    :listSubByRincian="$listSubByRincian ?? []"
/>
@endpush
