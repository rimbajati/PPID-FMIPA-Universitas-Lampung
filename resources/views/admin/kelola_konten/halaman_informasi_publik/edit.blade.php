@extends('layout.admin')

@section('title', 'Kelola Halaman Informasi Publik - Admin PPID')

@section('content')
<div class="space-y-8 pb-16">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 md:p-8 border border-slate-200 shadow-sm">
        <div>
            <span class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[#07597b]">Manajemen Tampilan Halaman</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-1">Kelola Halaman Informasi Publik</h1>
            <p class="text-sm md:text-base text-slate-600 mt-1">
                Edit teks banner header (Judul & Subjudul) untuk 4 kategori halaman informasi publik.
            </p>
        </div>
        <div>
            <a href="/informasi-publik" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-3.5 bg-[#1B365D] hover:bg-slate-800 text-white text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all shadow">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman
            </a>
        </div>
    </div>

    <!-- Form Edit Konten Informasi Publik -->
    <form action="{{ route('admin.halaman-informasi-publik.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Card 1: Halaman Daftar Informasi Publik (Utama) -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-folder-open text-[#1B365D]"></i> Halaman Daftar Informasi Publik (Utama)
                </h2>
                <p class="text-sm text-slate-600 mt-1">Teks banner pada halaman utama <code>/informasi-publik</code>.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Judul Banner Halaman</label>
                    <input type="text" name="informasi_publik_judul" value="{{ old('informasi_publik_judul', $konten['informasi_publik_judul']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Deskripsi / Subjudul Banner</label>
                    <textarea name="informasi_publik_subjudul" rows="3"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900 focus:outline-none focus:border-[#1B365D]">{{ old('informasi_publik_subjudul', $konten['informasi_publik_subjudul']) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 2: Halaman Informasi Tersedia Setiap Saat -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-globe text-[#605ca8]"></i> Halaman Informasi Tersedia Setiap Saat
                </h2>
                <p class="text-sm text-slate-600 mt-1">Teks banner pada halaman <code>/informasi-setiap-saat</code>.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Judul Banner Halaman</label>
                    <input type="text" name="setiap_saat_judul" value="{{ old('setiap_saat_judul', $konten['setiap_saat_judul']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Deskripsi / Subjudul Banner</label>
                    <textarea name="setiap_saat_subjudul" rows="3"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900 focus:outline-none focus:border-[#1B365D]">{{ old('setiap_saat_subjudul', $konten['setiap_saat_subjudul']) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 3: Halaman Informasi Tersedia Secara Berkala -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock text-[#2563EB]"></i> Halaman Informasi Tersedia Secara Berkala
                </h2>
                <p class="text-sm text-slate-600 mt-1">Teks banner pada halaman <code>/informasi-berkala</code>.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Judul Banner Halaman</label>
                    <input type="text" name="berkala_judul" value="{{ old('berkala_judul', $konten['berkala_judul']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Deskripsi / Subjudul Banner</label>
                    <textarea name="berkala_subjudul" rows="3"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900 focus:outline-none focus:border-[#1B365D]">{{ old('berkala_subjudul', $konten['berkala_subjudul']) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 4: Halaman Informasi Diumumkan Serta Merta -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-[#0284C7]"></i> Halaman Informasi Diumumkan Serta Merta
                </h2>
                <p class="text-sm text-slate-600 mt-1">Teks banner pada halaman <code>/informasi-serta-merta</code>.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Judul Banner Halaman</label>
                    <input type="text" name="serta_merta_judul" value="{{ old('serta_merta_judul', $konten['serta_merta_judul']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Deskripsi / Subjudul Banner</label>
                    <textarea name="serta_merta_subjudul" rows="3"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900 focus:outline-none focus:border-[#1B365D]">{{ old('serta_merta_subjudul', $konten['serta_merta_subjudul']) }}</textarea>
                </div>
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
@endsection
