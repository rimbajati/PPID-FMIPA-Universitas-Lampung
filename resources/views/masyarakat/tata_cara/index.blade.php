@extends('components.layouts.app')

@section('title', 'Tata Cara Permohonan dan Keberatan - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-50 min-h-screen pb-20">

    <!-- Header Hero Banner -->
    <section class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 text-white py-12 md:py-16 relative overflow-hidden shadow-md">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full bg-sky-400/20 blur-2xl pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-bold text-sky-100">
                <i class="fa-solid fa-route"></i>
                <span>Standar Prosedur Layanan</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                Tata Cara Permohonan dan Keberatan
            </h1>
            
            <p class="text-sky-100 text-sm sm:text-base font-normal leading-relaxed max-w-3xl">
                Panduan komprehensif mengenai prosedur resmi pengajuan permohonan informasi publik, jangka waktu pemenuhan (SLA), mekanisme penyampaian keberatan, hingga penyelesaian sengketa informasi publik di lingkungan FMIPA Universitas Lampung.
            </p>

            <div class="flex flex-wrap items-center gap-3 pt-2 text-xs sm:text-sm text-sky-100">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 border border-white/15">
                    <i class="fa-regular fa-clock text-sky-300"></i>
                    <span>SLA: 10 + 7 Hari Kerja</span>
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 border border-white/15">
                    <i class="fa-solid fa-coins text-sky-300"></i>
                    <span>Layanan Tidak Dipungut Biaya</span>
                </span>
            </div>
        </div>
    </section>

    <!-- Konten Utama -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 space-y-12">

        <!-- Grid 2 Kartu Prosedur Utama: Permohonan & Keberatan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- KARTU 1: TATA CARA PERMOHONAN INFORMASI -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-black border border-sky-100">
                            <i class="fa-solid fa-file-signature text-sky-600"></i>
                            <span>Langkah Permohonan</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">10 Hari Kerja</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Tata Cara Permohonan Informasi
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                        Masyarakat dan badan hukum dapat mengajukan permohonan informasi publik dengan langkah-langkah berikut:
                    </p>

                    <!-- Steps Timeline Permohonan -->
                    <div class="space-y-4 pt-2">
                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-xl bg-sky-600 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-sky-600/30">
                                1
                            </span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">Pengisian Formulir Permohonan</h4>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    Isi formulir permohonan secara online melalui portal PPID FMIPA atau datang langsung ke meja layanan PPID dengan melampirkan salinan identitas resmi (KTP / Paspor / Akta Pendirian bagi Badan Hukum) serta rincian informasi yang dibutuhkan.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-xl bg-sky-600 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-sky-600/30">
                                2
                            </span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">Registrasi & Penerimaan Nomor Tiket</h4>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    Petugas PPID memeriksa kelengkapan berkas pemohon, mencatat permohonan ke dalam buku register, dan memberikan nomor registrasi/nomor tiket unik untuk pelacakan.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-xl bg-sky-600 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-sky-600/30">
                                3
                            </span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">Pemrosesan & Jawaban Resmi (10 + 7 Hari)</h4>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    PPID memberikan tanggapan resmi paling lambat <strong>10 hari kerja</strong> sejak permohonan dinyatakan lengkap, dan dapat diperpanjang maksimal <strong>7 hari kerja</strong> dengan pemberitahuan tertulis sebelumnya kepada pemohon.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-xl bg-sky-600 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-sky-600/30">
                                4
                            </span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">Penyerahan Dokumen Informasi</h4>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    Informasi diberikan sesuai bentuk atau format yang diminta pemohon (salinan digital atau cetak). Layanan informasi tidak dipungut biaya; biaya penggandaan/pengiriman (bila ada) dibebankan kepada pemohon sesuai standar biaya yang berlaku.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-3">
                    <a href="{{ route('layanan.permohonan') }}" class="px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white text-xs sm:text-sm font-bold rounded-2xl transition shadow-sm hover:shadow inline-flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle text-xs"></i>
                        <span>Isi Formulir Permohonan</span>
                    </a>
                    <a href="{{ route('layanan.riwayat') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs sm:text-sm font-bold rounded-2xl transition inline-flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                        <span>Lacak Tiket Layanan</span>
                    </a>
                </div>
            </div>

            <!-- KARTU 2: TATA CARA PENGAJUAN KEBERATAN -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-black border border-amber-100">
                            <i class="fa-solid fa-scale-balanced text-amber-600"></i>
                            <span>Mekanisme Keberatan</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">30 Hari Kerja</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Tata Cara Pengajuan Keberatan
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                        Pemohon informasi publik berhak mengajukan keberatan resmi apabila menemui hambatan atau tidak puas atas tanggapan PPID:
                    </p>

                    <!-- Steps Timeline Keberatan -->
                    <div class="space-y-4 pt-2">
                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-xl bg-amber-500 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-amber-500/30">
                                1
                            </span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">Pengajuan Keberatan oleh Pemohon</h4>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    Keberatan diajukan secara tertulis (online melalui portal atau langsung) paling lambat <strong>30 hari kerja</strong> setelah diterimanya tanggapan atau setelah terlewatinya batas waktu pemberian jawaban oleh PPID.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-xl bg-amber-500 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-amber-500/30">
                                2
                            </span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">Pemberian Alasan Keberatan yang Sah</h4>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    Keberatan dapat didasari alasan: penolakan atas permohonan, informasi berkala tidak disediakan, permohonan tidak ditanggapi, permintaan tidak dipenuhi sebagaimana mestinya, pengenaan biaya yang tidak wajar, atau penyampaian informasi melebihi batas waktu.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-xl bg-amber-500 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-amber-500/30">
                                3
                            </span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">Tanggapan oleh Atasan PPID (30 Hari)</h4>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    Atasan PPID (Rektor Universitas Lampung) memberikan tanggapan tertulis atas keberatan paling lambat <strong>30 hari kerja</strong> sejak permohonan keberatan diterima secara lengkap.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-xl bg-amber-500 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-amber-500/30">
                                4
                            </span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">Penyelesaian Sengketa Informasi (14 Hari)</h4>
                                <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                    Apabila pemohon tidak puas dengan keputusan tanggapan keberatan dari Atasan PPID, pemohon dapat mengajukan permohonan penyelesaian Sengketa Informasi Publik ke <strong>Komisi Informasi</strong> paling lambat <strong>14 hari kerja</strong> sejak diterimanya tanggapan tertulis.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-3">
                    <a href="{{ route('layanan.keberatan') }}" class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white text-xs sm:text-sm font-bold rounded-2xl transition shadow-sm hover:shadow inline-flex items-center gap-2">
                        <i class="fa-solid fa-scale-balanced text-xs"></i>
                        <span>Formulir Pengajuan Keberatan</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Section: Waktu Layanan & Biaya -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 sm:p-7 rounded-3xl bg-white border border-slate-200/90 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center text-lg">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">Jangka Waktu Pelayanan (SLA)</h3>
                <ul class="space-y-2 text-xs sm:text-sm text-slate-600 font-medium">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-sky-600 text-xs mt-1"></i>
                        <span><strong>Jawaban Permohonan:</strong> Maksimal 10 hari kerja (dapat diperpanjang 7 hari kerja dengan pemberitahuan tertulis).</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-sky-600 text-xs mt-1"></i>
                        <span><strong>Tanggapan Keberatan:</strong> Maksimal 30 hari kerja sejak keberatan diterima Atasan PPID.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-sky-600 text-xs mt-1"></i>
                        <span><strong>Jam Operasional:</strong> Senin–Kamis 08.00–16.00 WIB · Jumat 08.00–16.30 WIB (Istirahat 12.00–13.00 WIB).</span>
                    </li>
                </ul>
            </div>

            <div class="p-6 sm:p-7 rounded-3xl bg-white border border-slate-200/90 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">Standar Biaya Pelayanan</h3>
                <ul class="space-y-2 text-xs sm:text-sm text-slate-600 font-medium">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-600 text-xs mt-1"></i>
                        <span><strong>Gratis (Tidak Dipungut Biaya):</strong> Layanan pencarian data, konsultasi, dan pengiriman informasi format digital via email / portal PPID.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-600 text-xs mt-1"></i>
                        <span><strong>Biaya Penggandaan / Ekspedisi:</strong> Bila pemohon meminta salinan fisik/cetak atau kurir pos, biaya dibebankan kepada pemohon sesuai standar biaya yang ditetapkan.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-check text-emerald-600 text-xs mt-1"></i>
                        <span><a href="https://ppid.unila.ac.id/standar-biaya-pelayanan-informasi-publik/" target="_blank" class="text-sky-600 hover:underline font-bold">Pelajari Standar Biaya Layanan Informasi Unila &rarr;</a></span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Section: SOP & Formulir Layanan (Tautan Dokumen Resmi Sesuai monev-ppid) -->
        <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-black border border-slate-200 mb-2">
                        <i class="fa-solid fa-file-pdf text-sky-600"></i>
                        <span>Dokumen Standar</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900">
                        SOP & Dokumen Standar Pelayanan Informasi
                    </h3>
                </div>
                <a href="https://ppid.unila.ac.id/formulir-layanan-informasi/" target="_blank" class="text-xs sm:text-sm font-bold text-sky-600 hover:text-sky-700 inline-flex items-center gap-1.5 self-start sm:self-auto">
                    <span>Indeks Formulir Lengkap</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="https://ppid.unila.ac.id/sop-layanan-informasi/" target="_blank" class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 hover:bg-sky-50/60 hover:border-sky-200 transition group flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-sky-600 flex items-center justify-center shrink-0 group-hover:bg-sky-600 group-hover:text-white transition">
                        <i class="fa-solid fa-file-contract text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h5 class="text-xs sm:text-sm font-extrabold text-slate-900 group-hover:text-sky-700 transition">POS AP Layanan Informasi (SOP)</h5>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Standar Operasional Prosedur Layanan</p>
                    </div>
                </a>

                <a href="https://ppid.unila.ac.id/standar-pelayanan-informasi-publik/" target="_blank" class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 hover:bg-sky-50/60 hover:border-sky-200 transition group flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-sky-600 flex items-center justify-center shrink-0 group-hover:bg-sky-600 group-hover:text-white transition">
                        <i class="fa-solid fa-clipboard-check text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h5 class="text-xs sm:text-sm font-extrabold text-slate-900 group-hover:text-sky-700 transition">Standar Pelayanan Informasi Publik</h5>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Ketentuan umum dan hak pemohon</p>
                    </div>
                </a>

                <a href="https://ppid.unila.ac.id/maklumat-pelayanan/" target="_blank" class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 hover:bg-sky-50/60 hover:border-sky-200 transition group flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-sky-600 flex items-center justify-center shrink-0 group-hover:bg-sky-600 group-hover:text-white transition">
                        <i class="fa-solid fa-scroll text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h5 class="text-xs sm:text-sm font-extrabold text-slate-900 group-hover:text-sky-700 transition">Maklumat Pelayanan</h5>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Komitmen pelayanan informasi KIP</p>
                    </div>
                </a>

                <a href="https://ppid.unila.ac.id/formulir-permohonan-informasi-publik/" target="_blank" class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 hover:bg-sky-50/60 hover:border-sky-200 transition group flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-sky-600 flex items-center justify-center shrink-0 group-hover:bg-sky-600 group-hover:text-white transition">
                        <i class="fa-solid fa-file-pen text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h5 class="text-xs sm:text-sm font-extrabold text-slate-900 group-hover:text-sky-700 transition">Formulir Permohonan Informasi</h5>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Lampiran VI Perki 1/2021</p>
                    </div>
                </a>

                <a href="https://ppid.unila.ac.id/formulir-keberatan-jawaban-informasi-publik/" target="_blank" class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 hover:bg-sky-50/60 hover:border-sky-200 transition group flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-sky-600 flex items-center justify-center shrink-0 group-hover:bg-sky-600 group-hover:text-white transition">
                        <i class="fa-solid fa-file-shield text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h5 class="text-xs sm:text-sm font-extrabold text-slate-900 group-hover:text-sky-700 transition">Formulir Keberatan Jawaban</h5>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Lampiran X Perki 1/2021</p>
                    </div>
                </a>

                <a href="https://ppid.unila.ac.id/formulir-keluhan-informasi-publik/" target="_blank" class="p-4 rounded-2xl border border-slate-200/80 bg-slate-50 hover:bg-sky-50/60 hover:border-sky-200 transition group flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 text-sky-600 flex items-center justify-center shrink-0 group-hover:bg-sky-600 group-hover:text-white transition">
                        <i class="fa-solid fa-message-exclamation text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <h5 class="text-xs sm:text-sm font-extrabold text-slate-900 group-hover:text-sky-700 transition">Formulir Keluhan Informasi</h5>
                        <p class="text-[11px] text-slate-500 font-medium mt-0.5">Formulir aspirasi & pengaduan publik</p>
                    </div>
                </a>
            </div>
        </div>

    </div>

</main>
@endsection
