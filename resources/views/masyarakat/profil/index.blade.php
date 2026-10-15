@extends('components.layouts.app')

@section('title', 'Profil - PPID Pelaksana FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-white min-h-screen pb-20">

    <!-- 1. HERO BANNER - Akademik Navy Emas -->
    <section class="bg-gradient-to-r from-primary via-primary-light to-primary text-white py-12 md:py-16 relative overflow-hidden shadow-md border-b-2 border-secondary/30">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-secondary/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full bg-secondary/5 blur-2xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-white p-2.5 shadow-xl border-2 border-secondary shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logoPPID.png') }}?v=3.0" alt="Logo PPID FMIPA Unila" class="w-full h-full object-contain">
                </div>
                <div class="space-y-2">
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">{{ $halaman['hero_judul'] ?? 'Profil PPID Pelaksana FMIPA' }}</h1>
                    <p class="w-full max-w-none text-slate-300 text-sm sm:text-base font-normal leading-relaxed">{{ $halaman['hero_deskripsi'] ?? '' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. TENTANG + NILAI PELAYANAN KAMI -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            <!-- Kiri: Deskripsi Tentang Kami (tanpa tombol ajukan permohonan) -->
            <div class="lg:col-span-6 space-y-6">
                <div class="space-y-3">
                    <p class="text-sm font-extrabold uppercase tracking-[0.18em] text-primary">— Tentang kami</p>
                    <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-slate-900 tracking-tight leading-none">{{ $halaman['tentang_judul'] ?? 'Apa itu PPID?' }}</h2>
                    <div class="h-1.5 w-16 bg-primary rounded-full"></div>
                </div>
                <div class="space-y-4 text-base sm:text-lg text-slate-600 leading-relaxed">
                    <p>{{ $halaman['tentang_p1'] ?? '' }}</p>
                    <p>{{ $halaman['tentang_p2'] ?? '' }}</p>
                </div>
            </div>

            <!-- Kanan: Menggantikan Paket Regulasi dengan Nilai Pelayanan Kami berbentuk kartu kontainer elegan -->
            <div class="lg:col-span-5">
                <div class="bg-secondary-light border border-secondary/20 rounded-3xl p-7 sm:p-8 space-y-5">
                    <div class="w-14 h-14 rounded-2xl bg-primary text-white flex items-center justify-center text-xl shadow-sm">
                        <i class="mdi mdi-shield-star-outline"></i>
                    </div>
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

    <!-- 3. VISI & MISI — redesign: Stacked layout (Visi atas, Misi bawah) -->
    <section class="bg-slate-50 border-y border-slate-100 py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <div class="text-center space-y-3">
                <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-slate-900 tracking-tight leading-none">Visi & Misi</h2>
                <div class="h-1.5 w-16 bg-secondary rounded-full mx-auto"></div>
            </div>

            <!-- VISI — Atas, Kartu Full Width Lebar (Sejajar Container) -->
            <div class="w-full">
                <div class="bg-gradient-to-br from-primary to-primary-light rounded-3xl p-8 sm:p-14 text-white text-center shadow-lg relative overflow-hidden">
                    <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
                    <div class="absolute -left-20 -bottom-20 w-80 h-80 rounded-full bg-secondary/10 blur-3xl pointer-events-none"></div>
                    
                    <div class="relative space-y-6">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 text-slate-200 text-xs font-extrabold uppercase tracking-widest border border-white/20">
                            <i class="mdi mdi-eye-outline text-[10px]"></i> Visi Kami
                        </span>
                        <blockquote class="text-xl sm:text-2xl lg:text-3xl font-black leading-tight">
                            "{{ $halaman['visi'] ?? '' }}"
                        </blockquote>
                        <div class="pt-4 border-t border-white/10 w-32 mx-auto">
                            <p class="text-xs sm:text-sm text-secondary font-bold uppercase tracking-wider">PPID FMIPA Unila</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MISI — Bawah, Grid 4 Kolom dengan Keterangan Misi Kami -->
            <div class="space-y-6">
                <div class="flex items-center justify-center">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-secondary/15 text-primary text-xs font-extrabold uppercase tracking-widest border border-secondary/30">
                        <i class="mdi mdi-target text-secondary text-sm"></i> Misi Kami
                    </span>
                </div>

                <div class="space-y-4 max-w-4xl mx-auto">
                    @foreach(($halaman['misi'] ?? []) as $idx => $misi)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 relative overflow-hidden hover:border-secondary/40 hover:shadow-lg transition-all duration-300 group">
                        <span class="absolute -right-2 -bottom-4 text-6xl font-black leading-none select-none pointer-events-none group-hover:scale-105 transition-transform duration-300" style="color: rgba(15,42,68,0.04);">{{ str_pad($idx+1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-primary text-secondary flex items-center justify-center text-base sm:text-lg font-black shrink-0 shadow-xs">
                            {{ $idx+1 }}
                        </div>
                        <div class="space-y-1 flex-1 min-w-0 pr-8">
                            <h4 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-primary transition-colors leading-snug">
                                {{ $misi['judul'] }}
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                                {{ $misi['deskripsi'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- 4. STRUKTUR — hierarki 3 lapis: Kepala → Wakil → Koordinator -->
    <section class="max-w-6xl mx-auto px-4 sm:px-8 lg:px-12 py-14 space-y-8">
        <div class="text-center space-y-3">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ $halaman['struktur_judul'] ?? 'Struktur Organisasi' }}</h2>
            <div class="h-1.5 w-16 bg-secondary rounded-full mx-auto"></div>
        </div>

        @php
            // Helper fungsi inisial bersih (ambil dari nama_lengkap, atau bersihkan gelar jika tersimpan dalam nama)
            $cleanName = function($fullName, $namaLengkap = null) {
                if (!empty($namaLengkap)) {
                    $words = array_values(array_filter(explode(' ', trim($namaLengkap))));
                    if (count($words) >= 2) {
                        return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                    } elseif (count($words) === 1) {
                        return strtoupper(substr($words[0], 0, 1));
                    }
                }
                // Jika hanya ada nama dengan gelar, bersihkan gelar umum
                $cleaned = preg_replace('/\b(Dr|Drs|Ir|Prof|Eng|S\.Si|M\.Si|M\.T|M\.Kom|S\.T|S\.Kom|Ph\.D|M\.Sc|B\.Sc)\b\.?/i', '', $fullName ?? '');
                $cleaned = trim(preg_replace('/[^a-zA-Z\s]/', '', $cleaned));
                $words = array_values(array_filter(explode(' ', $cleaned)));
                if (count($words) >= 2) {
                    return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                } elseif (count($words) === 1) {
                    return strtoupper(substr($words[0], 0, 1));
                }
                return strtoupper(substr($fullName ?: 'A', 0, 1));
            };

            $inisialKepala = $cleanName($profil['nama'] ?? 'Heri Satria', $profil['nama_lengkap'] ?? null);
            $inisialWakil  = $cleanName($profil['wakil_nama'] ?? 'Aristoteles', $profil['wakil_nama_lengkap'] ?? null);
        @endphp

        <!-- Level 1: Kepala PPID -->
        <div class="flex justify-center">
            <div class="relative w-full max-w-lg bg-primary text-white rounded-3xl p-8 pt-10 text-center shadow-xl">
                <span class="absolute -top-4 left-1/2 -translate-x-1/2 px-6 py-2 rounded-full bg-secondary text-primary text-sm font-black uppercase tracking-wider">Kepala PPID</span>
                <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center mx-auto font-black text-2xl tracking-wider">{{ $inisialKepala }}</div>
                <p class="font-black text-2xl mt-4 leading-tight">{{ $profil['nama'] ?? 'Dekan FMIPA' }}</p>
                <p class="text-base text-slate-200 mt-2 font-medium">{{ ($halaman['struktur_atasan']['jabatan'] ?? 'Dekan FMIPA') }}</p>
            </div>
        </div>

        <!-- Connector Kepala -> Wakil -->
        <div class="flex justify-center -my-2"><div class="w-0.5 h-10 bg-slate-300"></div></div>

        <!-- Level 2: Wakil Kepala PPID -->
        <div class="flex justify-center">
            <div class="relative w-full max-w-lg bg-white border-2 border-secondary/30 rounded-3xl p-8 pt-10 text-center shadow-md">
                <span class="absolute -top-4 left-1/2 -translate-x-1/2 px-6 py-2 rounded-full bg-primary text-white text-sm font-black uppercase tracking-wider">Wakil Kepala</span>
                <div class="w-20 h-20 rounded-full bg-primary text-secondary flex items-center justify-center mx-auto font-black text-2xl tracking-wider">{{ $inisialWakil }}</div>
                <p class="font-black text-xl sm:text-2xl mt-4 text-slate-900 leading-tight">{{ $profil['wakil_nama'] ?? ($halaman['struktur_ketua']['jabatan'] ?? 'Wakil Kepala PPID') }}</p>
                <p class="text-base text-slate-600 mt-2 font-medium">{{ ($halaman['struktur_ketua']['jabatan'] ?? 'Wakil Dekan Bidang Umum dan Keuangan') }}</p>
            </div>
        </div>

        <!-- Connector Wakil -> Koordinator -->
        <div class="flex justify-center -my-2"><div class="w-0.5 h-8 bg-slate-200"></div></div>

        <!-- Koordinator Bidang (Dinamis: Nama di atas, Jabatan di bawah) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-center">
            @foreach(($halaman['struktur_bidang'] ?? []) as $idx => $bidang)
            @php
                $namaBidang = $bidang['nama'] ?? ($bidang['jabatan'] ?? 'Koordinator');
                $jabatanBidang = $bidang['jabatan'] ?? ($bidang['peran'] ?? '');

                // Bersihkan inisial dari nama
                $inisial = $cleanName($namaBidang);
                $warna = ['bg-emerald-500','bg-orange-500','bg-rose-500','bg-purple-500','bg-sky-500','bg-teal-500'][$idx % 6];
            @endphp
            <div class="bg-white border-2 border-slate-200 rounded-3xl p-7 text-center hover:border-secondary hover:shadow-xl transition-all flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-full {{ $warna }} text-white font-black text-xl flex items-center justify-center mx-auto shadow-sm tracking-wider">{{ $inisial }}</div>
                    <p class="font-black text-lg mt-4 text-slate-900 leading-tight">{{ $namaBidang }}</p>
                </div>
                @if(!empty($jabatanBidang))
                    <p class="text-sm text-slate-600 leading-relaxed mt-2.5 pt-2 border-t border-slate-100 font-medium">{{ $jabatanBidang }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </section>

    <!-- 5. TUGAS & FUNGSI (list dua kolom dengan ikon sebaris, bukan grid 6 pilar gelap) -->
    <section class="bg-slate-50 border-y border-slate-100 py-14">
        <div class="max-w-6xl mx-auto px-4 sm:px-8 lg:px-12">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-8">
                <div class="space-y-2">
                    <p class="text-xs font-extrabold uppercase tracking-widest text-primary">Peran & tanggung jawab</p>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Tugas & Fungsi</h2>
                    <div class="h-1 w-12 bg-primary rounded-full"></div>
                </div>
                <p class="text-xs text-slate-400 max-w-xs sm:text-right">Enam mandat utama PPID menurut UU KIP dan peraturan pelaksana.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-0">
                <div class="flex gap-4 py-4 border-b border-slate-200">
                    <span class="text-sm font-black text-secondary shrink-0 pt-0.5">01</span>
                    <div><h4 class="font-bold text-slate-900 text-sm">Penyediaan Informasi</h4><p class="text-xs text-slate-500 mt-1 leading-relaxed">Menyediakan, menyimpan, dan mendokumentasikan informasi badan publik secara tertib.</p></div>
                </div>
                <div class="flex gap-4 py-4 border-b border-slate-200">
                    <span class="text-sm font-black text-secondary shrink-0 pt-0.5">02</span>
                    <div><h4 class="font-bold text-slate-900 text-sm">Pelayanan Permohonan</h4><p class="text-xs text-slate-500 mt-1 leading-relaxed">Menerima dan menindaklanjuti permohonan sesuai SOP dan batas waktu.</p></div>
                </div>
                <div class="flex gap-4 py-4 border-b border-slate-200">
                    <span class="text-sm font-black text-secondary shrink-0 pt-0.5">03</span>
                    <div><h4 class="font-bold text-slate-900 text-sm">Pengelolaan Keberatan</h4><p class="text-xs text-slate-500 mt-1 leading-relaxed">Memproses keberatan atas layanan secara adil dan terbuka.</p></div>
                </div>
                <div class="flex gap-4 py-4 border-b border-slate-200">
                    <span class="text-sm font-black text-secondary shrink-0 pt-0.5">04</span>
                    <div><h4 class="font-bold text-slate-900 text-sm">Pengujian Konsekuensi</h4><p class="text-xs text-slate-500 mt-1 leading-relaxed">Menguji akibat dibuka/ditutupnya informasi menurut peraturan.</p></div>
                </div>
                <div class="flex gap-4 py-4 border-b border-slate-200 md:border-b-0">
                    <span class="text-sm font-black text-secondary shrink-0 pt-0.5">05</span>
                    <div><h4 class="font-bold text-slate-900 text-sm">Publikasi Berkala</h4><p class="text-xs text-slate-500 mt-1 leading-relaxed">Mengumumkan informasi via portal resmi dan kanal digital.</p></div>
                </div>
                <div class="flex gap-4 py-4">
                    <span class="text-sm font-black text-secondary shrink-0 pt-0.5">06</span>
                    <div><h4 class="font-bold text-slate-900 text-sm">Pelaporan Kinerja</h4><p class="text-xs text-slate-500 mt-1 leading-relaxed">Laporan layanan ke atasan dan Komisi Informasi periodik.</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. MAKLUMAT + STANDAR (quote terang + tabel ringkas) -->
    <section class="max-w-6xl mx-auto px-4 sm:px-8 lg:px-12 py-14">
        <div class="space-y-2 mb-8">
            <p class="text-xs font-extrabold uppercase tracking-widest text-primary">Standar pelayanan</p>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Maklumat Pelayanan</h2>
            <div class="h-1 w-12 bg-primary rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-5 bg-[#E0F2FE] border border-secondary/30 rounded-2xl p-6 sm:p-7 space-y-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-9 h-9 rounded-xl bg-white border border-secondary/30 text-primary flex items-center justify-center"><i class="mdi mdi-certificate-outline text-sm"></i></span>
                    <h4 class="font-extrabold text-slate-900 text-sm">Janji layanan kami</h4>
                </div>
                <p class="text-sm text-slate-600 italic leading-relaxed">
                    "{{ $halaman['maklumat_quote'] ?? '' }}"
                </p>
                <div class="flex items-center gap-3 pt-3 border-t border-secondary/30/70">
                    <div class="w-9 h-9 rounded-full bg-primary text-white font-bold flex items-center justify-center text-sm">
                        {{ substr($profil['nama'] ?? 'A', 0, 1) }}
                    </div>
                    <div class="leading-tight">
                        <span class="block text-sm font-bold text-slate-900">{{ $profil['nama'] ?? 'Dekan FMIPA' }}</span>
                        <span class="block text-xs text-slate-500">Atasan PPID FMIPA Unila</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 bg-white border border-slate-200 rounded-2xl overflow-hidden">
                <div class="px-5 py-3.5 bg-slate-50 border-b border-slate-100 flex items-center gap-2">
                    <i class="mdi mdi-clipboard-outline text-primary"></i>
                    <h3 class="font-extrabold text-slate-900 text-sm">Ringkasan standar</h3>
                </div>
                <dl class="divide-y divide-slate-100 text-xs sm:text-sm">
                    @foreach(($halaman['standar_pelayanan'] ?? []) as $row)
                    <div class="px-5 py-2.5 flex flex-col sm:flex-row sm:gap-4"><dt class="sm:w-44 shrink-0 font-bold text-slate-500 text-[11px] uppercase tracking-wide pt-0.5">{{ $row['label'] }}</dt><dd class="text-slate-700">{{ $row['isi'] }}</dd></div>
                    @endforeach
                </dl>
            </div>
        </div>
    </section>

    <!-- 7. CTA TERANG (bukan banner navy) -->
    <section class="max-w-6xl mx-auto px-4 sm:px-8 lg:px-12">
        <div class="bg-gradient-to-r from-primary to-primary-light rounded-3xl px-6 sm:px-10 py-10 text-center text-white shadow-sm space-y-4 relative overflow-hidden">
            <div class="absolute -top-10 -left-10 w-48 h-48 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-12 -right-8 w-56 h-56 rounded-full bg-white/10"></div>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight relative">Butuh Informasi Publik?</h2>
            <p class="text-slate-200 text-xs sm:text-sm max-w-xl mx-auto relative">Ajukan permohonan sekarang atau hubungi kami lewat kanal resmi.</p>
            <div class="flex flex-wrap items-center justify-center gap-3 relative">
                <a href="{{ route('layanan.permohonan') }}" class="px-6 py-3 rounded-xl bg-white text-primary font-extrabold text-sm hover:bg-secondary-light transition inline-flex items-center gap-2">
                    <i class="mdi mdi-send-outline text-xs"></i> Ajukan Permohonan
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil['whatsapp'] ?? '6281320178069') }}" target="_blank" class="px-6 py-3 rounded-xl bg-primary-light/60 border border-white/30 text-white font-extrabold text-sm hover:bg-primary-light transition inline-flex items-center gap-2">
                    <i class="mdi mdi-whatsapp"></i> Hubungi PPID
                </a>
            </div>
        </div>
    </section>

</main>
@endsection
