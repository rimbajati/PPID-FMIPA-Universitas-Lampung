@props(['permohonans'])

<!-- Table Container (Header, Filters, Search, Table & Pagination) -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Action Header, Bulk Actions, Pill Filters & Wide Search Bar -->
    <div class="p-6 border-b border-slate-100">
        <form id="filter-search-form" action="{{ route('admin.permohonan.index') }}" method="GET" class="flex flex-col xl:flex-row items-start xl:items-center gap-3 w-full">
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()"
                        class="inline-flex items-center justify-center gap-2 px-5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs md:text-sm font-extrabold rounded-xl transition cursor-pointer h-[48px] whitespace-nowrap select-none">
                    <i class="fa-solid fa-list-check"></i> <span id="text-select-mode">Pilih</span>
                </button>

                <button type="button" id="btn-bulk-delete" onclick="triggerBulkDelete()"
                        class="hidden inline-flex items-center justify-center gap-2 px-5 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-xl transition shadow-xs cursor-pointer h-[48px] whitespace-nowrap select-none">
                    <i class="fa-solid fa-trash"></i> <span>Hapus (<span id="selected-count">0</span>)</span>
                </button>
            </div>

            <!-- Interactive Pill Filters & Search -->
            <div class="flex flex-wrap items-center gap-3 flex-1">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="flex items-center gap-1.5 bg-slate-100/80 p-1.5 rounded-2xl border border-slate-200/50 shrink-0 h-[48px]">
                    <a href="{{ route('admin.permohonan.index') }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ !request('status') || request('status') == 'Semua' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.permohonan.index', array_merge(request()->query(), ['status' => 'Diajukan'])) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('status') == 'Diajukan' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">
                        Diajukan
                    </a>
                    <a href="{{ route('admin.permohonan.index', array_merge(request()->query(), ['status' => 'Diproses'])) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('status') == 'Diproses' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">
                        Diproses
                    </a>
                    <a href="{{ route('admin.permohonan.index', array_merge(request()->query(), ['status' => 'Selesai'])) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('status') == 'Selesai' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900' }}">
                        Selesai
                    </a>
                    <a href="{{ route('admin.permohonan.index', array_merge(request()->query(), ['status' => 'Ditolak'])) }}" 
                       class="px-4 py-2 rounded-xl text-xs md:text-sm transition-all duration-200 whitespace-nowrap {{ request('status') == 'Ditolak' ? 'bg-white text-slate-900 shadow-xs font-black' : 'text-slate-500 font-bold hover:text-slate-900' }}">
                        Ditolak
                    </a>
                </div>

                <!-- Input Searchbar -->
                <div class="flex-1 min-w-[200px] h-[48px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. tiket, nama pemohon, NIK pemohon..." 
                           class="w-full h-full px-4 bg-slate-50 border border-slate-200 text-xs md:text-sm font-semibold text-slate-800 placeholder-slate-400 rounded-xl focus:bg-white focus:outline-none focus:border-sky-500 transition shadow-xs" autocomplete="off">
                </div>

                <!-- Tombol Cari Terpisah -->
                <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-5 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-xl transition cursor-pointer shadow-xs shrink-0 whitespace-nowrap h-[48px]">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i> <span>Cari</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Form Bulk Delete Terpisah -->
    <form id="form-bulk-delete" action="{{ route('admin.permohonan.bulk') }}" method="POST">
        @csrf
        @method('DELETE')

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-sky-500 text-white text-xs md:text-sm font-extrabold tracking-wide whitespace-nowrap">
                        <th id="col-checkbox-header" class="hidden px-4 py-4 w-10 text-center">
                            <input type="checkbox" id="check-all" onclick="toggleCheckAll(this)" class="w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 whitespace-nowrap">No. Tiket</th>
                        <th class="px-6 py-4 whitespace-nowrap">Pemohon</th>
                        <th class="px-6 py-4 whitespace-nowrap">Tgl. Pengajuan</th>
                        <th class="px-6 py-4 whitespace-nowrap">Informasi yang Diminta</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs md:text-sm">
                    @forelse($permohonans as $item)
                        <tr class="hover:bg-sky-50/70 transition-colors">
                            <td class="col-checkbox-cell hidden px-4 py-2.5 text-center">
                                <input type="checkbox" name="ids[]" value="{{ $item->id }}" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                            </td>
                            <td class="px-6 py-2.5 font-bold text-slate-800 whitespace-nowrap">
                                {{ $item->no_tiket }}
                            </td>
                            <td class="px-6 py-2.5">
                                <div class="text-xs md:text-sm font-extrabold text-slate-900">{{ $item->nama_lengkap }}</div>
                                <div class="text-xs text-slate-400 font-semibold">NIK: {{ $item->no_identitas ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-2.5 text-slate-500 font-medium whitespace-nowrap">
                                {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-2.5 max-w-xs md:max-w-sm">
                                <p class="text-slate-700 font-medium leading-relaxed line-clamp-2 text-xs md:text-sm">
                                    {{ $item->informasi_yang_diminta }}
                                </p>
                            </td>
                            <td class="px-6 py-2.5 text-center whitespace-nowrap">
                                <div class="flex flex-col items-center gap-1">
                                    @if($item->status === 'Menunggu' || $item->status === 'Diajukan')
                                        <span class="inline-block px-3.5 py-1 text-xs font-extrabold bg-slate-100 text-slate-700 rounded-lg border border-slate-200">
                                             Diajukan
                                        </span>
                                    @elseif($item->status === 'Perlu Tindakan' || $item->status === 'Diproses' || $item->status === 'Proses')
                                        <span class="inline-block px-3.5 py-1 text-xs font-extrabold bg-orange-50 text-orange-700 rounded-lg border border-orange-200">
                                            Diproses
                                        </span>
                                    @elseif($item->status === 'Terima' || $item->status === 'Selesai')
                                        <span class="inline-block px-3.5 py-1 text-xs font-extrabold bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-200">
                                            Selesai
                                        </span>
                                    @elseif($item->status === 'Ditolak')
                                        <span class="inline-block px-3.5 py-1 text-xs font-extrabold bg-rose-50 text-rose-700 rounded-lg border border-rose-200">
                                            Ditolak
                                        </span>
                                    @endif

                                    @if($item->keberatan)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-black bg-amber-500 text-white rounded-md shadow-2xs" title="Permohonan ini sedang dalam sengketa keberatan">
                                            <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Keberatan
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-2.5 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    @php
                                        $statusAwal = $item->status;
                                    @endphp

                                    @if($item->keberatan)
                                        <a href="{{ route('admin.permohonan.show', $item->id) }}"
                                           class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-500 bg-slate-100 hover:bg-slate-200 hover:text-slate-800 transition cursor-pointer shadow-2xs border border-slate-200"
                                           title="Lihat Detail Permohonan (Dalam Keberatan)">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                    @elseif($statusAwal === 'Diajukan' || $statusAwal === 'Menunggu')
                                        <a href="{{ route('admin.permohonan.show', $item->id) }}"
                                           class="w-8 h-8 flex items-center justify-center rounded-xl text-amber-700 bg-amber-50 hover:bg-amber-500 hover:text-white transition cursor-pointer shadow-2xs border border-amber-200"
                                           title="Proses Permohonan">
                                            <i class="fa-solid fa-gears text-xs"></i>
                                        </a>
                                    @elseif($statusAwal === 'Perlu Tindakan' || $statusAwal === 'Diproses' || $statusAwal === 'Proses')
                                        <a href="{{ route('admin.permohonan.show', $item->id) }}"
                                           class="w-8 h-8 flex items-center justify-center rounded-xl text-sky-700 bg-sky-50 hover:bg-sky-500 hover:text-white transition cursor-pointer shadow-2xs border border-sky-200"
                                           title="Tindaklanjuti">
                                            <i class="fa-solid fa-reply text-xs"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.permohonan.show', $item->id) }}"
                                           class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-500 bg-slate-100 hover:bg-slate-200 hover:text-slate-800 transition cursor-pointer shadow-2xs border border-slate-200"
                                           title="Lihat Detail">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>
                                    @endif

                                    <button type="button" onclick="triggerDelete('{{ route('admin.permohonan.destroy', $item->id) }}', '{{ $item->no_tiket }}')"
                                            class="w-8 h-8 flex items-center justify-center text-rose-600 bg-rose-50/90 hover:bg-rose-600 hover:text-white rounded-xl transition cursor-pointer shadow-2xs border border-rose-200/60"
                                            title="Hapus Permohonan Ini">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400 font-semibold text-xs md:text-sm">
                                Tidak ada data permohonan informasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="p-6 border-t border-slate-100">
            <x-ui.pagination :paginator="$permohonans" label="permohonan" />
        </div>
    </form>
</div>
