<script>
function permohonanSingleForm() {
    return {
        tujuan: @json(old('tujuan_penggunaan_informasi', '')),
        rincian: @json(old('informasi_yang_diminta', '')),
        jenis_permohonan: @json(old('jenis_permohonan', 'Mendapatkan salinan')),
        cara_memperoleh: @json(old('cara_memperoleh_informasi', 'Salinan Digital (Dikirim melalui Email)')),
        ktpName: '',
        ktpSize: '',
        ktpUrl: '',
        ktpErrorMsg: '',
        jenis_identitas: @json(old('jenis_identitas', 'KTP')),
        nik: @json(old('no_identitas', '')),
        nama_lengkap: @json(old('nama_lengkap', '')),
        email: @json(old('email', '')),
        no_hp: @json(old('no_telepon', '')),
        pekerjaan: @json(old('pekerjaan', '')),
        alamat_lengkap: @json(old('alamat_lengkap', '')),
        has_file: false,
        disetujui: false,

        get labelNomorIdentitas() {
            if (this.jenis_identitas === 'Paspor') return 'Nomor Paspor';
            if (this.jenis_identitas === 'Badan hukum') return 'Nomor Akta Notaris / SK Pendirian';
            return 'NIK (Nomor Induk Kependudukan)';
        },

        get placeholderNomorIdentitas() {
            if (this.jenis_identitas === 'Paspor') return 'Contoh: A12345678';
            if (this.jenis_identitas === 'Badan hukum') return 'Contoh: AHU-0012345.AH.01.01 atau No. Akta Notaris';
            return 'Masukkan 16 digit NIK';
        },

        get hintNomorIdentitas() {
            if (this.jenis_identitas === 'Paspor') return 'Nomor pada paspor resmi pemohon yang masih berlaku.';
            if (this.jenis_identitas === 'Badan hukum') return 'Nomor Akta Notaris atau SK Pengesahan Kemenkumham lembaga Anda.';
            return 'Nomor NIK 16 digit pada KTP asli yang Anda unggah.';
        },

        get labelSalinanIdentitas() {
            if (this.jenis_identitas === 'Paspor') return 'Salinan Paspor';
            if (this.jenis_identitas === 'Badan hukum') return 'Salinan Akta Notaris / SK Pendirian';
            return 'Salinan Identitas (KTP)';
        },

        submitted: false,
        isLoading: false,

        hasError(field) {
            if (!this.submitted) return false;
            if (field === 'nama_lengkap') return !this.nama_lengkap || !this.nama_lengkap.trim();
            if (field === 'no_telepon') return !this.no_hp || !this.no_hp.trim();
            if (field === 'email') return !this.email || !this.email.trim();
            if (field === 'jenis_identitas') return !this.jenis_identitas;
            if (field === 'no_identitas') return !this.nik || !this.nik.trim();
            if (field === 'file_identitas') return !this.has_file;
            if (field === 'pekerjaan') return !this.pekerjaan || !this.pekerjaan.trim();
            if (field === 'alamat_lengkap') return !this.alamat_lengkap || !this.alamat_lengkap.trim();
            if (field === 'informasi_yang_diminta') return !this.rincian || !this.rincian.trim();
            if (field === 'tujuan_penggunaan_informasi') return !this.tujuan || !this.tujuan.trim();
            if (field === 'cara_memperoleh_informasi') return !this.cara_memperoleh || !this.cara_memperoleh.trim();
            if (field === 'disetujui') return !this.disetujui;
            return false;
        },

        getErrorMsg(field) {
            const messages = {
                'nama_lengkap': 'Nama lengkap wajib diisi',
                'no_telepon': 'Nomor WhatsApp/Telepon wajib diisi',
                'email': 'Email wajib diisi',
                'jenis_identitas': 'Jenis identitas wajib dipilih',
                'no_identitas': 'Nomor identitas wajib diisi',
                'file_identitas': 'Salinan identitas wajib diunggah',
                'pekerjaan': 'Pekerjaan wajib diisi',
                'alamat_lengkap': 'Alamat lengkap wajib diisi',
                'informasi_yang_diminta': 'Informasi yang diminta wajib diisi',
                'tujuan_penggunaan_informasi': 'Tujuan penggunaan informasi wajib diisi',
                'cara_memperoleh_informasi': 'Cara memperoleh informasi wajib dipilih',
                'disetujui': 'Anda harus menerima pernyataan untuk melanjutkan'
            };
            return messages[field] || 'Wajib diisi';
        },

        submitForm(e) {
            this.submitted = true;
            const fields = [
                'nama_lengkap',
                'no_telepon',
                'email',
                'jenis_identitas',
                'no_identitas',
                'file_identitas',
                'pekerjaan',
                'alamat_lengkap',
                'informasi_yang_diminta',
                'tujuan_penggunaan_informasi',
                'cara_memperoleh_informasi',
                'disetujui'
            ];

            const firstInvalid = fields.find(f => this.hasError(f));
            if (firstInvalid) {
                e.preventDefault();
                this.$nextTick(() => {
                    const el = document.querySelector(`[data-field="${firstInvalid}"]`) || document.getElementById(firstInvalid) || document.getElementById(`checkbox_${firstInvalid}`);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        if (el.focus) el.focus();
                    }
                });
            } else {
                // Semua field valid - tampilkan loading splash
                this.isLoading = true;
                document.body.classList.add('overflow-hidden');
            }
        },

        handleIdentitasInput(e) {
            if (this.jenis_identitas === 'KTP') {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                this.nik = e.target.value;
            } else {
                this.nik = e.target.value;
            }
        },

        handleIdentitasFileChange(e) {
            const files = e.target.files;
            this.ktpErrorMsg = '';
            if (this.ktpUrl) { URL.revokeObjectURL(this.ktpUrl); this.ktpUrl = ''; }
            if (files && files.length > 0) {
                const f = files[0];
                if (f.size > 2 * 1024 * 1024) {
                    this.ktpErrorMsg = 'Ukuran berkas maksimal 2 MB';
                    e.target.value = '';
                    this.ktpName = ''; this.ktpSize = ''; this.has_file = false; return;
                }
                this.ktpName = f.name;
                this.ktpSize = (f.size / 1024).toFixed(1) + ' KB';
                if (f.size > 1024 * 1024) this.ktpSize = (f.size / (1024*1024)).toFixed(1) + ' MB';
                this.ktpUrl = URL.createObjectURL(f);
                this.has_file = true;
            } else {
                this.ktpName = ''; this.ktpSize = ''; this.has_file = false;
            }
        },
        clearIdentitasFile() {
            const el = document.getElementById('file_identitas');
            if (el) el.value = '';
            if (this.ktpUrl) URL.revokeObjectURL(this.ktpUrl);
            this.ktpName = ''; this.ktpSize = ''; this.ktpUrl = ''; this.has_file = false; this.ktpErrorMsg = '';
        }
    };
}
</script>
