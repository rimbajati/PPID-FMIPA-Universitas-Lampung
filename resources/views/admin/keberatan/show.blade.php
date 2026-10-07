@extends('components.layouts.admin')

@section('title', 'Detail Keberatan - ' . ($keberatan->no_tiket ?? 'PPID FMIPA'))
@section('header_title', 'Detail Keberatan')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 pb-12">

    <x-admin.keberatan.detail.header :keberatan="$keberatan" />

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8 bg-white rounded-xl border border-slate-200 overflow-hidden">
            <div class="px-5 sm:px-6 py-6 sm:py-7">
                <x-admin.keberatan.detail.detail-keberatan :keberatan="$keberatan" />
            </div>
        </div>
        <div class="lg:col-span-4 lg:sticky lg:top-6">
            <x-admin.keberatan.detail.status-panel :keberatan="$keberatan" />
        </div>
    </div>

</div>
@endsection
