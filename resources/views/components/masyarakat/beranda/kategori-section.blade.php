@props([
    'kategoriCount' => [
        'setiap_saat' => 0,
        'berkala' => 0,
        'serta_merta' => 0,
        'dikecualikan' => 0,
    ]
])

<!-- Kategori Informasi Publik Section (Harmonis dengan Tema PPID FMIPA Unila) -->
<section id="kategori-informasi" class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 pt-16 sm:pt-20 mb-24 relative z-20">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-700 text-xs font-black border border-sky-200/80 shadow-2xs">
            <i class="fa-solid fa-layer-group text-sky-500"></i>
            <span>Klasifikasi UU KIP No. 14/2008</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
            Kategori <span class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 bg-clip-text text-transparent">Informasi Publik</span>
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
            Akses seluruh dokumen informasi publik FMIPA Universitas Lampung yang telah diklasifikasikan secara transparan, akuntabel, dan sesuai regulasi perundangan.
        </p>
    </div>

    <!-- Grid 4 Kategori (Responsive: 1 col di mobile, 2 col di tablet, 4 col di desktop) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- 1. Informasi Berkala (Navy Blue khas Referensi) -->
        <div class="bg-gradient-to-br from-[#1e3a5f] to-[#0f233a] p-6 sm:p-7 rounded-3xl shadow-lg shadow-slate-900/15 hover:shadow-2xl hover:shadow-slate-900/25 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group relative overflow-hidden text-white border border-sky-400/20">
            <div class="space-y-4 relative z-10">
                <!-- Icon Besar di Tengah (Tanpa Kotak Pembungkus, Bersih Sesuai Referensi) -->
                <div class="flex justify-center pt-2">
                    <div class="text-5xl sm:text-6xl text-white group-hover:scale-110 transition-transform duration-300 drop-shadow-md">
                        <i class="fa-regular fa-calendar-days"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-xl font-black text-white tracking-tight">Informasi Berkala</h3>
                    <p class="text-xs text-white/80 leading-relaxed font-medium mt-2">
                        Informasi yang wajib disediakan dan disampaikan secara rutin oleh badan publik.
                    </p>
                </div>

                <!-- Daftar Checklist Dokumen Khas Referensi -->
                <div class="space-y-2.5 pt-2 border-t border-white/10 text-xs font-semibold text-white/90">
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-sky-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Laporan Keuangan</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-sky-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">LKjIP</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-sky-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Rencana Strategis</span>
                    </div>
                    <div class="text-[11px] italic text-white/60 pl-7">
                        + informasi lainnya
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Khas Referensi -->
            <div class="pt-5 mt-5 border-t border-white/15 relative z-10">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Berkala') }}" class="w-full py-2.5 px-4 rounded-xl bg-white/15 hover:bg-white text-white hover:text-[#1e3a5f] text-xs font-black transition-all flex items-center justify-center gap-2 border border-white/25 shadow-xs group-hover:border-white">
                    <span>Lihat Informasi</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        <!-- 2. Informasi Serta-Merta (Crimson / Vibrant Red-Pink khas Referensi) -->
        <div class="bg-gradient-to-br from-[#e1144b] to-[#be0f3d] p-6 sm:p-7 rounded-3xl shadow-lg shadow-rose-600/20 hover:shadow-2xl hover:shadow-rose-600/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group relative overflow-hidden text-white border border-rose-300/20">
            <div class="space-y-4 relative z-10">
                <!-- Icon Besar di Tengah (Tanpa Kotak Pembungkus, Bersih Sesuai Referensi) -->
                <div class="flex justify-center pt-2">
                    <div class="text-5xl sm:text-6xl text-white group-hover:scale-110 transition-transform duration-300 drop-shadow-md">
                        <i class="fa-regular fa-bell"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-xl font-black text-white tracking-tight">Informasi Serta-Merta</h3>
                    <p class="text-xs text-white/80 leading-relaxed font-medium mt-2">
                        Informasi yang dapat mengancam hajat hidup orang banyak dan harus disampaikan langsung.
                    </p>
                </div>

                <!-- Daftar Checklist Dokumen Khas Referensi -->
                <div class="space-y-2.5 pt-2 border-t border-white/10 text-xs font-semibold text-white/90">
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-rose-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Bencana Alam</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-rose-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Wabah Penyakit</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-rose-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Krisis Pangan & Darurat</span>
                    </div>
                    <div class="text-[11px] italic text-white/60 pl-7">
                        + informasi lainnya
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Khas Referensi -->
            <div class="pt-5 mt-5 border-t border-white/15 relative z-10">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Serta-Merta') }}" class="w-full py-2.5 px-4 rounded-xl bg-white/15 hover:bg-white text-white hover:text-[#e1144b] text-xs font-black transition-all flex items-center justify-center gap-2 border border-white/25 shadow-xs group-hover:border-white">
                    <span>Lihat Informasi</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        <!-- 3. Informasi Setiap Saat (Emerald / Pine Green khas Referensi) -->
        <div class="bg-gradient-to-br from-[#059669] to-[#047857] p-6 sm:p-7 rounded-3xl shadow-lg shadow-emerald-600/20 hover:shadow-2xl hover:shadow-emerald-600/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group relative overflow-hidden text-white border border-emerald-400/20">
            <div class="space-y-4 relative z-10">
                <!-- Icon Besar di Tengah (Tanpa Kotak Pembungkus, Bersih Sesuai Referensi) -->
                <div class="flex justify-center pt-2">
                    <div class="text-5xl sm:text-6xl text-white group-hover:scale-110 transition-transform duration-300 drop-shadow-md">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-xl font-black text-white tracking-tight">Informasi Setiap Saat</h3>
                    <p class="text-xs text-white/80 leading-relaxed font-medium mt-2">
                        Informasi yang wajib disediakan oleh badan publik dan tersedia setiap saat bagi pemohon.
                    </p>
                </div>

                <!-- Daftar Checklist Dokumen Khas Referensi -->
                <div class="space-y-2.5 pt-2 border-t border-white/10 text-xs font-semibold text-white/90">
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-emerald-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Daftar Pegawai & Dosen</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-emerald-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Data Aset & Sarana</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-emerald-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Profil Instansi FMIPA</span>
                    </div>
                    <div class="text-[11px] italic text-white/60 pl-7">
                        + informasi lainnya
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Khas Referensi -->
            <div class="pt-5 mt-5 border-t border-white/15 relative z-10">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Setiap+Saat') }}" class="w-full py-2.5 px-4 rounded-xl bg-white/15 hover:bg-white text-white hover:text-[#059669] text-xs font-black transition-all flex items-center justify-center gap-2 border border-white/25 shadow-xs group-hover:border-white">
                    <span>Lihat Informasi</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        <!-- 4. Informasi Dikecualikan (Slate / Charcoal Grey khas Referensi) -->
        <div class="bg-gradient-to-br from-[#475569] to-[#334155] p-6 sm:p-7 rounded-3xl shadow-lg shadow-slate-900/20 hover:shadow-2xl hover:shadow-slate-900/30 transition-all duration-300 hover:-translate-y-1.5 flex flex-col justify-between group relative overflow-hidden text-white border border-slate-400/20">
            <div class="space-y-4 relative z-10">
                <!-- Icon Besar di Tengah (Tanpa Kotak Pembungkus, Bersih Sesuai Referensi) -->
                <div class="flex justify-center pt-2">
                    <div class="text-5xl sm:text-6xl text-white group-hover:scale-110 transition-transform duration-300 drop-shadow-md">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>

                <div class="text-center">
                    <h3 class="text-xl font-black text-white tracking-tight">Informasi Dikecualikan</h3>
                    <p class="text-xs text-white/80 leading-relaxed font-medium mt-2">
                        Informasi yang dikecualikan dan dibatasi sesuai peraturan perundang-undangan (Pasal 17 KIP).
                    </p>
                </div>

                <!-- Daftar Checklist Dokumen Khas Referensi -->
                <div class="space-y-2.5 pt-2 border-t border-white/10 text-xs font-semibold text-white/90">
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-slate-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Data Pribadi</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-slate-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Rahasia Negara / Jabatan</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-center text-[10px] text-slate-200 shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </span>
                        <span class="truncate">Data Internal Terbatas</span>
                    </div>
                    <div class="text-[11px] italic text-white/60 pl-7">
                        + informasi lainnya
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Khas Referensi -->
            <div class="pt-5 mt-5 border-t border-white/15 relative z-10">
                <a href="{{ url('/informasi-publik?kategori=Informasi+Dikecualikan') }}" class="w-full py-2.5 px-4 rounded-xl bg-white/15 hover:bg-white text-white hover:text-[#475569] text-xs font-black transition-all flex items-center justify-center gap-2 border border-white/25 shadow-xs group-hover:border-white">
                    <span>Lihat Informasi</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

    </div>
</section>
