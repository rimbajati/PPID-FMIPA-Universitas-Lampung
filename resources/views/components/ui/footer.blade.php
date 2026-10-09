@props(['profil' => []])

@php
    $email = $profil['email'] ?? 'ppid.fmipa@unila.ac.id';
    $waRaw = preg_replace('/[^0-9]/', '', $profil['whatsapp'] ?? '6281320178069');
    $waDisplay = '+' . substr($waRaw, 0, 2) . ' ' . substr($waRaw, 2, 3) . '-' . substr($waRaw, 5, 4) . '-' . substr($waRaw, 9);
    $namaPIC = $profil['nama'] ?? 'Aristoeteles';
    $jabatanPIC = $profil['jabatan'] ?? 'Kasubag TU';
@endphp

<footer class="bg-[#E0F2FE] text-slate-600 py-6 border-t border-sky-200">
    <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-16">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
            
            <!-- BRANDING -->
            <div class="lg:col-span-5 space-y-2">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('images/logoPPID.png') }}?v=2.0" alt="Logo PPID" class="h-7 w-auto object-contain">
                    <div class="text-left leading-tight">
                        <span class="block text-slate-900 font-extrabold text-xs tracking-wide uppercase">PPID Pelaksana</span>
                        <span class="block text-slate-500 font-semibold text-[10px] tracking-wide uppercase">FMIPA Universitas Lampung</span>
                    </div>
                </a>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Portal resmi PPID Pelaksana FMIPA Universitas Lampung.
                </p>
                <div class="pt-1.5 space-y-0.5 text-xs text-slate-500">
                    <p><i class="fa-solid fa-envelope text-slate-400 mr-1.5 text-[11px]"></i>{{ $email }}</p>
                    <p><i class="fa-brands fa-whatsapp text-slate-400 mr-1.5 text-[11px]"></i><a href="https://wa.me/{{ $waRaw }}" target="_blank" class="hover:text-slate-700 transition">{{ $waDisplay }}</a></p>
                </div>
            </div>

            <!-- LINKS -->
            <div class="lg:col-span-2 space-y-2">
                <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">Layanan</h4>
                <ul class="space-y-1.5 text-xs">
                    <li><a href="{{ route('tata-cara') }}" class="hover:text-slate-900 transition">Tata Cara</a></li>
                    <li><a href="{{ route('layanan.permohonan') }}" class="hover:text-slate-900 transition">Permohonan</a></li>
                    <li><a href="{{ route('layanan.keberatan') }}" class="hover:text-slate-900 transition">Keberatan</a></li>
                    <li><a href="{{ route('layanan.riwayat') }}" class="hover:text-slate-900 transition">Lacak Tiket</a></li>
                </ul>
            </div>

            <div class="lg:col-span-3 space-y-2">
                <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">Informasi Publik</h4>
                <ul class="space-y-1.5 text-xs">
                    <li><a href="{{ route('informasi.publik') }}" class="hover:text-slate-900 transition">Daftar Informasi Publik</a></li>
                    <li><a href="{{ route('informasi.publik', ['kategori' => 'Berkala']) }}" class="hover:text-slate-900 transition">Berkala</a></li>
                    <li><a href="{{ route('informasi.dikecualikan') }}" class="hover:text-slate-900 transition">Dikecualikan</a></li>
                    <li><a href="{{ route('regulasi') }}" class="hover:text-slate-900 transition">Regulasi</a></li>
                </ul>
            </div>

            <div class="lg:col-span-2 space-y-2">
                <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">Tautan</h4>
                <ul class="space-y-1.5 text-xs">
                    <li><a href="https://unila.ac.id" target="_blank" class="hover:text-slate-900 transition">Unila</a></li>
                    <li><a href="https://fmipa.unila.ac.id" target="_blank" class="hover:text-slate-900 transition">FMIPA</a></li>
                    <li><a href="{{ route('admin.login') }}" class="hover:text-slate-900 transition">Login Admin</a></li>
                </ul>
            </div>

        </div>

        <div class="mt-6 pt-4 border-t border-sky-100 flex flex-col md:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
            <p>&copy; {{ date('Y') }} PPID FMIPA Unila</p>
            <p>Jl. Prof. Dr. Sumantri Brojonegoro No. 1, Bandar Lampung</p>
        </div>

    </div>
</footer>
