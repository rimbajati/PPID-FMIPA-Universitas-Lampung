<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPID FMIPA Unila</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        unila: '#0f2b4a', /* Warna biru gelap khas wireframe Anda */
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-gray-800">

<!-- Cukup panggil file navbar yang sudah rapi -->
@include('partials.navbar')

    <div class="relative bg-gray-900 h-[500px]">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
        <div class="absolute inset-0 bg-black bg-opacity-60"></div> <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="max-w-2xl text-white">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Transparansi Informasi untuk FMIPA Unggul</h1>
                <p class="text-lg text-gray-300 mb-8">Pejabat Pengelola Informasi dan Dokumentasi (PPID) FMIPA Universitas Lampung berkomitmen memberikan layanan informasi publik yang cepat, akurat, dan transparan sesuai amanat UU No. 14 Tahun 2008.</p>
                <a href="#" class="bg-white text-unila px-6 py-3 rounded font-semibold flex items-center inline-flex hover:bg-gray-100 transition">
                    <i class="fa-regular fa-file-lines mr-2"></i> Ajukan Permohonan
                </a>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold text-unila mb-2">Klasifikasi Informasi Publik</h2>
            <p class="text-gray-500 mb-10 text-sm">Akses dokumen publik kami yang telah dikategorikan untuk memudahkan pencarian Anda.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 flex items-center justify-center rounded mb-4">
                        <i class="fa-regular fa-calendar-alt"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Informasi Berkala</h3>
                    <p class="text-sm text-gray-500 mb-4">Informasi yang wajib disediakan dan diumumkan secara rutin oleh FMIPA Unila kepada publik.</p>
                    <a href="#" class="text-sm font-semibold text-gray-800 hover:text-unila">Lihat Dokumen <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 flex items-center justify-center rounded mb-4">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Informasi Serta-Merta</h3>
                    <p class="text-sm text-gray-500 mb-4">Informasi yang dapat mengancam hajat hidup orang banyak dan ketertiban umum.</p>
                    <a href="#" class="text-sm font-semibold text-gray-800 hover:text-unila">Lihat Dokumen <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 flex items-center justify-center rounded mb-4">
                        <i class="fa-solid fa-link"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Informasi Setiap Saat</h3>
                    <p class="text-sm text-gray-500 mb-4">Informasi yang harus tersedia setiap saat dan dapat diakses melalui permohonan resmi.</p>
                    <a href="#" class="text-sm font-semibold text-gray-800 hover:text-unila">Lihat Dokumen <i class="fa-solid fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-unila py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h2 class="text-2xl font-bold text-white mb-2">Butuh informasi lainnya?</h2>
                <p class="text-blue-200 text-sm">Ajukan permohonan informasi secara online melalui sistem terpadu kami.</p>
            </div>
            <div>
                <a href="#" class="bg-white text-unila px-6 py-3 rounded font-bold hover:bg-gray-100 transition">Ajukan Sekarang</a>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">UPDATE TERBARU</span>
                    <h2 class="text-2xl font-bold text-unila mt-2">Berita & Pengumuman</h2>
                </div>
                <a href="#" class="text-sm font-semibold text-gray-600 hover:text-unila hidden md:block">Lihat Semua Berita <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i></a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Berita 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center text-xs text-gray-500 mb-2">
                            <span>12 MEI 2024</span>
                            <span class="mx-2">•</span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded">PENGUMUMAN</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">Laporan Layanan Informasi Publik Semester I Tahun...</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">Transparansi adalah kunci akuntabilitas. FMIPA Unila merilis laporan berkala terkait permohonan informasi...</p>
                        <a href="#" class="text-sm font-bold text-unila hover:underline">Baca Selengkapnya</a>
                    </div>
                </div>
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Berita 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center text-xs text-gray-500 mb-2">
                            <span>10 MEI 2024</span>
                            <span class="mx-2">•</span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded">KEGIATAN</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">Sosialisasi Keterbukaan Informasi di Lingkungan...</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">Meningkatkan kesadaran akan pentingnya hak publik atas informasi melalui workshop intensif bagi staf administrasi...</p>
                        <a href="#" class="text-sm font-bold text-unila hover:underline">Baca Selengkapnya</a>
                    </div>
                </div>
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Berita 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center text-xs text-gray-500 mb-2">
                            <span>05 MEI 2024</span>
                            <span class="mx-2">•</span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded">DIGITAL</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight">Pembaruan Sistem E-PPID FMIPA Unila untuk...</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">Optimasi platform digital untuk memastikan aksesibilitas informasi 24/7 bagi seluruh civitas akademika dan publik...</p>
                        <a href="#" class="text-sm font-bold text-unila hover:underline">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-unila text-white pt-12 pb-8 border-t-4 border-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">PPID FMIPA Unila</h3>
                    <p class="text-sm text-blue-200 leading-relaxed">Gedung Dekanat FMIPA Universitas Lampung<br>Jl. Prof. Dr. Sumantri Brojonegoro No. 1<br>Bandar Lampung, 35145</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider">NAVIGASI</h3>
                    <ul class="space-y-2 text-sm text-blue-200">
                        <li><a href="#" class="hover:text-white transition">Peta Situs</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                        <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider">HUBUNGI KAMI</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-blue-800 flex items-center justify-center hover:bg-blue-700 transition"><i class="fa-solid fa-globe text-sm"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-blue-800 flex items-center justify-center hover:bg-blue-700 transition"><i class="fa-regular fa-envelope text-sm"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-blue-800 flex items-center justify-center hover:bg-blue-700 transition"><i class="fa-solid fa-phone text-sm"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-blue-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-blue-300">
                <p>&copy; 2024 FMIPA Universitas Lampung. All Rights Reserved.</p>
                <div class="space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white">Terms of Service</a>
                    <a href="#" class="hover:text-white">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
