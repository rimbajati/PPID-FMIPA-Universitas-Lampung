@extends('components.layouts.admin')

@section('title', 'FAQ - Admin PPID')
@section('header_title', 'Kelola FAQ')

@section('content')
<div class="space-y-8 w-full pb-12">

    {{-- Alert --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-[15px] font-bold shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-xl shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-[15px] font-bold shadow-sm">
            <i class="fa-solid fa-circle-exclamation text-rose-600 text-xl shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Page Title --}}
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Pertanyaan yang Sering Diajukan</h1>
        <p class="text-[15px] text-slate-500 font-medium mt-1.5">Kelola daftar FAQ yang tampil di beranda masyarakat. Batas maksimal 5 pertanyaan.</p>
    </div>

    {{-- Daftar FAQ (List Memanjang) --}}
    <div class="space-y-4">
        @forelse($faqs as $faq)
            <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 shadow-sm flex flex-col sm:flex-row sm:items-start justify-between gap-5 group hover:border-sky-200 transition-all">
                <div class="space-y-3 flex-1 min-w-0">
                    <div class="flex items-start gap-4">
                        <span class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 font-black text-sm flex items-center justify-center shrink-0 mt-0.5 border border-sky-100">Q</span>
                        <h3 class="text-[17px] font-black text-slate-900 break-words leading-snug">
                            {{ $faq['pertanyaan'] ?? '' }}
                        </h3>
                    </div>
                    <div class="pl-12 text-[15px] text-slate-600 font-medium leading-relaxed whitespace-pre-line break-words">
                        {{ $faq['jawaban'] ?? '' }}
                    </div>
                </div>
                <div class="shrink-0 pl-12 sm:pl-0">
                    <button type="button"
                            onclick="triggerDelete('{{ route('admin.faq.destroy', $faq['id']) }}', '{{ addslashes($faq['pertanyaan'] ?? 'pertanyaan ini') }}')"
                            class="px-4 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[13px] inline-flex items-center gap-2 transition-all border border-rose-200/60 cursor-pointer">
                        <i class="fa-regular fa-trash-can"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="p-12 text-center bg-white rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mx-auto text-3xl border border-slate-100">
                    <i class="fa-regular fa-circle-question"></i>
                </div>
                <div class="space-y-1">
                    <p class="text-base font-bold text-slate-700">Belum ada pertanyaan FAQ</p>
                    <p class="text-sm text-slate-400 font-medium">Gunakan formulir di bawah untuk menambahkan pertanyaan pertama.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Form Tambah (Di Bawah) --}}
    @if(count($faqs) < 5)
        <div id="formTambahFaq" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-md space-y-6 scroll-mt-6">
            <div class="flex items-center gap-3.5 border-b border-slate-100 pb-5">
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg font-black shrink-0 border border-sky-100">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-900">Tambah Pertanyaan Baru</h3>
                    <p class="text-[14px] text-slate-400 font-medium">Tambah pertanyaan baru (Tersisa {{ 5 - count($faqs) }} slot lagi).</p>
                </div>
            </div>
            
            <form action="{{ route('admin.faq.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label class="block text-[15px] font-bold text-slate-800">Pertanyaan</label>
                    <input type="text" name="pertanyaan" required
                           value="{{ old('pertanyaan') }}"
                           placeholder="Contoh: Berapa biaya pengajuan permohonan informasi?"
                           class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-[15px] font-bold text-slate-800">Jawaban</label>
                    <textarea name="jawaban" rows="5" required
                              placeholder="Tuliskan jawaban yang jelas dan informatif..."
                              class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition resize-none leading-relaxed">{{ old('jawaban') }}</textarea>
                </div>
                <div class="flex items-center justify-end pt-2">
                    <button type="submit"
                            class="px-8 py-3.5 bg-sky-600 hover:bg-sky-700 text-white font-black text-sm rounded-xl shadow-lg shadow-sky-600/20 transition-all inline-flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Pertanyaan</span>
                    </button>
                </div>
            </form>
        </div>
    @else
        <div class="p-5 bg-amber-50 border border-amber-200 rounded-2xl flex items-center gap-3.5 text-amber-800">
            <i class="fa-solid fa-circle-info text-xl text-amber-500"></i>
            <p class="text-sm font-bold">Batas maksimal 5 FAQ telah tercapai. Hapus salah satu pertanyaan jika ingin menambah pertanyaan baru.</p>
        </div>
    @endif

</div>
@endsection
