@extends('components.layouts.app')

@section('title', 'Regulasi Keterbukaan Informasi Publik - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-50 min-h-screen pb-20">

    <!-- Header Hero Banner Regulasi -->
    <section class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 text-white py-12 md:py-16 relative overflow-hidden shadow-md">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full bg-sky-400/20 blur-2xl pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                Regulasi Keterbukaan Informasi Publik
            </h1>
            
            <p class="text-sky-100 text-sm sm:text-base font-normal leading-relaxed max-w-3xl">
                Daftar peraturan perundang-undangan Republik Indonesia dan peraturan internal Universitas Lampung yang menjadi dasar hukum penyelenggaraan layanan keterbukaan informasi publik di PPID Pelaksana FMIPA.
            </p>
        </div>
    </section>

    <!-- Konten Utama Regulasi -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 space-y-10">

        @php
            $nasional = collect($regulasi)->where('kategori', 'nasional');
            $internal = collect($regulasi)->where('kategori', 'internal');
        @endphp

        @if($nasional->count() > 0)
        <!-- Kategori 1: Peraturan Perundang-undangan Nasional -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-landmark"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Peraturan Perundang-undangan Nasional
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Hukum positif dan ketentuan pelaksanaan KIP tingkat nasional</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($nasional as $item)
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[11px] font-bold border border-sky-100">
                                {{ $item['badge'] }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400">{{ $item['tahun'] }}</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-sky-600 transition">
                            {{ $item['judul'] }}
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            {{ $item['deskripsi'] }}
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">{{ $item['sumber'] }}</span>
                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka Peraturan</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($internal->count() > 0)
        <!-- Kategori 2: Regulasi Internal Universitas Lampung -->
        <div class="space-y-4 pt-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Regulasi Internal Universitas Lampung
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Peraturan Rektor dan Surat Keputusan penetapan PPID di lingkungan Unila</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($internal as $item)
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-100">
                                {{ $item['badge'] }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400">{{ $item['tahun'] }}</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-amber-600 transition">
                            {{ $item['judul'] }}
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            {{ $item['deskripsi'] }}
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">{{ $item['sumber'] }}</span>
                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka Peraturan</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

</main>
@endsection
