@props(['info', 'isLink', 'viewUrl'])

@php
    $kategoriStyles = [
        'Informasi Berkala'      => ['bg' => 'bg-[#1B365D]', 'text' => 'text-white'],
        'Informasi Serta-Merta'  => ['bg' => 'bg-rose-500', 'text' => 'text-white'],
        'Informasi Setiap Saat'  => ['bg' => 'bg-emerald-500', 'text' => 'text-white'],
        'Informasi Dikecualikan' => ['bg' => 'bg-slate-600', 'text' => 'text-white'],
    ];
    $style = $kategoriStyles[$info->kategori_informasi] ?? ['bg' => 'bg-sky-500', 'text' => 'text-white'];
@endphp

<div class="bg-white border border-slate-200/90 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
    
    <!-- Badges Row -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold {{ $style['bg'] }} {{ $style['text'] }} shadow-xs">
                {{ $info->kategori_informasi }}
            </span>
            <span class="px-3.5 py-1.5 bg-sky-50 text-sky-700 border border-sky-100 text-xs font-extrabold rounded-full">
                Tahun {{ $info->tahun_terbit ?? '2026' }}
            </span>
        </div>

        <div class="flex items-center gap-1.5 text-xs text-slate-500 font-bold shrink-0 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-100">
            <i class="fa-regular fa-eye text-sky-500"></i>
            <span>Dilihat {{ number_format($info->dilihat ?? 0) }} kali</span>
        </div>
    </div>

    <!-- Title -->
    <h1 class="text-xl md:text-2xl font-black text-slate-900 leading-snug break-words">
        {{ $info->judul_informasi }}
    </h1>

    <!-- Description -->
    @if($info->deskripsi_informasi)
        <p class="text-xs md:text-sm text-slate-600 font-medium leading-relaxed break-words [word-break:break-word] whitespace-pre-line">
            {{ $info->deskripsi_informasi }}
        </p>
    @endif

    <!-- File & Info Attributes -->
    <div class="space-y-4 pt-2 border-t border-slate-100">

        <div class="space-y-3 text-xs font-semibold text-slate-600">
            @if($isLink)
                <div class="flex items-center justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-link text-slate-400 text-xs w-4"></i> Tautan
                    </span>
                    <span class="font-extrabold text-slate-800 truncate max-w-[220px]" title="{{ $info->link_informasi }}">{{ $info->link_informasi }}</span>
                </div>
            @else
                <div class="flex items-center justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-paperclip text-slate-400 text-xs w-4"></i> Nama File
                    </span>
                    <span class="font-extrabold text-slate-800 truncate max-w-[220px]" title="{{ $info->nama_file_asli ?: $info->file_informasi }}">{{ $info->nama_file_asli ?: $info->file_informasi ?: '-' }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    @if($info->kategori_informasi !== 'Informasi Dikecualikan')
        <div class="pt-2">
            @if($isLink)
                <a href="{{ $viewUrl }}" target="_blank" class="w-full py-3.5 px-6 bg-sky-500 hover:bg-sky-600 text-white font-extrabold text-xs md:text-sm rounded-2xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2.5 cursor-pointer">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span>Buka Tautan</span>
                </a>
            @else
                <a href="{{ $viewUrl }}" download class="w-full py-3.5 px-6 bg-sky-500 hover:bg-sky-600 text-white font-extrabold text-xs md:text-sm rounded-2xl transition shadow-md hover:shadow-lg flex items-center justify-center gap-2.5 cursor-pointer">
                    <i class="fa-solid fa-download text-xs"></i>
                    <span>Unduh File Informasi</span>
                </a>
            @endif
        </div>
    @endif

</div>
