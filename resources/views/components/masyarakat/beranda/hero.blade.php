<section class="relative w-full flex items-center overflow-hidden" style="min-height:calc(100dvh - var(--header-h)); min-height:calc(100vh - var(--header-h));">
    <!-- 1. Background Gedung Dekanat FMIPA Unila dengan Gradasi Gelap Elegan Sesuai Tema Biru PPID -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/GedungDekanatFMIPA.jpg') }}" 
             alt="Gedung Dekanat FMIPA Universitas Lampung" 
             class="w-full h-full object-cover object-[center_35%]">
        
        <!-- Gradasi Biru Navy Lembut & Transparan: Cukup untuk membuat teks terbaca tanpa membuat gedung gelap -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/75 via-sky-950/45 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
    </div>

    <!-- 2. Konten Teks Langsung Menyatu dengan Layout Membentang Panjang ke Kanan -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
        <div class="max-w-2xl sm:max-w-3xl lg:max-w-4xl space-y-6 text-left">
            
            <!-- Judul Utama Persis Desain Awal (Warna Putih & Highlight Sky Blue Bersinar) -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-[4rem] font-black text-white tracking-tight leading-[1.12]">
                Portal Layanan <br>
                <span class="relative inline-block pb-2">
                    <span class="bg-gradient-to-r from-white via-sky-100 to-[#7dd3fc] bg-clip-text text-transparent">Informasi Publik.</span>
                    <span class="absolute bottom-0 left-0 w-full h-2.5 bg-gradient-to-r from-[#0284c7] to-[#38bdf8] rounded-full shadow-sm shadow-sky-400/40"></span>
                </span>
            </h1>

            <!-- Deskripsi Persis Desain Awal (Kontras & Lembut di Atas Gelap) -->
            <p class="text-sm sm:text-base lg:text-lg text-slate-200 font-medium leading-relaxed max-w-2xl sm:max-w-3xl pt-2">
                Berpedoman pada <strong class="text-secondary font-bold">UU No. 14 Tahun 2008</strong>, kami berkomitmen menghadirkan layanan informasi yang cepat, terpercaya, dan mudah diakses guna membangun tata kelola FMIPA Universitas Lampung yang akuntabel, profesional, serta transparan.
            </p>

            <!-- Tombol Aksi Utama Persis Desain Awal -->
            <div class="flex flex-wrap items-center gap-3.5 pt-2">
                <a href="{{ url('/informasi-publik') }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-primary hover:bg-primary-light text-white text-sm sm:text-base font-extrabold rounded-full transition-all shadow-lg shadow-primary/15 hover:shadow-xl hover:shadow-sky-400/40 hover:-translate-y-0.5 inline-flex items-center justify-center gap-2 cursor-pointer">
                    <span>Mulai Cari Informasi</span>
                </a>
                
                <a href="{{ url('/permohonan') }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-white/10 hover:bg-white/20 text-white hover:text-secondary text-sm sm:text-base font-extrabold rounded-full border-2 border-white/30 hover:border-secondary transition-all shadow-2xs hover:shadow-md hover:-translate-y-0.5 inline-flex items-center justify-center gap-2.5 cursor-pointer backdrop-blur-sm">
                    <span>Ajukan Permohonan</span>
                    <i class="mdi mdi-arrow-right text-base"></i>
                </a>
            </div>

        </div>
    </div>
</section>
