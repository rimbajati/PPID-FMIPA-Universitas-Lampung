@extends('layouts.dashboard')

@section('title', 'Formulir Permohonan Informasi - PPID FMIPA Unila')

@section('content')
<div class="w-full py-6 px-4 sm:px-8">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-800">Formulir Permohonan Informasi Publik</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi data berikut untuk mengajukan permohonan informasi publik.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 bg-green-50 border border-green-600 p-4 text-green-800 text-sm font-medium">
        <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
        <br><span class="font-bold mt-1 block">Nomor Tiket Anda: {{ session('tiket') }}</span>
    </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-none shadow-sm overflow-hidden">
        <form id="formPermohonan" action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100" novalidate>
            @csrf

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">1. Identitas Pemohon</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Lengkap*</label>
                        <input type="text" name="nama" id="nama" value="{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-none px-3 py-2 text-sm" readonly>
                        <p id="error-nama" class="text-red-600 text-xs mt-3 font-medium hidden">Nama lengkap wajib diisi.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Pekerjaan*</label>
                        <select name="pekerjaan" id="pekerjaan" class="w-full border rounded-none px-3 py-2 text-sm focus:border-[#0a192f] outline-none transition border-gray-300">
                            <option value="">-- Pilih Pekerjaan --</option>
                            <option value="Mahasiswa">Mahasiswa</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Staff">Staff / Tenaga Kependidikan</option>
                            <option value="Masyarakat Umum">Masyarakat Umum</option>
                        </select>
                        <p id="error-pekerjaan" class="text-red-600 text-xs mt-3 font-medium hidden">Pekerjaan wajib dipilih.</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Lengkap*</label>
                    <textarea name="alamat" id="alamat" class="w-full border rounded-none px-3 py-2 text-sm focus:border-[#0a192f] outline-none transition border-gray-300" rows="2"></textarea>
                    <p id="error-alamat" class="text-red-600 text-xs mt-3 font-medium hidden">Alamat lengkap wajib diisi.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nomor Telepon / WhatsApp*</label>
                        <input type="tel" name="telepon" id="telepon" class="w-full border rounded-none px-3 py-2 text-sm focus:border-[#0a192f] outline-none transition border-gray-300">
                        <p id="error-telepon" class="text-red-600 text-xs mt-3 font-medium hidden">Nomor telepon wajib diisi.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Alamat Email*</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="w-full bg-gray-50 border border-gray-200 text-gray-600 rounded-none px-3 py-2 text-sm" readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Upload Identitas (KTP / KTM)*</label>
                    <input type="file" name="identitas" id="identitas" accept="image/*,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-none file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 cursor-pointer">
                    <p id="error-identitas" class="text-red-600 text-xs mt-3 font-medium hidden">File identitas wajib diupload.</p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">2. Rincian Informasi</h3>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Informasi Yang Diminta*</label>
                    <textarea name="info_diminta" id="info_diminta" class="w-full border rounded-none px-3 py-2 text-sm focus:border-[#0a192f] outline-none transition border-gray-300" rows="3"></textarea>
                    <p id="error-info" class="text-red-600 text-xs mt-3 font-medium hidden">Informasi yang diminta wajib diisi.</p>
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Tujuan Penggunaan*</label>
                    <textarea name="tujuan" id="tujuan" class="w-full border rounded-none px-3 py-2 text-sm focus:border-[#0a192f] outline-none transition border-gray-300" rows="3"></textarea>
                    <p id="error-tujuan" class="text-red-600 text-xs mt-3 font-medium hidden">Tujuan penggunaan wajib diisi.</p>
                </div>

                <div class="mb-2">
                    <label class="block text-xs font-bold text-gray-900 uppercase mb-3">Cara Mendapatkan Informasi*</label>
                    <div class="space-y-3">
                        @foreach(['Mengambil Langsung', 'Email', 'WhatsApp'] as $opsi)
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="cara_ambil" value="{{ $opsi }}" class="cara_ambil w-4 h-4 text-blue-900 border-gray-300">
                            <span class="text-sm text-gray-700">{{ $opsi }}</span>
                        </label>
                        @endforeach
                    </div>
                    <p id="error-cara" class="text-red-600 text-xs mt-3 font-medium hidden">Silakan pilih cara pengambilan informasi.</p>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50 border-t border-gray-100">
                <div class="mb-6">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" name="pernyataan" id="pernyataan" class="mt-0.5 rounded-none border-gray-300 text-blue-900 focus:ring-blue-500 h-4 w-4 shrink-0 transition" value="1">
                        <span class="text-sm text-gray-700">Saya menyatakan bahwa data yang saya isikan adalah benar.</span>
                    </label>
                    <p id="error-pernyataan" class="text-red-600 text-xs mt-3 font-medium hidden">Anda wajib menyetujui pernyataan ini.</p>
                </div>
                <button type="button" id="btnBukaModal" class="w-full md:w-auto bg-[#0a192f] hover:bg-black text-white px-8 py-3 rounded-none font-semibold text-sm transition-all shadow-md">
                    Kirim Permohonan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalKonfirmasi" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-8 w-full max-w-sm rounded-none border border-gray-200 shadow-xl mx-4">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Konfirmasi Pengiriman</h3>
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin data yang diisikan sudah benar dan ingin mengirim permohonan ini?</p>
        <div class="flex gap-4">
            <button id="btnBatal" class="flex-1 py-2 border border-gray-300 text-gray-600 font-bold hover:bg-gray-50 transition">Batal</button>
            <button id="btnKirim" class="flex-1 py-2 bg-[#0a192f] text-white font-bold hover:bg-black transition">Ya, Kirim</button>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('formPermohonan');
    const btnBukaModal = document.getElementById('btnBukaModal');
    const modal = document.getElementById('modalKonfirmasi');

    btnBukaModal.addEventListener('click', function() {
        // Reset Error
        document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));

        let isValid = true;

        // Validasi Manual
        if (!document.getElementById('pekerjaan').value) { document.getElementById('error-pekerjaan').classList.remove('hidden'); isValid = false; }
        if (!document.getElementById('alamat').value) { document.getElementById('error-alamat').classList.remove('hidden'); isValid = false; }
        if (!document.getElementById('telepon').value) { document.getElementById('error-telepon').classList.remove('hidden'); isValid = false; }
        if (document.getElementById('identitas').files.length === 0) { document.getElementById('error-identitas').classList.remove('hidden'); isValid = false; }
        if (!document.getElementById('info_diminta').value) { document.getElementById('error-info').classList.remove('hidden'); isValid = false; }
        if (!document.getElementById('tujuan').value) { document.getElementById('error-tujuan').classList.remove('hidden'); isValid = false; }
        if (!document.querySelector('input[name="cara_ambil"]:checked')) { document.getElementById('error-cara').classList.remove('hidden'); isValid = false; }
        if (!document.getElementById('pernyataan').checked) { document.getElementById('error-pernyataan').classList.remove('hidden'); isValid = false; }

        if (isValid) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    });

    document.getElementById('btnBatal').addEventListener('click', () => {
        modal.classList.add('hidden'); modal.classList.remove('flex');
    });

    document.getElementById('btnKirim').addEventListener('click', () => {
        form.submit();
    });
</script>
@endsection
