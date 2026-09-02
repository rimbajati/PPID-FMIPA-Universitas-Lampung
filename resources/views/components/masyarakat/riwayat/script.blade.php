<script>
function lacakRiwayatApp(allLayansData) {
    return {
        allLayans: allLayansData || [],
        searchQuery: '',
        activeItem: null,

        init() {
            this.activeItem = null;
            this.searchQuery = '';
        },

        selectTiket(item) {
            let copy = JSON.parse(JSON.stringify(item));
            this.activeItem = copy;
            this.searchQuery = item.no_tiket;
            this.$nextTick(() => {
                const el = document.getElementById('hasil-tracking');
                if (el) el.scrollIntoView({ behavior: 'smooth' });
            });
        },

        lacakTiket() {
            if (!this.searchQuery.trim()) {
                alert('Silakan masukkan nomor tiket layanan terlebih dahulu.');
                return;
            }
            const q = this.searchQuery.trim().toLowerCase();
            const found = this.allLayans.find(i => i.no_tiket.toLowerCase() === q || ('#' + i.no_tiket.toLowerCase()) === q);
            
            if (found) {
                this.activeItem = found;
                this.$nextTick(() => {
                    const el = document.getElementById('hasil-tracking');
                    if (el) el.scrollIntoView({ behavior: 'smooth' });
                });
            } else {
                alert('Nomor tracking "' + this.searchQuery + '" tidak ditemukan pada riwayat Anda.');
            }
        }
    };
}
</script>
