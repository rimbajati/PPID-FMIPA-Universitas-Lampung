<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['paginator', 'label' => 'data']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['paginator', 'label' => 'data']); ?>
<?php foreach (array_filter((['paginator', 'label' => 'data']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();

    // Generate page links array with ellipses
    $elements = [];
    if ($lastPage <= 9) {
        $elements[] = range(1, $lastPage);
    } else {
        if ($currentPage <= 4) {
            $elements[] = range(1, 5);
            $elements[] = '...';
            $elements[] = range($lastPage - 1, $lastPage);
        } elseif ($currentPage >= $lastPage - 3) {
            $elements[] = range(1, 2);
            $elements[] = '...';
            $elements[] = range($lastPage - 4, $lastPage);
        } else {
            $elements[] = range(1, 2);
            $elements[] = '...';
            $elements[] = range($currentPage - 1, $currentPage + 1);
            $elements[] = '...';
            $elements[] = range($lastPage - 1, $lastPage);
        }
    }
?>

<div class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full">
    <!-- Counter Left -->
    <div class="text-xs md:text-sm text-slate-800">
        Menampilkan <?php echo e($paginator->firstItem() ?? 0); ?> sampai <?php echo e($paginator->lastItem() ?? 0); ?> dari <?php echo e($paginator->total()); ?> entri
    </div>

    <!-- Unified Connected Pagination Box (Matching Reference Image) -->
    <div class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white">
        
        <?php if($paginator->onFirstPage()): ?>
            <span class="px-3.5 py-2 text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed select-none">
                ‹
            </span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="px-3.5 py-2 text-xs font-bold text-sky-500 hover:bg-sky-50 transition flex items-center justify-center">
                ‹
            </a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <span class="px-3 py-2 text-xs font-bold bg-slate-100/70 text-slate-400 select-none">
                    <?php echo e($element); ?>

                </span>
            <?php elseif(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $currentPage): ?>
                        <span class="px-3.5 py-2 min-w-[38px] text-center text-xs font-extrabold bg-sky-500 text-white shadow-2xs">
                            <?php echo e($page); ?>

                        </span>
                    <?php else: ?>
                        <a href="<?php echo e($paginator->url($page)); ?>" class="px-3.5 py-2 min-w-[38px] text-center text-xs font-bold bg-white text-sky-500 hover:bg-sky-50 transition">
                            <?php echo e($page); ?>

                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="px-3.5 py-2 text-xs font-bold text-sky-500 hover:bg-sky-50 transition flex items-center justify-center">
                ›
            </a>
        <?php else: ?>
            <span class="px-3.5 py-2 text-xs font-bold text-slate-300 bg-slate-50 cursor-not-allowed select-none">
                ›
            </span>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/ui/pagination.blade.php ENDPATH**/ ?>