@extends('components.layouts.admin')

@section('title', 'Detail Permohonan - ' . ($permohonan->no_tiket ?? 'PPID FMIPA'))
@section('header_title', 'Detail Permohonan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 pb-12">

    <x-admin.permohonan.detail.header :permohonan="$permohonan" />

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8 bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-5 sm:px-6 py-6 sm:py-7">
                <x-admin.permohonan.detail.detail-permohonan :permohonan="$permohonan" />
            </div>
        </div>
        <div class="lg:col-span-4 lg:sticky lg:top-6 space-y-4">
            <x-admin.permohonan.detail.status-panel :permohonan="$permohonan" />
        </div>
    </div>

</div>
@endsection
