<?php $__env->startSection('title', 'Manajemen Pengajuan Keberatan - Admin PPID'); ?>
<?php $__env->startSection('header_title', 'Pengajuan Keberatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- 5 Summary Cards -->
    <?php if (isset($component)) { $__componentOriginalbb7fd5521d8654abfe6e6feb241ab596 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb7fd5521d8654abfe6e6feb241ab596 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.keberatan.summary-cards','data' => ['totalKeberatan' => $totalKeberatan,'totalMenunggu' => $totalMenunggu,'totalDiproses' => $totalDiproses,'totalSelesai' => $totalSelesai,'totalDitolak' => $totalDitolak]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.keberatan.summary-cards'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['totalKeberatan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalKeberatan),'totalMenunggu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalMenunggu),'totalDiproses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalDiproses),'totalSelesai' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalSelesai),'totalDitolak' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalDitolak)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb7fd5521d8654abfe6e6feb241ab596)): ?>
<?php $attributes = $__attributesOriginalbb7fd5521d8654abfe6e6feb241ab596; ?>
<?php unset($__attributesOriginalbb7fd5521d8654abfe6e6feb241ab596); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb7fd5521d8654abfe6e6feb241ab596)): ?>
<?php $component = $__componentOriginalbb7fd5521d8654abfe6e6feb241ab596; ?>
<?php unset($__componentOriginalbb7fd5521d8654abfe6e6feb241ab596); ?>
<?php endif; ?>

    <!-- Tabel Data Pengajuan Keberatan -->
    <?php if (isset($component)) { $__componentOriginal64204013bb99d3a0e12991928490b74f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal64204013bb99d3a0e12991928490b74f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.keberatan.table','data' => ['keberatans' => $keberatans]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.keberatan.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['keberatans' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($keberatans)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal64204013bb99d3a0e12991928490b74f)): ?>
<?php $attributes = $__attributesOriginal64204013bb99d3a0e12991928490b74f; ?>
<?php unset($__attributesOriginal64204013bb99d3a0e12991928490b74f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal64204013bb99d3a0e12991928490b74f)): ?>
<?php $component = $__componentOriginal64204013bb99d3a0e12991928490b74f; ?>
<?php unset($__componentOriginal64204013bb99d3a0e12991928490b74f); ?>
<?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/admin/keberatan/index.blade.php ENDPATH**/ ?>