@extends('components.layouts.app')

@section('title', 'Tata Cara Permohonan dan Keberatan - PPID FMIPA Universitas Lampung')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-50 min-h-screen pb-20">

    <!-- Header Hero Banner (fix — tidak diedit dari admin) -->
    <section class="bg-gradient-to-r from-sky-600 via-sky-500 to-blue-700 text-white py-12 md:py-16 relative overflow-hidden shadow-md">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-80 h-80 rounded-full bg-sky-400/20 blur-2xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">Tata Cara Permohonan dan Keberatan</h1>
            <p class="w-full max-w-none text-sky-100 text-sm sm:text-base font-normal leading-relaxed">Panduan komprehensif mengenai prosedur resmi pengajuan permohonan informasi publik, jangka waktu pemenuhan (SLA), mekanisme penyampaian keberatan, hingga penyelesaian sengketa informasi publik di lingkungan FMIPA Universitas Lampung.</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 space-y-12">

        <!-- Grid 2 Kartu Prosedur Utama: Permohonan & Keberatan -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- KARTU 1: TATA CARA PERMOHONAN INFORMASI -->
            <div class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Tata Cara Permohonan Informasi</h2>
                    <p class="text-sm text-slate-600 font-medium leading-relaxed">Masyarakat dan badan hukum dapat mengajukan permohonan informasi publik dengan langkah-langkah berikut:</p>
                    <div class="space-y-4 pt-2">
                        @foreach(($tataCara['permohonan_langkah'] ?? []) as $idx => $step)
                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-lg bg-blue-600 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-blue-600/30">{{ $idx + 1 }}</span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">{{ $step['judul'] }}</h4>
                                <p class="text-sm text-slate-600 font-medium leading-relaxed">{{ $step['deskripsi'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-3">
                    <a href="{{ route('layanan.permohonan') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-bold rounded-xl transition shadow-sm hover:shadow inline-flex items-center gap-2">
                        <i class="fa-solid fa-envelope-open-text text-xs"></i><span>Buat Permohonan Informasi</span>
                    </a>
                </div>
            </div>

            <!-- KARTU 2: TATA CARA PENGAJUAN KEBERATAN -->
            <div id="keberatan" class="bg-white border border-slate-200/90 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between space-y-6 scroll-mt-24">
                <div class="space-y-4">
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Tata Cara Pengajuan Keberatan</h2>
                    <p class="text-sm text-slate-600 font-medium leading-relaxed">Pemohon informasi publik berhak mengajukan keberatan resmi apabila menemui hambatan atau tidak puas atas tanggapan PPID:</p>
                    <div class="space-y-4 pt-2">
                        @foreach(($tataCara['keberatan_langkah'] ?? []) as $idx => $step)
                        <div class="flex items-start gap-3.5">
                            <span class="w-8 h-8 rounded-lg bg-amber-500 text-white font-black flex items-center justify-center text-xs shrink-0 shadow-sm shadow-amber-500/30">{{ $idx + 1 }}</span>
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">{{ $step['judul'] }}</h4>
                                <p class="text-sm text-slate-600 font-medium leading-relaxed">{{ $step['deskripsi'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pt-6 border-t border-slate-100 flex flex-wrap items-center gap-3">
                    <a href="{{ route('layanan.keberatan') }}" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs md:text-sm font-bold rounded-xl transition shadow-sm hover:shadow inline-flex items-center gap-2">
                        <i class="fa-solid fa-gavel text-xs"></i><span>Ajukan Keberatan</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</main>
@endsection
