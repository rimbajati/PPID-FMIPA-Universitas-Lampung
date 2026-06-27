@extends('layouts.main')

@section('title', 'Beranda - PPID FMIPA Unila')

@section('content')
    <div class="relative w-full h-[750px] bg-gray-900 overflow-hidden">
        <div class="absolute inset-0 bg-center bg-cover bg-no-repeat"
            style="background-image: url('{{ asset('images/FMIPA.jpg') }}');">
        </div>

        <div class="absolute inset-0 bg-[radial-gradient(circle_at_left,_var(--tw-gradient-stops))] from-black/70 via-black/20 to-transparent"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 drop-shadow-lg">
                    Transparansi Informasi untuk FMIPA Unggul
                </h1>
                <p class="text-xl text-gray-100 mb-10 drop-shadow-md">
                    Pejabat Pengelola Informasi dan Dokumentasi (PPID) FMIPA Universitas Lampung berkomitmen memberikan layanan informasi publik yang cepat, akurat, dan transparan.
                </p>
                <a href="{{ route('permohonan.create') }}" class="bg-primary text-white px-8 py-4 rounded-xl font-bold flex items-center inline-flex hover:bg-blue-600 transition shadow-xl text-lg">
                    <i class="fa-regular fa-file-lines mr-2"></i> Ajukan Permohonan
                </a>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold text-black mb-2">Klasifikasi Informasi Publik</h2>
            <p class="text-gray-500 mb-10 text-sm">Akses dokumen publik kami yang telah dikategorikan untuk memudahkan pencarian Anda.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition">
                    <div class="w-10 h-10 bg-[#0095e8]/10 text-[#0095e8] flex items-center justify-center rounded-lg mb-4">
                        <i class="fa-regular fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Informasi Berkala</h3>
                    <p class="text-sm text-gray-500 mb-4">Informasi yang wajib disediakan dan diumumkan secara rutin oleh FMIPA Unila.</p>
                    <a href="#" class="text-sm font-bold text-[#0095e8] hover:underline">Lihat Dokumen <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
                <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition">
                    <div class="w-10 h-10 bg-[#0095e8]/10 text-[#0095e8] flex items-center justify-center rounded-lg mb-4">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Informasi Serta-Merta</h3>
                    <p class="text-sm text-gray-500 mb-4">Informasi yang dapat mengancam hajat hidup orang banyak dan ketertiban umum.</p>
                    <a href="#" class="text-sm font-bold text-[#0095e8] hover:underline">Lihat Dokumen <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
                <div class="border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition">
                    <div class="w-10 h-10 bg-[#0095e8]/10 text-[#0095e8] flex items-center justify-center rounded-lg mb-4">
                        <i class="fa-solid fa-link"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Informasi Setiap Saat</h3>
                    <p class="text-sm text-gray-500 mb-4">Informasi yang harus tersedia setiap saat dan dapat diakses melalui permohonan resmi.</p>
                    <a href="#" class="text-sm font-bold text-[#0095e8] hover:underline">Lihat Dokumen <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#0095e8] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-white">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h2 class="text-2xl font-bold mb-2">Butuh informasi lainnya?</h2>
                <p class="text-blue-50 text-sm">Ajukan permohonan informasi secara online melalui sistem terpadu kami.</p>
            </div>
            <div>
                <a href="{{ route('permohonan.create') }}" class="bg-white text-[#0095e8] px-8 py-3 rounded-xl font-bold hover:bg-gray-100 transition shadow-lg">Ajukan Sekarang</a>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- <div class="flex justify-between items-end mb-8">
                        <div>
                            <span class="bg-[#0095e8]/10 text-[#0095e8] text-xs font-bold px-3 py-1 rounded-full uppercase">Update Terbaru</span>
                            <h2 class="text-2xl font-bold text-gray-900 mt-3">Berita & Pengumuman</h2>
                        </div>
                        <a href="#" class="text-sm font-bold text-gray-600 hover:text-[#0095e8] hidden md:block">Lihat Semua Berita <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition">
                            <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Berita" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-xs text-gray-500 mb-2">
                                    <span>12 MEI 2024</span>
                                    <span class="mx-2">•</span>
                                    <span class="bg-[#0095e8]/10 text-[#0095e8] px-2 py-0.5 rounded">PENGUMUMAN</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">Laporan Layanan Informasi Publik Semester I Tahun...</h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2">Transparansi adalah kunci akuntabilitas. FMIPA Unila merilis laporan berkala terkait permohonan informasi...</p>
                                <a href="#" class="text-sm font-bold text-[#0095e8] hover:underline">Baca Selengkapnya</a>
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition">
                            <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Berita" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-xs text-gray-500 mb-2">
                                    <span>10 MEI 2024</span>
                                    <span class="mx-2">•</span>
                                    <span class="bg-[#0095e8]/10 text-[#0095e8] px-2 py-0.5 rounded">KEGIATAN</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">Sosialisasi Keterbukaan Informasi di Lingkungan...</h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2">Meningkatkan kesadaran akan pentingnya hak publik atas informasi melalui workshop intensif bagi staf administrasi...</p>
                                <a href="#" class="text-sm font-bold text-[#0095e8] hover:underline">Baca Selengkapnya</a>
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition">
                            <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Berita" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <div class="flex items-center text-xs text-gray-500 mb-2">
                                    <span>05 MEI 2024</span>
                                    <span class="mx-2">•</span>
                                    <span class="bg-[#0095e8]/10 text-[#0095e8] px-2 py-0.5 rounded">DIGITAL</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">Pembaruan Sistem E-PPID FMIPA Unila untuk...</h3>
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2">Optimasi platform digital untuk memastikan aksesibilitas informasi 24/7 bagi seluruh civitas akademika dan publik...</p>
                                <a href="#" class="text-sm font-bold text-[#0095e8] hover:underline">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
@endsection
