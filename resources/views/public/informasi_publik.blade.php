<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Informasi Publik - PPID FMIPA Unila</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        unila: '#0f2b4a', /* Biru gelap FMIPA Unila */
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
    </style>
</head>
<body class="text-gray-800">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="font-bold text-xl text-unila">PPID FMIPA Unila</span>
                </div>
                <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                    <a href="/" class="hover:text-unila transition">Beranda</a>
                    <a href="/informasi-publik" class="text-unila border-b-2 border-unila pb-1">Informasi Publik</a>
                    <a href="#" class="hover:text-unila transition">Berita</a>
                    <a href="#" class="hover:text-unila transition">Layanan</a>
                </div>
                <div>
                    <a href="#" class="bg-unila text-white px-5 py-2 rounded text-sm font-semibold hover:bg-blue-900 transition">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Daftar Dokumen Informasi Publik</h1>
            <p class="text-gray-600 max-w-3xl leading-relaxed">
                Di bawah ini adalah daftar dokumen informasi publik yang dikelola oleh PPID FMIPA Universitas Lampung. Gunakan bilah pencarian dan filter kategori untuk memudahkan Anda menemukan dokumen yang dibutuhkan.
            </p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row justify-between gap-4">
            <div class="w-full md:w-1/3">
                <select class="w-full border border-gray-300 rounded text-sm px-4 py-2.5 bg-gray-50 text-gray-700 focus:outline-none focus:ring-1 focus:ring-unila focus:border-unila">
                    <option value="" disabled selected>Pilih Kategori Dokumen Informasi Publik</option>
                    <option value="berkala">Informasi Berkala</option>
                    <option value="serta-merta">Informasi Serta-Merta</option>
                    <option value="setiap-saat">Informasi Setiap Saat</option>
                </select>
            </div>
            <div class="w-full md:w-1/3 relative">
                <input type="text" placeholder="Bilah Pencarian..." class="w-full border border-gray-300 rounded text-sm px-4 py-2.5 bg-gray-50 text-gray-700 focus:outline-none focus:ring-1 focus:ring-unila focus:border-unila">
                <i class="fa-solid fa-search absolute right-4 top-3 text-gray-400"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 whitespace-nowrap">
                <thead class="bg-unila text-white text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4 w-1/2">Dokumen Informasi</th>
                        <th class="px-6 py-4 text-center">Kategori</th>
                        <th class="px-6 py-4 text-center">Tahun Publikasi</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-unila whitespace-normal">Laporan Kinerja Instansi Pemerintah (LKjIP) 2023</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Berkala</span>
                        </td>
                        <td class="px-6 py-4 text-center">2023</td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="inline-flex items-center border border-unila text-unila bg-white px-4 py-1.5 rounded text-sm hover:bg-unila hover:text-white transition">
                                <i class="fa-solid fa-download mr-2"></i> Unduh
                            </a>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-unila whitespace-normal">Rencana Strategis (Renstra) FMIPA Unila 2020-2024</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Berkala</span>
                        </td>
                        <td class="px-6 py-4 text-center">2020</td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="inline-flex items-center border border-unila text-unila bg-white px-4 py-1.5 rounded text-sm hover:bg-unila hover:text-white transition">
                                <i class="fa-solid fa-download mr-2"></i> Unduh
                            </a>
                        </td>
                    </tr>

                    <tr><td class="px-6 py-6" colspan="4"></td></tr>
                    <tr><td class="px-6 py-6 border-t border-gray-100" colspan="4"></td></tr>
                    <tr><td class="px-6 py-6 border-t border-gray-100" colspan="4"></td></tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-center">
            <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                <a href="#" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    Sebelahnya
                </a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-unila text-sm font-medium text-white">
                    1
                </a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    2
                </a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    3
                </a>
                <a href="#" class="relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    Selanjutnya
                </a>
            </nav>
        </div>

        <div class="mt-16 mb-8 bg-gray-200 rounded-lg p-1">
            <div class="bg-unila rounded-md p-8 flex flex-col md:flex-row justify-between items-center text-white shadow-inner">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h3 class="text-xl font-bold mb-2">Tidak menemukan dokumen yang Anda cari?</h3>
                    <p class="text-blue-200 text-sm">Anda dapat mengajukan permohonan informasi publik secara daring melalui formulir resmi kami.</p>
                </div>
                <a href="#" class="bg-white text-unila font-bold px-6 py-2.5 rounded shadow hover:bg-gray-100 transition whitespace-nowrap">
                    Ajukan Permohonan
                </a>
            </div>
        </div>

    </main>

    <footer class="bg-unila text-white pt-12 pb-8 border-t-4 border-blue-600 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">PPID FMIPA Unila</h3>
                    <p class="text-sm text-blue-200 leading-relaxed">Gedung Dekanat FMIPA Universitas Lampung<br>Jl. Prof. Dr. Sumantri Brojonegoro No. 1<br>Bandar Lampung, 35145</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider">NAVIGASI</h3>
                    <ul class="space-y-2 text-sm text-blue-200">
                        <li><a href="/" class="hover:text-white transition">Beranda</a></li>
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
            <div class="border-t border-blue-800 pt-8 flex justify-between items-center text-xs text-blue-300">
                <p>&copy; 2026 FMIPA Universitas Lampung. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
