@extends('layout.bilah_sisi')

@section('title', 'Detail Keberatan')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('layanan.index') }}" class="text-sm text-gray-500 hover:text-[#0a192f] transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Riwayat
        </a>
    </div>

    @php
        $status = strtolower($keb->status);
        $progressClass = 'w-1/3';
        if ($status === 'diproses') {
            $progressClass = 'w-2/3';
        } elseif (in_array($status, ['diterima', 'ditolak'])) {
            $progressClass = 'w-full';
        }
    @endphp
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm mb-6">
        <div class="flex justify-between mb-2 text-[10px] font-bold uppercase">
            <span class="text-green-600">1. Pengajuan</span>
            <span class="{{ in_array($status, ['diproses', 'diterima', 'ditolak']) ? 'text-green-600' : 'text-gray-300' }}">2. Peninjauan</span>
            <span class="{{ in_array($status, ['diterima', 'ditolak']) ? 'text-green-600' : 'text-gray-300' }}">3. Putusan</span>
        </div>
        <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
            <div class="{{ $progressClass }} bg-green-500 h-2 transition-all"></div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
        <h2 class="text-xl font-bold mb-6 text-[#0a192f]">Detail Keberatan #{{ $keb->id }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
            <div class="space-y-6">
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Ref. Tiket Permohonan</p>
                    <p class="font-bold font-mono text-[#0a192f]">{{ $keb->permohonan->no_tiket }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Status Putusan</p>
                    <p class="font-bold uppercase text-blue-600">{{ $keb->status }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Tanggal Pengajuan</p>
                    <p class="font-medium">{{ $keb->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Alasan Keberatan</p>
                    <p class="font-medium bg-gray-50 p-4 rounded-xl border border-gray-100 text-gray-700 leading-relaxed italic">
                        "{{ $keb->alasan_keberatan }}"
                    </p>
                </div>
                @if($keb->lampiran_pendukung)
                <div>
                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Lampiran Data Pendukung</p>
                    <a href="{{ asset('storage/'.$keb->lampiran_pendukung) }}" class="inline-flex items-center gap-2 text-blue-600 font-bold hover:underline mt-1" target="_blank">
                        <i class="fa-solid fa-file-arrow-down"></i> Unduh Lampiran Data Pendukung
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

