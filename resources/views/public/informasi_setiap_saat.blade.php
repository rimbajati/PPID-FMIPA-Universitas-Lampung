@extends('layout.utama')

@section('title', 'Informasi Tersedia Setiap Saat - PPID FMIPA Unila')

@section('content')
<div class="container mx-auto px-4 py-12 pt-32 max-w-7xl">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Informasi Tersedia Setiap Saat</h1>
        <p class="text-gray-600 max-w-2xl text-sm md:text-base">
            Daftar informasi yang dapat diakses oleh publik setiap saat tanpa perlu melalui permohonan khusus.
        </p>
    </div>

    <!-- Search Form -->
    <form id="searchForm" action="{{ url('/informasi-setiap-saat') }}" method="GET" class="bg-white p-4 md:p-6 border border-gray-100 shadow-xl mb-8 flex flex-col md:flex-row gap-4 items-center rounded-3xl">
        <!-- Pagination Controls -->
        <input type="hidden" name="perPage" id="perPage_input" value="{{ request('perPage', 10) }}">

        <div class="relative w-full md:w-auto flex-[2]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari rincian atau sub informasi..."
                class="w-full border border-gray-200 rounded-2xl p-3 outline-none text-sm text-gray-600 focus:border-blue-500 transition">
        </div>
        <button type="submit" class="w-full md:w-auto px-8 py-3 bg-[#0a192f] text-white rounded-2xl font-bold text-sm hover:bg-black transition">Cari</button>
    </form>

    <!-- Data Table -->
    <div class="bg-white border border-gray-100 shadow-lg rounded-3xl overflow-hidden mb-10">
        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[700px] text-left border-collapse">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Rincian Informasi</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Sub Informasi</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Tanggal Upload</th>
                        <th class="px-8 py-5 text-[11px] font-bold text-gray-600 uppercase tracking-wider text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($informasi->groupBy('rincian_informasi') as $grup => $items)
                        @foreach($items as $index => $item)
                            <tr class="hover:bg-gray-50 transition {{ $loop->last ? 'border-b-2 border-gray-300' : 'border-b border-gray-100' }}">

                                @if($index === 0)
                                    <td rowspan="{{ $items->count() }}" class="p-5 pl-8 font-bold text-gray-900 align-top">
                                        {{ $grup }}
                                    </td>
                                @endif

                                <td class="p-5 text-gray-700">{{ $item->sub_informasi }}</td>
                                <td class="p-5 text-gray-500 text-sm">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="p-5 text-center">
                                    <a href="{{ url('/informasi/akses/'.$item->id) }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-block bg-[#0a192f] text-white text-[11px] font-bold px-6 py-2.5 rounded-full hover:bg-black transition shadow-sm whitespace-nowrap">
                                    LIHAT
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr><td colspan="4" class="p-10 text-center text-gray-400">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center mt-8">
        {{ $informasi->appends(request()->query())->links() }}
    </div>
</div>
@endsection

