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

    @php
        $nasionalAdmin = collect($regulasi)->where('kategori', 'nasional');
        $internalAdmin = collect($regulasi)->where('kategori', 'internal');
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

        <!-- Kolom Nasional -->
        <div class="space-y-6">
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Peraturan Nasional</h2>

            @if($nasionalAdmin->count() > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach($nasionalAdmin as $item)
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-1.5 group relative pr-14">
                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="block">
                        <h3 class="text-base font-black text-slate-900 group-hover:text-sky-600 transition">{{ $item['judul'] }}</h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $item['deskripsi'] }}</p>
                    </a>
                    <form action="{{ route('admin.regulasi.destroy', $item['id']) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="absolute top-4 right-4 w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Form Tambah Nasional -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6 mt-4">
                <h2 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-plus text-sky-600"></i> Tambah
                </h2>
                <form action="{{ route('admin.regulasi.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="kategori" value="nasional">
                    <input type="text" name="judul" required placeholder="Judul" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm">
                    <textarea name="deskripsi" required placeholder="Deskripsi" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm" rows="2"></textarea>
                    <input type="url" name="url" required placeholder="URL Regulasi" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm">
                    <button type="submit" class="w-full py-2 bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm rounded-xl transition">Tambah</button>
                </form>
            </div>
        </div>

        <!-- Kolom Internal -->
        <div class="space-y-6">
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Regulasi Internal Universitas Lampung</h2>

            @if($internalAdmin->count() > 0)
            <div class="grid grid-cols-1 gap-4">
                @foreach($internalAdmin as $item)
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-1.5 group relative pr-14">
                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="block">
                        <h3 class="text-base font-black text-slate-900 group-hover:text-sky-600 transition">{{ $item['judul'] }}</h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $item['deskripsi'] }}</p>
                    </a>
                    <form action="{{ route('admin.regulasi.destroy', $item['id']) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="absolute top-4 right-4 w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white flex items-center justify-center transition" title="Hapus"><i class="fa-solid fa-trash text-xs"></i></button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Form Tambah Internal -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden p-6 mt-4">
                <h2 class="text-sm font-extrabold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-plus text-sky-600"></i> Tambah
                </h2>
                <form action="{{ route('admin.regulasi.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="kategori" value="internal">
                    <input type="text" name="judul" required placeholder="Judul" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm">
                    <textarea name="deskripsi" required placeholder="Deskripsi" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm" rows="2"></textarea>
                    <input type="url" name="url" required placeholder="URL Regulasi" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm">
                    <button type="submit" class="w-full py-2 bg-sky-600 hover:bg-sky-700 text-white font-bold text-sm rounded-xl transition">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
