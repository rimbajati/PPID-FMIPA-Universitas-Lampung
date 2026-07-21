@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-sm font-bold text-gray-400 bg-gray-100 rounded-2xl cursor-not-allowed">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-2xl hover:bg-gray-50 transition">Prev</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-2xl">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 text-sm font-bold text-white bg-[#1B365D] rounded-2xl">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-2xl hover:bg-gray-100 transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-2xl hover:bg-gray-50 transition">Next</a>
        @else
            <span class="px-4 py-2 text-sm font-bold text-gray-400 bg-gray-100 rounded-2xl cursor-not-allowed">Next</span>
        @endif
    </nav>
@endif
