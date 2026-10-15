@props(['profil' => []])

@php
    $email = $profil['email'] ?? 'ppid.fmipa@unila.ac.id';
@endphp

<footer class="bg-primary-light text-slate-200 border-t border-secondary/20">
    <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-16 py-10 md:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

            <!-- BRANDING -->
            <div class="lg:col-span-6 space-y-4">
                <a href="/" class="flex items-start gap-3">
                    <span class="w-11 h-11 rounded-xl bg-white border border-secondary flex items-center justify-center shrink-0 shadow-2xs p-1.5">
                        <img src="{{ asset('images/logoPPID.png') }}?v=2.0" alt="Logo PPID" class="w-full h-full object-contain">
                    </span>
                    <span class="leading-tight pt-0.5">
                        <span class="block text-white font-extrabold text-sm leading-tight">PPID Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Lampung</span>
                        <span class="block text-secondary font-medium text-xs mt-0.5">Pejabat Pengelola Informasi dan Dokumentasi</span>
                    </span>
                </a>
                <p class="text-sm text-slate-300 leading-relaxed max-w-xl">
                    Portal resmi keterbukaan informasi publik <span class="font-bold text-white">Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Lampung</span> yang berkomitmen memberikan pelayanan informasi yang transparan, akuntabel, mudah diakses, dan berkualitas bagi masyarakat.
                </p>
            </div>

            <!-- TAUTAN CEPAT -->
            <div class="lg:col-span-3 space-y-4">
                <div>
                    <h4 class="text-white font-extrabold text-sm tracking-wide">Tautan Cepat</h4>
                    <div class="w-6 h-0.5 bg-secondary mt-2 rounded-full"></div>
                </div>
                <ul class="space-y-3 text-sm">
                    <li><a href="/" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition"><span class="text-secondary">→</span> Beranda</a></li>
                    <li><a href="{{ route('profil.ppid') ?? url('/profil-ppid') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition"><span class="text-secondary">→</span> Profil</a></li>
                    <li><a href="{{ route('informasi.publik') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition"><span class="text-secondary">→</span> Katalog Informasi</a></li>
                    <li><a href="{{ route('layanan.permohonan') }}" class="inline-flex items-center gap-2 text-slate-300 hover:text-white transition"><span class="text-secondary">→</span> Permohonan Informasi</a></li>
                </ul>
            </div>

            <!-- IKUTI KAMI -->
            <div class="lg:col-span-3 space-y-4">
                <div>
                    <h4 class="text-white font-extrabold text-sm tracking-wide">Ikuti Kami</h4>
                    <div class="w-6 h-0.5 bg-secondary mt-2 rounded-full"></div>
                </div>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Ikuti informasi dan aktivitas terbaru FMIPA Unila melalui kanal resmi kami.
                </p>
                <div class="flex items-center gap-2.5">
                    <a href="https://www.facebook.com/fmipaunila" target="_blank" aria-label="Facebook" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:text-secondary hover:border-secondary transition">
                        <i class="mdi mdi-facebook text-lg"></i>
                    </a>
                    <a href="https://www.instagram.com/fmipa_unila" target="_blank" aria-label="Instagram" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:text-secondary hover:border-secondary transition">
                        <i class="mdi mdi-instagram text-lg"></i>
                    </a>
                    <a href="https://x.com/" target="_blank" aria-label="X" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:text-secondary hover:border-secondary transition">
                        <i class="mdi mdi-twitter text-lg"></i>
                    </a>
                    <a href="https://www.youtube.com/" target="_blank" aria-label="YouTube" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:text-secondary hover:border-secondary transition">
                        <i class="mdi mdi-youtube text-lg"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- BOTTOM BAR -->
    <div class="border-t border-secondary/20">
        <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-16 py-4 flex flex-col md:flex-row items-center justify-between gap-2 text-xs text-slate-400">
            <p>&copy; {{ date('Y') }} <span class="font-bold text-white">PPID FMIPA Universitas Lampung</span>. Hak Cipta Dilindungi.</p>
            <p class="text-center md:text-right">Jl. Prof. Dr. Sumantri Brojonegoro No. 1, Bandar Lampung</p>
        </div>
    </div>
</footer>
