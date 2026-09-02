@props(['informasi', 'listTahun' => []])

<!-- Table Container -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Filter & Action Bar Header -->
    <div class="p-6 border-b border-slate-100">
        <!-- Interactive Filter Pill & Search Bar & Tombol Tambah Informasi -->
        <form id="filter-search-form" action="{{ url('/admin/informasi-publik') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full">
            <!-- Tombol Pilih & Hapus -->
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()"
                        class="inline-flex items-center justify-center gap-2 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs md:text-sm font-extrabold rounded-xl transition cursor-pointer h-[48px] whitespace-nowrap">
                    <i class="fa-solid fa-list-check"></i> <span id="text-select-mode">Pilih</span>
                </button>

                <button type="button" id="btn-bulk-delete" onclick="triggerBulkDelete()"
                        class="hidden inline-flex items-center justify-center gap-2 px-5 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-xl transition shadow-xs cursor-pointer h-[48px] whitespace-nowrap">
                    <i class="fa-solid fa-trash"></i> <span>Hapus (<span id="selected-count">0</span>)</span>
                </button>
            </div>

            @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif

            <!-- Pill Filter Kategori -->
            <div class="flex items-center gap-1.5 bg-slate-100/80 p-1.5 rounded-xl border border-slate-200/50 shrink-0 h-[48px]">
                <a href="{{ request()->fullUrlWithQuery(['kategori' => null]) }}" class="px-4 py-2 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('kategori') == '' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">Semua</a>
                <a href="{{ request()->fullUrlWithQuery(['kategori' => 'Informasi Berkala']) }}" class="px-4 py-2 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('kategori') == 'Informasi Berkala' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">Berkala</a>
                <a href="{{ request()->fullUrlWithQuery(['kategori' => 'Informasi Serta-Merta']) }}" class="px-4 py-2 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('kategori') == 'Informasi Serta-Merta' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">Serta-Merta</a>
                <a href="{{ request()->fullUrlWithQuery(['kategori' => 'Informasi Setiap Saat']) }}" class="px-4 py-2 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('kategori') == 'Informasi Setiap Saat' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">Setiap Saat</a>
                <a href="{{ request()->fullUrlWithQuery(['kategori' => 'Informasi Dikecualikan']) }}" class="px-4 py-2 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('kategori') == 'Informasi Dikecualikan' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">Dikecualikan</a>
            </div>

            <!-- Dropdown Filter Tahun Terbit Dinamis -->
            <select name="tahun" onchange="document.getElementById('filter-search-form').submit()" 
                    class="bg-slate-50 border border-slate-200 text-slate-700 text-xs md:text-sm font-bold px-4 py-2 rounded-xl focus:outline-none focus:bg-white focus:border-[#1B365D] transition-all cursor-pointer h-[48px] shrink-0">
                <option value="">Semua Tahun</option>
                @if(isset($listTahun) && count($listTahun) > 0)
                    @foreach($listTahun as $y)
                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                @endif
            </select>

            <!-- Input Searchbar Penuh (Mengisi Seluruh Sisa Ruang Gap) -->
            <div class="relative flex-1 min-w-[240px] h-[48px]">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau deskripsi..." class="w-full h-full pl-11 pr-26 bg-slate-50 border border-slate-200 text-xs md:text-sm font-semibold text-slate-800 placeholder-slate-400 rounded-xl focus:outline-none focus:bg-white focus:border-[#1B365D] transition-all shadow-xs" autocomplete="off">
                <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-[#1B365D] hover:bg-[#152a4a] text-white text-xs font-extrabold rounded-lg transition cursor-pointer shadow-xs">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i> Cari
                </button>
            </div>
        </form>
    </div>

    <form id="form-bulk-delete" action="{{ route('admin.informasi.bulk') }}" method="POST">
        @csrf
        @method('DELETE')

        <!-- Tabel Daftar Informasi Publik Clean Modern -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#1B365D] text-white text-xs md:text-sm font-extrabold tracking-wide whitespace-nowrap">
                        <th id="col-checkbox-header" class="hidden px-4 py-4 w-10 text-center">
                            <input type="checkbox" id="check-all" onclick="toggleCheckAll(this)" class="w-4 h-4 rounded border-white/30 text-[#1B365D] focus:ring-0 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 whitespace-nowrap">Judul Informasi</th>
                        <th class="px-6 py-4 whitespace-nowrap">Deskripsi Informasi</th>
                        <th class="px-6 py-4 whitespace-nowrap">Kategori Informasi</th>
                        <th class="px-6 py-4 whitespace-nowrap text-center">Tahun Terbit</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-xs sm:text-sm font-medium text-slate-800">
                    @forelse($informasi as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="col-checkbox-cell hidden px-4 py-4 text-center">
                                <input type="checkbox" name="ids[]" form="form-bulk-delete" value="{{ $item->id }}" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                            </td>

                            <td class="p-6 font-extrabold text-slate-900 break-words leading-relaxed">
                                {{ $item->judul_informasi }}
                            </td>

                            <td class="p-6 font-semibold text-slate-700 break-words leading-relaxed">{{ $item->deskripsi_informasi }}</td>
                            <td class="p-6 whitespace-nowrap">
                                @if($item->kategori_informasi === 'Informasi Setiap Saat')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 whitespace-nowrap">
                                        Informasi Setiap Saat
                                    </span>
                                @elseif($item->kategori_informasi === 'Informasi Berkala')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-xs font-bold bg-cyan-100 text-cyan-800 border border-cyan-200 whitespace-nowrap">
                                        Informasi Berkala
                                    </span>
                                @elseif($item->kategori_informasi === 'Informasi Serta-Merta')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-xs font-bold bg-red-100 text-red-800 border border-red-200 whitespace-nowrap">
                                        Informasi Serta-Merta
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-[6px] text-xs font-bold bg-slate-100 text-slate-700 border border-slate-300 whitespace-nowrap">
                                        Informasi Dikecualikan
                                    </span>
                                @endif
                            </td>
                            <td class="p-6 text-center font-bold text-slate-700 whitespace-nowrap">
                                {{ $item->tahun_terbit ?? date('Y', strtotime($item->created_at ?? now())) }}
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                     @php
                                         $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                         $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->judul_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                     @endphp
                                     <a href="{{ ($item->link_informasi && !$item->file_informasi) ? $item->link_informasi : url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName).'?from_admin=1') }}" target="_blank" title="Lihat Berkas" class="p-2.5 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white transition shadow-xs" style="border-radius: 6px !important;">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                    </a>
                                    <button type="button" onclick="editData({{ json_encode($item) }})" title="Edit Data" class="p-2.5 text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-xs cursor-pointer" style="border-radius: 6px !important;">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </button>
                                    <button type="button" onclick="triggerDelete('{{ url('/admin/informasi-publik/'.$item->id) }}', '{{ addslashes($item->judul_informasi) }}')" title="Hapus Data" class="p-2.5 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-xs cursor-pointer" style="border-radius: 6px !important;">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data Informasi Publik.</td></tr>
                    @endforelse
                </tbody>
            </table>
        
        <!-- Pagination Footer -->
        <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs md:text-sm font-semibold text-slate-500">
                Menampilkan <span class="font-extrabold text-slate-900">{{ $informasi->firstItem() ?? 0 }}–{{ $informasi->lastItem() ?? 0 }}</span> dari <span class="font-black text-[#1B365D]">{{ $informasi->total() }}</span> informasi publik
            </div>

            <!-- Pagination Nomor Angka -->
            <div class="flex items-center gap-1.5 flex-wrap">
                {{-- Tombol Prev --}}
                @if ($informasi->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 text-xs font-bold cursor-not-allowed select-none border border-slate-200/50">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </span>
                @else
                    <a href="{{ $informasi->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-extrabold border border-slate-200 transition shadow-2xs">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </a>
                @endif

                {{-- Angka-angka Halaman --}}
                @foreach (range(1, $informasi->lastPage()) as $page)
                    @if ($page == $informasi->currentPage())
                        <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#1B365D] text-white text-xs font-black shadow-xs">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $informasi->url($page) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-extrabold border border-slate-200 transition shadow-2xs">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Tombol Next --}}
                @if ($informasi->hasMorePages())
                    <a href="{{ $informasi->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-extrabold border border-slate-200 transition shadow-2xs">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 text-xs font-bold cursor-not-allowed select-none border border-slate-200/50">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
</form>
</div>
