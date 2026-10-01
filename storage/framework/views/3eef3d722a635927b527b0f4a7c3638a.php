<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['user' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['user' => null]); ?>
<?php foreach (array_filter((['user' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

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
        nama_lengkap: <?php echo json_encode($user ? ($user->nama_lengkap ?? $user->name) : '', 15, 512) ?>,
        email: <?php echo json_encode($user ? $user->email : '', 15, 512) ?>,
        no_hp: <?php echo json_encode($user ? ($user->no_hp ?? $user->no_telepon ?? '') : '', 15, 512) ?>,
        alamat: <?php echo json_encode($user ? ($user->alamat ?? $user->alamat_lengkap ?? '') : '', 15, 512) ?>,
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
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/masyarakat/permohonan/script.blade.php ENDPATH**/ ?>