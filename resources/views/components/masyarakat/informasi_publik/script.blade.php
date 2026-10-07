<script>
    function incrementCounter(id) {
        const el = document.getElementById('click-count-' + id);
        if (el) el.innerText = ((parseInt(el.innerText.replace(/[^0-9]/g, '')) || 0) + 1).toLocaleString('id-ID');
    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('aside a[href]')) sessionStorage.setItem('catalog_scroll_pos', window.scrollY);
    });

    (function() {
        const savedPos = sessionStorage.getItem('catalog_scroll_pos');
        if (savedPos !== null) {
            window.scrollTo(0, parseInt(savedPos, 10));
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

    const dipTables = new Map();

    function initClientSideDipTables() {
        document.querySelectorAll('[data-dip-tbody]').forEach(tbody => {
            const key = tbody.dataset.dipTbody;
            const rows = Array.from(tbody.querySelectorAll('.table-dip-row'));
            const state = {
                tbody,
                rows: rows.map((element, index) => ({
                    element,
                    originalIndex: index + 1,
                    dilihat: parseInt(element.dataset.dilihat, 10) || 0,
                    ringkasan: element.dataset.ringkasan || '',
                    pejabat: element.dataset.pejabat || '',
                    penanggung_jawab: element.dataset.penanggung_jawab || '',
                    waktu: element.dataset.waktu || '',
                    retensi: element.dataset.retensi || '',
                    bentuk: element.dataset.bentuk || '',
                    fullText: element.innerText.toLowerCase()
                })),
                filtered: [],
                page: 1,
                perPage: 10,
                sortColumn: null,
                sortDirection: 'asc'
            };
            dipTables.set(key, state);
            const initialSearch = document.querySelector(`[data-dip-search="${key}"]`);
            if (initialSearch && initialSearch.value) state.filtered = state.rows.filter(row => row.fullText.includes(initialSearch.value.toLowerCase().trim()));
            else state.filtered = [...state.rows];
            renderDipTable(key);
        });
    }

    function searchDipTable(key, value) {
        const state = dipTables.get(key);
        if (!state) return;
        const term = value.trim().toLowerCase();
        state.filtered = term ? state.rows.filter(row => row.fullText.includes(term)) : [...state.rows];
        state.page = 1;
        renderDipTable(key);
    }

    function changePerPageDip(key, value) {
        const state = dipTables.get(key);
        if (!state) return;
        state.perPage = parseInt(value, 10) || 10;
        state.page = 1;
        renderDipTable(key);
    }

    function sortDipTable(key, column) {
        const state = dipTables.get(key);
        if (!state) return;
        if (state.sortColumn === column) {
            if (state.sortDirection === 'asc') state.sortDirection = 'desc';
            else { state.sortColumn = null; state.sortDirection = 'asc'; }
        } else {
            state.sortColumn = column;
            state.sortDirection = 'asc';
        }
        renderDipTable(key);
    }

    function renderDipTable(key) {
        const state = dipTables.get(key);
        if (!state) return;
        const { tbody, filtered } = state;
        const info = document.querySelector(`[data-dip-info="${key}"]`);
        const pagination = document.querySelector(`[data-dip-pagination="${key}"]`);
        const rows = [...filtered];

        if (state.sortColumn) {
            rows.sort((a, b) => {
                let result;
                if (state.sortColumn === 'no') result = a.originalIndex - b.originalIndex;
                else if (state.sortColumn === 'dilihat') result = a.dilihat - b.dilihat;
                else result = (a[state.sortColumn] || '').localeCompare(b[state.sortColumn] || '', 'id', { numeric: true, sensitivity: 'base' });
                return state.sortDirection === 'asc' ? result : -result;
            });
        }

        const total = rows.length;
        const pages = Math.ceil(total / state.perPage) || 1;
        state.page = Math.min(Math.max(state.page, 1), pages);
        const start = (state.page - 1) * state.perPage;
        const end = Math.min(start + state.perPage, total);
        tbody.innerHTML = '';

        tbody.closest('table')?.querySelectorAll('th[onclick*="sortDipTable"]').forEach(th => {
            const column = th.getAttribute('onclick').match(/,\s*'([^']+)'/)?.[1];
            const icon = th.querySelector('span:last-child');
            if (!column || !icon) return;
            const active = column === state.sortColumn;
            icon.className = `inline-flex items-center justify-center text-xs md:text-sm ${active ? 'text-white' : 'text-white/70 group-hover:text-white'} transition`;
            icon.innerHTML = active
                ? (state.sortDirection === 'desc' ? '<i class="fa-solid fa-sort-down"></i>' : '<i class="fa-solid fa-sort-up"></i>')
                : '<i class="fa-solid fa-sort"></i>';
        });

        if (!total) {
            tbody.innerHTML = '<tr><td colspan="8" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data informasi pada jenis ini yang sesuai.</td></tr>';
            if (info) info.innerText = 'Menampilkan 0–0 dari 0 informasi';
            if (pagination) pagination.innerHTML = '';
            return;
        }

        rows.slice(start, end).forEach(row => {
            const numberCell = row.element.querySelector('.col-dip-no');
            if (numberCell) numberCell.innerText = row.originalIndex;
            tbody.appendChild(row.element);
        });
        if (info) info.innerText = `Menampilkan ${start + 1}–${end} dari ${total} informasi`;
        if (!pagination) return;

        pagination.innerHTML = '';
        const addButton = (label, target, disabled, active = false) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.innerText = label;
            button.disabled = disabled;
            button.className = 'px-3.5 py-2 min-w-[38px] text-center text-sm transition ' + (active ? 'font-extrabold bg-sky-500 text-white' : disabled ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'font-bold bg-white text-sky-500 hover:bg-sky-50 cursor-pointer');
            if (!disabled) button.onclick = () => { state.page = target; renderDipTable(key); };
            pagination.appendChild(button);
        };
        addButton('‹', state.page - 1, state.page === 1);
        const visiblePages = new Set([1, pages]);
        for (let page = Math.max(1, state.page - 2); page <= Math.min(pages, state.page + 2); page++) visiblePages.add(page);
        let previousPage = 0;
        [...visiblePages].sort((a, b) => a - b).forEach(page => {
            if (previousPage && page - previousPage > 1) {
                const dots = document.createElement('span');
                dots.className = 'px-3 py-2 text-sm font-bold text-slate-400';
                dots.innerText = '…';
                pagination.appendChild(dots);
            }
            addButton(String(page), page, page === state.page, page === state.page);
            previousPage = page;
        });
        addButton('›', state.page + 1, state.page === pages);
    }

    document.addEventListener('DOMContentLoaded', initClientSideDipTables);
</script>
