@props(['halaman' => []])

@php
    $halamanData = !empty($halaman) ? $halaman : \App\Http\Controllers\Admin\KontenController::getHalamanProfil();
@endphp

<!-- Tentang Kami & Nilai Pelayanan Kami -->
<section id="tentang-kami" class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 pt-14 sm:pt-20 mb-16 sm:mb-20 relative z-20 scroll-mt-24 sm:scroll-mt-28">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
        <!-- Kiri: Deskripsi Tentang Kami -->
        <div class="lg:col-span-7 space-y-6">
            <div class="space-y-3">
                <p class="text-sm font-extrabold uppercase tracking-[0.18em] text-primary">— Tentang kami</p>
                <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-slate-900 tracking-tight leading-none">{{ $halamanData['tentang_judul'] ?? 'Apa itu PPID?' }}</h2>
                <div class="h-1.5 w-16 bg-secondary rounded-full"></div>
            </div>
            <div class="space-y-4 text-base sm:text-lg text-slate-600 leading-relaxed font-normal">
                <p>{{ $halamanData['tentang_p1'] ?? 'Pejabat Pengelola Informasi dan Dokumentasi (PPID) adalah pejabat yang bertanggung jawab di bidang penyimpanan, pendokumentasian, penyediaan, dan pelayanan informasi di badan publik.' }}</p>
                <p>{{ $halamanData['tentang_p2'] ?? 'PPID FMIPA Universitas Lampung dibentuk untuk mewujudkan komitmen keterbukaan informasi publik sesuai amanat Undang-Undang Nomor 14 Tahun 2008. Kami melayani sivitas akademika dan masyarakat umum dalam memperoleh informasi publik yang berkualitas.' }}</p>
            </div>
        </div>

        <!-- Kanan: Nilai Pelayanan Kami berbentuk kartu kontainer elegan -->
        <div class="lg:col-span-5">
            <div class="bg-secondary-light border border-secondary/20 rounded-3xl p-7 sm:p-8 space-y-5 shadow-xs">
                <h3 class="text-lg font-black text-slate-900">Nilai Pelayanan Kami</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-white border border-secondary/20 text-primary flex items-center justify-center shrink-0 shadow-2xs"><i class="mdi mdi-eye-outline text-base"></i></span>
                        <div class="leading-snug">
                            <span class="block text-sm font-bold text-slate-900">Transparan</span>
                            <span class="block text-xs text-slate-600 mt-0.5">Terbuka dalam penyediaan dan penyebarluasan informasi publik.</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-white border border-secondary/20 text-primary flex items-center justify-center shrink-0 shadow-2xs"><i class="mdi mdi-check-circle-outline text-base"></i></span>
                        <div class="leading-snug">
                            <span class="block text-sm font-bold text-slate-900">Akuntabel</span>
                            <span class="block text-xs text-slate-600 mt-0.5">Bertanggung jawab penuh atas setiap proses pelayanan.</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-white border border-secondary/20 text-primary flex items-center justify-center shrink-0 shadow-2xs"><i class="mdi mdi-star-outline text-base"></i></span>
                        <div class="leading-snug">
                            <span class="block text-sm font-bold text-slate-900">Profesional</span>
                            <span class="block text-xs text-slate-600 mt-0.5">Kompeten, cepat, dan berintegritas dalam melayani.</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-white border border-secondary/20 text-primary flex items-center justify-center shrink-0 shadow-2xs"><i class="mdi mdi-account-group-outline text-base"></i></span>
                        <div class="leading-snug">
                            <span class="block text-sm font-bold text-slate-900">Partisipatif</span>
                            <span class="block text-xs text-slate-600 mt-0.5">Melibatkan publik dalam pengawasan dan evaluasi layanan.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
