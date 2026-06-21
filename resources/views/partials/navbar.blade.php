<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="font-bold text-xl text-unila">PPID FMIPA Unila</a>
            </div>

            <!-- Menu -->
            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                <a href="/informasi-publik" class="hover:text-unila transition">Informasi Publik</a>
                <a href="#" class="hover:text-unila transition">Berita</a>
                <a href="#" class="hover:text-unila transition">Layanan</a>
            </div>

            <!-- Area Login / Profil -->
            <div class="flex items-center">
                @guest
                    <a href="/login" class="bg-unila text-white px-5 py-2 rounded text-sm font-semibold hover:bg-blue-900 transition shadow-sm">
                        Masuk
                    </a>
                @endguest

                @auth
                    <!-- Tombol Profil (Trigger) -->
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-2 focus:outline-none hover:bg-gray-50 px-2 py-1 rounded-lg transition">
                            <span class="text-sm font-bold text-gray-800">{{ Auth::user()->nama_lengkap }}</span>
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center border border-gray-300">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Menu Dropdown -->
                        <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-lg shadow-lg py-1 z-50">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 font-semibold hover:bg-gray-100 transition">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Script sederhana untuk buka-tutup dropdown -->
<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Menutup dropdown jika user mengklik di luar area menu
    window.onclick = function(event) {
        if (!event.target.matches('button') && !event.target.matches('span')) {
            const dropdown = document.getElementById('profileDropdown');
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        }
    }
</script>
