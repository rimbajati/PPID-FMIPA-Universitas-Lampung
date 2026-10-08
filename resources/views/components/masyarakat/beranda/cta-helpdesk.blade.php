@props(['profil' => []])

@php
    $email = $profil['email'] ?? 'ppid.fmipa@unila.ac.id';
    $wa    = preg_replace('/[^0-9]/', '', $profil['whatsapp'] ?? '6281320178069');
@endphp

<!-- Call to Action Banner & Helpdesk PPID Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 mb-20">
    <div class="relative bg-gradient-to-r from-sky-600 via-sky-500 to-blue-600 rounded-3xl p-6 sm:p-8 lg:px-10 lg:py-7 text-white overflow-hidden shadow-xl shadow-sky-600/20">
        
        <!-- Ambient Geometric / Soft Rings -->
        <div class="absolute -right-16 -top-16 w-64 h-64 border-8 border-white/10 rounded-full pointer-events-none"></div>
        <div class="absolute right-32 -bottom-20 w-80 h-80 border-8 border-white/10 rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-6 text-center lg:text-left">
            
            <div class="space-y-2 max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-0.5 rounded-full bg-white/20 text-white text-[11px] font-bold backdrop-blur-xs">
                    <i class="fa-solid fa-headset text-[11px]"></i>
                    <span>Pusat Bantuan & Konsultasi</span>
                </div>
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight leading-snug">
                    Butuh Bantuan Terkait Informasi Publik FMIPA?
                </h2>
                <p class="text-xs sm:text-sm text-sky-100 font-normal leading-relaxed">
                    Tim PPID FMIPA Universitas Lampung siap melayani kebutuhan data dan konsultasi Anda di jam kerja operasional.
                </p>
            </div>

            <!-- Tombol Aksi Helpdesk -->
            <div class="flex flex-wrap items-center justify-center gap-3 shrink-0">
                <a href="https://wa.me/{{ $wa }}" target="_blank" class="px-5 sm:px-6 py-2.5 bg-white hover:bg-slate-50 text-sky-700 text-xs sm:text-sm font-extrabold rounded-full transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 inline-flex items-center gap-2 cursor-pointer">
                    <i class="fa-brands fa-whatsapp text-emerald-500 text-base"></i>
                    <span>Hubungi WhatsApp</span>
                </a>

                <a href="mailto:{{ $email }}" class="px-5 sm:px-6 py-2.5 bg-sky-700/60 hover:bg-sky-700 text-white text-xs sm:text-sm font-extrabold rounded-full border border-white/30 transition-all shadow-2xs hover:shadow-md hover:-translate-y-0.5 inline-flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-envelope text-xs"></i>
                    <span>Kirim Email</span>
                </a>
            </div>

        </div>

    </div>
</section>
