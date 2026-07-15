@extends('layouts.admin')

@section('title', 'Manajemen Informasi Publik - PPID FMIPA Unila')

@section('content')

    <!-- Pesan Sukses -->
    @if(session('success'))
        <div id="success-alert" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                    <i class="fa-solid fa-check text-emerald-600"></i>
                </div>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('success-alert').remove()" class="text-emerald-600 hover:text-emerald-800 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Informasi Publik</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola repositori data informasi publik FMIPA Universitas Lampung</p>
        </div>
    </div>

    <!-- Statistik Grid -->
    <!-- Container: Gunakan flex dan overflow-x-auto untuk mobile, grid untuk desktop -->
    <div class="flex gap-4 overflow-x-auto pb-2 lg:grid lg:grid-cols-4 lg:gap-6 lg:pb-0 mb-4">

        <!-- 1. Total Informasi -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-6 text-white shadow-xl shadow-blue-900/10 overflow-hidden h-44">
            <!-- Gunakan items-center, hapus mt-1 dari icon -->
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-folder-open text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Total Informasi Publik</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalInformasi }}
            </div>
        </div>

        <!-- 4. Setiap Saat -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-indigo-600 to-indigo-800 rounded-3xl p-6 text-white shadow-xl shadow-indigo-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-globe text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Informasi Tersedia Setiap Saat</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalSetiapSaat }}
            </div>
        </div>

        <!-- 2. Berkala -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-3xl p-6 text-white shadow-xl shadow-emerald-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-clock text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Informasi Tersedia Secara Berkala</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalBerkala }}
            </div>
        </div>

        <!-- 3. Serta-Merta -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl p-6 text-white shadow-xl shadow-amber-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-bullhorn text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Informasi Diumumkan Serta-Merta</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalSertaMerta }}
            </div>
        </div>

    </div>

    <!-- Filter & Search Form -->
    <form id="filterForm" action="{{ url('/admin/informasi-publik') }}" method="GET" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
        <div>
            <select name="kategori" onchange="this.form.submit()" class="w-full border-slate-200 bg-slate-50 rounded-xl p-3.5 text-sm font-semibold text-slate-700 outline-none">
                <option value="">Semua Jenis Informasi</option>
                <option value="Informasi Tersedia Setiap Saat" {{ request('kategori') == 'Informasi Tersedia Setiap Saat' ? 'selected' : '' }}>Informasi Tersedia Setiap Saat</option>
                <option value="Informasi Tersedia Secara Berkala" {{ request('kategori') == 'Informasi Tersedia Secara Berkala' ? 'selected' : '' }}>Informasi Tersedia Secara Berkala</option>
                <option value="Informasi Diumumkan Serta-Merta" {{ request('kategori') == 'Informasi Diumumkan Serta-Merta' ? 'selected' : '' }}>Informasi Diumumkan Serta-Merta</option>
            </select>
        </div>
        <div>
            <select name="rincian" onchange="this.form.submit()" class="w-full border-slate-200 bg-slate-50 rounded-xl p-3.5 text-sm font-semibold text-slate-700 outline-none">
                <option value="">Semua Rincian Informasi</option>
                @foreach($listRincian as $r) <option value="{{ $r }}" {{ request('rincian') == $r ? 'selected' : '' }}>{{ $r }}</option> @endforeach
            </select>
        </div>
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" id="searchInput" placeholder="Masukan kata kunci informasi..." class="w-full border-slate-200 bg-slate-50 rounded-xl pl-12 pr-4 py-3.5 text-sm outline-none">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-slate-400"></i>
        </div>
    </form>

    <!-- Tombol Hapus Terpilih -->
    <div class="mb-4 flex justify-end gap-3">
        <button id="btn-bulk-delete" onclick="triggerBulkDelete()" class="hidden bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg text-sm">
            <i class="fa-solid fa-trash mr-2"></i> Hapus Terpilih
        </button>
        <button onclick="openModal('modal-create')" class="bg-[#0095e8] hover:bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg text-sm">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Informasi Baru
        </button>
    </div>

    <!-- Table Section -->
    <form id="bulk-delete-form" action="{{ route('admin.informasi.bulk') }}" method="POST">
        @csrf @method('DELETE')
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 text-[14px] font-extrabold text-slate-600 uppercase tracking-widest border-b border-slate-100">
                            <th class="p-6 pl-8 w-10"><input type="checkbox" id="select-all" class="rounded border-slate-300"></th>
                            <th class="p-6">Rincian Informasi</th>
                            <th class="p-6">Sub Informasi</th>
                            <th class="p-6">Jenis Informasi</th>
                            <th class="p-6">Tanggal</th>
                            <th class="p-6 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-slate-700">
                        @forelse ($informasi->groupBy('rincian_informasi') as $rincian => $groupItems)
                            @php $groupSlug = \Illuminate\Support\Str::slug($rincian); @endphp

                            @foreach ($groupItems as $index => $item)
                                {{-- Cek apakah ini item terakhir di dalam grup --}}
                                <tr class="hover:bg-slate-50/50 transition-colors {{ $loop->last ? 'border-b-2 border-slate-300' : 'border-b border-slate-50' }}">
                                    <td class="p-6 pl-8"></td>
                                    <td class="p-6">
                                        @if ($index === 0)
                                            <input type="checkbox" class="group-checkbox rounded border-slate-300 mr-2" data-group="{{ $groupSlug }}">
                                            <span class="font-bold text-[17px] text-slate-900">{{ $rincian }}</span>
                                        @endif
                                    </td>
                                    <td class="p-6">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="child-checkbox rounded border-slate-300 mr-3" data-group="{{ $groupSlug }}">
                                        <span class="text-[15px] text-slate-900">{{ $item->sub_informasi }}</span>
                                    </td>
                                    <td class="p-6">
                                        @php
                                            $style = [
                                                'Informasi Tersedia Setiap Saat' => 'bg-indigo-100 text-indigo-700',
                                                'Informasi Tersedia Secara Berkala' => 'bg-emerald-100 text-emerald-700',
                                                'Informasi Diumumkan Serta-Merta' => 'bg-amber-100 text-amber-700',
                                            ][$item->kategori] ?? 'bg-slate-100 text-slate-600';
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[12px] font-bold {{ $style }}">{{ $item->kategori }}</span>
                                    </td>
                                    <td class="p-6 text-slate-400">{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td class="p-6 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            <a href="{{ $item->tipe_informasi === 'link' ? $item->jalur_informasi : route('informasi.file', ['id' => $item->id, 'slug' => \Illuminate\Support\Str::slug($item->sub_informasi)]) }}" target="_blank" class="p-2.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition"><i class="fa-solid fa-eye"></i></a>
                                            <button type="button" onclick="editData({{ json_encode($item) }})" class="p-2.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button type="button" onclick="triggerDelete('{{ url('/admin/informasi-publik/'.$item->id) }}', '{{ addslashes($item->sub_informasi) }}')" class="p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr><td colspan="6" class="p-12 text-center text-slate-400">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    @include('admin.partials.modal_informasi')

    <!-- Modal Delete Single -->
    <div id="modal-delete" class="hidden fixed inset-0 z-[2000] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full border border-slate-100 shadow-2xl">
            <h3 class="text-xl font-bold text-center mb-2">Hapus Data?</h3>
            <p class="text-sm text-slate-500 text-center mb-8 italic" id="delete-item-name"></p>
            <div class="flex gap-3">
                <button onclick="closeModal('modal-delete')" class="flex-1 py-3 bg-slate-100 rounded-xl font-bold text-sm">Batal</button>
                <form id="form-delete" action="" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-red-600 text-white rounded-xl font-bold text-sm">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Bulk -->
    <div id="modal-bulk-delete" class="hidden fixed inset-0 z-[2000] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full border border-slate-100 shadow-2xl">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl mb-6 mx-auto"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h3 class="text-xl font-bold text-center mb-2">Hapus <span id="bulk-count">0</span> Data?</h3>
            <p class="text-sm text-slate-500 text-center mb-8 leading-relaxed">
                Apakah Anda yakin ingin menghapus semua data yang terpilih secara permanen?
            </p>
            <div class="flex gap-3">
                <button onclick="closeModal('modal-bulk-delete')" class="flex-1 py-3 bg-slate-100 rounded-xl font-bold text-sm">Batal</button>
                <button onclick="document.getElementById('bulk-delete-form').submit()" class="flex-1 py-3 bg-red-600 text-white rounded-xl font-bold text-sm">Ya, Hapus Semua</button>
            </div>
        </div>
    </div>

    <script>
        const selectAll = document.getElementById('select-all');
        const groupCheckboxes = document.querySelectorAll('.group-checkbox');
        const childCheckboxes = document.querySelectorAll('.child-checkbox');
        const bulkBtn = document.getElementById('btn-bulk-delete');

        function updateMasterCheckbox() {
            const allChecked = Array.from(childCheckboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
        }

        selectAll.addEventListener('change', function() {
            [...groupCheckboxes, ...childCheckboxes].forEach(cb => cb.checked = this.checked);
            toggleBulkBtn();
        });

        groupCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const group = this.dataset.group;
                const children = document.querySelectorAll(`.child-checkbox[data-group="${group}"]`);
                children.forEach(child => child.checked = this.checked);
                updateMasterCheckbox();
                toggleBulkBtn();
            });
        });

        childCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const group = this.dataset.group;
                const siblings = document.querySelectorAll(`.child-checkbox[data-group="${group}"]`);
                const allSiblingsSelected = Array.from(siblings).every(s => s.checked);
                document.querySelector(`.group-checkbox[data-group="${group}"]`).checked = allSiblingsSelected;
                updateMasterCheckbox();
                toggleBulkBtn();
            });
        });

        function toggleBulkBtn() {
            bulkBtn.classList.toggle('hidden', document.querySelectorAll('.child-checkbox:checked').length === 0);
        }

        function triggerBulkDelete() {
            const count = document.querySelectorAll('.child-checkbox:checked').length;
            document.getElementById('bulk-count').innerText = count;
            openModal('modal-bulk-delete');
        }

        const searchInput = document.getElementById('searchInput');
        let timer = null;
        searchInput.addEventListener('input', function() {
            clearTimeout(timer);
            timer = setTimeout(() => { document.getElementById('filterForm').submit(); }, 800);
        });

        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        function triggerDelete(url, name) {
            document.getElementById('form-delete').action = url;
            document.getElementById('delete-item-name').innerText = name;
            openModal('modal-delete');
        }

        function toggleRincian(prefix, value) {
            const inputBaru = document.getElementById(`${prefix}_rincian_baru`);
            const selectElement = document.getElementById(`${prefix}_rincian_select`);
            if (value === 'baru') {
                inputBaru.classList.remove('hidden'); inputBaru.required = true;
                selectElement.name = "kategori_lama"; inputBaru.name = "rincian_informasi_baru";
            } else {
                inputBaru.classList.add('hidden'); inputBaru.required = false;
                selectElement.name = "rincian_informasi";
            }
        }

        function toggleFormat(prefix, jenis) {
            const zonaFile = document.getElementById(`${prefix}_zona_file`);
            const zonaLink = document.getElementById(`${prefix}_zona_link`);
            const inputFile = document.getElementById(`${prefix}_input_file`);
            const inputLink = document.getElementById(`${prefix}_input_link`);
            if (jenis === 'file') {
                zonaFile.classList.remove('hidden'); zonaLink.classList.add('hidden');
                inputFile.disabled = false; inputLink.disabled = true;
            } else {
                zonaFile.classList.add('hidden'); zonaLink.classList.remove('hidden');
                inputFile.disabled = true; inputLink.disabled = false;
            }
        }

        function editData(item) {
            const form = document.getElementById('form-edit');
            form.action = `/admin/informasi-publik/${item.id}`;
            const selectRincian = document.getElementById('edit_rincian_select');
            let isExists = Array.from(selectRincian.options).some(opt => opt.value === item.rincian_informasi);
            if (isExists) {
                selectRincian.value = item.rincian_informasi;
                toggleRincian('edit', item.rincian_informasi);
            } else {
                selectRincian.value = 'baru';
                toggleRincian('edit', 'baru');
                document.getElementById('edit_rincian_baru').value = item.rincian_informasi;
            }
            document.getElementById('edit_sub').value = item.sub_informasi;
            document.getElementById('edit_kategori').value = item.kategori;
            if (item.tipe_informasi === 'link') {
                document.getElementById('edit_format_link').checked = true;
                document.getElementById('edit_input_link').value = item.jalur_informasi;
                toggleFormat('edit', 'link');
            } else {
                document.getElementById('edit_format_file').checked = true;
                toggleFormat('edit', 'file');
            }
            openModal('modal-edit');
        }
    </script>
@endsection
