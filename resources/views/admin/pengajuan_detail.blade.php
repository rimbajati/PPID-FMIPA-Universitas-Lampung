@extends('layouts.admin')

@section('title', 'Detail Pengajuan - PPID FMIPA Unila')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Detail Pengajuan</h1>
            <p class="text-sm text-gray-500">Tiket: <span class="font-bold text-[#0095e8]">{{ $permohonan->no_tiket }}</span></p>
        </div>
        <a href="{{ url('/admin/pengajuan') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold text-sm transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
                <h2 class="text-lg font-extrabold text-gray-900 mb-6">Data {{ $permohonan->jenis_layanan }}</h2>

                @if($permohonan->jenis_layanan == 'Permohonan')
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Rincian Informasi</label>
                            <p class="p-4 bg-gray-50 rounded-xl mt-1 text-gray-700">{{ $permohonan->info_diminta }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase mt-4">Tujuan Permohonan</label>
                            <p class="p-4 bg-gray-50 rounded-xl mt-1 text-gray-700">{{ $permohonan->tujuan_permohonan }}</p>
                        </div>
                    </div>
                @else
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Alasan Keberatan</label>
                            <p class="p-4 bg-gray-50 rounded-xl mt-1 text-gray-700">{{ $permohonan->tujuan_keberatan }}</p>
                        </div>
                        @if($permohonan->permohonan_terkait_id)
                        <div class="p-4 border border-blue-100 bg-blue-50 rounded-xl">
                            <label class="text-[10px] font-bold text-blue-400 uppercase">Terkait dengan Permohonan</label>
                            <p class="font-bold text-blue-700">Tiket: {{ $permohonan->permohonanTerkait->no_tiket ?? 'N/A' }}</p>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
                <h2 class="text-lg font-extrabold text-gray-900 mb-6">Data Pemohon</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Nama Lengkap</label>
                        <p class="font-bold text-gray-900">{{ $permohonan->nama }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase">Kontak</label>
                        <p class="text-sm text-gray-600">{{ $permohonan->email }}</p>
                        <p class="text-sm text-gray-600">{{ $permohonan->no_hp }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-lg">
                <h2 class="text-lg font-extrabold text-gray-900 mb-4">Lampiran</h2>
                @if($permohonan->lampiran_pendukung)
                    <a href="{{ asset('storage/'.$permohonan->lampiran_pendukung) }}" target="_blank"
                       class="flex items-center justify-center gap-2 w-full p-4 bg-[#0095e8] text-white rounded-2xl font-bold hover:bg-blue-700 transition">
                        <i class="fa-solid fa-file-download"></i> Unduh Lampiran
                    </a>
                @else
                    <p class="text-center text-gray-400 font-bold text-sm bg-gray-50 p-4 rounded-xl">Tidak ada lampiran</p>
                @endif
            </div>
        </div>
    </div>
@endsection
