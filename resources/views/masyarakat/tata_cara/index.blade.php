@extends('components.layouts.app')

@section('title', ($tataCara['header_judul'] ?? 'Tata Cara Permohonan dan Keberatan') . ' - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-50 min-h-screen pb-20">

    <!-- Header Hero Banner -->
    <section class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 text-white py-12 md:py-16 relative overflow-hidden shadow-md">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full bg-sky-400/20 blur-2xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">{{ $tataCara['header_judul'] }}</h1>
            <p class="w-full max-w-none text-sky-100 text-sm sm:text-base font-normal leading-relaxed">{{ $tataCara['header_deskripsi'] }}</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 space-y-12">

        <!-- Grid 2 Kartu Prosedur Utama: Permohonan & Keberatan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- KARTU 1: TATA CARA PERMOHONAN INFORMASI -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-black border border-blue-100">
                            <i class="fa-solid fa-file-signature text-blue-600"></i>
                            <span>{{ $tataCara['permohonan_badge'] }}</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-bold">{{ $tataCara['permohonan_sla'] }}</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $tataCara['permohonan_judul'] }}</h2>
                    <p class="text-sm md:text-base text-slate-600 font-medium leading-relaxed">{{ $tataCara['permohonan_deskripsi'] }}</p>
                    <div class="space-y-4 pt-2">
                        @foreach(($tataCara['permohonan_langkah'] ?? []) as $idx => $step)
                        <div class="flex items-start gap-3.5">
                            <span class="w-9 h-9 rounded-xl bg-blue-600 text-white font-black flex items-center justify-center text-sm shrink-0 shadow-sm shadow-blue-600/30">{{ $idx + 1 }}</span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-base sm:text-lg text-slate-900">{{ $step['judul'] }}</h4>
                                <p class="text-sm md:text-base text-slate-600 font-medium leading-relaxed">{{ $step['deskripsi'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-3">
                    <a href="{{ route('layanan.permohonan') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm md:text-base font-bold rounded-2xl transition shadow-sm hover:shadow inline-flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-xs"></i><span>Buat Permohonan Informasi</span>
                    </a>
                </div>
            </div>

            <!-- KARTU 2: TATA CARA PENGAJUAN KEBERATAN -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-sm font-black border border-amber-100">
                            <i class="fa-solid fa-scale-balanced text-amber-600"></i>
                            <span>{{ $tataCara['keberatan_badge'] }}</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-bold">{{ $tataCara['keberatan_sla'] }}</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $tataCara['keberatan_judul'] }}</h2>
                    <p class="text-sm md:text-base text-slate-600 font-medium leading-relaxed">{{ $tataCara['keberatan_deskripsi'] }}</p>
                    <div class="space-y-4 pt-2">
                        @foreach(($tataCara['keberatan_langkah'] ?? []) as $idx => $step)
                        <div class="flex items-start gap-3.5">
                            <span class="w-9 h-9 rounded-xl bg-amber-500 text-white font-black flex items-center justify-center text-sm shrink-0 shadow-sm shadow-amber-500/30">{{ $idx + 1 }}</span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-base sm:text-lg text-slate-900">{{ $step['judul'] }}</h4>
                                <p class="text-sm md:text-base text-slate-600 font-medium leading-relaxed">{{ $step['deskripsi'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-3">
                    <a href="{{ route('layanan.keberatan') }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white text-sm md:text-base font-bold rounded-2xl transition shadow-sm hover:shadow inline-flex items-center gap-2">
                        <i class="fa-solid fa-scale-balanced text-xs"></i><span>Ajukan Keberatan</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Section: Waktu Layanan & Biaya -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 sm:p-7 rounded-3xl bg-white border border-slate-200/90 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center text-lg"><i class="fa-regular fa-clock"></i></div>
                <h3 class="text-lg font-black text-slate-900">{{ $tataCara['sla_judul'] }}</h3>
                <ul class="space-y-2 text-sm md:text-base text-slate-600 font-medium">
                    @foreach(($tataCara['sla_items'] ?? []) as $item)
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check text-sky-600 text-xs mt-1"></i><span>{{ $item }}</span></li>
                    @endforeach
                </ul>
            </div>
            <div class="p-6 sm:p-7 rounded-3xl bg-white border border-slate-200/90 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg"><i class="fa-solid fa-coins"></i></div>
                <h3 class="text-lg font-black text-slate-900">{{ $tataCara['biaya_judul'] }}</h3>
                <ul class="space-y-2 text-sm md:text-base text-slate-600 font-medium">
                    @foreach(($tataCara['biaya_items'] ?? []) as $item)
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check text-emerald-600 text-xs mt-1"></i><span>{{ $item }}</span></li>
                    @endforeach
                    @if(!empty($tataCara['biaya_link_url']))
                    <li class="flex items-start gap-2"><i class="fa-solid fa-check text-emerald-600 text-xs mt-1"></i><span><a href="{{ $tataCara['biaya_link_url'] }}" target="_blank" class="text-sky-600 hover:underline font-bold">{{ $tataCara['biaya_link_text'] }}</a></span></li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Section: SOP & Dokumen Standar -->
        <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-black border border-slate-200 mb-2">
                        <i class="fa-solid fa-file-pdf text-sky-600"></i><span>{{ $tataCara['dokumen_badge'] }}</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900">{{ $tataCara['dokumen_judul'] }}</h3>
                </div>
                @if(!empty($tataCara['dokumen_link_url']))
                <a href="{{ $tataCara['dokumen_link_url'] }}" target="_blank" class="text-sm md:text-base font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5 self-start sm:self-auto">
                    <span>{{ $tataCara['dokumen_link_text'] }}</span><i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach(($tataCara['dokumen'] ?? []) as $dok)
                <a href="{{ $dok['url'] }}" target="_blank" class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 hover:bg-sky-50/60 hover:border-sky-200 transition group flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-sky-600 flex items-center justify-center shrink-0 group-hover:bg-sky-600 group-hover:text-white transition"><i class="fa-solid fa-file-contract text-sm"></i></div>
                    <div class="min-w-0"><h5 class="text-sm sm:text-base font-extrabold text-slate-900 group-hover:text-sky-700 transition">{{ $dok['judul'] }}</h5><p class="text-sm text-slate-500 font-medium mt-0.5">{{ $dok['deskripsi'] }}</p></div>
                </a>
                @endforeach
            </div>
        </div>

    </div>

</main>
@endsection
