<?php $__env->startSection('title', 'Dashboard Permohonan - Admin PPID'); ?>
<?php $__env->startSection('header_title', 'Permohonan Informasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Section Header & 5 Summary Overview Cards -->
    <?php if (isset($component)) { $__componentOriginale338dba9605af5d04ff6762fe5692beb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale338dba9605af5d04ff6762fe5692beb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permohonan.summary-cards','data' => ['totalPermohonan' => $totalPermohonan,'totalMenunggu' => $totalMenunggu,'totalDiproses' => $totalDiproses,'totalSelesai' => $totalSelesai,'totalDitolak' => $totalDitolak]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.permohonan.summary-cards'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['totalPermohonan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalPermohonan),'totalMenunggu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalMenunggu),'totalDiproses' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalDiproses),'totalSelesai' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalSelesai),'totalDitolak' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalDitolak)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale338dba9605af5d04ff6762fe5692beb)): ?>
<?php $attributes = $__attributesOriginale338dba9605af5d04ff6762fe5692beb; ?>
<?php unset($__attributesOriginale338dba9605af5d04ff6762fe5692beb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale338dba9605af5d04ff6762fe5692beb)): ?>
<?php $component = $__componentOriginale338dba9605af5d04ff6762fe5692beb; ?>
<?php unset($__componentOriginale338dba9605af5d04ff6762fe5692beb); ?>
<?php endif; ?>

    <!-- Tabel Data Permohonan, Search, & Filter -->
    <?php if (isset($component)) { $__componentOriginal1b11e615de2aa591af11af70ae27bcdc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1b11e615de2aa591af11af70ae27bcdc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permohonan.table','data' => ['permohonans' => $permohonans]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.permohonan.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permohonans' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($permohonans)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1b11e615de2aa591af11af70ae27bcdc)): ?>
<?php $attributes = $__attributesOriginal1b11e615de2aa591af11af70ae27bcdc; ?>
<?php unset($__attributesOriginal1b11e615de2aa591af11af70ae27bcdc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1b11e615de2aa591af11af70ae27bcdc)): ?>
<?php $component = $__componentOriginal1b11e615de2aa591af11af70ae27bcdc; ?>
<?php unset($__componentOriginal1b11e615de2aa591af11af70ae27bcdc); ?>
<?php endif; ?>

    <!-- Modal Konfirmasi Hapus Data (Single / Bulk) -->
    <?php if (isset($component)) { $__componentOriginalb2683f8a2dbe616896c40f8e776dbca5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2683f8a2dbe616896c40f8e776dbca5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.delete','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modals.delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2683f8a2dbe616896c40f8e776dbca5)): ?>
<?php $attributes = $__attributesOriginalb2683f8a2dbe616896c40f8e776dbca5; ?>
<?php unset($__attributesOriginalb2683f8a2dbe616896c40f8e776dbca5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2683f8a2dbe616896c40f8e776dbca5)): ?>
<?php $component = $__componentOriginalb2683f8a2dbe616896c40f8e776dbca5; ?>
<?php unset($__componentOriginalb2683f8a2dbe616896c40f8e776dbca5); ?>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('components.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/admin/permohonan/index.blade.php ENDPATH**/ ?>