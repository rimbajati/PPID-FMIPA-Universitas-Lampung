<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('permohonanModalData', () => ({
            detailModalOpen: false, 
            selectedPermohonan: null,
            tipeTanggapan: 'file',
            shouldRefreshOnClose: false,
            
            init() {
                window.permohonanAlpineComponent = this;
            },
            
            closeModal() {
                this.detailModalOpen = false;
                if (this.shouldRefreshOnClose) {
                    window.location.reload();
                }
            },

            openDetail(item) {
                if (item) {
                    if (!item.original_status) {
                        item.original_status = item.status;
                    }
                    this.selectedPermohonan = Object.assign({}, item);
                    this.tipeTanggapan = (item.link_jawaban_permohonan || item.link_jawaban) ? 'link' : 'file';
                    this.detailModalOpen = true;
                }
            }
        }));
    });

    window.isSelectMode = false;

    window.toggleSelectMode = function() {
        window.isSelectMode = !window.isSelectMode;
        const isSelectMode = window.isSelectMode;
        const headerCol = document.getElementById('col-checkbox-header');
        const bodyCols = document.querySelectorAll('.col-checkbox-cell');
        const toggleBtn = document.getElementById('btn-toggle-select');
        const textSelectMode = document.getElementById('text-select-mode');
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const checkAll = document.getElementById('check-all');
        const itemCbs = document.querySelectorAll('.item-checkbox');

        if (headerCol) {
            headerCol.classList.toggle('hidden', !isSelectMode);
        }
        bodyCols.forEach(el => {
            el.classList.toggle('hidden', !isSelectMode);
        });

        if (toggleBtn) {
            if (isSelectMode) {
                toggleBtn.classList.remove('bg-slate-100', 'text-slate-700');
                toggleBtn.classList.add('bg-rose-50', 'text-rose-600', 'border', 'border-rose-200');
                if (textSelectMode) textSelectMode.innerText = "Batal";
            } else {
                if (checkAll) checkAll.checked = false;
                itemCbs.forEach(cb => cb.checked = false);
                toggleBtn.classList.remove('bg-rose-50', 'text-rose-600', 'border', 'border-rose-200');
                toggleBtn.classList.add('bg-slate-100', 'text-slate-700');
                if (textSelectMode) textSelectMode.innerText = "Pilih";
                if (bulkBtn) bulkBtn.classList.add('hidden');
            }
        }
    };

    window.toggleCheckAll = function(source) {
        const itemCbs = document.querySelectorAll('.item-checkbox');
        itemCbs.forEach(cb => cb.checked = source.checked);
        window.updateBulkState();
    };

    window.updateBulkState = function() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        const bulkBtn = document.getElementById('btn-bulk-delete');
        const selectedCount = document.getElementById('selected-count');
        const checkAll = document.getElementById('check-all');
        const itemCbs = document.querySelectorAll('.item-checkbox');

        if (selectedCount) selectedCount.innerText = checkedCount;
        if (bulkBtn) bulkBtn.classList.toggle('hidden', !window.isSelectMode || checkedCount === 0);
        if (checkAll && itemCbs.length > 0) {
            checkAll.checked = (checkedCount === itemCbs.length);
        }
    };

    window.currentDeleteType = null;
    window.currentDeleteUrl = null;

    window.closeDeleteModal = function() {
        const modal = document.getElementById('modalConfirmDelete');
        if (modal) modal.classList.add('hidden');
        window.currentDeleteType = null;
        window.currentDeleteUrl = null;
    };

    window.triggerBulkDelete = function() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        const textEl = document.getElementById('deleteConfirmText');
        if (textEl) textEl.innerHTML = 'Apakah Anda yakin ingin menghapus <b>' + checkedCount + ' permohonan</b> yang dipilih?';
        window.currentDeleteType = 'bulk';
        const modal = document.getElementById('modalConfirmDelete');
        if (modal) modal.classList.remove('hidden');
    };

    window.triggerDelete = function(url, tiket) {
        const textEl = document.getElementById('deleteConfirmText');
        if (textEl) textEl.innerHTML = 'Apakah Anda yakin ingin menghapus permohonan <b>"' + tiket + '"</b> ini?';
        window.currentDeleteType = 'single';
        window.currentDeleteUrl = url;
        const modal = document.getElementById('modalConfirmDelete');
        if (modal) modal.classList.remove('hidden');
    };

    window.executeDelete = function() {
        if (window.currentDeleteType === 'bulk') {
            const bulkForm = document.getElementById('form-bulk-delete');
            if (bulkForm) bulkForm.submit();
        } else if (window.currentDeleteType === 'single' && window.currentDeleteUrl) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = window.currentDeleteUrl;

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
    };

    window.openPermohonanDetail = function(btn) {
        try {
            const rawData = btn.getAttribute('data-keberatan') || btn.getAttribute('data-permohonan');
            const item = typeof rawData === 'string' ? JSON.parse(rawData) : rawData;

            if (item) {
                if (!item.original_status) {
                    item.original_status = item.status;
                }
            }

            if (window.permohonanAlpineComponent) {
                window.permohonanAlpineComponent.selectedPermohonan = item;
                window.permohonanAlpineComponent.detailModalOpen = true;
            } else {
                const rootEl = document.querySelector('[x-data]');
                if (rootEl && window.Alpine) {
                    const alpineData = window.Alpine.$data(rootEl);
                    if (alpineData) {
                        if (typeof alpineData.openDetail === 'function') {
                            alpineData.openDetail(item);
                        } else {
                            alpineData.selectedPermohonan = item;
                            alpineData.detailModalOpen = true;
                        }
                    }
                }
            }
        } catch (e) {
            console.error("Gagal membuka detail permohonan:", e);
        }
    };
</script>
