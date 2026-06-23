@extends('layouts.main')

@section('title', 'Informasi Publik - PPID FMIPA Unila')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-7xl">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-black mb-2">Daftar Informasi Publik</h1>
        <p class="text-gray-600 max-w-3xl">Di bawah ini adalah daftar informasi publik yang dikelola oleh PPID FMIPA Universitas Lampung. Gunakan bilah pencarian dan filter kategori untuk memudahkan Anda menemukan informasi yang dibutuhkan.</p>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm mb-8 flex flex-col md:flex-row gap-4">
        <select class="border border-gray-300 rounded-md p-2.5 flex-1 outline-none text-sm text-gray-700">
            <option>Pilih Kategori Informasi Publik</option>
            <option value="BERKALA">Berkala</option>
            <option value="SERTA-MERTA">Serta-Merta</option>
            <option value="SETIAP-SAAT">Setiap Saat</option>
        </select>
        <div class="relative flex-[2]">
            <input type="text" placeholder="Bilah Pencarian..." class="w-full border border-gray-300 rounded-md p-2.5 outline-none text-sm text-gray-700">
            <i class="fa-solid fa-magnifying-glass absolute right-4 top-3 text-gray-400"></i>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-8">
        <table class="w-full text-left">
            <!-- Header Tabel menggunakan Biru PPID -->
            <thead class="bg-[#0095e8] text-white">
                <tr>
                    <th class="p-4 text-xs font-bold uppercase tracking-wider">Informasi</th>
                    <th class="p-4 text-xs font-bold uppercase tracking-wider">Kategori</th>
                    <th class="p-4 text-xs font-bold uppercase tracking-wider">Tahun Publikasi</th>
                    <th class="p-4 text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($dokumens as $dok)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 text-sm text-gray-800">{{ $dok->judul_dokumen }}</td>
                    <td class="p-4">
                        <span class="bg-[#e0f2fe] text-[#0095e8] text-[10px] font-bold px-2 py-1 rounded">
                            {{ $dok->kategori }}
                        </span>
                    </td>
                    <td class="p-4 text-sm text-gray-700">{{ $dok->tahun_publikasi }}</td>
                    <td class="p-4">
                        <a href="{{ asset('storage/' . $dok->file_path) }}"
                           class="inline-flex items-center text-sm font-semibold text-gray-700 hover:text-[#0095e8] transition">
                            <i class="fa-solid fa-download mr-2"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-10 text-center text-gray-500 italic">Belum ada informasi yang diunggah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mb-12">
        {{ $dokumens->links() }}
    </div>

    <!-- CTA Footer menggunakan Biru PPID -->
    <div class="bg-[#0095e8] p-8 rounded-lg text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-lg">
        <div>
            <h3 class="text-xl font-bold mb-1">Tidak menemukan informasi yang Anda cari?</h3>
            <p class="text-sm text-blue-50">Anda dapat mengajukan permohonan informasi publik secara daring melalui formulir resmi kami.</p>
        </div>
        <a href="{{ route('permohonan.create') }}" class="bg-white text-[#0095e8] hover:bg-gray-100 px-6 py-3 rounded font-bold transition shadow-md whitespace-nowrap">
            Ajukan Permohonan
        </a>
    </div>
</div>
@endsection
