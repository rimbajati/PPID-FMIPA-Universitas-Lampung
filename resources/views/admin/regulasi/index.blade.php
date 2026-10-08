@extends('components.layouts.admin')

@section('title', 'Regulasi - Admin PPID')
@section('header_title', 'Kelola Regulasi')

@section('content')
<div class="space-y-6 w-full pb-10">

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-bold shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-[380px_1fr] gap-6 items-start">
        
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden lg:sticky lg:top-6">
            <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2.5">
                    <i class="fa-solid fa-plus text-sky-600"></i> Tambah Regulasi
                </h2>
            </div>
            <form action="{{ route('admin.regulasi.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <select name="kategori" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium">
                    <option value="nasional">Nasional</option>
                    <option value="internal">Internal</option>
                </select>
                <input type="text" name="badge" required placeholder="Badge (contoh: UU)" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm">
                <input type="text" name="tahun" required placeholder="Tahun/Sumber" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm">
                <input type="text" name="judul" required placeholder="Judul" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm">
                <textarea name="deskripsi" required placeholder="Deskripsi" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm" rows="3"></textarea>
                <input type="text" name="sumber" required placeholder="Sumber/Instansi" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm">
                <input type="url" name="url" required placeholder="URL Dokumen" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm">
                <button type="submit" class="w-full py-3 bg-sky-600 text-white font-bold text-sm rounded-xl">Simpan Regulasi</button>
            </form>
        </div>

        <div class="space-y-4">
            @forelse($regulasi as $item)
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-start justify-between">
                    <div>
                        <span class="text-xs font-bold text-sky-600 uppercase">{{ $item['badge'] }}</span>
                        <h3 class="text-lg font-black text-slate-900">{{ $item['judul'] }}</h3>
                        <p class="text-sm text-slate-600 mt-1">{{ $item['deskripsi'] }}</p>
                    </div>
                    <form action="{{ route('admin.regulasi.destroy', $item['id']) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-rose-600 hover:text-rose-700 font-bold text-sm">Hapus</button>
                    </form>
                </div>
            @empty
                <p>Belum ada regulasi.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection