@extends('components.layouts.admin')

@section('title', 'Dashboard Permohonan - Admin PPID')
@section('header_title', 'Permohonan Informasi')

@section('content')
<div class="space-y-6">

    <!-- Section Header & 5 Summary Overview Cards -->
    <x-admin.permohonan.summary-cards :totalPermohonan="$totalPermohonan" :totalMenunggu="$totalMenunggu" :totalDiproses="$totalDiproses" :totalSelesai="$totalSelesai" :totalDitolak="$totalDitolak" />

    <!-- Tabel Data Permohonan, Search, & Filter -->
    <x-admin.permohonan.table :permohonans="$permohonans" />
</div>
@endsection

@push('scripts')
<script>
(function () {
    // State sort per kolom
    const _sortState = { col: null, dir: 'asc' };

    window.sortPermohonanTable = function (col) {
        const tbody = document.querySelector('#form-bulk-delete tbody');
        if (!tbody) return;

        // Toggle arah
        if (_sortState.col === col) {
            _sortState.dir = _sortState.dir === 'asc' ? 'desc' : 'asc';
        } else {
            _sortState.col = col;
            _sortState.dir = 'asc';
        }

        const rows = Array.from(tbody.querySelectorAll('tr:not([colspan])'));
        rows.sort((a, b) => {
            let va = '', vb = '';
            if (col === 'no_tiket') {
                va = a.cells[1]?.textContent.trim() ?? '';
                vb = b.cells[1]?.textContent.trim() ?? '';
            } else if (col === 'tanggal') {
                va = a.cells[2]?.textContent.trim() ?? '';
                vb = b.cells[2]?.textContent.trim() ?? '';
            } else if (col === 'nama') {
                va = a.cells[3]?.querySelector('div')?.textContent.trim() ?? '';
                vb = b.cells[3]?.querySelector('div')?.textContent.trim() ?? '';
            } else if (col === 'status') {
                va = a.cells[5]?.textContent.trim() ?? '';
                vb = b.cells[5]?.textContent.trim() ?? '';
            }
            const cmp = va.localeCompare(vb, 'id', { sensitivity: 'base' });
            return _sortState.dir === 'asc' ? cmp : -cmp;
        });

        rows.forEach(r => tbody.appendChild(r));
    };
})();
</script>
@endpush
