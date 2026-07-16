@extends('layout.admin')

@section('title', 'Manajemen Pengajuan - PPID FMIPA Unila')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Manajemen Pengajuan</h1>
        <p class="text-sm text-gray-500">Daftar integrasi permohonan informasi dan keberatan</p>
    </div>

    <!-- Statistik Grid -->
    <div class="flex gap-4 overflow-x-auto pb-4 lg:grid lg:grid-cols-5 lg:gap-6 lg:pb-0 mb-10">
        <!-- Total -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-slate-600 to-slate-800 rounded-3xl p-6 text-white shadow-xl shadow-slate-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-folder-open text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Total</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalPermohonan ?? 0 }}
            </div>
        </div>

        <!-- Diajukan -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-gray-500 to-gray-700 rounded-3xl p-6 text-white shadow-xl shadow-gray-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-paper-plane text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Diajukan</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalDiajukan ?? 0 }}
            </div>
        </div>

        <!-- Diproses -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-sky-500 to-blue-600 rounded-3xl p-6 text-white shadow-xl shadow-blue-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-spinner text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Diproses</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalDiproses ?? 0 }}
            </div>
        </div>

        <!-- Diterima -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-3xl p-6 text-white shadow-xl shadow-emerald-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-check-circle text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Diterima</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalDiterima ?? 0 }}
            </div>
        </div>

        <!-- Ditolak -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-red-500 to-red-700 rounded-3xl p-6 text-white shadow-xl shadow-red-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-times-circle text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Ditolak</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalDitolak ?? 0 }}
            </div>
        </div>
    </div>

    <!-- Filter & Search Form -->
    <form id="filterForm" action="{{ url('/admin/pengajuan') }}" method="GET" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 items-center animate-fade-in">
        <div>
            <select name="jenis_layanan" onchange="this.form.submit()" class="w-full border-slate-200 bg-slate-50 rounded-xl p-3.5 text-sm font-semibold text-slate-700 outline-none cursor-pointer hover:border-blue-500 transition shadow-sm">
                <option value="">Semua Jenis Layanan</option>
                <option value="Permohonan" {{ request('jenis_layanan') == 'Permohonan' ? 'selected' : '' }}>Permohonan Informasi</option>
                <option value="Keberatan" {{ request('jenis_layanan') == 'Keberatan' ? 'selected' : '' }}>Pengajuan Keberatan</option>
            </select>
        </div>
        <div>
            <select name="status" onchange="this.form.submit()" class="w-full border-slate-200 bg-slate-50 rounded-xl p-3.5 text-sm font-semibold text-slate-700 outline-none cursor-pointer hover:border-blue-500 transition shadow-sm">
                <option value="">Semua Status</option>
                @foreach(['DIAJUKAN', 'DIPROSES', 'DITERIMA', 'DITOLAK'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" id="searchInput" placeholder="Cari nama, no. tiket, rincian..." class="w-full border-slate-200 bg-slate-50 rounded-xl pl-12 pr-4 py-3.5 text-sm outline-none hover:border-blue-500 focus:border-blue-500 transition shadow-sm">
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

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-10">

        <form id="bulk-delete-form" action="{{ route('admin.pengajuan.bulk') }}" method="POST">
            @csrf @method('DELETE')
            <div class="overflow-x-auto w-full">
                <table class="w-full min-w-[1000px] text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 text-[14px] font-extrabold text-slate-600 uppercase tracking-widest border-b border-slate-100">
                            <th class="col-checkbox p-6 pl-8 w-10 hidden"><input type="checkbox" id="select-all" class="rounded border-slate-300"></th>
                            <th class="p-6 pl-8">No. Tiket</th>
                            <th class="p-6">Jenis</th>
                            <th class="p-6">Pemohon</th>
                            <th class="p-6">Rincian</th>
                            <th class="p-6">Tanggal</th>
                            <th class="p-6">Status</th>
                            <th class="p-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-700">
                        @forelse ($permohonans as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors border-b border-slate-50">
                                <td class="col-checkbox p-6 pl-8 hidden">
                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="child-checkbox rounded border-slate-300">
                                </td>
                                <td class="p-6 pl-8 font-mono font-bold text-[#0095e8] text-[15px]">{{ $item->no_tiket }}</td>
                                <td class="p-6 text-slate-900 font-bold text-[15px] whitespace-nowrap">
                                    {{ $item->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}
                                </td>
                                <td class="p-6">
                                    <div class="font-bold text-slate-900 text-[15px]">{{ $item->nama }}</div>
                                </td>
                                <td class="p-6 text-slate-600 max-w-[250px] truncate text-[15px]" title="{{ $item->jenis_layanan == 'Permohonan' ? $item->info_diminta : $item->tujuan_keberatan }}">
                                    {{ $item->jenis_layanan == 'Permohonan' ? $item->info_diminta : $item->tujuan_keberatan }}
                                </td>
                                <td class="p-6 text-slate-400 text-[15px]">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="p-6 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold border
                                        {{ match($item->status) {
                                            'DIAJUKAN' => 'bg-amber-50/60 text-amber-800 border-amber-200/50',
                                            'DIPROSES' => 'bg-blue-50/60 text-blue-800 border-blue-200/50',
                                            'DITERIMA' => 'bg-emerald-50/60 text-emerald-800 border-emerald-200/50',
                                            'DITOLAK'  => 'bg-rose-50/60 text-rose-800 border-rose-200/50',
                                            default    => 'bg-gray-50/60 text-gray-800 border-gray-200/50'
                                        } }}">
                                        <span class="h-1.5 w-1.5 rounded-full
                                            {{ match($item->status) {
                                                'DIAJUKAN' => 'bg-amber-500',
                                                'DIPROSES' => 'bg-blue-500',
                                                'DITERIMA' => 'bg-emerald-500',
                                                'DITOLAK'  => 'bg-rose-500',
                                                default    => 'bg-gray-400'
                                            } }}"></span>
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ url('/admin/pengajuan/' . $item->id) }}" class="p-2.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Lihat Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <button type="button" onclick="triggerDelete('{{ url('/admin/pengajuan/'.$item->id) }}', '{{ $item->no_tiket }}')" class="p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition" title="Hapus Pengajuan">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="p-12 text-center text-slate-400">Belum ada data pengajuan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div class="p-6 bg-gray-50 border-t border-gray-100">
            {{ $permohonans->links() }}
        </div>
    </div>

    @include('admin.modals.modal_hapus')

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

        selectAll.addEventListener('change', function() {
            childCheckboxes.forEach(cb => cb.checked = this.checked);
            toggleBulkBtn();
        });

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

        const searchInput = document.getElementById('searchInput');
        let timer = null;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => { document.getElementById('filterForm').submit(); }, 800);
            });
        }

        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
@endsection

