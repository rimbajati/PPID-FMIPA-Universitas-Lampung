<script>
    const permohonansData = @json($permohonans->keyBy('id'));

    function formatWIB(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        const day = date.getDate();
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${day} ${month} ${year} - ${hours}:${minutes} WIB`;
    }

    function selectCaraAmbil(value) {
        const hiddenInput = document.getElementById('cara_ambil');
        if (hiddenInput) {
            hiddenInput.value = value;
            // Dispatch change event to trigger validator error removal
            hiddenInput.dispatchEvent(new Event('change'));
        }
    }

    function toggleModal(id, show) {
        document.getElementById(id).classList.toggle('hidden', !show);
        if (id === 'modal-form' && !show) {
            resetForm();
        }
    }

    function resetForm() {
        const form = document.querySelector('#modal-form form');
        if (form) {
            form.reset();
            form.action = "{{ route('layanan.store') }}";
            
            // Remove PUT override
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
            
            // Reset submit button text
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Kirim Pengajuan';
            }
        }
        
        // Reset Title
        const titleEl = document.querySelector('#modal-form h2');
        if (titleEl) titleEl.innerText = 'Formulir Pengajuan Baru';
        
        // Re-enable select fields
        const jenisLayanan = document.getElementById('jenis_layanan');
        if (jenisLayanan) {
            jenisLayanan.value = "";
            jenisLayanan.disabled = false;
        }
        
        const permohonanTerkait = document.getElementById('permohonan_terkait_id');
        if (permohonanTerkait) {
            permohonanTerkait.value = "";
            permohonanTerkait.disabled = false;
        }
        
        const identitasError = document.getElementById('identitas-file-error');
        if (identitasError) {
            identitasError.innerText = '';
            identitasError.classList.add('hidden');
        }

        document.querySelectorAll('.error-msg').forEach(el => {
            if (el.id !== 'identitas-file-error') el.remove();
        });
        document.querySelectorAll('.input-field').forEach(el => {
            el.classList.remove('border-red-500');
            el.classList.add('border-slate-300');
        });
        
        // Reset cara_ambil radio buttons
        document.querySelectorAll('input[name="cara_ambil_radio"]').forEach(r => r.checked = false);
        const hiddenCaraAmbil = document.getElementById('cara_ambil');
        if (hiddenCaraAmbil) hiddenCaraAmbil.value = '';

        // Hide existing file badges
        ['identitas-existing-file-info', 'akta-existing-file-info', 'pendukung-existing-file-info', 'keberatan-existing-file-info'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        });
        
        toggleFormFields();
    }

    function validateIdentitasFile(input) {
        const errorEl = document.getElementById('identitas-file-error');
        if (!input.files || input.files.length === 0) {
            if (errorEl) {
                errorEl.innerText = '';
                errorEl.classList.add('hidden');
            }
            return;
        }

        const file = input.files[0];
        const allowedExtensions = ['jpg', 'jpeg', 'png'];
        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            // Kosongkan input agar file tidak terinput
            input.value = '';
            if (errorEl) {
                errorEl.innerText = 'Format file lampiran identitas harus berupa gambar (JPG, JPEG, PNG). File tidak dapat diunggah.';
                errorEl.classList.remove('hidden');
            }
            input.classList.add('border-red-500');
            input.classList.remove('border-slate-300');
        } else {
            if (errorEl) {
                errorEl.innerText = '';
                errorEl.classList.add('hidden');
            }
            input.classList.remove('border-red-500');
            input.classList.add('border-slate-300');
        }
    }
    function toggleFormFields() {
        const type = document.getElementById('jenis_layanan').value;
        document.getElementById('section-permohonan').classList.toggle('hidden', type !== 'Permohonan');
        document.getElementById('section-keberatan').classList.toggle('hidden', type !== 'Keberatan');
        document.getElementById('section-keberatan-pilih').classList.toggle('hidden', type !== 'Keberatan');
        
        const wrapper = document.getElementById('form-body-wrapper');
        const lampiranPermohonan = document.getElementById('lampiran_pendukung');
        const lampiranKeberatan = document.getElementById('lampiran_pendukung_keberatan');
        
        if (type === 'Keberatan') {
            setFieldsLockState(true);
            document.getElementById('section-identitas').classList.add('hidden');
            document.getElementById('identitas').disabled = true;
            document.getElementById('section-akta').classList.add('hidden');
            document.getElementById('akta_pendirian').disabled = true;
            
            if (lampiranPermohonan) lampiranPermohonan.disabled = true;
            if (lampiranKeberatan) lampiranKeberatan.disabled = false;
            
            const relatedId = document.getElementById('permohonan_terkait_id').value;
            wrapper.classList.toggle('hidden', !relatedId);
        } else if (type === 'Permohonan') {
            setFieldsLockState(false);
            document.getElementById('section-identitas').classList.remove('hidden');
            document.getElementById('identitas').disabled = false;
            
            if (lampiranPermohonan) lampiranPermohonan.disabled = false;
            if (lampiranKeberatan) lampiranKeberatan.disabled = true;
            
            const existingInfo = document.getElementById('keberatan-existing-file-info');
            if (existingInfo) existingInfo.classList.add('hidden');
            
            checkKategori();
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }
    function setFieldsLockState(isLocked) {
        const textInputs = ['no_identitas', 'telepon', 'alamat'];
        const selectInputs = ['pekerjaan', 'kategori_pemohon'];

        textInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.readOnly = isLocked;
                if (isLocked) {
                    el.classList.add('bg-slate-100', 'cursor-not-allowed');
                } else {
                    el.classList.remove('bg-slate-100', 'cursor-not-allowed');
                }
            }
        });

        selectInputs.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                if (isLocked) {
                    el.style.pointerEvents = 'none';
                    el.classList.add('bg-slate-100', 'cursor-not-allowed');
                } else {
                    el.style.pointerEvents = 'auto';
                    el.classList.remove('bg-slate-100', 'cursor-not-allowed');
                }
            }
        });
    }
    function fillRelatedPermohonanData() {
        const id = document.getElementById('permohonan_terkait_id').value;
        const item = permohonansData[id];
        const wrapper = document.getElementById('form-body-wrapper');
        
        if (item) {
            document.getElementById('no_identitas').value = item.no_identitas || '';
            document.getElementById('telepon').value = item.no_hp || '';
            document.getElementById('alamat').value = item.alamat || '';
            document.getElementById('pekerjaan').value = item.pekerjaan || '';
            document.getElementById('kategori_pemohon').value = item.kategori_pemohon || '';
            
            // Check if there is an existing lampiran_pendukung
            const existingInfo = document.getElementById('keberatan-existing-file-info');
            const existingLink = document.getElementById('keberatan-existing-file-link');
            if (item.lampiran_pendukung && item.lampiran_pendukung !== '-') {
                if (existingInfo && existingLink) {
                    existingLink.href = `/storage/${item.lampiran_pendukung}`;
                    existingInfo.classList.remove('hidden');
                }
            } else {
                if (existingInfo) {
                    existingInfo.classList.add('hidden');
                }
            }
            
            checkKategori();
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }
    function checkKategori() {
        const type = document.getElementById('jenis_layanan').value;
        if (type === 'Keberatan') {
            document.getElementById('section-akta').classList.add('hidden');
            const aktaInput = document.getElementById('akta_pendirian');
            if (aktaInput) aktaInput.disabled = true;
            return;
        }

        const kategori = document.getElementById('kategori_pemohon').value;
        const sectionAkta = document.getElementById('section-akta');
        const aktaInput = document.getElementById('akta_pendirian');
        const wajibAkta = ['LSM/NGO', 'Instansi Pemerintah', 'Lembaga Pemerintah'];
        
        if (wajibAkta.includes(kategori)) {
            sectionAkta.classList.remove('hidden');
            if (aktaInput) aktaInput.disabled = false;
        } else {
            sectionAkta.classList.add('hidden');
            if (aktaInput) aktaInput.disabled = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const typeParam = urlParams.get('type');
        
        if (typeParam === 'permohonan' || typeParam === 'keberatan') {
            const val = typeParam === 'permohonan' ? 'Permohonan' : 'Keberatan';
            document.getElementById('jenis_layanan').value = val;
            
            toggleModal('modal-form', true);
            
            const url = new URL(window.location);
            url.searchParams.delete('type');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }

        toggleFormFields();
        if (document.getElementById('permohonan_terkait_id').value) {
            fillRelatedPermohonanData();
        }
    });

    document.querySelectorAll('.input-field').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            this.classList.add('border-slate-300');
            const nextElement = this.nextElementSibling;
            if (nextElement && nextElement.classList.contains('error-msg')) {
                nextElement.classList.add('hidden');
            }
        });
        input.addEventListener('change', function() {
            this.classList.remove('border-red-500');
            this.classList.add('border-slate-300');
            const nextElement = this.nextElementSibling;
            if (nextElement && nextElement.classList.contains('error-msg')) {
                nextElement.classList.add('hidden');
            }
        });
    });

    const form = document.querySelector('#modal-form form');
    if (form) {

        // Labels for error messages per field name
        const fieldLabels = {
            no_identitas: 'Nomor identitas wajib diisi.',
            telepon: 'Nomor Telepon wajib diisi.',
            alamat: 'Alamat wajib diisi.',
            pekerjaan: 'Pekerjaan wajib dipilih.',
            kategori_pemohon: 'Kategori pemohon wajib dipilih.',
            identitas: 'Lampiran Identitas wajib diunggah.',
            akta_pendirian: 'Akta Pendirian wajib diunggah untuk kategori ini.',
            info_diminta: 'Rincian informasi wajib diisi.',
            tujuan: 'Tujuan permohonan wajib diisi.',
            cara_ambil: 'Cara memperoleh informasi wajib dipilih.',
            tujuan_keberatan: 'Tujuan mengajukan keberatan wajib diisi.',
            alasan_keberatan: 'Alasan mengajukan keberatan wajib diisi.',
            pernyataan: 'Anda wajib menyetujui pernyataan kebenaran data.',
        };

        // Helper: check if element is visible (not in a hidden parent)
        function isVisible(el) {
            let node = el;
            while (node && node !== document.body) {
                if (node.classList && node.classList.contains('hidden')) return false;
                node = node.parentElement;
            }
            return true;
        }

        // Show error under a field
        function showFieldError(field, message) {
            // For checkboxes, insert error after the parent container (the flex div)
            let insertTarget = field;
            if (field.type === 'checkbox') {
                insertTarget = field.closest('.flex, .space-y-1, div') || field.parentElement;
            } else if (field.type === 'file') {
                const nextP = field.nextElementSibling;
                if (nextP && nextP.tagName.toLowerCase() === 'p') {
                    insertTarget = nextP;
                }
            }

            // Remove existing JS error near this field
            const container = (field.type === 'checkbox') ? insertTarget : field.parentElement;
            const existing = container.querySelector('[data-js-error]');
            if (existing) existing.remove();

            // Add red border
            field.classList.add('border-red-500');
            field.classList.remove('border-slate-300');

            // Insert error message after the target element
            const err = document.createElement('p');
            err.setAttribute('data-js-error', '1');
            err.className = 'text-red-500 text-xs mt-1';
            err.textContent = message;
            insertTarget.insertAdjacentElement('afterend', err);
        }

        // Clear error from a field
        function clearFieldError(field) {
            field.classList.remove('border-red-500');
            field.classList.add('border-slate-300');
            const existing = field.parentElement.querySelector('[data-js-error]');
            if (existing) existing.remove();
        }

        // File validation config: allowed extensions and max size (bytes)
        const fileRules = {
            identitas:           { exts: ['jpg','jpeg','png'], label: 'Lampiran Identitas' },
            akta_pendirian:      { exts: ['jpg','jpeg','png','pdf'], label: 'Akta Pendirian' },
            lampiran_pendukung:  { exts: ['jpg','jpeg','png','pdf'], label: 'Lampiran Data Pendukung' },
        };
        const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB

        function validateFileField(field) {
            const rules = fileRules[field.name];
            if (!rules || field.files.length === 0) return true; // no rules or no file — skip
            const file = field.files[0];
            const ext = file.name.split('.').pop().toLowerCase();
            if (!rules.exts.includes(ext)) {
                const allowed = rules.exts.map(e => e.toUpperCase()).join(', ');
                showFieldError(field, `Format ${rules.label} tidak valid. Harus berupa: ${allowed}.`);
                return false;
            }
            if (file.size > MAX_FILE_SIZE) {
                const actualMB = (file.size / (1024 * 1024)).toFixed(2);
                showFieldError(field, `Ukuran ${rules.label} terlalu besar! Maksimal 2 MB (Ukuran file Anda: ${actualMB} MB).`);
                field.value = '';
                return false;
            }
            clearFieldError(field);
            return true;
        }

        // Validate file type & size immediately on file selection
        form.querySelectorAll('input[type="file"]').forEach(function(field) {
            field.addEventListener('change', function() {
                validateFileField(field);
            });
        });

        // Clear errors on interaction (non-file)
        form.querySelectorAll('[data-required]').forEach(function(field) {
            if (field.type === 'file') return; // handled above
            ['input', 'change'].forEach(function(evt) {
                field.addEventListener(evt, function() { clearFieldError(field); });
            });
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear all previous JS errors
            form.querySelectorAll('[data-js-error]').forEach(function(el) { el.remove(); });

            let firstError = null;
            const isEditMode = !!form.querySelector('input[name="_method"]');

            const requiredFields = form.querySelectorAll('[data-required]');
            requiredFields.forEach(function(field) {
                if (!isVisible(field)) {
                    clearFieldError(field);
                    return; // skip hidden fields
                }

                let isEmpty = false;
                if (field.type === 'file') {
                    // File inputs are optional in Edit Mode (existing file is kept)
                    isEmpty = !isEditMode && field.files.length === 0;
                } else if (field.type === 'checkbox') {
                    isEmpty = !field.checked;
                } else {
                    isEmpty = field.value.trim() === '';
                }

                if (isEmpty) {
                    const label = fieldLabels[field.name] || 'Field ini wajib diisi.';
                    showFieldError(field, label);
                    if (!firstError) firstError = field;
                } else {
                    // For file inputs: validate type & size ONLY if a file is actually selected
                    if (field.type === 'file') {
                        if (field.files.length > 0) {
                            const valid = validateFileField(field);
                            if (!valid && !firstError) firstError = field;
                        } else {
                            clearFieldError(field);
                        }
                    } else {
                        clearFieldError(field);
                    }
                }
            });

            // Also validate any non-required file fields that have a file selected
            form.querySelectorAll('input[type="file"]:not([data-required])').forEach(function(field) {
                if (!isVisible(field) || field.files.length === 0) return;
                const valid = validateFileField(field);
                if (!valid && !firstError) firstError = field;
            });

            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            // All valid — show confirmation modal
            toggleModal('modal-confirm-submit', true);
        });
    }

    const confirmSubmitBtn = document.getElementById('confirm-submit-btn');
    if (confirmSubmitBtn) {
        confirmSubmitBtn.addEventListener('click', function() {
            // Close confirmation modal
            toggleModal('modal-confirm-submit', false);
            
            // Send the form via AJAX
            sendFormAjax();
        });
    }

    function sendFormAjax() {
        if (!form) return;
        
        // Clear previous error messages
        document.querySelectorAll('.error-msg').forEach(el => el.remove());
        document.querySelectorAll('.input-field').forEach(el => {
            el.classList.remove('border-red-500');
            el.classList.add('border-slate-300');
        });
        
        // Show loading state or disable button
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Mengirim...';
        }
        
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async response => {
            const isJson = response.headers.get('content-type')?.includes('application/json');
            const data = isJson ? await response.json() : null;
            
            if (response.status === 422) {
                // Validation errors
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
                
                if (data && data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        // Find the input element by id first, then by name
                        let inputEl = document.getElementById(field) || form.querySelector(`[name="${field}"]`);
                        
                        if (inputEl) {
                            inputEl.classList.remove('border-slate-300');
                            inputEl.classList.add('border-red-500');
                            
                            // Create error message paragraph
                            const errorP = document.createElement('p');
                            errorP.className = 'error-msg text-red-500 text-xs mt-1';
                            errorP.innerText = messages[0];
                            
                            // Insert error message after the element
                            if (field === 'pernyataan') {
                                const container = inputEl.closest('.flex');
                                if (container) {
                                    container.after(errorP);
                                } else {
                                    inputEl.after(errorP);
                                }
                            } else if (inputEl.type === 'file') {
                                const nextP = inputEl.nextElementSibling;
                                if (nextP && nextP.tagName.toLowerCase() === 'p') {
                                    nextP.after(errorP);
                                } else {
                                    inputEl.after(errorP);
                                }
                            } else {
                                inputEl.after(errorP);
                            }
                        }
                    }
                    
                    // Scroll to the first error
                    const firstError = form.querySelector('.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            } else if (response.ok) {
                // Success! Reload page to display success flash message
                window.location.reload();
            } else {
                // System errors
                alert(data && data.message ? data.message : 'Terjadi kesalahan sistem. Silakan coba lagi.');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            }
        })
        .catch(error => {
            console.error(error);
            alert('Gagal mengirim pengajuan. Periksa koneksi internet Anda.');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }

    @if ($errors->any()) toggleModal('modal-form', true); @endif

    function openSummaryModal(data) {
        document.getElementById('modal-nama').innerText = data.nama;
        const tiketEl = document.getElementById('modal-tiket');
        if (tiketEl) {
            const isKeb = (data.no_tiket || '').startsWith('KEB');
            tiketEl.style.color = isKeb ? '#d97706' : '#1B365D';
            tiketEl.innerText = data.no_tiket;
        }
        document.getElementById('modal-no-identitas').innerText = data.no_identitas;
        document.getElementById('modal-email').innerText = data.email;
        document.getElementById('modal-hp').innerText = data.no_hp;
        document.getElementById('modal-pekerjaan').innerText = data.pekerjaan;
        document.getElementById('modal-alamat').innerText = data.alamat;
        document.getElementById('modal-jenis').innerText = data.jenis_layanan;
        document.getElementById('modal-kategori').innerText = data.kategori_pemohon;
        
        if (data.jenis_layanan === 'Keberatan') {
            document.getElementById('lbl-modal-info').innerText = 'Alasan Keberatan';
            document.getElementById('modal-info').innerText = data.alasan_keberatan || '-';
            
            document.getElementById('lbl-modal-tujuan').innerText = 'Tujuan Keberatan';
            document.getElementById('modal-tujuan').innerText = data.tujuan_keberatan || '-';
            
            document.getElementById('row-modal-cara').classList.add('hidden');
        } else {
            document.getElementById('lbl-modal-info').innerText = 'Rincian Informasi';
            document.getElementById('modal-info').innerText = data.info_diminta || '-';
            
            document.getElementById('lbl-modal-tujuan').innerText = 'Tujuan';
            document.getElementById('modal-tujuan').innerText = data.tujuan_permohonan || '-';
            
            document.getElementById('row-modal-cara').classList.remove('hidden');
            document.getElementById('modal-cara').innerText = data.cara_memperoleh || '-';
        }
        
        // Render status history rows
        const historyBody = document.getElementById('modal-status-history-body');
        historyBody.innerHTML = ''; // clear current rows
        
        if (data.status_histories && data.status_histories.length > 0) {
            data.status_histories.forEach(history => {
                let hasilHtml = '-';
                if (history.status === 'DITERIMA' || (history.status === data.status && (data.file_jawaban || data.link_jawaban))) {
                    let btns = [];
                    if (data.file_jawaban) {
                        btns.push(`<a href="/storage/${data.file_jawaban}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1B365D] hover:bg-[#162c4c] text-white rounded-lg font-bold text-xs shadow-xs transition"><i class="fa-solid fa-file-arrow-down"></i> Unduh File</a>`);
                    }
                    if (data.link_jawaban) {
                        btns.push(`<a href="${data.link_jawaban}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs shadow-xs transition"><i class="fa-solid fa-up-right-from-square"></i> Buka Link</a>`);
                    }
                    if (btns.length > 0) {
                        hasilHtml = `<div class="flex items-center gap-2 flex-wrap">${btns.join('')}</div>`;
                    }
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="p-5 font-bold text-slate-800">${history.status}</td>
                    <td class="p-5 text-slate-700">${formatWIB(history.created_at)}</td>
                    <td class="p-5 text-slate-700">${history.catatan && history.catatan.trim() !== '' ? history.catatan : '-'}</td>
                    <td class="p-5 text-slate-700">${hasilHtml}</td>
                `;
                historyBody.appendChild(row);
            });
        } else {
            // Fallback for legacy records that don't have history records
            let hasilHtml = '-';
            if (data.status === 'DITERIMA' || data.file_jawaban || data.link_jawaban) {
                let btns = [];
                if (data.file_jawaban) {
                    btns.push(`<a href="/storage/${data.file_jawaban}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#1B365D] hover:bg-[#162c4c] text-white rounded-lg font-bold text-xs shadow-xs transition"><i class="fa-solid fa-file-arrow-down"></i> Unduh File</a>`);
                }
                if (data.link_jawaban) {
                    btns.push(`<a href="${data.link_jawaban}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-xs shadow-xs transition"><i class="fa-solid fa-up-right-from-square"></i> Buka Link</a>`);
                }
                if (btns.length > 0) {
                    hasilHtml = `<div class="flex items-center gap-2 flex-wrap">${btns.join('')}</div>`;
                }
            }

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="p-5 font-bold text-slate-800">${data.status}</td>
                <td class="p-5 text-slate-700">${formatWIB(data.updated_at)}</td>
                <td class="p-5 text-slate-700">${data.catatan_admin && data.catatan_admin.trim() !== '' ? data.catatan_admin : '-'}</td>
                <td class="p-5 text-slate-700">${hasilHtml}</td>
            `;
            historyBody.appendChild(row);
        }

        // Setup Identitas Link (Pop-up Modal)
        const identitasContainer = document.getElementById('modal-identitas-doc');
        if(data.lampiran_identitas && data.lampiran_identitas !== '-') {
            const url = `/storage/${data.lampiran_identitas}`;
            identitasContainer.innerHTML = `<button type="button" onclick="openPreviewDoc('${url}', '${data.nama}', '${data.no_identitas || ''}', 'Identitas (KTP/SIM/KTM)')" class="inline-flex items-center gap-2 text-[#1B365D] bg-cyan-50 hover:bg-cyan-100 border border-cyan-200 px-3.5 py-1.5 rounded-lg text-sm font-semibold transition"><i class="fa-solid fa-id-card text-[#1B365D]"></i> Identitas </button>`;
        } else {
            identitasContainer.innerText = '-';
        }
        
        // Setup Akta Link (Buka di Tab Baru)
        const aktaRow = document.getElementById('row-modal-akta');
        const aktaContainer = document.getElementById('modal-akta-doc');
        const showAkta = ['LSM/NGO', 'Instansi Pemerintah', 'Lembaga Pemerintah'].includes(data.kategori_pemohon);
        if (showAkta) {
            aktaRow.classList.remove('hidden');
            if (data.akta_pendirian && data.akta_pendirian !== '-') {
                const url = `/storage/${data.akta_pendirian}`;
                aktaContainer.innerHTML = `<a href="${url}" target="_blank" class="inline-flex items-center gap-2 text-[#1B365D] bg-cyan-50 hover:bg-cyan-100 border border-cyan-200 px-3.5 py-1.5 rounded-lg text-sm font-semibold transition"><i class="fa-solid fa-file-lines text-[#1B365D]"></i> Akta Pendirian Badan hukum </a>`;
            } else {
                aktaContainer.innerText = '-';
            }
        } else {
            aktaRow.classList.add('hidden');
        }

        // Setup Pendukung Link (Buka di Tab Baru)
        const pendukungContainer = document.getElementById('modal-pendukung-doc');
        if(data.lampiran_pendukung && data.lampiran_pendukung !== '-') {
            const url = `/storage/${data.lampiran_pendukung}`;
            pendukungContainer.innerHTML = `<a href="${url}" target="_blank" class="inline-flex items-center gap-2 text-[#1B365D] bg-cyan-50 hover:bg-cyan-100 border border-cyan-200 px-3.5 py-1.5 rounded-lg text-sm font-semibold transition"><i class="fa-solid fa-file-lines text-[#1B365D]"></i> Dokumen Pendukung </a>`;
        } else {
            pendukungContainer.innerText = '-';
        }

        // Store active data for modal action buttons
        window.currentSummaryData = data;

        // Toggle footer action button visibilities
        const btnKeberatan = document.getElementById('modal-btn-keberatan');
        if (btnKeberatan) {
            btnKeberatan.classList.toggle('hidden', data.jenis_layanan !== 'Permohonan');
        }

        const btnEdit = document.getElementById('modal-btn-edit');
        const btnDelete = document.getElementById('modal-btn-delete');
        if (btnEdit) {
            btnEdit.classList.toggle('hidden', !['DIAJUKAN', 'PERBAIKAN'].includes(data.status));
        }
        if (btnDelete) {
            btnDelete.classList.toggle('hidden', data.status !== 'DIAJUKAN');
        }

        toggleModal('modal-summary', true);
    }

    function actionAjukanKeberatanFromModal() {
        if (!window.currentSummaryData) return;
        const id = window.currentSummaryData.id;
        toggleModal('modal-summary', false);
        openAjukanKeberatan(id);
    }

    function actionEditFromModal() {
        if (!window.currentSummaryData) return;
        const item = window.currentSummaryData;
        toggleModal('modal-summary', false);
        openEditModal(item);
    }

    function actionDeleteFromModal() {
        if (!window.currentSummaryData) return;
        const id = window.currentSummaryData.id;
        const noTiket = window.currentSummaryData.no_tiket;
        toggleModal('modal-summary', false);
        deletePengajuan(id, noTiket);
    }

    function openEditModal(item) {
        // Reset form first
        resetForm();
        
        const form = document.querySelector('#modal-form form');
        if (!form) return;
        
        // Update Title and Action
        const titleEl = document.querySelector('#modal-form h2');
        if (titleEl) titleEl.innerText = 'Edit Pengajuan: ' + item.no_tiket;
        
        form.action = `/layanan/${item.id}`;
        
        // Add PUT method override
        let methodInput = form.querySelector('input[name="_method"]');
        if (!methodInput) {
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            form.appendChild(methodInput);
        }
        methodInput.value = 'PUT';
        
        // Update submit button text
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.innerText = 'Simpan Perubahan';
        
        // Populate fields
        const jenisLayanan = document.getElementById('jenis_layanan');
        if (jenisLayanan) {
            jenisLayanan.value = item.jenis_layanan;
            jenisLayanan.disabled = true; // Disable editing service type
        }
        
        // Trigger field visibility based on jenis_layanan
        toggleFormFields();
        
        // Populate permohonan_terkait_id if Keberatan
        if (item.jenis_layanan === 'Keberatan') {
            const permohonanTerkait = document.getElementById('permohonan_terkait_id');
            if (permohonanTerkait) {
                permohonanTerkait.value = item.permohonan_terkait_id;
                permohonanTerkait.disabled = true; // Disable editing related ticket
            }
            // Populate Keberatan specific fields
            const tujuanKeberatan = document.getElementById('tujuan_keberatan');
            if (tujuanKeberatan) tujuanKeberatan.value = item.tujuan_keberatan;
            
            const alasanKeberatan = document.getElementById('alasan_keberatan');
            if (alasanKeberatan) alasanKeberatan.value = item.alasan_keberatan;
        } else {
            // Populate Permohonan specific fields
            const infoDiminta = document.getElementById('info_diminta');
            if (infoDiminta) infoDiminta.value = item.info_diminta;
            
            const tujuan = document.getElementById('tujuan');
            if (tujuan) tujuan.value = item.tujuan_permohonan;
            
            const caraAmbil = document.getElementById('cara_ambil');
            if (caraAmbil) {
                caraAmbil.value = item.cara_memperoleh;
                // Sync with radio button UI
                const radio = document.querySelector(`input[name="cara_ambil_radio"][value="${item.cara_memperoleh}"]`);
                if (radio) {
                    radio.checked = true;
                }
            }
        }
        
        // Populate lockable personal info
        const noIdentitas = document.getElementById('no_identitas');
        if (noIdentitas) noIdentitas.value = item.no_identitas;
        
        const telepon = document.getElementById('telepon');
        if (telepon) telepon.value = item.no_hp;
        
        const alamat = document.getElementById('alamat');
        if (alamat) alamat.value = item.alamat;
        
        const pekerjaan = document.getElementById('pekerjaan');
        if (pekerjaan) pekerjaan.value = item.pekerjaan;
        
        const kategoriPemohon = document.getElementById('kategori_pemohon');
        if (kategoriPemohon) {
            kategoriPemohon.value = item.kategori_pemohon;
            // Trigger checkKategori to show/hide akta pendirian section
            checkKategori();
        }
        
        // Auto fill locked/unlocked state
        if (item.jenis_layanan === 'Keberatan') {
            setFieldsLockState(true);
        } else {
            setFieldsLockState(false);
        }
        
        // Populate existing files info badges in edit mode
        if (item.lampiran_identitas && item.lampiran_identitas !== '-') {
            const elInfo = document.getElementById('identitas-existing-file-info');
            const elLink = document.getElementById('identitas-existing-file-link');
            if (elInfo && elLink) {
                elLink.href = `/storage/${item.lampiran_identitas}`;
                elInfo.classList.remove('hidden');
            }
        }

        if (item.akta_pendirian && item.akta_pendirian !== '-') {
            const elInfo = document.getElementById('akta-existing-file-info');
            const elLink = document.getElementById('akta-existing-file-link');
            if (elInfo && elLink) {
                elLink.href = `/storage/${item.akta_pendirian}`;
                elInfo.classList.remove('hidden');
            }
        }

        if (item.lampiran_pendukung && item.lampiran_pendukung !== '-') {
            const elInfo = document.getElementById('pendukung-existing-file-info');
            const elLink = document.getElementById('pendukung-existing-file-link');
            if (elInfo && elLink) {
                elLink.href = `/storage/${item.lampiran_pendukung}`;
                elInfo.classList.remove('hidden');
            }
        }

        // Make sure body wrapper is shown
        const wrapper = document.getElementById('form-body-wrapper');
        if (wrapper) wrapper.classList.remove('hidden');
        
        // Show modal
        toggleModal('modal-form', true);
    }

    let pengajuanIdToDelete = null;

    function deletePengajuan(id, ticketNo) {
        pengajuanIdToDelete = id;
        document.getElementById('delete-ticket-display').innerText = ticketNo;
        
        // Show modal delete
        toggleModal('modal-delete', true);
        
        // Set action for confirm button
        const confirmBtn = document.getElementById('confirm-delete-btn');
        if (confirmBtn) {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Ya, Hapus';
            confirmBtn.onclick = function() {
                // Disable button and show spinner
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Menghapus...';
                
                fetch(`/layanan/${pengajuanIdToDelete}`, {
                    method: 'POST', // Use POST with _method = DELETE for Laravel CSRF compatibility
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'DELETE'
                    })
                })
                .then(async response => {
                    const data = await response.json();
                    if (response.ok) {
                        toggleModal('modal-delete', false);
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal menghapus pengajuan.');
                        confirmBtn.disabled = false;
                        confirmBtn.innerHTML = 'Ya, Hapus';
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Terjadi kesalahan jaringan.');
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = 'Ya, Hapus';
                });
            };
        }
    }

    function switchToPermohonan() {
        const jenisLayanan = document.getElementById('jenis_layanan');
        if (jenisLayanan) {
            jenisLayanan.value = 'Permohonan';
            toggleFormFields();
        }
    }

    function openAjukanKeberatan(permohonanId) {
        resetForm();
        toggleModal('modal-form', true);
        const jenisLayanan = document.getElementById('jenis_layanan');
        if (jenisLayanan) {
            jenisLayanan.value = 'Keberatan';
            toggleFormFields();
        }
        const permohonanSelect = document.getElementById('permohonan_terkait_id');
        if (permohonanSelect) {
            permohonanSelect.value = permohonanId;
            fillRelatedPermohonanData();
        }
    }

    function openPreviewDoc(url, nama, noIdentitas, label) {
        const imgEl = document.getElementById('preview-identitas-img');
        const iframeEl = document.getElementById('preview-identitas-iframe');
        const titleEl = document.getElementById('preview-identitas-title');
        const namaEl = document.getElementById('preview-nama-lengkap');
        const noIdentitasEl = document.getElementById('preview-no-identitas');

        if (titleEl) titleEl.innerText = `Preview ${label}`;
        if (namaEl) namaEl.innerText = nama || '-';
        if (noIdentitasEl) noIdentitasEl.innerText = (noIdentitas && noIdentitas !== 'undefined' && noIdentitas !== '') ? noIdentitas : '-';

        const isImage = /\.(jpg|jpeg|png|webp|gif)$/i.test(url);
        if (isImage) {
            if (imgEl) {
                imgEl.src = url;
                imgEl.classList.remove('hidden');
            }
            if (iframeEl) {
                iframeEl.src = '';
                iframeEl.classList.add('hidden');
            }
        } else {
            if (iframeEl) {
                iframeEl.src = url;
                iframeEl.classList.remove('hidden');
            }
            if (imgEl) {
                imgEl.src = '';
                imgEl.classList.add('hidden');
            }
        }

        toggleModal('modal-preview-identitas', true);
    }

    function performLiveSearch(formElement) {
        const url = new URL(formElement.action, window.location.origin);
        const formData = new FormData(formElement);
        for (const [key, value] of formData.entries()) {
            if (value) url.searchParams.set(key, value);
        }
        
        const dataContainer = document.getElementById('data-table-container');
        if (dataContainer) dataContainer.classList.add('opacity-50', 'pointer-events-none');

        fetch(url.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            const newTable = doc.getElementById('data-table-container');
            if (newTable && dataContainer) {
                dataContainer.innerHTML = newTable.innerHTML;
            }
            
            window.history.replaceState(null, '', url.toString());
        })
        .catch(err => console.error("Search fetch failed:", err))
        .finally(() => {
            if (dataContainer) dataContainer.classList.remove('opacity-50', 'pointer-events-none');
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let timer = null;
            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    const filterForm = document.getElementById('filterForm');
                    if (filterForm) performLiveSearch(filterForm);
                }, 400);
            });
        }
    });
</script>

