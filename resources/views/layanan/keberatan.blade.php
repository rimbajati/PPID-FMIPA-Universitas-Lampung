@extends('layouts.dashboard')

@section('title', 'Formulir Pengajuan Keberatan - PPID FMIPA Unila')

@section('content')
<div class="w-full py-6 px-4 sm:px-8">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Formulir Keberatan Informasi Publik</h1>
        <p class="text-gray-500 text-sm mt-1">Formulir ini digunakan apabila permohonan informasi Anda ditolak, tidak ditanggapi, atau informasi yang diberikan tidak sesuai.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <form action="{{ route('keberatan.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
            @csrf

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">1. Identitas Pengaju Keberatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Lengkap*</label>
                        <input type="text" value="{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded px-3 py-2 text-sm" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Email*</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded px-3 py-2 text-sm" readonly>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">2. Permohonan Yang Disanggah</h3>
                @if($permohonans->isEmpty())
                    <div class="bg-amber-50 text-amber-800 p-4 rounded text-sm border border-amber-200">Belum ada riwayat permohonan yang dapat disanggah.</div>
                @else
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Pilih Nomor Tiket Permohonan*</label>
                        <select name="permohonan_id" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition @error('permohonan_id') border-red-500 @else border-gray-300 @enderror">
                            <option value="">-- Pilih Permohonan --</option>
                            @foreach($permohonans as $perm)
                                <option value="{{ $perm->id }}" {{ old('permohonan_id') == $perm->id ? 'selected' : '' }}>
                                    #{{ $perm->no_tiket ?? $perm->id }} - {{ Str::limit($perm->info_diminta, 50) }}
                                </option>
                            @endforeach
                        </select>
                        @error('permohonan_id') <p class="text-red-500 text-xs mt-2">Silakan pilih permohonan yang akan disanggah.</p> @enderror
                    </div>
                @endif
            </div>

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">3. Alasan & Bukti Pendukung</h3>
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alasan Keberatan*</label>
                    <textarea name="alasan_keberatan" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition @error('alasan_keberatan') border-red-500 @else border-gray-300 @enderror" rows="5">{{ old('alasan_keberatan') }}</textarea>
                    @error('alasan_keberatan') <p class="text-red-500 text-xs mt-2">Alasan keberatan wajib diisi.</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Lampiran Dokumen (Opsional)</label>
                    <input type="file" name="dokumen_pendukung" accept="image/*,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-xs text-gray-400 mt-2">( JPG, PNG, PDF | Maks. 2MB )</p>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50 border-t border-gray-100">

                <!-- Checkbox & Error Grouping -->
                <div class="mb-6">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" name="pernyataan" class="mt-0.5 rounded border-gray-300 text-blue-900 focus:ring-blue-500 h-4 w-4 shrink-0 transition" value="1">
                        <span class="text-sm text-gray-700 leading-relaxed group-hover:text-gray-900 transition">
                            Saya menyatakan bahwa data yang saya isikan adalah benar dan bertanggung jawab penuh atas penggunaan informasi ini.
                        </span>
                    </label>

                    <!-- Error Message di bawah checkbox -->
                    @error('pernyataan')
                        <div class="mt-2 text-red-600 text-xs font-medium flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full md:w-auto bg-[#0a192f] hover:bg-black text-white px-8 py-3 rounded-none font-semibold text-sm transition-all shadow-md hover:shadow-lg active:scale-[0.98]">
                    Kirim Permohonan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
