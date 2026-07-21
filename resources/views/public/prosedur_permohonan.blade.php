@extends('layout.utama')

@section('title', 'Prosedur Permohonan Informasi - PPID FMIPA Unila')

@section('content')
@php
    $prosedur = \App\Models\ProsedurPermohonan::getData();
@endphp

<!-- Hero Section -->
<div class="relative bg-[#1B365D] text-white pt-32 sm:pt-40 pb-16 sm:pb-24 overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#1B365D] via-[#1B365D]/90 to-[#1B365D]/70"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-8 md:px-16 lg:px-24">
        <!-- Breadcrumb -->
        <nav class="flex flex-wrap items-center gap-2 text-sm sm:text-base text-cyan-200 mb-6">
            <a href="/" class="hover:text-white transition-colors">Beranda</a>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span>Layanan Informasi</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-white font-bold">Prosedur Permohonan Informasi</span>
        </nav>

        <div class="max-w-4xl space-y-4">
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight leading-tight">
                {{ $prosedur['judul'] }}
            </h1>
            <p class="text-slate-100 text-base sm:text-xl md:text-2xl leading-relaxed font-normal">
                {{ $prosedur['subjudul'] }}
            </p>
        </div>
    </div>
</div>

<!-- Highlight Metrics / Quick Info -->
<div class="bg-white border-b border-slate-200 py-8 sm:py-10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 md:px-16 lg:px-24">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="flex items-start gap-4 p-5 border border-slate-200 bg-slate-50">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-[#1B365D] text-white flex items-center justify-center text-xl sm:text-2xl shrink-0">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-slate-500 uppercase tracking-wider">Jangka Waktu</h3>
                    <p class="text-lg sm:text-xl md:text-2xl font-black text-slate-900 mt-1">{{ $prosedur['jangka_waktu'] }}</p>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">+ Perpanjangan 7 hari kerja</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-5 border border-slate-200 bg-slate-50">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-[#07597b] text-white flex items-center justify-center text-xl sm:text-2xl shrink-0">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-slate-500 uppercase tracking-wider">Biaya Layanan</h3>
                    <p class="text-lg sm:text-xl md:text-2xl font-black text-emerald-600 mt-1">{{ $prosedur['biaya_layanan'] }}</p>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Tidak dipungut biaya apapun</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-5 border border-slate-200 bg-slate-50">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-[#1B365D] text-white flex items-center justify-center text-xl sm:text-2xl shrink-0">
                    <i class="fa-solid fa-id-card"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-slate-500 uppercase tracking-wider">Syarat Utama</h3>
                    <p class="text-lg sm:text-xl md:text-2xl font-black text-slate-900 mt-1">{{ $prosedur['syarat_utama'] }}</p>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">KTP / KTM / Legalitas Badan</p>
                </div>
            </div>

            <div class="flex items-start gap-4 p-5 border border-slate-200 bg-slate-50">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-[#07597b] text-white flex items-center justify-center text-xl sm:text-2xl shrink-0">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm font-extrabold text-slate-500 uppercase tracking-wider">Hak Pemohon</h3>
                    <p class="text-lg sm:text-xl md:text-2xl font-black text-slate-900 mt-1">{{ $prosedur['hak_pemohon'] }}</p>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Jika ditolak / tidak direspon</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="py-12 sm:py-20 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-8 md:px-16 lg:px-24 space-y-12 sm:space-y-20">

        <!-- Tab Selector: Permohonan vs Keberatan -->
        <div class="bg-white border border-slate-200 p-6 sm:p-10 md:p-12 shadow-lg">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 border-b border-slate-200 pb-8 mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Tahapan & Alur Prosedur</h2>
                    <p class="text-sm sm:text-base text-slate-600 mt-2">Pilih alur layanan yang ingin Anda pelajari di bawah ini.</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 bg-slate-100 p-2 border border-slate-200">
                    <button type="button" id="tab-permohonan-btn" onclick="switchTab('permohonan')"
                            class="px-5 sm:px-8 py-3.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all bg-[#1B365D] text-white shadow text-center">
                        <i class="fa-solid fa-file-lines mr-2"></i> Alur Permohonan Informasi
                    </button>
                    <button type="button" id="tab-keberatan-btn" onclick="switchTab('keberatan')"
                            class="px-5 sm:px-8 py-3.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all text-slate-700 hover:text-slate-900 hover:bg-slate-200 text-center">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i> Alur Pengajuan Keberatan
                    </button>
                </div>
            </div>

            <!-- Tab 1: Alur Permohonan Informasi -->
            <div id="section-permohonan" class="space-y-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    @foreach($prosedur['tahapan_permohonan'] as $step)
                    <div class="bg-white border border-slate-200 p-6 sm:p-7 flex flex-col justify-between hover:border-[#1B365D] transition-all group shadow-sm hover:shadow-md">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <span class="w-10 h-10 sm:w-12 sm:h-12 bg-[#1B365D] text-white font-black text-sm sm:text-base flex items-center justify-center">
                                    {{ $step['nomor'] }}
                                </span>
                                <i class="fa-solid {{ $step['ikon'] ?? 'fa-pen-to-square' }} text-xl sm:text-2xl text-slate-400 group-hover:text-[#1B365D] transition-colors"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 mb-3">{{ $step['judul'] }}</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                                {{ $step['deskripsi'] }}
                            </p>
                        </div>
                        @if(!empty($step['catatan']))
                        <div class="mt-6 pt-4 border-t border-slate-100 text-xs sm:text-sm font-bold text-[#07597b]">
                            <i class="fa-solid fa-circle-info mr-1.5"></i> {{ $step['catatan'] }}
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="bg-blue-50/80 border-l-4 border-[#1B365D] p-6 sm:p-8 text-sm sm:text-base text-slate-800 space-y-3">
                    <p class="font-extrabold text-[#1B365D] text-base sm:text-lg flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-xl"></i> Catatan Waktu & Perpanjangan Permohonan:
                    </p>
                    <p class="text-sm sm:text-base text-slate-700 leading-relaxed">
                        Apabila informasi yang diminta memerlukan pencarian mendalam atau koordinasi antar unit kerja, PPID FMIPA Unila berhak memperpanjang waktu penyampaian tanggapan paling lambat <strong class="text-slate-900 font-extrabold">7 (tujuh) hari kerja</strong> dengan memberitahukan secara tertulis beserta alasan kepada pemohon.
                    </p>
                </div>
            </div>

            <!-- Tab 2: Alur Pengajuan Keberatan -->
            <div id="section-keberatan" class="hidden space-y-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($prosedur['tahapan_keberatan'] as $step)
                    <div class="bg-white border border-slate-200 p-6 sm:p-7 flex flex-col justify-between hover:border-amber-500 transition-all group shadow-sm hover:shadow-md">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <span class="w-10 h-10 sm:w-12 sm:h-12 bg-amber-600 text-white font-black text-sm sm:text-base flex items-center justify-center">
                                    {{ $step['nomor'] }}
                                </span>
                                <i class="fa-solid {{ $step['ikon'] ?? 'fa-file-signature' }} text-xl sm:text-2xl text-slate-400 group-hover:text-amber-600 transition-colors"></i>
                            </div>
                            <h3 class="text-base sm:text-lg font-extrabold text-slate-900 mb-3">{{ $step['judul'] }}</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                                {{ $step['deskripsi'] }}
                            </p>
                        </div>
                        @if(!empty($step['catatan']))
                        <div class="mt-6 pt-4 border-t border-slate-100 text-xs sm:text-sm font-bold text-amber-800">
                            <i class="fa-solid fa-clock mr-1.5"></i> {{ $step['catatan'] }}
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                <div class="bg-amber-50/80 border-l-4 border-amber-600 p-6 sm:p-8 text-sm sm:text-base text-slate-800 space-y-3">
                    <p class="font-extrabold text-amber-900 text-base sm:text-lg flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i> Alasan Mengajukan Keberatan:
                    </p>
                    <ul class="list-disc list-inside text-sm sm:text-base text-slate-800 space-y-2 font-medium">
                        <li>Penolakan atas permintaan informasi berdasarkan alasan pengecualian.</li>
                        <li>Tidak disediakannya informasi berkala.</li>
                        <li>Permintaan informasi tidak ditanggapi sebagaimana mestinya.</li>
                        <li>Permintaan informasi ditanggapi tidak sebagaimana yang diminta.</li>
                        <li>Pengenaan biaya yang tidak makzul.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section: Persyaratan Dokumen Pemohon -->
        <div class="bg-white border border-slate-200 p-6 sm:p-10 md:p-12 shadow-lg">
            <div class="mb-8">
                <span class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[#07597b]">Kelengkapan Identitas</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Persyaratan Dokumen Pemohon</h2>
                <p class="text-sm sm:text-base text-slate-600 mt-2">Siapkan berkas identitas resmi berikut sebelum mengajukan formulir permohonan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1: Perorangan -->
                @if(isset($prosedur['syarat_dokumen']['perorangan']))
                @php $secPer = $prosedur['syarat_dokumen']['perorangan']; @endphp
                <div class="border border-slate-200 p-6 sm:p-7 bg-slate-50/50 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-[#1B365D] text-white flex items-center justify-center text-xl sm:text-2xl mb-5">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 mb-3">{{ $secPer['judul'] ?? 'Pemohon Perorangan' }}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mb-5 leading-relaxed">{{ $secPer['deskripsi'] ?? '' }}</p>
                        <ul class="space-y-3 text-xs sm:text-sm md:text-base text-slate-800 font-medium">
                            @foreach($secPer['poin'] as $poin)
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-600 mt-1 shrink-0 text-sm sm:text-base"></i>
                                <span>{{ $poin }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Card 2: Kelompok Masyarakat -->
                @if(isset($prosedur['syarat_dokumen']['kelompok']))
                @php $secKel = $prosedur['syarat_dokumen']['kelompok']; @endphp
                <div class="border border-slate-200 p-6 sm:p-7 bg-slate-50/50 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-[#07597b] text-white flex items-center justify-center text-xl sm:text-2xl mb-5">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 mb-3">{{ $secKel['judul'] ?? 'Kelompok Masyarakat' }}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mb-5 leading-relaxed">{{ $secKel['deskripsi'] ?? '' }}</p>
                        <ul class="space-y-3 text-xs sm:text-sm md:text-base text-slate-800 font-medium">
                            @foreach($secKel['poin'] as $poin)
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-600 mt-1 shrink-0 text-sm sm:text-base"></i>
                                <span>{{ $poin }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Card 3: Badan Hukum / Organisasi -->
                @if(isset($prosedur['syarat_dokumen']['badan_hukum']))
                @php $secBH = $prosedur['syarat_dokumen']['badan_hukum']; @endphp
                <div class="border border-slate-200 p-6 sm:p-7 bg-slate-50/50 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-[#1B365D] text-white flex items-center justify-center text-xl sm:text-2xl mb-5">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 mb-3">{{ $secBH['judul'] ?? 'Badan Hukum / NGO' }}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mb-5 leading-relaxed">{{ $secBH['deskripsi'] ?? '' }}</p>
                        <ul class="space-y-3 text-xs sm:text-sm md:text-base text-slate-800 font-medium">
                            @foreach($secBH['poin'] as $poin)
                            <li class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-600 mt-1 shrink-0 text-sm sm:text-base"></i>
                                <span>{{ $poin }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Section: Service Level Agreement (SLA) & Matrix Table -->
        <div class="bg-white border border-slate-200 p-6 sm:p-10 md:p-12 shadow-lg">
            <div class="mb-8">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Standar Waktu Layanan & Biaya (SLA)</h2>
                <p class="text-sm sm:text-base text-slate-600 mt-2">Matriks acuan batas waktu tanggapan serta ketentuan biaya layanan PPID FMIPA Unila.</p>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="min-w-[680px]">
                    <thead>
                        <tr>
                            <th class="text-center w-14 text-sm sm:text-base">No</th>
                            <th class="text-left text-sm sm:text-base">Jenis Layanan PPID</th>
                            <th class="text-center w-44 text-sm sm:text-base">Batas Waktu Max</th>
                            <th class="text-center w-40 text-sm sm:text-base">Biaya</th>
                            <th class="text-left text-sm sm:text-base">Bentuk Output / Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prosedur['sla_matrix'] as $row)
                        <tr>
                            <td class="text-center font-bold text-sm sm:text-base">{{ $row['no'] }}</td>
                            <td class="font-extrabold text-slate-900 text-sm sm:text-base">{{ $row['layanan'] }}</td>
                            <td class="text-center font-semibold text-sm sm:text-base">{{ $row['waktu'] }}</td>
                            <td class="text-center font-black text-emerald-600 text-sm sm:text-base">{{ $row['biaya'] }}</td>
                            <td class="text-sm sm:text-base text-slate-700 font-medium">{{ $row['output'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FAQ Accordion Section -->
        <div class="bg-white border border-slate-200 p-6 sm:p-10 md:p-12 shadow-lg">
            <div class="mb-8">
                <span class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[#07597b]">Pertanyaan Umum</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Pertanyaan Sering Diajukan (FAQ)</h2>
                <p class="text-sm sm:text-base text-slate-600 mt-2">Informasi penting mengenai prosedur dan aturan layanan informasi publik.</p>
            </div>

            <div class="space-y-4">
                @foreach($prosedur['faqs'] as $i => $faq)
                <div class="border border-slate-200 bg-slate-50/50">
                    <button type="button" onclick="toggleFaq({{ $i + 1 }})"
                            class="w-full p-5 sm:p-6 text-left flex justify-between items-center font-extrabold text-slate-900 hover:text-[#1B365D] transition-colors text-sm sm:text-base md:text-lg">
                        <span class="flex items-center gap-3 sm:gap-4 pr-3">
                            <i class="fa-solid fa-circle-question text-[#1B365D] shrink-0 text-lg sm:text-xl"></i>
                            <span>{{ $faq['tanya'] }}</span>
                        </span>
                        <i id="faq-icon-{{ $i + 1 }}" class="fa-solid fa-chevron-down text-slate-400 text-sm transition-transform duration-300 shrink-0"></i>
                    </button>
                    <div id="faq-answer-{{ $i + 1 }}" class="hidden p-5 sm:p-6 pt-0 border-t border-slate-200/50 text-sm sm:text-base text-slate-700 leading-relaxed font-medium">
                        {{ $faq['jawab'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Action Banner / Call to Action -->
        <div class="bg-[#1B365D] text-white p-8 sm:p-12 md:p-14 shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="space-y-3 text-center lg:text-left">
                <h3 class="text-2xl sm:text-3xl md:text-4xl font-extrabold">Siap Mengajukan Permohonan Informasi?</h3>
                <p class="text-cyan-100 text-sm sm:text-base md:text-lg max-w-2xl leading-relaxed">
                    Silakan akses formulir layanan permohonan informasi publik secara langsung atau periksa daftar dokumen informasi publik yang telah dipublikasikan.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto shrink-0">
                <a href="{{ route('layanan.index') }}?type=permohonan"
                   class="w-full sm:w-auto text-center px-8 py-4 bg-[#07597b] hover:bg-cyan-700 text-white font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane text-sm sm:text-base"></i> Buat Permohonan
                </a>
                <a href="/informasi-publik"
                   class="w-full sm:w-auto text-center px-8 py-4 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-extrabold text-xs sm:text-sm uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-list-ul text-sm sm:text-base"></i> Lihat Daftar Informasi
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Floating Quick Edit Widget (Hanya Muncul Saat Admin Login) -->
@auth
    @if(Auth::user()->isAdmin())
    <div class="fixed bottom-6 right-6 z-[9999] transition-all transform hover:scale-105">
        <a href="{{ route('admin.prosedur-permohonan.edit') }}"
           class="inline-flex items-center gap-3 px-6 py-4 bg-[#1B365D] hover:bg-[#07597b] text-white text-xs sm:text-sm font-extrabold uppercase tracking-wider shadow-2xl border-2 border-white/20">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-500"></span>
            </span>
            <i class="fa-solid fa-pen-to-square text-base"></i>
            <span>Edit Halaman Ini (Admin)</span>
        </a>
    </div>
    @endif
@endauth

<script>
function switchTab(tab) {
    const permSec = document.getElementById('section-permohonan');
    const kebSec = document.getElementById('section-keberatan');
    const permBtn = document.getElementById('tab-permohonan-btn');
    const kebBtn = document.getElementById('tab-keberatan-btn');

    if (tab === 'permohonan') {
        permSec.classList.remove('hidden');
        kebSec.classList.add('hidden');
        permBtn.className = "px-5 sm:px-8 py-3.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all bg-[#1B365D] text-white shadow text-center";
        kebBtn.className = "px-5 sm:px-8 py-3.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all text-slate-700 hover:text-slate-900 hover:bg-slate-200 text-center";
    } else {
        permSec.classList.add('hidden');
        kebSec.classList.remove('hidden');
        kebBtn.className = "px-5 sm:px-8 py-3.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all bg-amber-600 text-white shadow text-center";
        permBtn.className = "px-5 sm:px-8 py-3.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider transition-all text-slate-700 hover:text-slate-900 hover:bg-slate-200 text-center";
    }
}

function toggleFaq(id) {
    const answer = document.getElementById(`faq-answer-${id}`);
    const icon = document.getElementById(`faq-icon-${id}`);

    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.classList.add('rotate-180');
    } else {
        answer.classList.add('hidden');
        icon.classList.remove('rotate-180');
    }
}
</script>
@endsection
