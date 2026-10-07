@extends('components.layouts.admin')

@section('title', 'Daftar Informasi Publik (DIP) - Admin PPID')
@section('header_title', 'Daftar Informasi Publik (DIP)')

@section('content')
<div class="space-y-6">

    <!-- Section Header: Dinamis sesuai Klasifikasi yang Dipilih -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                Daftar Informasi Publik
            </h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">
                Kelola dan publikasikan informasi publik PPID FMIPA Universitas Lampung
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

    <form id="form-bulk-delete" action="{{ route('admin.informasi.bulk') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <div id="bulk-selected-inputs"></div>
    </form>

    <!-- Kontrol pemilihan berlaku untuk semua tabel kategori -->
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

    </div>

    @php
        $jenisPublik = [
            ['nama' => 'Informasi Berkala', 'judul' => 'Informasi Publik yang Wajib Disediakan secara Berkala', 'key' => 'berkala', 'deskripsi' => 'informasi yang wajib disediakan secara berkala.'],
            ['nama' => 'Informasi Setiap Saat', 'judul' => 'Informasi Publik yang Wajib Tersedia Setiap Saat', 'key' => 'setiap-saat', 'deskripsi' => 'informasi yang tersedia untuk diakses setiap saat.'],
            ['nama' => 'Informasi Serta-Merta', 'judul' => 'Informasi Publik yang Wajib Diumumkan secara Serta-Merta', 'key' => 'serta-merta', 'deskripsi' => 'informasi yang wajib diumumkan segera.'],
        ];
    @endphp

    @php $selectedKategori = trim((string) request()->query('kategori', '')); @endphp
    <div class="space-y-10">
        @foreach($jenisPublik as $jenis)
            @if($selectedKategori === '' || mb_strtolower($selectedKategori) === mb_strtolower($jenis['nama']))
            @php $daftarJenis = $informasiGroups->get($jenis['nama'], collect()); @endphp
            <section class="space-y-4" aria-labelledby="judul-admin-{{ $jenis['key'] }}">
                <header class="space-y-1">
                    <h2 id="judul-admin-{{ $jenis['key'] }}" class="text-xl md:text-2xl font-extrabold text-slate-900">{{ $jenis['judul'] }}</h2>
                    <p class="text-sm md:text-base text-slate-600">{{ number_format($daftarJenis->count(), 0, ',', '.') }} informasi {{ $jenis['deskripsi'] }}</p>
                </header>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-800">Tampilkan
                        <select data-admin-dip-per-page="{{ $jenis['key'] }}" onchange="changePerPageAdminDip('{{ $jenis['key'] }}', this.value)" class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm font-bold text-slate-900">
                            <option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                        </select> baris
                    </label>
                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-800">Cari:
                        <input data-admin-dip-search="{{ $jenis['key'] }}" oninput="searchAdminDipTable('{{ $jenis['key'] }}', this.value)" value="{{ request('search') }}" class="w-48 sm:w-64 px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-normal focus:outline-none focus:ring-2 focus:ring-sky-500/30">
                    </label>
                </div>

                <x-admin.informasi_publik.table :informasi="$daftarJenis" :table-key="$jenis['key']" :force-table="$selectedKategori === ''" />
            </section>
            @endif
        @endforeach
    </div>

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
