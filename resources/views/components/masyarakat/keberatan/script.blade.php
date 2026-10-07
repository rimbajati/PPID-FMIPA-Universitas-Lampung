@php
    $prefillTiket = old('no_tiket_permohonan', request('tiket', request('no_tiket', '')));
    $prefillEmail = old('email', request('email', ''));
@endphp
<script>
function keberatanForm() {
    return {
        no_tiket_permohonan: @json($prefillTiket),
        email: @json($prefillEmail),
        alasan_keberatan: @json(old('alasan_keberatan', '')),
        kronologi_keberatan: @json(old('kronologi_keberatan', '')),
        pendukungFileName: '',
        pendukungFileSize: '',
        pendukungFileUrl: '',
        pendukungErrorMsg: '',
        disetujui: false,
        submitted: false,
        isLoading: false,

        hasError(field) {
            if (!this.submitted) return false;
            if (field === 'no_tiket_permohonan') return !this.no_tiket_permohonan || !this.no_tiket_permohonan.trim();
            if (field === 'email') return !this.email || !this.email.trim();
            if (field === 'alasan_keberatan') return !this.alasan_keberatan || !this.alasan_keberatan.trim();
            if (field === 'kronologi_keberatan') return !this.kronologi_keberatan || !this.kronologi_keberatan.trim();
            if (field === 'disetujui') return !this.disetujui;
            return false;
        },

        getErrorMsg(field) {
            const messages = {
                'no_tiket_permohonan': 'Nomor tiket permohonan wajib diisi',
                'email': 'Email wajib diisi',
                'alasan_keberatan': 'Alasan keberatan wajib dipilih',
                'kronologi_keberatan': 'Kronologi keberatan wajib diisi',
                'disetujui': 'Anda harus menerima pernyataan untuk melanjutkan'
            };
            return messages[field] || 'Wajib diisi';
        },

        submitForm(e) {
            this.submitted = true;
            const fields = [
                'no_tiket_permohonan',
                'email',
                'alasan_keberatan',
                'kronologi_keberatan',
                'disetujui'
            ];

            const firstInvalid = fields.find(f => this.hasError(f));
            if (firstInvalid) {
                e.preventDefault();
                this.$nextTick(() => {
                    const el = document.querySelector(`[data-field="${firstInvalid}"]`) || document.getElementById(firstInvalid);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        const input = el.querySelector('input, select, textarea');
                        if (input && input.focus) input.focus();
                    }
                });
            } else {
                // Semua field valid - tampilkan loading splash
                this.isLoading = true;
                document.body.classList.add('overflow-hidden');
            }
        },

        handlePendukungFileChange(event) {
            const file = event.target.files[0];
            this.pendukungErrorMsg = '';
            this.pendukungFileName = '';
            this.pendukungFileSize = '';
            if (this.pendukungFileUrl) { URL.revokeObjectURL(this.pendukungFileUrl); this.pendukungFileUrl = ''; }
            if (!file) return;
            if (file.size > 5 * 1024 * 1024) {
                this.pendukungErrorMsg = 'Ukuran file maksimal 5MB';
                event.target.value = '';
                return;
            }
            this.pendukungFileName = file.name;
            this.pendukungFileSize = (file.size / 1024).toFixed(1) + ' KB';
            if (file.size > 1024*1024) this.pendukungFileSize = (file.size / (1024*1024)).toFixed(1) + ' MB';
            this.pendukungFileUrl = URL.createObjectURL(file);
        },
        clearPendukungFile() {
            const el = document.getElementById('pendukung_file_input');
            if (el) el.value = '';
            if (this.pendukungFileUrl) URL.revokeObjectURL(this.pendukungFileUrl);
            this.pendukungFileName = ''; this.pendukungFileSize = ''; this.pendukungFileUrl = ''; this.pendukungErrorMsg = '';
        }
    };
}
</script>
