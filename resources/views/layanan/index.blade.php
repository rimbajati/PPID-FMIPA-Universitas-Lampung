@extends('layouts.sidebar')

@section('title', 'Formulir Layanan Informasi - PPID FMIPA Unila')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Formulir Layanan Informasi</h1>
        <p class="text-gray-500 text-sm">Silakan pilih jenis layanan dan lengkapi data berikut.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form id="formLayanan" action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="p-6 md:p-8 bg-gray-50/50 border-b border-gray-100">
                <label class="block text-xs font-bold text-gray-900 uppercase tracking-wider mb-3">Jenis Layanan Informasi*</label>
                <select name="jenis_layanan" id="jenis_layanan"
                    class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] focus:ring-1 focus:ring-[#0a192f] outline-none transition duration-200 cursor-pointer">
                    <option value="">-- Pilih Jenis Layanan --</option>
                    <option value="permohonan" {{ request()->query('type') == 'permohonan' ? 'selected' : '' }}>Permohonan Informasi</option>
                    <option value="keberatan" {{ request()->query('type') == 'keberatan' ? 'selected' : '' }}>Pengajuan Keberatan</option>
                </select>
                <p id="error-jenis" class="text-red-600 text-xs mt-2 font-medium hidden">Jenis layanan wajib dipilih.</p>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">Identitas Pemohon</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase">Nama Lengkap</label>
                        <input type="text" value="{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-xl px-4 py-3 text-sm" readonly>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase">Alamat Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-xl px-4 py-3 text-sm" readonly>
                    </div>
                </div>
            </div>

            <div id="section-permohonan" class="hidden px-6 md:px-8 pb-8 space-y-6">
                <div class="border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">Rincian Permohonan Informasi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Kategori Pemohon</label>
                            <input type="text" name="kategori_pemohon" placeholder="Contoh: Perorangan/Lembaga" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Nomor Identitas (KTP/SIM/Paspor)</label>
                            <input type="text" name="no_identitas" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none">
                        </div>
                    </div>
                    <div class="space-y-6 mt-6">
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Lampiran KTP/SIM/PASPOR</label>
                            <input type="file" name="lampiran_identitas" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-[#0a192f] hover:file:bg-gray-100 cursor-pointer border border-gray-200 rounded-xl px-2 py-2">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Handphone</label>
                                <input type="tel" name="handphone" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Alamat</label>
                                <input type="text" name="alamat" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Kategori Bidang</label>
                                <select name="kategori_bidang" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Akademik">Akademik</option>
                                    <option value="Non-Akademik">Non-Akademik</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-xs font-semibold text-gray-500 uppercase">Cara Memperoleh Informasi</label>
                                <select name="cara_memperoleh" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none">
                                    <option value="">-- Pilih Salah Satu --</option>
                                    <option value="Softcopy">Softcopy (Email)</option>
                                    <option value="Hardcopy">Hardcopy (Ambil di Lokasi)</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Rincian Informasi</label>
                            <textarea name="info_diminta" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none" rows="3"></textarea>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Tujuan Permohonan Informasi</label>
                            <textarea name="tujuan_informasi" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div id="section-keberatan" class="hidden px-6 md:px-8 pb-8 space-y-6">
                <div class="border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">Rincian Keberatan</h3>
                    <div class="space-y-4">
                         <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Pilih Permohonan yang Disanggah*</label>
                            <select name="permohonan_id" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none">
                                <option value="">-- Pilih Permohonan --</option>
                                @foreach($permohonans as $perm)
                                    <option value="{{ $perm->id }}">#{{ $perm->no_tiket }} - {{ Str::limit($perm->info_diminta, 50) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase">Alasan Keberatan*</label>
                            <textarea name="alasan_keberatan" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#0a192f] outline-none" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 md:px-8 py-6 bg-gray-50 border-t border-gray-100 rounded-b-2xl flex justify-end">
                <button type="submit" class="bg-[#0a192f] hover:bg-black text-white px-8 py-3 rounded-xl font-semibold text-sm transition-all shadow-md">
                    Kirim Formulir
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jenisLayanan = document.getElementById('jenis_layanan');
        const secPermohonan = document.getElementById('section-permohonan');
        const secKeberatan = document.getElementById('section-keberatan');

        function updateForm() {
            const val = jenisLayanan.value;
            // Toggle visibility berdasarkan value
            secPermohonan.classList.toggle('hidden', val !== 'permohonan');
            secKeberatan.classList.toggle('hidden', val !== 'keberatan');
        }

        // Jalankan saat load (otomatis pilih berdasarkan parameter URL jika ada)
        updateForm();

        // Jalankan saat dropdown diubah
        jenisLayanan.addEventListener('change', updateForm);
    });
</script>
@endsection
