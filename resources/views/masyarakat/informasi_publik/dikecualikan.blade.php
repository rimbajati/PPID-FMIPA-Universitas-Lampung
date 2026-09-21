@extends('components.layouts.app')

@section('title', 'Daftar Informasi Publik yang Dikecualikan - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-100/70 min-h-screen pb-20">

    <!-- Header Hero Banner Dikecualikan (Matching DIP Layout) -->
    <section class="bg-slate-100/80 text-slate-800 py-8 md:py-10 border-b border-slate-200/80">
        <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 space-y-2">
            <h1 class="text-3xl sm:text-4xl md:text-[2.6rem] font-black text-slate-900 tracking-tight leading-tight">
                Informasi yang Dikecualikan
            </h1>
            <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed max-w-5xl">
                Memuat daftar informasi publik yang bersifat ketat, terbatas, dan rahasia yang tidak dapat diberikan kepada pemohon berdasarkan pengujian konsekuensi Pasal 17 Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik oleh PPID FMIPA Universitas Lampung. Untuk Daftar Informasi Publik yang Dikecualikan tingkat universitas dapat diakses melalui portal PPID Utama:
                <a href="https://ppid.unila.ac.id/informasi-dikecualikan/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 text-sky-600 hover:text-sky-700 font-bold hover:underline ml-1">
                    <span>Daftar Informasi Publik yang Dikecualikan Universitas Lampung &rarr;</span>
                </a>
            </p>
        </div>
    </section>

    <!-- Container Konten Daftar Informasi Dikecualikan -->
    <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="space-y-4">
            <!-- Bar Kontrol Tabel: Show Entries di Kiri & Search di Kanan (DataTables Style) -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
                <!-- Dropdown Show Entries -->
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                    <span>Show</span>
                    <select id="select-per-page-dik" onchange="changePerPageDik(this.value)" 
                            class="px-3 py-1.5 bg-white border border-slate-900 rounded-2xl text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entries</span>
                </div>

                <!-- Search Bar Pencarian Seluruh Isi Tabel (Format DataTables Style: Search: [_____ x]) -->
                <form id="form-search-dik" onsubmit="event.preventDefault();" class="flex items-center gap-2">
                    <label for="input-search-dik" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">
                        Search:
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="input-search-dik"
                               autocomplete="off"
                               oninput="debounceSearchDik()"
                               class="w-48 sm:w-56 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-2xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                        <button type="button" id="btn-clear-search-dik" onclick="clearSearchDik()" title="Hapus pencarian" 
                                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Informasi Publik yang Dikecualikan (Desain Seragam dengan Tabel DIP) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-slate-300">
                        <thead>
                            <!-- Baris Header 1 -->
                            <tr class="bg-sky-500 text-white text-[11px] sm:text-xs md:text-sm font-black tracking-tight divide-x divide-white/40 border-b border-sky-600 select-none">
                                <th rowspan="2" onclick="sortDikTable('no')" class="px-3 py-3.5 text-center w-12 shrink-0 border-r border-white/40 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
                                    <div class="flex items-center justify-center gap-1">
                                        <span>No</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th rowspan="2" onclick="sortDikTable('ringkasan')" class="px-5 py-3.5 text-center min-w-[220px] max-w-[300px] border-r border-white/40 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th rowspan="2" onclick="sortDikTable('dasar_hukum')" class="px-5 py-3.5 text-center min-w-[240px] max-w-[340px] border-r border-white/40 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Dasar Hukum">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Dasar Hukum</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th colspan="2" class="px-4 py-2 text-center border-b border-r border-white/40">
                                    Konsekuensi / Pertimbangan Bagi Publik
                                </th>
                                <th rowspan="2" onclick="sortDikTable('jangka_waktu')" class="px-4 py-3.5 text-center min-w-[180px] max-w-[240px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Jangka Waktu">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Jangka Waktu</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                            </tr>
                            <!-- Baris Header 2 (Sub-kolom Konsekuensi) -->
                            <tr class="bg-sky-500 text-white text-[11px] sm:text-xs md:text-sm font-black tracking-tight divide-x divide-white/40 border-b border-sky-600 select-none">
                                <th onclick="sortDikTable('dibuka')" class="px-4 py-2 text-center min-w-[180px] max-w-[260px] border-r border-white/40 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Konsekuensi Dibuka">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Dibuka</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortDikTable('ditutup')" class="px-4 py-2 text-center min-w-[180px] max-w-[260px] border-r border-white/40 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Konsekuensi Ditutup">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Ditutup</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="table-dik-body" class="divide-y divide-slate-300 text-xs sm:text-sm font-medium text-slate-800">
                            @forelse($items as $idx => $item)
                                <tr class="table-dik-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-300"
                                    data-no="{{ $idx + 1 }}"
                                    data-ringkasan="{{ strtolower($item->ringkasan_informasi ?? '') }}"
                                    data-dasar_hukum="{{ strtolower($item->dasar_hukum ?? '') }}"
                                    data-dibuka="{{ strtolower($item->dibuka ?? '') }}"
                                    data-ditutup="{{ strtolower($item->ditutup ?? '') }}"
                                    data-jangka_waktu="{{ strtolower($item->jangka_waktu ?? '') }}">
                                    <!-- 1. NO -->
                                    <td class="col-dik-no px-3 py-3 text-center font-bold text-slate-400 align-top">
                                        {{ $idx + 1 }}
                                    </td>

                                    <!-- 2. INFORMASI -->
                                    <td class="px-5 py-3 font-extrabold text-slate-900 align-top leading-relaxed [word-break:break-word]">
                                        {{ $item->ringkasan_informasi }}
                                    </td>

                                    <!-- 3. DASAR HUKUM -->
                                    <td class="px-5 py-3 text-slate-700 align-top leading-relaxed [word-break:break-word] whitespace-pre-line font-medium">
                                        {{ $item->dasar_hukum ?: '-' }}
                                    </td>

                                    <!-- 4. KONSEKUENSI DIBUKA -->
                                    <td class="px-4 py-3 text-slate-700 align-top leading-relaxed [word-break:break-word] whitespace-pre-line font-medium">
                                        {{ $item->dibuka ?: '-' }}
                                    </td>

                                    <!-- 5. KONSEKUENSI DITUTUP -->
                                    <td class="px-4 py-3 text-slate-700 align-top leading-relaxed [word-break:break-word] whitespace-pre-line font-medium">
                                        {{ $item->ditutup ?: '-' }}
                                    </td>

                                    <!-- 6. JANGKA WAKTU -->
                                    <td class="px-4 py-3 text-slate-700 align-top leading-relaxed [word-break:break-word] whitespace-pre-line font-semibold">
                                        {{ $item->jangka_waktu ?: '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-12 text-center text-slate-400 font-semibold">
                                        Tidak ada data Informasi Publik yang Dikecualikan yang sesuai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination Client-side Instan -->
                <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div id="table-dik-info" class="text-xs md:text-sm text-slate-800">
                        Menampilkan 0 sampai 0 dari 0 entri
                    </div>
                    <div id="table-dik-pagination" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
                        <!-- Tombol dibuat via JavaScript secara instan -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<script>
    let dikAllRows = [];
    let dikFilteredRows = [];
    let dikCurrentPage = 1;
    let dikPerPage = 10;
    let dikSortColumn = null;
    let dikSortDirection = 'asc';

    function initClientSideDikTable() {
        const tbody = document.getElementById('table-dik-body');
        if (!tbody) return;

        const rawRows = Array.from(tbody.querySelectorAll('.table-dik-row'));
        if (rawRows.length === 0) return;

        dikAllRows = rawRows.map((tr, index) => {
            return {
                element: tr,
                originalIndex: index + 1,
                ringkasan: tr.getAttribute('data-ringkasan') || '',
                dasar_hukum: tr.getAttribute('data-dasar_hukum') || '',
                dibuka: tr.getAttribute('data-dibuka') || '',
                ditutup: tr.getAttribute('data-ditutup') || '',
                jangka_waktu: tr.getAttribute('data-jangka_waktu') || '',
                fullText: tr.innerText.toLowerCase()
            };
        });

        applyClientSideDikFilter();
    }

    function debounceSearchDik() {
        const input = document.getElementById('input-search-dik');
        const clearBtn = document.getElementById('btn-clear-search-dik');
        if (!input) return;

        const query = input.value.trim();
        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        dikCurrentPage = 1;
        applyClientSideDikFilter();
    }

    function clearSearchDik() {
        const input = document.getElementById('input-search-dik');
        const clearBtn = document.getElementById('btn-clear-search-dik');
        if (input) {
            input.value = '';
            input.focus();
        }
        if (clearBtn) clearBtn.classList.add('hidden');
        dikCurrentPage = 1;
        applyClientSideDikFilter();
    }

    function changePerPageDik(val) {
        dikPerPage = parseInt(val) || 10;
        dikCurrentPage = 1;
        applyClientSideDikFilter();
    }

    function sortDikTable(column) {
        if (dikSortColumn === column) {
            if (dikSortDirection === 'asc') {
                dikSortDirection = 'desc';
            } else {
                dikSortColumn = null;
                dikSortDirection = 'asc';
            }
        } else {
            dikSortColumn = column;
            dikSortDirection = 'asc';
        }

        updateSortDikIconsUI();
        applyClientSideDikFilter();
    }

    function updateSortDikIconsUI() {
        const headers = document.querySelectorAll('th[onclick*="sortDikTable"]');
        headers.forEach(th => {
            const colName = th.getAttribute('onclick').match(/'(.*)'/)?.[1];
            const iconSpan = th.querySelector('span:last-child');
            if (!iconSpan) return;

            if (colName === dikSortColumn) {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white transition';
                iconSpan.innerHTML = dikSortDirection === 'desc' 
                    ? '<i class="fa-solid fa-sort-down"></i>' 
                    : '<i class="fa-solid fa-sort-up"></i>';
            } else {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition';
                iconSpan.innerHTML = '<i class="fa-solid fa-sort"></i>';
            }
        });
    }

    function applyClientSideDikFilter() {
        const input = document.getElementById('input-search-dik');
        const query = input ? input.value.trim().toLowerCase() : '';

        if (!query) {
            dikFilteredRows = [...dikAllRows];
        } else {
            dikFilteredRows = dikAllRows.filter(row => row.fullText.includes(query));
        }

        if (dikSortColumn) {
            dikFilteredRows.sort((a, b) => {
                if (dikSortColumn === 'no') {
                    return dikSortDirection === 'asc' ? a.originalIndex - b.originalIndex : b.originalIndex - a.originalIndex;
                }
                const valA = a[dikSortColumn] || '';
                const valB = b[dikSortColumn] || '';
                const cmp = valA.localeCompare(valB, 'id', { numeric: true, sensitivity: 'base' });
                return dikSortDirection === 'asc' ? cmp : -cmp;
            });
        } else {
            dikFilteredRows.sort((a, b) => a.originalIndex - b.originalIndex);
        }

        renderClientSideDikTable();
    }

    function renderClientSideDikTable() {
        const tbody = document.getElementById('table-dik-body');
        const infoEl = document.getElementById('table-dik-info');
        const paginEl = document.getElementById('table-dik-pagination');
        if (!tbody) return;

        const totalItems = dikFilteredRows.length;
        const totalPages = Math.ceil(totalItems / dikPerPage) || 1;

        if (dikCurrentPage > totalPages) dikCurrentPage = totalPages;
        if (dikCurrentPage < 1) dikCurrentPage = 1;

        const startIndex = (dikCurrentPage - 1) * dikPerPage;
        const endIndex = Math.min(startIndex + dikPerPage, totalItems);

        tbody.innerHTML = '';

        if (totalItems === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data Informasi Publik yang Dikecualikan yang sesuai.</td></tr>';
            if (infoEl) infoEl.innerText = 'Menampilkan 0 sampai 0 dari 0 entri';
            if (paginEl) paginEl.innerHTML = '';
            return;
        }

        const pageRows = dikFilteredRows.slice(startIndex, endIndex);
        pageRows.forEach((row, idx) => {
            const tr = row.element;
            const noCol = tr.querySelector('.col-dik-no');
            if (noCol) noCol.innerText = startIndex + idx + 1;
            tbody.appendChild(tr);
        });

        if (infoEl) {
            infoEl.innerText = `Menampilkan ${startIndex + 1} sampai ${endIndex} dari ${totalItems} entri`;
        }

        if (paginEl) {
            paginEl.innerHTML = '';

            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.innerHTML = '‹';
            prevBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (dikCurrentPage === 1 ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            prevBtn.onclick = () => { if (dikCurrentPage > 1) { dikCurrentPage--; renderClientSideDikTable(); } };
            paginEl.appendChild(prevBtn);

            for (let p = 1; p <= totalPages; p++) {
                if (totalPages > 7 && Math.abs(p - dikCurrentPage) > 2 && p !== 1 && p !== totalPages) {
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
                    (p === dikCurrentPage ? 'font-extrabold bg-sky-500 text-white shadow-2xs' : 'font-bold bg-white text-sky-500 hover:bg-sky-50');
                pageBtn.onclick = () => { dikCurrentPage = p; renderClientSideDikTable(); };
                paginEl.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.innerHTML = '›';
            nextBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (dikCurrentPage === totalPages ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            nextBtn.onclick = () => { if (dikCurrentPage < totalPages) { dikCurrentPage++; renderClientSideDikTable(); } };
            paginEl.appendChild(nextBtn);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initClientSideDikTable();
    });
</script>
@endsection
