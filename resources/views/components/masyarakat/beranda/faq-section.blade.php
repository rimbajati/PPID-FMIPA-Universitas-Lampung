@props(['faqs' => []])

<!-- Tanya Jawab Seputar PPID Section (FAQ Accordion) -->
<section class="max-w-4xl mx-auto px-6 md:px-12 mb-20" x-data="{ activeAccordion: null }">
    <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-700 text-xs font-extrabold border border-sky-100">
            <i class="fa-solid fa-circle-question"></i>
            <span>FAQ PPID</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Pertanyaan yang Sering Diajukan</h2>
        <p class="text-sm sm:text-base text-slate-600 font-medium">Informasi penting terkait tata kelola dan pengajuan permohonan informasi publik.</p>
    </div>

    <div class="space-y-4">
        @forelse($faqs as $index => $faq)
            <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-2xs transition-all">
                <button 
                    type="button" 
                    @click="activeAccordion = (activeAccordion === {{ $index + 1 }} ? null : {{ $index + 1 }})" 
                    class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 cursor-pointer focus:outline-none">
                    <span class="font-extrabold text-sm sm:text-base text-slate-900 break-words min-w-0 flex-1 leading-snug">
                        {{ is_array($faq) ? ($faq['pertanyaan'] ?? '') : ($faq->pertanyaan ?? '') }}
                    </span>
                    <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition-transform duration-300" :class="{ 'rotate-180 bg-sky-100 text-sky-700': activeAccordion === {{ $index + 1 }} }">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </span>
                </button>
                <div x-show="activeAccordion === {{ $index + 1 }}" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed border-t border-slate-100 whitespace-pre-line break-words">
                    {!! nl2br(e(is_array($faq) ? ($faq['jawaban'] ?? '') : ($faq->jawaban ?? ''))) !!}
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white rounded-2xl border border-slate-200 text-slate-400 text-sm font-semibold">
                Belum ada pertanyaan FAQ yang ditambahkan.
            </div>
        @endforelse
    </div>
</section>
