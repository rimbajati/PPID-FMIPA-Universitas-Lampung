<?php
    $displayTitle = match($slug) {
        'berkala'     => 'Informasi yang Wajib Disediakan dan Diumumkan Secara Berkala',
        'serta-merta' => 'Informasi yang Wajib Diumumkan secara Serta-merta',
        'setiap-saat' => 'Informasi yang Wajib Tersedia Setiap Saat',
        default       => $namaKategori,
    };
?>

<?php $__env->startSection('title', $displayTitle . ' - PPID FMIPA Universitas Lampung'); ?>

<?php $__env->startSection('content'); ?>
<main class="pt-16 md:pt-[4.5rem] bg-slate-100/70 min-h-screen pb-20">

    <!-- Header Hero Banner Kategori (Matching DIP Layout) -->
    <section class="bg-slate-100/80 text-slate-800 py-8 md:py-10 border-b border-slate-200/80">
        <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 space-y-2">
            <h1 class="text-3xl sm:text-4xl md:text-[2.6rem] font-black text-slate-900 tracking-tight leading-tight">
                <?php echo e($displayTitle); ?>

            </h1>
            <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed max-w-5xl">
                <?php if($slug === 'berkala'): ?>
                    Informasi publik yang wajib disediakan dan diumumkan secara berkala sekurang-kurangnya 6 (enam) bulan sekali, meliputi informasi tentang profil Badan Publik, kegiatan dan kinerja, laporan keuangan, serta informasi lain yang diatur dalam peraturan perundang-undangan (Pasal 9 UU No. 14 Tahun 2008).
                <?php elseif($slug === 'serta-merta'): ?>
                    Informasi publik yang wajib diumumkan secara serta-merta tanpa penundaan mengenai suatu informasi yang dapat mengancam hajat hidup orang banyak dan ketertiban umum (Pasal 10 UU No. 14 Tahun 2008).
                <?php elseif($slug === 'setiap-saat'): ?>
                    Informasi publik yang wajib disediakan oleh Badan Publik setiap saat untuk dapat diakses oleh pengguna informasi publik, meliputi daftar regulasi, keputusan dan pertimbangannya, rencana kerja dan anggaran tahunan, perjanjian dengan pihak ketiga, serta prosedur kerja pelayanan (Pasal 11 UU No. 14 Tahun 2008).
                <?php endif; ?>
            </p>
        </div>
    </section>

    <!-- Container Konten Daftar Informasi (List Minimalis Modern ala Contoh Unpad) -->
    <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="space-y-4">
            <!-- Bar Kontrol Tabel: Show Entries di Kiri & Search di Kanan (DataTables Style) -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
                <!-- Dropdown Show Entries -->
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                    <span>Show</span>
                    <select id="select-per-page-kat" onchange="changePerPageKat(this.value)" 
                            class="px-3 py-1.5 bg-white border border-slate-900 rounded-2xl text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entries</span>
                </div>

                <!-- Search Bar Pencarian Seluruh Isi Tabel (Format DataTables Style: Search: [_____ x]) -->
                <form id="form-search-kat" onsubmit="event.preventDefault();" class="flex items-center gap-2">
                    <label for="input-search-kat" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">
                        Search:
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="input-search-kat"
                               autocomplete="off"
                               oninput="debounceSearchKat()"
                               class="w-48 sm:w-56 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-2xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                        <button type="button" id="btn-clear-search-kat" onclick="clearSearchKat()" title="Hapus pencarian" 
                                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </form>
            </div>

            <?php if($slug === 'serta-merta'): ?>
                <!-- Pengumuman Tipe Card List ala Unpad untuk Informasi Serta-Merta -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 sm:p-7 space-y-4">
                    <!-- Container Card List Serta-Merta (Terhubung dengan Client-Side Instant Search) -->
                    <div id="container-serta-merta" class="space-y-3">
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                    ? $item->link_informasi 
                                    : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName)) : null);
                                $tglPembuatan = $item->waktu_pembuatan_informasi ?: ($item->created_at ? $item->created_at->translatedFormat('d F Y') : '-');
                            ?>
                            <div class="card-serta-merta group/card flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 sm:p-5 rounded-2xl border border-slate-200/80 bg-white hover:bg-sky-50/40 hover:border-sky-200 transition-all duration-200 shadow-2xs hover:shadow-xs"
                                 data-dilihat="<?php echo e((int)($item->dilihat ?? 0)); ?>"
                                 data-rincian="<?php echo e(strtolower($item->rincian_informasi ?? '')); ?>"
                                 data-sub_informasi="<?php echo e(strtolower($item->sub_informasi ?? '')); ?>">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-10 h-10 rounded-xl bg-sky-100/70 text-sky-600 flex items-center justify-center shrink-0 group-hover/card:bg-sky-500 group-hover/card:text-white transition-colors duration-200 mt-0.5">
                                        <i class="fa-solid fa-bullhorn text-sm"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover/card:text-sky-600 transition-colors leading-snug">
                                            <?php echo e($item->sub_informasi); ?>

                                        </h3>
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400 font-semibold">
                                            <span class="flex items-center gap-1.5">
                                                <i class="fa-regular fa-calendar text-[11px]"></i>
                                                <span><?php echo e($tglPembuatan); ?></span>
                                            </span>
                                            <?php if($item->pejabat_unit_yang_menguasai_informasi): ?>
                                                <span class="text-slate-300">•</span>
                                                <span class="flex items-center gap-1.5 text-slate-500">
                                                    <i class="fa-solid fa-building-columns text-[11px]"></i>
                                                    <span><?php echo e($item->pejabat_unit_yang_menguasai_informasi); ?></span>
                                                </span>
                                            <?php endif; ?>
                                            <?php if($item->dilihat): ?>
                                                <span class="text-slate-300">•</span>
                                                <span class="flex items-center gap-1.5">
                                                    <i class="fa-regular fa-eye text-[11px]"></i>
                                                    <span><?php echo e(number_format($item->dilihat)); ?> dilihat</span>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                    <?php if($fileTargetUrl): ?>
                                        <a href="<?php echo e($fileTargetUrl); ?>" target="_blank" 
                                           class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-xl transition shadow-2xs hover:shadow-xs cursor-pointer">
                                            <span>Lihat Berkas</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-xs font-semibold text-slate-400 italic px-3 py-1.5 bg-slate-100 rounded-xl">Dokumen Belum Tersedia</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-12 text-center text-slate-400 font-semibold">
                                Belum ada pengumuman serta-merta yang diterbitkan saat ini.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Pagination Serta-Merta -->
                    <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div id="table-kat-info" class="text-xs md:text-sm text-slate-800">
                            Menampilkan 0 sampai 0 dari 0 entri
                        </div>
                        <div id="table-kat-pagination" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
                            <!-- Tombol dibuat via JavaScript secara instan -->
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Tabel Rincian Informasi & Sub Informasi (Untuk Berkala & Setiap Saat) -->
                <div class="bg-white rounded-2xl border border-slate-300 shadow-xs overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-slate-300">
                            <thead>
                                <tr class="bg-sky-500 text-white text-[11px] sm:text-xs md:text-sm font-black tracking-tight divide-x divide-white/40 border-b border-sky-600 select-none">
                                    <th onclick="sortKatTable('rincian')" class="px-5 py-3 min-w-[220px] sm:w-1/3 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Rincian Informasi">
                                        <div class="flex items-center justify-between gap-1.5">
                                            <span>Rincian Informasi</span>
                                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                                <i class="fa-solid fa-sort"></i>
                                            </span>
                                        </div>
                                    </th>
                                    <th onclick="sortKatTable('sub_informasi')" class="px-5 py-3 min-w-[300px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Sub Informasi">
                                        <div class="flex items-center justify-between gap-1.5">
                                            <span>Sub Informasi</span>
                                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                                <i class="fa-solid fa-sort"></i>
                                            </span>
                                        </div>
                                    </th>
                                    <th onclick="sortKatTable('dilihat')" class="px-4 py-3 text-center w-28 shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan berdasarkan Sering Dilihat">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <span>Akses</span>
                                            <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                                <i class="fa-solid fa-sort"></i>
                                            </span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="table-kat-body" class="divide-y divide-slate-300 text-xs sm:text-sm font-medium text-slate-800">
                                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                        $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                        $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                            ? $item->link_informasi 
                                            : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName)) : null);
                                        $rincianText = trim($item->rincian_informasi ?: '-');
                                    ?>
                                    <tr class="table-kat-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-300"
                                        data-dilihat="<?php echo e((int)($item->dilihat ?? 0)); ?>"
                                        data-rincian="<?php echo e(strtolower($rincianText)); ?>"
                                        data-sub_informasi="<?php echo e(strtolower($item->sub_informasi ?? '')); ?>">
                                        <!-- 1. Rincian Informasi -->
                                        <td class="col-kat-rincian px-5 py-3.5 font-extrabold text-slate-900 align-top leading-relaxed bg-white border-r border-slate-300 [word-break:break-word]">
                                            <?php echo e($rincianText); ?>

                                        </td>

                                        <!-- 2. Sub Informasi (Nama Dokumen) -->
                                        <td class="px-5 py-3.5 text-slate-800 align-top leading-relaxed [word-break:break-word]">
                                             <?php
                                                 $subText = trim($item->sub_informasi ?: '');
                                                 $isPending = empty($subText) || $subText === 'Dokumen sedang dilengkapi unit';
                                             ?>
                                             <div class="space-y-1.5">
                                                 <?php if(!$isPending): ?>
                                                     <div class="font-bold text-slate-900">
                                                         <?php echo e($subText); ?>

                                                     </div>


                                                     <?php if($item->dilihat): ?>
                                                         <div class="text-[11px] text-slate-400 font-semibold flex items-center gap-1.5">
                                                             <i class="fa-regular fa-eye text-[10px]"></i>
                                                             <span><?php echo e(number_format($item->dilihat)); ?> dilihat</span>
                                                         </div>
                                                     <?php endif; ?>
                                                 <?php else: ?>
                                                     <div class="text-xs text-slate-400 italic font-medium flex items-center gap-1.5">
                                                         <i class="fa-regular fa-clock text-[11px]"></i>
                                                         <span>Dokumen sedang dilengkapi unit</span>
                                                     </div>
                                                 <?php endif; ?>
                                             </div>
                                        </td>

                                        <!-- 3. Akses -->
                                        <td class="px-2 py-3 text-center align-middle">
                                             <div class="flex items-center justify-center">
                                                 <?php if($item->bentuk_informasi_yang_tersedia === 'Cetak' && !$item->file_informasi && !$item->link_informasi): ?>
                                                     <span class="text-slate-400 font-bold text-xs">-</span>
                                                 <?php elseif($fileTargetUrl && $fileTargetUrl !== '#'): ?>
                                                     <a href="<?php echo e($fileTargetUrl); ?>" target="_blank" title="Lihat Tautan / Berkas" 
                                                        class="inline-flex items-center justify-center px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-lg transition shadow-2xs">
                                                         Lihat
                                                     </a>
                                                 <?php else: ?>
                                                     <span class="text-slate-400 font-bold text-xs">-</span>
                                                 <?php endif; ?>
                                             </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="p-12 text-center text-slate-400 font-semibold">
                                            Tidak ada data informasi untuk kategori ini.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Pagination Client-side Instan -->
                    <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div id="table-kat-info" class="text-xs md:text-sm text-slate-800">
                            Menampilkan 0 sampai 0 dari 0 entri
                        </div>
                        <div id="table-kat-pagination" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
                            <!-- Tombol dibuat via JavaScript secara instan -->
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Call to Action Bantuan -->
            <div class="bg-gradient-to-r from-sky-600 to-blue-700 text-white rounded-2xl p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <h4 class="font-extrabold text-sm sm:text-base">Butuh dokumen atau informasi lainnya?</h4>
                    <p class="text-xs text-sky-100">
                        Anda dapat mengajukan permohonan informasi publik secara online melalui formulir permohonan resmi PPID FMIPA Unila.
                    </p>
                </div>
                <a href="<?php echo e(url('/permohonan')); ?>" class="px-4 py-2 bg-white text-sky-700 hover:bg-sky-50 font-extrabold text-xs rounded-xl transition shadow-xs shrink-0 whitespace-nowrap">
                    Ajukan Permohonan
                </a>
            </div>
        </div>
    </div>

</main>

<script>
    let katAllRows = [];
    let katFilteredRows = [];
    let katCurrentPage = 1;
    let katPerPage = 10;
    let katSortColumn = null;
    let katSortDirection = 'asc';

    function initClientSideKatTable() {
        const tbody = document.getElementById('table-kat-body');
        const containerCards = document.getElementById('container-serta-merta');

        const rawRows = tbody ? Array.from(tbody.querySelectorAll('.table-kat-row')) : [];
        const rawCards = containerCards ? Array.from(containerCards.querySelectorAll('.card-serta-merta')) : [];

        if (rawRows.length === 0 && rawCards.length === 0) return;

        const sourceElements = rawCards.length > 0 ? rawCards : rawRows;

        katAllRows = sourceElements.map((el, index) => {
            return {
                element: el,
                originalIndex: index + 1,
                dilihat: parseInt(el.getAttribute('data-dilihat')) || 0,
                rincian: el.getAttribute('data-rincian') || '',
                sub_informasi: el.getAttribute('data-sub_informasi') || '',
                fullText: el.innerText.toLowerCase()
            };
        });

        updatePopulerKatBtnUI();
        applyClientSideKatFilter();
    }

    function toggleFilterPopulerKat() {
        if (katSortColumn === 'dilihat') {
            katSortColumn = null;
            katSortDirection = 'asc';
        } else {
            katSortColumn = 'dilihat';
            katSortDirection = 'desc';
        }

        updatePopulerKatBtnUI();
        updateSortKatIconsUI();
        katCurrentPage = 1;
        applyClientSideKatFilter();
    }

    function updatePopulerKatBtnUI() {
        const btn = document.getElementById('btn-filter-populer-kat');
        if (!btn) return;

        if (katSortColumn === 'dilihat') {
            btn.className = 'px-3.5 py-1.5 rounded-2xl border text-xs sm:text-sm font-black transition flex items-center gap-1.5 shadow-xs cursor-pointer border-amber-500 bg-amber-500 text-white';
        } else {
            btn.className = 'px-3.5 py-1.5 rounded-2xl border text-xs sm:text-sm font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer border-slate-300 bg-white text-slate-700 hover:bg-sky-50 hover:text-sky-600 hover:border-sky-300';
        }
    }

    function debounceSearchKat() {
        const input = document.getElementById('input-search-kat');
        const clearBtn = document.getElementById('btn-clear-search-kat');
        if (!input) return;

        const query = input.value.trim();
        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        katCurrentPage = 1;
        applyClientSideKatFilter();
    }

    function clearSearchKat() {
        const input = document.getElementById('input-search-kat');
        const clearBtn = document.getElementById('btn-clear-search-kat');
        if (input) {
            input.value = '';
            input.focus();
        }
        if (clearBtn) clearBtn.classList.add('hidden');
        katCurrentPage = 1;
        applyClientSideKatFilter();
    }

    function changePerPageKat(val) {
        katPerPage = parseInt(val) || 10;
        katCurrentPage = 1;
        applyClientSideKatFilter();
    }

    function sortKatTable(column) {
        if (katSortColumn === column) {
            if (katSortDirection === 'asc') {
                katSortDirection = 'desc';
            } else {
                katSortColumn = null;
                katSortDirection = 'asc';
            }
        } else {
            katSortColumn = column;
            katSortDirection = 'asc';
        }

        updatePopulerKatBtnUI();
        updateSortKatIconsUI();
        applyClientSideKatFilter();
    }

    function updateSortKatIconsUI() {
        const headers = document.querySelectorAll('th[onclick*="sortKatTable"]');
        headers.forEach(th => {
            const colName = th.getAttribute('onclick').match(/'(.*)'/)?.[1];
            const iconSpan = th.querySelector('span:last-child');
            if (!iconSpan) return;

            if (colName === katSortColumn) {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white transition';
                iconSpan.innerHTML = katSortDirection === 'desc' 
                    ? '<i class="fa-solid fa-sort-down"></i>' 
                    : '<i class="fa-solid fa-sort-up"></i>';
            } else {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition';
                iconSpan.innerHTML = '<i class="fa-solid fa-sort"></i>';
            }
        });
    }

    function applyClientSideKatFilter() {
        const input = document.getElementById('input-search-kat');
        const query = input ? input.value.trim().toLowerCase() : '';

        if (!query) {
            katFilteredRows = [...katAllRows];
        } else {
            katFilteredRows = katAllRows.filter(row => row.fullText.includes(query));
        }

        if (katSortColumn) {
            katFilteredRows.sort((a, b) => {
                if (katSortColumn === 'dilihat') {
                    const valA = a.dilihat || 0;
                    const valB = b.dilihat || 0;
                    return katSortDirection === 'asc' ? valA - valB : valB - valA;
                }
                const valA = a[katSortColumn] || '';
                const valB = b[katSortColumn] || '';
                const cmp = valA.localeCompare(valB, 'id', { numeric: true, sensitivity: 'base' });
                return katSortDirection === 'asc' ? cmp : -cmp;
            });
        } else {
            katFilteredRows.sort((a, b) => a.originalIndex - b.originalIndex);
        }

        renderClientSideKatTable();
    }

    function renderClientSideKatTable() {
        const tbody = document.getElementById('table-kat-body');
        const containerCards = document.getElementById('container-serta-merta');
        const infoEl = document.getElementById('table-kat-info');
        const paginEl = document.getElementById('table-kat-pagination');

        const isCards = !!containerCards;
        const targetContainer = isCards ? containerCards : tbody;
        if (!targetContainer) return;

        const totalItems = katFilteredRows.length;
        const totalPages = Math.ceil(totalItems / katPerPage) || 1;

        if (katCurrentPage > totalPages) katCurrentPage = totalPages;
        if (katCurrentPage < 1) katCurrentPage = 1;

        const startIndex = (katCurrentPage - 1) * katPerPage;
        const endIndex = Math.min(startIndex + katPerPage, totalItems);

        targetContainer.innerHTML = '';

        if (totalItems === 0) {
            if (isCards) {
                targetContainer.innerHTML = '<div class="p-12 text-center text-slate-400 font-semibold bg-slate-50/50 rounded-2xl border border-slate-100">Tidak ada pengumuman yang sesuai dengan pencarian.</div>';
            } else {
                targetContainer.innerHTML = '<tr><td colspan="3" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data informasi untuk kategori ini yang sesuai.</td></tr>';
            }
            if (infoEl) infoEl.innerText = 'Menampilkan 0 sampai 0 dari 0 entri';
            if (paginEl) paginEl.innerHTML = '';
            return;
        }

        const pageRows = katFilteredRows.slice(startIndex, endIndex);

        if (isCards) {
            // Render Cards untuk Informasi Serta-Merta
            pageRows.forEach(row => {
                targetContainer.appendChild(row.element);
            });
        } else {
            // Render Tabel dengan penggabungan rowspan otomatis untuk Berkala & Setiap Saat
            let i = 0;
            while (i < pageRows.length) {
                const currentRincian = (pageRows[i].rincian || '').trim();
                let span = 1;
                for (let j = i + 1; j < pageRows.length; j++) {
                    const nextRincian = (pageRows[j].rincian || '').trim();
                    if (currentRincian.localeCompare(nextRincian, 'id', { sensitivity: 'accent' }) === 0) {
                        span++;
                    } else {
                        break;
                    }
                }

                for (let k = 0; k < span; k++) {
                    const tr = pageRows[i + k].element;
                    const rincianTd = tr.querySelector('.col-kat-rincian');
                    if (rincianTd) {
                        if (k === 0) {
                            rincianTd.style.display = '';
                            rincianTd.setAttribute('rowspan', span);
                        } else {
                            rincianTd.style.display = 'none';
                        }
                    }
                    targetContainer.appendChild(tr);
                }

                i += span;
            }
        }

        if (infoEl) {
            infoEl.innerText = `Menampilkan ${startIndex + 1} sampai ${endIndex} dari ${totalItems} entri`;
        }

        if (paginEl) {
            paginEl.innerHTML = '';

            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.innerHTML = '‹';
            prevBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (katCurrentPage === 1 ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            prevBtn.onclick = () => { if (katCurrentPage > 1) { katCurrentPage--; renderClientSideKatTable(); } };
            paginEl.appendChild(prevBtn);

            for (let p = 1; p <= totalPages; p++) {
                if (totalPages > 7 && Math.abs(p - katCurrentPage) > 2 && p !== 1 && p !== totalPages) {
                    if (p === 2 || p === totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.className = 'px-3 py-2 text-xs font-bold bg-slate-100/70 text-slate-400 select-none';
                        dots.innerText = '...';
                        paginEl.appendChild(dots);
                    }
                    continue;
                }

                const pageBtn = document.createElement('button');
                pageBtn.type = 'button';
                pageBtn.innerText = p;
                pageBtn.className = 'px-3.5 py-2 min-w-[38px] text-center text-xs transition cursor-pointer ' + 
                    (p === katCurrentPage ? 'font-extrabold bg-sky-500 text-white shadow-2xs' : 'font-bold bg-white text-sky-500 hover:bg-sky-50');
                pageBtn.onclick = () => { katCurrentPage = p; renderClientSideKatTable(); };
                paginEl.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.innerHTML = '›';
            nextBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (katCurrentPage === totalPages ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            nextBtn.onclick = () => { if (katCurrentPage < totalPages) { katCurrentPage++; renderClientSideKatTable(); } };
            paginEl.appendChild(nextBtn);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initClientSideKatTable();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/masyarakat/informasi_publik/kategori.blade.php ENDPATH**/ ?>