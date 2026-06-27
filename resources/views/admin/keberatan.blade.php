@extends('layouts.admin')

@section('title', 'Manajemen Keberatan - PPID FMIPA Unila')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Keberatan Informasi</h1>
        <p class="text-sm text-gray-500">Tindak lanjuti pengajuan sengketa atau keberatan dari pemohon atas penolakan informasi publik</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-gray-200 hover:shadow-xl transition flex flex-col justify-between">
            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Keberatan</span>
            <span class="text-3xl font-extrabold text-gray-900">{{ $totalKeberatan ?? 12 }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 hover:shadow-xl transition flex flex-col justify-between">
            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Diajukan</span>
            <span class="text-3xl font-extrabold text-gray-600">{{ $kebDiajukan ?? 2 }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-amber-100 hover:shadow-xl transition flex flex-col justify-between">
            <span class="text-[11px] font-bold text-amber-500 uppercase tracking-wider mb-1">Diproses</span>
            <span class="text-3xl font-extrabold text-amber-500">{{ $kebDiproses ?? 3 }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 hover:shadow-xl transition flex flex-col justify-between">
            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Diterima</span>
            <span class="text-3xl font-extrabold text-emerald-600">{{ $kebDiterima ?? 5 }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-200 hover:shadow-xl transition flex flex-col justify-between">
            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Ditolak</span>
            <span class="text-3xl font-extrabold text-red-500">{{ $kebDitolak ?? 2 }}</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white">
            <h2 class="text-lg font-extrabold text-gray-900">Daftar Pengajuan Keberatan</h2>
            <button class="px-4 py-2 border border-gray-300 rounded-xl text-sm font-bold bg-gray-50 hover:bg-gray-100 text-gray-700 transition flex items-center">
                <i class="fa-solid fa-filter mr-2 text-gray-400"></i> Filter Sengketa
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-[10px] font-extrabold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="p-4 pl-6 font-mono">No. Tiket</th>
                        <th class="p-4">Pemohon</th>
                        <th class="p-4">Penjelasan Keberatan</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    <tr class="hover:bg-gray-50 transition font-medium">
                        <td class="p-4 pl-6 font-mono font-bold text-amber-600">REQ-20260615-088</td>
                        <td class="p-4 font-extrabold text-gray-900">Hendra Cipta</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Penolakan soal ujian dinilai tidak mendasar karena soal tahun lalu sudah menjadi arsip terbuka</td>
                        <td class="p-4 text-xs font-bold text-gray-500">17 Jun 2026</td>
                        <td class="p-4"><span class="bg-amber-100 text-amber-700 font-bold px-2.5 py-1 rounded-md text-[11px] tracking-wide">DIPROSES</span></td>
                        <td class="p-4 text-center">
                            <a href="#" class="px-4 py-2 bg-gray-100 hover:bg-amber-500 text-gray-800 hover:text-white rounded-xl font-bold text-xs transition">Detail</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition font-medium">
                        <td class="p-4 pl-6 font-mono font-bold text-amber-600">REQ-20260510-112</td>
                        <td class="p-4 font-extrabold text-gray-900">Siti Nurhaliza</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">Permohonan tidak kunjung ditanggapi atau diproses melewati batas waktu 10 hari kerja</td>
                        <td class="p-4 text-xs font-bold text-gray-500">25 Mei 2026</td>
                        <td class="p-4"><span class="bg-gray-100 text-gray-700 font-bold px-2.5 py-1 rounded-md text-[11px] tracking-wide">DIAJUKAN</span></td>
                        <td class="p-4 text-center">
                            <a href="#" class="px-4 py-2 bg-gray-100 hover:bg-amber-500 text-gray-800 hover:text-white rounded-xl font-bold text-xs transition">Detail</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center text-xs text-gray-500 font-medium">
            <span>Menampilkan 1 sampai 2 dari 12 keberatan</span>
            <div class="space-x-1 font-bold">
                <button class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1.5 bg-[#0095e8] text-white rounded-lg shadow">1</button>
                <button class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700 font-normal">Berikutnya</button>
            </div>
        </div>
    </div>
@endsection
