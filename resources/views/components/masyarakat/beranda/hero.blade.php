<!-- Hero Section Banner: Dekanat FMIPA & Konten Modern Glassmorphism -->
<section class="relative w-full min-h-[calc(100vh-124px)] flex items-center bg-[#1B365D] text-white overflow-hidden px-6 md:px-16 lg:px-24 py-20">
    <!-- Latar Belakang Asli Gambar Gedung Dekanat FMIPA Unila (Jelas & Cerah) -->
    <div class="absolute inset-0 bg-cover bg-center opacity-65" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <!-- Gradient Overlay Biru Transparan -->
    <div class="absolute inset-0 bg-gradient-to-r from-[#1B365D]/75 via-[#1B365D]/50 to-[#1B365D]/25"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        
        <!-- Kolom Kiri: Teks & Action Buttons -->
        <div class="lg:col-span-7 space-y-7 text-left">
            
            <!-- Subtitle PPID -->
            <p class="text-sky-300 text-base sm:text-lg md:text-xl lg:text-[22px] font-black tracking-wider uppercase whitespace-nowrap">
                Pejabat Pengelola Informasi & Dokumentasi (PPID)
            </p>

            <!-- Judul Utama Bold & Highlight Emas -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.15] text-white tracking-tight">
                Fakultas Matematika dan Ilmu Pengetahuan Alam <br>
                <span class="text-sky-300 underline decoration-sky-300/40 underline-offset-8">Universitas Lampung</span>
            </h1>

            <!-- Deskripsi Subtitle -->
            <p class="text-base md:text-lg text-slate-200 font-normal leading-relaxed max-w-2xl">
                Berpedoman pada <strong class="text-white font-bold">UU No. 14 Tahun 2008</strong>, kami berkomitmen menghadirkan layanan informasi yang cepat, terpercaya, dan mudah diakses guna membangun tata kelola pemerintahan yang akuntabel, profesional, serta transparan.
            </p>

            <!-- Tombol Aksi Utama -->
            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="{{ url('/informasi-publik') }}" class="px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/30 text-white text-sm font-bold transition backdrop-blur-md inline-flex items-center gap-2.5 cursor-pointer" style="border-radius: 6px !important;">
                    <i class="fa-solid fa-border-all text-xs"></i> Lihat Informasi Publik
                </a>
            </div>

            <div class="flex flex-wrap items-center gap-6 pt-6 text-xs md:text-sm text-slate-300 font-medium border-t border-white/15">
            </div>
        </div>

    </div>
</section>
