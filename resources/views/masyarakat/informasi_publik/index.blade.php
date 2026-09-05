@extends('components.layouts.app')

@section('title', 'Katalog Informasi Publik - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-[64px] md:pt-[70px] bg-slate-100/70 min-h-screen pb-20">

    <!-- Header Hero Banner (Matching Reference UI Title & Subtitle) -->
    <x-masyarakat.informasi_publik.hero-header />

    <!-- Main 2-Column Grid Container (Matching Reference Layout) -->
    <div class="px-4 sm:px-8 md:px-12 lg:px-16 mt-4">
        <div class="max-w-[1600px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT COLUMN: Filter Bar & Table View (lg:col-span-9) -->
            <div class="lg:col-span-9 space-y-6">
                
                <!-- Pill Filter Bar & Search Box Card -->
                <x-masyarakat.informasi_publik.top-filter-bar :years="$years" :topiks="$topiks" :totalCount="$totalCount" :kategoryCounts="$kategoryCounts" />

                <!-- Catalog Table List with Dark Navy Header Bar -->
                <x-masyarakat.informasi_publik.catalog-grid :informasiList="$informasiList" />

            </div>

            <!-- RIGHT COLUMN: Tag Cloud & Permohonan (lg:col-span-3) -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Sidebar Card: Tag Cloud Quick Filter (Matching Reference Images 2 & 3) -->
                @php
                    $allTags = [];
                    $currentKategori = array_values(array_filter((array) request('kategori', [])));
                    $currentTopik    = array_values(array_filter((array) request('topik', [])));

                    // 1. Tag Kategori
                    foreach ($kategoryCounts as $cName => $cCount) {
                        $shortName = Str::replace('Informasi ', '', $cName);
                        $isAct = in_array($cName, $currentKategori);

                        // Build toggle URL for Kategori (Multi-select)
                        $params = request()->query();
                        $list = $currentKategori;
                        if ($isAct) {
                            $list = array_values(array_diff($list, [$cName]));
                        } else {
                            $list[] = $cName;
                        }
                        if (empty($list)) {
                            unset($params['kategori']);
                        } else {
                            $params['kategori'] = $list;
                        }
                        unset($params['page']);

                        $allTags[] = [
                            'label'  => $shortName,
                            'count'  => $cCount,
                            'url'    => url('/informasi-publik') . ($params ? '?' . http_build_query($params) : ''),
                            'active' => $isAct
                        ];
                    }

                    // 2. Tag Topik/Bidang
                    if (isset($topikCounts) && is_array($topikCounts)) {
                        foreach ($topikCounts as $tName => $tCount) {
                            $isAct = in_array($tName, $currentTopik);

                            // Build toggle URL for Topik (Multi-select)
                            $params = request()->query();
                            $list = $currentTopik;
                            if ($isAct) {
                                $list = array_values(array_diff($list, [$tName]));
                            } else {
                                $list[] = $tName;
                            }
                            if (empty($list)) {
                                unset($params['topik']);
                            } else {
                                $params['topik'] = $list;
                            }
                            unset($params['page']);

                            $allTags[] = [
                                'label'  => $tName,
                                'count'  => $tCount,
                                'url'    => url('/informasi-publik') . ($params ? '?' . http_build_query($params) : ''),
                                'active' => $isAct
                            ];
                        }
                    }

                    $totalTagsCount = count($allTags);
                    $initialLimit = 10;
                @endphp

                <div x-data="{ expanded: false }" class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-xs space-y-4">
                    <h3 class="text-md font-extrabold text-slate-800 tracking-tight">
                        Tag
                    </h3>

                    <!-- Tag List Container -->
                    <div :class="expanded ? 'max-h-72 overflow-y-auto pr-1 [scrollbar-width:thin]' : ''" class="transition-all duration-300">
                        <div class="flex flex-wrap gap-2">
                            @foreach($allTags as $index => $tag)
                                <a href="{{ $tag['url'] }}" 
                                   @if($index >= $initialLimit) x-show="expanded" x-cloak @endif
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold border transition shadow-2xs group cursor-pointer
                                          {{ $tag['active'] ? 'bg-sky-500 text-white border-sky-500 font-extrabold' : 'bg-slate-50 hover:bg-sky-50 text-slate-700 hover:text-sky-700 border-slate-200/80 hover:border-sky-200' }}">
                                    <span>{{ $tag['label'] }}</span>
                                    <span class="text-[11px] font-medium {{ $tag['active'] ? 'text-white/80' : 'text-slate-400 group-hover:text-sky-600' }}">
                                        {{ $tag['count'] }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Expand / Collapse Button -->
                    @if($totalTagsCount > $initialLimit)
                        <div class="pt-1 border-t border-slate-100 flex items-center justify-between">
                            <button type="button" 
                                    @click="expanded = !expanded" 
                                    class="text-xs font-bold text-slate-500 hover:text-sky-600 transition cursor-pointer flex items-center gap-1.5">
                                <span x-text="expanded ? 'Sembunyikan' : 'Lihat semua tag ({{ $totalTagsCount }})'"></span>
                                <i class="fa-solid text-[10px]" :class="expanded ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Ajukan Permohonan Card -->
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 text-white rounded-3xl p-6 shadow-lg shadow-blue-600/20 space-y-3 border border-blue-500/20">
                    <h4 class="font-extrabold text-base">Tidak Menemukan Informasi?</h4>
                    <p class="text-xs text-blue-100 leading-relaxed">
                        Anda dapat mengajukan permohonan informasi publik secara online melalui formulir permohonan resmi.
                    </p>
                    <a href="{{ url('/permohonan') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-blue-600 hover:bg-blue-50 font-extrabold text-xs rounded-full transition shadow-sm cursor-pointer">
                        <i class="fa-solid fa-file-circle-plus"></i> Ajukan Permohonan
                    </a>
                </div>
            </div>

        </div>
    </div>

</main>

<!-- Helper Script Scroll & Click Counter -->
<x-masyarakat.informasi_publik.script />
@endsection

