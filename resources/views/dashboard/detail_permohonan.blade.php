@extends('layouts.sidebar')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm mb-6">
        <div class="flex justify-between mb-2 text-[10px] font-bold uppercase">
            <span class="{{ in_array($perm->status, ['DIAJUKAN', 'DIPROSES', 'DITERIMA']) ? 'text-green-600' : 'text-gray-300' }}">1. Pengajuan</span>
            <span class="{{ in_array($perm->status, ['DIPROSES', 'DITERIMA']) ? 'text-green-600' : 'text-gray-300' }}">2. Proses</span>
            <span class="{{ in_array($perm->status, ['DITERIMA']) ? 'text-green-600' : 'text-gray-300' }}">3. Valid</span>
        </div>
        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
            <div class="{{ $perm->status == 'DIAJUKAN' ? 'w-1/3' : ($perm->status == 'DIPROSES' ? 'w-2/3' : 'w-full') }} bg-green-500 h-2"></div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
        <h2 class="text-xl font-bold mb-6">Detail: {{ $perm->no_tiket }}</h2>
        <div class="grid grid-cols-2 gap-6 text-sm">
            <div><p class="text-gray-400 text-[10px] font-bold uppercase">Pemohon</p><p class="font-bold">{{ $perm->nama }}</p></div>
            <div><p class="text-gray-400 text-[10px] font-bold uppercase">Status</p><p class="font-bold text-blue-600">{{ $perm->status }}</p></div>
            <div class="col-span-2"><p class="text-gray-400 text-[10px] font-bold uppercase">Info</p><p>{{ $perm->info_diminta }}</p></div>
        </div>
    </div>
</div>
@endsection
