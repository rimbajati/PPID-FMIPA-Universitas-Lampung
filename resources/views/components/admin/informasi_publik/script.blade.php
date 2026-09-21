@props([
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => [],
    'listRincian' => []
])

<script>
    window.rincianByCategory = {
        'Informasi Berkala': {!! json_encode($listRincianBerkala) !!},
        'Informasi Setiap Saat': {!! json_encode($listRincianSetiapSaat) !!},
        'Informasi Serta-Merta': {!! json_encode($listRincianSertaMerta) !!},
        'all': {!! json_encode($listRincian) !!}
    };

    window.isSelectMode = false;

    window.toggleSelectMode = function() {
        window.isSelectMode = !window.isSelectMode;
        const isSelectMode = window.isSelectMode;
        const colHeader = document.getElementById('col-checkbox-header');
        const colCells = document.querySelectorAll('.col-checkbox-cell');
        const toggleBtn = document.getElementById('btn-toggle-select');
        const textSelectMode = document.getElementById('text-select-mode');
        const checkAll = document.getElementById('check-all');

        if (colHeader) colHeader.classList.toggle('hidden', !isSelectMode);
        colCells.forEach(cell => cell.classList.toggle('hidden', !isSelectMode));

        if (isSelectMode) {
            toggleBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
            toggleBtn.classList.add('bg-rose-50', 'text-rose-600', 'border-rose-300');
            textSelectMode.innerText = 'Batal';
        } else {
            toggleBtn.classList.remove('bg-rose-50', 'text-rose-600', 'border-rose-300');
            toggleBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
            textSelectMode.innerText = 'Hapus';
            
            if (checkAll) checkAll.checked = false;
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = false);
            window.updateBulkState();
        }

        if (typeof renderClientSideAdminDipTable === 'function') {
            renderClientSideAdminDipTable();
        }
    };

    window.toggleCheckAll = function(master) {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => cb.checked = master.checked);
        window.updateBulkState();
    };

    window.updateBulkState = function() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const selectedCount = document.getElementById('selected-count');
        const checkAll = document.getElementById('check-all');
        const totalItems = document.querySelectorAll('.item-checkbox').length;

        if (selectedCount) selectedCount.innerText = checkedCount;

        if (bulkBtn) {
            if (checkedCount > 0 && isSelectMode) {
                bulkBtn.classList.remove('hidden');
            } else {
                bulkBtn.classList.add('hidden');
            }
        }

        if (checkAll && totalItems > 0) {
            checkAll.checked = (checkedCount === totalItems);
        }
    }

    // Modal confirm delete & bulk delete sudah ditangani secara global di layout admin.blade.php
    function triggerBulkDelete() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        if (checkedCount === 0) return;
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus <b>' + checkedCount + '</b> informasi publik yang dipilih?';
        window.currentDeleteType = 'bulk';
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    function triggerDelete(url, title) {
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus informasi <b>"' + title + '"</b> ini?';
        window.currentDeleteType = 'single';
        window.currentDeleteUrl = url;
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    function handleFileChange(input) {
        const fileDisplayName = document.getElementById('fileDisplayName');
        const currentFileLink = document.getElementById('currentFileLink');
        
        if (input.files && input.files.length > 0) {
            if (currentFileLink) currentFileLink.classList.add('hidden');
            if (fileDisplayName) {
                fileDisplayName.textContent = input.files[0].name;
                fileDisplayName.classList.remove('hidden', 'text-slate-500');
                fileDisplayName.classList.add('text-slate-800', 'font-semibold');
            }
        } else {
            // Jika batal memilih file saat edit, kembalikan ke file saat ini bila ada
            const isEdit = document.getElementById('formMethod').value === 'PUT';
            const fileNameSpan = document.getElementById('currentFileName');
            if (isEdit && fileNameSpan && fileNameSpan.textContent.trim() !== '') {
                if (fileDisplayName) fileDisplayName.classList.add('hidden');
                if (currentFileLink) currentFileLink.classList.remove('hidden');
            } else {
                if (currentFileLink) currentFileLink.classList.add('hidden');
                if (fileDisplayName) {
                    fileDisplayName.textContent = 'No file chosen';
                    fileDisplayName.classList.remove('hidden', 'text-slate-800', 'font-semibold');
                    fileDisplayName.classList.add('text-slate-500');
                }
            }
        }
    }

    function openModalCreate() {
        openAddModal();
    }

    function addSubInfo(rincianName, jenisKategori) {
        openAddModal();
        if (jenisKategori && document.getElementById('inputJenisInformasi')) {
            document.getElementById('inputJenisInformasi').value = jenisKategori;
            handleJenisInformasiChange(jenisKategori);
        }
        if (rincianName && document.getElementById('inputRincianInformasi')) {
            document.getElementById('inputRincianInformasi').value = rincianName;
        }
        const judulEl = document.getElementById('inputJudul');
        if (judulEl) {
            judulEl.focus();
        }
    }

    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Informasi Publik';
        document.getElementById('modalSubtitle').innerText = 'Tambahkan dokumen informasi publik baru kedalam sistem';
        document.getElementById('formAddEdit').action = "{{ url('/admin/informasi-publik') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('formAddEdit').reset();
        
        // Reset file display
        const fileDisplayName = document.getElementById('fileDisplayName');
        const currentFileLink = document.getElementById('currentFileLink');
        const fileNameSpan = document.getElementById('currentFileName');
        if (fileNameSpan) fileNameSpan.textContent = '';
        if (currentFileLink) {
            currentFileLink.classList.add('hidden');
            currentFileLink.href = '#';
        }
        if (fileDisplayName) {
            fileDisplayName.textContent = 'No file chosen';
            fileDisplayName.classList.remove('hidden', 'text-slate-800', 'font-semibold');
            fileDisplayName.classList.add('text-slate-500');
        }

        const helpText = document.getElementById('fileHelpText');
        if (helpText) helpText.innerText = 'Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)';

        // Reset default 
        document.getElementById('inputTahun').value = '';
        if (document.getElementById('inputRetensiArsip')) document.getElementById('inputRetensiArsip').value = '';
        if (document.getElementById('inputRincianInformasi')) document.getElementById('inputRincianInformasi').value = '';
        if (document.getElementById('inputPejabatPenguasa')) document.getElementById('inputPejabatPenguasa').value = '';
        // Pre-fill kategori jika sedang filter kategori
        const urlParamsAdd = new URLSearchParams(window.location.search);
        const currentKat = urlParamsAdd.get('kategori') || '';
        if (document.getElementById('inputJenisInformasi')) {
            document.getElementById('inputJenisInformasi').value = currentKat;
            handleJenisInformasiChange(currentKat);
        }
        if (document.getElementById('inputBentukInformasi')) {
            document.getElementById('inputBentukInformasi').value = 'Cetak dan Online';
            handleBentukInformasiChange('Cetak dan Online');
        }

        if (document.getElementById('inputSubInformasi')) document.getElementById('inputSubInformasi').value = '';
        if (document.getElementById('inputRingkasanIsi')) {
            document.getElementById('inputRingkasanIsi').value = '';
            document.getElementById('inputRingkasanIsi').dispatchEvent(new Event('input'));
        }

        toggleInputType('file');
        document.getElementById('modalAddEdit').classList.remove('hidden');
    }

    function handleJenisInformasiChange(kategori) {
        const modalBox = document.getElementById('modalAddEditBox');
        const sectionFields = document.getElementById('section-form-fields');
        const btnSubmit = document.getElementById('btnSubmitAddEdit');
        const datalist = document.getElementById('list-rincian-dynamic');

        const hasCategory = Boolean(kategori && kategori.trim() !== '');

        if (modalBox) {
            if (hasCategory) {
                modalBox.classList.remove('max-w-lg');
                modalBox.classList.add('max-w-6xl');
            } else {
                modalBox.classList.remove('max-w-6xl');
                modalBox.classList.add('max-w-lg');
            }
        }

        if (sectionFields) {
            sectionFields.classList.toggle('hidden', !hasCategory);
        }
        if (btnSubmit) {
            btnSubmit.classList.toggle('hidden', !hasCategory);
        }

        if (!datalist) return;

        // Kosongkan opsi sebelumnya
        datalist.innerHTML = '';

        if (!hasCategory) return;

        // Ambil opsi khusus untuk kategori yang dipilih
        const options = (window.rincianByCategory && window.rincianByCategory[kategori]) 
            ? window.rincianByCategory[kategori] 
            : [];

        // Buat elemen option baru hanya untuk kategori yang dipilih
        options.forEach(val => {
            if (val && val.trim() !== '') {
                const opt = document.createElement('option');
                opt.value = val;
                datalist.appendChild(opt);
            }
        });
    }

    function closeAddEditModal() {
        document.getElementById('modalAddEdit').classList.add('hidden');
    }

    function handleBentukInformasiChange(val) {
        const sectionAksesOnline = document.getElementById('sectionAksesOnline');
        const inputFile = document.getElementById('inputFile');
        const inputLink = document.getElementById('inputLink');

        if (val === 'Cetak') {
            if (sectionAksesOnline) sectionAksesOnline.classList.add('hidden');
            if (inputFile) inputFile.removeAttribute('required');
            if (inputLink) inputLink.removeAttribute('required');
        } else {
            // Untuk 'Cetak dan Online' maupun 'Online'
            if (sectionAksesOnline) sectionAksesOnline.classList.remove('hidden');
            const selectedType = document.querySelector('input[name="jenis_informasi_format"]:checked')?.value || 'file';
            toggleInputType(selectedType);
        }
    }

    function toggleInputType(type) {
        const containerFile = document.getElementById('containerFile');
        const containerLink = document.getElementById('containerLink');
        const inputFile = document.getElementById('inputFile');
        const inputLink = document.getElementById('inputLink');
        const fileRequiredStar = document.getElementById('fileRequiredStar');
        const isEdit = document.getElementById('formMethod').value === 'PUT';
        const bentukInfo = document.getElementById('inputBentukInformasi')?.value || 'Cetak dan Online';

        if (bentukInfo === 'Cetak') {
            if (inputFile) inputFile.removeAttribute('required');
            if (inputLink) inputLink.removeAttribute('required');
            return;
        }

        if (type === 'file') {
            containerFile.classList.remove('hidden');
            containerLink.classList.add('hidden');
            if (inputFile) inputFile.removeAttribute('required');
            if (inputLink) inputLink.removeAttribute('required');
        } else {
            containerFile.classList.add('hidden');
            containerLink.classList.remove('hidden');
            if (inputLink) inputLink.removeAttribute('required');
            if (inputFile) inputFile.removeAttribute('required');
        }
    }

    function editData(item) {

        document.getElementById('modalTitle').innerText = 'Edit Informasi Publik (DIP)';
        document.getElementById('modalSubtitle').innerText = 'Perbarui data informasi publik dibawah ini';
        document.getElementById('formAddEdit').action = "{{ url('/admin/informasi-publik') }}/" + item.id;
        document.getElementById('formMethod').value = 'PUT';

        let subVal = item.sub_informasi || item.ringkasan_isi_informasi || item.judul_informasi || '';
        if (subVal.trim() === 'Dokumen sedang dilengkapi unit') {
            subVal = '';
        }
        if (document.getElementById('inputSubInformasi')) {
            document.getElementById('inputSubInformasi').value = subVal;
        }

        let ringkasanVal = item.ringkasan_isi_informasi || '';
        if (ringkasanVal.trim() === 'Dokumen sedang dilengkapi unit') {
            ringkasanVal = '';
        }
        if (document.getElementById('inputRingkasanIsi')) {
            document.getElementById('inputRingkasanIsi').value = ringkasanVal;
            document.getElementById('inputRingkasanIsi').dispatchEvent(new Event('input'));
        }

        document.getElementById('inputJenisInformasi').value = item.jenis_informasi || '';
        handleJenisInformasiChange(item.jenis_informasi || '');
        document.getElementById('inputTahun').value = item.waktu_pembuatan_informasi || item.tahun_terbit || '';
        if (document.getElementById('inputRetensiArsip')) {
            document.getElementById('inputRetensiArsip').value = item.retensi_arsip || '';
        }
        if (document.getElementById('inputRincianInformasi')) {
            document.getElementById('inputRincianInformasi').value = item.rincian_informasi || '';
        }
        if (document.getElementById('inputPejabatPenguasa')) {
            document.getElementById('inputPejabatPenguasa').value = item.pejabat_unit_yang_menguasai_informasi || item.pejabat_unit_yang_menguasai || item.pejabat_penguasa || '';
        }
        if (document.getElementById('inputPenanggungJawab')) {
            document.getElementById('inputPenanggungJawab').value = item.penanggung_jawab_pembuatan_informasi || '';
        }
        if (document.getElementById('inputBentukInformasi')) {
            let bentukVal = item.bentuk_informasi_yang_tersedia || item.bentuk_informasi || 'Cetak dan Online';
            if (bentukVal === 'Cetak/Online') bentukVal = 'Cetak dan Online';
            if (bentukVal === '-') bentukVal = 'Cetak dan Online';
            document.getElementById('inputBentukInformasi').value = bentukVal;
            handleBentukInformasiChange(bentukVal);
        }

        const fileDisplayName = document.getElementById('fileDisplayName');
        const fileNameSpan = document.getElementById('currentFileName');
        const fileLink = document.getElementById('currentFileLink');
        const helpText = document.getElementById('fileHelpText');

        if (item.link_informasi && !item.file_informasi) {
            document.querySelector('input[name="jenis_informasi_format"][value="link"]').checked = true;
            toggleInputType('link');
            document.getElementById('inputLink').value = item.link_informasi || '';
            if (fileDisplayName) {
                fileDisplayName.textContent = 'No file chosen';
                fileDisplayName.classList.remove('hidden', 'text-slate-800', 'font-semibold');
                fileDisplayName.classList.add('text-slate-500');
            }
            if (fileLink) fileLink.classList.add('hidden');
            if (helpText) helpText.innerText = 'Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)';
        } else {
            document.querySelector('input[name="jenis_informasi_format"][value="file"]').checked = true;
            toggleInputType('file');

            if (item.file_informasi) {
                const displayName = item.nama_file_asli || item.file_informasi.split('/').pop();
                if (fileNameSpan) fileNameSpan.innerText = displayName;
                if (fileLink) {
                    fileLink.href = "{{ url('/informasi/file') }}/" + item.id + "/" + encodeURIComponent(displayName) + "?from_admin=1";
                    fileLink.classList.remove('hidden');
                }
                if (fileDisplayName) fileDisplayName.classList.add('hidden');
                if (helpText) helpText.innerText = 'Pilih file baru jika ingin mengganti file saat ini. Biarkan kosong jika tidak ingin mengubah file.';
            } else {
                if (fileLink) fileLink.classList.add('hidden');
                if (fileDisplayName) {
                    fileDisplayName.textContent = 'No file chosen';
                    fileDisplayName.classList.remove('hidden', 'text-slate-800', 'font-semibold');
                    fileDisplayName.classList.add('text-slate-500');
                }
                if (helpText) helpText.innerText = 'Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)';
            }
        }

        document.getElementById('modalAddEdit').classList.remove('hidden');

        // Dispatch input event for char counter
        document.getElementById('inputJudul').dispatchEvent(new Event('input'));
    }

    function handleFormSubmit(event) {
        // Form submitted normally
        return true;
    }

    function submitFilterForm() {
        const form = document.getElementById('filter-search-form');
        if (form) form.submit();
    }

    function updatePdfExportLink(tahun) {
        const btn = document.getElementById('btnCetakPdfDirect');
        if (!btn) return;
        let url = "{{ route('admin.export.informasi.pdf') }}";
        if (tahun) {
            url += '?tahun=' + encodeURIComponent(tahun);
        }
        btn.href = url;
    }

    // =========================================================================
    // PURE CLIENT-SIDE DATATABLES ENGINE ADMIN (0ms Instant Search & Filter)
    // =========================================================================
    let adminDipAllRows = [];
    let adminDipFilteredRows = [];
    let adminDipCurrentPage = 1;
    let adminDipPerPage = 10;
    let adminDipSortColumn = null;
    let adminDipSortDirection = 'asc';

    function initClientSideAdminDipTable() {
        const tbody = document.getElementById('table-admin-dip-body');
        const containerSertaMerta = document.getElementById('container-admin-serta-merta');
        if (!tbody && !containerSertaMerta) return;

        const urlParams = new URLSearchParams(window.location.search);
        const searchVal = urlParams.get('search') || '';
        const perPageVal = parseInt(urlParams.get('per_page')) || 10;
        const sortByVal = urlParams.get('sort_by') || null;
        const sortDirVal = urlParams.get('sort_direction') || 'asc';

        adminDipPerPage = [10, 25, 50, 100].includes(perPageVal) ? perPageVal : 10;
        adminDipSortColumn = sortByVal;
        adminDipSortDirection = sortDirVal;

        const perPageSelect = document.getElementById('select-per-page-admin-dip');
        if (perPageSelect) perPageSelect.value = adminDipPerPage;

        const searchInput = document.getElementById('input-search-admin-dip');
        if (searchInput && searchVal) searchInput.value = searchVal;

        if (containerSertaMerta) {
            const rawCards = Array.from(containerSertaMerta.querySelectorAll('.card-admin-serta-merta'));
            if (rawCards.length === 0) return;

            adminDipAllRows = rawCards.map((card, index) => {
                return {
                    element: card,
                    originalIndex: index + 1,
                    no: index + 1,
                    dilihat: parseInt(card.getAttribute('data-dilihat')) || 0,
                    rincian: card.getAttribute('data-rincian') || '',
                    sub_informasi: card.getAttribute('data-sub_informasi') || '',
                    ringkasan: card.getAttribute('data-ringkasan') || '',
                    pejabat: card.getAttribute('data-pejabat') || '',
                    penanggung_jawab: card.getAttribute('data-penanggung_jawab') || '',
                    waktu: card.getAttribute('data-waktu') || '',
                    retensi: card.getAttribute('data-retensi') || '',
                    bentuk: card.getAttribute('data-bentuk') || '',
                    fullText: card.innerText.toLowerCase()
                };
            });
        } else if (tbody) {
            const rawRows = Array.from(tbody.querySelectorAll('.table-admin-dip-row'));
            if (rawRows.length === 0) return;

            adminDipAllRows = rawRows.map((tr, index) => {
                return {
                    element: tr,
                    originalIndex: index + 1,
                    no: index + 1,
                    dilihat: parseInt(tr.getAttribute('data-dilihat')) || 0,
                    rincian: tr.getAttribute('data-rincian') || '',
                    sub_informasi: tr.getAttribute('data-sub_informasi') || '',
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
        }

        updateSortAdminDipIconsUI();
        applyClientSideAdminDipFilter();
    }

    function debounceSearchAdminDip() {
        const input = document.getElementById('input-search-admin-dip');
        const clearBtn = document.getElementById('btn-clear-search-admin-dip');
        if (!input) return;

        const query = input.value.trim();
        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        adminDipCurrentPage = 1;
        applyClientSideAdminDipFilter();
    }

    function clearSearchAdminDip() {
        const input = document.getElementById('input-search-admin-dip');
        const clearBtn = document.getElementById('btn-clear-search-admin-dip');
        if (input) {
            input.value = '';
            input.focus();
        }
        if (clearBtn) {
            clearBtn.classList.add('hidden');
        }
        adminDipCurrentPage = 1;
        applyClientSideAdminDipFilter();
    }

    function changePerPageAdminDip(val) {
        adminDipPerPage = parseInt(val) || 10;
        adminDipCurrentPage = 1;
        applyClientSideAdminDipFilter();
    }

    function sortAdminDipTable(column) {
        if (adminDipSortColumn === column) {
            if (adminDipSortDirection === 'asc') {
                adminDipSortDirection = 'desc';
            } else {
                adminDipSortColumn = null;
                adminDipSortDirection = 'asc';
            }
        } else {
            adminDipSortColumn = column;
            adminDipSortDirection = 'asc';
        }

        updateSortAdminDipIconsUI();
        applyClientSideAdminDipFilter();
    }

    function updateSortAdminDipIconsUI() {
        const headers = document.querySelectorAll('th[onclick*="sortAdminDipTable"]');
        headers.forEach(th => {
            const colName = th.getAttribute('onclick').match(/'(.*)'/)?.[1];
            const iconSpan = th.querySelector('span:last-child');
            if (!iconSpan) return;

            if (colName === adminDipSortColumn) {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white transition';
                iconSpan.innerHTML = adminDipSortDirection === 'desc' 
                    ? '<i class="fa-solid fa-sort-down"></i>' 
                    : '<i class="fa-solid fa-sort-up"></i>';
            } else {
                iconSpan.className = 'inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition';
                iconSpan.innerHTML = '<i class="fa-solid fa-sort"></i>';
            }
        });
    }

    function applyClientSideAdminDipFilter() {
        const input = document.getElementById('input-search-admin-dip');
        const query = input ? input.value.trim().toLowerCase() : '';

        // 1. Filtering
        if (!query) {
            adminDipFilteredRows = [...adminDipAllRows];
        } else {
            adminDipFilteredRows = adminDipAllRows.filter(row => row.fullText.includes(query));
        }

        // 2. Sorting
        if (adminDipSortColumn) {
            adminDipFilteredRows.sort((a, b) => {
                let valA, valB;
                if (adminDipSortColumn === 'no') {
                    valA = a.originalIndex;
                    valB = b.originalIndex;
                    return adminDipSortDirection === 'asc' ? valA - valB : valB - valA;
                } else if (adminDipSortColumn === 'dilihat') {
                    valA = a.dilihat || 0;
                    valB = b.dilihat || 0;
                    return adminDipSortDirection === 'asc' ? valA - valB : valB - valA;
                } else {
                    valA = a[adminDipSortColumn] || '';
                    valB = b[adminDipSortColumn] || '';
                    const cmp = valA.localeCompare(valB, 'id', { numeric: true, sensitivity: 'base' });
                    return adminDipSortDirection === 'asc' ? cmp : -cmp;
                }
            });
        } else {
            adminDipFilteredRows.sort((a, b) => a.originalIndex - b.originalIndex);
        }

        // 3. Render tabel dan kontrol paginasi
        renderClientSideAdminDipTable();

        // 4. Update URL tanpa reload
        const url = new URL(window.location.href);
        if (query) url.searchParams.set('search', query); else url.searchParams.delete('search');
        if (adminDipPerPage !== 10) url.searchParams.set('per_page', adminDipPerPage); else url.searchParams.delete('per_page');
        if (adminDipSortColumn) {
            url.searchParams.set('sort_by', adminDipSortColumn);
            url.searchParams.set('sort_direction', adminDipSortDirection);
        } else {
            url.searchParams.delete('sort_by');
            url.searchParams.delete('sort_direction');
        }
        window.history.replaceState({}, '', url.toString());

        // 5. Update link tombol Export PDF dan Export Excel agar mengikuti filter dan sorting saat ini
        updateExportLinks(query, adminDipSortColumn, adminDipSortDirection);
    }

    function updateExportLinks(query, sortBy, sortDir) {
        const btnPdf = document.getElementById('btn-export-pdf');
        const btnExcel = document.getElementById('btn-export-excel');

        [btnPdf, btnExcel].forEach(btn => {
            if (!btn) return;
            try {
                const targetUrl = new URL(btn.href, window.location.origin);
                if (query) targetUrl.searchParams.set('search', query); else targetUrl.searchParams.delete('search');
                if (sortBy) {
                    targetUrl.searchParams.set('sort_by', sortBy);
                    targetUrl.searchParams.set('sort_direction', sortDir || 'asc');
                } else {
                    targetUrl.searchParams.delete('sort_by');
                    targetUrl.searchParams.delete('sort_direction');
                }
                btn.href = targetUrl.toString();
            } catch (e) {}
        });
    }

    function renderClientSideAdminDipTable() {
        const tbody = document.getElementById('table-admin-dip-body');
        const containerSertaMerta = document.getElementById('container-admin-serta-merta');
        const infoEl = document.getElementById('table-admin-dip-info');
        const paginEl = document.getElementById('table-admin-dip-pagination');
        if (!tbody && !containerSertaMerta) return;

        const totalItems = adminDipFilteredRows.length;
        const totalPages = Math.ceil(totalItems / adminDipPerPage) || 1;

        if (adminDipCurrentPage > totalPages) adminDipCurrentPage = totalPages;
        if (adminDipCurrentPage < 1) adminDipCurrentPage = 1;

        const startIndex = (adminDipCurrentPage - 1) * adminDipPerPage;
        const endIndex = Math.min(startIndex + adminDipPerPage, totalItems);

        if (containerSertaMerta) {
            containerSertaMerta.innerHTML = '';

            if (totalItems === 0) {
                containerSertaMerta.innerHTML = `<div class="p-12 text-center text-slate-400 font-semibold bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">Tidak ada Informasi Serta-Merta yang sesuai.</div>`;
                if (infoEl) infoEl.innerText = 'Menampilkan 0 sampai 0 dari 0 entri';
                if (paginEl) paginEl.innerHTML = '';
                window.updateBulkState();
                return;
            }

            const pageRows = adminDipFilteredRows.slice(startIndex, endIndex);
            pageRows.forEach((row, i) => {
                const card = row.element;
                const cbCell = card.querySelector('.col-checkbox-cell');
                if (cbCell) cbCell.classList.toggle('hidden', !window.isSelectMode);
                containerSertaMerta.appendChild(card);
            });
        } else if (tbody) {
            tbody.innerHTML = '';

            const isKatMode = new URLSearchParams(window.location.search).has('kategori') || {{ request()->filled('kategori') ? 'true' : 'false' }};

            if (totalItems === 0) {
                const colspan = isKatMode ? '4' : '9';
                tbody.innerHTML = `<tr><td colspan="${colspan}" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data Informasi Publik yang sesuai.</td></tr>`;
                if (infoEl) infoEl.innerText = 'Menampilkan 0 sampai 0 dari 0 entri';
                if (paginEl) paginEl.innerHTML = '';
                window.updateBulkState();
                return;
            }

            const pageRows = adminDipFilteredRows.slice(startIndex, endIndex);

            if (isKatMode) {
                // Dynamic rowspan merging pada mode kategori (Berkala & Setiap Saat)
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
                        const noCell = tr.querySelector('.col-admin-dip-no');
                        if (noCell) {
                            noCell.innerText = startIndex + (i + k) + 1;
                        }

                        // Sinkronkan visibility checkbox mode pilih
                        const cbCell = tr.querySelector('.col-checkbox-cell');
                        if (cbCell) cbCell.classList.toggle('hidden', !window.isSelectMode);

                        const rincianTd = tr.querySelector('.col-admin-rincian');
                        if (rincianTd) {
                            if (k === 0) {
                                rincianTd.style.display = '';
                                rincianTd.setAttribute('rowspan', span);
                            } else {
                                rincianTd.style.display = 'none';
                            }
                        }
                        tbody.appendChild(tr);
                    }

                    i += span;
                }
            } else {
                // Mode Matriks Lengkap (Full DIP)
                pageRows.forEach((row, i) => {
                    const tr = row.element;
                    const noCell = tr.querySelector('.col-admin-dip-no');
                    if (noCell) {
                        noCell.innerText = startIndex + i + 1;
                    }

                    // Sinkronkan visibility checkbox mode pilih
                    const cbCell = tr.querySelector('.col-checkbox-cell');
                    if (cbCell) cbCell.classList.toggle('hidden', !window.isSelectMode);

                    tbody.appendChild(tr);
                });
            }
        }

        // Teks info entri
        if (infoEl) {
            infoEl.innerText = `Menampilkan ${startIndex + 1} sampai ${endIndex} dari ${totalItems} entri`;
        }

        // Paginasi buttons
        if (paginEl) {
            paginEl.innerHTML = '';

            // Previous
            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.innerHTML = '‹';
            prevBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (adminDipCurrentPage === 1 ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            prevBtn.onclick = () => { if (adminDipCurrentPage > 1) { adminDipCurrentPage--; renderClientSideAdminDipTable(); } };
            paginEl.appendChild(prevBtn);

            // Pages
            for (let p = 1; p <= totalPages; p++) {
                if (totalPages > 7 && Math.abs(p - adminDipCurrentPage) > 2 && p !== 1 && p !== totalPages) {
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
                    (p === adminDipCurrentPage ? 'font-extrabold bg-sky-500 text-white shadow-2xs' : 'font-bold bg-white text-sky-500 hover:bg-sky-50');
                pageBtn.onclick = () => { adminDipCurrentPage = p; renderClientSideAdminDipTable(); };
                paginEl.appendChild(pageBtn);
            }

            // Next
            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.innerHTML = '›';
            nextBtn.className = 'px-3.5 py-2 text-xs font-bold transition flex items-center justify-center ' + 
                (adminDipCurrentPage === totalPages ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'text-sky-500 hover:bg-sky-50 cursor-pointer');
            nextBtn.onclick = () => { if (adminDipCurrentPage < totalPages) { adminDipCurrentPage++; renderClientSideAdminDipTable(); } };
            paginEl.appendChild(nextBtn);
        }

        window.updateBulkState();
    }

    document.addEventListener('DOMContentLoaded', function() {
        initClientSideAdminDipTable();
    });
</script>
