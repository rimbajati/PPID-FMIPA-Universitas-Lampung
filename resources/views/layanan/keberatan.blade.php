@extends('layouts.dashboard')

@section('title', 'Formulir Pengajuan Keberatan - PPID FMIPA Unila')

@section('content')
<div class="w-full max-w-4xl mx-auto">

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 p-6 mb-8 rounded-2xl shadow-sm w-full transition-all">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white shrink-0 shadow-md">
                <i class="fa-solid fa-check text-lg"></i>
            </div>
            <div>
                <h4 class="font-bold text-green-900 text-base">Pengajuan Keberatan Berhasil Dikirim!</h4>
                <p class="text-xs text-green-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
        <p class="text-[11px] text-green-800/80 mt-3 border-t border-green-200/60 pt-2 font-medium">
            <i class="fa-solid fa-circle-info mr-1"></i> Anda dapat memantau status putusan keberatan ini melalui menu Riwayat Layanan.
        </p>
    </div>
    @endif

    <div class="mb-8 text-center md:text-left">
        <div class="inline-block mb-2">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Formulir Pengajuan Keberatan</h1>
            <div class="h-1.5 bg-[#0a192f] rounded-full mt-2 w-1/2"></div>
        </div>
        <p class="text-sm md:text-base text-gray-600">
            Formulir ini digunakan apabila permohonan informasi Anda ditolak, tidak ditanggapi, atau informasi yang diberikan tidak sesuai.
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

        <form id="keberatanForm" action="{{ route('keberatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#0a192f] mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-user-shield"></i> 1. Identitas Pengaju
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-2">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Nama Lengkap</label>
                        <input type="text" value="{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}" class="w-full border border-gray-200 rounded-xl p-3.5 bg-gray-50 text-gray-600 font-medium text-sm focus:outline-none cursor-not-allowed" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Alamat Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" class="w-full border border-gray-200 rounded-xl p-3.5 bg-gray-50 text-gray-600 font-medium text-sm focus:outline-none cursor-not-allowed" readonly>
                    </div>
                </div>
                <span class="text-[10px] text-gray-400 block"><i class="fa-solid fa-lock mr-1"></i>Data identitas otomatis dihubungkan dengan akun Anda saat ini.</span>
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#0a192f] mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-ticket"></i> 2. Pilih Permohonan Yang Disanggah
                </h3>

                @if($permohonans->isEmpty())
                    <div class="bg-amber-50 border border-amber-200 p-5 rounded-xl text-center">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 text-2xl mb-2"></i>
                        <p class="text-xs font-bold text-amber-900 mb-1">Belum Ada Riwayat Permohonan</p>
                        <p class="text-[11px] text-amber-700">Anda harus mengajukan permohonan informasi terlebih dahulu sebelum dapat mengajukan keberatan.</p>
                    </div>
                @else
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Nomor Tiket / Judul Permohonan Awal *</label>
                        <select name="permohonan_id" class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 bg-white focus:outline-none focus:border-[#0a192f] focus:ring-1 focus:ring-[#0a192f] transition" required>
                            <option value="">-- Pilih Permohonan Informasi Sebelumnya --</option>
                            @foreach($permohonans as $perm)
                                <option value="{{ $perm->id }}" {{ old('permohonan_id') == $perm->id ? 'selected' : '' }}>
                                    Tiket #{{ $perm->no_tiket ?? $perm->id }} - {{ Str::limit($perm->info_diminta ?? 'Permohonan Informasi', 60) }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-[10px] text-gray-400 mt-1 block">Pilih riwayat permohonan yang hasilnya kurang memuaskan atau belum ditanggapi.</span>
                    </div>
                @endif
            </div>

            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#0a192f] mb-4 pb-2 border-b border-gray-100 flex items-center gap-2">
                    <i class="fa-solid fa-scale-balanced"></i> 3. Alasan & Bukti Pendukung
                </h3>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Alasan Mengajukan Keberatan *</label>
                    <textarea name="alasan_keberatan" placeholder="Jelaskan secara rinci alasan Anda mengajukan keberatan..." class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 focus:outline-none focus:border-[#0a192f] focus:ring-1 focus:ring-[#0a192f] transition" rows="4" required>{{ old('alasan_keberatan') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">Upload Dokumen Pendukung <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center bg-gray-50 hover:bg-gray-100/50 transition relative group">
                        <input type="file" name="dokumen_pendukung" id="dokumenInput" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-folder-open text-2xl text-gray-400 group-hover:text-[#0a192f] transition mb-2"></i>
                            <p id="fileNameDisplay" class="text-xs font-semibold text-gray-700">Klik atau geser file lampiran ke sini</p>
                            <p class="text-[10px] text-gray-400 mt-1">Format gambar (JPG, PNG) atau PDF. Maksimal 2 MB.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100/80">
                <label class="flex items-start gap-3 cursor-pointer select-none">
                    <input type="checkbox" id="checkPernyataan" name="pernyataan" class="mt-0.5 rounded text-[#0a192f] focus:ring-[#0a192f] w-4 h-4 shrink-0" value="1">
                    <span class="text-xs text-gray-700 leading-relaxed">
                        Dengan ini saya menyatakan bahwa pengajuan keberatan ini disampaikan dengan itikad baik dan data yang saya berikan adalah benar dan sah.
                    </span>
                </label>
            </div>

            <button type="submit" id="btnKirim" disabled class="w-full bg-gray-200 text-gray-400 py-4 rounded-xl font-bold uppercase tracking-wider text-sm cursor-not-allowed transition-all shadow-sm">
                Ajukan Keberatan
            </button>
        </form>
    </div>
</div>

<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity">
    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-2xl max-w-sm w-full mx-4 border border-gray-100 text-center transform transition-all">
        <div class="w-14 h-14 bg-blue-50 text-[#0a192f] rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-gavel text-xl"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Keberatan</h3>
        <p class="text-xs text-gray-600 mb-6 leading-relaxed">
            Apakah Anda yakin ingin mengajukan keberatan untuk permohonan ini? Petugas PPID akan meninjau ulang permohonan Anda.
        </p>
        <div class="flex gap-3">
            <button type="button" id="btnBatal" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl font-bold text-xs text-gray-700 transition">
                Batal
            </button>
            <button type="button" id="btnYa" class="flex-1 px-4 py-3 bg-[#0a192f] hover:bg-blue-950 rounded-xl font-bold text-xs text-white shadow-md transition">
                Ya, Ajukan
            </button>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('keberatanForm');
    const btnKirim = document.getElementById('btnKirim');
    const modal = document.getElementById('confirmModal');
    const btnBatal = document.getElementById('btnBatal');
    const btnYa = document.getElementById('btnYa');
    const dokumenInput = document.getElementById('dokumenInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    if (dokumenInput) {
        dokumenInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.innerHTML = `<span class="text-[#0a192f] font-bold"><i class="fa-solid fa-file-check mr-1.5"></i>${this.files[0].name}</span>`;
            } else {
                fileNameDisplay.innerHTML = "Klik atau geser file lampiran ke sini";
            }
        });
    }

    function checkFormStatus() {
        const permohonanId = document.querySelector('select[name="permohonan_id"]')?.value;
        const alasan = document.querySelector('textarea[name="alasan_keberatan"]')?.value;
        const pernyataan = document.getElementById('checkPernyataan')?.checked;

        const isAllFilled = (permohonanId && alasan && alasan.trim() !== '' && pernyataan);

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
