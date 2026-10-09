@props(['informasi', 'tableKey' => 'main', 'unified' => false])

<!-- Table Container Informasi Publik (Masyarakat / Publik) -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Tabel Daftar Informasi Publik — horizontal scroll on mobile -->
    <div class="overflow-x-auto -webkit-overflow-scrolling-touch">
        <table class="w-full min-w-[1200px] table-auto border-collapse border border-slate-200">
            <thead>
                <tr class="bg-sky-500 text-white text-xs md:text-sm font-black tracking-tight divide-x divide-white/40 border-b border-sky-600 text-left leading-snug select-none">
                    <th onclick="sortDipTable('{{ $tableKey }}', 'no')" class="px-2 py-3 w-12 shrink-0 cursor-pointer hover:bg-sky-600/60 transition group">
                        <div class="flex items-center justify-between gap-1.5">
                            <span>No</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'ringkasan')" class="px-3.5 py-3 text-left min-w-[300px] cursor-pointer hover:bg-sky-600/60 transition group">
                        <div class="flex items-center justify-between gap-1.5">
                            <span>Ringkasan Isi Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'pejabat')" class="px-3.5 py-3 text-left min-w-[210px] cursor-pointer hover:bg-sky-600/60 transition group">
                        <div class="flex items-center justify-between gap-1.5">
                            <span>Pejabat/Unit yang Menguasai Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'penanggung_jawab')" class="px-3.5 py-3 text-left min-w-[180px] cursor-pointer hover:bg-sky-600/60 transition group">
                        <div class="flex items-center justify-between gap-1.5">
                            <span>Penanggung Jawab</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'waktu')" class="px-3.5 py-3 text-left min-w-[170px] cursor-pointer hover:bg-sky-600/60 transition group">
                        <div class="flex items-center justify-between gap-1.5">
                            <span>Waktu dan Tempat Pembuatan</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'bentuk')" class="px-3 py-3 text-left min-w-[120px] cursor-pointer hover:bg-sky-600/60 transition group">
                        <div class="flex items-center justify-between gap-1.5">
                            <span>Format</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'retensi')" class="px-3 py-3 text-left min-w-[140px] cursor-pointer hover:bg-sky-600/60 transition group">
                        <div class="flex items-center justify-between gap-1.5">
                            <span>Retensi Arsip</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('{{ $tableKey }}', 'dilihat')" class="px-2 py-3 text-left w-20 min-w-[80px] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group">
                        <div class="flex items-center justify-between gap-1.5">
                            <span>Aksi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="table-dip-body-{{ $tableKey }}" data-dip-tbody="{{ $tableKey }}" data-unified="{{ $unified ? 'true' : 'false' }}" class="divide-y divide-slate-200 text-xs sm:text-sm font-medium text-slate-800 text-left">
                @php $groupCurrent = null; @endphp
                @forelse($informasi as $idx => $item)
                    @if($unified)
                        @if($groupCurrent !== ($item->kategori_informasi ?? ''))
                            @php 
                                $groupCurrent = $item->kategori_informasi ?? ''; 
                                $label = match($groupCurrent) {
                                    'Informasi Berkala' => 'Informasi Publik yang Wajib Disediakan Secara Berkala',
                                    'Informasi Setiap Saat' => 'Informasi Publik yang Wajib Tersedia Setiap Saat',
                                    'Informasi Serta-Merta' => 'Informasi Publik yang Wajib Diumumkan Secara Serta-Merta',
                                    default => \Illuminate\Support\Str::title($groupCurrent),
                                };
                            @endphp
                            <tr class="bg-sky-50/80">
                                <td colspan="8" class="px-4 py-3 font-black text-sm tracking-wide text-sky-700 border-t border-sky-100">
                                    <span class="inline-flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-500"></span>{{ $label }}</span>
                                </td>
                            </tr>
                        @endif
                    @endif
                    <tr class="table-dip-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-200"
                        data-jenis="{{ strtolower($item->kategori_informasi ?? '') }}"
                        data-dilihat="{{ (int)($item->dilihat ?? 0) }}"
                        data-ringkasan="{{ strtolower($item->sub_informasi ?? '') }}"
                        data-pejabat="{{ strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '') }}"
                        data-penanggung_jawab="{{ strtolower($item->penanggung_jawab_pembuatan_informasi ?? '') }}"
                        data-waktu="{{ strtolower($item->waktu_pembuatan_informasi ?? '') }}"
                        data-bentuk="{{ strtolower($item->bentuk_informasi_yang_tersedia ?? '') }}"
                        data-retensi="{{ strtolower($item->retensi_arsip ?? '') }}">
                        <td class="col-dip-no px-3 py-3.5 text-center font-bold text-slate-400 align-top">{{ $idx + 1 }}</td>
                        <td class="px-4 py-3.5 text-slate-900 leading-normal text-sm md:text-base align-top">{{ $item->sub_informasi ?: '-' }}</td>
                        <td class="px-4 py-3.5 text-slate-700 text-left text-sm md:text-base align-top">{{ $item->pejabat_unit_yang_menguasai_informasi ?: '-' }}</td>
                        <td class="px-4 py-3.5 text-slate-700 text-left text-sm md:text-base align-top">{{ $item->penanggung_jawab_pembuatan_informasi ?: '-' }}</td>
                        <td class="px-4 py-3.5 text-left text-slate-700 text-sm md:text-base align-top">{{ $item->waktu_pembuatan_informasi ?: '-' }}</td>
                        <td class="px-3.5 py-3.5 text-center text-slate-700 text-sm md:text-base align-top">{{ $item->bentuk_informasi_yang_tersedia ?: '-' }}</td>
                        <td class="px-3.5 py-3.5 text-center text-slate-700 text-sm md:text-base align-top">{{ $item->retensi_arsip ?: '-' }}</td>
                        <td class="px-3 py-3.5 text-center align-top">
                            @php
                                $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                $url = ($item->link_informasi && !$item->file_informasi) ? $item->link_informasi : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($item->nama_file_asli ?: 'file.pdf')) : null);
                            @endphp
                            @if($url)
                                <a href="{{ $url }}" target="_blank" class="inline-flex items-center justify-center px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-lg transition">Lihat</a>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="p-12 text-center text-slate-400">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div id="table-dip-info-{{ $tableKey }}" data-dip-info="{{ $tableKey }}" class="text-xs sm:text-sm font-medium text-slate-600">Menampilkan 0–0 dari 0 informasi</div>
        <div id="table-dip-pagination-{{ $tableKey }}" data-dip-pagination="{{ $tableKey }}" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none"></div>
    </div>
</div>
