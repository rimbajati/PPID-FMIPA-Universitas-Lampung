@extends('components.layouts.admin')

@section('title', 'Tanya Jawab (FAQ) - Admin PPID')
@section('header_title', 'Tanya Jawab (FAQ)')

@section('content')
<div class="space-y-6">

    <!-- Notifikasi Feedback Flash Message -->
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200/80 rounded-2xl text-emerald-800 text-xs sm:text-sm font-bold shadow-2xs">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200/80 rounded-2xl text-rose-800 text-xs sm:text-sm space-y-1 shadow-2xs">
            <div class="font-black flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Terjadi kesalahan pada input:</span>
            </div>
            <ul class="list-disc list-inside font-semibold space-y-0.5 pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header Section FAQ (Tanpa Kotak) -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Kelola Tanya Jawab (FAQ)</h1>
        <p class="text-xs sm:text-sm font-semibold text-slate-400 mt-1">Daftar pertanyaan dan jawaban yang tampil langsung di beranda pemohon untuk memandu masyarakat.</p>
    </div>

    <!-- Daftar FAQ Accordion / Kartu -->
    <div class="space-y-3.5">
        @forelse($faqs as $faq)
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-start justify-between gap-4 group">
                <div class="space-y-2 flex-1 min-w-0">
                    <div class="flex items-start gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-sky-100 text-sky-700 font-black text-xs flex items-center justify-center shrink-0 mt-0.5">
                            Q
                        </span>
                        <h3 class="text-sm sm:text-base font-black text-slate-900 break-words leading-snug">
                            {{ $faq['pertanyaan'] ?? '' }}
                        </h3>
                    </div>
                    <div class="pl-8 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed whitespace-pre-line break-words">
                        {{ $faq['jawaban'] ?? '' }}
                    </div>
                </div>

                <!-- Tombol Aksi Hapus Menggunakan Modal Kustom Elegan -->
                <div class="shrink-0 pl-8 sm:pl-0 sm:pt-0.5">
                    <button 
                        type="button" 
                        onclick="triggerDelete('{{ route('admin.faq.destroy', $faq['id']) }}', '{{ addslashes($faq['pertanyaan'] ?? 'pertanyaan ini') }}')"
                        class="px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs inline-flex items-center gap-1.5 transition-all border border-rose-200/60 cursor-pointer">
                        <i class="fa-regular fa-trash-can text-xs"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="p-10 text-center bg-white rounded-2xl border border-slate-200/90 shadow-2xs space-y-2.5">
                <div class="w-11 h-11 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-lg">
                    <i class="fa-regular fa-circle-question"></i>
                </div>
                <p class="text-xs sm:text-sm font-bold text-slate-600">Belum ada pertanyaan FAQ yang dibuat.</p>
                <p class="text-[11px] sm:text-xs text-slate-400 max-w-sm mx-auto font-medium">Gunakan formulir di bawah ini untuk menambahkan tanya jawab pertama ke beranda pemohon.</p>
            </div>
        @endforelse
    </div>

    <!-- KOTAK FORM LANGSUNG: Tambah FAQ Baru (Di Paling Bawah) -->
    <div id="formTambahFaq" class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-2xs space-y-4 scroll-mt-6">
        <div class="flex items-center gap-2.5 border-b border-slate-100 pb-3.5">
            <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-sm font-black shrink-0">
                <i class="fa-solid fa-circle-plus"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-black text-slate-900">Tambah Tanya Jawab (FAQ)</h3>
                <p class="text-xs text-slate-400 font-medium">Tuliskan pertanyaan baru dan jawabannya untuk langsung ditampilkan di beranda pemohon.</p>
            </div>
        </div>

        <form action="{{ route('admin.faq.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-slate-700">Pertanyaan</label>
                <input 
                    type="text" 
                    name="pertanyaan" 
                    required 
                    value="{{ old('pertanyaan') }}"
                    placeholder="Contoh: Berapa biaya pengajuan permohonan informasi?" 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-slate-700">Jawaban</label>
                <textarea 
                    name="jawaban" 
                    rows="4" 
                    required 
                    placeholder="Tuliskan jawaban yang jelas dan informatif untuk pemohon..." 
                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all resize-none">{{ old('jawaban') }}</textarea>
            </div>

            <div class="flex items-center justify-end pt-2">
                <button 
                    type="submit" 
                    class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-black text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
