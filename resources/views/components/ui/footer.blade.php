<footer class="bg-[#F0F9FF] text-slate-700 py-16 border-t border-sky-200/60">
    <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-16">
        
        <!-- GRID 5 KOLOM (Persis Tata Letak Referensi) -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-12 gap-10 lg:gap-8">
            
            <!-- KOLOM 1: BRANDING & KONTAK (4 Columns) -->
            <div class="lg:col-span-4 space-y-4">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PPID FMIPA Unila" class="h-8 w-auto object-contain">
                    <h3 class="text-base font-black text-slate-900 tracking-tight">PPID FMIPA Unila</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed font-normal pr-4">
                    Portal resmi Pejabat Pengelola Informasi dan Dokumentasi Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Lampung. Menjamin keterbukaan informasi publik secara cepat, transparan, dan akuntabel.
                </p>

                <div class="pt-2 space-y-1 text-xs text-slate-600 font-normal">
                    <p class="font-bold text-slate-900">PPID FMIPA Universitas Lampung</p>
                    <p>ppid.fmipa@unila.ac.id</p>
                    <p>Telepon: +62 721-704625</p>
                    <p>Jl. Prof. Dr. Sumantri Brojonegoro No. 1, Bandar Lampung</p>
                </div>

                <div class="pt-4 text-xs text-slate-500 font-medium">
                    &copy; {{ date('Y') }} PPID FMIPA Unila. Semua hak dilindungi.
                </div>
            </div>

            <!-- KOLOM 2: LAYANAN PPID (2 Columns) -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">
                    Layanan PPID
                </h4>
                <ul class="space-y-3 text-xs">
                    <li>
                        <a href="{{ route('layanan.permohonan') }}" class="block hover:text-sky-600 transition-colors">
                            <span class="font-semibold text-slate-800 block">Permohonan Informasi</span>
                            <span class="text-[10px] text-slate-400 block font-normal">Formulir Pengajuan Online</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('layanan.keberatan') }}" class="block hover:text-sky-600 transition-colors">
                            <span class="font-semibold text-slate-800 block">Pengajuan Keberatan</span>
                            <span class="text-[10px] text-slate-400 block font-normal">Proses Keberatan Publik</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('layanan.riwayat') }}" class="block hover:text-sky-600 transition-colors">
                            <span class="font-semibold text-slate-800 block">Lacak Tiket Layanan</span>
                            <span class="text-[10px] text-slate-400 block font-normal">Status Tiket Real-Time</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('layanan') }}" class="block hover:text-sky-600 transition-colors">
                            <span class="font-semibold text-slate-800 block">Hub Layanan</span>
                            <span class="text-[10px] text-slate-400 block font-normal">Katalog Layanan PPID</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- KOLOM 3: INFORMASI PUBLIK (2 Columns) -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">
                    Informasi Publik
                </h4>
                <ul class="space-y-2.5 text-xs font-medium text-slate-600">
                    <li>
                        <a href="{{ route('informasi.publik', ['kategori' => 'Berkala']) }}" class="hover:text-sky-600 transition-colors">Informasi Berkala</a>
                    </li>
                    <li>
                        <a href="{{ route('informasi.publik', ['kategori' => 'Serta Merta']) }}" class="hover:text-sky-600 transition-colors">Informasi Serta Merta</a>
                    </li>
                    <li>
                        <a href="{{ route('informasi.publik', ['kategori' => 'Setiap Saat']) }}" class="hover:text-sky-600 transition-colors">Informasi Setiap Saat</a>
                    </li>
                    <li>
                        <a href="{{ route('informasi.publik') }}" class="hover:text-sky-600 transition-colors">Daftar Informasi Publik</a>
                    </li>
                </ul>
            </div>

            <!-- KOLOM 4: PORTAL TERKAIT (2 Columns) -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">
                    Portal Terkait
                </h4>
                <ul class="space-y-2.5 text-xs font-medium text-slate-600">
                    <li>
                        <a href="https://unila.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-sky-600 transition-colors">Universitas Lampung</a>
                    </li>
                    <li>
                        <a href="https://fmipa.unila.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-sky-600 transition-colors">FMIPA Unila</a>
                    </li>
                    <li>
                        <a href="https://ppid.unila.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-sky-600 transition-colors">PPID Utama Unila</a>
                    </li>
                    <li>
                        <a href="https://kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="hover:text-sky-600 transition-colors">Kemendikbudristek</a>
                    </li>
                </ul>
            </div>

            <!-- KOLOM 5: AKUN & AKSES (2 Columns) -->
            <div class="lg:col-span-2 space-y-3">
                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">
                    Akun & Akses
                </h4>
                <ul class="space-y-2.5 text-xs font-medium text-slate-600">
                    <li>
                        <a href="{{ route('login') }}" class="hover:text-sky-600 transition-colors">Masuk Akun</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="hover:text-sky-600 transition-colors">Pendaftaran Pemohon</a>
                    </li>
                    <li>
                        <a href="{{ route('password.request') }}" class="hover:text-sky-600 transition-colors">Lupa Kata Sandi</a>
                    </li>
                    <li>
                        <a href="{{ route('beranda') }}" class="hover:text-sky-600 transition-colors">Beranda Utama</a>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</footer>
