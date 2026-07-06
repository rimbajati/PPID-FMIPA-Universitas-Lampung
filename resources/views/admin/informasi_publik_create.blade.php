@extends('layouts.admin')

@php
    $isEdit = isset($informasi);
@endphp

@section('title', $isEdit ? 'Edit Informasi Publik' : 'Tambah Informasi Baru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-xs font-bold text-[#0095e8] uppercase tracking-wider">Layanan DIP</span>
                <h1 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $isEdit ? 'Edit Informasi' : 'Tambah Informasi Baru' }}</h1>
            </div>
            <a href="{{ url('/admin/informasi-publik') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold text-xs transition flex items-center">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-xl shadow-sm">
                <div class="flex items-center mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-red-500 mr-2"></i>
                    <span class="font-bold text-red-800 text-sm">Gagal menyimpan data. Periksa isian berikut:</span>
                </div>
                <ul class="list-disc list-inside text-xs text-red-700 pl-6 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm">
            <form action="{{ $isEdit ? url('/admin/informasi-publik/' . $informasi->id) : url('/admin/informasi-publik') }}"
                  method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if($isEdit) @method('PUT') @endif

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Judul Informasi Publik <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_informasi" value="{{ old('judul_informasi', $isEdit ? $informasi->judul_informasi : '') }}" placeholder="Contoh: Rencana Strategis (Renstra) FMIPA Tahun 2026-2030" class="w-full border border-gray-300 rounded-xl p-3.5 text-sm bg-gray-50 focus:outline-none focus:border-[#0095e8] font-medium transition" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Klasifikasi Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" class="w-full border border-gray-300 rounded-xl p-3.5 text-sm bg-gray-50 focus:outline-none focus:border-[#0095e8] font-bold text-gray-700 transition" required>
                            <option value="">-- Pilih Kategori UU KIP --</option>
                            @foreach(['Informasi Berkala', 'Informasi Serta-Merta', 'Informasi Setiap Saat', 'Informasi Dikecualikan'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $isEdit ? $informasi->kategori : '') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-900 mb-2">Tahun Publikasi <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_publikasi" value="{{ old('tahun_publikasi', $isEdit ? $informasi->tahun_publikasi : \Carbon\Carbon::now()->year) }}" class="w-full border border-gray-300 rounded-xl p-3.5 text-sm bg-gray-50 focus:outline-none focus:border-[#0095e8] font-bold transition" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Deskripsi Singkat / Keterangan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <textarea name="deskripsi" rows="3" placeholder="Tuliskan ringkasan isi dokumen atau peruntukan informasi ini..." class="w-full border border-gray-300 rounded-xl p-3.5 text-sm bg-gray-50 focus:outline-none focus:border-[#0095e8] transition">{{ old('deskripsi', $isEdit ? $informasi->deskripsi : '') }}</textarea>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <label class="block text-sm font-bold text-gray-900 mb-3">Format Penyajian Informasi <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex-1 border border-gray-200 rounded-xl p-4 flex items-center cursor-pointer hover:bg-blue-50/50 transition">
                            <input type="radio" name="opsi_format" value="file" class="mr-3" onclick="toggleFormat('file')" {{ old('opsi_format', ($isEdit && $informasi->tipe_informasi != 'link') ? 'file' : 'file') == 'file' ? 'checked' : '' }}>
                            <div>
                                <span class="block font-extrabold text-sm text-gray-900">Unggah Berkas Fisik</span>
                                <span class="block text-xs text-gray-400">Format: PDF, DOCX, XLSX (Max 10MB)</span>
                            </div>
                        </label>
                        <label class="flex-1 border border-gray-200 rounded-xl p-4 flex items-center cursor-pointer hover:bg-blue-50/50 transition">
                            <input type="radio" name="opsi_format" value="link" class="mr-3" onclick="toggleFormat('link')" {{ old('opsi_format', ($isEdit && $informasi->tipe_informasi == 'link') ? 'link' : '') == 'link' ? 'checked' : '' }}>
                            <div>
                                <span class="block font-extrabold text-sm text-gray-900">Tautan / Link Eksternal</span>
                                <span class="block text-xs text-gray-400">Tautan rujukan ke halaman web FMIPA</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="zona_file" class="bg-blue-50/30 border border-blue-100 p-6 rounded-2xl hidden">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Pilih Berkas Dokumen <span class="text-red-500">*</span></label>
                    <input type="file" name="berkas" id="input_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" class="w-full border border-gray-300 bg-white rounded-xl p-2.5 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0095e8] file:text-white hover:file:bg-blue-600 cursor-pointer">
                </div>

                <div id="zona_link" class="bg-amber-50/30 border border-amber-100 p-6 rounded-2xl hidden">
                    <label class="block text-sm font-bold text-gray-900 mb-2">Masukkan Alamat URL Lengkap <span class="text-red-500">*</span></label>
                    <input type="url" name="url_link" id="input_link" value="{{ old('url_link', ($isEdit && $informasi->tipe_informasi == 'link') ? $informasi->jalur_informasi : '') }}" placeholder="https://fmipa.unila.ac.id/..." class="w-full border border-amber-300 rounded-xl p-3.5 text-sm bg-white focus:outline-none focus:border-amber-500 font-mono">
                </div>

                <div class="flex gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ url('/admin/informasi-publik') }}" class="w-1/3 py-3.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold text-sm text-center transition">Batal</a>
                    <button type="submit" class="w-2/3 py-3.5 bg-[#0095e8] hover:bg-blue-600 text-white rounded-xl font-bold text-sm transition shadow-lg flex items-center justify-center cursor-pointer">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> {{ $isEdit ? 'Update Informasi Publik' : 'Simpan Informasi Publik' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleFormat(jenis) {
            const zonaFile = document.getElementById('zona_file');
            const zonaLink = document.getElementById('zona_link');
            const inputFile = document.getElementById('input_file');
            const inputLink = document.getElementById('input_link');

            if (jenis === 'file') {
                zonaFile.classList.remove('hidden');
                zonaLink.classList.add('hidden');
                inputFile.disabled = false;
                inputLink.disabled = true;
            } else {
                zonaFile.classList.add('hidden');
                zonaLink.classList.remove('hidden');
                inputFile.disabled = true;
                inputLink.disabled = false;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const checked = document.querySelector('input[name="opsi_format"]:checked');
            toggleFormat(checked ? checked.value : 'file');
        });
    </script>
@endsection
