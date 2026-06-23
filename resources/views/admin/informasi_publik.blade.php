@extends('layouts.admin')

@section('title', 'Manajemen Informasi Publik - PPID FMIPA Unila')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Daftar Informasi Publik</h1>
            <p class="text-sm text-gray-500">Kelola dan perbarui repositori informasi publik FMIPA Universitas Lampung</p>
        </div>
        <div>
            <a href="{{ url('/admin/informasi-publik/create') }}" class="bg-[#0095e8] text-white px-6 py-3 rounded-xl font-bold flex items-center justify-center hover:bg-blue-600 transition shadow-lg text-sm">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Informasi
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Informasi</span>
            <span class="text-3xl font-extrabold text-gray-900">{{ $totalInformasi ?? 0 }}</span>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Berkala</span>
            <span class="text-3xl font-extrabold text-[#0095e8]">{{ $totalBerkala ?? 0 }}</span>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Serta-Merta</span>
            <span class="text-3xl font-extrabold text-amber-500">{{ $totalSertaMerta ?? 0 }}</span>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Setiap Saat</span>
            <span class="text-3xl font-extrabold text-emerald-600">{{ $totalSetiapSaat ?? 0 }}</span>
        </div>
    </div>

    <form action="{{ url('/admin/informasi-publik') }}" method="GET" class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm mb-6 flex flex-col sm:flex-row gap-4">
        <select name="kategori" onchange="this.form.submit()" class="w-full sm:w-64 border border-gray-300 rounded-xl p-3 text-sm font-bold bg-gray-50 focus:border-[#0095e8] transition">
            <option value="">Semua Kategori</option>
            <option value="Informasi Berkala" {{ request('kategori') == 'Informasi Berkala' ? 'selected' : '' }}>Informasi Berkala</option>
            <option value="Informasi Serta-Merta" {{ request('kategori') == 'Informasi Serta-Merta' ? 'selected' : '' }}>Informasi Serta-Merta</option>
            <option value="Informasi Setiap Saat" {{ request('kategori') == 'Informasi Setiap Saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
            <option value="Informasi Dikecualikan" {{ request('kategori') == 'Informasi Dikecualikan' ? 'selected' : '' }}>Informasi Dikecualikan</option>
        </select>
        <div class="w-full relative flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul informasi..." class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-3 text-sm bg-gray-50 focus:border-[#0095e8]">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-gray-400"></i>
        </div>
    </form>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-[10px] font-extrabold text-gray-500 uppercase border-b">
                    <th class="p-4 pl-6">Informasi Publik</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Tahun</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($informasi as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 pl-6">
                            <a href="{{ $item->tipe_informasi == 'link' ? $item->jalur_informasi : asset($item->jalur_informasi) }}"
                               target="_blank" class="font-extrabold text-gray-900 hover:text-[#0095e8] flex items-center">
                                <i class="fa-solid {{ $item->tipe_informasi == 'link' ? 'fa-link' : 'fa-file-pdf' }} mr-2 text-[#0095e8]"></i>
                                {{ $item->judul_informasi }}
                            </a>
                        </td>
                        <td class="p-4">
                            <span class="font-bold px-3 py-1 rounded-full text-xs
                                {{ match($item->kategori) {
                                    'Informasi Berkala' => 'bg-blue-100 text-blue-700',
                                    'Informasi Serta-Merta' => 'bg-amber-100 text-amber-700',
                                    'Informasi Setiap Saat' => 'bg-emerald-100 text-emerald-700',
                                    default => 'bg-red-100 text-red-700'
                                } }}">
                                {{ $item->kategori }}
                            </span>
                        </td>
                        <td class="p-4 font-bold text-gray-600">{{ $item->tahun_publikasi }}</td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ url('/admin/informasi-publik/'.$item->id.'/edit') }}" class="px-3 py-1.5 bg-gray-100 hover:bg-blue-500 hover:text-white rounded-lg font-bold text-xs transition">Edit</a>
                                <form action="{{ url('/admin/informasi-publik/'.$item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white rounded-lg font-bold text-xs transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-10 text-center text-gray-400">Data tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 bg-gray-50 border-t">{{ $informasi->links() }}</div>
    </div>
@endsection
