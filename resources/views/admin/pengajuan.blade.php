@extends('layouts.admin')

@section('title', 'Manajemen Pengajuan - PPID FMIPA Unila')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Manajemen Pengajuan</h1>
        <p class="text-sm text-gray-500">Daftar integrasi permohonan informasi dan keberatan</p>
    </div>

    <!-- Statistik Grid -->
    <div class="flex gap-4 overflow-x-auto pb-4 lg:grid lg:grid-cols-5 lg:gap-6 lg:pb-0 mb-10">
        <!-- Total -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-slate-600 to-slate-800 rounded-3xl p-6 text-white shadow-xl shadow-slate-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-folder-open text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Total</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalPermohonan ?? 0 }}
            </div>
        </div>

        <!-- Diajukan -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-gray-500 to-gray-700 rounded-3xl p-6 text-white shadow-xl shadow-gray-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-paper-plane text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Diajukan</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalDiajukan ?? 0 }}
            </div>
        </div>

        <!-- Diproses -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-sky-500 to-blue-600 rounded-3xl p-6 text-white shadow-xl shadow-blue-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-spinner text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Diproses</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalDiproses ?? 0 }}
            </div>
        </div>

        <!-- Diterima -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-3xl p-6 text-white shadow-xl shadow-emerald-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-check-circle text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Diterima</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalDiterima ?? 0 }}
            </div>
        </div>

        <!-- Ditolak -->
        <div class="min-w-[200px] lg:min-w-0 relative bg-gradient-to-br from-red-500 to-red-700 rounded-3xl p-6 text-white shadow-xl shadow-red-900/10 overflow-hidden h-44">
            <div class="flex items-center gap-3 z-10 relative">
                <i class="fa-solid fa-times-circle text-2xl text-white/80"></i>
                <span class="text-lg font-bold tracking-wider uppercase leading-tight">Ditolak</span>
            </div>
            <div class="absolute -bottom-6 right-10 text-[100px] font-black text-white/40 select-none pointer-events-none">
                {{ $totalDitolak ?? 0 }}
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-lg overflow-hidden mb-10">
        <form action="{{ url('/admin/pengajuan') }}" method="GET" class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-lg font-extrabold text-gray-900">Daftar Pengajuan</h2>
            <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-xl text-sm font-bold bg-white cursor-pointer hover:border-blue-500 transition shadow-sm">
                <option value="">Semua Status</option>
                @foreach(['DIAJUKAN', 'DIPROSES', 'DITERIMA', 'DITOLAK'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </form>

        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[1000px] text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-[11px] font-extrabold text-gray-600 uppercase border-b border-gray-200">
                        <th class="p-5 pl-8">No. Tiket</th>
                        <th class="p-5">Jenis</th>
                        <th class="p-5">Pemohon</th>
                        <th class="p-5">Rincian</th>
                        <th class="p-5">Tanggal</th>
                        <th class="p-5">Status</th>
                        <th class="p-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($permohonans as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-5 pl-8 font-mono font-bold text-[#0095e8]">{{ $item->no_tiket }}</td>
                            <td class="p-5">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase
                                    {{ $item->jenis_layanan == 'Permohonan' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                    {{ $item->jenis_layanan }}
                                </span>
                            </td>
                            <td class="p-5">
                                <div class="font-bold text-gray-900">{{ $item->nama }}</div>
                            </td>
                            <td class="p-5 text-gray-600 max-w-[250px] truncate" title="{{ $item->jenis_layanan == 'Permohonan' ? $item->info_diminta : $item->tujuan_keberatan }}">
                                {{ $item->jenis_layanan == 'Permohonan' ? $item->info_diminta : $item->tujuan_keberatan }}
                            </td>
                            <td class="p-5 font-bold text-gray-500 text-xs">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="p-5">
                                <span class="font-bold px-3 py-1 rounded-full text-[11px] uppercase tracking-wide
                                    {{ match($item->status) {
                                        'DIAJUKAN' => 'bg-gray-100 text-gray-600',
                                        'DIPROSES' => 'bg-blue-100 text-blue-700',
                                        'DITERIMA' => 'bg-emerald-100 text-emerald-700',
                                        'DITOLAK'  => 'bg-red-100 text-red-700',
                                        default    => 'bg-gray-100'
                                    } }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="p-5 text-center">
                                <a href="{{ url('/admin/pengajuan/' . $item->id) }}" class="inline-block px-5 py-2 bg-slate-100 hover:bg-[#0095e8] text-slate-700 hover:text-white rounded-xl font-bold text-xs transition shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="p-10 text-center text-gray-400">Belum ada data pengajuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-gray-50 border-t border-gray-100">
            {{ $permohonans->links() }}
        </div>
    </div>
@endsection
