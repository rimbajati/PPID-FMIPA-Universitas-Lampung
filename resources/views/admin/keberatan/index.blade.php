@extends('components.layouts.admin')

@section('title', 'Manajemen Pengajuan Keberatan - Admin PPID')
@section('header_title', 'Pengajuan Keberatan')

@section('content')
<div x-data="{ 
    detailModalOpen: false, 
    selectedKeberatan: null,
    tipeTanggapan: 'file',
    shouldRefreshOnClose: false,
    
    init() {
        window.keberatanAlpineComponent = this;
    },
    
    closeModal() {
        this.detailModalOpen = false;
        if (this.shouldRefreshOnClose) {
            window.location.reload();
        }
    },

    openDetail(item) {
        this.selectedKeberatan = item;
        this.detailModalOpen = true;
    }
}" class="space-y-6">

    <!-- 5 Summary Cards -->
    <x-admin.keberatan.summary-cards 
        :totalKeberatan="$totalKeberatan"
        :totalMenunggu="$totalMenunggu"
        :totalDiproses="$totalDiproses"
        :totalSelesai="$totalSelesai"
        :totalDitolak="$totalDitolak"
    />

    <!-- Tabel Data Pengajuan Keberatan -->
    <x-admin.keberatan.table :keberatans="$keberatans" />

    <!-- Modal Follow-up (harus di dalam x-data agar Alpine bisa akses state) -->
    <x-admin.keberatan.modal-follow-up />

</div>
@endsection

@push('scripts')
<x-admin.keberatan.script />
@endpush
