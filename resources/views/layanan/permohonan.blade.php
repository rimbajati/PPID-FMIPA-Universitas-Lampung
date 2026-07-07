@extends('layouts.dashboard')

@section('title', 'Formulir Permohonan Informasi - PPID FMIPA Unila')

@section('content')
<div class="w-full py-6 px-4 sm:px-8">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Formulir Permohonan Informasi Publik</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi data berikut untuk mengajukan permohonan informasi publik.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
            @csrf

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">1. Identitas Pemohon</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Lengkap*</label>
                        <input type="text" value="{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded px-3 py-2 text-sm" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Pekerjaan*</label>
                        <select name="pekerjaan" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition @error('pekerjaan') border-red-500 @else border-gray-300 @enderror">
                            <option value="">-- Pilih Pekerjaan --</option>
                            <option value="Mahasiswa" {{ old('pekerjaan') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Dosen" {{ old('pekerjaan') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="Staff" {{ old('pekerjaan') == 'Staff' ? 'selected' : '' }}>Staff / Tenaga Kependidikan</option>
                            <option value="Masyarakat Umum" {{ old('pekerjaan') == 'Masyarakat Umum' ? 'selected' : '' }}>Masyarakat Umum</option>
                        </select>
                        @error('pekerjaan') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Lengkap*</label>
                    <textarea name="alamat" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition @error('alamat') border-red-500 @else border-gray-300 @enderror" rows="2">{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nomor Telepon / WhatsApp*</label>
                        <input type="tel" name="telepon" value="{{ old('telepon') }}" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition @error('telepon') border-red-500 @else border-gray-300 @enderror">
                        @error('telepon') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Email*</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded px-3 py-2 text-sm" readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Upload Identitas (KTP / KTM / PASPOR)*</label>
                    <input type="file" name="identitas" accept="image/*,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    @error('identitas') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-2">( JPG, PNG, PDF | Maks. 2MB )</p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">2. Rincian Informasi</h3>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Informasi Yang Diminta*</label>
                    <textarea name="info_diminta" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition @error('info_diminta') border-red-500 @else border-gray-300 @enderror" rows="3">{{ old('info_diminta') }}</textarea>
                    @error('info_diminta') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Tujuan Penggunaan*</label>
                    <textarea name="tujuan" class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition @error('tujuan') border-red-500 @else border-gray-300 @enderror" rows="3">{{ old('tujuan') }}</textarea>
                    @error('tujuan') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-3">Cara Mendapatkan Informasi*</label>
                    <div class="space-y-3">
                        @foreach(['Mengambil Langsung','Email', 'WhatsApp'] as $opsi)
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="cara_ambil" value="{{ $opsi }}" class="w-4 h-4 text-blue-600 border-gray-300" {{ old('cara_ambil') == $opsi ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">{{ $opsi }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error('cara_ambil') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Area Footer Form -->
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
