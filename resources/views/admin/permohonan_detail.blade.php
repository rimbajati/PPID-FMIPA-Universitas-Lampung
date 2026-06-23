@extends('layouts.admin')

@section('title', 'Detail Permohonan - PPID FMIPA Unila')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Detail Permohonan</h1>
            <p class="text-sm text-gray-500">Tiket: <span class="font-mono font-bold text-[#0095e8]">{{ $permohonan->no_tiket }}</span></p>
        </div>
        <a href="{{ url('/admin/permohonan') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold text-sm transition">← Kembali</a>
    </div>

    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-6">
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Pemohon</p>
                <p class="font-bold text-gray-900">{{ $permohonan->nama }}</p>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Pekerjaan</p>
                <p class="font-bold text-gray-900">{{ $permohonan->pekerjaan }}</p>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Email</p>
                <p class="font-bold text-gray-900">{{ $permohonan->email }}</p>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Telepon</p>
                <p class="font-bold text-gray-900">{{ $permohonan->telepon }}</p>
            </div>
            <div class="col-span-1 md:col-span-2">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Alamat Lengkap</p>
                <p class="font-bold text-gray-900">{{ $permohonan->alamat }}</p>
            </div>
            <div class="col-span-1 md:col-span-2">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Cara Mendapatkan Informasi</p>
                <p class="font-bold text-[#0095e8] bg-blue-50 px-3 py-1 rounded-lg inline-block">{{ $permohonan->cara_ambil }}</p>
            </div>
        </div>

        <div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Rincian Informasi</p><p class="text-gray-700 bg-gray-50 p-4 rounded-lg border">{{ $permohonan->info_diminta }}</p></div>
        <div><p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Tujuan</p><p class="text-gray-700 bg-gray-50 p-4 rounded-lg border">{{ $permohonan->tujuan }}</p></div>

        <div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-2">Dokumen Identitas</p>
            <a href="{{ asset('storage/' . $permohonan->file_identitas) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-[#0095e8] text-white rounded-lg font-bold text-xs hover:bg-blue-600 transition">
                <i class="fa-solid fa-file-pdf mr-2"></i> Lihat Dokumen Identitas
            </a>
        </div>
    </div>

    <div class="mt-8 bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
        <h3 class="font-extrabold text-gray-900 mb-4">Eksekusi Status Permohonan</h3>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-4 mb-4 rounded-xl border border-green-200 font-bold text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 text-red-700 p-4 mb-4 rounded-xl border border-red-200 font-bold text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ url('/admin/permohonan/' . $permohonan->id . '/status') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Ubah Status:</label>
                    <select name="status" class="w-full border border-gray-300 rounded-xl p-3 font-bold text-sm bg-gray-50 focus:border-[#0095e8] outline-none">
                        <option value="DIAJUKAN" {{ $permohonan->status == 'DIAJUKAN' ? 'selected' : '' }}>DIAJUKAN</option>
                        <option value="DIPROSES" {{ $permohonan->status == 'DIPROSES' ? 'selected' : '' }}>DIPROSES</option>
                        <option value="DITERIMA" {{ $permohonan->status == 'DITERIMA' ? 'selected' : '' }}>DITERIMA</option>
                        <option value="DITOLAK"  {{ $permohonan->status == 'DITOLAK' ? 'selected' : '' }}>DITOLAK</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Lampiran Jawaban (Opsional):</label>
                    <input type="file" name="file_jawaban" class="w-full border border-gray-300 rounded-xl p-2.5 text-sm bg-gray-50">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Admin (Untuk Email Pemohon):</label>
                <textarea name="catatan_admin" class="w-full border border-gray-300 rounded-xl p-3 text-sm bg-gray-50 focus:border-[#0095e8] outline-none" rows="4">{{ $permohonan->catatan_admin }}</textarea>
            </div>

            <button type="submit" class="w-full px-6 py-3 bg-gray-900 hover:bg-black text-white rounded-xl font-bold text-sm transition">
                Simpan Status & Kirim Notifikasi Email
            </button>
        </form>
    </div>
</div>
@endsection
