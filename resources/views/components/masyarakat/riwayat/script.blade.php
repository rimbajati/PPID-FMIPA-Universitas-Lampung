<script>
function lacakRiwayatApp(allLayansData) {
    return {
        allLayans: allLayansData || [],
        searchQuery: '',
        activeItem: null,
        currentPage: 1,
        perPage: 9,

        get totalPages() {
            return Math.ceil(this.allLayans.length / this.perPage) || 1;
        },

        get paginatedLayans() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.allLayans.slice(start, start + this.perPage);
        },

        get firstItem() {
            if (this.allLayans.length === 0) return 0;
            return (this.currentPage - 1) * this.perPage + 1;
        },

        get lastItem() {
            const end = this.currentPage * this.perPage;
            return end > this.allLayans.length ? this.allLayans.length : end;
        },

        get pageNumbers() {
            const total = this.totalPages;
            const current = this.currentPage;
            let pages = [];

            if (total <= 7) {
                for (let i = 1; i <= total; i++) pages.push(i);
            } else {
                if (current <= 4) {
                    pages = [1, 2, 3, 4, 5, '...', total];
                } else if (current >= total - 3) {
                    pages = [1, '...', total - 4, total - 3, total - 2, total - 1, total];
                } else {
                    pages = [1, '...', current - 1, current, current + 1, '...', total];
                }
            }
            return pages;
        },

        init() {
            this.activeItem = null;
            this.searchQuery = '';
            this.currentPage = 1;
        },

        goToPage(page) {
            if (page === '...' || page < 1 || page > this.totalPages) return;
            this.currentPage = page;
            this.$nextTick(() => {
                const el = document.getElementById('daftar-riwayat-grid');
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        },

        prevPage() {
            if (this.currentPage > 1) {
                this.goToPage(this.currentPage - 1);
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.goToPage(this.currentPage + 1);
            }
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
