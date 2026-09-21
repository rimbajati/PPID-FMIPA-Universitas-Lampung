@extends('components.layouts.admin')

@section('title', 'Informasi Serta-Merta - Admin PPID')
@section('header_title', 'Informasi Serta-Merta')

@section('content')
<div class="space-y-6">

    <!-- Section Header: Informasi Serta-Merta Overview & Tombol Tambah -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Informasi Serta-Merta</h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">Publikasikan pengumuman, peringatan dini, dan surat edaran penting/mendesak bagi publik</p>
        </div>

        <!-- Tombol Aksi Header -->
        <div class="flex items-center gap-2.5 shrink-0">
            <!-- Tombol Export PDF Informasi Serta-Merta Sesuai Sort & Search -->
            <a id="btn-export-serta-merta-pdf" href="{{ route('admin.export.informasi.pdf', ['kategori' => 'Informasi Serta-Merta']) }}" target="_blank"
               class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i>
                <span>Export PDF</span>
            </a>

            <!-- Tombol Export Excel Informasi Serta-Merta Sesuai Sort & Search -->
            <a id="btn-export-serta-merta-excel" href="{{ route('admin.export.informasi.excel', ['kategori' => 'Informasi Serta-Merta']) }}" target="_blank"
               class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-emerald-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                <i class="fa-solid fa-file-excel text-emerald-600 text-sm"></i>
                <span>Export Excel</span>
            </a>

            <!-- Tombol Tambah Utama -->
            <button type="button" onclick="openModalCreateSertaMerta()" 
                    class="inline-flex items-center justify-center gap-2.5 px-5 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer">
                <i class="fa-solid fa-plus text-sm"></i>
                <span>Tambah Informasi</span>
            </button>
        </div>
    </div>

    <!-- Bar Kontrol Tabel: Mode Pilih & Show Entries di Kiri, Search di Kanan -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
        <!-- Sisi Kiri: Tombol Mode Pilih, Tombol Hapus Bulk, dan Show Entries Dropdown -->
        <div class="flex items-center gap-3 flex-wrap">
            <!-- Tombol Mode Pilih -->
            <button type="button" id="btn-toggle-select" onclick="toggleSelectModeSertaMerta()"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition shadow-2xs hover:shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-list-check"></i> <span id="text-select-mode">Pilih</span>
            </button>

            <!-- Tombol Hapus Bulk (Muncul saat mode pilih aktif & ada item dicentang) -->
            <button type="button" id="btn-bulk-delete" onclick="triggerBulkDeleteSertaMerta()"
                    class="hidden inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-2xl transition shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-trash"></i> <span>Hapus (<span id="selected-count">0</span>) data terpilih</span>
            </button>

            <!-- Dropdown Show Entries -->
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                <span>Show</span>
                <select id="select-per-page-serta-merta" onchange="changePerPageSertaMerta(this.value)" 
                        class="px-3 py-1.5 bg-white border border-slate-900 rounded-2xl text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>entries</span>
            </div>
        </div>

        <!-- Sisi Kanan: Search Bar Pencarian Seluruh Isi Tabel (Format DataTables: Search: [_____ x]) -->
        <form id="form-search-serta-merta" onsubmit="event.preventDefault();" class="flex items-center gap-2">
            <label for="input-search-serta-merta" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">
                Search:
            </label>
            <div class="relative">
                <input type="text" 
                       name="search" 
                       id="input-search-serta-merta" 
                       autocomplete="off"
                       oninput="debounceSearchSertaMerta()"
                       class="w-48 sm:w-56 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-2xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                <button type="button" id="btn-clear-search-serta-merta" onclick="clearSearchSertaMerta()" title="Hapus pencarian" 
                        class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Container Informasi Serta-Merta -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <form id="form-bulk-delete-serta-merta" action="{{ route('admin.informasi-serta-merta.bulk') }}" method="POST">
            @csrf
            @method('DELETE')

            <div>
                <table class="w-full table-fixed text-left border-collapse border border-slate-200">
                    <thead>
                        <tr class="bg-sky-500 text-white text-xs md:text-sm font-extrabold tracking-wide divide-x divide-white/20 select-none">
                            <th id="col-checkbox-header" class="hidden px-2 py-3.5 w-12 text-center">
                                <input type="checkbox" id="check-all" onclick="toggleCheckAllSertaMerta(this)" class="w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer">
                            </th>
                            <th onclick="sortSertaMertaTable('no')" class="px-2 py-3.5 text-center w-14 shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
                                <div class="flex items-center justify-center gap-1.5">
                                    <span>No</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th onclick="sortSertaMertaTable('judul')" class="px-4 py-3.5 text-left w-[46%] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Judul Informasi">
                                <div class="flex items-center justify-between gap-1.5">
                                    <span>Judul Informasi Serta-Merta</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th onclick="sortSertaMertaTable('waktu')" class="px-3.5 py-3.5 text-center w-[20%] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Waktu / Tanggal Terbit">
                                <div class="flex items-center justify-center gap-1.5">
                                    <span>Waktu / Tanggal Terbit</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th onclick="sortSertaMertaTable('pejabat')" class="px-3.5 py-3.5 text-center w-[20%] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Unit Penerbit">
                                <div class="flex items-center justify-center gap-1.5">
                                    <span>Unit / Satker Penerbit</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th class="px-3 py-3.5 text-center w-[14%] shrink-0">
                                <span>Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table-serta-merta-body" class="divide-y divide-slate-200 text-xs md:text-sm">
                        @forelse($items as $idx => $item)
                            @php
                                $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->judul_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                    ? $item->link_informasi 
                                    : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName)).'?from_admin=1' : null);
                            @endphp
                            <tr class="table-serta-merta-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-200"
                                data-id="{{ $item->id }}"
                                data-no="{{ $idx + 1 }}"
                                data-dilihat="{{ (int)($item->dilihat ?? 0) }}"
                                data-judul="{{ strtolower($item->judul_informasi ?? '') }}"
                                data-waktu="{{ strtolower($item->waktu_pembuatan_informasi ?? '') }}"
                                data-pejabat="{{ strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '') }}">
                                
                                <td class="col-checkbox-cell hidden px-2 py-3 text-center">
                                    <input type="checkbox" name="ids[]" form="form-bulk-delete-serta-merta" value="{{ $item->id }}" onclick="updateBulkStateSertaMerta()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                                </td>

                                <td class="col-serta-merta-no px-2 py-3 text-center font-bold text-slate-400">
                                    {{ $idx + 1 }}
                                </td>

                                <td class="px-4 py-3 font-medium text-slate-800 leading-relaxed align-middle break-words">
                                    <div class="space-y-1">
                                        <div class="font-extrabold text-slate-900 text-xs sm:text-sm" title="{{ $item->judul_informasi }}">
                                            {{ $item->judul_informasi }}
                                        </div>
                                        @if($item->dilihat)
                                            <div class="text-[11px] text-slate-400 font-semibold flex items-center gap-1.5">
                                                <i class="fa-regular fa-eye text-[10px]"></i>
                                                <span>{{ number_format($item->dilihat) }} dilihat</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-3.5 py-3 text-center font-bold text-slate-700 break-words text-xs sm:text-sm leading-normal align-middle">
                                    {{ $item->waktu_pembuatan_informasi }}
                                </td>

                                <td class="px-3.5 py-3 text-center font-medium text-slate-700 break-words text-xs sm:text-sm leading-normal align-middle">
                                    {{ $item->pejabat_unit_yang_menguasai_informasi ?: '-' }}
                                </td>

                                <td class="px-2 py-2.5 text-center align-middle">
                                    <div class="flex items-center justify-center gap-1.5">
                                        @if($fileTargetUrl)
                                            <a href="{{ $fileTargetUrl }}" target="_blank" title="Lihat Tautan / Berkas" 
                                               class="w-7 h-7 flex items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white transition shadow-2xs rounded-lg">
                                                <i class="fa-regular fa-eye text-[11px]"></i>
                                            </a>
                                        @endif
                                        <button type="button" onclick="openModalEditSertaMerta({{ json_encode($item) }})" title="Edit Data" class="w-7 h-7 flex items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        </button>
                                        <button type="button" onclick="triggerDeleteSertaMerta('{{ route('admin.informasi-serta-merta.destroy', $item->id) }}', '{{ addslashes($item->judul_informasi) }}')" title="Hapus Data" class="w-7 h-7 flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                            <i class="fa-solid fa-trash text-[11px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400 font-semibold">
                                    Belum ada data Informasi Serta-Merta.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Footer Client-side Pagination DataTables Style -->
        <div class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div id="table-serta-merta-info" class="text-xs md:text-sm text-slate-800 font-medium">
                Menampilkan 0 sampai 0 dari 0 entri
            </div>
            <div id="table-serta-merta-pagination" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
            </div>
        </div>
    </div>

</div>
@endsection

@section('modals')
<!-- Modal Tambah/Edit Informasi Serta-Merta -->
<div id="modalSertaMerta" class="hidden fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl border-0 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[96vh]">
        
        <div class="bg-sky-500 text-white px-6 py-3.5 shrink-0 rounded-t-2xl w-full">
            <h3 id="modalSertaMertaTitle" class="text-lg sm:text-xl font-extrabold text-white tracking-tight leading-snug">Tambah Informasi Serta-Merta</h3>
            <p id="modalSertaMertaSubtitle" class="text-xs text-white/90 font-medium mt-0.5 leading-normal">Publikasikan informasi atau surat edaran penting/mendesak bagi publik</p>
        </div>

        <form id="formSertaMerta" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" id="formMethodSertaMerta" name="_method" value="POST">

            <div class="p-6 text-xs md:text-sm overflow-y-auto flex-1 space-y-3.5">
                
                <!-- 1. Judul Informasi Serta-Merta -->
                <div class="space-y-1" x-data="{ len: 0 }" x-init="len = $refs.inputSertaMerta ? $refs.inputSertaMerta.value.length : 0">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">
                            Judul Informasi Serta-Merta <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[11px] font-bold text-slate-400 shrink-0" :class="len >= 150 ? 'text-rose-500 font-extrabold' : ''">
                            <span x-text="len">0</span>/150
                        </span>
                    </div>
                    <input type="text" id="inputJudulSertaMerta" name="judul_informasi" x-ref="inputSertaMerta" maxlength="150" required 
                           placeholder="Contoh: Surat Edaran Kesiapsiagaan Bencana / Pengumuman Kedaruratan Kampus..." 
                           @input="len = $el.value.length"
                           class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold placeholder:text-slate-400 focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                </div>

                <!-- 2. Waktu/Tanggal & Unit/Satker Penerbit -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">
                            Waktu / Tanggal Terbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputWaktuSertaMerta" name="waktu_pembuatan_informasi" required 
                               placeholder="Contoh: 18 September 2026" 
                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">
                            Unit / Satker Penerbit <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputPejabatSertaMerta" name="pejabat_unit_yang_menguasai_informasi" required 
                               placeholder="Contoh: Dekanat FMIPA Universitas Lampung" 
                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                    </div>
                </div>

                <!-- 3. Akses & Berkas / Tautan -->
                <div class="space-y-3 pt-0.5">
                    <div class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Akses Lampiran <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-center justify-start gap-2 h-[38px] px-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                <input type="radio" name="format_serta_merta" id="radioFileSertaMerta" value="file" checked onclick="toggleFormatSertaMerta('file')" class="text-sky-600 focus:ring-0">
                                <span class="font-bold text-slate-700 text-xs truncate">Unggah Berkas</span>
                            </label>
                            <label class="flex items-center justify-start gap-2 h-[38px] px-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                <input type="radio" name="format_serta_merta" id="radioLinkSertaMerta" value="link" onclick="toggleFormatSertaMerta('link')" class="text-sky-600 focus:ring-0">
                                <span class="font-bold text-slate-700 text-xs truncate">Tautan Eksternal</span>
                            </label>
                        </div>
                    </div>

                    <!-- Upload File Serta Merta -->
                    <div id="containerFileSertaMerta" class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Upload File <span id="fileRequiredStarSertaMerta" class="text-rose-500">*</span></label>

                        <div class="relative flex items-center w-full min-h-[38px] p-1 bg-slate-50 border border-slate-200 rounded-xl transition focus-within:border-sky-500 focus-within:bg-white">
                            <input type="file" id="inputFileSertaMerta" name="file_informasi" accept=".pdf,.doc,.docx,.xls,.xlsx" class="sr-only" onchange="handleFileChangeSertaMerta(this)">

                            <button type="button" onclick="document.getElementById('inputFileSertaMerta').click()"
                                    class="shrink-0 px-3 py-1 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white text-xs font-black rounded-lg transition shadow-2xs cursor-pointer">
                                Choose File
                            </button>

                            <div class="flex-1 min-w-0 px-2 flex items-center">
                                <span id="fileNameSertaMerta" class="text-xs text-slate-500 font-medium truncate">No file chosen</span>
                                <a id="currentFileLinkSertaMerta" href="#" target="_blank" title="Klik untuk melihat file saat ini" 
                                   class="hidden text-xs font-semibold text-sky-600 hover:text-sky-700 underline truncate block cursor-pointer max-w-full">
                                    <span id="currentFileNameSertaMerta" class="truncate"></span>
                                </a>
                            </div>
                        </div>

                        <p id="fileHelpTextSertaMerta" class="text-[10px] text-slate-400 font-medium">Format: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)</p>
                    </div>

                    <!-- Tautan Link Serta Merta -->
                    <div id="containerLinkSertaMerta" class="space-y-1 hidden">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">Tautan Link <span class="text-rose-500">*</span></label>
                        <input type="url" id="inputLinkSertaMerta" name="link_informasi" placeholder="Contoh: https://drive.google.com/... atau https://unila.ac.id/..." 
                               class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                    </div>
                </div>

            </div>

            <!-- Footer Buttons -->
            <div class="px-5 py-3 sm:px-6 bg-slate-50/90 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0 rounded-b-2xl">
                <button type="button" onclick="closeModalSertaMerta()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs sm:text-sm font-extrabold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs sm:text-sm font-extrabold rounded-xl transition shadow-xs cursor-pointer flex items-center gap-1.5">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Global -->
