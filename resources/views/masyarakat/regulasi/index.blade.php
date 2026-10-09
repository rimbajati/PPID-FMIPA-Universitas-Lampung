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

    <!-- Konten Utama Regulasi (Side-by-Side) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">

        @php
            $nasional = collect($regulasi)->where('kategori', 'nasional');
            $internal = collect($regulasi)->where('kategori', 'internal');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
            
            @if($nasional->count() > 0)
            <!-- Kolom Nasional -->
            <div class="space-y-6">
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Peraturan Nasional</h2>

                <div class="grid grid-cols-1 gap-4">
                    @foreach($nasional as $item)
                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="block bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-1.5 group cursor-pointer">
                        <h3 class="text-base font-black text-slate-900 group-hover:text-sky-600 transition">
                            {{ $item['judul'] }}
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            {{ $item['deskripsi'] }}
                        </p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if($internal->count() > 0)
            <!-- Kolom Internal -->
            <div class="space-y-6">
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Regulasi Internal Universitas Lampung</h2>

                <div class="grid grid-cols-1 gap-4">
                    @foreach($internal as $item)
                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="block bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-1.5 group cursor-pointer">
                        <h3 class="text-base font-black text-slate-900 group-hover:text-sky-600 transition">
                            {{ $item['judul'] }}
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            {{ $item['deskripsi'] }}
                        </p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

    </div>

</main>
@endsection
