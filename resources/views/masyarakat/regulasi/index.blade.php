@extends('components.layouts.app')

@section('title', 'Regulasi Keterbukaan Informasi Publik - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-50 min-h-screen pb-20">

    <!-- Header Hero Banner Regulasi -->
    <section class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 text-white py-12 md:py-16 relative overflow-hidden shadow-md">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full bg-sky-400/20 blur-2xl pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-bold text-sky-100">
                <i class="fa-solid fa-scale-balanced"></i>
                <span>Landasan Hukum & Kebijakan</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                Regulasi Keterbukaan Informasi Publik
            </h1>
            
            <p class="text-sky-100 text-sm sm:text-base font-normal leading-relaxed max-w-3xl">
                Daftar peraturan perundang-undangan Republik Indonesia dan peraturan internal Universitas Lampung yang menjadi dasar hukum penyelenggaraan layanan keterbukaan informasi publik di PPID Pelaksana FMIPA.
            </p>
        </div>
    </section>

    <!-- Konten Utama Regulasi -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 space-y-10">

        <!-- Kategori 1: Peraturan Perundang-undangan Nasional -->
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-landmark"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Peraturan Perundang-undangan Nasional
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Hukum positif dan ketentuan pelaksanaan KIP tingkat nasional</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- UU No 14/2008 -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 text-[11px] font-bold border border-sky-100">
                                Undang-Undang
                            </span>
                            <span class="text-xs font-semibold text-slate-400">Tahun 2008</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-sky-600 transition">
                            Undang-Undang No. 14 Tahun 2008
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Tentang Keterbukaan Informasi Publik (UU KIP) — Payung hukum utama yang menjamin hak warga negara untuk memperoleh informasi publik.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">Dokumen JDIH BPK</span>
                        <a href="https://peraturan.bpk.go.id/Details/39047/uu-no-14-tahun-2008" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka Peraturan</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- PP No 61/2010 -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">
                                Peraturan Pemerintah
                            </span>
                            <span class="text-xs font-semibold text-slate-400">Tahun 2010</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-sky-600 transition">
                            Peraturan Pemerintah No. 61 Tahun 2010
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Tentang Pelaksanaan Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">Dokumen JDIH BPK</span>
                        <a href="https://peraturan.bpk.go.id/Details/5048/pp-no-61-tahun-2010" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka Peraturan</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Perki No 1/2021 -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold border border-emerald-100">
                                Peraturan Komisi Informasi
                            </span>
                            <span class="text-xs font-semibold text-slate-400">Tahun 2021</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-sky-600 transition">
                            Perki No. 1 Tahun 2021
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Tentang Standar Layanan Informasi Publik (SLIP) — Mengatur klasifikasi, tata kelola, dan prosedur teknis layanan informasi oleh Badan Publik.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">Komisi Informasi Pusat</span>
                        <a href="https://ppid.unila.ac.id/peraturan-tentang-keterbukaan-informasi-publik/" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka Peraturan</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Kumpulan Regulasi KIP -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 text-[11px] font-bold border border-purple-100">
                                Kompilasi Regulasi
                            </span>
                            <span class="text-xs font-semibold text-slate-400">Kumpulan</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-sky-600 transition">
                            Peraturan tentang Keterbukaan Informasi Publik
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Kompilasi peraturan terkait keterbukaan informasi publik yang dihimpun dan dipublikasikan pada portal PPID Universitas Lampung.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">PPID Universitas Lampung</span>
                        <a href="https://ppid.unila.ac.id/peraturan-tentang-keterbukaan-informasi-publik/" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka Kumpulan</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori 2: Regulasi Internal Universitas Lampung -->
        <div class="space-y-4 pt-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-black">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Regulasi Internal Universitas Lampung
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">Peraturan Rektor dan Surat Keputusan penetapan PPID di lingkungan Unila</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Peraturan Rektor -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[11px] font-bold border border-amber-100">
                                Peraturan Rektor
                            </span>
                            <span class="text-xs font-semibold text-slate-400">Universitas Lampung</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-amber-600 transition">
                            Peraturan Rektor tentang Keterbukaan Informasi Publik
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Ketentuan dan pedoman pelaksanaan keterbukaan informasi publik serta tata kelola dokumen di lingkungan Universitas Lampung.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">PPID Universitas Lampung</span>
                        <a href="https://ppid.unila.ac.id/peraturan-rektor-tentang-keterbukaan-informasi-publik/" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka Peraturan Rektor</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- SK PPID Unila -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[11px] font-bold border border-rose-100">
                                Keputusan Rektor (SK)
                            </span>
                            <span class="text-xs font-semibold text-slate-400">Universitas Lampung</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-rose-600 transition">
                            SK PPID Universitas Lampung
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Surat Keputusan Rektor Universitas Lampung tentang Penetapan Pejabat Pengelola Informasi dan Dokumentasi (PPID) Utama dan PPID Pelaksana.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">PPID Universitas Lampung</span>
                        <a href="https://ppid.unila.ac.id/sk-ppid/" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka SK Penetapan</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Indeks Regulasi Lengkap Unila -->
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-3 flex flex-col justify-between group md:col-span-2">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-bold border border-slate-200">
                                Indeks Lengkap
                            </span>
                            <span class="text-xs font-semibold text-slate-400">Portal Utama</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-sky-600 transition">
                            Indeks Lengkap Regulasi PPID Universitas Lampung
                        </h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">
                            Akses katalog menyeluruh regulasi, SOP, maklumat pelayanan, dan pedoman tata kelola KIP di tingkat Universitas Lampung.
                        </p>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400 font-medium">ppid.unila.ac.id/regulasi/</span>
                        <a href="https://ppid.unila.ac.id/regulasi/" target="_blank" rel="noopener noreferrer" class="font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5">
                            <span>Buka Portal Regulasi Unila</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>
@endsection
