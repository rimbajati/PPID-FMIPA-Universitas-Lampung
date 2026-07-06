@extends('layouts.dashboard')

@section('title', 'Riwayat Layanan')

@section('content')
<div class="w-full !max-w-none space-y-12">

    <div class="w-full">
        <h2 class="text-xl font-bold text-[#0a192f] mb-6">Riwayat Permohonan Informasi</h2>
        <div class="w-full bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-[#0a192f] text-white">
                        <tr>
                            <th class="px-8 py-5 font-bold whitespace-nowrap">No Tiket</th>
                            <th class="px-8 py-5 font-bold">Informasi Diminta</th>
                            <th class="px-8 py-5 font-bold whitespace-nowrap">Tanggal</th>
                            <th class="px-8 py-5 font-bold whitespace-nowrap">Status</th>
                            <th class="px-8 py-5 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($permohonans as $perm)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-8 py-5 font-mono font-bold text-[#0a192f] whitespace-nowrap">{{ $perm->no_tiket }}</td>
                            <td class="px-8 py-5 text-gray-700">
                                <div class="max-w-xs md:max-w-sm lg:max-w-md break-words">
                                    {{ $perm->info_diminta }}
                                </div>
                            </td>
                            <td class="px-8 py-5 text-gray-500 whitespace-nowrap">{{ $perm->created_at->format('d M Y') }}</td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full
                                    @if($perm->status == 'DIAJUKAN') bg-orange-100 text-orange-600
                                    @elseif($perm->status == 'DIPROSES') bg-blue-100 text-blue-600
                                    @elseif($perm->status == 'DITERIMA') bg-green-100 text-green-600
                                    @elseif($perm->status == 'DITOLAK') bg-red-100 text-red-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ $perm->status }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center"><button class="text-gray-400 hover:text-[#0a192f] text-lg"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-8 py-10 text-center text-gray-400">Belum ada riwayat permohonan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-4 border-t border-gray-100 bg-slate-50 flex items-center justify-between">
                <span class="text-xs text-gray-500">Menampilkan {{ $permohonans->firstItem() ?? 0 }} - {{ $permohonans->lastItem() ?? 0 }} dari {{ $permohonans->total() }} data</span>
                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white">
                    @if ($permohonans->onFirstPage())
                        <span class="px-3 py-2 text-gray-300 border-r border-gray-200"><i class="fa-solid fa-chevron-left text-[10px]"></i></span>
                    @else
                        <a href="{{ $permohonans->previousPageUrl() }}" class="px-3 py-2 text-gray-600 hover:bg-gray-50 border-r border-gray-200"><i class="fa-solid fa-chevron-left text-[10px]"></i></a>
                    @endif
                    @foreach ($permohonans->getUrlRange(1, $permohonans->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="px-4 py-2 text-xs font-bold border-r border-gray-200 {{ $page == $permohonans->currentPage() ? 'bg-[#0a192f] text-white' : 'text-gray-600 hover:bg-gray-50' }}">{{ $page }}</a>
                    @endforeach
                    @if ($permohonans->hasMorePages())
                        <a href="{{ $permohonans->nextPageUrl() }}" class="px-3 py-2 text-gray-600 hover:bg-gray-50"><i class="fa-solid fa-chevron-right text-[10px]"></i></a>
                    @else
                        <span class="px-3 py-2 text-gray-300"><i class="fa-solid fa-chevron-right text-[10px]"></i></span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="w-full">
        <h2 class="text-xl font-bold text-[#0a192f] mb-6">Riwayat Pengajuan Keberatan</h2>
        <div class="w-full bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-[#0a192f] text-white">
                        <tr>
                            <th class="px-8 py-5 font-bold whitespace-nowrap">No Tiket</th>
                            <th class="px-8 py-5 font-bold">Alasan Keberatan</th>
                            <th class="px-8 py-5 font-bold whitespace-nowrap">Tanggal</th>
                            <th class="px-8 py-5 font-bold whitespace-nowrap">Putusan</th>
                            <th class="px-8 py-5 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($keberatans as $keb)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-8 py-5 font-mono font-bold text-[#0a192f] whitespace-nowrap">{{ $keb->permohonan->no_tiket ?? '-' }}</td>
                            <td class="px-8 py-5 text-gray-700">
                                <div class="max-w-xs md:max-w-sm lg:max-w-md break-words">
                                    {{ $keb->alasan_keberatan }}
                                </div>
                            </td>
                            <td class="px-8 py-5 text-gray-500 whitespace-nowrap">{{ \Carbon\Carbon::parse($keb->tanggal_pengajuan)->format('d M Y') }}</td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full
                                    @if($keb->status_putusan == 'MENUNGGU') bg-amber-100 text-amber-600
                                    @elseif($keb->status_putusan == 'DITERIMA') bg-green-100 text-green-600
                                    @elseif($keb->status_putusan == 'DITOLAK') bg-red-100 text-red-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ $keb->status_putusan }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center"><button class="text-gray-400 hover:text-[#0a192f] text-lg"><i class="fa-solid fa-ellipsis-vertical"></i></button></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-8 py-10 text-center text-gray-400">Belum ada riwayat keberatan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-8 py-4 border-t border-gray-100 bg-slate-50 flex items-center justify-between">
                <span class="text-xs text-gray-500">Menampilkan {{ $keberatans->firstItem() ?? 0 }} - {{ $keberatans->lastItem() ?? 0 }} dari {{ $keberatans->total() }} data</span>
                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white">
                    @if ($keberatans->onFirstPage())
                        <span class="px-3 py-2 text-gray-300 border-r border-gray-200"><i class="fa-solid fa-chevron-left text-[10px]"></i></span>
                    @else
                        <a href="{{ $keberatans->previousPageUrl() }}" class="px-3 py-2 text-gray-600 hover:bg-gray-50 border-r border-gray-200"><i class="fa-solid fa-chevron-left text-[10px]"></i></a>
                    @endif
                    @foreach ($keberatans->getUrlRange(1, $keberatans->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="px-4 py-2 text-xs font-bold border-r border-gray-200 {{ $page == $keberatans->currentPage() ? 'bg-[#0a192f] text-white' : 'text-gray-600 hover:bg-gray-50' }}">{{ $page }}</a>
                    @endforeach
                    @if ($keberatans->hasMorePages())
                        <a href="{{ $keberatans->nextPageUrl() }}" class="px-3 py-2 text-gray-600 hover:bg-gray-50"><i class="fa-solid fa-chevron-right text-[10px]"></i></a>
                    @else
                        <span class="px-3 py-2 text-gray-300"><i class="fa-solid fa-chevron-right text-[10px]"></i></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
