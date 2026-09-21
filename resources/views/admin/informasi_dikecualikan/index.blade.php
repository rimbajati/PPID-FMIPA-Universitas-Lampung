@extends('components.layouts.admin')

@section('title', 'Daftar Informasi Dikecualikan (DIK) - Admin PPID')
@section('header_title', 'Daftar Informasi Dikecualikan (DIK)')

@section('content')
<div class="space-y-6">

    <!-- Section Header: Informasi Dikecualikan Overview & Tombol Tambah -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Daftar Informasi Dikecualikan</h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">Kelola daftar informasi yang dikecualikan berdasarkan ketentuan hukum dan uji konsekuensi</p>
        </div>

        <!-- Tombol Aksi Header -->
        <div class="flex items-center gap-2.5 shrink-0">
            <!-- Tombol Tambah Utama -->
            <button type="button" onclick="openModalCreateDik()" 
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
            <button type="button" id="btn-bulk-delete" onclick="triggerBulkDeleteDik()"
                    class="hidden inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-2xl transition shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-trash"></i> <span>Hapus (<span id="selected-count">0</span>) data terpilih</span>
            </button>

            <!-- Dropdown Show Entries -->
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                <span>Show</span>
                <select id="select-per-page-admin-dik" onchange="changePerPageAdminDik(this.value)" 
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
        <form id="form-search-admin-dik" onsubmit="event.preventDefault();" class="flex items-center gap-2">
            <label for="input-search-admin-dik" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">
                Search:
            </label>
            <div class="relative">
                <input type="text" 
                       name="search" 
                       id="input-search-admin-dik"
                       value="{{ request('search') }}" 
                       autocomplete="off"
                       oninput="debounceSearchAdminDik()"
                       class="w-48 sm:w-56 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-2xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                <button type="button" id="btn-clear-search-admin-dik" onclick="clearSearchAdminDik()" title="Hapus pencarian" 
                        class="{{ request('search') ? '' : 'hidden' }} absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Container & Data Tabel -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <form id="form-bulk-delete" action="{{ route('admin.informasi-dikecualikan.bulk') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="overflow-x-auto">
                <table class="w-full table-fixed text-left border-collapse border border-slate-200">
                    <colgroup>
                        <col id="col-checkbox-group" class="hidden w-10">
                        <col class="w-12 shrink-0">
                        <col class="w-[25%]">
                        <col class="w-[20%]">
                        <col class="w-[12%]">
                        <col class="w-[18%]">
                        <col class="w-[15%]">
                        <col class="w-[10%] shrink-0">
                    </colgroup>
                    <thead>
                        <!-- Baris Header 1 -->
                        <tr class="bg-sky-500 text-white text-xs sm:text-sm font-extrabold tracking-tight divide-x divide-white/20 text-center leading-snug select-none">
                            <th rowspan="2" id="col-checkbox-header" class="hidden px-2 py-3.5 text-center">
                                <input type="checkbox" id="check-all" onclick="toggleCheckAll(this)" class="w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer">
                            </th>
                            <th rowspan="2" onclick="sortAdminDikTable('no')" class="px-2 py-3.5 text-center cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
                                <div class="flex items-center justify-center gap-1.5">
                                    <span>No</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th rowspan="2" onclick="sortAdminDikTable('ringkasan')" class="px-3.5 py-3.5 text-center cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Informasi">
                                <div class="flex items-center justify-between gap-1.5">
                                    <span>Informasi</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th rowspan="2" onclick="sortAdminDikTable('dasar_hukum')" class="px-3.5 py-3.5 text-center cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Dasar Hukum">
                                <div class="flex items-center justify-between gap-1.5">
                                    <span>Dasar Hukum</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th colspan="2" class="px-3.5 py-2 text-center border-b border-white/20">Konsekuensi / Pertimbangan Bagi Publik</th>
                            <th rowspan="2" onclick="sortAdminDikTable('jangka_waktu')" class="px-3.5 py-3.5 text-center cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Jangka Waktu">
                                <div class="flex items-center justify-between gap-1.5">
                                    <span>Jangka Waktu</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th rowspan="2" class="px-2 py-3.5 text-center">Aksi</th>
                        </tr>
                        <!-- Baris Header 2 (Sub-kolom Konsekuensi) -->
                        <tr class="bg-sky-500 text-white text-xs sm:text-sm font-extrabold tracking-tight divide-x divide-white/20 text-center leading-snug select-none">
                            <th onclick="sortAdminDikTable('dibuka')" class="px-3 py-2 text-center cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Konsekuensi Dibuka">
                                <div class="flex items-center justify-between gap-1.5">
                                    <span>Jika Dibuka</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th onclick="sortAdminDikTable('ditutup')" class="px-3 py-2 text-center cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Konsekuensi Ditutup">
                                <div class="flex items-center justify-between gap-1.5">
                                    <span>Jika Ditutup</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table-admin-dik-body" class="divide-y divide-slate-200 text-xs sm:text-sm font-medium text-slate-800">
                        @forelse($informasi as $idx => $item)
                            <tr class="table-admin-dik-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-200"
                                data-id="{{ $item->id }}"
                                data-no="{{ $idx + 1 }}"
                                data-ringkasan="{{ strtolower($item->ringkasan_informasi ?? '') }}"
                                data-dasar_hukum="{{ strtolower($item->dasar_hukum ?? '') }}"
                                data-dibuka="{{ strtolower($item->dibuka ?? '') }}"
                                data-ditutup="{{ strtolower($item->ditutup ?? '') }}"
                                data-jangka_waktu="{{ strtolower($item->jangka_waktu ?? '') }}">
                                <td class="col-checkbox-cell hidden px-2 py-3 text-center">
                                    <input type="checkbox" name="ids[]" form="form-bulk-delete" value="{{ $item->id }}" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                                </td>
                                <td class="col-admin-dik-no px-2 py-3 text-center font-bold text-slate-400">
                                    {{ $idx + 1 }}
                                </td>
                                <td class="px-3.5 py-3 font-extrabold text-slate-900 leading-normal break-words">
                                    {{ $item->ringkasan_informasi }}
                                </td>
                                <td class="px-3 py-3 text-slate-700 break-words leading-normal">
                                    {{ $item->dasar_hukum }}
                                </td>
                                <td class="px-3 py-3 text-slate-700 break-words leading-normal">
                                    {{ $item->dibuka ?: '-' }}
                                </td>
                                <td class="px-3 py-3 text-slate-700 break-words leading-normal">
                                    {{ $item->ditutup }}
                                </td>
                                <td class="px-3 py-3 text-center font-semibold text-slate-700 break-words">
                                    {{ $item->jangka_waktu }}
                                </td>
                                <td class="px-2 py-2.5 text-center align-middle whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Tombol Lihat (Detail Pop-up) -->
                                        <button type="button" onclick="openDetailDikModal({{ json_encode($item) }})" title="Lihat Detail" 
                                                class="w-7 h-7 flex items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white transition shadow-2xs rounded-lg cursor-pointer">
                                            <i class="fa-regular fa-eye text-[11px]"></i>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <button type="button" onclick="openModalEditDik({{ json_encode($item) }})" title="Edit Data" 
                                                class="w-7 h-7 flex items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button" onclick="triggerDeleteDik('{{ url('/admin/informasi-dikecualikan/' . $item->id) }}', '{{ addslashes($item->ringkasan_informasi) }}')" title="Hapus Data" 
                                                class="w-7 h-7 flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                            <i class="fa-solid fa-trash text-[11px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-12 text-center text-slate-400 font-semibold">
                                    Tidak ada data informasi dikecualikan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Kontrol Paginasi Client-side Instan -->
            <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div id="table-admin-dik-info" class="text-xs md:text-sm text-slate-800">
                    Menampilkan 0 sampai 0 dari 0 entri
                </div>
                <div id="table-admin-dik-pagination" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
                    <!-- Render dinamis via JavaScript -->
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

@section('modals')
<!-- =================================================== -->
<!-- MODAL TAMBAH & EDIT INFORMASI DIKECUALIKAN (DIK)    -->
<!-- =================================================== -->
<div id="modalAddEditDik" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden transition-all duration-200">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh] animate-in fade-in zoom-in-95 duration-150">
        <!-- Header Modal -->
        <div class="px-6 pt-6 pb-4 flex items-start justify-between gap-4 border-b border-slate-100">
            <div class="space-y-1">
                <h3 id="modalDikTitle" class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">Tambah Informasi Dikecualikan</h3>
                <p id="modalDikSubtitle" class="text-xs font-semibold text-slate-400">Masukkan detail informasi yang dikecualikan</p>
            </div>
            <button type="button" onclick="closeModalAddEditDik()" 
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition cursor-pointer shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Body Formulir -->
        <form id="formAddEditDik" method="POST" class="p-6 overflow-y-auto space-y-4 text-xs sm:text-sm">
            @csrf
            <input type="hidden" name="_method" id="formMethodDik" value="POST">

            <!-- 1. Ringkasan Informasi -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-800">Ringkasan Informasi <span class="text-rose-500">*</span></label>
                <textarea name="ringkasan_informasi" id="inputRingkasanInformasi" rows="3" required placeholder="Contoh: Dokumen Ujian Mahasiswa, Nilai Indeks Prestasi, Berkas Kepegawaian..." 
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"></textarea>
            </div>

            <!-- 2. Dasar Hukum Pengecualian Informasi -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-800">Dasar Hukum Pengecualian Informasi <span class="text-rose-500">*</span></label>
                <textarea name="dasar_hukum" id="inputDasarHukum" rows="3" required placeholder="Contoh: UU KIP Pasal 17 Huruf h Angka 4 dan Angka 5..." 
                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition"></textarea>
            </div>

            <!-- 3. Dibuka & Ditutup -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="font-bold text-slate-800">Dibuka</label>
                    <input type="text" name="dibuka" id="inputDibuka" value="-" placeholder="Default: -" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label class="font-bold text-slate-800">Ditutup <span class="text-rose-500">*</span></label>
                    <input type="text" name="ditutup" id="inputDitutup" required placeholder="Contoh: Seluruh Dokumen Informasi Ujian" 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                </div>
            </div>

            <!-- 4. Jangka Waktu -->
            <div class="space-y-1.5">
                <label class="font-bold text-slate-800">Jangka Waktu <span class="text-rose-500">*</span></label>
                <input type="text" name="jangka_waktu" id="inputJangkaWaktu" required placeholder="Contoh: Selama menjadi mahasiswa sampai lulus" 
                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
            </div>

            <!-- Footer Modal Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button type="button" onclick="closeModalAddEditDik()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-xl transition shadow-sm cursor-pointer">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL POPUP: DETAIL INFORMASI YANG DIKECUALIKAN          -->
<!-- ======================================================== -->
<div id="modalDetailDik" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden transition-all duration-200">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh] animate-in fade-in zoom-in-95 duration-150">
        <!-- Header Modal -->
        <div class="px-6 pt-6 pb-4 flex items-start justify-between gap-4 border-b border-slate-100">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400">Daftar Informasi yang Dikecualikan</p>
                <h3 id="dikDetailRingkasan" class="text-xl sm:text-2xl font-black text-slate-900 leading-tight"></h3>
            </div>
            <button type="button" onclick="closeDetailDikModal()" 
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition cursor-pointer shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Body Modal (Format Persis Sesuai Gambar Referensi) -->
        <div class="p-6 overflow-y-auto space-y-6 text-sm divide-y divide-slate-100">
            <!-- 1. Dasar Hukum Pengecualian Informasi -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-2 first:pt-0">
                <div class="sm:col-span-4 font-bold text-slate-900">
                    Dasar Hukum Pengecualian Informasi
                </div>
                <div id="dikDetailDasarHukum" class="sm:col-span-8 text-slate-700 font-medium whitespace-pre-line leading-relaxed">
                </div>
            </div>

            <!-- 2. Dibuka -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-5">
                <div class="sm:col-span-4 font-bold text-slate-900">
                    Dibuka
                </div>
                <div id="dikDetailDibuka" class="sm:col-span-8 text-slate-700 font-medium">
                    -
                </div>
            </div>

            <!-- 3. Ditutup -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-5">
                <div class="sm:col-span-4 font-bold text-slate-900">
                    Ditutup
                </div>
                <div id="dikDetailDitutup" class="sm:col-span-8 text-slate-700 font-medium leading-relaxed">
                </div>
            </div>

            <!-- 4. Jangka Waktu -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-5">
                <div class="sm:col-span-4 font-bold text-slate-900">
                    Jangka Waktu
                </div>
                <div id="dikDetailJangkaWaktu" class="sm:col-span-8 text-slate-700 font-medium leading-relaxed">
                </div>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-3.5 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end">
            <button type="button" onclick="closeDetailDikModal()" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.isSelectMode = false;

    window.toggleSelectMode = function() {
        window.isSelectMode = !window.isSelectMode;
        const isSelectMode = window.isSelectMode;
        const colGroup = document.getElementById('col-checkbox-group');
        const colHeader = document.getElementById('col-checkbox-header');
        const colCells = document.querySelectorAll('.col-checkbox-cell');
        const toggleBtn = document.getElementById('btn-toggle-select');
        const textSelectMode = document.getElementById('text-select-mode');
        const checkAll = document.getElementById('check-all');

        if (colGroup) colGroup.classList.toggle('hidden', !isSelectMode);
        if (colHeader) colHeader.classList.toggle('hidden', !isSelectMode);
        colCells.forEach(cell => cell.classList.toggle('hidden', !isSelectMode));

        if (isSelectMode) {
            toggleBtn.classList.remove('bg-slate-100', 'text-slate-700');
            toggleBtn.classList.add('bg-rose-50', 'text-rose-600');
            textSelectMode.innerText = 'Batal';
        } else {
            toggleBtn.classList.remove('bg-rose-50', 'text-rose-600', 'border-rose-300');
            toggleBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
            textSelectMode.innerText = 'Hapus';
            
            if (checkAll) checkAll.checked = false;
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = false);
            window.updateBulkState();
        }
    };

    window.toggleCheckAll = function(master) {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        window.updateBulkState();
    };

    window.updateBulkState = function() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const selectedCount = document.getElementById('selected-count');
        const checkAll = document.getElementById('check-all');
        const totalItems = document.querySelectorAll('.item-checkbox').length;

        if (selectedCount) selectedCount.innerText = checkedCount;

        if (bulkBtn) {
            if (checkedCount > 0 && isSelectMode) {
                bulkBtn.classList.remove('hidden');
            } else {
                bulkBtn.classList.add('hidden');
            }
        }

        if (checkAll && totalItems > 0) {
            checkAll.checked = (checkedCount === totalItems);
        }
    };

    function triggerBulkDeleteDik() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        if (checkedCount === 0) return;
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus <b>' + checkedCount + '</b> informasi dikecualikan yang dipilih?';
        window.currentDeleteType = 'bulk';
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    function triggerDeleteDik(url, title) {
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus informasi dikecualikan <b>"' + title + '"</b> ini?';
        window.currentDeleteType = 'single';
        window.currentDeleteUrl = url;
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    function openModalCreateDik() {
        document.getElementById('modalDikTitle').innerText = 'Tambah Informasi Dikecualikan';
        document.getElementById('modalDikSubtitle').innerText = 'Masukkan detail informasi yang dikecualikan';
        document.getElementById('formAddEditDik').action = "{{ url('/admin/informasi-dikecualikan') }}";
        document.getElementById('formMethodDik').value = 'POST';
        document.getElementById('formAddEditDik').reset();
        document.getElementById('inputDibuka').value = '-';
        document.getElementById('modalAddEditDik').classList.remove('hidden');
    }

    function openModalEditDik(data) {
        document.getElementById('modalDikTitle').innerText = 'Edit Informasi Dikecualikan';
        document.getElementById('modalDikSubtitle').innerText = 'Perbarui data informasi yang dikecualikan';
        document.getElementById('formAddEditDik').action = "{{ url('/admin/informasi-dikecualikan') }}/" + data.id;
        document.getElementById('formMethodDik').value = 'PUT';
        
        document.getElementById('inputRingkasanInformasi').value = data.ringkasan_informasi || '';
        document.getElementById('inputDasarHukum').value = data.dasar_hukum || '';
        document.getElementById('inputDibuka').value = data.dibuka || '-';
        document.getElementById('inputDitutup').value = data.ditutup || '';
        document.getElementById('inputJangkaWaktu').value = data.jangka_waktu || '';

        document.getElementById('modalAddEditDik').classList.remove('hidden');
    }

    function closeModalAddEditDik() {
        document.getElementById('modalAddEditDik').classList.add('hidden');
    }

    function openDetailDikModal(data) {
        document.getElementById('dikDetailRingkasan').innerText = data.ringkasan_informasi || '-';
        document.getElementById('dikDetailDasarHukum').innerText = data.dasar_hukum || '-';
        document.getElementById('dikDetailDibuka').innerText = data.dibuka || '-';
        document.getElementById('dikDetailDitutup').innerText = data.ditutup || '-';
        document.getElementById('dikDetailJangkaWaktu').innerText = data.jangka_waktu || '-';

        document.getElementById('modalDetailDik').classList.remove('hidden');
    }

    function closeDetailDikModal() {
        document.getElementById('modalDetailDik').classList.add('hidden');
    }

    // =========================================================================
    // PURE CLIENT-SIDE DATATABLES ENGINE ADMIN DIK (0ms Instant Search & Filter)
    // =========================================================================
    let adminDikAllRows = [];
    let adminDikFilteredRows = [];
    let adminDikCurrentPage = 1;
    let adminDikPerPage = 10;
    let adminDikSortColumn = null;
    let adminDikSortDirection = 'asc';

    function initClientSideAdminDikTable() {
        const tbody = document.getElementById('table-admin-dik-body');
        if (!tbody) return;

        // Ambil preferensi dari URL jika ada
        const urlParams = new URLSearchParams(window.location.search);
        const searchVal = urlParams.get('search') || '';
        const perPageVal = parseInt(urlParams.get('per_page')) || 10;
        const sortByVal = urlParams.get('sort_by') || null;
        const sortDirVal = urlParams.get('sort_direction') || 'asc';

        adminDikPerPage = [10, 25, 50, 100].includes(perPageVal) ? perPageVal : 10;
        adminDikSortColumn = sortByVal;
        adminDikSortDirection = sortDirVal;

        const perPageSelect = document.getElementById('select-per-page-admin-dik');
        if (perPageSelect) perPageSelect.value = adminDikPerPage;

        const searchInput = document.getElementById('input-search-admin-dik');
        if (searchInput && searchVal) searchInput.value = searchVal;

        const rawRows = Array.from(tbody.querySelectorAll('.table-admin-dik-row'));
        if (rawRows.length === 0) return;

        adminDikAllRows = rawRows.map((tr, index) => {
            return {
                element: tr,
                originalIndex: index + 1,
                no: index + 1,
                ringkasan: tr.getAttribute('data-ringkasan') || '',
                dasar_hukum: tr.getAttribute('data-dasar_hukum') || '',
                dibuka: tr.getAttribute('data-dibuka') || '',
                ditutup: tr.getAttribute('data-ditutup') || '',
                jangka_waktu: tr.getAttribute('data-jangka_waktu') || '',
                fullText: tr.innerText.toLowerCase()
            };
        });

        updateSortAdminDikIconsUI();
        applyClientSideAdminDikFilter();
    }

    function debounceSearchAdminDik() {
        const input = document.getElementById('input-search-admin-dik');
        const clearBtn = document.getElementById('btn-clear-search-admin-dik');
        if (!input) return;

        const query = input.value.trim();
        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        adminDikCurrentPage = 1;
        applyClientSideAdminDikFilter();
    }

    function clearSearchAdminDik() {
        const input = document.getElementById('input-search-admin-dik');
        const clearBtn = document.getElementById('btn-clear-search-admin-dik');
        if (input) {
            input.value = '';
            input.focus();
        }
        if (clearBtn) {
            clearBtn.classList.add('hidden');
        }
        adminDikCurrentPage = 1;
        applyClientSideAdminDikFilter();
    }

    function changePerPageAdminDik(val) {
        adminDikPerPage = parseInt(val) || 10;
        adminDikCurrentPage = 1;
        applyClientSideAdminDikFilter();
    }

    function sortAdminDikTable(column) {
        if (adminDikSortColumn === column) {
            if (adminDikSortDirection === 'asc') {
                adminDikSortDirection = 'desc';
            } else {
                adminDikSortColumn = null;
                adminDikSortDirection = 'asc';
            }
        } else {
            adminDikSortColumn = column;
            adminDikSortDirection = 'asc';
        }

        updateSortAdminDikIconsUI();
        applyClientSideAdminDikFilter();
    }

    function updateSortAdminDikIconsUI() {
        const headers = document.querySelectorAll('th[onclick*="sortAdminDikTable"]');
        headers.forEach(th => {
            const colName = th.getAttribute('onclick').match(/'(.*)'/)?.[1];
            const iconSpan = th.querySelector('span:last-child');
            if (!iconSpan) return;

            if (colName === adminDikSortColumn) {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white transition';
                iconSpan.innerHTML = adminDikSortDirection === 'desc' 
                    ? '<i class="fa-solid fa-sort-down"></i>' 
                    : '<i class="fa-solid fa-sort-up"></i>';
            } else {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition';
                iconSpan.innerHTML = '<i class="fa-solid fa-sort"></i>';
            }
        });
    }

    function applyClientSideAdminDikFilter() {
        const input = document.getElementById('input-search-admin-dik');
        const query = input ? input.value.trim().toLowerCase() : '';

        // 1. Filtering
        if (!query) {
            adminDikFilteredRows = [...adminDikAllRows];
        } else {
            adminDikFilteredRows = adminDikAllRows.filter(row => row.fullText.includes(query));
        }

        // 2. Sorting
        if (adminDikSortColumn) {
            adminDikFilteredRows.sort((a, b) => {
                let valA, valB;
                if (adminDikSortColumn === 'no') {
                    valA = a.originalIndex;
                    valB = b.originalIndex;
                    return adminDikSortDirection === 'asc' ? valA - valB : valB - valA;
                } else {
                    valA = a[adminDikSortColumn] || '';
                    valB = b[adminDikSortColumn] || '';
                    const cmp = valA.localeCompare(valB, 'id', { numeric: true, sensitivity: 'base' });
                    return adminDikSortDirection === 'asc' ? cmp : -cmp;
                }
            });
        } else {
            adminDikFilteredRows.sort((a, b) => a.originalIndex - b.originalIndex);
        }

        // 3. Render tabel & paginasi
        renderClientSideAdminDikTable();

        // 4. Update URL tanpa reload
        const url = new URL(window.location.href);
        if (query) url.searchParams.set('search', query); else url.searchParams.delete('search');
        if (adminDikPerPage !== 10) url.searchParams.set('per_page', adminDikPerPage); else url.searchParams.delete('per_page');
        if (adminDikSortColumn) {
            url.searchParams.set('sort_by', adminDikSortColumn);
            url.searchParams.set('sort_direction', adminDikSortDirection);
        } else {
            url.searchParams.delete('sort_by');
            url.searchParams.delete('sort_direction');
        }
        window.history.replaceState({}, '', url.toString());
    }

    function renderClientSideAdminDikTable() {
        const tbody = document.getElementById('table-admin-dik-body');
        const infoEl = document.getElementById('table-admin-dik-info');
        const paginEl = document.getElementById('table-admin-dik-pagination');
        if (!tbody) return;

        const totalItems = adminDikFilteredRows.length;
        const totalPages = Math.ceil(totalItems / adminDikPerPage) || 1;

        if (adminDikCurrentPage > totalPages) adminDikCurrentPage = totalPages;
        if (adminDikCurrentPage < 1) adminDikCurrentPage = 1;

        const startIndex = (adminDikCurrentPage - 1) * adminDikPerPage;
        const endIndex = Math.min(startIndex + adminDikPerPage, totalItems);

        tbody.innerHTML = '';

        if (totalItems === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data informasi dikecualikan yang sesuai.</td></tr>';
            if (infoEl) infoEl.innerText = 'Menampilkan 0 sampai 0 dari 0 entri';
            if (paginEl) paginEl.innerHTML = '';
            window.updateBulkState();
            return;
        }

        const pageRows = adminDikFilteredRows.slice(startIndex, endIndex);
        pageRows.forEach((row, i) => {
            const tr = row.element;
            const noCell = tr.querySelector('.col-admin-dik-no');
            if (noCell) {
                noCell.innerText = startIndex + i + 1;
            }

            const cbCell = tr.querySelector('.col-checkbox-cell');
            if (cbCell) cbCell.classList.toggle('hidden', !window.isSelectMode);

            tbody.appendChild(tr);
        });

        if (infoEl) {
            infoEl.innerText = `Menampilkan ${startIndex + 1} sampai ${endIndex} dari ${totalItems} entri`;
        }

        if (paginEl) {
            paginEl.innerHTML = '';

            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.innerHTML = '‹';
            prevBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (adminDikCurrentPage === 1 ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            prevBtn.onclick = () => { if (adminDikCurrentPage > 1) { adminDikCurrentPage--; renderClientSideAdminDikTable(); } };
            paginEl.appendChild(prevBtn);

            for (let p = 1; p <= totalPages; p++) {
                if (totalPages > 7 && Math.abs(p - adminDikCurrentPage) > 2 && p !== 1 && p !== totalPages) {
                    if (p === 2 || p === totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.className = 'px-3 py-2 text-xs font-bold bg-slate-100/70 text-slate-400 select-none';
                        dots.innerText = '...';
                        paginEl.appendChild(dots);
                    }
                    continue;
                }

                const pageBtn = document.createElement('button');
                pageBtn.type = 'button';
                pageBtn.innerText = p;
                pageBtn.className = 'px-3.5 py-2 min-w-[38px] text-center text-xs transition cursor-pointer ' + 
                    (p === adminDikCurrentPage ? 'font-extrabold bg-sky-500 text-white shadow-2xs' : 'font-bold bg-white text-sky-500 hover:bg-sky-50');
                pageBtn.onclick = () => { adminDikCurrentPage = p; renderClientSideAdminDikTable(); };
                paginEl.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.innerHTML = '›';
            nextBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (adminDikCurrentPage === totalPages ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            nextBtn.onclick = () => { if (adminDikCurrentPage < totalPages) { adminDikCurrentPage++; renderClientSideAdminDikTable(); } };
            paginEl.appendChild(nextBtn);
        }

        window.updateBulkState();
    }

    document.addEventListener('DOMContentLoaded', function() {
        initClientSideAdminDikTable();
    });
</script>
@endpush
