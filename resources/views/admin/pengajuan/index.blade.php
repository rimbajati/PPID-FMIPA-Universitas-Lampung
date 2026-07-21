@extends('layout.admin')

@section('title', 'Manajemen Pengajuan - PPID FMIPA Unila')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Manajemen Pengajuan</h1>
        <p class="text-sm text-gray-500">Daftar integrasi permohonan informasi dan keberatan</p>
    </div>

    <!-- Statistik Grid (5 Cards Siakad Style - Kompak & Siku 90 Deg) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

        <!-- 1. Total -->
        <div class="relative bg-[#0073b7] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalPermohonan ?? 0 }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Total</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-inbox"></i>
            </div>
        </div>

        <!-- 2. Diajukan -->
        <div class="relative bg-[#1B365D] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalDiajukan ?? 0 }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Diajukan</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-paper-plane"></i>
            </div>
        </div>

        <!-- 3. Diproses -->
        <div class="relative bg-[#f39c12] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalDiproses ?? 0 }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Diproses</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-gears"></i>
            </div>
        </div>

        <!-- 4. Diterima -->
        <div class="relative bg-[#00a65a] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalDiterima ?? 0 }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Diterima</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <!-- 5. Ditolak -->
        <div class="relative bg-[#dd4b39] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalDitolak ?? 0 }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Ditolak</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
        </div>

    </div>

    <!-- Filter & Search Form -->
    <form id="filterForm" action="{{ url('/admin/pengajuan') }}" method="GET" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 items-center animate-fade-in" onsubmit="event.preventDefault(); performLiveSearch(this);">
        <div>
            <select name="jenis_layanan" onchange="performLiveSearch(this.form)" class="w-full border-slate-200 bg-slate-50 rounded-xl p-3.5 text-sm font-semibold text-slate-700 outline-none cursor-pointer hover:border-blue-500 transition shadow-sm">
                <option value="">Semua Jenis Layanan</option>
                <option value="Permohonan" {{ request('jenis_layanan') == 'Permohonan' ? 'selected' : '' }}>Permohonan Informasi</option>
                <option value="Keberatan" {{ request('jenis_layanan') == 'Keberatan' ? 'selected' : '' }}>Pengajuan Keberatan</option>
            </select>
        </div>
        <div>
            <select name="status" onchange="performLiveSearch(this.form)" class="w-full border-slate-200 bg-slate-50 rounded-xl p-3.5 text-sm font-semibold text-slate-700 outline-none cursor-pointer hover:border-blue-500 transition shadow-sm">
                <option value="">Semua Status</option>
                @foreach(['DIAJUKAN', 'DIPROSES', 'PERBAIKAN', 'DITERIMA', 'DITOLAK'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" id="searchInput" placeholder="Cari nama, no. tiket, rincian..." class="w-full border-slate-200 bg-slate-50 rounded-xl pl-12 pr-4 py-3.5 text-sm outline-none hover:border-blue-500 focus:border-blue-500 transition shadow-sm" autocomplete="off">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-slate-400"></i>
        </div>
    </form>

    <!-- Kontrol Hapus Terpilih -->
    <div class="mb-6 flex flex-wrap gap-4 justify-between items-center">
        <div class="flex flex-wrap gap-3">
            <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-2.5 rounded-xl font-bold transition text-sm flex items-center gap-2">
                <i class="fa-solid fa-list-check text-base"></i> <span id="text-select-mode">Pilih Banyak</span>
            </button>
            <button id="btn-bulk-delete" type="button" onclick="triggerBulkDelete()" class="hidden bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-bold transition shadow-md text-sm flex items-center gap-2">
                <i class="fa-solid fa-trash text-base"></i> Hapus Terpilih
            </button>
        </div>
    </div>

    <!-- Data Table Section -->
    <form id="bulk-delete-form" action="{{ route('admin.pengajuan.bulk') }}" method="POST">
        @csrf @method('DELETE')
        <div id="data-table-container" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-10 transition-opacity duration-200">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 text-[14px] font-extrabold text-slate-600 uppercase tracking-widest border-b border-slate-100">
                            <th class="col-checkbox p-6 pl-8 w-10 hidden"><input type="checkbox" id="select-all" class="rounded border-slate-300"></th>
                            <th class="p-6 pl-8">No. Tiket</th>
                            <th class="p-6">Jenis</th>
                            <th class="p-6">Pemohon</th>
                            <th class="p-6">Rincian</th>
                            <th class="p-6">Tanggal</th>
                            <th class="p-6">Status</th>
                            <th class="p-6 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-700">
                        @forelse ($permohonans as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors {{ $loop->last ? 'border-b-2 border-slate-300' : 'border-b border-slate-50' }}">
                                <td class="col-checkbox p-6 pl-8 hidden">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="child-checkbox rounded border-slate-300">
                                </td>
                                <td class="p-6 pl-8 font-mono font-bold text-slate-900 text-[15px]">{{ $item->no_tiket }}</td>
                                <td class="p-6 text-slate-900 font-bold text-[15px] whitespace-nowrap">
                                    {{ $item->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}
                                </td>
                                <td class="p-6">
                                    <div class="font-bold text-slate-900 text-[15px]">{{ $item->nama }}</div>
                                </td>
                                <td class="p-6 text-slate-900 text-[15px]">
                                    {{ $item->jenis_layanan == 'Permohonan' ? $item->info_diminta : $item->tujuan_keberatan }}
                                </td>
                                <td class="p-6 text-slate-400 text-[15px]">{{ $item->created_at->translatedFormat('j F Y') }}</td>
                                <td class="p-6 whitespace-nowrap">
                                    @php
                                        $statusStyle = match($item->status) {
                                            'DIAJUKAN'  => 'bg-amber-100 text-amber-700',
                                            'DIPROSES'  => 'bg-indigo-100 text-indigo-700',
                                            'PERBAIKAN' => 'bg-orange-100 text-orange-800',
                                            'DITERIMA'  => 'bg-emerald-100 text-emerald-700',
                                            'DITOLAK'   => 'bg-rose-100 text-rose-700',
                                            default     => 'bg-slate-100 text-slate-600',
                                        };
                                    @endphp
                                    <span class="px-3.5 py-1 rounded-full text-[12px] font-bold inline-block text-center {{ $statusStyle }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="p-6 text-center">
                                    <a href="{{ url('/admin/pengajuan/' . $item->id) }}" class="inline-flex items-center justify-center bg-[#1B365D] hover:bg-[#1B365D] text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm hover:shadow">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="p-12 text-center text-slate-400">Belum ada data pengajuan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50 border-t border-gray-100">
                {{ $permohonans->links() }}
            </div>
        </div>
    </form>

    @include('admin.pengajuan.modals.modal_hapus')

    <script>
        const selectAll = document.getElementById('select-all');
        const childCheckboxes = document.querySelectorAll('.child-checkbox');
        const bulkBtn = document.getElementById('btn-bulk-delete');

        let isSelectMode = false;
        function toggleSelectMode() {
            isSelectMode = !isSelectMode;
            
            const colCheckboxes = document.querySelectorAll('.col-checkbox');
            const toggleBtn = document.getElementById('btn-toggle-select');
            const textSelectMode = document.getElementById('text-select-mode');
            
            colCheckboxes.forEach(el => el.classList.toggle('hidden', !isSelectMode));
            
            if (isSelectMode) {
                toggleBtn.classList.remove('bg-slate-100', 'text-slate-700', 'hover:bg-slate-200');
                toggleBtn.classList.add('bg-rose-50', 'text-rose-600', 'hover:bg-rose-100');
                textSelectMode.innerText = "Batal";
            } else {
                selectAll.checked = false;
                childCheckboxes.forEach(cb => cb.checked = false);
                
                toggleBtn.classList.remove('bg-rose-50', 'text-rose-600', 'hover:bg-rose-100');
                toggleBtn.classList.add('bg-slate-100', 'text-slate-700', 'hover:bg-slate-200');
                textSelectMode.innerText = "Pilih Banyak";
                
                bulkBtn.classList.add('hidden');
            }
        }

        function updateMasterCheckbox() {
            const allChecked = Array.from(childCheckboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                childCheckboxes.forEach(cb => cb.checked = this.checked);
                toggleBulkBtn();
            });
        }

        childCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                updateMasterCheckbox();
                toggleBulkBtn();
            });
        });

        function toggleBulkBtn() {
            const checkedCount = document.querySelectorAll('.child-checkbox:checked').length;
            bulkBtn.classList.toggle('hidden', !isSelectMode || checkedCount === 0);
        }

        function triggerBulkDelete() {
            const count = document.querySelectorAll('.child-checkbox:checked').length;
            document.getElementById('bulk-count').innerText = count;
            openModal('modal-bulk-delete');
        }

        function triggerDelete(url, name) {
            document.getElementById('form-delete').action = url;
            document.getElementById('delete-item-name').innerText = name;
            openModal('modal-delete');
        }

        function performLiveSearch(formElement) {
            const url = new URL(formElement.action, window.location.origin);
            const formData = new FormData(formElement);
            for (const [key, value] of formData.entries()) {
                if (value) url.searchParams.set(key, value);
            }
            
            const dataContainer = document.getElementById('data-table-container');
            if (dataContainer) dataContainer.classList.add('opacity-50', 'pointer-events-none');

            fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newTable = doc.getElementById('data-table-container');
                if (newTable && dataContainer) {
                    dataContainer.innerHTML = newTable.innerHTML;
                }
                
                window.history.replaceState(null, '', url.toString());
            })
            .catch(err => console.error("Search fetch failed:", err))
            .finally(() => {
                if (dataContainer) dataContainer.classList.remove('opacity-50', 'pointer-events-none');
            });
        }

        const searchInput = document.getElementById('searchInput');
        let timer = null;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => { performLiveSearch(document.getElementById('filterForm')); }, 400);
            });
        }

        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
@endsection

