@props(['paginator', 'label' => 'data'])

@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();

    // Generate page links array with ellipses
    $elements = [];
    if ($lastPage <= 9) {
        $elements[] = range(1, $lastPage);
    } else {
        if ($currentPage <= 4) {
            $elements[] = range(1, 5);
            $elements[] = '...';
            $elements[] = range($lastPage - 1, $lastPage);
        } elseif ($currentPage >= $lastPage - 3) {
            $elements[] = range(1, 2);
            $elements[] = '...';
            $elements[] = range($lastPage - 4, $lastPage);
        } else {
            $elements[] = range(1, 2);
            $elements[] = '...';
            $elements[] = range($currentPage - 1, $currentPage + 1);
            $elements[] = '...';
            $elements[] = range($lastPage - 1, $lastPage);
        }
    }
@endphp

<div class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full">
    <!-- Counter Left -->
    <div class="text-xs md:text-sm font-semibold text-slate-500">
        Menampilkan <span class="font-extrabold text-slate-900">{{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }}</span> dari <span class="font-black text-sky-600">{{ $paginator->total() }}</span> {{ $label }}
    </div>

    <!-- Unified Connected Pagination Box (Matching Reference Image) -->
    <div class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3.5 py-2 text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed select-none">
                ‹
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3.5 py-2 text-xs font-bold text-sky-500 hover:bg-sky-50 transition flex items-center justify-center">
                ‹
            </a>
        @endif

        {{-- Page Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-xs font-bold bg-slate-100/70 text-slate-400 select-none">
                    {{ $element }}
                </span>
            @elseif (is_array($element))
                @foreach ($element as $page)
                    @if ($page == $currentPage)
                        <span class="px-3.5 py-2 min-w-[38px] text-center text-xs font-extrabold bg-sky-500 text-white shadow-2xs">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($page) }}" class="px-3.5 py-2 min-w-[38px] text-center text-xs font-bold bg-white text-sky-500 hover:bg-sky-50 transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3.5 py-2 text-xs font-bold text-sky-500 hover:bg-sky-50 transition flex items-center justify-center">
                ›
            </a>
        @else
            <span class="px-3.5 py-2 text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed select-none">
                ›
            </span>
        @endif
    </div>
</div>
