<section class="relative w-full min-h-[calc(100vh-130px)] flex items-center bg-gradient-to-b from-slate-50 via-white to-sky-50/40 text-slate-800 overflow-hidden py-8 md:py-12 border-b border-slate-200/60">
    <!-- Container Sejajar dan Sama Lebar dengan Navbar (max-w-7xl) -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
        
        <!-- Kolom Kiri: Teks & Action Pill Buttons (6 Kolom / 50%) -->
        <div class="lg:col-span-6 space-y-6 text-left">
            
            <!-- Subtitle Badge Pill (#1 Platform Tag) -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-50 text-sky-700 text-xs sm:text-sm font-extrabold border border-sky-200/80 shadow-2xs">
                <span class="w-2.5 h-2.5 rounded-full bg-sky-500 animate-pulse"></span>
                <span>Pejabat Pengelola Informasi & Dokumentasi (PPID)</span>
            </div>

            <!-- Judul Utama Bold & Accent Gradient Capsule (Diperbesar) -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-[4rem] font-black text-slate-900 tracking-tight leading-[1.12]">
                Portal Layanan <br>
                <span class="relative inline-flex items-center px-4 py-1 mt-2 bg-gradient-to-r from-sky-500/10 via-sky-400/15 to-blue-500/10 rounded-2xl border border-sky-300/40 backdrop-blur-xs shadow-2xs">
                    <span class="bg-gradient-to-r from-sky-500 via-sky-600 to-blue-700 bg-clip-text text-transparent">Informasi Publik.</span>
                </span>
            </h1>

            <!-- Deskripsi Subtitle (Diperbesar) -->
            <p class="text-sm sm:text-base lg:text-lg text-slate-600 font-medium leading-relaxed max-w-xl">
                Berpedoman pada <strong class="text-sky-600 font-bold">UU No. 14 Tahun 2008</strong>, kami berkomitmen menghadirkan layanan informasi yang cepat, terpercaya, dan mudah diakses guna membangun tata kelola FMIPA Universitas Lampung yang akuntabel, profesional, serta transparan.
            </p>

            <!-- Tombol Aksi Utama (Pill Style Diperbesar & Lebih Gagah) -->
            <div class="flex flex-wrap items-center gap-3.5 pt-2">
                <a href="{{ url('/informasi-publik') }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-sky-500 hover:bg-sky-600 text-white text-sm sm:text-base font-extrabold rounded-full transition-all shadow-lg shadow-sky-500/25 hover:shadow-xl hover:shadow-sky-500/35 hover:-translate-y-0.5 inline-flex items-center justify-center gap-2 cursor-pointer">
                    <span>Mulai Cari Informasi</span>
                </a>
                
                <a href="{{ url('/permohonan') }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-white hover:bg-sky-50/60 text-slate-800 hover:text-sky-600 text-sm sm:text-base font-extrabold rounded-full border-2 border-slate-300 hover:border-sky-500 transition-all shadow-2xs hover:shadow-md hover:-translate-y-0.5 inline-flex items-center justify-center gap-2.5 cursor-pointer">
                    <span>Ajukan Permohonan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Kolom Kanan: Browser Window Frame Mockup (6 Kolom / 50% Lebih Pas dan Gagah) -->
        <div class="lg:col-span-6 flex justify-center lg:justify-end items-center">
            
            <!-- Soft Outer Frame Box -->
            <div class="w-full max-w-lg bg-slate-200/60 p-2 sm:p-2.5 rounded-2xl sm:rounded-3xl border border-slate-300/40 shadow-xl relative">
                
                <!-- Inner Browser Mockup Card -->
                <div class="w-full bg-white rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden text-left">
                    
                    <!-- Browser Window Control Bar -->
                    <div class="bg-slate-50 px-4 py-2.5 border-b border-slate-200/80 flex items-center justify-between gap-3">
                        <!-- macOS Control Dots -->
                        <div class="flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-400 inline-block"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 inline-block"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span>
                        </div>
                        
                        <!-- Simulated Address Bar -->
                        <div class="flex-1 max-w-[200px] sm:max-w-xs bg-white border border-slate-200 rounded-full px-3.5 py-0.5 text-[11px] sm:text-xs font-semibold text-slate-500 flex items-center justify-between gap-1.5 shadow-2xs">
                            <span class="truncate">ppid.fmipa.unila.ac.id</span>
                            <i class="fa-solid fa-lock text-slate-400 text-[9px]"></i>
                        </div>

                        <!-- Top Right Simulated Filter Badges -->
                        <div class="hidden sm:flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
                            <span class="px-2 py-0.5 bg-slate-200/80 rounded">PPID</span>
                            <span class="px-2 py-0.5 bg-sky-100 text-sky-800 rounded">FMIPA</span>
                        </div>
                    </div>

                    <!-- Browser Content Area: Gambar Gedung Dekanat FMIPA (Tinggi Proporsional & Pas) -->
                    <div class="relative overflow-hidden group">
                        <img src="{{ asset('images/GedungDekanatFMIPA.jpg') }}" alt="Gedung Dekanat FMIPA Unila" class="w-full h-[280px] sm:h-[330px] md:h-[360px] object-cover hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent flex items-end p-5 sm:p-6">
                            <div class="text-white space-y-0.5">
                                <p class="text-xs sm:text-sm font-bold tracking-wider text-sky-300">Fakultas Matematika dan Ilmu Pengetahuan Alam</p>
                                <h3 class="text-lg sm:text-xl font-black">Universitas Lampung</h3>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>
