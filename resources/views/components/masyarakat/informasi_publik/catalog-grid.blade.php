@props(['informasiList'])

<!-- Table Catalog View (Matching Reference UI Style) -->
<div class="space-y-4">
    <!-- Header Counter Text -->
    <div class="flex items-center justify-between px-1">
        <p class="text-xs md:text-sm text-slate-500 font-normal">
            Menampilkan {{ $informasiList->count() }} dari {{ $informasiList->total() }} informasi
        </p>
    </div>

    @if($informasiList->count() > 0)
        
        <!-- TABLE CONTAINER WITH SKY BLUE HEADER BAR -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            
            <!-- Table Sky Blue Header Bar -->
            <div class="bg-sky-500 text-white px-6 py-4 text-sm font-bold tracking-wider grid grid-cols-12 gap-4 items-center shadow-xs">
                <div class="col-span-7">Informasi</div>
                <div class="col-span-3 text-center">Kategori</div>
                <div class="col-span-2 text-center">Tahun Terbit</div>
            </div>

            <!-- Table Body Rows -->
            <div class="divide-y divide-slate-100">
                @php
                    $kategoriStyles = [
                        'Informasi Berkala'      => 'bg-[#1B365D] text-white',
                        'Informasi Serta-Merta'  => 'bg-rose-500 text-white',
                        'Informasi Setiap Saat'  => 'bg-emerald-500 text-white',
                        'Informasi Dikecualikan' => 'bg-slate-600 text-white',
                    ];
                @endphp

                @foreach($informasiList as $info)
                    @php
                        $detailUrl = route('informasi.detail', $info->id);
                        $badgeStyle = $kategoriStyles[$info->kategori_informasi] ?? 'bg-sky-500 text-white';
                    @endphp

                    <div class="px-6 py-4 hover:bg-sky-50/70 transition-colors grid grid-cols-12 gap-4 items-center group">
                        <!-- 1. INFORMASI -->
                        <div class="col-span-7 min-w-0 space-y-1">
                            <a href="{{ $detailUrl }}" 
                               class="text-sm font-extrabold text-slate-900 group-hover:text-slate-900 group-hover:underline group-hover:decoration-slate-900 transition-colors leading-snug block break-words [word-break:break-word]">
                                {{ $info->judul_informasi }}
                            </a>
                        </div>

                        <!-- 2. KATEGORI -->
                        <div class="col-span-3 flex items-center justify-center">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeStyle }} shadow-2xs inline-block text-center whitespace-nowrap">
                                {{ $info->kategori_informasi }}
                            </span>
                        </div>

                        <!-- 3. TAHUN TERBIT -->
                        <div class="col-span-2 flex items-center justify-center">
                            <span class="px-2.5 py-1 bg-sky-100 text-sky-700 text-[11px] font-extrabold rounded-full whitespace-nowrap">
                                {{ $info->tahun_terbit ?? '2026' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Pagination Footer (Matching Reference UI) -->
        <div class="pt-3 flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Page Indicator Left -->
            <p class="text-xs text-slate-500 font-medium">
                Halaman {{ $informasiList->currentPage() }} dari {{ $informasiList->lastPage() }}
            </p>

            <!-- Pagination Controls Right (Always Displayed) -->
            <div class="inline-flex items-center p-1 bg-slate-200/60 rounded-xl gap-1 text-xs font-semibold text-slate-600">
                {{-- First Page --}}
                @if($informasiList->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 cursor-not-allowed">«</span>
                @else
                    <a href="{{ $informasiList->url(1) }}" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/80 transition text-slate-700">«</a>
                @endif

                {{-- Previous Page --}}
                @if($informasiList->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $informasiList->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/80 transition text-slate-700">‹</a>
                @endif

                {{-- Page Numbers --}}
                @foreach($informasiList->getUrlRange(max(1, $informasiList->currentPage() - 2), min($informasiList->lastPage(), $informasiList->currentPage() + 2)) as $page => $url)
                    @if($page == $informasiList->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-slate-900 font-extrabold shadow-2xs border border-slate-300/60">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/80 transition text-slate-700">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page --}}
                @if($informasiList->hasMorePages())
                    <a href="{{ $informasiList->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/80 transition text-slate-700">›</a>
                @else
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 cursor-not-allowed">›</span>
                @endif

                {{-- Last Page --}}
                @if($informasiList->currentPage() == $informasiList->lastPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 cursor-not-allowed">»</span>
                @else
                    <a href="{{ $informasiList->url($informasiList->lastPage()) }}" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/80 transition text-slate-700">»</a>
                @endif
            </div>
        </div>

    @else
        <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center space-y-4 shadow-xs">
            <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-2xl mx-auto border border-sky-100">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-lg font-black text-slate-900">Tidak Ada Informasi Ditemukan</h3>
                <p class="text-xs md:text-sm text-slate-500 font-medium max-w-md mx-auto">
                    Coba ubah pencarian atau pilih kategori filter yang berbeda.
                </p>
            </div>
        </div>
    @endif
</div>

