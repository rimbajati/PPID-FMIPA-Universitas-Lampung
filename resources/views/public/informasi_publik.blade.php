@extends('layouts.main')

@section('title', 'Informasi Publik - PPID FMIPA Unila')

@section('content')
<div class="container mx-auto px-4 py-12 pt-32 max-w-7xl">

    <div class="mb-10 text-center md:text-left">
        <div class="inline-block mb-3">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                Daftar Informasi Publik
            </h1>
            <div class="h-1.5 bg-[#0a192f] mt-2 w-1/2"></div>
        </div>
        <p class="text-sm md:text-base text-gray-600">
            Daftar informasi publik yang dikelola oleh PPID FMIPA Universitas Lampung.
        </p>
    </div>

    <form action="{{ url('/informasi-publik') }}" method="GET" class="bg-white p-5 border border-gray-200 mb-10 flex flex-col md:flex-row gap-4">
        <select name="kategori" onchange="this.form.submit()" class="border border-gray-200 rounded-none p-3 flex-1 outline-none text-sm text-gray-700 bg-gray-50 focus:border-[#0a192f] transition">
            <option value="">Semua Kategori</option>
            <option value="Informasi Berkala" {{ request('kategori') == 'Informasi Berkala' ? 'selected' : '' }}>Informasi Berkala</option>
            <option value="Informasi Serta-Merta" {{ request('kategori') == 'Informasi Serta-Merta' ? 'selected' : '' }}>Informasi Serta-Merta</option>
            <option value="Informasi Setiap Saat" {{ request('kategori') == 'Informasi Setiap Saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
        </select>
        <div class="relative flex-[2]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul..." class="w-full border border-gray-200 rounded-none p-3 outline-none text-sm text-gray-700 pr-10 focus:border-[#0a192f] transition">
            <button type="submit" class="absolute right-3 top-3.5 text-gray-400 hover:text-[#0a192f]">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>

    <div class="mb-10">
        <div class="hidden md:block bg-white border border-gray-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-[#0a192f] text-white">
                    <tr>
                        <th class="p-6 text-xs font-bold uppercase tracking-wider">Informasi</th>
                        <th class="p-6 text-xs font-bold uppercase tracking-wider w-48">Kategori</th>
                        <th class="p-6 text-xs font-bold uppercase tracking-wider w-24">Tahun</th>
                        <th class="p-6 text-xs font-bold uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($informasi as $dok)
                    <tr class="hover:bg-blue-50/50 transition-colors">
                        <td class="p-6 text-sm text-gray-800 font-medium">{{ $dok->judul_informasi }}</td>
                        <td class="p-6 whitespace-nowrap">
                            <span class="inline-block bg-blue-50 text-[#0a192f] text-[11px] font-bold px-3 py-1.5 border border-blue-200">
                                {{ $dok->kategori }}
                            </span>
                        </td>
                        <td class="p-6 text-sm text-gray-600">{{ $dok->tahun_publikasi }}</td>
                        <td class="p-6 whitespace-nowrap">
                            <a href="{{ route('akses.dokumen', $dok->id) }}" target="_blank"
                               class="inline-flex items-center text-sm font-semibold text-[#0a192f] hover:text-blue-600 transition">
                                <i class="fa-solid {{ $dok->tipe_informasi == 'link' ? 'fa-external-link' : 'fa-download' }} mr-2"></i>
                                {{ $dok->tipe_informasi == 'link' ? 'Buka Link' : 'Detail' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-12 text-center text-gray-500 italic">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden space-y-4">
            @forelse($informasi as $dok)
            <div class="bg-white p-5 border border-gray-200">
                <h4 class="font-bold text-gray-900 mb-2 leading-snug">{{ $dok->judul_informasi }}</h4>
                <div class="flex justify-between items-center text-xs text-gray-500 mb-4">
                    <span class="bg-blue-50 text-[#0a192f] font-bold px-2 py-0.5 border border-blue-200">{{ $dok->kategori }}</span>
                    <span>{{ $dok->tahun_publikasi }}</span>
                </div>
                <a href="{{ route('akses.dokumen', $dok->id) }}" target="_blank" class="block w-full text-center py-2 bg-[#0a192f] text-white text-sm font-bold">
                    {{ $dok->tipe_informasi == 'link' ? 'Buka Link' : 'Download Detail' }}
                </a>
            </div>
            @empty
            <div class="text-center p-10 text-gray-500 bg-white border border-gray-200">Data tidak ditemukan.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-sm text-gray-600">
            Menampilkan <b>{{ $informasi->firstItem() ?? 0 }}</b> - <b>{{ $informasi->lastItem() ?? 0 }}</b> dari <b>{{ $informasi->total() }}</b> data
        </div>

        <div class="flex gap-0">
            @if ($informasi->onFirstPage())
                <span class="px-4 py-2 bg-gray-100 text-gray-400 border border-gray-200 text-sm cursor-not-allowed">Prev</span>
            @else
                <a href="{{ $informasi->previousPageUrl() }}" class="px-4 py-2 bg-white border border-gray-200 text-sm hover:bg-[#0a192f] hover:text-white transition">Prev</a>
            @endif

            @foreach ($informasi->getUrlRange(max(1, $informasi->currentPage() - 2), min($informasi->lastPage(), $informasi->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" class="px-4 py-2 border border-l-0 border-gray-200 text-sm {{ ($page == $informasi->currentPage()) ? 'bg-[#0a192f] text-white' : 'bg-white hover:bg-gray-50' }}">
                    {{ $page }}
                </a>
            @endforeach

            @if ($informasi->hasMorePages())
                <a href="{{ $informasi->nextPageUrl() }}" class="px-4 py-2 bg-white border border-l-0 border-gray-200 text-sm hover:bg-[#0a192f] hover:text-white transition">Next</a>
            @else
                <span class="px-4 py-2 bg-gray-100 text-gray-400 border border-l-0 border-gray-200 text-sm cursor-not-allowed">Next</span>
            @endif
        </div>
    </div>

    <div class="mt-16 bg-[#0a192f] p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h3 class="text-2xl font-bold mb-2">Tidak menemukan yang Anda cari?</h3>
            <p class="text-sm text-gray-300">Anda dapat mengajukan permohonan informasi publik secara daring melalui formulir resmi kami.</p>
        </div>
        <a href="{{ route('permohonan.create') }}" class="bg-white text-[#000] hover:bg-gray-200 px-8 py-4 font-bold transition-all shadow-md whitespace-nowrap">
            Ajukan Permohonan Sekarang
        </a>
    </div>
</div>
@endsection
