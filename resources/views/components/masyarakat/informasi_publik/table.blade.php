@props(['informasi', 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => []])

<!-- Table Container Informasi Publik (Masyarakat / Publik) -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Tabel Daftar Informasi Publik (Fit Screen, Never Horizontal Scroll) -->
    <div>
        <table class="w-full table-fixed text-left border-collapse border border-slate-300">
            <thead>
                @php
                    $curSortBy = request('sort_by');
                    $curSortDir = request('sort_direction', 'asc');
                @endphp
                <tr class="bg-sky-500 text-white text-[11px] sm:text-xs md:text-sm font-black tracking-tight divide-x divide-white/40 border-b border-sky-600 text-center leading-snug select-none">
                    <th onclick="sortDipTable('no')" class="px-1 py-3 text-center w-12 shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
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
                    <th onclick="sortDipTable('ringkasan')" class="px-2 py-3 text-center w-[20%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Ringkasan Isi Informasi">
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
                    <th onclick="sortDipTable('jenis')" class="px-1.5 py-3 w-[11%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Jenis Informasi">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Jenis Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'jenis' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'jenis')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('pejabat')" class="px-2 py-3 w-[14%] break-normal cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Pejabat/Unit/Satker">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Pejabat/Unit/Satker yang Menguasai Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'pejabat' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'pejabat')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('penanggung_jawab')" class="px-1.5 py-3 w-[14%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Penanggung Jawab">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Penanggung Jawab Pembuatan atau Penerbitan Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'penanggung_jawab' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'penanggung_jawab')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('waktu')" class="px-1.5 py-3 w-[12%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Waktu dan Tempat">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Waktu dan Tempat Pembuatan Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'waktu' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'waktu')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('retensi')" class="px-1.5 py-3 w-[11%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Retensi Arsip">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Jangka Waktu Penyimpanan atau Retensi Arsip</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'retensi' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'retensi')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('bentuk')" class="px-1.5 py-3 w-[10.5%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Bentuk Informasi">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Bentuk Informasi yang Tersedia</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm {{ $curSortBy === 'bentuk' ? 'text-white' : 'text-white/70 group-hover:text-white' }} transition">
                                @if($curSortBy === 'bentuk')
                                    <i class="fa-solid {{ $curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up' }}"></i>
                                @else
                                    <i class="fa-solid fa-sort"></i>
                                @endif
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('dilihat')" class="px-1.5 py-3 w-[8%] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan berdasarkan Sering Dilihat">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Akses</span>
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
            <tbody id="table-dip-body" class="divide-y divide-slate-200 text-xs sm:text-sm font-medium text-slate-800">
                @forelse($informasi as $idx => $item)
                    <tr class="table-dip-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-200"
                        data-id="{{ $item->id }}"
                        data-no="{{ $idx + 1 }}"
                        data-dilihat="{{ (int)($item->dilihat ?? 0) }}"
                        data-ringkasan="{{ strtolower($item->ringkasan_isi_informasi ?? '') }}"
                        data-jenis="{{ strtolower($item->jenis_informasi ?? '') }}"
                        data-pejabat="{{ strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '') }}"
                        data-penanggung_jawab="{{ strtolower($item->penanggung_jawab_pembuatan_informasi ?? '') }}"
                        data-waktu="{{ strtolower($item->waktu_pembuatan_informasi ?? '') }}"
                        data-retensi="{{ strtolower($item->retensi_arsip ?? '') }}"
                        data-bentuk="{{ strtolower($item->bentuk_informasi_yang_tersedia ?? '') }}">
                        <!-- 0. Kolom No -->
                        <td class="col-dip-no px-2 py-3 text-center font-bold text-slate-400">
                            {{ $idx + 1 }}
                        </td>

                        <!-- 1. Ringkasan Isi Informasi -->
                        <td class="px-3.5 py-3 text-slate-900 leading-normal break-words text-xs sm:text-sm">
                            @php
                                $subText = trim($item->sub_informasi ?: ($item->ringkasan_isi_informasi ?: ''));
                                $ringkasanText = trim($item->ringkasan_isi_informasi ?: '');
                            @endphp
                            <div class="space-y-1">
                                @if($subText && $subText !== 'Dokumen sedang dilengkapi unit')
                                    <div class="font-black text-slate-900 leading-snug">{{ $subText }}</div>
                                @endif

                                @if($ringkasanText && $ringkasanText !== $subText && $ringkasanText !== 'Dokumen sedang dilengkapi unit')
                                    <div class="text-xs text-slate-500 font-normal leading-relaxed">{{ $ringkasanText }}</div>
                                @endif

                                @if($item->dilihat)
                                    <div class="text-[11px] text-slate-400 font-semibold flex items-center gap-1.5 pt-0.5">
                                        <i class="fa-regular fa-eye text-[10px]"></i>
                                        <span>{{ number_format($item->dilihat) }} dilihat</span>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- 2. Jenis Informasi (Berkala / Serta Merta / Setiap Saat) -->
                        <td class="px-2.5 py-3 font-medium text-slate-700 text-center break-words text-xs sm:text-sm leading-normal">
                            @php
                                $cleanJenis = preg_replace('/^informasi\s+/i', '', trim($item->jenis_informasi ?? ''));
                            @endphp
                            {{ $cleanJenis ?: ($item->jenis_informasi ?: '-') }}
                        </td>

                        <!-- 3. Pejabat/Unit/Satker Yang Menguasai Informasi -->
                        <td class="px-3 py-3 font-medium text-slate-700 text-center break-words text-xs sm:text-sm leading-normal">
                            {{ $item->pejabat_unit_yang_menguasai_informasi ?: '-' }}
                        </td>

                        <!-- 4. Penanggung Jawab Pembuatan Informasi -->
                        <td class="px-3 py-3 font-medium text-slate-700 text-center break-words text-xs sm:text-sm leading-normal">
                            {{ $item->penanggung_jawab_pembuatan_informasi ?: '-' }}
                        </td>

                        <!-- 5. Waktu dan Tempat Pembuatan Informasi -->
                        <td class="px-3 py-3 text-center font-medium text-slate-700 break-words text-xs sm:text-sm leading-normal">
                            {{ $item->waktu_pembuatan_informasi ?? date('Y', strtotime($item->created_at ?? now())) }}
                        </td>

                        <!-- 6. Jangka Waktu Penyimpanan atau Retensi Arsip -->
                        <td class="px-3 py-3 text-center font-medium text-slate-700 break-words text-xs sm:text-sm leading-normal">
                            {{ $item->retensi_arsip ?: '-' }}
                        </td>

                        <!-- 7. Bentuk/Format Informasi yang Tersedia -->
                        <td class="px-3 py-3 text-center font-semibold text-slate-700 break-words text-xs sm:text-sm leading-normal">
                            {{ $item->bentuk_informasi_yang_tersedia ?: 'Cetak dan Online' }}
                        </td>

                        <!-- 9. Akses (Hanya untuk Melihat Dokumen/Tautan) -->
                        <td class="px-2 py-3 text-center align-middle">
                            <div class="flex items-center justify-center">
                                @php
                                    $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                    $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->ringkasan_isi_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                    $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                        ? $item->link_informasi 
                                        : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName)) : null);
                                @endphp
                                @if($item->bentuk_informasi_yang_tersedia === 'Cetak' && !$item->file_informasi && !$item->link_informasi)
                                    <span class="text-slate-400 font-bold text-xs">-</span>
                                @elseif($fileTargetUrl && $fileTargetUrl !== '#')
                                    <a href="{{ $fileTargetUrl }}" target="_blank" title="Lihat Tautan / Berkas" 
                                       class="inline-flex items-center justify-center px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-lg transition shadow-2xs">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-slate-400 font-bold text-xs">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data Informasi Publik yang sesuai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer Kontrol Paginasi Client-side Instan (Persis seperti Unpad / DataTables) -->
    <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div id="table-dip-info" class="text-xs md:text-sm text-slate-800">
            Menampilkan 0 sampai 0 dari 0 entri
        </div>
        <div id="table-dip-pagination" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
            <!-- Render dinamis via JavaScript -->
        </div>
    </div>
</div>
