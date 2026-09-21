<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['faqs' => []]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['faqs' => []]); ?>
<?php foreach (array_filter((['faqs' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

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
        <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-2xs transition-all">
                <button 
                    type="button" 
                    @click="activeAccordion = (activeAccordion === <?php echo e($index + 1); ?> ? null : <?php echo e($index + 1); ?>)" 
                    class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 cursor-pointer focus:outline-none">
                    <span class="font-extrabold text-sm sm:text-base text-slate-900 break-words min-w-0 flex-1 leading-snug">
                        <?php echo e(is_array($faq) ? ($faq['pertanyaan'] ?? '') : ($faq->pertanyaan ?? '')); ?>

                    </span>
                    <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition-transform duration-300" :class="{ 'rotate-180 bg-sky-100 text-sky-700': activeAccordion === <?php echo e($index + 1); ?> }">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </span>
                </button>
                <div x-show="activeAccordion === <?php echo e($index + 1); ?>" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed border-t border-slate-100 whitespace-pre-line break-words">
                    <?php echo nl2br(e(is_array($faq) ? ($faq['jawaban'] ?? '') : ($faq->jawaban ?? ''))); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-8 text-center bg-white rounded-2xl border border-slate-200 text-slate-400 text-sm font-semibold">
                Belum ada pertanyaan FAQ yang ditambahkan.
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/masyarakat/beranda/faq-section.blade.php ENDPATH**/ ?>