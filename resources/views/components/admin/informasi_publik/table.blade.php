@props(['informasi', 'listKategori' => [], 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => [], 'tableKey' => 'main', 'forceTable' => false, 'unified' => false])

<!-- Table Container -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        @php
            $isUnified = (bool) $unified;
            $isKategoriMode = !$isUnified && request()->filled('kategori') && !$forceTable;
            $curSortBy = request('sort_by');
            $curSortDir = request('sort_direction', 'asc');
        @endphp

        <!-- Tabel Daftar Informasi Publik — horizontal scroll on mobile -->
        <div class="overflow-x-auto -webkit-overflow-scrolling-touch">
            <table class="w-full {{ $isKategoriMode ? 'min-w-0 table-fixed' : 'min-w-[750px] table-auto' }} text-left border-collapse border border-slate-200">
                <thead>
                    @if($isUnified)
                    <tr class="bg-primary text-white text-xs md:text-sm font-black tracking-tight text-center leading-snug select-none">
                        <th id="col-checkbox-header-{{ $tableKey }}" class="col-checkbox-header hidden px-1 py-3 w-10 text-center">
                            <input type="checkbox" class="check-all w-4 h-4 rounded border-white/30 text-primary focus:ring-0 cursor-pointer" onclick="toggleCheckAll(this)">
                        </th>
                        <th onclick="sortAdminDipTable('{{ $tableKey }}', 'no')" class="px-2 py-3 text-center w-12 min-w-[48px] shrink-0 cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Nomor">
                            <div class="flex items-center justify-center gap-1.5">
                                <span>No</span>
                                <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                    <i class="mdi mdi-swap-vertical"></i>
                                </span>
                            </div>
                        </th>
                        <th onclick="sortAdminDipTable('{{ $tableKey }}', 'ringkasan')" class="px-3.5 py-3 text-left min-w-[300px] cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Ringkasan Isi Informasi">
                            <div class="flex items-center justify-between gap-1.5">
                                <span>Ringkasan Isi Informasi</span>
                                <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                    <i class="mdi mdi-swap-vertical"></i>
                                </span>
                            </div>
                        </th>
                        <th onclick="sortAdminDipTable('{{ $tableKey }}', 'bentuk')" class="px-3 py-3 text-left min-w-[120px] cursor-pointer hover:bg-primary/60 transition group"><div class="flex items-center justify-between gap-1.5"><span>Format</span><span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="mdi mdi-swap-vertical"></i></span></div></th>
                        <th onclick="sortAdminDipTable('{{ $tableKey }}', 'retensi')" class="px-3 py-3 text-left min-w-[140px] cursor-pointer hover:bg-primary/60 transition group"><div class="flex items-center justify-between gap-1.5"><span>Retensi Arsip</span><span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="mdi mdi-swap-vertical"></i></span></div></th>
                        <th class="px-2 py-3 text-center w-24 min-w-[90px] shrink-0"><span>Aksi</span></th>
                    </tr>
                    @elseif($isKategoriMode)
                        {{-- Header Kategori (Berkala, Setiap Saat, Serta-Merta): Rincian Informasi & Sub Informasi --}}
                        <tr class="bg-primary text-white text-xs md:text-sm font-black tracking-tight select-none">
                                <th id="col-checkbox-header-{{ $tableKey }}" class="col-checkbox-header hidden px-2 py-3.5 w-12 text-center">
                                    <input type="checkbox" class="check-all w-4 h-4 rounded border-white/30 text-primary focus:ring-0 cursor-pointer" onclick="toggleCheckAll(this)">
                                </th>
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'rincian')" class="px-4 py-3.5 text-left w-[35%] cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Rincian Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Rincian Informasi</span>
                                        <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="mdi mdi-swap-vertical"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'sub_informasi')" class="px-4 py-3.5 text-left w-[53%] cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Sub Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Sub Informasi</span>
                                        <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="mdi mdi-swap-vertical"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'dilihat')" class="px-2 py-3.5 text-center w-[12%] min-w-[116px] cursor-pointer hover:bg-primary/60 transition" title="Urutkan berdasarkan akses"><div class="flex items-center justify-center gap-1"><span>Aksi</span><span class="sort-icon-wrapper inline-flex items-center text-white/70"><i class="mdi mdi-swap-vertical"></i></span></div></th>
                            </tr>
                        @else
                            {{-- Header Standar Daftar Informasi Publik (DIP) Matriks Lengkap Sesuai Permintaan --}}
                            <tr class="bg-primary text-white text-xs md:text-sm font-black tracking-tight text-center leading-snug select-none">
                                <th id="col-checkbox-header-{{ $tableKey }}" class="col-checkbox-header hidden px-1 py-3 w-10 text-center">
                                    <input type="checkbox" class="check-all w-4 h-4 rounded border-white/30 text-primary focus:ring-0 cursor-pointer" onclick="toggleCheckAll(this)">
                                </th>
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'no')" class="px-2 py-3 text-center w-12 min-w-[48px] shrink-0 cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Nomor">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>No</span>
                                        <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="mdi mdi-swap-vertical"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'ringkasan')" class="px-3.5 py-3 text-left min-w-[300px] cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Ringkasan Isi Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Ringkasan Isi Informasi</span>
                                        <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="mdi mdi-swap-vertical"></i>
                                        </span>
                                    </div>
                                </th>
                                @unless($forceTable)
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'jenis')" class="px-3.5 py-3 text-center min-w-[140px] cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Kategori Informasi">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Kategori Informasi</span>
                                        <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="mdi mdi-swap-vertical"></i>
                                        </span>
                                    </div>
                                </th>
                                @endunless
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'bentuk')" class="px-3 py-3 text-center min-w-[120px] cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Format">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Format</span>
                                        <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="mdi mdi-swap-vertical"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'retensi')" class="px-3 py-3 text-center min-w-[140px] cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan Retensi Arsip">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Retensi Arsip</span>
                                        <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="mdi mdi-swap-vertical"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('{{ $tableKey }}', 'dilihat')" class="px-2 py-3 text-center w-24 min-w-[90px] shrink-0 cursor-pointer hover:bg-primary/60 transition group" title="Klik untuk mengurutkan berdasarkan Akses / Sering Dilihat">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Aksi</span>
                                        <span class="sort-icon-wrapper inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="mdi mdi-swap-vertical"></i>
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        @endif
                    </thead>
            <tbody id="table-admin-dip-body-{{ $tableKey }}" data-admin-dip-tbody="{{ $tableKey }}" data-unified="{{ $isUnified ? 'true' : 'false' }}" data-category-mode="{{ $isKategoriMode ? 'true' : 'false' }}" data-category-table="{{ $isKategoriMode ? 'true' : 'false' }}" class="{{ $isUnified ? 'divide-y divide-slate-200' : ($isKategoriMode ? '' : 'divide-y divide-slate-200') }} text-xs sm:text-sm font-medium text-slate-800 text-left align-top">
                        @php $unifiedGroupCurrent = null; $unifiedColspan = 6; @endphp
                        @forelse($informasi as $idx => $item)
                            @if($isUnified && !request()->filled('kategori'))
                                @if($unifiedGroupCurrent !== ($item->kategori_informasi ?? ''))
                                    @php
                                        $unifiedGroupCurrent = $item->kategori_informasi ?? '';
                                        $unifiedGroupLabel = match($unifiedGroupCurrent) {
                                            'Informasi Berkala' => 'Informasi Publik yang Wajib Disediakan Secara Berkala',
                                            'Informasi Setiap Saat' => 'Informasi Publik yang Wajib Tersedia Setiap Saat',
                                            'Informasi Serta-Merta' => 'Informasi Publik yang Wajib Diumumkan Secara Serta-Merta',
                                            default => \Illuminate\Support\Str::title($unifiedGroupCurrent),
                                        };
                                    @endphp
                                    <tr class="table-admin-dip-group bg-secondary-light/80">
                                        <td colspan="{{ $unifiedColspan }}" class="px-4 py-3 font-black text-xs md:text-sm tracking-wide text-primary border-t border-secondary/20">
                                            <span class="inline-flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-primary"></span>
                                                {{ $unifiedGroupLabel }}
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                            @php
                                $rincianText = trim($item->rincian_informasi ?: '-');
                                $subInformasiText = trim($item->sub_informasi ?: '');
                                $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                    ? $item->link_informasi 
                                    : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName).'?from_admin=1') : null);
                            @endphp
                            <tr class="table-admin-dip-row hover:bg-secondary-light/70 transition-colors"
                                data-id="{{ $item->id }}"
                                data-no="{{ $idx + 1 }}"
                                data-dilihat="{{ (int)($item->dilihat ?? 0) }}"
                                data-rincian="{{ strtolower($rincianText) }}"
                                data-sub_informasi="{{ strtolower($subInformasiText) }}"
                                data-tanggal="{{ $item->created_at?->timestamp ?? '' }}"
                                data-ringkasan="{{ strtolower($item->sub_informasi ?? '') }}"
                                data-jenis="{{ strtolower($item->kategori_informasi ?? '') }}"
                                data-pejabat="{{ strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '') }}"
                                data-penanggung_jawab="{{ strtolower($item->penanggung_jawab_pembuatan_informasi ?? '') }}"
                                data-waktu="{{ strtolower($item->waktu_pembuatan_informasi ?? '') }}"
                                data-retensi="{{ strtolower($item->retensi_arsip ?? '') }}"
                                data-bentuk="{{ strtolower($item->bentuk_informasi_yang_tersedia ?? '') }}">
                                <td class="col-checkbox-cell hidden px-2 py-3 text-center align-top">
                                    <input type="checkbox" value="{{ $item->id }}" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                                </td>

                                @if($isUnified)
                                    <td class="col-admin-dip-no px-2 py-3 text-center font-bold text-slate-400 align-top">{{ $idx + 1 }}</td>
                                    <td class="px-4 py-3.5 text-slate-900 leading-normal break-words text-sm md:text-base align-top">
                                        @php $subValU = trim($item->sub_informasi ?: ''); @endphp
                                        <div class="space-y-1">
                                            @if($subValU && $subValU !== 'Dokumen sedang dilengkapi unit')
                                                <div class="font-medium text-slate-900 leading-snug">{{ $subValU }}</div>
                                            @else
                                                <div class="font-medium text-slate-900 leading-snug">-</div>
                                                <div class="text-xs text-amber-600 font-semibold italic flex items-center gap-1"><i class="mdi mdi-clock-outline text-[10px]"></i><span>Dokumen sedang dilengkapi unit</span></div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-3.5 py-3.5 text-left font-semibold text-slate-700 break-words text-sm md:text-base leading-normal align-top">{{ $item->bentuk_informasi_yang_tersedia ?: '-' }}</td>
                                    <td class="px-3.5 py-3.5 text-left font-medium text-slate-700 break-words text-sm md:text-base leading-normal align-top">{{ $item->retensi_arsip ?: '-' }}</td>
                                    <td class="px-3 py-3.5 text-center align-top">
                                        <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                            @if($fileTargetUrl && $fileTargetUrl !== '#')
                                                <a href="{{ $fileTargetUrl }}" target="_blank" title="Lihat Tautan / Berkas" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-primary bg-secondary-light hover:bg-primary hover:text-white transition shadow-2xs rounded-lg"><i class="mdi mdi-eye-outline text-[11px] not-italic leading-none"></i></a>
                                            @endif
                                            <button type="button" onclick="editData({{ json_encode($item) }})" title="Edit Data" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg"><i class="mdi mdi-square-edit-outline text-[11px] not-italic leading-none"></i></button>
                                            <button type="button" onclick="triggerDelete('{{ url('/admin/informasi-publik/'.$item->id) }}', '{{ addslashes($item->sub_informasi) }}')" title="Hapus Data" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg"><i class="mdi mdi-trash-can-outline text-[11px] not-italic leading-none"></i></button>
                                        </div>
                                    </td>

                                @elseif($isKategoriMode)
                                    <!-- 1. Rincian Informasi (Topik Induk) - Dynamic Rowspan Handled by Client Engine -->
                                    <td class="col-admin-rincian px-4 py-3 font-medium text-slate-800 leading-relaxed align-top bg-white break-words">{{ $rincianText }}</td>

                                    <!-- 2. Sub Informasi (Nama Dokumen) + Aksi Langsung di Dalamnya -->
                                    <td class="col-admin-sub-info px-4 py-3 font-medium text-slate-800 leading-relaxed align-top break-words">
                                        @php
                                            $subText = trim($item->sub_informasi ?: '');
                                            $isPending = empty($subText) || $subText === 'Dokumen sedang dilengkapi unit';
                                        @endphp
                                        <div class="space-y-1.5">
                                            @if(!$isPending)
                                                <div class="font-medium text-slate-800" title="{{ $subText }}">{{ $subText }}</div>
                                            @else
                                                <div class="flex items-center gap-2 py-0.5">
                                                    <i class="mdi mdi-clock-outline text-[11px] text-amber-500"></i>
                                                    <span class="text-xs text-amber-600 italic font-medium">Dokumen sedang dilengkapi unit</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-2 py-3 text-center align-top">
                                        <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                            @if($fileTargetUrl && $fileTargetUrl !== '#')
                                                <a href="{{ $fileTargetUrl }}" target="_blank" title="Lihat Tautan / Berkas" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-primary bg-secondary-light hover:bg-primary hover:text-white rounded-lg transition"><i class="mdi mdi-eye-outline text-[11px] not-italic leading-none"></i></a>
                                            @endif
                                            <button type="button" onclick="editData({{ json_encode($item) }})" title="Edit" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white rounded-lg transition cursor-pointer"><i class="mdi mdi-square-edit-outline text-[11px] not-italic leading-none"></i></button>
                                            <button type="button" onclick="triggerDelete('{{ url('/admin/informasi-publik/'.$item->id) }}', '{{ addslashes($subText ?: $rincianText) }}')" title="Hapus" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-lg transition cursor-pointer"><i class="mdi mdi-trash-can-outline text-[11px] not-italic leading-none"></i></button>
                                        </div>
                                    </td>
                                @else
                                     <!-- 1. Ringkasan Isi Informasi -->
                                     <td class="px-4 py-3.5 text-slate-900 leading-normal break-words text-sm md:text-base align-top">
                                         @php
                                             $subVal = trim($item->sub_informasi ?: '');
                                         @endphp
                                         <div class="space-y-1">
                                             @if($subVal && $subVal !== 'Dokumen sedang dilengkapi unit')
                                                 <div class="font-medium text-slate-900 leading-snug">{{ $subVal }}</div>
                                             @else
                                                 <div class="font-medium text-slate-900 leading-snug">-</div>
                                                 <div class="text-xs text-amber-600 font-semibold italic flex items-center gap-1">
                                                     <i class="mdi mdi-clock-outline text-[10px]"></i>
                                                     <span>Dokumen sedang dilengkapi unit</span>
                                                 </div>
                                             @endif
                                         </div>
                                     </td>

                                     @unless($forceTable)
                                     <!-- 2. Kategori Informasi -->
                                     <td class="px-3.5 py-3.5 text-center align-top whitespace-nowrap">
                                         @php
                                             $jVal = trim($item->kategori_informasi ?: '');
                                             $jBadgeClass = match($jVal) {
                                                 'Informasi Berkala' => 'bg-[#1B365D] text-white',
                                                 'Informasi Serta Merta', 'Informasi Serta-Merta' => 'bg-rose-500 text-white',
                                                 'Informasi Setiap Saat' => 'bg-emerald-600 text-white',
                                                 'Informasi Dikecualikan' => 'bg-slate-700 text-white',
                                                 default => 'bg-primary text-white'
                                             };
                                         @endphp
                                         @if($jVal)
                                             <span class="inline-flex items-center justify-center px-2.5 py-1 text-[11px] font-bold rounded-lg {{ $jBadgeClass }} shadow-2xs">
                                                 {{ $jVal }}
                                             </span>
                                         @else
                                             <span class="text-slate-400 font-bold text-xs">-</span>
                                         @endif
                                     </td>

                                     @endunless

                                     <!-- 6. Format -->
                                     <td class="px-3.5 py-3.5 text-left font-semibold text-slate-700 break-words text-sm md:text-base leading-normal align-top">
                                         {{ $item->bentuk_informasi_yang_tersedia ?: '-' }}
                                     </td>

                                     <!-- 7. Retensi Arsip -->
                                     <td class="px-3.5 py-3.5 text-left font-medium text-slate-700 break-words text-sm md:text-base leading-normal align-top">
                                         {{ $item->retensi_arsip ?: '-' }}
                                     </td>

                                     <!-- 8. Akses / Aksi (Kolom Paling Kanan) -->
                                     <td class="px-3 py-3.5 text-center align-top">
                                         <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                             @if($fileTargetUrl && $fileTargetUrl !== '#')
                                                 <a href="{{ $fileTargetUrl }}" target="_blank" title="Lihat Tautan / Berkas" 
                                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-primary bg-secondary-light hover:bg-primary hover:text-white transition shadow-2xs rounded-lg">
                                                     <i class="mdi mdi-eye-outline text-[11px] not-italic leading-none"></i>
                                                 </a>
                                             @endif
                                             <button type="button" onclick="editData({{ json_encode($item) }})" title="Edit Data" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                                 <i class="mdi mdi-square-edit-outline text-[11px] not-italic leading-none"></i>
                                             </button>
                                             <button type="button" onclick="triggerDelete('{{ url('/admin/informasi-publik/'.$item->id) }}', '{{ addslashes($item->sub_informasi) }}')" title="Hapus Data" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                                 <i class="mdi mdi-trash-can-outline text-[11px] not-italic leading-none"></i>
                                             </button>
                                         </div>
                                     </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="{{ $isKategoriMode ? '4' : ($forceTable ? '6' : '7') }}" class="p-12 text-center text-slate-400 font-semibold">{{ $isKategoriMode ? 'Tidak ada data informasi untuk kategori ini.' : 'Tidak ada data Informasi Publik.' }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        <!-- Footer Kontrol Paginasi Client-side Instan -->
        <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div id="table-admin-dip-info-{{ $tableKey }}" data-admin-dip-info="{{ $tableKey }}" class="text-xs sm:text-sm font-medium text-slate-600">
                Menampilkan 0–0 dari 0 informasi
            </div>
            <div id="table-admin-dip-pagination-{{ $tableKey }}" data-admin-dip-pagination="{{ $tableKey }}" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
                <!-- Render dinamis via JavaScript -->
            </div>
        </div>
</div>
