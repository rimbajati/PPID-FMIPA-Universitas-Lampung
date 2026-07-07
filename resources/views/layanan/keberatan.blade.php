@extends('layouts.dashboard')

@section('title', 'Formulir Pengajuan Keberatan - PPID FMIPA Unila')

@section('content')
<div class="w-full py-6 px-4 sm:px-8">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Formulir Keberatan Informasi Publik</h1>
        <p class="text-gray-500 text-sm mt-1">Formulir ini digunakan apabila permohonan informasi Anda ditolak atau tidak sesuai.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 bg-green-50 border border-green-600 p-4 text-green-800 text-sm font-medium">
        <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-none shadow-sm overflow-hidden">
        <form id="formKeberatan" action="{{ route('keberatan.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100" novalidate>
            @csrf

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">1. Identitas Pengaju Keberatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Lengkap</label>
                        <input type="text" value="{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-none px-3 py-2 text-sm" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-none px-3 py-2 text-sm" readonly>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">2. Permohonan Yang Disanggah</h3>
                @if($permohonans->isEmpty())
                    <div class="bg-amber-50 text-amber-800 p-4 rounded-none text-sm border border-amber-200">Belum ada riwayat permohonan yang dapat disanggah.</div>
                @else
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Pilih Nomor Tiket Permohonan*</label>
                        <select name="permohonan_id" id="permohonan_id" class="w-full border rounded-none px-3 py-2 text-sm focus:border-[#0a192f] outline-none transition border-gray-300">
                            <option value="">-- Pilih Permohonan --</option>
                            @foreach($permohonans as $perm)
                                <option value="{{ $perm->id }}" {{ old('permohonan_id') == $perm->id ? 'selected' : '' }}>
                                    #{{ $perm->no_tiket ?? $perm->id }} - {{ Str::limit($perm->info_diminta, 50) }}
                                </option>
                            @endforeach
                        </select>
                        <p id="error-permohonan_id" class="text-red-600 text-xs mt-3 font-medium hidden">Silakan pilih permohonan yang akan disanggah.</p>
                        @error('permohonan_id') <p class="text-red-600 text-xs mt-3 font-medium">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">3. Alasan & Bukti Pendukung</h3>
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alasan Keberatan*</label>
                    <textarea name="alasan_keberatan" id="alasan_keberatan" class="w-full border rounded-none px-3 py-2 text-sm focus:border-[#0a192f] outline-none transition border-gray-300" rows="5">{{ old('alasan_keberatan') }}</textarea>
                    <p id="error-alasan" class="text-red-600 text-xs mt-3 font-medium hidden">Alasan keberatan wajib diisi.</p>
                    @error('alasan_keberatan') <p class="text-red-600 text-xs mt-3 font-medium">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Lampiran Dokumen (Opsional)</label>
                    <input type="file" name="dokumen_pendukung" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-none file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 cursor-pointer">
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50 border-t border-gray-100">
                <div class="mb-6">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" name="pernyataan" id="pernyataan" class="mt-0.5 rounded-none border-gray-300 text-blue-900 focus:ring-blue-500 h-4 w-4 shrink-0 transition" value="1">
                        <span class="text-sm text-gray-700 leading-relaxed">Saya menyatakan bahwa data yang saya isikan adalah benar.</span>
                    </label>
                    <p id="error-pernyataan" class="text-red-600 text-xs mt-3 font-medium hidden">Anda wajib menyetujui pernyataan ini.</p>
                    @error('pernyataan') <p class="text-red-600 text-xs mt-3 font-medium">{{ $message }}</p> @enderror
                </div>

                <button type="button" id="btnBukaModal" class="w-full md:w-auto bg-[#0a192f] hover:bg-black text-white px-8 py-3 rounded-none font-semibold text-sm transition-all shadow-md">
                    Kirim Keberatan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalKonfirmasi" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-8 w-full max-w-sm rounded-none border border-gray-200 shadow-xl mx-4">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Konfirmasi Pengiriman</h3>
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin mengirim pengajuan keberatan ini?</p>
        <div class="flex gap-4">
            <button id="btnBatal" class="flex-1 py-2 border border-gray-300 text-gray-600 font-bold hover:bg-gray-50 transition">Batal</button>
            <button id="btnKirim" class="flex-1 py-2 bg-[#0a192f] text-white font-bold hover:bg-black transition">Ya, Kirim</button>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('formKeberatan');
    const btnBukaModal = document.getElementById('btnBukaModal');
    const modal = document.getElementById('modalKonfirmasi');

    btnBukaModal.addEventListener('click', function() {
        // Reset Error
        document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));

        let isValid = true;

        // Validasi Manual
        if (!document.getElementById('permohonan_id').value) { document.getElementById('error-permohonan_id').classList.remove('hidden'); isValid = false; }
        if (!document.getElementById('alasan_keberatan').value) { document.getElementById('error-alasan').classList.remove('hidden'); isValid = false; }
        if (!document.getElementById('pernyataan').checked) { document.getElementById('error-pernyataan').classList.remove('hidden'); isValid = false; }

        if (isValid) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    });

    document.getElementById('btnBatal').addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    document.getElementById('btnKirim').addEventListener('click', () => {
        form.submit();
    });
</script>
@endsection
