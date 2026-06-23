@extends('layouts.admin')

@section('title', 'Manajemen Permohonan - PPID FMIPA Unila')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Permohonan Informasi</h1>
        <p class="text-sm text-gray-500">Tinjau dan proses pengajuan permohonan informasi dari masyarakat</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
        @foreach(['Total' => $totalPermohonan, 'Diajukan' => $totalDiajukan, 'Diproses' => $totalDiproses, 'Diterima' => $totalDiterima, 'Ditolak' => $totalDitolak] as $label => $val)
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $label }}</span>
                <span class="text-3xl font-extrabold text-gray-900">{{ $val ?? 0 }}</span>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <form action="{{ url('/admin/permohonan') }}" method="GET" class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-extrabold text-gray-900">Daftar Pengajuan Permohonan</h2>
            <select name="status" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-bold bg-gray-50 cursor-pointer">
                <option value="">Filter Status</option>
                @foreach(['DIAJUKAN', 'DIPROSES', 'DITERIMA', 'DITOLAK'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-[10px] font-extrabold text-gray-500 uppercase border-b">
                        <th class="p-4 pl-6">No. Tiket</th>
                        <th class="p-4">Pemohon</th>
                        <th class="p-4">Rincian Informasi</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse ($permohonans as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 pl-6 font-mono font-bold text-[#0095e8]">{{ $item->no_tiket }}</td>
                            <td class="p-4 font-extrabold text-gray-900">{{ $item->nama }} <span class="block text-xs font-normal text-gray-400">{{ $item->pekerjaan }}</span></td>
                            <td class="p-4 text-gray-600 max-w-xs truncate">{{ $item->info_diminta }}</td>
                            <td class="p-4 text-xs font-bold text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                <span class="font-bold px-2.5 py-1 rounded-md text-[11px]
                                    {{ match($item->status) {
                                        'DIAJUKAN' => 'bg-gray-100 text-gray-700',
                                        'DIPROSES' => 'bg-blue-100 text-blue-700',
                                        'DITERIMA' => 'bg-emerald-100 text-emerald-700',
                                        'DITOLAK'  => 'bg-red-100 text-red-600',
                                        default    => 'bg-gray-100'
                                    } }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ url('/admin/permohonan/' . $item->id) }}" class="px-4 py-2 bg-gray-100 hover:bg-[#0095e8] text-gray-800 hover:text-white rounded-xl font-bold text-xs transition">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-10 text-center text-gray-400">Belum ada data permohonan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-gray-50 border-t">{{ $permohonans->links() }}</div>
    </div>
@endsection
