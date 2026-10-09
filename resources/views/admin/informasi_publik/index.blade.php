@extends('components.layouts.admin')

@section('title', 'Daftar Informasi Publik (DIP) - Admin PPID')
@section('header_title', 'Daftar Informasi Publik (DIP)')

@section('content')
<div class="space-y-6">

    @php $dipSelectedKategori = trim((string) request()->query('kategori', '')); @endphp
    <!-- Section Header: Dinamis sesuai Klasifikasi yang Dipilih -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                @if($dipSelectedKategori === 'Informasi Berkala') Informasi Publik yang Wajib Disediakan Secara Berkala
                @elseif($dipSelectedKategori === 'Informasi Setiap Saat') Informasi Publik yang Wajib Tersedia Setiap Saat
                @elseif($dipSelectedKategori === 'Informasi Serta-Merta') Informasi Publik yang Wajib Diumumkan Secara Serta-Merta
                @else Daftar Informasi Publik
                @endif
            </h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">
                @if($dipSelectedKategori === 'Informasi Berkala') Kelola informasi publik yang wajib disediakan secara berkala
                @elseif($dipSelectedKategori === 'Informasi Setiap Saat') Kelola informasi yang wajib tersedia setiap saat
                @elseif($dipSelectedKategori === 'Informasi Serta-Merta') Kelola informasi yang wajib diumumkan secara serta-merta
                @else Kelola dan publikasikan informasi publik PPID FMIPA Universitas Lampung
                @endif
            </p>
        </div>

            <!-- Tombol Aksi Header (Export & Tambah) -->
            <div class="flex items-center gap-2.5 shrink-0">
                <!-- Tombol Export Sesuai Kategori, Filter, dan Sort Header Aktif -->
                <a id="btn-export-pdf" href="{{ route('admin.export.informasi.pdf', request()->only(['kategori', 'tahun', 'satker', 'search', 'sort_by', 'sort_direction'])) }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                    <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i>
                    <span>Export</span>
                </a>

                <!-- Tombol Tambah Utama -->
                <button type="button" onclick="openModalCreate()" 
                        class="inline-flex items-center justify-center gap-2.5 px-5 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer">
                    <i class="fa-solid fa-plus text-sm"></i>
                    <span>Tambah</span>
                </button>
            </div>
    </div>

    @if($dipSelectedKategori === '')
    <!-- Kartu Visual Klasifikasi Informasi Publik — hanya tampil di mode keseluruhan -->
    <x-admin.informasi_publik.summary-cards
        :totalInformasi="$totalInformasi"
        :totalBerkala="$totalBerkala"
        :totalSertaMerta="$totalSertaMerta"
        :totalSetiapSaat="$totalSetiapSaat"
        :lastUpdateTotal="$lastUpdateTotal"
        :lastUpdateBerkala="$lastUpdateBerkala"
        :lastUpdateSertaMerta="$lastUpdateSertaMerta"
        :lastUpdateSetiapSaat="$lastUpdateSetiapSaat"
    />
    @endif

    <form id="form-bulk-delete" action="{{ route('admin.informasi.bulk') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <div id="bulk-selected-inputs"></div>
    </form>

    @php
        $selectedKategori = trim((string) request()->query('kategori', ''));
        $isUnifiedView = $selectedKategori === '';
        $displayInformasi = $isUnifiedView ? $informasi : $informasiGroups->get($selectedKategori, collect());
        $dipTableKey = $isUnifiedView ? 'unified' : 'kategori';
    @endphp

    {{-- Bar filter: Hapus di kiri Tampilkan, Cari di kanan --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3 flex-wrap">
            <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition shadow-2xs hover:shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-list-check"></i> <span id="text-select-mode">Hapus</span>
            </button>
            <button type="button" id="btn-bulk-delete" onclick="triggerBulkDelete()"
                    class="hidden inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-2xl transition shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-trash"></i> <span>Hapus (<span id="selected-count">0</span>) data terpilih</span>
            </button>
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                <span>Tampilkan</span>
                <select data-admin-dip-per-page="{{ $dipTableKey }}" id="select-per-page-admin-dip-{{ $dipTableKey }}" onchange="changePerPageAdminDip('{{ $dipTableKey }}', this.value)" class="px-3 py-1.5 bg-white border border-slate-900 rounded-lg text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                    <option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                </select>
                <span>baris</span>
            </div>
        </div>
        <form onsubmit="event.preventDefault();" class="flex items-center gap-2">
            <label for="input-search-admin-dip-{{ $dipTableKey }}" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">Cari:</label>
            <div class="relative">
                <input type="text" id="input-search-admin-dip-{{ $dipTableKey }}" data-admin-dip-search="{{ $dipTableKey }}" oninput="document.getElementById('btn-clear-search-admin-dip-{{ $dipTableKey }}')?.classList.toggle('hidden', !this.value.trim()); searchAdminDipTable('{{ $dipTableKey }}', this.value)" value="{{ request('search') }}" autocomplete="off" class="w-64 sm:w-80 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-lg text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                <button type="button" id="btn-clear-search-admin-dip-{{ $dipTableKey }}" onclick="const i=document.getElementById('input-search-admin-dip-{{ $dipTableKey }}'); if(i){i.value=''; i.focus();} this.classList.add('hidden'); searchAdminDipTable('{{ $dipTableKey }}', '');" title="Hapus pencarian" class="{{ request('search') ? '' : 'hidden' }} absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </form>
    </div>

    @if($isUnifiedView)
        <x-admin.informasi_publik.table :informasi="$displayInformasi" :table-key="'unified'" :force-table="false" :unified="true" />
    @else
        <x-admin.informasi_publik.table :informasi="$displayInformasi" :table-key="'kategori'" :force-table="false" :unified="false" />
    @endif

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
