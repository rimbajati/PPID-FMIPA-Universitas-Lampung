<section class="relative w-full min-h-[520px] sm:min-h-[580px] lg:min-h-[640px] flex items-center overflow-hidden border-b border-sky-950/40">
    <!-- 1. Background Gedung Dekanat FMIPA Unila dengan Gradasi Gelap Elegan Sesuai Tema Biru PPID -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/GedungDekanatFMIPA.jpg')); ?>" 
             alt="Gedung Dekanat FMIPA Universitas Lampung" 
             class="w-full h-full object-cover object-[center_35%]">
        
        <!-- Gradasi Biru Navy Lembut & Transparan: Cukup untuk membuat teks terbaca tanpa membuat gedung gelap -->
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/75 via-sky-950/45 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent"></div>
    </div>

    <!-- 2. Konten Teks Langsung Menyatu dengan Layout Membentang Panjang ke Kanan -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-24">
        <div class="max-w-2xl sm:max-w-3xl lg:max-w-4xl space-y-6 text-left">
            
            <!-- Subtitle Badge Pill Asli (Disesuaikan untuk Background Gelap) -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-sky-500/15 text-sky-200 text-xs sm:text-sm font-extrabold border border-sky-400/30 shadow-2xs backdrop-blur-md">
                <span class="w-2.5 h-2.5 rounded-full bg-sky-400 animate-pulse"></span>
                <span>Pejabat Pengelola Informasi & Dokumentasi (PPID)</span>
            </div>

            <!-- Judul Utama Persis Desain Awal (Warna Putih & Highlight Sky Blue Bersinar) -->
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-[4rem] font-black text-white tracking-tight leading-[1.12]">
                Portal Layanan <br>
                <span class="relative inline-flex items-center px-4 py-1 mt-2 bg-gradient-to-r from-sky-400/20 via-sky-300/15 to-blue-400/20 rounded-2xl border border-sky-300/40 backdrop-blur-xs shadow-2xs">
                    <span class="bg-gradient-to-r from-sky-300 via-sky-400 to-blue-300 bg-clip-text text-transparent">Informasi Publik.</span>
                </span>
            </h1>

            <!-- Deskripsi Persis Desain Awal (Kontras & Lembut di Atas Gelap) -->
            <p class="text-sm sm:text-base lg:text-lg text-slate-200 font-medium leading-relaxed max-w-2xl sm:max-w-3xl">
                Berpedoman pada <strong class="text-sky-300 font-bold">UU No. 14 Tahun 2008</strong>, kami berkomitmen menghadirkan layanan informasi yang cepat, terpercaya, dan mudah diakses guna membangun tata kelola FMIPA Universitas Lampung yang akuntabel, profesional, serta transparan.
            </p>

            <!-- Tombol Aksi Utama Persis Desain Awal -->
            <div class="flex flex-wrap items-center gap-3.5 pt-2">
                <a href="<?php echo e(url('/informasi-publik')); ?>" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-sky-500 hover:bg-sky-400 text-white text-sm sm:text-base font-extrabold rounded-full transition-all shadow-lg shadow-sky-500/30 hover:shadow-xl hover:shadow-sky-400/40 hover:-translate-y-0.5 inline-flex items-center justify-center gap-2 cursor-pointer">
                    <span>Mulai Cari Informasi</span>
                </a>
                
                <a href="<?php echo e(url('/permohonan')); ?>" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-white/10 hover:bg-white/20 text-white hover:text-sky-200 text-sm sm:text-base font-extrabold rounded-full border-2 border-white/30 hover:border-sky-400 transition-all shadow-2xs hover:shadow-md hover:-translate-y-0.5 inline-flex items-center justify-center gap-2.5 cursor-pointer backdrop-blur-sm">
                    <span>Ajukan Permohonan</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

        </div>
    </div>
</section>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/masyarakat/beranda/hero.blade.php ENDPATH**/ ?>