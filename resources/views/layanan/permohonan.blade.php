@extends('layouts.dashboard')

@section('title', 'Formulir Permohonan Informasi - PPID FMIPA Unila')

@section('content')
<div class="w-full max-w-4xl mx-auto">

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 p-6 mb-8 rounded-2xl shadow-sm w-full transition-all">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white shrink-0 shadow-md">
                    <i class="fa-solid fa-check text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-green-900 text-base">Permohonan Berhasil Dikirim!</h4>
                    <p class="text-xs text-green-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
            <div class="bg-white px-5 py-2.5 rounded-xl border border-green-200 text-center shadow-sm shrink-0">
                <span class="block text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Nomor Tiket</span>
                <span class="block font-mono font-extrabold text-lg text-green-600 tracking-widest mt-0.5">{{ session('tiket') }}</span>
            </div>
        </div>
        <p class="text-[11px] text-green-800/80 mt-3 border-t border-green-200/60 pt-2 font-medium">
            <i class="fa-solid fa-circle-info mr-1"></i> Simpan nomor tiket di atas untuk melacak status permohonan Anda melalui menu Riwayat Layanan. Salinan informasi akan dikirimkan langsung melalui email Anda setelah diproses.
        </p>
    </div>
    @endif

    <div class="mb-8 text-center md:text-left">
        <div class="inline-block mb-2">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Formulir Permohonan Informasi</h1>
            <div class="h-1.5 bg-[#0a192f] rounded-full mt-2 w-1/2"></div>
        </div>
        <p class="text-sm md:text-base text-gray-600">
            Lengkapi formulir di bawah ini dengan informasi yang valid dan jelas. Hasil salinan dokumen informasi publik akan dikirimkan langsung ke alamat email Anda.
        </p>
    </div>

    <div class="bg-white p-6 md:p-10 rounded-2xl border border-gray-100 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-2 bg-[#0a192f]"></div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-700 p-4 mb-8 rounded-xl border border-red-200 text-sm">
                <div class="font-bold mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-600"></i> Mohon perbaiki kesalahan berikut:
                </div>
                <ul class="list-disc list-inside space-y-1 text-xs text-red-600 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="permohonanForm" action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#0a192f] mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-shield"></i> 1. Identitas Pemohon
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama" value="{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}" class="w-full border border-gray-200 rounded-xl p-3.5 bg-gray-50 text-gray-600 font-medium text-sm focus:outline-none cursor-not-allowed" readonly required>
                        <span class="text-[10px] text-gray-400 mt-1 block"><i class="fa-solid fa-lock mr-1"></i>Diambil dari data akun Anda</span>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Pekerjaan *</label>
                        <select name="pekerjaan" class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 bg-white focus:outline-none focus:border-[#0a192f] focus:ring-1 focus:ring-[#0a192f] transition" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                            <option value="Mahasiswa" {{ old('pekerjaan') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Dosen" {{ old('pekerjaan') == 'Dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="Staff" {{ old('pekerjaan') == 'Staff' ? 'selected' : '' }}>Staff / Tenaga Kependidikan</option>
                            <option value="Masyarakat Umum" {{ old('pekerjaan') == 'Masyarakat Umum' ? 'selected' : '' }}>Masyarakat Umum</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Alamat Lengkap *</label>
                    <textarea name="alamat" placeholder="Tuliskan nama jalan, RT/RW, Kelurahan, Kecamatan, dan Kota/Kabupaten..." class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 focus:outline-none focus:border-[#0a192f] focus:ring-1 focus:ring-[#0a192f] transition" rows="2" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Nomor Telepon / WhatsApp *</label>
                        <input type="tel" name="telepon" value="{{ old('telepon') }}" placeholder="Contoh: 081234567890" class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 focus:outline-none focus:border-[#0a192f] focus:ring-1 focus:ring-[#0a192f] transition" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Alamat Email *</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full border border-gray-200 rounded-xl p-3.5 bg-gray-50 text-gray-600 font-medium text-sm focus:outline-none cursor-not-allowed" readonly required>
                        <span class="text-[10px] text-gray-400 mt-1 block"><i class="fa-solid fa-envelope mr-1"></i>Salinan informasi akan dikirim ke email ini</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Upload Kartu Identitas (KTP / KTM) *</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center bg-gray-50 hover:bg-gray-100/50 transition relative group">
                        <input type="file" name="identitas" id="identitasInput" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 group-hover:text-[#0a192f] transition mb-2"></i>
                            <p id="fileNameDisplay" class="text-xs font-semibold text-gray-700">Klik atau geser file Anda ke sini</p>
                            <p class="text-[10px] text-gray-400 mt-1">Format gambar (JPG, PNG) atau PDF. Maksimal 2 MB.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#0a192f] mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-file-lines"></i> 2. Rincian Informasi
                </h3>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Rincian Informasi Yang Diminta *</label>
                    <textarea name="info_diminta" placeholder="Jelaskan secara spesifik informasi publik atau dokumen yang Anda butuhkan..." class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 focus:outline-none focus:border-[#0a192f] focus:ring-1 focus:ring-[#0a192f] transition" rows="3" required>{{ old('info_diminta') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Tujuan Penggunaan Informasi *</label>
                    <textarea name="tujuan" placeholder="Contoh: Untuk keperluan penelitian skripsi / penyusunan artikel ilmiah / referensi pribadi..." class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 focus:outline-none focus:border-[#0a192f] focus:ring-1 focus:ring-[#0a192f] transition" rows="3" required>{{ old('tujuan') }}</textarea>
                </div>
            </div>

            <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100/80">
                <label class="flex items-start gap-3 cursor-pointer select-none">
                    <input type="checkbox" id="checkPernyataan" name="pernyataan" class="mt-0.5 rounded text-[#0a192f] focus:ring-[#0a192f] w-4 h-4 shrink-0" value="1">
                    <span class="text-xs text-gray-700 leading-relaxed">
                        Dengan ini saya menyatakan bahwa data yang saya isikan adalah benar dan sah. Saya bertanggung jawab penuh atas penggunaan informasi publik ini sesuai dengan ketentuan perundang-undangan yang berlaku.
                    </span>
                </label>
            </div>

            <button type="submit" id="btnKirim" disabled class="w-full bg-gray-200 text-gray-400 py-4 rounded-xl font-bold uppercase tracking-wider text-sm cursor-not-allowed transition-all shadow-sm">
                Kirim Permohonan
            </button>
        </form>
    </div>
</div>

<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity">
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-2xl max-w-sm w-full mx-4 border border-gray-100 text-center transform transition-all">
        <div class="w-14 h-14 bg-blue-50 text-[#0a192f] rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-paper-plane text-xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Pengiriman</h3>
        <p class="text-xs text-gray-600 mb-6 leading-relaxed">
            Apakah Anda yakin seluruh data yang Anda masukkan sudah benar? Salinan informasi publik akan dikirimkan langsung ke email Anda setelah selesai diproses.
        </p>
        <div class="flex gap-3">
            <button type="button" id="btnBatal" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl font-bold text-xs text-gray-700 transition">
                Batal
            </button>
            <button type="button" id="btnYa" class="flex-1 px-4 py-3 bg-[#0a192f] hover:bg-blue-950 rounded-xl font-bold text-xs text-white shadow-md transition">
                Ya, Kirim
            </button>
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
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    // Ubah tampilan nama file saat diunggah
    if (identitasInput) {
        identitasInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.innerHTML = `<span class="text-[#0a192f] font-bold"><i class="fa-solid fa-file-check mr-1.5"></i>${this.files[0].name}</span>`;
            } else {
                fileNameDisplay.innerHTML = "Klik atau geser file Anda ke sini";
            }
        });
    }

    // Pengecekan realtime untuk mengaktifkan tombol kirim
    function checkFormStatus() {
        const isFileSelected = identitasInput?.files?.length > 0;
        const nama = document.querySelector('input[name="nama"]')?.value;
        const pekerjaan = document.querySelector('select[name="pekerjaan"]')?.value;
        const alamat = document.querySelector('textarea[name="alamat"]')?.value;
        const telepon = document.querySelector('input[name="telepon"]')?.value;
        const infoDiminta = document.querySelector('textarea[name="info_diminta"]')?.value;
        const tujuan = document.querySelector('textarea[name="tujuan"]')?.value;
        const pernyataan = document.getElementById('checkPernyataan')?.checked;

        const isAllFilled = (
            nama && pekerjaan && alamat && telepon &&
            isFileSelected && infoDiminta && tujuan && pernyataan
        );

        if (isAllFilled) {
            btnKirim.disabled = false;
            btnKirim.className = "w-full bg-[#0a192f] hover:bg-blue-950 text-white py-4 rounded-xl font-bold uppercase tracking-wider text-sm shadow-lg hover:shadow-xl transition-all active:scale-[0.99] cursor-pointer";
        } else {
            btnKirim.disabled = true;
            btnKirim.className = "w-full bg-gray-200 text-gray-400 py-4 rounded-xl font-bold uppercase tracking-wider text-sm cursor-not-allowed transition-all";
        }
    }

    setInterval(checkFormStatus, 300);

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        modal.classList.remove('hidden');
    });

    btnBatal.addEventListener('click', () => modal.classList.add('hidden'));

    btnYa.addEventListener('click', () => {
        btnYa.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1.5"></i>Mengirim...';
        btnYa.disabled = true;
        form.submit();
    });
</script>
@endsection