<x-modals.delete />
@endsection

@push('scripts')
<script>
    window.isSelectModeSertaMerta = false;

    function toggleSelectModeSertaMerta() {
        window.isSelectModeSertaMerta = !window.isSelectModeSertaMerta;
        const isSelectMode = window.isSelectModeSertaMerta;
        const colHeader = document.getElementById('col-checkbox-header');
        const colCells = document.querySelectorAll('.col-checkbox-cell');
        const toggleBtn = document.getElementById('btn-toggle-select');
        const textSelectMode = document.getElementById('text-select-mode');
        const checkAll = document.getElementById('check-all');

        if (colHeader) colHeader.classList.toggle('hidden', !isSelectMode);
        colCells.forEach(cell => cell.classList.toggle('hidden', !isSelectMode));

        if (isSelectMode) {
            toggleBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
            toggleBtn.classList.add('bg-rose-50', 'text-rose-600', 'border-rose-300');
            textSelectMode.innerText = 'Batal';
        } else {
            toggleBtn.classList.remove('bg-rose-50', 'text-rose-600', 'border-rose-300');
            toggleBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
            textSelectMode.innerText = 'Pilih';
            
            if (checkAll) checkAll.checked = false;
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = false);
            updateBulkStateSertaMerta();
        }

        if (typeof renderClientSideSertaMertaTable === 'function') {
            renderClientSideSertaMertaTable();
        }
    }

    function toggleCheckAllSertaMerta(master) {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        updateBulkStateSertaMerta();
    }

    function updateBulkStateSertaMerta() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const selectedCount = document.getElementById('selected-count');
        const checkAll = document.getElementById('check-all');
        const totalItems = document.querySelectorAll('.item-checkbox').length;

        if (selectedCount) selectedCount.innerText = checkedCount;

        if (bulkBtn) {
            if (checkedCount > 0 && window.isSelectModeSertaMerta) {
                bulkBtn.classList.remove('hidden');
            } else {
                bulkBtn.classList.add('hidden');
            }
        }

        if (checkAll && totalItems > 0) {
            checkAll.checked = (checkedCount === totalItems);
        }
    }

    function triggerBulkDeleteSertaMerta() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        if (checkedCount === 0) return;
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus <b>' + checkedCount + '</b> Informasi Serta-Merta terpilih?';
        window.currentDeleteType = 'bulk-serta-merta';
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    function triggerDeleteSertaMerta(url, title) {
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus informasi <b>"' + title + '"</b> ini?';
        window.currentDeleteType = 'single';
        window.currentDeleteUrl = url;
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    // Modal submit handler
    document.addEventListener('DOMContentLoaded', function() {
        const originalConfirmDeleteBtn = document.getElementById('btnConfirmDeleteAction');
        if (originalConfirmDeleteBtn) {
            originalConfirmDeleteBtn.addEventListener('click', function(e) {
                if (window.currentDeleteType === 'bulk-serta-merta') {
                    e.preventDefault();
                    document.getElementById('form-bulk-delete-serta-merta').submit();
                }
            });
        }
        initClientSideSertaMertaTable();
    });

    function openModalCreateSertaMerta() {
        document.getElementById('modalSertaMertaTitle').innerText = 'Tambah Informasi Serta-Merta';
        document.getElementById('modalSertaMertaSubtitle').innerText = 'Publikasikan informasi atau surat edaran penting/mendesak bagi publik';
        document.getElementById('formSertaMerta').action = "{{ route('admin.informasi-serta-merta.store') }}";
        document.getElementById('formMethodSertaMerta').value = 'POST';
        document.getElementById('formSertaMerta').reset();

        document.getElementById('inputJudulSertaMerta').value = '';
        document.getElementById('inputWaktuSertaMerta').value = '';
        document.getElementById('inputPejabatSertaMerta').value = '';

        const fileNameSpan = document.getElementById('fileNameSertaMerta');
        if (fileNameSpan) fileNameSpan.textContent = 'No file chosen';
        const currentFileLink = document.getElementById('currentFileLinkSertaMerta');
        if (currentFileLink) currentFileLink.classList.add('hidden');

        toggleFormatSertaMerta('file');
        document.querySelector('input[name="format_serta_merta"][value="file"]').checked = true;

        document.getElementById('modalSertaMerta').classList.remove('hidden');
        document.getElementById('inputJudulSertaMerta').dispatchEvent(new Event('input'));
    }

    function closeModalSertaMerta() {
        document.getElementById('modalSertaMerta').classList.add('hidden');
    }

    function toggleFormatSertaMerta(format) {
        const containerFile = document.getElementById('containerFileSertaMerta');
        const containerLink = document.getElementById('containerLinkSertaMerta');
        const inputFile = document.getElementById('inputFileSertaMerta');
        const inputLink = document.getElementById('inputLinkSertaMerta');
        const isEdit = document.getElementById('formMethodSertaMerta').value === 'PUT';

        if (format === 'file') {
            if (containerFile) containerFile.classList.remove('hidden');
            if (containerLink) containerLink.classList.add('hidden');
            if (inputLink) inputLink.removeAttribute('required');
            if (inputFile) {
                if (isEdit) {
                    inputFile.removeAttribute('required');
                } else {
                    inputFile.setAttribute('required', 'required');
                }
            }
        } else {
            if (containerFile) containerFile.classList.add('hidden');
            if (containerLink) containerLink.classList.remove('hidden');
            if (inputFile) inputFile.removeAttribute('required');
            if (inputLink) inputLink.setAttribute('required', 'required');
        }
    }

    function handleFileChangeSertaMerta(input) {
        const fileDisplayName = document.getElementById('fileNameSertaMerta');
        const currentFileLink = document.getElementById('currentFileLinkSertaMerta');
        
        if (input.files && input.files.length > 0) {
            if (currentFileLink) currentFileLink.classList.add('hidden');
            if (fileDisplayName) {
                fileDisplayName.textContent = input.files[0].name;
                fileDisplayName.classList.remove('hidden', 'text-slate-500');
                fileDisplayName.classList.add('text-slate-800', 'font-semibold');
            }
        } else {
            const isEdit = document.getElementById('formMethodSertaMerta').value === 'PUT';
            const fileNameSpan = document.getElementById('currentFileNameSertaMerta');
            if (isEdit && fileNameSpan && fileNameSpan.textContent.trim() !== '') {
                if (fileDisplayName) fileDisplayName.classList.add('hidden');
                if (currentFileLink) currentFileLink.classList.remove('hidden');
            } else {
                if (currentFileLink) currentFileLink.classList.add('hidden');
                if (fileDisplayName) {
                    fileDisplayName.textContent = 'No file chosen';
                    fileDisplayName.classList.remove('hidden', 'text-slate-800', 'font-semibold');
                    fileDisplayName.classList.add('text-slate-500');
                }
            }
        }
    }

    function openModalEditSertaMerta(item) {
        document.getElementById('modalSertaMertaTitle').innerText = 'Edit Informasi Serta-Merta';
        document.getElementById('modalSertaMertaSubtitle').innerText = 'Perbarui data informasi atau surat edaran serta-merta';
        document.getElementById('formSertaMerta').action = "{{ url('/admin/informasi-serta-merta') }}/" + item.id;
        document.getElementById('formMethodSertaMerta').value = 'PUT';
        document.getElementById('formSertaMerta').reset();

        document.getElementById('inputJudulSertaMerta').value = item.judul_informasi || '';
        document.getElementById('inputWaktuSertaMerta').value = item.waktu_pembuatan_informasi || '';
        document.getElementById('inputPejabatSertaMerta').value = item.pejabat_unit_yang_menguasai_informasi || '';

        const fileDisplayName = document.getElementById('fileNameSertaMerta');
        const fileNameSpan = document.getElementById('currentFileNameSertaMerta');
        const fileLink = document.getElementById('currentFileLinkSertaMerta');
        const helpText = document.getElementById('fileHelpTextSertaMerta');

        if (item.link_informasi && !item.file_informasi) {
            document.querySelector('input[name="format_serta_merta"][value="link"]').checked = true;
            toggleFormatSertaMerta('link');
            document.getElementById('inputLinkSertaMerta').value = item.link_informasi || '';
            if (fileDisplayName) {
                fileDisplayName.textContent = 'No file chosen';
                fileDisplayName.classList.remove('hidden', 'text-slate-800', 'font-semibold');
                fileDisplayName.classList.add('text-slate-500');
            }
            if (fileLink) fileLink.classList.add('hidden');
            if (helpText) helpText.innerText = 'Format: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)';
        } else {
            document.querySelector('input[name="format_serta_merta"][value="file"]').checked = true;
            toggleFormatSertaMerta('file');

            if (item.file_informasi) {
                const displayName = item.nama_file_asli || item.file_informasi.split('/').pop();
                if (fileNameSpan) fileNameSpan.innerText = displayName;
                if (fileLink) {
                    fileLink.href = "{{ url('/informasi/file') }}/" + item.id + "/" + encodeURIComponent(displayName) + "?from_admin=1";
                    fileLink.classList.remove('hidden');
                }
                if (fileDisplayName) fileDisplayName.classList.add('hidden');
                if (helpText) helpText.innerText = 'Pilih file baru jika ingin mengganti file saat ini. Biarkan kosong jika tidak ingin mengubah file.';
            } else {
                if (fileLink) fileLink.classList.add('hidden');
                if (fileDisplayName) {
                    fileDisplayName.textContent = 'No file chosen';
                    fileDisplayName.classList.remove('hidden', 'text-slate-800', 'font-semibold');
                    fileDisplayName.classList.add('text-slate-500');
                }
                if (helpText) helpText.innerText = 'Format: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)';
            }
        }

        document.getElementById('modalSertaMerta').classList.remove('hidden');
        document.getElementById('inputJudulSertaMerta').dispatchEvent(new Event('input'));
    }

    // =========================================================================
    // CLIENT-SIDE DATATABLES ENGINE KHUSUS INFORMASI SERTA-MERTA
    // =========================================================================
    let sertaMertaAllRows = [];
    let sertaMertaFilteredRows = [];
    let sertaMertaCurrentPage = 1;
    let sertaMertaPerPage = 10;
    let sertaMertaSortColumn = null;
    let sertaMertaSortDirection = 'asc';

    function initClientSideSertaMertaTable() {
        const tbody = document.getElementById('table-serta-merta-body');
        if (!tbody) return;

        const perPageSelect = document.getElementById('select-per-page-serta-merta');
        if (perPageSelect) sertaMertaPerPage = parseInt(perPageSelect.value) || 10;

        const rawRows = Array.from(tbody.querySelectorAll('.table-serta-merta-row'));
        if (rawRows.length === 0) return;

        sertaMertaAllRows = rawRows.map((tr, index) => {
            return {
                element: tr,
                no: index + 1,
                judul: tr.getAttribute('data-judul') || '',
                waktu: tr.getAttribute('data-waktu') || '',
                pejabat: tr.getAttribute('data-pejabat') || '',
                fullText: tr.innerText.toLowerCase()
            };
        });

        applyClientSideSertaMertaFilter();
    }

    function debounceSearchSertaMerta() {
        clearTimeout(window.sertaMertaSearchTimer);
        window.sertaMertaSearchTimer = setTimeout(() => {
            const input = document.getElementById('input-search-serta-merta');
            const clearBtn = document.getElementById('btn-clear-search-serta-merta');
            if (clearBtn) clearBtn.classList.toggle('hidden', !input.value);
            sertaMertaCurrentPage = 1;
            applyClientSideSertaMertaFilter();
        }, 150);
    }

    function clearSearchSertaMerta() {
        const input = document.getElementById('input-search-serta-merta');
        const clearBtn = document.getElementById('btn-clear-search-serta-merta');
        if (input) input.value = '';
        if (clearBtn) clearBtn.classList.add('hidden');
        sertaMertaCurrentPage = 1;
        applyClientSideSertaMertaFilter();
    }

    function changePerPageSertaMerta(val) {
        sertaMertaPerPage = parseInt(val) || 10;
        sertaMertaCurrentPage = 1;
        renderClientSideSertaMertaTable();
    }

    function sortSertaMertaTable(column) {
        if (sertaMertaSortColumn === column) {
            sertaMertaSortDirection = (sertaMertaSortDirection === 'asc') ? 'desc' : 'asc';
        } else {
            sertaMertaSortColumn = column;
            sertaMertaSortDirection = 'asc';
        }

        sertaMertaFilteredRows.sort((a, b) => {
            let valA = a[column];
            let valB = b[column];

            if (column === 'no') {
                return (sertaMertaSortDirection === 'asc') ? (valA - valB) : (valB - valA);
            }
            return (sertaMertaSortDirection === 'asc') 
                ? String(valA).localeCompare(String(valB), 'id') 
                : String(valB).localeCompare(String(valA), 'id');
        });

        sertaMertaCurrentPage = 1;
        renderClientSideSertaMertaTable();
        updateSertaMertaExportLinks();
    }

    function applyClientSideSertaMertaFilter() {
        const searchInput = document.getElementById('input-search-serta-merta');
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

        if (!query) {
            sertaMertaFilteredRows = [...sertaMertaAllRows];
        } else {
            sertaMertaFilteredRows = sertaMertaAllRows.filter(row => row.fullText.includes(query));
        }

        sertaMertaCurrentPage = 1;
        renderClientSideSertaMertaTable();
        updateSertaMertaExportLinks();
    }

    function updateSertaMertaExportLinks() {
        const btnPdf = document.getElementById('btn-export-serta-merta-pdf');
        const btnExcel = document.getElementById('btn-export-serta-merta-excel');
        const searchInput = document.getElementById('input-search-serta-merta');
        const query = searchInput ? searchInput.value.trim() : '';

        [btnPdf, btnExcel].forEach(btn => {
            if (!btn) return;
            try {
                const targetUrl = new URL(btn.href, window.location.origin);
                if (query) {
                    targetUrl.searchParams.set('search', query);
                } else {
                    targetUrl.searchParams.delete('search');
                }

                if (sertaMertaSortColumn) {
                    // Map sort column alias to server column
                    let serverSortBy = sertaMertaSortColumn;
                    if (sertaMertaSortColumn === 'judul') serverSortBy = 'sub_informasi';
                    if (sertaMertaSortColumn === 'pejabat') serverSortBy = 'pejabat';
                    if (sertaMertaSortColumn === 'waktu') serverSortBy = 'waktu';

                    targetUrl.searchParams.set('sort_by', serverSortBy);
                    targetUrl.searchParams.set('sort_direction', sertaMertaSortDirection || 'asc');
                } else {
                    targetUrl.searchParams.delete('sort_by');
                    targetUrl.searchParams.delete('sort_direction');
                }
                btn.href = targetUrl.toString();
            } catch (e) {}
        });
    }

    function renderClientSideSertaMertaTable() {
        const tbody = document.getElementById('table-serta-merta-body');
        if (!tbody) return;

        const totalFiltered = sertaMertaFilteredRows.length;
        const totalPages = Math.ceil(totalFiltered / sertaMertaPerPage) || 1;

        if (sertaMertaCurrentPage > totalPages) sertaMertaCurrentPage = totalPages;
        if (sertaMertaCurrentPage < 1) sertaMertaCurrentPage = 1;

        const startIdx = (sertaMertaCurrentPage - 1) * sertaMertaPerPage;
        const endIdx = Math.min(startIdx + sertaMertaPerPage, totalFiltered);

        sertaMertaAllRows.forEach(row => row.element.remove());

        if (totalFiltered === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="p-12 text-center text-slate-400 font-semibold">Tidak ada Informasi Serta-Merta yang sesuai pencarian.</td></tr>`;
        } else {
            tbody.innerHTML = '';
            for (let i = startIdx; i < endIdx; i++) {
                const row = sertaMertaFilteredRows[i];
                const noCell = row.element.querySelector('.col-serta-merta-no');
                if (noCell) noCell.innerText = (i + 1);

                const colCell = row.element.querySelector('.col-checkbox-cell');
                if (colCell) {
                    colCell.classList.toggle('hidden', !window.isSelectModeSertaMerta);
                }

                tbody.appendChild(row.element);
            }
        }

        // Info entries
        const infoEl = document.getElementById('table-serta-merta-info');
        if (infoEl) {
            infoEl.innerText = totalFiltered === 0 
                ? 'Menampilkan 0 sampai 0 dari 0 entri'
                : `Menampilkan ${startIdx + 1} sampai ${endIdx} dari ${totalFiltered} entri`;
        }

        // Pagination buttons
        renderPaginationButtonsSertaMerta(totalPages);
    }

    function renderPaginationButtonsSertaMerta(totalPages) {
        const paginEl = document.getElementById('table-serta-merta-pagination');
        if (!paginEl) return;

        if (totalPages <= 1) {
            paginEl.innerHTML = '';
            return;
        }

        let html = '';
        html += `<button type="button" onclick="goToPageSertaMerta(${sertaMertaCurrentPage - 1})" 
                    ${sertaMertaCurrentPage === 1 ? 'disabled class="px-3 py-2 text-xs font-bold text-slate-300 cursor-not-allowed bg-slate-50"' : 'class="px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 cursor-pointer"'}>
                    Prev
                </button>`;

        for (let p = 1; p <= totalPages; p++) {
            if (p === sertaMertaCurrentPage) {
                html += `<span class="px-3.5 py-2 text-xs font-extrabold bg-sky-500 text-white">${p}</span>`;
            } else {
                html += `<button type="button" onclick="goToPageSertaMerta(${p})" class="px-3.5 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 cursor-pointer">${p}</button>`;
            }
        }

        html += `<button type="button" onclick="goToPageSertaMerta(${sertaMertaCurrentPage + 1})" 
                    ${sertaMertaCurrentPage === totalPages ? 'disabled class="px-3 py-2 text-xs font-bold text-slate-300 cursor-not-allowed bg-slate-50"' : 'class="px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-50 cursor-pointer"'}>
                    Next
                </button>`;

        paginEl.innerHTML = html;
    }

    function goToPageSertaMerta(page) {
        sertaMertaCurrentPage = page;
        renderClientSideSertaMertaTable();
    }
</script>
@endpush
