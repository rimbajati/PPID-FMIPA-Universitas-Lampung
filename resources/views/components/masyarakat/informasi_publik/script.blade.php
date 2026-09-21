<script>
    function incrementCounter(id) {
        var el = document.getElementById('click-count-' + id);
        if (el) {
            var currentVal = parseInt(el.innerText.replace(/[^0-9]/g, '')) || 0;
            var newVal = currentVal + 1;
            el.innerText = newVal.toLocaleString('id-ID');
        }
    }

    document.addEventListener('click', function(e) {
        const link = e.target.closest('aside a[href]');
        if (link) {
            sessionStorage.setItem('catalog_scroll_pos', window.scrollY);
        }
    });

    (function() {
        const savedPos = sessionStorage.getItem('catalog_scroll_pos');
        if (savedPos !== null) {
            window.scrollTo(0, parseInt(savedPos));
            sessionStorage.removeItem('catalog_scroll_pos');
        }
    })();

    function openPublicDikModal(item) {
        document.getElementById('publicDikDetailJudul').innerText = item.judul_informasi || '-';
        document.getElementById('publicDikDetailDasarHukum').innerText = item.dasar_hukum || '-';
        document.getElementById('publicDikDetailDibuka').innerText = item.dibuka || '-';
        document.getElementById('publicDikDetailDitutup').innerText = item.ditutup || '-';
        document.getElementById('publicDikDetailJangkaWaktu').innerText = item.jangka_waktu || '-';

        document.getElementById('modalPublicDetailDikecualikan').classList.remove('hidden');
    }

    function closePublicDikModal() {
        document.getElementById('modalPublicDetailDikecualikan').classList.add('hidden');
    }

    // =========================================================================
    // PURE CLIENT-SIDE DATATABLES ENGINE (0ms Instant Search & Filter ala Unpad)
    // =========================================================================
    let dipAllRows = [];
    let dipFilteredRows = [];
    let dipCurrentPage = 1;
    let dipPerPage = 10;
    let dipSortColumn = null;
    let dipSortDirection = 'asc';

    function initClientSideDipTable() {
        const tbody = document.getElementById('table-dip-body');
        if (!tbody) return;

        // Ambil preferensi dari URL jika ada
        const urlParams = new URLSearchParams(window.location.search);
        const searchVal = urlParams.get('search') || '';
        const perPageVal = parseInt(urlParams.get('per_page')) || 10;
        const sortByVal = urlParams.get('sort_by') || null;
        const sortDirVal = urlParams.get('sort_direction') || 'asc';

        dipPerPage = [10, 25, 50, 100].includes(perPageVal) ? perPageVal : 10;
        dipSortColumn = sortByVal;
        dipSortDirection = sortDirVal;

        const perPageSelect = document.getElementById('select-per-page-dip');
        if (perPageSelect) perPageSelect.value = dipPerPage;

        const searchInput = document.getElementById('input-search-dip');
        if (searchInput && searchVal) searchInput.value = searchVal;

        // Simpan semua baris tabel asli ke array memory
        const rawRows = Array.from(tbody.querySelectorAll('.table-dip-row'));
        if (rawRows.length === 0) return;

        dipAllRows = rawRows.map((tr, index) => {
            return {
                element: tr,
                originalIndex: index + 1,
                no: index + 1,
                dilihat: parseInt(tr.getAttribute('data-dilihat')) || 0,
                ringkasan: tr.getAttribute('data-ringkasan') || '',
                jenis: tr.getAttribute('data-jenis') || '',
                pejabat: tr.getAttribute('data-pejabat') || '',
                penanggung_jawab: tr.getAttribute('data-penanggung_jawab') || '',
                waktu: tr.getAttribute('data-waktu') || '',
                retensi: tr.getAttribute('data-retensi') || '',
                bentuk: tr.getAttribute('data-bentuk') || '',
                fullText: tr.innerText.toLowerCase()
            };
        });

        updatePopulerBtnUI();
        applyClientSideFilter();
    }

    function toggleFilterPopulerDip() {
        if (dipSortColumn === 'dilihat') {
            // Jika sedang aktif, klik lagi akan reset ke urutan default
            dipSortColumn = null;
            dipSortDirection = 'asc';
        } else {
            // Aktifkan urutan sering dilihat (terbanyak ke terendah)
            dipSortColumn = 'dilihat';
            dipSortDirection = 'desc';
        }

        updatePopulerBtnUI();
        updateSortIconsUI();
        dipCurrentPage = 1;
        applyClientSideFilter();
    }

    function updatePopulerBtnUI() {
        const btn = document.getElementById('btn-filter-populer');
        if (!btn) return;

        if (dipSortColumn === 'dilihat') {
            btn.className = 'px-3.5 py-1.5 rounded-2xl border text-xs sm:text-sm font-black transition flex items-center gap-1.5 shadow-xs cursor-pointer border-amber-500 bg-amber-500 text-white';
        } else {
            btn.className = 'px-3.5 py-1.5 rounded-2xl border text-xs sm:text-sm font-bold transition flex items-center gap-1.5 shadow-2xs cursor-pointer border-slate-300 bg-white text-slate-700 hover:bg-sky-50 hover:text-sky-600 hover:border-sky-300';
        }
    }

    // Dipanggil seketika saat user mengetik (0 milidetik, tanpa debounce lama)
    function debounceSearchDip() {
        const input = document.getElementById('input-search-dip');
        const clearBtn = document.getElementById('btn-clear-search');
        if (!input) return;

        const query = input.value.trim();
        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        dipCurrentPage = 1;
        applyClientSideFilter();
    }

    function clearSearchDip() {
        const input = document.getElementById('input-search-dip');
        const clearBtn = document.getElementById('btn-clear-search');
        if (input) {
            input.value = '';
            input.focus();
        }
        if (clearBtn) {
            clearBtn.classList.add('hidden');
        }
        dipCurrentPage = 1;
        applyClientSideFilter();
    }

    function changePerPageDip(val) {
        dipPerPage = parseInt(val) || 10;
        dipCurrentPage = 1;
        applyClientSideFilter();
    }

    function sortDipTable(column) {
        if (dipSortColumn === column) {
            if (dipSortDirection === 'asc') {
                dipSortDirection = 'desc';
            } else {
                // Klik ke-3: Reset ke urutan default
                dipSortColumn = null;
                dipSortDirection = 'asc';
            }
        } else {
            dipSortColumn = column;
            dipSortDirection = 'asc';
        }

        updateSortIconsUI();
        applyClientSideFilter();
    }

    function updateSortIconsUI() {
        const headers = document.querySelectorAll('th[onclick*="sortDipTable"]');
        headers.forEach(th => {
            const colName = th.getAttribute('onclick').match(/'(.*)'/)?.[1];
            const iconSpan = th.querySelector('span:last-child');
            if (!iconSpan) return;

            if (colName === dipSortColumn) {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white transition';
                iconSpan.innerHTML = dipSortDirection === 'desc' 
                    ? '<i class="fa-solid fa-sort-down"></i>' 
                    : '<i class="fa-solid fa-sort-up"></i>';
            } else {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition';
                iconSpan.innerHTML = '<i class="fa-solid fa-sort"></i>';
            }
        });
    }

    function applyClientSideFilter() {
        const input = document.getElementById('input-search-dip');
        const query = input ? input.value.trim().toLowerCase() : '';

        // 1. Filtering Instan
        if (!query) {
            dipFilteredRows = [...dipAllRows];
        } else {
            dipFilteredRows = dipAllRows.filter(row => row.fullText.includes(query));
        }

        // 2. Sorting Instan
        if (dipSortColumn) {
            dipFilteredRows.sort((a, b) => {
                let valA, valB;
                if (dipSortColumn === 'no') {
                    valA = a.originalIndex;
                    valB = b.originalIndex;
                    return dipSortDirection === 'asc' ? valA - valB : valB - valA;
                } else if (dipSortColumn === 'dilihat') {
                    valA = a.dilihat || 0;
                    valB = b.dilihat || 0;
                    return dipSortDirection === 'asc' ? valA - valB : valB - valA;
                } else {
                    valA = a[dipSortColumn] || '';
                    valB = b[dipSortColumn] || '';
                    const cmp = valA.localeCompare(valB, 'id', { numeric: true, sensitivity: 'base' });
                    return dipSortDirection === 'asc' ? cmp : -cmp;
                }
            });
        } else {
            // Urutan default semula
            dipFilteredRows.sort((a, b) => a.originalIndex - b.originalIndex);
        }

        // 3. Render Tabel & Paginasi
        renderClientSideDipTable();

        // 4. Sinkronkan ke URL tanpa reload
        const url = new URL(window.location.href);
        if (query) url.searchParams.set('search', query); else url.searchParams.delete('search');
        if (dipPerPage !== 10) url.searchParams.set('per_page', dipPerPage); else url.searchParams.delete('per_page');
        if (dipSortColumn) {
            url.searchParams.set('sort_by', dipSortColumn);
            url.searchParams.set('sort_direction', dipSortDirection);
        } else {
            url.searchParams.delete('sort_by');
            url.searchParams.delete('sort_direction');
        }
        window.history.replaceState({}, '', url.toString());
    }

    function renderClientSideDipTable() {
        const tbody = document.getElementById('table-dip-body');
        const infoEl = document.getElementById('table-dip-info');
        const paginEl = document.getElementById('table-dip-pagination');
        if (!tbody) return;

        const totalItems = dipFilteredRows.length;
        const totalPages = Math.ceil(totalItems / dipPerPage) || 1;

        if (dipCurrentPage > totalPages) dipCurrentPage = totalPages;
        if (dipCurrentPage < 1) dipCurrentPage = 1;

        const startIndex = (dipCurrentPage - 1) * dipPerPage;
        const endIndex = Math.min(startIndex + dipPerPage, totalItems);

        tbody.innerHTML = '';

        if (totalItems === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data Informasi Publik yang sesuai.</td></tr>';
            if (infoEl) infoEl.innerText = 'Menampilkan 0 sampai 0 dari 0 entri';
            if (paginEl) paginEl.innerHTML = '';
            return;
        }

        // Tampilkan potongan baris sesuai halaman
        const pageRows = dipFilteredRows.slice(startIndex, endIndex);
        pageRows.forEach((row, i) => {
            const tr = row.element;
            const noCell = tr.querySelector('.col-dip-no');
            if (noCell) {
                noCell.innerText = startIndex + i + 1;
            }
            tbody.appendChild(tr);
        });

        // Update teks counter: "Menampilkan 1 sampai 10 dari 59 entri"
        if (infoEl) {
            infoEl.innerText = `Menampilkan ${startIndex + 1} sampai ${endIndex} dari ${totalItems} entri`;
        }

        // Render Tombol Pagination ala DataTables
        if (paginEl) {
            paginEl.innerHTML = '';

            // Tombol Previous (‹)
            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.innerHTML = '‹';
            prevBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (dipCurrentPage === 1 ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            prevBtn.onclick = () => { if (dipCurrentPage > 1) { dipCurrentPage--; renderClientSideDipTable(); } };
            paginEl.appendChild(prevBtn);

            // Nomor Halaman
            for (let p = 1; p <= totalPages; p++) {
                // Simple windowing
                if (totalPages > 7 && Math.abs(p - dipCurrentPage) > 2 && p !== 1 && p !== totalPages) {
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
                    (p === dipCurrentPage ? 'font-extrabold bg-sky-500 text-white shadow-2xs' : 'font-bold bg-white text-sky-500 hover:bg-sky-50');
                pageBtn.onclick = () => { dipCurrentPage = p; renderClientSideDipTable(); };
                paginEl.appendChild(pageBtn);
            }

            // Tombol Next (›)
            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.innerHTML = '›';
            nextBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (dipCurrentPage === totalPages ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            nextBtn.onclick = () => { if (dipCurrentPage < totalPages) { dipCurrentPage++; renderClientSideDipTable(); } };
            paginEl.appendChild(nextBtn);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initClientSideDipTable();
    });
</script>
