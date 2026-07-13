@extends('layouts.admin')

@section('title', 'Manajemen Informasi Publik - PPID FMIPA Unila')

@section('content')
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Informasi Publik</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola repositori data informasi publik FMIPA Universitas Lampung</p>
        </div>
        <button onclick="openModal('modal-create')" class="inline-flex items-center justify-center bg-[#0095e8] hover:bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg shadow-blue-500/20 text-sm">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Informasi Baru
        </button>
    </div>

    <!-- Statistik Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $stats = [
                ['label' => 'Total Informasi', 'value' => $totalInformasi ?? 0, 'color' => 'text-gray-900'],
                ['label' => 'Berkala', 'value' => $totalBerkala ?? 0, 'color' => 'text-[#0095e8]'],
                ['label' => 'Serta-Merta', 'value' => $totalSertaMerta ?? 0, 'color' => 'text-amber-500'],
                ['label' => 'Setiap Saat', 'value' => $totalSetiapSaat ?? 0, 'color' => 'text-emerald-600'],
            ];
        @endphp
        @foreach($stats as $stat)
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">{{ $stat['label'] }}</span>
                <span class="text-3xl font-extrabold {{ $stat['color'] }}">{{ $stat['value'] }}</span>
            </div>
        @endforeach
    </div>

    <!-- Filter & Search -->
    <form action="{{ url('/admin/informasi-publik') }}" method="GET" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4">
        <div class="w-full md:w-80">
            <select name="kategori" onchange="this.form.submit()" class="w-full border border-gray-200 rounded-xl p-3 text-sm font-bold bg-gray-50 focus:border-[#0095e8] focus:ring-1 focus:ring-[#0095e8] transition outline-none">
                <option value="">Semua Kategori</option>
                <option value="Informasi Tersedia Secara Berkala" {{ request('kategori') == 'Informasi Tersedia Secara Berkala' ? 'selected' : '' }}>Informasi Tersedia Secara Berkala</option>
                <option value="Informasi Diumumkan Serta-Merta" {{ request('kategori') == 'Informasi Diumumkan Serta-Merta' ? 'selected' : '' }}>Informasi Diumumkan Serta-Merta</option>
                <option value="Informasi Tersedia Setiap Saat" {{ request('kategori') == 'Informasi Tersedia Setiap Saat' ? 'selected' : '' }}>Informasi Tersedia Setiap Saat</option>
            </select>
        </div>
        <div class="flex-1 relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul atau detail informasi..." class="w-full border border-gray-200 rounded-xl pl-12 pr-4 py-3 text-sm bg-gray-50 focus:border-[#0095e8] focus:ring-1 focus:ring-[#0095e8] transition outline-none">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400"></i>
        </div>
    </form>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-[11px] font-extrabold text-gray-500 uppercase tracking-widest border-b border-gray-100">
                        <th class="p-5 pl-8">Rincian Informasi</th>
                        <th class="p-5">Sub/Ringkasan Informasi</th>
                        <th class="p-5">Kategori</th>
                        <th class="p-5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-sm">
                    @forelse ($informasi as $item)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="p-5 pl-8"><span class="font-bold text-gray-900">{{ $item->rincian_informasi }}</span></td>
                            <td class="p-5 text-gray-600">{{ $item->sub_informasi }}</td>
                            <td class="p-5"><span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase bg-gray-100 text-gray-600">{{ $item->kategori }}</span></td>
                            <td class="p-5 text-center">
                                <button type="button"
                                    onclick="editData({{ json_encode($item) }})"
                                    class="p-2.5 text-gray-500 hover:text-[#0095e8] hover:bg-blue-50 rounded-lg transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ url('/admin/informasi-publik/'.$item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-12 text-center text-gray-400">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODALS (Create & Edit) -->
    @include('admin.partials.modal_informasi')

    <script>
        // Modal Control
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        // Live Search Debounce
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.querySelector('input[name="search"]');
            let timeout = null;
            if(searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        if (this.value.length >= 2 || this.value.length === 0) this.form.submit();
                    }, 500);
                });
            }
        });

        // Toggle Rincian (Dropdown vs Text Baru)
        function toggleRincian(prefix, value) {
            const inputBaru = document.getElementById(`${prefix}_rincian_baru`);
            const selectElement = document.getElementById(`${prefix}_rincian_select`);

            if (value === 'baru') {
                inputBaru.classList.remove('hidden');
                inputBaru.required = true;
                selectElement.name = "kategori_lama"; // Bypass required
                inputBaru.name = "rincian_informasi_baru";
            } else {
                inputBaru.classList.add('hidden');
                inputBaru.required = false;
                selectElement.name = "rincian_informasi";
            }
        }

        // Toggle Format (File vs Link)
        function toggleFormat(prefix, jenis) {
            const zonaFile = document.getElementById(`${prefix}_zona_file`);
            const zonaLink = document.getElementById(`${prefix}_zona_link`);
            const inputFile = document.getElementById(`${prefix}_input_file`);
            const inputLink = document.getElementById(`${prefix}_input_link`);

            if (jenis === 'file') {
                zonaFile.classList.remove('hidden');
                zonaLink.classList.add('hidden');
                inputFile.disabled = false;
                inputLink.disabled = true;
            } else {
                zonaFile.classList.add('hidden');
                zonaLink.classList.remove('hidden');
                inputFile.disabled = true;
                inputLink.disabled = false;
            }
        }

        // Populate Edit Modal Data
        function editData(item) {
            // Set Form Action URL
            const form = document.getElementById('form-edit');
            form.action = `/admin/informasi-publik/${item.id}`;

            // 1. Set Rincian Informasi
            const selectRincian = document.getElementById('edit_rincian_select');
            let isExists = Array.from(selectRincian.options).some(opt => opt.value === item.rincian_informasi);

            if (isExists) {
                selectRincian.value = item.rincian_informasi;
                toggleRincian('edit', item.rincian_informasi);
            } else {
                // Fallback jika tidak ada di list
                selectRincian.value = 'baru';
                toggleRincian('edit', 'baru');
                document.getElementById('edit_rincian_baru').value = item.rincian_informasi;
            }

            // 2. Set Sub & Kategori
            document.getElementById('edit_sub').value = item.sub_informasi;
            document.getElementById('edit_kategori').value = item.kategori;

            // 3. Set Format
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
