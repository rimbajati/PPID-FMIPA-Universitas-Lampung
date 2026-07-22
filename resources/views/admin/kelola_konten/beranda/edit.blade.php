@extends('layout.admin')

@section('title', 'Kelola Beranda Utama - Admin PPID')

@section('content')
<div class="space-y-8 pb-16">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 md:p-8 border border-slate-200 shadow-sm">
        <div>
            <span class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[#07597b]">Manajemen Konten Utama</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-1">Kelola Beranda Utama</h1>
            <p class="text-sm md:text-base text-slate-600 mt-1">
                Edit teks banner hero, alur permohonan informasi, dan seksi laporan statistik pada halaman utama publik.
            </p>
        </div>
        <div>
            <a href="/" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-3.5 bg-[#1B365D] hover:bg-slate-800 text-white text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all shadow">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Halaman
            </a>
        </div>
    </div>

    <!-- Form Edit Beranda -->
    <form action="{{ route('admin.beranda.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Card 1: Banner Hero Utama -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-house text-[#1B365D]"></i> Banner Hero Utama (Atas)
                </h2>
                <p class="text-sm text-slate-600 mt-1">Ubah teks tagline, baris judul utama, dan placeholder pencarian.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Tagline Atas Banner</label>
                    <input type="text" name="hero_tagline" value="{{ old('hero_tagline', $beranda['hero_tagline']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-semibold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Baris Judul 1</label>
                    <input type="text" name="hero_judul_1" value="{{ old('hero_judul_1', $beranda['hero_judul_1']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Baris Judul 2</label>
                    <input type="text" name="hero_judul_2" value="{{ old('hero_judul_2', $beranda['hero_judul_2']) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Subjudul (Institusi)</label>
                    <input type="text" name="hero_subjudul" value="{{ old('hero_subjudul', $beranda['hero_subjudul']) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-semibold text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Placeholder Input Pencarian</label>
                    <input type="text" name="hero_search_placeholder" value="{{ old('hero_search_placeholder', $beranda['hero_search_placeholder']) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900 focus:outline-none focus:border-[#1B365D]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Teks Pengantar Tombol Permohonan (Sisi User)</label>
                    <textarea name="hero_cta_user_text" rows="2"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900 focus:outline-none focus:border-[#1B365D]">{{ old('hero_cta_user_text', $beranda['hero_cta_user_text']) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 2: Seksi Alur Permohonan Informasi -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-[#1B365D]"></i> Seksi Alur Permohonan Informasi
                    </h2>
                    <p class="text-sm text-slate-600 mt-1">Kelola judul seksi dan ikhtisar alur permohonan di Beranda.</p>
                </div>
                <a href="{{ route('admin.prosedur-permohonan.edit') }}"
                   class="px-5 py-3 bg-[#1B365D] hover:bg-[#07597b] text-white text-xs sm:text-sm font-extrabold uppercase tracking-wider inline-flex items-center gap-2 shadow">
                    <i class="fa-solid fa-gear"></i> Kelola Alur di Prosedur Layanan
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Judul Seksi Alur</label>
                    <input type="text" name="alur_judul" value="{{ old('alur_judul', $beranda['alur_judul']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Subjudul Seksi Alur</label>
                    <input type="text" name="alur_subjudul" value="{{ old('alur_subjudul', $beranda['alur_subjudul']) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900">
                </div>
            </div>

            <div class="p-5 bg-blue-50/80 border-l-4 border-[#1B365D] space-y-2">
                <p class="font-extrabold text-[#1B365D] text-sm sm:text-base flex items-center gap-2">
                    <i class="fa-solid fa-link"></i> Terhubung Otomatis ke Prosedur Layanan:
                </p>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                    Langkah-langkah alur permohonan yang tampil di Beranda secara otomatis <strong>disinkronkan 100%</strong> dari pengaturan <strong class="text-[#1B365D]">Prosedur Layanan</strong>. Setiap perubahan langkah yang Anda simpan di menu Prosedur Layanan akan seketika memperbarui tampilan Alur di Beranda dan Halaman Prosedur secara bersamaan.
                </p>
            </div>
        </div>

        <!-- Card 3: Seksi Laporan Keterbukaan Informasi & Statistik -->
        <div class="bg-white border border-slate-200 p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-xl font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-[#1B365D]"></i> Seksi Laporan & Grafik Statistik
                </h2>
                <p class="text-sm text-slate-600 mt-1">Ubah teks deskripsi laporan grafik statistik permohonan informasi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Tagline Seksi Statistik</label>
                    <input type="text" name="stats_tagline" value="{{ old('stats_tagline', $beranda['stats_tagline']) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-semibold text-slate-900">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Judul Utama Seksi Statistik</label>
                    <input type="text" name="stats_judul" value="{{ old('stats_judul', $beranda['stats_judul']) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base font-bold text-slate-900">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-slate-800 mb-2">Deskripsi Penjelasan Statistik</label>
                    <textarea name="stats_deskripsi" rows="3"
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-sm sm:text-base text-slate-900 focus:outline-none focus:border-[#1B365D]">{{ old('stats_deskripsi', $beranda['stats_deskripsi']) }}</textarea>
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
