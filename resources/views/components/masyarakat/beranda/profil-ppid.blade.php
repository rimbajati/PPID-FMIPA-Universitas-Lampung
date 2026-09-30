@props(['profil' => []])

@php
    $nama           = $profil['nama'] ?? 'Aristoeteles';
    $jabatan        = $profil['jabatan'] ?? 'Kasubag TU / PIC PPID Pelaksana';
    $foto           = $profil['foto'] ?? null;
    $tugasFungsi    = $profil['tugas_fungsi'] ?? 'Mengelola, menyediakan, dan melayani informasi publik di lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam; menyusun Daftar Informasi Publik unit; melayani permohonan dan keberatan; serta melaporkan layanan kepada PPID Utama Universitas Lampung.';
    $initial        = strtoupper(substr($nama ?: 'A', 0, 1));
    $hasFoto        = $foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($foto);
@endphp

<!-- Profil PPID Pelaksana -->
<section id="profil-ppid" class="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 pt-14 sm:pt-20 mb-16 sm:mb-20 relative z-20 scroll-mt-24 sm:scroll-mt-28">

    <!-- HEADER SECTION -->
    <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-10 space-y-2.5">
        <!-- <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-black border border-sky-200 shadow-2xs">
            <i class="fa-solid fa-id-card text-sky-500"></i>
            <span>Struktur Pelaksana</span>
        </div> -->

        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight leading-tight">
            Profil <span class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 bg-clip-text text-transparent">PPID Pelaksana</span>
        </h2>

        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
            Dasar penetapan mengikuti SK Rektor Universitas Lampung tentang PPID (lihat <a href="{{ url('/regulasi') }}" class="text-sky-600 hover:text-sky-700 font-bold hover:underline">Regulasi</a>).
        </p>
    </div>

    <!-- Card Profil: Foto Besar Kiri + Konten Kanan -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">

        <!-- Ambient Glows -->
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col sm:flex-row">

            {{-- ========== KOLOM FOTO (KIRI) ========== --}}
            <div class="sm:w-72 md:w-80 lg:w-96 shrink-0 border-b sm:border-b-0 sm:border-r border-slate-200/80 bg-slate-900/5 relative overflow-hidden flex items-center justify-center p-3 sm:p-5">
                @if($hasFoto)
                    {{-- Blurred Ambient Background dari foto agar area kosong terlihat menyatu & elegan --}}
                    <div class="absolute inset-0 bg-cover bg-center blur-2xl opacity-25 scale-125 select-none pointer-events-none"
                         style="background-image: url('{{ asset('storage/' . $foto) }}');"></div>

                    {{-- Container foto: fleksibel, ukuran pas, foto utuh 100% (tidak terpotong), tajam & HD --}}
                    <div class="relative z-10 w-full flex items-center justify-center">
                        <img src="{{ asset('storage/' . $foto) }}"
                             alt="Foto {{ $nama }}"
                             class="w-auto h-auto max-w-full max-h-[300px] sm:max-h-[360px] object-contain rounded-2xl shadow-lg ring-1 ring-black/5"
                             loading="eager">
                    </div>
                @else
                    {{-- Avatar Placeholder saat belum ada foto --}}
                    <div class="flex flex-col items-center justify-center gap-4 py-16 px-8 w-full h-full min-h-[260px] bg-gradient-to-br from-slate-50 to-sky-50/50">
                        <div class="w-28 h-28 rounded-3xl bg-gradient-to-tr from-sky-500 to-blue-700 text-white font-black text-5xl flex items-center justify-center shadow-xl shadow-sky-600/30">
                            {{ $initial }}
                        </div>
                    </div>
                @endif
            </div>

            {{-- ========== KOLOM KONTEN (KANAN) ========== --}}
            <div class="flex-1 min-w-0 p-6 sm:p-8 lg:p-10 space-y-6 flex flex-col justify-center">

                {{-- Nama & Jabatan --}}
                <div>
                    <h3 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 leading-tight">
                        {{ $nama }}
                    </h3>

                    <p class="text-sm sm:text-base text-sky-700 font-bold mt-1.5">
                        {{ $jabatan }}
                    </p>
                </div>

                {{-- Divider --}}
                <div class="w-12 h-1 rounded-full bg-gradient-to-r from-sky-500 to-blue-600"></div>

                {{-- Tugas dan Fungsi --}}
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-sky-500 text-xs"></i>
                        <span class="text-md font-semibold text-slate-500">Tugas dan Fungsi</span>
                    </div>
                    <p class="text-sm sm:text-base text-slate-700 font-medium leading-relaxed whitespace-pre-line">
                        {{ $tugasFungsi }}
                    </p>
                </div>

            </div>
        </div>
    </div>

</section>
