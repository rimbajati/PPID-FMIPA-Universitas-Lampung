@extends('layout.admin')

@section('title', 'Manajemen Informasi Publik - PPID FMIPA Unila')

@section('content')

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Informasi Publik</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola repositori data informasi publik FMIPA Universitas Lampung</p>
        </div>
    </div>

    <!-- Statistik Grid (4 Cards Siakad Style - Kompak & Siku 90 Deg) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <!-- 1. Total Informasi -->
        <div class="relative bg-[#1B365D] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalInformasi }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Total Informasi Publik</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-folder-open"></i>
            </div>
        </div>

        <!-- 2. Setiap Saat -->
        <div class="relative bg-[#605ca8] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalSetiapSaat }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Informasi Setiap Saat</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-globe"></i>
            </div>
        </div>

        <!-- 3. Secara Berkala -->
        <div class="relative bg-[#2563EB] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalBerkala }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Informasi Secara Berkala</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>

        <!-- 4. Serta-Merta -->
        <div class="relative bg-[#0284C7] p-5 text-white overflow-hidden shadow-sm flex flex-col justify-between h-[115px]">
            <div class="z-10">
                <span class="text-3xl sm:text-4xl font-extrabold text-white leading-none block mb-1.5">{{ $totalSertaMerta }}</span>
                <span class="text-xs sm:text-sm font-bold text-white/95 tracking-wide block uppercase">Informasi Serta-Merta</span>
            </div>
            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-5xl text-black/15 select-none pointer-events-none">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
        </div>

    </div>

    <!-- Filter & Search Form -->
    <form id="filterForm" action="{{ url('/admin/informasi-publik') }}" method="GET" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mb-8 grid grid-cols-1 md:grid-cols-3 gap-4 items-center" onsubmit="event.preventDefault(); performLiveSearch(this);">
        <div>
            <select name="rincian" onchange="performLiveSearch(this.form)" class="w-full border-slate-200 bg-slate-50 rounded-xl p-3.5 text-sm font-semibold text-slate-700 outline-none">
                <option value="">Semua Rincian Informasi</option>
                @foreach($listRincian as $r) <option value="{{ $r }}" {{ request('rincian') == $r ? 'selected' : '' }}>{{ $r }}</option> @endforeach
            </select>
        </div>
        <div>
            <select name="kategori" onchange="performLiveSearch(this.form)" class="w-full border-slate-200 bg-slate-50 rounded-xl p-3.5 text-sm font-semibold text-slate-700 outline-none">
                <option value="">Semua Jenis Informasi</option>
                <option value="Informasi Tersedia Setiap Saat" {{ request('kategori') == 'Informasi Tersedia Setiap Saat' ? 'selected' : '' }}>Informasi Tersedia Setiap Saat</option>
                <option value="Informasi Tersedia Secara Berkala" {{ request('kategori') == 'Informasi Tersedia Secara Berkala' ? 'selected' : '' }}>Informasi Tersedia Secara Berkala</option>
                <option value="Informasi Diumumkan Serta-Merta" {{ request('kategori') == 'Informasi Diumumkan Serta-Merta' ? 'selected' : '' }}>Informasi Diumumkan Serta-Merta</option>
            </select>
        </div>
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" id="searchInput" placeholder="Masukan kata kunci informasi..." class="w-full border-slate-200 bg-slate-50 rounded-xl pl-12 pr-4 py-3.5 text-sm outline-none" autocomplete="off">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-slate-400"></i>
        </div>
    </form>

    <!-- Kontrol Hapus Terpilih & Tambah -->
    <div class="mb-6 flex flex-wrap gap-4 justify-between items-center">
        <div class="flex flex-wrap gap-3">
            <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-2xl font-bold transition text-sm flex items-center gap-2">
                <i class="fa-solid fa-list-check text-base"></i> <span id="text-select-mode">Pilih Banyak</span>
            </button>
            <button id="btn-bulk-delete" type="button" onclick="triggerBulkDelete()" class="hidden bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-trash text-base"></i> Hapus Terpilih
            </button>
        </div>
        <div class="w-full sm:w-auto">
            <button type="button" onclick="openModal('modal-create')" class="w-full sm:w-auto bg-[#0095e8] hover:bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus text-base"></i> Tambah Informasi Baru
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <form id="bulk-delete-form" action="{{ route('admin.informasi.bulk') }}" method="POST">
        @csrf @method('DELETE')
        <div id="data-table-container" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden transition-opacity duration-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 text-[14px] font-extrabold text-slate-600 uppercase tracking-widest border-b border-slate-100">
                            <th class="col-checkbox p-6 pl-8 w-10 hidden"><input type="checkbox" id="select-all" class="rounded border-slate-300"></th>
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
                                <tr class="hover:bg-slate-50/50 transition-colors {{ $loop->last ? 'border-b-2 border-slate-300' : 'border-b border-slate-50' }}">
                                    <td class="col-checkbox p-6 pl-8 hidden">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="child-checkbox rounded border-slate-300" data-group="{{ $groupSlug }}">
                                    </td>
                                    <td class="p-6">
                                        @if ($index === 0)
                                            <input type="checkbox" class="group-checkbox rounded border-slate-300 mr-2 hidden" data-group="{{ $groupSlug }}">
                                            <span class="font-bold text-[17px] text-slate-900">{{ $rincian }}</span>
                                        @endif
                                    </td>
                                    <td class="p-6">
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
                                    <td class="p-6 text-slate-400">{{ $item->created_at->translatedFormat('j F Y') }}</td>
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

    @include('admin.informasi_publik.modals.modal_form_informasi')
    @include('admin.informasi_publik.modals.modal_hapus')

    <script>
        const selectAll = document.getElementById('select-all');
        const groupCheckboxes = document.querySelectorAll('.group-checkbox');
        const childCheckboxes = document.querySelectorAll('.child-checkbox');
        const bulkBtn = document.getElementById('btn-bulk-delete');

        let isSelectMode = false;
        function toggleSelectMode() {
            isSelectMode = !isSelectMode;
            
            const colCheckboxes = document.querySelectorAll('.col-checkbox');
            const groupCheckboxesList = document.querySelectorAll('.group-checkbox');
            const toggleBtn = document.getElementById('btn-toggle-select');
            const textSelectMode = document.getElementById('text-select-mode');
            
            colCheckboxes.forEach(el => el.classList.toggle('hidden', !isSelectMode));
            groupCheckboxesList.forEach(el => el.classList.toggle('hidden', !isSelectMode));
            
            if (isSelectMode) {
                toggleBtn.classList.remove('bg-slate-100', 'text-slate-700', 'hover:bg-slate-200');
                toggleBtn.classList.add('bg-rose-50', 'text-rose-600', 'hover:bg-rose-100');
                textSelectMode.innerText = "Batal";
            } else {
                selectAll.checked = false;
                [...groupCheckboxes, ...childCheckboxes].forEach(cb => cb.checked = false);
                
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
                const parentGroup = document.querySelector(`.group-checkbox[data-group="${group}"]`);
                if (parentGroup) {
                    parentGroup.checked = allSiblingsSelected;
                }
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

        function triggerDelete(url, name) {
            document.getElementById('form-delete').action = url;
            document.getElementById('delete-item-name').innerText = name;
            openModal('modal-delete');
        }

        function toggleRincian(prefix, value) {
            const inputBaru = document.getElementById(`${prefix}_rincian_baru`);
            const selectElement = document.getElementById(`${prefix}_rincian_select`);
            selectElement.name = "rincian_informasi";
            if (value === 'baru') {
                inputBaru.classList.remove('hidden'); inputBaru.required = true;
                inputBaru.disabled = false; inputBaru.name = "rincian_informasi_baru";
            } else {
                inputBaru.classList.add('hidden'); inputBaru.required = false;
                inputBaru.disabled = true; inputBaru.name = "rincian_informasi_baru";
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

        function setupAjaxForm(formId, modalId) {
            const form = document.getElementById(formId);
            if (!form) return;

            form.querySelectorAll('.input-field').forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-500');
                    const nextElement = this.nextElementSibling;
                    if (nextElement && nextElement.classList.contains('error-msg')) {
                        nextElement.remove();
                    }
                });
                input.addEventListener('change', function() {
                    this.classList.remove('border-red-500');
                    const nextElement = this.nextElementSibling;
                    if (nextElement && nextElement.classList.contains('error-msg')) {
                        nextElement.remove();
                    }
                });
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                form.querySelectorAll('.error-msg').forEach(el => el.remove());
                form.querySelectorAll('.input-field').forEach(el => {
                    el.classList.remove('border-red-500');
                });

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Mengirim...';
                }

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(async response => {
                    const isJson = response.headers.get('content-type')?.includes('application/json');
                    const data = isJson ? await response.json() : null;

                    if (response.status === 422) {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }

                        if (data && data.errors) {
                            for (const [field, messages] of Object.entries(data.errors)) {
                                let inputEl = form.querySelector(`#${modalId.replace('modal-', '')}_${field}`) || 
                                              form.querySelector(`[name="${field}"]`) ||
                                              form.querySelector(`#${field}`);

                                if (inputEl) {
                                    inputEl.classList.add('border-red-500');

                                    const errorP = document.createElement('p');
                                    errorP.className = 'error-msg text-red-500 text-xs mt-1';
                                    errorP.innerText = messages[0];

                                    inputEl.after(errorP);
                                }
                            }

                            const firstError = form.querySelector('.border-red-500');
                            if (firstError) {
                                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                    } else if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Terjadi kesalahan pada server.');
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Terjadi kesalahan jaringan.');
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            setupAjaxForm('form-create', 'modal-create');
            setupAjaxForm('form-edit', 'modal-edit');
        });
    </script>
@endsection
