@extends('components.layouts.admin')

@section('title', 'Manajemen Pengajuan Keberatan - Admin PPID')
@section('header_title', 'Pengajuan Keberatan')

@section('content')
<div class="space-y-6">

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

</div>
@endsection
