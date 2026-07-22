@extends('layout.admin')

@section('title', 'Kelola Prosedur Permohonan - Admin PPID')

@section('content')
<div class="space-y-8 pb-16">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 md:p-8 border border-slate-200 shadow-sm">
        <div>
            <span class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[#07597b]">Manajemen Konten Publik</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-1">Kelola Halaman Prosedur Permohonan</h1>
            <p class="text-sm md:text-base text-slate-600 mt-1">
                Edit konten, teks header, alur tahapan, dokumen persyaratan, tabel SLA, dan FAQ yang tampil di halaman publik.
            </p>
        </div>
        <div>
            <a href="{{ route('prosedur.permohonan') }}" target="_blank"
               class="inline-flex items-center gap-2 px-6 py-3.5 bg-[#1B365D] hover:bg-[#07597b] text-white text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all shadow">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman
            </a>
        </div>
    </div>

    <!-- Form Edit Prosedur -->
    <form action="{{ route('admin.prosedur-permohonan.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Card 1: Header Utama & Quick Info Metrics -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-heading text-[#1B365D]"></i> Header Halaman & Kartu Ringkasan Info
                </h2>
                <p class="text-sm text-slate-600 mt-1">Ubah judul utama, subjudul banner, serta nilai ringkasan metric card.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Judul Utama Halaman</label>
                    <input type="text" name="judul" value="{{ old('judul', $prosedur['judul']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-semibold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Subjudul / Deskripsi Banner</label>
                    <textarea name="subjudul" rows="2"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900 focus:outline-none focus:border-[#1B365D]">{{ old('subjudul', $prosedur['subjudul']) }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4 border-t border-slate-100">
                <div>
                    <label class="block text-xs sm:text-sm font-extrabold text-slate-800 uppercase mb-2">Jangka Waktu</label>
                    <input type="text" name="jangka_waktu" value="{{ old('jangka_waktu', $prosedur['jangka_waktu']) }}" required
                           class="w-full px-3.5 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900">
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-extrabold text-slate-800 uppercase mb-2">Biaya Layanan</label>
                    <input type="text" name="biaya_layanan" value="{{ old('biaya_layanan', $prosedur['biaya_layanan']) }}" required
                           class="w-full px-3.5 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900">
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-extrabold text-slate-800 uppercase mb-2">Syarat Utama</label>
                    <input type="text" name="syarat_utama" value="{{ old('syarat_utama', $prosedur['syarat_utama']) }}" required
                           class="w-full px-3.5 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900">
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-extrabold text-slate-800 uppercase mb-2">Hak Pemohon</label>
                    <input type="text" name="hak_pemohon" value="{{ old('hak_pemohon', $prosedur['hak_pemohon']) }}" required
                           class="w-full px-3.5 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900">
                </div>
            </div>
        </div>

        <!-- Card 2: Tahapan Alur Permohonan -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-list-ol text-[#1B365D]"></i> Tahapan Alur Permohonan Informasi
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Atur langkah-langkah alur permohonan informasi publik.</p>
                </div>
                <button type="button" onclick="addPermohonanStep()"
                        class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-800 text-xs sm:text-sm font-extrabold uppercase tracking-wider">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Langkah
                </button>
            </div>

            <div id="wrapper-tahapan-permohonan" class="space-y-4">
                @foreach($prosedur['tahapan_permohonan'] as $i => $step)
                <div class="p-4 border border-slate-200 bg-slate-50 relative group item-step-permohonan">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <div class="md:col-span-1 text-center">
                            <span class="w-9 h-9 bg-[#1B365D] text-white font-extrabold text-sm inline-flex items-center justify-center step-num">
                                {{ sprintf('%02d', $i + 1) }}
                            </span>
                        </div>
                        <div class="md:col-span-3">
                            <input type="text" name="tahapan_permohonan[{{ $i }}][judul]" value="{{ $step['judul'] }}" placeholder="Judul Langkah" required
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
                        </div>
                        <div class="md:col-span-5">
                            <input type="text" name="tahapan_permohonan[{{ $i }}][deskripsi]" value="{{ $step['deskripsi'] }}" placeholder="Deskripsi singkat langkah"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">
                        </div>
                        <div class="md:col-span-2">
                            <input type="text" name="tahapan_permohonan[{{ $i }}][catatan]" value="{{ $step['catatan'] ?? '' }}" placeholder="Catatan/SLA"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-xs sm:text-sm font-medium text-slate-600">
                        </div>
                        <div class="md:col-span-1 text-right">
                            <button type="button" onclick="this.closest('.item-step-permohonan').remove(); reindexPermohonan();"
                                    class="w-9 h-9 text-red-500 hover:bg-red-50 border border-red-200">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Card 3: Tahapan Alur Keberatan -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600"></i> Tahapan Alur Pengajuan Keberatan
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Atur langkah-langkah dalam proses penanganan keberatan oleh Atasan PPID.</p>
                </div>
                <button type="button" onclick="addKeberatanStep()"
                        class="px-4 py-2.5 bg-amber-50 hover:bg-amber-100 border border-amber-300 text-amber-800 text-xs sm:text-sm font-extrabold uppercase tracking-wider">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Langkah
                </button>
            </div>

            <div id="wrapper-tahapan-keberatan" class="space-y-4">
                @foreach($prosedur['tahapan_keberatan'] as $i => $step)
                <div class="p-4 border border-slate-200 bg-slate-50 relative group item-step-keberatan">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                        <div class="md:col-span-1 text-center">
                            <span class="w-9 h-9 bg-amber-600 text-white font-extrabold text-sm inline-flex items-center justify-center step-num-k">
                                {{ sprintf('%02d', $i + 1) }}
                            </span>
                        </div>
                        <div class="md:col-span-3">
                            <input type="text" name="tahapan_keberatan[{{ $i }}][judul]" value="{{ $step['judul'] }}" placeholder="Judul Langkah" required
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
                        </div>
                        <div class="md:col-span-5">
                            <input type="text" name="tahapan_keberatan[{{ $i }}][deskripsi]" value="{{ $step['deskripsi'] }}" placeholder="Deskripsi singkat langkah"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">
                        </div>
                        <div class="md:col-span-2">
                            <input type="text" name="tahapan_keberatan[{{ $i }}][catatan]" value="{{ $step['catatan'] ?? '' }}" placeholder="Catatan/SLA"
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-xs sm:text-sm font-medium text-slate-600">
                        </div>
                        <div class="md:col-span-1 text-right">
                            <button type="button" onclick="this.closest('.item-step-keberatan').remove(); reindexKeberatan();"
                                    class="w-9 h-9 text-red-500 hover:bg-red-50 border border-red-200">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Card 4: Syarat Dokumen Pemohon -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-[#1B365D]"></i> Kelengkapan Syarat Dokumen Pemohon
                </h2>
                <p class="text-sm text-slate-600 mt-1">Edit daftar dokumen yang disyaratkan untuk Pemohon Perorangan, Kelompok, dan Badan Hukum.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Perorangan -->
                <div class="p-5 border border-slate-200 bg-slate-50 space-y-4">
                    <h3 class="text-base font-extrabold text-slate-900 uppercase flex items-center gap-2">
                        <i class="fa-solid fa-user text-[#1B365D]"></i> Pemohon Perorangan
                    </h3>
                    <input type="text" name="syarat_perorangan_judul" value="{{ $prosedur['syarat_dokumen']['perorangan']['judul'] ?? 'Pemohon Perorangan' }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
                    <textarea name="syarat_perorangan_deskripsi" rows="2" placeholder="Deskripsi ringkas"
                              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">{{ $prosedur['syarat_dokumen']['perorangan']['deskripsi'] ?? '' }}</textarea>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-extrabold uppercase text-slate-700">Poin Syarat:</label>
                            <button type="button" onclick="addPoinSyarat('perorangan')" class="text-xs font-extrabold text-[#1B365D] hover:underline">
                                <i class="fa-solid fa-plus mr-1"></i> Tambah Poin
                            </button>
                        </div>
                        <div id="wrapper-poin-perorangan" class="space-y-2.5">
                            @foreach($prosedur['syarat_dokumen']['perorangan']['poin'] as $p)
                                <div class="flex items-center gap-2 item-poin-syarat">
                                    <input type="text" name="syarat_perorangan_poin[]" value="{{ $p }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">
                                    <button type="button" onclick="this.closest('.item-poin-syarat').remove();" class="w-9 h-9 shrink-0 text-red-500 hover:bg-red-50 border border-red-200 flex items-center justify-center">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Kelompok -->
                <div class="p-5 border border-slate-200 bg-slate-50 space-y-4">
                    <h3 class="text-base font-extrabold text-slate-900 uppercase flex items-center gap-2">
                        <i class="fa-solid fa-users text-[#07597b]"></i> Kelompok Masyarakat
                    </h3>
                    <input type="text" name="syarat_kelompok_judul" value="{{ $prosedur['syarat_dokumen']['kelompok']['judul'] ?? 'Kelompok Masyarakat' }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
                    <textarea name="syarat_kelompok_deskripsi" rows="2" placeholder="Deskripsi ringkas"
                              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">{{ $prosedur['syarat_dokumen']['kelompok']['deskripsi'] ?? '' }}</textarea>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-extrabold uppercase text-slate-700">Poin Syarat:</label>
                            <button type="button" onclick="addPoinSyarat('kelompok')" class="text-xs font-extrabold text-[#07597b] hover:underline">
                                <i class="fa-solid fa-plus mr-1"></i> Tambah Poin
                            </button>
                        </div>
                        <div id="wrapper-poin-kelompok" class="space-y-2.5">
                            @foreach($prosedur['syarat_dokumen']['kelompok']['poin'] as $p)
                                <div class="flex items-center gap-2 item-poin-syarat">
                                    <input type="text" name="syarat_kelompok_poin[]" value="{{ $p }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">
                                    <button type="button" onclick="this.closest('.item-poin-syarat').remove();" class="w-9 h-9 shrink-0 text-red-500 hover:bg-red-50 border border-red-200 flex items-center justify-center">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Badan Hukum -->
                <div class="p-5 border border-slate-200 bg-slate-50 space-y-4">
                    <h3 class="text-base font-extrabold text-slate-900 uppercase flex items-center gap-2">
                        <i class="fa-solid fa-building text-[#1B365D]"></i> Badan Hukum / NGO
                    </h3>
                    <input type="text" name="syarat_badan_hukum_judul" value="{{ $prosedur['syarat_dokumen']['badan_hukum']['judul'] ?? 'Badan Hukum / NGO' }}"
                           class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
                    <textarea name="syarat_badan_hukum_deskripsi" rows="2" placeholder="Deskripsi ringkas"
                              class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">{{ $prosedur['syarat_dokumen']['badan_hukum']['deskripsi'] ?? '' }}</textarea>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-extrabold uppercase text-slate-700">Poin Syarat:</label>
                            <button type="button" onclick="addPoinSyarat('badan_hukum')" class="text-xs font-extrabold text-[#1B365D] hover:underline">
                                <i class="fa-solid fa-plus mr-1"></i> Tambah Poin
                            </button>
                        </div>
                        <div id="wrapper-poin-badan_hukum" class="space-y-2.5">
                            @foreach($prosedur['syarat_dokumen']['badan_hukum']['poin'] as $p)
                                <div class="flex items-center gap-2 item-poin-syarat">
                                    <input type="text" name="syarat_badan_hukum_poin[]" value="{{ $p }}" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">
                                    <button type="button" onclick="this.closest('.item-poin-syarat').remove();" class="w-9 h-9 shrink-0 text-red-500 hover:bg-red-50 border border-red-200 flex items-center justify-center">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 5: FAQ (Pertanyaan Sering Diajukan) -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-circle-question text-[#1B365D]"></i> Pertanyaan Sering Diajukan (FAQ)
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Tambah, edit, atau hapus item pertanyaan umum yang muncul pada accordion FAQ.</p>
                </div>
                <button type="button" onclick="addFaqItem()"
                        class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-800 text-xs sm:text-sm font-extrabold uppercase tracking-wider">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah FAQ
                </button>
            </div>

            <div id="wrapper-faqs" class="space-y-4">
                @foreach($prosedur['faqs'] as $i => $faq)
                <div class="p-5 border border-slate-200 bg-slate-50 space-y-3 item-faq">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm font-extrabold uppercase text-slate-700">FAQ Item #<span class="faq-num">{{ $i + 1 }}</span></span>
                        <button type="button" onclick="this.closest('.item-faq').remove(); reindexFaq();"
                                class="text-red-500 hover:text-red-700 text-xs sm:text-sm font-bold">
                            <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                        </button>
                    </div>
                    <div>
                        <input type="text" name="faqs[{{ $i }}][tanya]" value="{{ $faq['tanya'] }}" placeholder="Pertanyaan" required
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
                    </div>
                    <div>
                        <textarea name="faqs[{{ $i }}][jawab]" rows="2" placeholder="Jawaban" required
                                  class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">{{ $faq['jawab'] }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Submit Button Banner -->
        <div class="sticky bottom-4 z-20 bg-[#1B365D] p-5 text-white shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-slate-200 hidden sm:block">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Pastikan perubahan sudah sesuai sebelum menyimpan.
            </div>
            <div class="flex gap-4 w-full sm:w-auto justify-end">
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>

function reindexPermohonan() {
    document.querySelectorAll('.item-step-permohonan').forEach((el, index) => {
        el.querySelector('.step-num').innerText = String(index + 1).padStart(2, '0');
    });
}

function addPermohonanStep() {
    const wrapper = document.getElementById('wrapper-tahapan-permohonan');
    const index = wrapper.querySelectorAll('.item-step-permohonan').length;
    const numStr = String(index + 1).padStart(2, '0');

    const html = `
    <div class="p-4 border border-slate-200 bg-slate-50 relative group item-step-permohonan">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            <div class="md:col-span-1 text-center">
                <span class="w-9 h-9 bg-[#1B365D] text-white font-extrabold text-sm inline-flex items-center justify-center step-num">${numStr}</span>
            </div>
            <div class="md:col-span-3">
                <input type="text" name="tahapan_permohonan[${index}][judul]" placeholder="Judul Langkah" required
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
            </div>
            <div class="md:col-span-5">
                <input type="text" name="tahapan_permohonan[${index}][deskripsi]" placeholder="Deskripsi singkat langkah"
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">
            </div>
            <div class="md:col-span-2">
                <input type="text" name="tahapan_permohonan[${index}][catatan]" placeholder="Catatan/SLA"
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-xs sm:text-sm font-medium text-slate-600">
            </div>
            <div class="md:col-span-1 text-right">
                <button type="button" onclick="this.closest('.item-step-permohonan').remove(); reindexPermohonan();"
                        class="w-9 h-9 text-red-500 hover:bg-red-50 border border-red-200">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </div>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
}

function reindexKeberatan() {
    document.querySelectorAll('.item-step-keberatan').forEach((el, index) => {
        el.querySelector('.step-num-k').innerText = String(index + 1).padStart(2, '0');
    });
}

function addKeberatanStep() {
    const wrapper = document.getElementById('wrapper-tahapan-keberatan');
    const index = wrapper.querySelectorAll('.item-step-keberatan').length;
    const numStr = String(index + 1).padStart(2, '0');

    const html = `
    <div class="p-4 border border-slate-200 bg-slate-50 relative group item-step-keberatan">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            <div class="md:col-span-1 text-center">
                <span class="w-9 h-9 bg-amber-600 text-white font-extrabold text-sm inline-flex items-center justify-center step-num-k">${numStr}</span>
            </div>
            <div class="md:col-span-3">
                <input type="text" name="tahapan_keberatan[${index}][judul]" placeholder="Judul Langkah" required
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
            </div>
            <div class="md:col-span-5">
                <input type="text" name="tahapan_keberatan[${index}][deskripsi]" placeholder="Deskripsi singkat langkah"
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">
            </div>
            <div class="md:col-span-2">
                <input type="text" name="tahapan_keberatan[${index}][catatan]" placeholder="Catatan/SLA"
                       class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-xs sm:text-sm font-medium text-slate-600">
            </div>
            <div class="md:col-span-1 text-right">
                <button type="button" onclick="this.closest('.item-step-keberatan').remove(); reindexKeberatan();"
                        class="w-9 h-9 text-red-500 hover:bg-red-50 border border-red-200">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </div>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
}

function reindexFaq() {
    document.querySelectorAll('.item-faq').forEach((el, index) => {
        el.querySelector('.faq-num').innerText = index + 1;
    });
}

function addFaqItem() {
    const wrapper = document.getElementById('wrapper-faqs');
    const index = wrapper.querySelectorAll('.item-faq').length;

    const html = `
    <div class="p-5 border border-slate-200 bg-slate-50 space-y-3 item-faq">
        <div class="flex justify-between items-center">
            <span class="text-xs sm:text-sm font-extrabold uppercase text-slate-700">FAQ Item #<span class="faq-num">${index + 1}</span></span>
            <button type="button" onclick="this.closest('.item-faq').remove(); reindexFaq();"
                    class="text-red-500 hover:text-red-700 text-xs sm:text-sm font-bold">
                <i class="fa-solid fa-trash-can mr-1"></i> Hapus
            </button>
        </div>
        <div>
            <input type="text" name="faqs[${index}][tanya]" placeholder="Pertanyaan" required
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm font-bold text-slate-900">
        </div>
        <div>
            <textarea name="faqs[${index}][jawab]" rows="2" placeholder="Jawaban" required
                      class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800"></textarea>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
}

function addPoinSyarat(type) {
    const wrapper = document.getElementById(`wrapper-poin-${type}`);
    const inputName = `syarat_${type}_poin[]`;
    const html = `
    <div class="flex items-center gap-2 item-poin-syarat">
        <input type="text" name="${inputName}" placeholder="Tuliskan poin persyaratan..." class="w-full px-3.5 py-2.5 bg-white border border-slate-300 text-sm text-slate-800">
        <button type="button" onclick="this.closest('.item-poin-syarat').remove();" class="w-9 h-9 shrink-0 text-red-500 hover:bg-red-50 border border-red-200 flex items-center justify-center">
            <i class="fa-solid fa-trash-can text-sm"></i>
        </button>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
}
</script>
@endpush
@endsection
