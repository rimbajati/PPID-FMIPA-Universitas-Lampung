@extends('components.layouts.app')

@section('title', 'Pengajuan Keberatan Informasi - PPID FMIPA Unila')

@section('content')
<main class="pt-16 md:pt-[4.5rem] bg-slate-50 min-h-screen pb-24">

    <!-- Header Hero Banner & Dasar Hukum -->
    <x-masyarakat.keberatan.hero-header />

    <!-- Main Container Form Pengajuan Keberatan Single Page -->
    <div id="keberatan-form-container" class="max-w-7xl mx-auto px-4 md:px-8 lg:px-12 pt-8" x-data="keberatanForm()">
        
        <!-- Alert Error Global (misal: tiket masih dalam masa layanan / sudah ada keberatan) -->
        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 flex items-start gap-3 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg shrink-0 mt-0.5"></i>
            <div class="flex-1 text-sm leading-relaxed text-rose-800 font-medium">
                {{ session('error') }}
            </div>
            <button type="button" @click="show = false" class="shrink-0 text-rose-400 hover:text-rose-600 transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
        @endif

        <!-- Box Pemberitahuan Peringatan -->
        <x-masyarakat.keberatan.alert-warning />

        <!-- Form Utama Pengajuan Keberatan -->
        <x-masyarakat.keberatan.form />

    </div>

    <!-- Modal Sukses Keberatan -->
    @if(session()->has('success_keberatan_tiket'))
    <div class="fixed inset-0 z-[999999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity" 
         x-data="{ show: true }" 
         x-show="show" 
         x-init="document.body.classList.add('overflow-hidden')"
         x-effect="if(!show) document.body.classList.remove('overflow-hidden')"
         @keydown.escape="show = false"
         x-cloak>
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border-0 space-y-6 text-center animate-in fade-in zoom-in duration-200" 
             @click.outside="show = false">
            
            <!-- Icon Sukses -->
            <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mx-auto shadow-inner">
                <i class="fa-solid fa-check"></i>
            </div>

            <!-- Konten Teks -->
            <div class="space-y-2">
                <h2 class="text-xl font-black text-slate-900">Keberatan Berhasil Dikirim</h2>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-medium">
                    Tiket keberatan Anda telah dibuat. Simpan tiket ini atau cek email Anda untuk melacak status keberatan.
                </p>
            </div>

            <!-- Tiket Box -->
            <div class="rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                <p class="mb-1 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nomor Tiket Anda</p>
                <p class="text-xl font-black text-amber-600 font-mono tracking-wider">{{ session('success_keberatan_tiket') }}</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-center gap-3 pt-2">
                <button type="button" @click="
                    navigator.clipboard.writeText('{{ session('success_keberatan_tiket') }}');
                    const original = $el.innerHTML;
                    $el.innerHTML = '<i class=\'fa-solid fa-check mr-2\'></i>Tersalin';
                    $el.classList.replace('bg-amber-500', 'bg-emerald-600');
                    setTimeout(() => { 
                        $el.innerHTML = original;
                        $el.classList.replace('bg-emerald-600', 'bg-amber-500');
                    }, 2000);
                " class="w-full py-3.5 bg-amber-500 hover:bg-amber-600 text-white text-xs sm:text-sm font-extrabold rounded-xl transition shadow-md flex items-center justify-center">
                    <i class="fa-regular fa-copy mr-2 text-base"></i>Salin Tiket
                </button>
                <button type="button" @click="show = false" 
                        class="w-full py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-extrabold rounded-xl transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

</main>

<!-- Helper Alpine.js Logic -->
<x-masyarakat.keberatan.script />
@endsection
