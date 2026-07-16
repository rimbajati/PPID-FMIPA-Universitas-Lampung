@extends('layout.bilah_sisi')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(session('success'))
    <div id="success-alert" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center justify-between shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-circle-check text-lg"></i>
            </div>
            <div>
                <p class="font-bold text-emerald-950 text-base">{{ session('success') }}</p>
                @if(session('tiket'))
                <p class="text-xs text-emerald-700 font-semibold mt-0.5">Nomor Tiket: {{ session('tiket') }}</p>
                @endif
            </div>
        </div>
        <button onclick="document.getElementById('success-alert').remove()" class="text-emerald-400 hover:text-emerald-600 text-2xl font-bold ml-4">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Pengajuan</h1>
            <p class="text-slate-500 mt-1">Kelola dan pantau pengajuan informasi Anda.</p>
        </div>
        <button onclick="toggleModal('modal-form', true)" class="self-end md:self-auto group flex items-center gap-2 bg-blue-900 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-blue-800 transition-all shadow-lg">
            <i class="fa-solid fa-plus"></i> Buat Pengajuan
        </button>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr class="text-xs uppercase text-slate-500 font-bold tracking-wider">
                        <th class="px-6 py-5">No Tiket</th>
                        <th class="px-6 py-5 whitespace-nowrap">Jenis Layanan</th>
                        <th class="px-6 py-5">Rincian Pengajuan</th>
                        <th class="px-6 py-5 whitespace-nowrap">Tanggal Pengajuan</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-blue-900 whitespace-nowrap">{{ $item->no_tiket }}</td>
                        <td class="px-6 py-5 text-slate-800 text-sm font-semibold whitespace-nowrap">
                            {{ $item->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}
                        </td>
                        <td class="px-6 py-5 text-slate-600 text-sm max-w-xs">
                            <span class="truncate block" title="{{ $item->info_diminta ?? $item->tujuan_keberatan }}">
                                {{ Str::limit($item->info_diminta ?? $item->tujuan_keberatan, 45) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-slate-500 text-sm whitespace-nowrap">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold border
                                    {{ $item->status == 'DIAJUKAN' ? 'bg-amber-50/60 text-amber-800 border-amber-200/50' : '' }}
                                    {{ $item->status == 'DIPROSES' ? 'bg-blue-50/60 text-blue-800 border-blue-200/50' : '' }}
                                    {{ $item->status == 'DITERIMA' ? 'bg-emerald-50/60 text-emerald-800 border-emerald-200/50' : '' }}
                                    {{ $item->status == 'DITOLAK' ? 'bg-rose-50/60 text-rose-800 border-rose-200/50' : '' }}">
                                <span class="h-1.5 w-1.5 rounded-full
                                    {{ $item->status == 'DIAJUKAN' ? 'bg-amber-500' : '' }}
                                    {{ $item->status == 'DIPROSES' ? 'bg-blue-500' : '' }}
                                    {{ $item->status == 'DITERIMA' ? 'bg-emerald-500' : '' }}
                                    {{ $item->status == 'DITOLAK' ? 'bg-rose-500' : '' }}"></span>
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openSummaryModal({{ json_encode($item) }})"
                                        class="w-9 h-9 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl transition flex items-center justify-center hover:-translate-y-0.5 hover:shadow-sm"
                                        title="Lihat Detail">
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>
                                
                                @if($item->status == 'DIAJUKAN')
                                    <button onclick="openEditModal({{ json_encode($item) }})"
                                            class="w-9 h-9 bg-blue-50/50 hover:bg-blue-50 border border-blue-200/60 text-blue-600 rounded-xl transition flex items-center justify-center hover:-translate-y-0.5 hover:shadow-sm"
                                            title="Edit Pengajuan">
                                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                                    </button>
                                    <button onclick="deletePengajuan({{ $item->id }}, '{{ $item->no_tiket }}')"
                                            class="w-9 h-9 bg-rose-50/50 hover:bg-rose-50 border border-rose-200/60 text-rose-600 rounded-xl transition flex items-center justify-center hover:-translate-y-0.5 hover:shadow-sm"
                                            title="Hapus Pengajuan">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                @else
                                    <button class="w-9 h-9 bg-slate-50 border border-slate-200/60 text-slate-400 rounded-xl cursor-not-allowed flex items-center justify-center" disabled title="Pengajuan Terkunci (Sedang Diproses)">
                                        <i class="fa-solid fa-lock text-xs"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-slate-400">Belum ada riwayat pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals -->
@include('pemohon.layanan.modals.modal_formulir')
@include('pemohon.layanan.modals.modal_konfirmasi')
@include('pemohon.layanan.modals.modal_ringkasan')
@include('pemohon.layanan.modals.modal_hapus')

<!-- Scripts -->
@include('pemohon.layanan.modals.script')

@endsection

