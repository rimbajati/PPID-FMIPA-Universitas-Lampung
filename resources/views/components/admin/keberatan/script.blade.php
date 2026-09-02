<script>
    const selectAll = document.getElementById('select-all');
    const childCheckboxes = document.querySelectorAll('.child-checkbox');
    const bulkBtn = document.getElementById('btn-bulk-delete');
    const bulkForm = document.getElementById('form-bulk-delete');

    let isSelectMode = false;
    function toggleSelectMode() {
        isSelectMode = !isSelectMode;
        const colCheckboxes = document.querySelectorAll('.col-checkbox');
        const toggleBtn = document.getElementById('btn-toggle-select');
        const textSelectMode = document.getElementById('text-select-mode');

        colCheckboxes.forEach(el => el.classList.toggle('hidden', !isSelectMode));

        if (isSelectMode) {
            toggleBtn.classList.remove('bg-slate-100', 'text-slate-700');
            toggleBtn.classList.add('bg-rose-50', 'text-rose-600');
            textSelectMode.innerText = "Batal";
        } else {
            if(selectAll) selectAll.checked = false;
            childCheckboxes.forEach(cb => cb.checked = false);
            toggleBtn.classList.remove('bg-rose-50', 'text-rose-600');
            toggleBtn.classList.add('bg-slate-100', 'text-slate-700');
            textSelectMode.innerText = "Pilih";
            if (bulkBtn) bulkBtn.classList.add('hidden');
        }
    }

    function updateMasterCheckbox() {
        if(!selectAll || childCheckboxes.length === 0) return;
        const allChecked = Array.from(childCheckboxes).every(cb => cb.checked);
        selectAll.checked = allChecked;
    }

    if(selectAll) {
        selectAll.addEventListener('change', function() {
            childCheckboxes.forEach(cb => cb.checked = this.checked);
            toggleBulkBtn();
        });
    }

    childCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            updateMasterCheckbox();
            toggleBulkBtn();
        });
    });

    function toggleBulkBtn() {
        const checkedCount = document.querySelectorAll('.child-checkbox:checked').length;
        const countEl = document.getElementById('selected-count');
        if (countEl) countEl.textContent = checkedCount;
        if (bulkBtn) bulkBtn.classList.toggle('hidden', !isSelectMode || checkedCount === 0);
    }

    let currentDeleteType = null;
    let currentDeleteUrl = null;

    function closeDeleteModal() {
        const modal = document.getElementById('modalConfirmDelete');
        if (modal) modal.classList.add('hidden');
        currentDeleteType = null;
        currentDeleteUrl = null;
    }

    function triggerBulkDelete() {
        const checkedCount = document.querySelectorAll('.child-checkbox:checked').length;
        const textEl = document.getElementById('deleteConfirmText');
        if (textEl) textEl.innerHTML = 'Apakah Anda yakin ingin menghapus <b>' + checkedCount + ' pengajuan keberatan</b> yang dipilih?';
        currentDeleteType = 'bulk';
        const modal = document.getElementById('modalConfirmDelete');
        if (modal) modal.classList.remove('hidden');
    }

    function triggerDelete(url, tiket) {
        const textEl = document.getElementById('deleteConfirmText');
        if (textEl) textEl.innerHTML = 'Apakah Anda yakin ingin menghapus keberatan <b>"' + tiket + '"</b> ini?';
        currentDeleteType = 'single';
        currentDeleteUrl = url;
        const modal = document.getElementById('modalConfirmDelete');
        if (modal) modal.classList.remove('hidden');
    }

    function executeDelete() {
        if (currentDeleteType === 'bulk') {
            if (bulkForm) bulkForm.submit();
        } else if (currentDeleteType === 'single' && currentDeleteUrl) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = currentDeleteUrl;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            document.body.appendChild(form);
            form.submit();
        }
    }

    function submitQuickStatus(url, newStatus) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = newStatus;
        form.appendChild(statusInput);

        document.body.appendChild(form);
        form.submit();
    }

    function openKeberatanDetail(btn) {
        try {
            const rawData = btn.getAttribute('data-keberatan');
            const item = typeof rawData === 'string' ? JSON.parse(rawData) : rawData;

            if (item) {
                if (!item.original_status) {
                    item.original_status = item.status;
                }
            }

            if (window.keberatanAlpineComponent) {
                window.keberatanAlpineComponent.selectedKeberatan = item;
                window.keberatanAlpineComponent.detailModalOpen = true;
            } else {
                const rootEl = document.querySelector('[x-data]');
                if (rootEl && Alpine) {
                    const alpineData = Alpine.$data(rootEl);
                    if (alpineData) {
                        if (typeof alpineData.openDetail === 'function') {
                            alpineData.openDetail(item);
                        } else {
                            alpineData.selectedKeberatan = item;
                            alpineData.detailModalOpen = true;
                        }
                    }
                }
            }
        } catch (e) {
            console.error("Gagal membuka detail keberatan:", e);
        }
    }

    function handleOpenDetail(btn) {
        openKeberatanDetail(btn);
    }
</script>
