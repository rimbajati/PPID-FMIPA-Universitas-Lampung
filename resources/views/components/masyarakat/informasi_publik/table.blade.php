@props(['informasi', 'tableKey' => 'main'])

<!-- Table Container Informasi Publik (Masyarakat / Publik) -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Tabel Daftar Informasi Publik — horizontal scroll on mobile -->
    <div class="overflow-x-auto -webkit-overflow-scrolling-touch">
        <table class="w-full min-w-[1200px] table-auto border-collapse border border-slate-300">
            <thead>
                @php
                    $curSortBy = request('sort_by');
                    $curSortDir = request('sort_direction', 'asc');
                @endphp
                <tr class="bg-sky-500 text-white text-xs sm:text-sm md:text-lg font-black tracking-tight divide-x divide-white/40 border-b border-sky-600 text-center leading-snug select-none">
                    <th onclick="sortDipTable('{{ $tableKey }}', 'no')" class="px-2 py-3 text-center w-12 min-w-[48px] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>No</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'no' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'no')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'ringkasan')" class="px-3.5 py-3 text-center min-w-[300px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Ringkasan Isi Informasi">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Ringkasan Isi Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'ringkasan' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'ringkasan')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'pejabat')" class="px-3.5 py-3 text-center min-w-[210px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Pejabat/Unit yang Menguasai Informasi">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Pejabat/Unit yang Menguasai Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'pejabat' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'pejabat')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'penanggung_jawab')" class="px-3.5 py-3 text-center min-w-[180px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Penanggung Jawab">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Penanggung Jawab</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'penanggung_jawab' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'penanggung_jawab')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'waktu')" class="px-3.5 py-3 text-center min-w-[170px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Waktu dan Tempat Pembuatan">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Waktu dan Tempat Pembuatan</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'waktu' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'waktu')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'bentuk')" class="px-3 py-3 text-center min-w-[120px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Format">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Format</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'bentuk' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'bentuk')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'retensi')" class="px-3 py-3 text-center min-w-[140px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Retensi Arsip">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Retensi Arsip</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'retensi' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'retensi')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'dilihat')" class="px-2 py-3 text-center w-20 min-w-[80px] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan berdasarkan Akses / Sering Dilihat">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Aksi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'dilihat' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'dilihat')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="table-dip-body-{{ $tableKey }}" data-dip-tbody="{{ $tableKey }}" class="divide-y divide-slate-200 text-sm md:text-base font-medium text-slate-800 text-left">
                @forelse($informasi as $idx => $item)
                    <tr class="table-dip-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-200"
                        data-id="{{ $item->id }}"
                        data-no="{{ $idx + 1 }}"
                        data-dilihat="{{ (int)($item->dilihat ?? 0) }}"
                        data-ringkasan="{{ strtolower($item->sub_informasi ?? '') }}"
                        data-jenis="{{ strtolower($item->jenis_informasi ?? '') }}"
                        data-pejabat="{{ strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '') }}"
                        data-penanggung_jawab="{{ strtolower($item->penanggung_jawab_pembuatan_informasi ?? '') }}"
                        data-waktu="{{ strtolower($item->waktu_pembuatan_informasi ?? '') }}"
                        data-retensi="{{ strtolower($item->retensi_arsip ?? '') }}"
                        data-bentuk="{{ strtolower($item->bentuk_informasi_yang_tersedia ?? '') }}">
                        <!-- 0. Kolom No -->
                        <td class="col-dip-no px-3 py-3.5 text-center font-bold text-slate-400">
                            {{ $idx + 1 }}
                        </td>

                        <!-- 1. Ringkasan Isi Informasi -->
                        <td class="px-4 py-3.5 text-slate-900 leading-normal break-words text-sm md:text-base">
                            @php
                                $subVal = trim($item->sub_informasi ?: '');
                            @endphp
                            <div class="space-y-1">
                                @if($subVal && $subVal !== 'Dokumen sedang dilengkapi unit')
                                    <div class="font-medium text-slate-900 leading-snug">{{ $subVal }}</div>
                                @else
                                    <div class="font-medium text-slate-900 leading-snug">-</div>
                                    <div class="text-xs text-amber-600 font-semibold italic flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-[10px]"></i>
                                        <span>Dokumen sedang dilengkapi unit</span>
                                    </div>
                                @endif

                            </div>
                        </td>

                        <!-- 2. Pejabat/Unit yang Menguasai Informasi -->
                        <td class="px-4 py-3.5 font-medium text-slate-700 text-left break-words text-sm md:text-base leading-normal">
                            {{ $item->pejabat_unit_yang_menguasai_informasi ?: '-' }}
                        </td>

                        <!-- 3. Penanggung Jawab -->
                        <td class="px-4 py-3.5 font-medium text-slate-700 text-left break-words text-sm md:text-base leading-normal">
                            {{ $item->penanggung_jawab_pembuatan_informasi ?: '-' }}
                        </td>

                        <!-- 4. Waktu dan Tempat Pembuatan -->
                        <td class="px-4 py-3.5 text-left font-medium text-slate-700 break-words text-sm md:text-base leading-normal">
                            {{ $item->waktu_pembuatan_informasi ?: '-' }}
                        </td>

                        <!-- 5. Format -->
                        <td class="px-3.5 py-3.5 text-center font-semibold text-slate-700 break-words text-sm md:text-base leading-normal">
                            {{ $item->bentuk_informasi_yang_tersedia ?: '-' }}
                        </td>

                        <!-- 6. Retensi Arsip -->
                        <td class="px-3.5 py-3.5 text-center font-medium text-slate-700 break-words text-sm md:text-base leading-normal">
                            {{ $item->retensi_arsip ?: '-' }}
                        </td>

                        <!-- 7. Akses (Kolom Paling Kanan) -->
                        <td class="px-3 py-3.5 text-center align-middle">
                            <div class="flex items-center justify-center">
                                @php
                                    $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                    $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                    $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                        ? $item->link_informasi 
                                        : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName)) : null);
                                @endphp
                                @if($item->bentuk_informasi_yang_tersedia === 'Cetak' && !$item->file_informasi && !$item->link_informasi)
                                    <span class="text-slate-400 font-bold text-xs">-</span>
                                @elseif($fileTargetUrl && $fileTargetUrl !== '#')
                                    <a href="{{ $fileTargetUrl }}" target="_blank" title="Lihat Tautan / Berkas" 
                                       class="inline-flex items-center justify-center px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-sm md:text-base font-bold rounded-lg transition shadow-2xs">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-slate-400 font-bold text-xs">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data Informasi Publik yang sesuai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer Kontrol Paginasi Client-side Instan (Persis seperti Unpad / DataTables) -->
    <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div id="table-dip-info-{{ $tableKey }}" data-dip-info="{{ $tableKey }}" class="text-sm md:text-lg text-slate-800">
            Menampilkan 0–0 dari 0 informasi
        </div>
        <div id="table-dip-pagination-{{ $tableKey }}" data-dip-pagination="{{ $tableKey }}" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
            <!-- Render dinamis via JavaScript -->
        </div>
    </div>
</div>
