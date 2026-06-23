<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="font-bold text-xl text-[#0095e8]">PPID FMIPA Unila</a>
            </div>

            <div class="hidden md:flex space-x-8 text-sm font-bold text-gray-600 items-center">
                <a href="/informasi-publik" class="hover:text-[#0095e8] transition">Informasi Publik</a>
                <a href="https://fmipa.unila.ac.id/berita" class="hover:text-[#0095e8] transition">Berita</a>

                <div class="relative group">
                    <button onclick="toggleLayanan()" class="hover:text-[#0095e8] transition flex items-center gap-1 focus:outline-none">
                        Layanan
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="layananDropdown" class="hidden absolute top-full left-0 mt-3 w-72 bg-white border border-gray-100 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] py-3 z-50 transform transition-all duration-200">
                        <a href="{{ route('permohonan.create') }}" class="flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-[#0095e8] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="font-medium text-sm">Formulir Permohonan Informasi Publik</span>
                        </a>
                        <a href="{{ route('keberatan.create') }}" class="flex items-center gap-3 px-5 py-3 text-gray-700 hover:bg-blue-50 hover:text-[#0095e8] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span class="font-medium text-sm">Formulir Keberatan Informasi Publik</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex items-center">
                @guest
                    <a href="/login" class="bg-[#0095e8] text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-[#0081c9] transition shadow-md">Masuk</a>
                @endguest

                @auth
                    <div class="relative ml-4">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-2 focus:outline-none hover:bg-gray-50 px-2 py-1 rounded-lg transition">
                            <span class="text-sm font-bold text-gray-800">{{ Auth::user()->nama_lengkap }}</span>
                            <div class="w-8 h-8 bg-[#0095e8]/10 rounded-full flex items-center justify-center border border-[#0095e8]">
                                <svg class="w-4 h-4 text-[#0095e8]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            </div>
                        </button>
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-xl shadow-xl py-1 z-50">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 font-bold hover:bg-gray-100 transition">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleLayanan() { document.getElementById('layananDropdown').classList.toggle('hidden'); }
    function toggleDropdown() { document.getElementById('profileDropdown').classList.toggle('hidden'); }

    // Menutup dropdown jika klik di luar area
    window.onclick = function(event) {
        if (!event.target.matches('button') && !event.target.closest('button')) {
            const layDrop = document.getElementById('layananDropdown');
            const profDrop = document.getElementById('profileDropdown');
            if (!layDrop.classList.contains('hidden')) layDrop.classList.add('hidden');
            if (!profDrop.classList.contains('hidden')) profDrop.classList.add('hidden');
        }
    }
</script>
