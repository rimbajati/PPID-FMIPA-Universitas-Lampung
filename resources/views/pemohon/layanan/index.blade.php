@extends('layout.bilah_sisi')

@section('content')
<div class="container mx-auto px-4 py-6">
    @if(session('success'))
    <div id="success-alert" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 text-sm">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <p class="font-semibold text-emerald-950 text-sm">{{ session('success') }}</p>
                @if(session('tiket'))
                <p class="text-xs text-emerald-700 font-medium mt-0.5">Nomor Tiket: {{ session('tiket') }}</p>
                @endif
            </div>
        </div>
        <button onclick="document.getElementById('success-alert').remove()" class="text-emerald-500 hover:text-emerald-700 text-lg ml-4">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Riwayat Pengajuan</h1>
            <p class="text-slate-500 text-sm mt-0.5">Daftar permohonan informasi dan pengajuan keberatan Anda di PPID FMIPA Unila.</p>
        </div>
        <button onclick="toggleModal('modal-form', true)" class="self-start md:self-auto inline-flex items-center gap-2 bg-[#1B365D] hover:bg-[#1B365D] text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
            <i class="fa-solid fa-plus text-xs"></i> Buat Pengajuan Baru
        </button>
    </div>

    <!-- Filter & Search Form -->
    <form id="filterForm" action="{{ url('/layanan') }}" method="GET" class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm mb-6 grid grid-cols-1 md:grid-cols-3 gap-3 items-center" onsubmit="event.preventDefault(); performLiveSearch(this);">
        <div>
            <select name="jenis_layanan" onchange="performLiveSearch(this.form)" class="w-full border-slate-200 bg-slate-50 rounded-lg p-2.5 text-sm font-medium text-slate-700 outline-none cursor-pointer hover:border-[#1B365D] focus:border-[#1B365D] transition">
                <option value="">Semua Jenis Layanan</option>
                <option value="Permohonan" {{ request('jenis_layanan') == 'Permohonan' ? 'selected' : '' }}>Permohonan Informasi</option>
                <option value="Keberatan" {{ request('jenis_layanan') == 'Keberatan' ? 'selected' : '' }}>Pengajuan Keberatan</option>
            </select>
        </div>
        <div>
            <select name="status" onchange="performLiveSearch(this.form)" class="w-full border-slate-200 bg-slate-50 rounded-lg p-2.5 text-sm font-medium text-slate-700 outline-none cursor-pointer hover:border-[#1B365D] focus:border-[#1B365D] transition">
                <option value="">Semua Status</option>
                @foreach(['DIAJUKAN', 'DIPROSES', 'PERBAIKAN', 'DITERIMA', 'DITOLAK'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" id="searchInput" placeholder="Cari nomor tiket atau rincian..." class="w-full border-slate-200 bg-slate-50 rounded-lg pl-10 pr-3 py-2.5 text-sm font-medium outline-none hover:border-[#1B365D] focus:border-[#1B365D] transition" autocomplete="off">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
        </div>
    </form>

    <div id="data-table-container" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden transition-opacity duration-200">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-xs uppercase text-slate-600 font-bold tracking-wider">
                        <th class="px-5 py-4">No. Tiket</th>
                        <th class="px-5 py-4 whitespace-nowrap">Jenis Layanan</th>
                        <th class="px-5 py-4">Rincian Pengajuan</th>
                        <th class="px-5 py-4 whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        @if(Str::startsWith($item->no_tiket, 'KEB'))
                            <td class="px-5 py-4 font-bold text-sm whitespace-nowrap" style="color: #d97706 !important;">
                                {{ $item->no_tiket }}
                            </td>
                        @else
                            <td class="px-5 py-4 font-bold text-sm whitespace-nowrap" style="color: #2563eb !important;">
                                {{ $item->no_tiket }}
                            </td>
                        @endif
                        <td class="px-5 py-4 text-slate-800 text-sm font-medium whitespace-nowrap">
                            {{ $item->jenis_layanan == 'Keberatan' ? 'Pengajuan Keberatan' : 'Permohonan Informasi' }}
                        </td>
                        <td class="px-5 py-4 text-slate-600 text-sm">
                            {{ $item->info_diminta ?? $item->tujuan_keberatan }}
                        </td>
                        <td class="px-5 py-4 text-slate-500 text-sm whitespace-nowrap">{{ $item->created_at->translatedFormat('j F Y') }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @php
                                $stClass = match($item->status) {
                                    'DIAJUKAN'  => 'bg-slate-100 text-slate-700 border border-slate-200',
                                    'DIPROSES'  => 'bg-blue-100 text-blue-700 border border-blue-200',
                                    'PERBAIKAN' => 'bg-amber-100 text-amber-700 border border-amber-200',
                                    'DITERIMA'  => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
                                    'DITOLAK'   => 'bg-rose-100 text-rose-700 border border-rose-200',
                                    default     => 'bg-slate-100 text-slate-600 border border-slate-200',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold inline-block uppercase text-center {{ $stClass }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5">
                                <button onclick="openSummaryModal({{ json_encode($item) }})"
                                        class="inline-flex items-center justify-center px-3.5 py-1.5 bg-[#1B365D] hover:bg-[#162c4c] text-white text-xs font-semibold rounded-lg shadow-sm transition active:scale-95 cursor-pointer">
                                    Detail
                                </button>
                                @if($item->file_jawaban)
                                    <a href="{{ asset('storage/' . $item->file_jawaban) }}" target="_blank" title="Unduh File Jawaban PPID"
                                       class="inline-flex items-center justify-center px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                        <i class="fa-solid fa-download mr-1"></i> File
                                    </a>
                                @endif
                                @if($item->link_jawaban)
                                    <a href="{{ $item->link_jawaban }}" target="_blank" title="Buka Link Jawaban PPID"
                                       class="inline-flex items-center justify-center px-2.5 py-1.5 bg-cyan-600 hover:bg-cyan-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                                        <i class="fa-solid fa-up-right-from-square mr-1"></i> Link
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400 text-sm">Belum ada riwayat pengajuan.</td></tr>
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

