<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => [],
    'listRincian' => [],
    'listSubByRincian' => []
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => [],
    'listRincian' => [],
    'listSubByRincian' => []
]); ?>
<?php foreach (array_filter(([
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => [],
    'listRincian' => [],
    'listSubByRincian' => []
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<script>
    window.rincianByCategory = {
        'Informasi Berkala': <?php echo json_encode($listRincianBerkala); ?>,
        'Informasi Setiap Saat': <?php echo json_encode($listRincianSetiapSaat); ?>,
        'Informasi Serta-Merta': <?php echo json_encode($listRincianSertaMerta); ?>,
        'all': <?php echo json_encode($listRincian); ?>

    };

    // Map: rincian_informasi => [sub_informasi, ...] untuk dropdown dinamis sub informasi
    window.subByRincian = <?php echo json_encode($listSubByRincian); ?>;

    // Perbarui datalist sub informasi berdasarkan nilai rincian yang dipilih
    window.updateSubInformasiDatalist = function(rincianVal) {
        const datalist = document.getElementById('list-sub-informasi-history');
        if (!datalist) return;
        datalist.innerHTML = '';
        const rincian = (rincianVal || '').trim();
        if (!rincian) return;
        const options = (window.subByRincian && window.subByRincian[rincian]) ? window.subByRincian[rincian] : [];
        options.forEach(val => {
            if (val && val.trim() !== '') {
                const opt = document.createElement('option');
                opt.value = val;
                datalist.appendChild(opt);
            }
        });
    };

    window.isSelectMode = false;

    function getAdminDipCheckboxes() {
        const checkboxes = new Map();
        document.querySelectorAll('.item-checkbox').forEach(input => checkboxes.set(input.value, input));
        if (typeof adminDipTables !== 'undefined') {
            adminDipTables.forEach(state => state.rows.forEach(row => {
                const input = row.element.querySelector('.item-checkbox');
                if (input) checkboxes.set(input.value, input);
            }));
        }
        return [...checkboxes.values()];
    }

    window.toggleSelectMode = function() {
        window.isSelectMode = !window.isSelectMode;
        const isSelectMode = window.isSelectMode;
        const colHeaders = document.querySelectorAll('.col-checkbox-header');
        const colCells = document.querySelectorAll('.col-checkbox-cell');
        const toggleBtn = document.getElementById('btn-toggle-select');
        const textSelectMode = document.getElementById('text-select-mode');
        const checkAll = document.querySelectorAll('.check-all');

        colHeaders.forEach(header => header.classList.toggle('hidden', !isSelectMode));
        colCells.forEach(cell => cell.classList.toggle('hidden', !isSelectMode));

        if (isSelectMode) {
            toggleBtn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
            toggleBtn.classList.add('bg-rose-50', 'text-rose-600', 'border-rose-300');
            textSelectMode.innerText = 'Batal';
        } else {
            toggleBtn.classList.remove('bg-rose-50', 'text-rose-600', 'border-rose-300');
            toggleBtn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
            textSelectMode.innerText = 'Hapus';
            
            checkAll.forEach(input => input.checked = false);
            getAdminDipCheckboxes().forEach(cb => cb.checked = false);
            window.updateBulkState();
        }

        if (typeof renderClientSideAdminDipTable === 'function') {
            renderClientSideAdminDipTable();
        }
    };

    window.toggleCheckAll = function(master) {
        const checkboxes = getAdminDipCheckboxes();
        checkboxes.forEach(cb => cb.checked = master.checked);
        document.querySelectorAll('.check-all').forEach(input => input.checked = master.checked);
        window.updateBulkState();
    };

    window.updateBulkState = function() {
        const checkboxes = getAdminDipCheckboxes();
        const selected = checkboxes.filter(input => input.checked);
        const checkedCount = selected.length;
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const selectedCount = document.getElementById('selected-count');
        const checkAll = document.querySelectorAll('.check-all');
        const totalItems = checkboxes.length;

        if (selectedCount) selectedCount.innerText = checkedCount;

        if (bulkBtn) {
            if (checkedCount > 0 && isSelectMode) {
                bulkBtn.classList.remove('hidden');
            } else {
                bulkBtn.classList.add('hidden');
            }
        }

        checkAll.forEach(input => input.checked = totalItems > 0 && checkedCount === totalItems);
        const selectedInputs = document.getElementById('bulk-selected-inputs');
        if (selectedInputs) {
            selectedInputs.innerHTML = '';
            selected.forEach(input => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'ids[]';
                hidden.value = input.value;
                selectedInputs.appendChild(hidden);
            });
        }
    }

    // Modal confirm delete & bulk delete sudah ditangani secara global di layout admin.blade.php
    function triggerBulkDelete() {
        const checkedCount = getAdminDipCheckboxes().filter(input => input.checked).length;
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

    function triggerDeleteRincian(rincianTitle, jenisKategori) {
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus Rincian Informasi <b>"' + rincianTitle + '"</b> beserta seluruh isi dokumen di dalamnya?';
        window.currentDeleteType = 'rincian';
        window.currentDeleteRincianData = { rincian: rincianTitle, jenis: jenisKategori };
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    function handleFileChange(input) {
        // Now handled by Alpine; keep compat so onChange legacy tidak error
        if (input.files && input.files[0]) {
            const disp = document.getElementById('fileDisplayName');
            if (disp) disp.textContent = input.files[0].name;
        }
    }

    function openModalCreate() {
        openAddModal();
    }

    function addSubInfo(itemJson) {
        const subVal = (itemJson.sub_informasi || '').trim();
        const isPending = !subVal || subVal === 'Dokumen sedang dilengkapi unit';

        if (isPending) {
            // Record masih placeholder → UPDATE record yang ada (isi sub informasinya)
            editData(itemJson);
            // Kosongkan field Sub Informasi agar admin bisa langsung mengisi
            const subEl = document.getElementById('inputSubInformasi');
            if (subEl) {
                subEl.value = '';
                subEl.focus();
            }
        } else {
            // Record sudah terisi → Buka form TAMBAH BARU dengan jenis & rincian yang sama
            openAddModal();
            // Pre-fill jenis dan rincian informasi
            const jenisEl = document.getElementById('inputJenisInformasi');
            const rincianEl = document.getElementById('inputRincianInformasi');
            if (jenisEl) {
                jenisEl.value = itemJson.jenis_informasi || '';
                handleJenisInformasiChange(jenisEl.value);
            }
            if (rincianEl) {
                rincianEl.value = itemJson.rincian_informasi || '';
            }
            // Langsung tampilkan form lengkap agar admin bisa mengisi sub informasi
            setTimeout(() => {
                toggleSubDetailFields(true);
                const subEl = document.getElementById('inputSubInformasi');
                if (subEl) subEl.focus();
            }, 50);
        }
    }

    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Informasi Publik';
        document.getElementById('modalSubtitle').innerText = 'Tambahkan informasi publik baru ke dalam sistem';
        document.getElementById('formAddEdit').action = "<?php echo e(url('/admin/informasi-publik')); ?>";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('formAddEdit').reset();
        
        // Reset Alpine file state + hidden compat
        (() => {
            const root = document.getElementById('sectionAksesOnline');
            if (root && root._x_dataStack && root._x_dataStack[0]) {
                const d = root._x_dataStack[0];
                d.fileName=''; d.fileSize=''; if(d.fileUrl) URL.revokeObjectURL(d.fileUrl); d.fileUrl=''; d.tipe='file';
            }
            const fileNameSpan = document.getElementById('currentFileName');
            const currentFileLink = document.getElementById('currentFileLink');
            if (fileNameSpan) fileNameSpan.textContent = '';
            if (currentFileLink) { currentFileLink.classList.add('hidden'); currentFileLink.href='#'; }
        })();

        const helpText = document.getElementById('fileHelpText');
        if (helpText) helpText.innerText = 'Format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Maksimal 5 MB)';

        // Reset default inputs
        if (document.getElementById('inputSubInformasi')) document.getElementById('inputSubInformasi').value = '';
        if (document.getElementById('inputRincianInformasi')) document.getElementById('inputRincianInformasi').value = '';
        if (document.getElementById('inputPejabatPenguasa')) document.getElementById('inputPejabatPenguasa').value = '';
        if (document.getElementById('inputTahun')) document.getElementById('inputTahun').value = '';
        if (document.getElementById('inputRetensiArsip')) document.getElementById('inputRetensiArsip').value = '';
        if (document.getElementById('inputLink')) document.getElementById('inputLink').value = '';
        if (document.getElementById('inputFile')) document.getElementById('inputFile').value = '';

        // Tampilkan seluruh form sejak modal tambah dibuka.
        toggleSubDetailFields(true);

        // Pre-fill kategori jika sedang filter kategori
        const urlParamsAdd = new URLSearchParams(window.location.search);
        const currentKat = urlParamsAdd.get('kategori') || '';
        if (document.getElementById('inputJenisInformasi')) {
            document.getElementById('inputJenisInformasi').value = currentKat;
            handleJenisInformasiChange(currentKat);
        } else {
            handleJenisInformasiChange('');
        }

        if (document.getElementById('inputBentukInformasi')) {
            document.getElementById('inputBentukInformasi').value = 'Cetak dan Online';
            handleBentukInformasiChange('Cetak dan Online');
        }

        toggleInputType('file');
        document.getElementById('modalAddEdit').classList.remove('hidden');
    }

    window.toggleSubDetailFields = function() {
        const sectionFields = document.getElementById('section-form-fields');
        const btnSubmit = document.getElementById('btnSubmitAddEdit');
        if (!sectionFields) return;
        sectionFields.classList.remove('hidden');
        document.getElementById('inputSubInformasi')?.setAttribute('required', 'required');
        document.getElementById('inputPejabatPenguasa')?.setAttribute('required', 'required');
        document.getElementById('inputTahun')?.setAttribute('required', 'required');
        document.getElementById('inputRetensiArsip')?.setAttribute('required', 'required');
        btnSubmit?.classList.remove('hidden');
    };

    function handleJenisInformasiChange(kategori) {
        const sectionRincian = document.getElementById('section-rincian-field');
        const datalist = document.getElementById('list-rincian-dynamic');
        const hasCategory = Boolean(kategori && kategori.trim() !== '');
        const isSertaMerta = kategori === 'Informasi Serta-Merta';
        const rincianInput = document.getElementById('inputRincianInformasi');
        const subLabel = document.getElementById('labelSubInformasi');

        // Serta-Merta adalah satu pengumuman langsung, bukan kelompok rincian/subinformasi.
        sectionRincian?.classList.toggle('hidden', isSertaMerta);
        if (subLabel) subLabel.textContent = isSertaMerta ? 'Informasi' : 'Sub Informasi';
        if (rincianInput) {
            if (isSertaMerta) {
                rincianInput.value = 'Pengumuman Serta-Merta';
                rincianInput.removeAttribute('required');
            } else {
                if (rincianInput.value === 'Pengumuman Serta-Merta') rincianInput.value = '';
                rincianInput.setAttribute('required', 'required');
            }
        }

        toggleSubDetailFields(true);

        // Reset datalist sub informasi saat kategori berubah
        updateSubInformasiDatalist('');

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

        // Pasang listener oninput pada inputRincianInformasi untuk update datalist sub informasi
        if (rincianInput && !rincianInput._subDatalistListenerAdded) {
            rincianInput.addEventListener('input', function() {
                updateSubInformasiDatalist(this.value);
            });
            rincianInput.addEventListener('change', function() {
                updateSubInformasiDatalist(this.value);
            });
            rincianInput._subDatalistListenerAdded = true;
        }
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

    // Sumber Berkas now x-data controlled (tipe File/Tautan); keep no-op for legacy callers + sync hidden ids for compat
    window.toggleInputType = function(type) {
        // Alpine x-data drives UI; just keep required attrs safe
        const inputFile = document.getElementById('inputFile');
        const inputLink = document.getElementById('inputLink');
        const bentukInfo = document.getElementById('inputBentukInformasi')?.value || 'Cetak dan Online';
        if (bentukInfo === 'Cetak') {
            if (inputFile) inputFile.removeAttribute('required');
            if (inputLink) inputLink.removeAttribute('required');
            return;
        }
        if (inputFile) inputFile.removeAttribute('required');
        if (inputLink) inputLink.removeAttribute('required');
    };

    function editData(item) {

        document.getElementById('modalTitle').innerText = 'Edit Informasi Publik';
        document.getElementById('modalSubtitle').innerText = 'Perbarui data informasi publik dibawah ini';
        document.getElementById('formAddEdit').action = "<?php echo e(url('/admin/informasi-publik')); ?>/" + item.id;
        document.getElementById('formMethod').value = 'PUT';

        let subVal = item.sub_informasi || item.judul_informasi || '';
        if (subVal.trim() === 'Dokumen sedang dilengkapi unit') {
            subVal = '';
        }
        if (document.getElementById('inputSubInformasi')) {
            document.getElementById('inputSubInformasi').value = subVal;
        }

        document.getElementById('inputJenisInformasi').value = item.jenis_informasi || '';
        handleJenisInformasiChange(item.jenis_informasi || '');
        document.getElementById('inputTahun').value = item.waktu_pembuatan_informasi || item.tahun_terbit || '';
        if (document.getElementById('inputRetensiArsip')) {
            document.getElementById('inputRetensiArsip').value = item.retensi_arsip || '';
        }
        if (document.getElementById('inputRincianInformasi')) {
            document.getElementById('inputRincianInformasi').value = item.jenis_informasi === 'Informasi Serta-Merta'
                ? 'Pengumuman Serta-Merta'
                : (item.rincian_informasi || '');
            // Update datalist sub informasi sesuai rincian yang sudah terpilih
            updateSubInformasiDatalist(item.rincian_informasi || '');
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

        // sync Alpine tipe + preview file for Edit
        const root = document.getElementById('sectionAksesOnline');
        const alpine = root && root._x_dataStack ? root._x_dataStack[0] : null;
        const setAlpineFile = (name, url) => {
            if (!alpine) return;
            alpine.fileName = name || '';
            alpine.fileUrl = url || '';
            alpine.fileSize = '';
        };

        if (item.link_informasi && !item.file_informasi) {
            if (alpine) alpine.tipe = 'link';
            window.toggleInputType('link');
            document.getElementById('inputLink').value = item.link_informasi || '';
            setAlpineFile('', '');
            if (fileDisplayName) fileDisplayName.textContent = '';
            if (fileLink) fileLink.classList.add('hidden');
            if (helpText) helpText.innerText = 'Format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Maksimal 5 MB)';
        } else {
            if (alpine) alpine.tipe = 'file';
            window.toggleInputType('file');

            if (item.file_informasi) {
                const displayName = item.nama_file_asli || item.file_informasi.split('/').pop();
                const fileUrl = "<?php echo e(url('/informasi/file')); ?>/" + item.id + "/" + encodeURIComponent(displayName) + "?from_admin=1";
                setAlpineFile(displayName, fileUrl);
                if (fileNameSpan) fileNameSpan.innerText = displayName;
                if (fileLink) {
                    fileLink.href = fileUrl;
                    fileLink.classList.remove('hidden');
                }
                if (fileDisplayName) fileDisplayName.textContent = displayName;
                if (helpText) helpText.innerText = 'Pilih file baru jika ingin mengganti file saat ini. Biarkan kosong jika tidak ingin mengubah file.';
            } else {
                setAlpineFile('', '');
                if (fileLink) fileLink.classList.add('hidden');
                if (fileDisplayName) fileDisplayName.textContent = '';
                if (helpText) helpText.innerText = 'Format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Maksimal 5 MB)';
            }
        }

        toggleSubDetailFields(true);
        document.getElementById('modalAddEdit').classList.remove('hidden');
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
        let url = "<?php echo e(route('admin.export.informasi.pdf')); ?>";
        if (tahun) {
            url += '?tahun=' + encodeURIComponent(tahun);
        }
        btn.href = url;
    }

    // =========================================================================
    const adminDipTables = new Map();

    function initClientSideAdminDipTable() {
        document.querySelectorAll('[data-admin-dip-tbody]').forEach(tbody => {
            const key = tbody.dataset.adminDipTbody;
            const rows = Array.from(tbody.querySelectorAll('.table-admin-dip-row'));
            const state = {
                tbody,
                rows: rows.map((element, index) => ({
                    element,
                    originalIndex: index + 1,
                    rincianCellTemplate: element.querySelector('.col-admin-rincian')?.cloneNode(true) || null,
                    dilihat: parseInt(element.dataset.dilihat, 10) || 0,
                    rincian: element.dataset.rincian || '',
                    sub_informasi: element.dataset.sub_informasi || '',
                    tanggal: parseInt(element.dataset.tanggal, 10) || 0,
                    ringkasan: element.dataset.ringkasan || '',
                    jenis: element.dataset.jenis || '',
                    pejabat: element.dataset.pejabat || '',
                    penanggung_jawab: element.dataset.penanggung_jawab || '',
                    waktu: element.dataset.waktu || '',
                    retensi: element.dataset.retensi || '',
                    bentuk: element.dataset.bentuk || '',
                    fullText: element.innerText.toLowerCase()
                })),
                filtered: [], page: 1, perPage: 10, sortColumn: null, sortDirection: 'asc'
            };
            const search = document.querySelector(`[data-admin-dip-search="${key}"]`);
            const term = search ? search.value.trim().toLowerCase() : '';
            state.filtered = term ? state.rows.filter(row => row.fullText.includes(term)) : [...state.rows];
            adminDipTables.set(key, state);
            renderAdminDipTable(key);
        });
    }

    function searchAdminDipTable(key, value) {
        const state = adminDipTables.get(key);
        if (!state) return;
        const term = value.trim().toLowerCase();
        state.filtered = term ? state.rows.filter(row => row.fullText.includes(term)) : [...state.rows];
        state.page = 1;
        renderAdminDipTable(key);
        updateExportLinks(term, state.sortColumn, state.sortDirection);
    }

    function changePerPageAdminDip(key, value) {
        const state = adminDipTables.get(key);
        if (!state) return;
        state.perPage = parseInt(value, 10) || 10;
        state.page = 1;
        renderAdminDipTable(key);
    }

    function sortAdminDipTable(key, column) {
        const state = adminDipTables.get(key);
        if (!state) return;
        if (state.sortColumn === column) {
            if (state.sortDirection === 'asc') state.sortDirection = 'desc';
            else { state.sortColumn = null; state.sortDirection = 'asc'; }
        } else {
            state.sortColumn = column;
            state.sortDirection = 'asc';
        }
        renderAdminDipTable(key);
        updateExportLinks('', state.sortColumn, state.sortDirection);
    }

    function updateExportLinks(query, sortBy, sortDir) {
        ['btn-export-pdf'].forEach(id => {
            const button = document.getElementById(id);
            if (!button) return;
            const target = new URL(button.href, window.location.origin);
            if (query) target.searchParams.set('search', query);
            else target.searchParams.delete('search');
            if (sortBy) {
                target.searchParams.set('sort_by', sortBy);
                target.searchParams.set('sort_direction', sortDir || 'asc');
            } else {
                target.searchParams.delete('sort_by');
                target.searchParams.delete('sort_direction');
            }
            button.href = target.toString();
        });
    }

    function renderClientSideAdminDipTable() {
        adminDipTables.forEach((_, key) => renderAdminDipTable(key));
    }

    function renderAdminDipTable(key) {
        const state = adminDipTables.get(key);
        if (!state) return;
        const { tbody, filtered } = state;
        const info = document.querySelector(`[data-admin-dip-info="${key}"]`);
        const pagination = document.querySelector(`[data-admin-dip-pagination="${key}"]`);
        const rows = [...filtered];
        const isCategoryTable = tbody.dataset.categoryTable === 'true';
        if (isCategoryTable) {
            // Keep equal rincian values together, while preserving the original group order.
            // This lets a newly added sub-information join its existing rincian group.
            const groupOrder = new Map();
            state.rows.forEach(row => {
                const groupKey = (row.rincian || '').trim();
                if (!groupOrder.has(groupKey)) groupOrder.set(groupKey, groupOrder.size);
            });
            rows.sort((a, b) => {
                const groupA = (a.rincian || '').trim();
                const groupB = (b.rincian || '').trim();
                let groupCompare = 0;
                if (state.sortColumn === 'rincian') {
                    groupCompare = groupA.localeCompare(groupB, 'id', { numeric: true, sensitivity: 'base' });
                    if (state.sortDirection === 'desc') groupCompare *= -1;
                } else {
                    groupCompare = (groupOrder.get(groupA) ?? 0) - (groupOrder.get(groupB) ?? 0);
                }
                if (groupCompare) return groupCompare;
                if (!state.sortColumn || state.sortColumn === 'rincian') return a.originalIndex - b.originalIndex;

                let result;
                if (state.sortColumn === 'no') result = a.originalIndex - b.originalIndex;
                else if (state.sortColumn === 'dilihat' || state.sortColumn === 'tanggal') result = a[state.sortColumn] - b[state.sortColumn];
                else result = (a[state.sortColumn] || '').localeCompare(b[state.sortColumn] || '', 'id', { numeric: true, sensitivity: 'base' });
                return (state.sortDirection === 'asc' ? result : -result) || (a.originalIndex - b.originalIndex);
            });
        } else if (state.sortColumn) {
            rows.sort((a, b) => {
                let result;
                if (state.sortColumn === 'no') result = a.originalIndex - b.originalIndex;
                else if (state.sortColumn === 'dilihat' || state.sortColumn === 'tanggal') result = a[state.sortColumn] - b[state.sortColumn];
                else result = (a[state.sortColumn] || '').localeCompare(b[state.sortColumn] || '', 'id', { numeric: true, sensitivity: 'base' });
                return state.sortDirection === 'asc' ? result : -result;
            });
        }
        tbody.closest('table')?.querySelectorAll('th[onclick*="sortAdminDipTable"]').forEach(th => {
            const column = th.getAttribute('onclick').match(/,\s*'([^']+)'/)?.[1];
            const icon = th.querySelector('span:last-child');
            if (!column || !icon) return;
            const active = column === state.sortColumn;
            icon.className = `inline-flex items-center justify-center text-xs md:text-sm ${active ? 'text-white' : 'text-white/70 group-hover:text-white'} transition`;
            icon.innerHTML = active ? (state.sortDirection === 'desc' ? '<i class="fa-solid fa-sort-down"></i>' : '<i class="fa-solid fa-sort-up"></i>') : '<i class="fa-solid fa-sort"></i>';
        });
        const total = rows.length;
        const totalPages = Math.ceil(total / state.perPage) || 1;
        state.page = Math.min(Math.max(state.page, 1), totalPages);
        const start = (state.page - 1) * state.perPage;
        const end = Math.min(start + state.perPage, total);
        tbody.innerHTML = '';
        if (!total) {
            const isCategoryMode = tbody.dataset.categoryMode === 'true';
            const isSertaMertaTable = tbody.dataset.sertaMertaTable === 'true';
            const emptyMessage = isCategoryMode ? 'Tidak ada data informasi untuk kategori ini.' : 'Tidak ada data Informasi Publik yang sesuai.';
            if (isSertaMertaTable) {
                tbody.innerHTML = `<div class="p-12 text-center text-slate-400 font-semibold border border-slate-200">${emptyMessage}</div>`;
                if (info) info.innerText = 'Menampilkan 0–0 dari 0 informasi';
                if (pagination) pagination.innerHTML = '';
                return;
            }
            const columnCount = isSertaMertaTable ? 3 : (isCategoryMode ? 4 : 9);
            tbody.innerHTML = `<tr><td colspan="${columnCount}" class="p-12 text-center text-slate-400 font-semibold">${emptyMessage}</td></tr>`;
            if (info) info.innerText = 'Menampilkan 0–0 dari 0 informasi';
            if (pagination) pagination.innerHTML = '';
            return;
        }
        const visibleRows = rows.slice(start, end);
        visibleRows.forEach(row => {
            const numberCell = row.element.querySelector('.col-admin-dip-no');
            if (numberCell) numberCell.innerText = row.originalIndex;
            const checkboxCell = row.element.querySelector('.col-checkbox-cell');
            if (checkboxCell) checkboxCell.classList.toggle('hidden', !window.isSelectMode);
            if (tbody.dataset.categoryTable === 'true' && row.rincianCellTemplate) {
                let rincianCell = row.element.querySelector('.col-admin-rincian');
                if (!rincianCell) {
                    rincianCell = row.rincianCellTemplate.cloneNode(true);
                    row.element.insertBefore(rincianCell, row.element.querySelector('.col-admin-sub-info'));
                }
                rincianCell.rowSpan = 1;
                row.element.classList.remove('category-group-end');
                row.element.querySelectorAll('td').forEach(cell => cell.classList.remove('border-b', 'category-group-boundary-cell'));
            }
            tbody.appendChild(row.element);
        });
        if (tbody.dataset.categoryTable === 'true') {
            const categoryGroups = [];
            for (let index = 0; index < visibleRows.length;) {
                const groupKey = (visibleRows[index].rincian || '').trim();
                let groupEnd = index + 1;
                while (groupEnd < visibleRows.length && (visibleRows[groupEnd].rincian || '').trim() === groupKey) {
                    groupEnd++;
                }
                const firstCell = visibleRows[index].element.querySelector('.col-admin-rincian');
                if (firstCell) firstCell.rowSpan = groupEnd - index;
                for (let duplicateIndex = index + 1; duplicateIndex < groupEnd; duplicateIndex++) {
                    visibleRows[duplicateIndex].element.querySelector('.col-admin-rincian')?.remove();
                }
                categoryGroups.push({ firstIndex: index, lastIndex: groupEnd - 1 });
                index = groupEnd;
            }
            categoryGroups.slice(0, -1).forEach(group => {
                const lastRow = visibleRows[group.lastIndex].element;
                lastRow.classList.add('category-group-end');
                visibleRows[group.firstIndex].element.querySelector('.col-admin-rincian')?.classList.add('category-group-boundary-cell');
            });
        }
        if (info) info.innerText = `Menampilkan ${start + 1}–${end} dari ${total} informasi`;
        if (!pagination) return;
        pagination.innerHTML = '';
        const addButton = (label, target, disabled, active = false) => {
            const button = document.createElement('button');
            button.type = 'button'; button.innerText = label; button.disabled = disabled;
            button.className = 'px-3.5 py-2 min-w-[38px] text-center text-sm transition ' + (active ? 'font-extrabold bg-sky-500 text-white' : disabled ? 'text-slate-300 bg-slate-50 cursor-not-allowed' : 'font-bold bg-white text-sky-500 hover:bg-sky-50 cursor-pointer');
            if (!disabled) button.onclick = () => { state.page = target; renderAdminDipTable(key); };
            pagination.appendChild(button);
        };
        addButton('‹', state.page - 1, state.page === 1);
        const visiblePages = new Set([1, totalPages]);
        for (let page = Math.max(1, state.page - 2); page <= Math.min(totalPages, state.page + 2); page++) visiblePages.add(page);
        let previousPage = 0;
        [...visiblePages].sort((a, b) => a - b).forEach(page => {
            if (previousPage && page - previousPage > 1) {
                const dots = document.createElement('span'); dots.className = 'px-3 py-2 text-sm text-slate-400'; dots.innerText = '…'; pagination.appendChild(dots);
            }
            addButton(String(page), page, page === state.page, page === state.page);
            previousPage = page;
        });
        addButton('›', state.page + 1, state.page === totalPages);
    }

    document.addEventListener('DOMContentLoaded', initClientSideAdminDipTable);
</script>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/admin/informasi_publik/script.blade.php ENDPATH**/ ?>