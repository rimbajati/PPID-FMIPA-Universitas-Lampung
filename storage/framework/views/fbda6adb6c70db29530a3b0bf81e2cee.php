<?php $__env->startSection('title', 'Ajukan Permohonan Informasi - PPID FMIPA Unila'); ?>

<?php $__env->startSection('content'); ?>
<main class="pt-[4.75rem] md:pt-[5.25rem] bg-slate-50 min-h-screen pb-24">



    <!-- Header Hero Banner Permohonan Informasi -->
    <?php if (isset($component)) { $__componentOriginalba4a1285e82e9000242b63bf6bd57510 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalba4a1285e82e9000242b63bf6bd57510 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.permohonan.hero-header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.permohonan.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalba4a1285e82e9000242b63bf6bd57510)): ?>
<?php $attributes = $__attributesOriginalba4a1285e82e9000242b63bf6bd57510; ?>
<?php unset($__attributesOriginalba4a1285e82e9000242b63bf6bd57510); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalba4a1285e82e9000242b63bf6bd57510)): ?>
<?php $component = $__componentOriginalba4a1285e82e9000242b63bf6bd57510; ?>
<?php unset($__componentOriginalba4a1285e82e9000242b63bf6bd57510); ?>
<?php endif; ?>

    <!-- Main Container Content (Wide Layout 2 Kolom) -->
    <div id="permohonan-form-container" class="max-w-7xl mx-auto px-4 md:px-8 lg:px-12 pt-8" x-data="permohonanSingleForm()">
        
        <!-- SINGLE UNIFIED FORM CONTAINER -->
        <?php if (isset($component)) { $__componentOriginal6dc7bef46052e76974e3b6f619935fd7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6dc7bef46052e76974e3b6f619935fd7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.permohonan.form','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.permohonan.form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6dc7bef46052e76974e3b6f619935fd7)): ?>
<?php $attributes = $__attributesOriginal6dc7bef46052e76974e3b6f619935fd7; ?>
<?php unset($__attributesOriginal6dc7bef46052e76974e3b6f619935fd7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6dc7bef46052e76974e3b6f619935fd7)): ?>
<?php $component = $__componentOriginal6dc7bef46052e76974e3b6f619935fd7; ?>
<?php unset($__componentOriginal6dc7bef46052e76974e3b6f619935fd7); ?>
<?php endif; ?>
    </div>

</main>

<!-- Helper Alpine.js Form Logic -->
<?php if (isset($component)) { $__componentOriginal03aab542ee27c8fe51d997bc6d204afd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal03aab542ee27c8fe51d997bc6d204afd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.permohonan.script','data' => ['user' => $user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.permohonan.script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal03aab542ee27c8fe51d997bc6d204afd)): ?>
<?php $attributes = $__attributesOriginal03aab542ee27c8fe51d997bc6d204afd; ?>
<?php unset($__attributesOriginal03aab542ee27c8fe51d997bc6d204afd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal03aab542ee27c8fe51d997bc6d204afd)): ?>
<?php $component = $__componentOriginal03aab542ee27c8fe51d997bc6d204afd; ?>
<?php unset($__componentOriginal03aab542ee27c8fe51d997bc6d204afd); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/masyarakat/layanan/permohonan/index.blade.php ENDPATH**/ ?>