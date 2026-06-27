@extends('layouts.main')

@section('title', 'Formulir Permohonan Informasi - PPID FMIPA Unila')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl">

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded shadow-sm w-full">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h4 class="font-bold text-green-800 text-md">Berhasil!</h4>
                <p class="text-xs text-green-700">{{ session('success') }}</p>
            </div>
            <div class="bg-white px-4 py-2 rounded border border-green-200 text-center">
                <span class="block text-[10px] text-gray-500 uppercase tracking-wide">Nomor Tiket:</span>
                <span class="block font-mono font-bold text-lg text-green-600 tracking-wider">{{ session('tiket') }}</span>
            </div>
        </div>
        <p class="text-[10px] text-gray-400 mt-2">Simpan nomor tiket ini untuk melacak status permohonan.</p>
    </div>
    @endif

    <div class="bg-white p-8 rounded-lg border border-gray-200 shadow-sm">
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Formulir Permohonan Informasi</h1>
        <p class="text-gray-600 mb-8 text-sm">Silakan isi formulir di bawah ini dengan data yang benar.</p>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 mb-6 rounded border border-red-200">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form id="permohonanForm" action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama" value="{{ auth()->user()->nama_lengkap }}" class="w-full border border-gray-300 rounded-md p-3 bg-gray-50" readonly required>
                </div>
                <div><label class="block text-sm font-bold text-gray-700 mb-2">Pekerjaan *</label>
                    <select name="pekerjaan" class="w-full border border-gray-300 rounded-md p-3" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        <option value="Mahasiswa">Mahasiswa</option>
                        <option value="Dosen">Dosen</option>
                        <option value="Staff">Staff</option>
                        <option value="Masyarakat Umum">Masyarakat Umum</option>
                    </select>
                </div>
            </div>
            <div><label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap *</label>
                <textarea name="alamat" class="w-full border border-gray-300 rounded-md p-3" rows="2" required></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="tel" name="telepon" placeholder="Nomor Telepon/HP" class="border border-gray-300 rounded-md p-3" required>
                <input type="email" name="email" value="{{ auth()->user()->email }}" class="border border-gray-300 rounded-md p-3 bg-gray-50" readonly required>
            </div>
            <div><label class="block text-sm font-bold text-gray-700 mb-2">Upload Kartu Identitas *</label>
                <input type="file" name="identitas" id="identitasInput" class="w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div><label class="block text-sm font-bold text-gray-700 mb-2">Informasi Yang Diminta *</label>
                <textarea name="info_diminta" class="w-full border border-gray-300 rounded-md p-3" rows="3" required></textarea>
            </div>
            <div><label class="block text-sm font-bold text-gray-700 mb-2">Tujuan Permohonan *</label>
                <textarea name="tujuan" class="w-full border border-gray-300 rounded-md p-3" rows="3" required></textarea>
            </div>
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-700">Cara Memperoleh Informasi *</label>
                <div class="flex flex-col gap-2">
                    <label><input type="radio" name="cara_ambil" value="Email" required> Melalui Email</label>
                    <label><input type="radio" name="cara_ambil" value="Mengambil Langsung" required> Mengambil Langsung</label>
                    <label><input type="radio" name="cara_ambil" value="WhatsApp" required> Melalui WhatsApp</label>
                </div>
            </div>
            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                <label class="flex items-start cursor-pointer">
                    <input type="checkbox" id="checkPernyataan" name="pernyataan" class="mt-1 mr-2" value="1">
                    <span class="text-sm text-gray-700">Dengan ini saya menyatakan bahwa data yang saya isikan adalah benar adanya dan saya bersedia bertanggung jawab atas kebenaran data tersebut.</span>
                </label>
            </div>
            <button type="submit" id="btnKirim" disabled class="w-full bg-gray-400 text-white px-8 py-3 rounded font-bold cursor-not-allowed transition">KIRIM PERMOHONAN</button>
        </form>
    </div>
</div>

<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full mx-4">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Pengiriman</h3>
        <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin data yang dimasukkan sudah benar? Data tidak dapat diubah setelah dikirim.</p>
        <div class="flex gap-4">
            <button type="button" id="btnBatal" class="flex-1 px-4 py-2 bg-gray-200 rounded font-bold text-gray-700">Batal</button>
            <button type="button" id="btnYa" class="flex-1 px-4 py-2 bg-[#0095e8] text-white rounded font-bold">Ya, Kirim</button>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('permohonanForm');
    const btnKirim = document.getElementById('btnKirim');
    const modal = document.getElementById('confirmModal');
    const btnBatal = document.getElementById('btnBatal');
    const btnYa = document.getElementById('btnYa');
    const identitasInput = document.getElementById('identitasInput');

    function checkFormStatus() {
        // Validasi input file menggunakan files.length
        const isFileSelected = identitasInput.files.length > 0;

        const isAllFilled = (
            document.querySelector('input[name="nama"]').value &&
            document.querySelector('select[name="pekerjaan"]').value &&
            document.querySelector('textarea[name="alamat"]').value &&
            document.querySelector('input[name="telepon"]').value &&
            isFileSelected &&
            document.querySelector('textarea[name="info_diminta"]').value &&
            document.querySelector('textarea[name="tujuan"]').value &&
            document.querySelector('input[name="cara_ambil"]:checked') &&
            document.getElementById('checkPernyataan').checked
        );

        if (isAllFilled) {
            btnKirim.disabled = false;
            btnKirim.className = "w-full bg-[#0095e8] text-white px-8 py-3 rounded font-bold hover:bg-blue-700 transition";
        } else {
            btnKirim.disabled = true;
            btnKirim.className = "w-full bg-gray-400 text-white px-8 py-3 rounded font-bold cursor-not-allowed transition";
        }
    }

    setInterval(checkFormStatus, 500);

    // Pastikan form hanya disubmit oleh tombol modal
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        modal.classList.remove('hidden');
    });

    btnBatal.addEventListener('click', () => modal.classList.add('hidden'));

    btnYa.addEventListener('click', () => {
        modal.classList.add('hidden');
        form.submit();
    });
</script>
@endsection
