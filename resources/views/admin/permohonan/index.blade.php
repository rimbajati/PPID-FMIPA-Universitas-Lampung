@extends('components.layouts.admin')

@section('title', 'Dashboard Permohonan - Admin PPID')
@section('header_title', 'Permohonan Informasi')

@section('content')
<div class="space-y-6">

    <!-- Section Header & 5 Summary Overview Cards -->
    <x-admin.permohonan.summary-cards :totalPermohonan="$totalPermohonan" :totalMenunggu="$totalMenunggu" :totalDiproses="$totalDiproses" :totalSelesai="$totalSelesai" :totalDitolak="$totalDitolak" />

    <!-- Tabel Data Permohonan, Search, & Filter -->
    <x-admin.permohonan.table :permohonans="$permohonans" />

    <!-- Modal Konfirmasi Hapus Data (Single / Bulk) -->
    <x-modals.delete />
</div>
@endsection


