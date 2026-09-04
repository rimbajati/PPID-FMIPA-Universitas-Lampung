@extends('components.layouts.app')

@section('title', $info->judul_informasi . ' - Detail Informasi Publik PPID FMIPA Unila')

@section('content')
@php
    $isLink = !empty($info->link_informasi) && empty($info->file_informasi);
    $viewUrl = route('informasi.lihat', $info->id);
    $embedUrl = $info->link_informasi;
    $isDriveFolder = false;

    if (!$isLink && !empty($info->nama_file_asli)) {
        $viewUrl = url('/informasi/file/' . $info->id . '/' . rawurlencode($info->nama_file_asli));
    } elseif ($isLink && !empty($info->link_informasi)) {
        $viewUrl = $info->link_informasi;
        if (str_contains($info->link_informasi, 'drive.google.com/file/d/')) {
            $embedUrl = preg_replace('/\/file\/d\/([a-zA-Z0-9_-]+).*/', '/file/d/$1/preview', $info->link_informasi);
        } elseif (str_contains($info->link_informasi, 'drive.google.com/drive/folders/')) {
            $isDriveFolder = true;
        } elseif (str_contains($info->link_informasi, 'docs.google.com/document/d/')) {
            $embedUrl = preg_replace('/\/document\/d\/([a-zA-Z0-9_-]+).*/', '/document/d/$1/preview', $info->link_informasi);
        } elseif (str_contains($info->link_informasi, 'docs.google.com/spreadsheets/d/')) {
            $embedUrl = preg_replace('/\/spreadsheets\/d\/([a-zA-Z0-9_-]+).*/', '/spreadsheets/d/$1/preview', $info->link_informasi);
        } elseif (str_contains($info->link_informasi, 'docs.google.com/presentation/d/')) {
            $embedUrl = preg_replace('/\/presentation\/d\/([a-zA-Z0-9_-]+).*/', '/presentation/d/$1/preview', $info->link_informasi);
        }
    }
@endphp

<main class="pt-[75px] md:pt-[85px] bg-slate-100/70 min-h-screen pb-20">

    <!-- Top Breadcrumbs Bar Component -->
    <x-masyarakat.informasi_publik.detail-breadcrumb :info="$info" />

    <!-- Main Split Detail & Preview Container -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-8 md:px-12 lg:px-16 mt-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT COLUMN: Information Detail Card -->
            <div class="lg:col-span-5 space-y-6">
                <x-masyarakat.informasi_publik.detail-left-card :info="$info" :isLink="$isLink" :viewUrl="$viewUrl" />
            </div>

            <!-- RIGHT COLUMN: Document Preview Frame -->
            <div class="lg:col-span-7 space-y-4">
                <x-masyarakat.informasi_publik.detail-preview-frame :info="$info" :isLink="$isLink" :viewUrl="$viewUrl" :embedUrl="$embedUrl" :isDriveFolder="$isDriveFolder" />
            </div>

        </div>
    </div>

</main>
@endsection
