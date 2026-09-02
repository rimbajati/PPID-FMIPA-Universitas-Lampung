<script>
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
            toggleBtn.classList.remove('bg-slate-100', 'text-slate-700');
            toggleBtn.classList.add('bg-rose-50', 'text-rose-600');
            textSelectMode.innerText = 'Batal';
        } else {
            toggleBtn.classList.remove('bg-rose-50', 'text-rose-600');
            toggleBtn.classList.add('bg-slate-100', 'text-slate-700');
            textSelectMode.innerText = 'Pilih';
            
            if (checkAll) checkAll.checked = false;
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = false);
            window.updateBulkState();
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

    let pendingDeleteAction = null;

    function closeDeleteModal() {
        document.getElementById('modalConfirmDelete').classList.add('hidden');
        pendingDeleteAction = null;
    }

    function triggerBulkDelete() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        if (checkedCount === 0) return;
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus <b>' + checkedCount + '</b> informasi publik yang dipilih?';
        currentDeleteType = 'bulk';
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    function triggerDelete(url, title) {
        document.getElementById('deleteConfirmText').innerHTML = 'Apakah Anda yakin ingin menghapus informasi <b>"' + title + '"</b> ini?';
        currentDeleteType = 'single';
        currentDeleteUrl = url;
        document.getElementById('modalConfirmDelete').classList.remove('hidden');
    }

    function openModalCreate() {
        document.getElementById('modalTitle').innerText = 'Tambah Informasi Publik';
        document.getElementById('modalSubtitle').innerText = 'Isi data dibawah ini untuk menambahkan informasi publik baru';
        document.getElementById('formAddEdit').action = "{{ url('/admin/informasi-publik') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('formAddEdit').reset();
        
        // Hide file info box in create mode
        const fileBox = document.getElementById('currentFileBox');
        if (fileBox) fileBox.classList.add('hidden');

        const helpText = document.getElementById('fileHelpText');
        if (helpText) helpText.innerText = 'Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)';

        // Reset default 
        document.getElementById('inputTahun').value = new Date().getFullYear();
        toggleInputType('file');
        document.getElementById('modalAddEdit').classList.remove('hidden');

        // Dispatch input event for char counter
        document.getElementById('inputJudul').dispatchEvent(new Event('input'));
        document.getElementById('inputDeskripsi').dispatchEvent(new Event('input'));
    }

    function closeAddEditModal() {
        document.getElementById('modalAddEdit').classList.add('hidden');
    }

    function toggleInputType(type) {
        const containerFile = document.getElementById('containerFile');
        const containerLink = document.getElementById('containerLink');
        const inputFile = document.getElementById('inputFile');
        const inputLink = document.getElementById('inputLink');
        const fileRequiredStar = document.getElementById('fileRequiredStar');
        const isEdit = document.getElementById('formMethod').value === 'PUT';

        if (type === 'file') {
            containerFile.classList.remove('hidden');
            containerLink.classList.add('hidden');
            if (isEdit) {
                if (inputFile) inputFile.removeAttribute('required');
                if (fileRequiredStar) fileRequiredStar.classList.add('hidden');
            } else {
                if (inputFile) inputFile.setAttribute('required', 'required');
                if (fileRequiredStar) fileRequiredStar.classList.remove('hidden');
            }
            if (inputLink) inputLink.removeAttribute('required');
        } else {
            containerFile.classList.add('hidden');
            containerLink.classList.remove('hidden');
            if (inputLink) inputLink.setAttribute('required', 'required');
            if (inputFile) inputFile.removeAttribute('required');
        }
    }

    function editData(item) {
        document.getElementById('modalTitle').innerText = 'Edit Informasi Publik';
        document.getElementById('modalSubtitle').innerText = 'Perbarui data informasi publik dibawah ini';
        document.getElementById('formAddEdit').action = "{{ url('/admin/informasi-publik') }}/" + item.id;
        document.getElementById('formMethod').value = 'PUT';

        document.getElementById('inputJudul').value = item.judul_informasi || '';
        document.getElementById('inputDeskripsi').value = item.deskripsi_informasi || '';
        document.getElementById('inputKategori').value = item.kategori_informasi || '';
        document.getElementById('inputTahun').value = item.tahun_terbit || (item.created_at ? new Date(item.created_at).getFullYear() : new Date().getFullYear());

        const fileBox = document.getElementById('currentFileBox');
        const fileNameSpan = document.getElementById('currentFileName');
        const fileLink = document.getElementById('currentFileLink');
        const helpText = document.getElementById('fileHelpText');

        if (item.link_informasi && !item.file_informasi) {
            document.querySelector('input[name="jenis_informasi"][value="link"]').checked = true;
            toggleInputType('link');
            document.getElementById('inputLink').value = item.link_informasi || '';
            if (fileBox) fileBox.classList.add('hidden');
            if (helpText) helpText.innerText = 'Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)';
        } else {
            document.querySelector('input[name="jenis_informasi"][value="file"]').checked = true;
            toggleInputType('file');

            if (item.file_informasi) {
                const displayName = item.nama_file_asli || item.file_informasi.split('/').pop();
                if (fileNameSpan) fileNameSpan.innerText = displayName;
                if (fileLink) fileLink.href = "{{ url('/informasi/file') }}/" + item.id + "/" + encodeURIComponent(displayName) + "?from_admin=1";
                if (fileBox) fileBox.classList.remove('hidden');
                if (helpText) helpText.innerText = 'Pilih file baru jika ingin mengganti file saat ini. Biarkan kosong jika tidak ingin mengubah file.';
            } else {
                if (fileBox) fileBox.classList.add('hidden');
                if (helpText) helpText.innerText = 'Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)';
            }
        }

        document.getElementById('modalAddEdit').classList.remove('hidden');

        // Dispatch input event for char counter
        document.getElementById('inputJudul').dispatchEvent(new Event('input'));
        document.getElementById('inputDeskripsi').dispatchEvent(new Event('input'));
    }

    function handleFormSubmit(event) {
        // Form submit standar
    }

    function submitFilterForm() {
        const form = document.getElementById('filter-search-form');
        if (form) form.submit();
    }
</script>
