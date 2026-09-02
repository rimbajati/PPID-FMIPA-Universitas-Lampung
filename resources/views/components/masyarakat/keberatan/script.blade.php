@props(['user' => null, 'permohonanUser' => []])

<script>
function keberatanForm() {
    return {
        submitted: false,
        selectedKategori: '',
        nomor_tracking_asal: '',
        alasan_keberatan: '',
        kronologi_keberatan: '',
        permohonan_id: '',
        pendukungName: '',
        pendukungUrl: '',
        pendukungErrorMsg: '',
        disetujui: false,
        nik: '',
        nama_lengkap: @json($user ? ($user->nama_lengkap ?? $user->name) : ''),
        email: @json($user ? $user->email : ''),
        no_hp: @json($user ? ($user->no_hp ?? $user->no_telepon ?? '') : ''),
        alamat: @json($user ? ($user->alamat ?? $user->alamat_lengkap ?? '') : ''),
        pekerjaan: '',
        nama_organisasi_lembaga: '',
        permohonanList: @json($permohonanUser),
        dropdownOpen: false,
        selectedPermohonanDetail: null,
        rincian_informasi_asal: '',

        selectPermohonan(item) {
            this.nomor_tracking_asal = item.no_tiket;
            this.permohonan_id = item.id;
            this.rincian_informasi_asal = item.informasi_yang_diminta || '';
            this.selectedPermohonanDetail = item;

            if (item.kategori_pemohon) this.selectedKategori = item.kategori_pemohon;
            if (item.nama_organisasi_lembaga) this.nama_organisasi_lembaga = item.nama_organisasi_lembaga;
            if (item.nik) this.nik = item.nik;
            if (item.nama_lengkap) this.nama_lengkap = item.nama_lengkap;
            if (item.email) this.email = item.email;
            if (item.no_hp) this.no_hp = item.no_hp;
            if (item.alamat) this.alamat = item.alamat;
            if (item.pekerjaan) this.pekerjaan = item.pekerjaan;

            this.dropdownOpen = false;
        },

        init() {
            const urlParams = new URLSearchParams(window.location.search);
            const tiketParam = urlParams.get('tiket');
            if (tiketParam && this.permohonanList.length > 0) {
                const found = this.permohonanList.find(p => p.no_tiket.toLowerCase() === tiketParam.toLowerCase());
                if (found) {
                    this.selectPermohonan(found);
                }
            }
        },

        onTrackingInput() {
            const found = this.permohonanList.find(p => p.no_tiket.toLowerCase() === this.nomor_tracking_asal.trim().toLowerCase());
            if (found) {
                this.selectPermohonan(found);
            } else {
                this.selectedPermohonanDetail = null;
                this.rincian_informasi_asal = '';
            }
        },

        isValidForm() {
            if (!this.nomor_tracking_asal || !String(this.nomor_tracking_asal).trim()) return false;
            if (!this.alasan_keberatan) return false;
            if (!this.kronologi_keberatan || !String(this.kronologi_keberatan).trim()) return false;
            if (!this.disetujui) return false;
            return true;
        },

        handlePendukungFileChange(event) {
            const file = event.target.files[0];
            this.pendukungErrorMsg = '';
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    this.pendukungErrorMsg = 'Ukuran file Berkas Pendukung maksimal 5MB!';
                    event.target.value = '';
                    this.pendukungName = '';
                    this.pendukungUrl = '';
                    return;
                }
                this.pendukungName = file.name;
                this.pendukungUrl = URL.createObjectURL(file);
            } else {
                this.pendukungName = '';
                this.pendukungUrl = '';
            }
        },

        removePendukungFile() {
            const input = document.getElementById('pendukung_file_input');
            if (input) input.value = '';
            this.pendukungName = '';
            this.pendukungUrl = '';
            this.pendukungErrorMsg = '';
        },

        scrollToFirstError() {
            this.$nextTick(() => {
                const el = document.querySelector('.border-red-500, input:invalid, select:invalid, textarea:invalid');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    el.focus();
                }
            });
        }
    };
}
</script>
