@props(['informasi', 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => []])

<!-- Table Container -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <form id="form-bulk-delete" action="{{ route('admin.informasi.bulk') }}" method="POST">
        @csrf
        @method('DELETE')

        @php
            $isKategoriMode = request()->filled('kategori');
            $curSortBy = request('sort_by');
            $curSortDir = request('sort_direction', 'asc');
        @endphp

        @php
            $isSertaMertaMode = (request('kategori') === 'Informasi Serta-Merta');
        @endphp

        @if($isSertaMertaMode)
            <!-- Tampilan Card List Serta-Merta (Sesuai Desain Publik / Masyarakat) dengan Kontrol Admin -->
            <div class="p-5 sm:p-7 space-y-4">
                <!-- Checkbox Pilih Semua Khusus Mode Serta-Merta -->
                <div id="col-checkbox-header" class="hidden flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 select-none">
                    <input type="checkbox" id="check-all" onclick="toggleCheckAll(this)" class="w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-0 cursor-pointer">
                    <label for="check-all" class="cursor-pointer">Pilih Semua Pengumuman</label>
                </div>

                <!-- Container Card List Serta-Merta -->
                <div id="container-admin-serta-merta" class="space-y-3">
                    @forelse($informasi as $idx => $item)
                        @php
                            $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                            $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                            $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                ? $item->link_informasi 
                                : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName).'?from_admin=1') : null);
                            $tglPembuatan = $item->waktu_pembuatan_informasi ?: ($item->created_at ? $item->created_at->translatedFormat('d F Y') : '-');
                        @endphp
                        <div class="card-admin-serta-merta group/card flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 sm:p-5 rounded-2xl border border-slate-200/80 bg-white hover:bg-sky-50/40 hover:border-sky-200 transition-all duration-200 shadow-2xs hover:shadow-xs"
                             data-id="{{ $item->id }}"
                             data-no="{{ $idx + 1 }}"
                             data-dilihat="{{ (int)($item->dilihat ?? 0) }}"
                             data-rincian="{{ strtolower($item->rincian_informasi ?? '') }}"
                             data-sub_informasi="{{ strtolower($item->sub_informasi ?? '') }}"
                             data-ringkasan="{{ strtolower($item->sub_informasi ?? '') }}"
                             data-pejabat="{{ strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '') }}"
                             data-penanggung_jawab="{{ strtolower($item->penanggung_jawab_pembuatan_informasi ?? '') }}"
                             data-waktu="{{ strtolower($tglPembuatan) }}"
                             data-retensi="{{ strtolower($item->retensi_arsip ?? '') }}"
                             data-bentuk="{{ strtolower($item->bentuk_informasi_yang_tersedia ?? '') }}">
                            
                            <div class="flex items-start gap-3.5 flex-1 min-w-0">
                                <!-- Checkbox Mode Hapus -->
                                <div class="col-checkbox-cell hidden pt-1 shrink-0">
                                    <input type="checkbox" name="ids[]" form="form-bulk-delete" value="{{ $item->id }}" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                                </div>

                                <!-- Megaphone Icon -->
                                <div class="w-10 h-10 rounded-xl bg-sky-100/70 text-sky-600 flex items-center justify-center shrink-0 group-hover/card:bg-sky-500 group-hover/card:text-white transition-colors duration-200 mt-0.5">
                                    <i class="fa-solid fa-bullhorn text-sm"></i>
                                </div>

                                <!-- Text Content -->
                                <div class="space-y-1 flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover/card:text-sky-600 transition-colors leading-snug break-words">
                                        {{ $item->sub_informasi }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400 font-semibold">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar text-[11px]"></i>
                                            <span>{{ $tglPembuatan }}</span>
                                        </span>
                                        @if($item->pejabat_unit_yang_menguasai_informasi)
                                            <span class="text-slate-300">•</span>
                                            <span class="flex items-center gap-1.5 text-slate-500">
                                                <i class="fa-solid fa-building-columns text-[11px]"></i>
                                                <span>{{ $item->pejabat_unit_yang_menguasai_informasi }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi Admin & Berkas -->
                            <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                @if($fileTargetUrl)
                                    <a href="{{ $fileTargetUrl }}" target="_blank" 
                                       class="inline-flex items-center justify-center gap-2 px-3.5 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-xl transition shadow-2xs hover:shadow-xs cursor-pointer">
                                        <span>Lihat Berkas</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    </a>
                                @else
                                    <span class="text-xs font-semibold text-slate-400 italic px-3 py-1.5 bg-slate-100 rounded-xl">Dokumen Belum Ada</span>
                                @endif

                                <button type="button" onclick="editData({{ json_encode($item) }})" title="Edit Pengumuman" 
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-amber-700 bg-amber-50 hover:bg-amber-600 hover:text-white text-xs font-bold rounded-xl transition shadow-2xs cursor-pointer">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    <span>Edit</span>
                                </button>

                                <button type="button" onclick="triggerDelete('{{ url('/admin/informasi-publik/'.$item->id) }}', '{{ addslashes($item->sub_informasi) }}')" title="Hapus Pengumuman" 
                                        class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-rose-700 bg-rose-50 hover:bg-rose-600 hover:text-white text-xs font-bold rounded-xl transition shadow-2xs cursor-pointer">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400 font-semibold bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                            Belum ada Informasi Serta-Merta yang ditambahkan.
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            <!-- Tabel Daftar Informasi Publik Clean Modern (Fit Screen, Never Horizontal Scroll) -->
            <div>
                <table class="w-full table-fixed text-left border-collapse border border-slate-200">
                    <thead>
                        @if($isKategoriMode)
                            {{-- Header Khusus Kategori Berkala & Setiap Saat: Hanya Rincian Informasi & Sub Informasi --}}
                            <tr class="bg-sky-500 text-white text-xs md:text-sm font-extrabold tracking-wide divide-x divide-white/20 select-none">
                                <th id="col-checkbox-header" class="hidden px-2 py-3.5 w-12 text-center">
                                    <input type="checkbox" id="check-all" onclick="toggleCheckAll(this)" class="w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer">
                                </th>
                                <th onclick="sortAdminDipTable('rincian')" class="px-4 py-3.5 text-left w-1/2 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Rincian Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Rincian Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('sub_informasi')" class="px-4 py-3.5 text-left w-1/2 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Sub Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Sub Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        @else
                            {{-- Header Standar Daftar Informasi Publik (DIP) Matriks Lengkap Sesuai Form --}}
                            <tr class="bg-sky-500 text-white text-[11px] sm:text-xs md:text-sm font-black tracking-tight divide-x divide-white/20 text-center leading-snug select-none">
                                <th id="col-checkbox-header" class="hidden px-1 py-3 w-10 text-center">
                                    <input type="checkbox" id="check-all" onclick="toggleCheckAll(this)" class="w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer">
                                </th>
                                <th onclick="sortAdminDipTable('no')" class="px-1 py-3 text-center w-12 shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>No</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('ringkasan')" class="px-2 py-3 text-center w-[20%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Ringkasan Isi Informasi">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Ringkasan Isi Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('jenis')" class="px-1.5 py-3 w-[11%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Jenis Informasi">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Jenis Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('pejabat')" class="px-2 py-3 w-[14%] break-normal cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Pejabat/Unit/Satker">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Pejabat/Unit/Satker yang Menguasai Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('penanggung_jawab')" class="px-1.5 py-3 w-[14%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Penanggung Jawab">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Penanggung Jawab Pembuatan atau Penerbitan Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('waktu')" class="px-1.5 py-3 w-[12%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Waktu dan Tempat">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Waktu dan Tempat Pembuatan Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('retensi')" class="px-1.5 py-3 w-[11%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Retensi Arsip">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Jangka Waktu Penyimpanan atau Retensi Arsip</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('bentuk')" class="px-1.5 py-3 w-[10.5%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Bentuk Informasi">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Bentuk Informasi yang Tersedia</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('dilihat')" class="px-1 py-3 w-[8%] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Sering Dilihat">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Aksi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        @endif
                    </thead>
                    <tbody id="table-admin-dip-body" class="divide-y divide-slate-200 text-xs sm:text-sm font-medium text-slate-800">
                        @forelse($informasi as $idx => $item)
                            @php
                                $rincianText = trim($item->rincian_informasi ?: '-');
                                $subInformasiText = trim($item->sub_informasi ?: '');
                                $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                    ? $item->link_informasi 
                                    : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName).'?from_admin=1') : null);
                            @endphp
                            <tr class="table-admin-dip-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-200"
                                data-id="{{ $item->id }}"
                                data-no="{{ $idx + 1 }}"
                                data-dilihat="{{ (int)($item->dilihat ?? 0) }}"
                                data-rincian="{{ strtolower($rincianText) }}"
                                data-sub_informasi="{{ strtolower($subInformasiText) }}"
                                data-ringkasan="{{ strtolower($item->sub_informasi ?? '') }}"
                                data-jenis="{{ strtolower($item->jenis_informasi ?? '') }}"
                                data-pejabat="{{ strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '') }}"
                                data-penanggung_jawab="{{ strtolower($item->penanggung_jawab_pembuatan_informasi ?? '') }}"
                                data-waktu="{{ strtolower($item->waktu_pembuatan_informasi ?? '') }}"
                                data-retensi="{{ strtolower($item->retensi_arsip ?? '') }}"
                                data-bentuk="{{ strtolower($item->bentuk_informasi_yang_tersedia ?? '') }}">
                                <td class="col-checkbox-cell hidden px-2 py-3 text-center">
                                    <input type="checkbox" name="ids[]" form="form-bulk-delete" value="{{ $item->id }}" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                                </td>

                                @if(!$isKategoriMode)
                                    <!-- 0. Kolom No (Hanya untuk Full DIP) -->
                                    <td class="col-admin-dip-no px-2 py-3 text-center font-bold text-slate-400">
                                        {{ $idx + 1 }}
                                    </td>
                                @endif

                                @if($isKategoriMode)
                                    <!-- 1. Rincian Informasi (Topik Induk) - Dynamic Rowspan Handled by Client Engine -->
                                    <td class="col-admin-rincian px-4 py-3 font-extrabold text-slate-900 leading-relaxed align-top bg-white border-r border-slate-200 break-words">
                                        <div class="sticky top-2">
                                            <div class="text-slate-900 font-extrabold text-xs sm:text-sm mb-2">
                                                {{ $rincianText }}
                                            </div>
                                            <!-- Aksi Khusus Rincian Informasi (Wadah Topik) -->
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <button type="button" onclick="addSubInfo({{ json_encode($item) }});" 
                                                        title="Tambah Sub Informasi baru di bawah rincian ini"
                                                        class="inline-flex items-center gap-1 px-2 py-1 bg-sky-50 hover:bg-sky-500 text-sky-600 hover:text-white rounded-lg text-[11px] font-bold transition shadow-2xs cursor-pointer border border-sky-200 hover:border-transparent">
                                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                                    <span>Sub Informasi</span>
                                                </button>
                                                <button type="button" 
                                                        onclick="triggerDeleteRincian('{{ addslashes($rincianText) }}', '{{ addslashes($item->jenis_informasi) }}')" 
                                                        title="Hapus Rincian Informasi ini beserta seluruh isinya"
                                                        class="inline-flex items-center gap-1 px-2 py-1 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white rounded-lg text-[11px] font-bold transition shadow-2xs cursor-pointer border border-rose-200 hover:border-transparent">
                                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                                    <span>Hapus Rincian</span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- 2. Sub Informasi (Nama Dokumen) + Aksi Langsung di Dalamnya -->
                                    <td class="px-4 py-3 font-medium text-slate-800 leading-relaxed align-top break-words">
                                        @php
                                            $subText = trim($item->sub_informasi ?: '');
                                            $isPending = empty($subText) || $subText === 'Dokumen sedang dilengkapi unit';
                                        @endphp
                                        <div class="space-y-1.5">
                                            @if(!$isPending)
                                                <div class="flex items-start justify-between gap-3">
                                                    <div class="space-y-1">
                                                        <div class="font-extrabold text-slate-900" title="{{ $subText }}">
                                                            {{ $subText }}
                                                        </div>

                                                    </div>

                                                    <!-- Tombol Aksi Dokumen Langsung Menempel di Sub Informasi -->
                                                    <div class="flex items-center gap-1.5 shrink-0 self-center">
                                                        @if($fileTargetUrl && $fileTargetUrl !== '#')
                                                            <a href="{{ $fileTargetUrl }}" target="_blank" title="Lihat Tautan / Berkas" 
                                                               class="w-7 h-7 flex items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white transition shadow-2xs rounded-lg cursor-pointer">
                                                                <i class="fa-regular fa-eye text-[11px]"></i>
                                                            </a>
                                                        @endif
                                                        <button type="button" onclick="editData({{ json_encode($item) }})" title="Edit Dokumen Ini" 
                                                                class="w-7 h-7 flex items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                                        </button>
                                                        <button type="button" onclick="triggerDelete('{{ url('/admin/informasi-publik/'.$item->id) }}', '{{ addslashes($subText) }}')" title="Hapus Dokumen Ini" 
                                                                class="w-7 h-7 flex items-center justify-center text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                                            <i class="fa-solid fa-trash text-[11px]"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-2 py-0.5">
                                                    <i class="fa-regular fa-clock text-[11px] text-amber-500"></i>
                                                    <span class="text-xs text-amber-600 italic font-medium">Dokumen sedang dilengkapi unit</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                @else
                                     <!-- 1. Ringkasan Isi Informasi (Rincian Informasi & Sub Informasi) -->
                                     <td class="px-3.5 py-3 text-slate-900 leading-normal break-words text-xs sm:text-sm">
                                         @php
                                             $rincianVal = trim($item->rincian_informasi ?: '');
                                             $subVal = trim($item->sub_informasi ?: '');
                                         @endphp
                                         <div class="space-y-1">
                                             @if($subVal && $subVal !== 'Dokumen sedang dilengkapi unit')
                                                 <div class="font-black text-slate-900 leading-snug">{{ $subVal }}</div>
                                                 @if($rincianVal && strcasecmp($rincianVal, $subVal) !== 0)
                                                     <div class="text-[11px] text-slate-500 font-semibold flex items-center gap-1">
                                                         <span class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-600 border border-slate-200/80">{{ $rincianVal }}</span>
                                                     </div>
                                                 @endif
                                             @else
                                                 <div class="font-black text-slate-900 leading-snug">{{ $rincianVal ?: '-' }}</div>
                                                 <div class="text-[11px] text-amber-600 font-semibold italic flex items-center gap-1">
                                                     <i class="fa-regular fa-clock text-[10px]"></i>
                                                     <span>Dokumen sedang dilengkapi unit</span>
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
                                         {{ $item->waktu_pembuatan_informasi ?: '-' }}
                                     </td>

                                     <!-- 6. Jangka Waktu Penyimpanan atau Retensi Arsip -->
                                     <td class="px-3 py-3 text-center font-medium text-slate-700 break-words text-xs sm:text-sm leading-normal">
                                         {{ $item->retensi_arsip ?: '-' }}
                                     </td>

                                     <!-- 7. Bentuk Informasi yang Tersedia -->
                                     <td class="px-3 py-3 text-center font-semibold text-slate-700 break-words text-xs sm:text-sm leading-normal">
                                         {{ $item->bentuk_informasi_yang_tersedia ?: '-' }}
                                     </td>

                                     <!-- Aksi (Tautan Berkas & Aksi Admin) Hanya untuk Full DIP -->
                                     <td class="px-2 py-2.5 text-center align-middle">
                                         <div class="flex items-center justify-center gap-1.5">
                                             @if($fileTargetUrl && $fileTargetUrl !== '#')
                                                 <a href="{{ $fileTargetUrl }}" target="_blank" title="Lihat Tautan / Berkas" 
                                                    class="w-7 h-7 flex items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white transition shadow-2xs rounded-lg">
                                                     <i class="fa-regular fa-eye text-[11px]"></i>
                                                 </a>
                                             @endif
                                             <button type="button" onclick="editData({{ json_encode($item) }})" title="Edit Data" class="w-7 h-7 flex items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                                 <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                             </button>
                                             <button type="button" onclick="triggerDelete('{{ url('/admin/informasi-publik/'.$item->id) }}', '{{ addslashes($item->sub_informasi) }}')" title="Hapus Data" class="w-7 h-7 flex items-center justify-center text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                                 <i class="fa-solid fa-trash text-[11px]"></i>
                                             </button>
                                         </div>
                                     </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="{{ $isKategoriMode ? '2' : '10' }}" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data Informasi Publik.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Footer Kontrol Paginasi Client-side Instan -->
        <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div id="table-admin-dip-info" class="text-xs md:text-sm text-slate-800">
                Menampilkan 0 sampai 0 dari 0 entri
            </div>
            <div id="table-admin-dip-pagination" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
                <!-- Render dinamis via JavaScript -->
            </div>
        </div>
    </form>
</div>
