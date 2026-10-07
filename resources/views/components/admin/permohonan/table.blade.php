@props(['permohonans'])

<!-- Table Container (Header, Filters, Search, Table & Pagination) -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Filter Bar: Selaras dengan Daftar Informasi Publik -->
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/60">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">

            <!-- Kiri: Tombol Hapus + Filter Status -->
            <div class="flex flex-wrap items-center gap-2.5">

                <!-- Tombol Hapus -->
                <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition shadow-2xs hover:shadow-xs cursor-pointer shrink-0 whitespace-nowrap select-none">
                    <i class="fa-solid fa-list-check"></i>
                    <span id="text-select-mode">Hapus</span>
                </button>

                <!-- Tombol Bulk Delete -->
                <button type="button" id="btn-bulk-delete" onclick="triggerBulkDelete()"
                        class="hidden inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-2xl transition shadow-xs cursor-pointer shrink-0 whitespace-nowrap select-none">
                    <i class="fa-solid fa-trash"></i>
                    <span>Hapus (<span id="selected-count">0</span>) data terpilih</span>
                </button>

                <!-- Separator -->
                <div class="w-px h-6 bg-slate-300 mx-0.5 shrink-0"></div>

                <!-- Filter Status Pills -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <a href="{{ route('admin.permohonan.index', request()->except(['status', 'page'])) }}"
                       class="px-3.5 py-2 text-sm font-bold rounded-xl transition whitespace-nowrap
                              {{ !request('status') ? 'bg-sky-500 text-white shadow-xs' : 'bg-white border border-slate-300 text-slate-600 hover:bg-slate-100' }}">
                        Semua
                    </a>
                    @foreach(['Diajukan','Diproses','Selesai','Ditolak'] as $st)
                    <a href="{{ route('admin.permohonan.index', array_merge(request()->except(['page']), ['status' => $st])) }}"
                       class="px-3.5 py-2 text-sm font-bold rounded-xl transition whitespace-nowrap
                              {{ request('status') === $st ? 'bg-sky-500 text-white shadow-xs' : 'bg-white border border-slate-300 text-slate-800 hover:bg-slate-100' }}">
                        {{ $st }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Kanan: Label Cari + Input (persis gaya DIP) -->
            <form id="filter-search-form" action="{{ route('admin.permohonan.index') }}" method="GET">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-800">Cari:
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="No. tiket, nama, NIK pemohon..."
                           autocomplete="off"
                           class="w-48 sm:w-64 px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-normal focus:outline-none focus:ring-2 focus:ring-sky-500/30">
                </label>
            </form>
        </div>
    </div>


    <!-- Form Bulk Delete Terpisah -->
    <form id="form-bulk-delete" action="{{ route('admin.permohonan.bulk') }}" method="POST">
        @csrf
        @method('DELETE')

        <!-- Table Content — horizontal scroll on mobile with table border & divider styling matching DIP -->
        <div class="overflow-x-auto -webkit-overflow-scrolling-touch">
            <table class="w-full min-w-[1000px] text-left border-collapse border border-slate-200">
                <thead>
                    <tr class="bg-sky-500 text-white text-xs md:text-sm font-extrabold tracking-wide select-none whitespace-nowrap">
                        <th id="col-checkbox-header" class="hidden px-2 py-3.5 w-12 text-center">
                            <input type="checkbox" id="check-all" onclick="toggleCheckAll(this)" class="w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer">
                        </th>
                        <th onclick="sortPermohonanTable('no_tiket')" class="px-4 py-3.5 text-center w-40 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan">
                            <div class="flex items-center justify-center gap-1.5">
                                <span>No. Tiket</span>
                                <span class="inline-flex items-center justify-center text-xs text-white/70 group-hover:text-white transition">
                                    <i class="fa-solid fa-sort"></i>
                                </span>
                            </div>
                        </th>
                        <th onclick="sortPermohonanTable('nama')" class="px-4 py-3.5 text-left min-w-[220px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan">
                            <div class="flex items-center gap-1.5">
                                <span>Pemohon</span>
                                <span class="inline-flex items-center justify-center text-xs text-white/70 group-hover:text-white transition">
                                    <i class="fa-solid fa-sort"></i>
                                </span>
                            </div>
                        </th>
                        <th onclick="sortPermohonanTable('tanggal')" class="px-4 py-3.5 text-center w-36 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan">
                            <div class="flex items-center justify-center gap-1.5">
                                <span>Tgl. Pengajuan</span>
                                <span class="inline-flex items-center justify-center text-xs text-white/70 group-hover:text-white transition">
                                    <i class="fa-solid fa-sort"></i>
                                </span>
                            </div>
                        </th>
                        <th class="px-4 py-3.5 text-left">Informasi yang Diminta</th>
                        <th onclick="sortPermohonanTable('status')" class="px-3.5 py-3.5 text-center w-32 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan">
                            <div class="flex items-center justify-center gap-1.5">
                                <span>Status</span>
                                <span class="inline-flex items-center justify-center text-xs text-white/70 group-hover:text-white transition">
                                    <i class="fa-solid fa-sort"></i>
                                </span>
                            </div>
                        </th>
                        <th class="px-3 py-3.5 text-center w-28">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 text-sm md:text-base font-medium text-slate-800">
                    @forelse($permohonans as $item)
                        <tr class="hover:bg-sky-50/70 transition-colors">
                            <td class="col-checkbox-cell hidden px-2 py-3 text-center align-middle">
                                <input type="checkbox" name="ids[]" value="{{ $item->id }}" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                            </td>
                            <td class="px-4 py-3.5 font-mono font-bold text-blue-600 text-center whitespace-nowrap align-middle">
                                {{ $item->no_tiket }}
                            </td>
                            <td class="px-4 py-3.5 align-middle">
                                <div class="font-bold text-slate-900 leading-snug">{{ $item->nama_lengkap }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600 font-medium text-center whitespace-nowrap align-middle">
                                {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 leading-relaxed break-words align-middle text-slate-800">
                                {{ $item->informasi_yang_diminta }}
                            </td>
                            <td class="px-3.5 py-3.5 text-center align-middle whitespace-nowrap">
                                <div class="flex flex-col items-center gap-1">
                                    @if($item->status === 'Menunggu' || $item->status === 'Diajukan')
                                        <span class="inline-block px-3 py-1 text-xs font-bold bg-slate-100 text-slate-700 rounded-lg border border-slate-200">
                                             Diajukan
                                        </span>
                                    @elseif($item->status === 'Perlu Tindakan' || $item->status === 'Diproses' || $item->status === 'Proses')
                                        <span class="inline-block px-3 py-1 text-xs font-bold bg-orange-50 text-orange-700 rounded-lg border border-orange-200">
                                            Diproses
                                        </span>
                                    @elseif($item->status === 'Terima' || $item->status === 'Selesai')
                                        <span class="inline-block px-3 py-1 text-xs font-bold bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-200">
                                            Selesai
                                        </span>
                                    @elseif($item->status === 'Ditolak')
                                        <span class="inline-block px-3 py-1 text-xs font-bold bg-rose-50 text-rose-700 rounded-lg border border-rose-200">
                                            Ditolak
                                        </span>
                                    @endif

                                    @if($item->keberatan)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[10px] font-bold bg-amber-500 text-white rounded-md shadow-2xs" title="Permohonan ini sedang dalam sengketa keberatan">
                                            <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Keberatan
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3.5 text-center align-middle whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                    @php
                                        $statusAwal = $item->status;
                                    @endphp

                                    @if($item->keberatan)
                                        <a href="{{ route('admin.permohonan.show', $item->id) }}"
                                           class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-slate-600 bg-slate-100 hover:bg-slate-200 transition shadow-2xs rounded-lg cursor-pointer"
                                           title="Lihat Detail Permohonan (Dalam Keberatan)">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                        </a>
                                    @elseif($statusAwal === 'Diajukan' || $statusAwal === 'Menunggu')
                                        <a href="{{ route('admin.permohonan.show', $item->id) }}"
                                           class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs rounded-lg cursor-pointer"
                                           title="Proses Permohonan">
                                            <i class="fa-solid fa-gears text-xs"></i>
                                        </a>
                                    @elseif($statusAwal === 'Perlu Tindakan' || $statusAwal === 'Diproses' || $statusAwal === 'Proses')
                                        <a href="{{ route('admin.permohonan.show', $item->id) }}"
                                           class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white transition shadow-2xs rounded-lg cursor-pointer"
                                           title="Tindaklanjuti">
                                            <i class="fa-solid fa-reply text-xs"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.permohonan.show', $item->id) }}"
                                           class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-slate-600 bg-slate-100 hover:bg-slate-200 transition shadow-2xs rounded-lg cursor-pointer"
                                           title="Lihat Detail">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                        </a>
                                    @endif

                                    <button type="button" onclick="triggerDelete('{{ route('admin.permohonan.destroy', $item->id) }}', '{{ $item->no_tiket }}')"
                                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-2xs rounded-lg cursor-pointer"
                                            title="Hapus Permohonan Ini">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400 font-semibold text-sm">
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
