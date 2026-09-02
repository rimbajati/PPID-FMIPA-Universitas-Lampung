@props(['user' => null])

<script>
function permohonanSingleForm() {
    return {
        selectedKategori: '',
        tujuan: '',
        rincian: '',
        cara_memperoleh: '',
        ktpName: '',
        pendukungName: '',
        disetujui: false,
        nik: '',
        nama_lengkap: @json($user ? ($user->nama_lengkap ?? $user->name) : ''),
        email: @json($user ? $user->email : ''),
        no_hp: @json($user ? ($user->no_hp ?? $user->no_telepon ?? '') : ''),
        alamat: @json($user ? ($user->alamat ?? $user->alamat_lengkap ?? '') : ''),
        pekerjaan: '',
        nama_organisasi_lembaga: '',

        handleIdentitasFileChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.ktpName = file.name;
            }
        },

        handlePendukungFileChange(e) {
            const file = e.target.files[0];
            if (file) {
                this.pendukungName = file.name;
            }
        }
    };
}
</script>
