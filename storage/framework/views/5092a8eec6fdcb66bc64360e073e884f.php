<?php $__env->startSection('title', 'Beranda - PPID FMIPA Universitas Lampung'); ?>

<?php $__env->startSection('content'); ?>
<main class="pt-[6.875rem] md:pt-32 bg-slate-50/50">

    <!-- 1. Hero Section Banner: Dekanat FMIPA & Konten Modern -->
    <?php if (isset($component)) { $__componentOriginal7aca7812192c6e4d59ae08c6be016454 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7aca7812192c6e4d59ae08c6be016454 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.beranda.hero','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.beranda.hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7aca7812192c6e4d59ae08c6be016454)): ?>
<?php $attributes = $__attributesOriginal7aca7812192c6e4d59ae08c6be016454; ?>
<?php unset($__attributesOriginal7aca7812192c6e4d59ae08c6be016454); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7aca7812192c6e4d59ae08c6be016454)): ?>
<?php $component = $__componentOriginal7aca7812192c6e4d59ae08c6be016454; ?>
<?php unset($__componentOriginal7aca7812192c6e4d59ae08c6be016454); ?>
<?php endif; ?>

    <!-- 3. Alur & Prosedur Permohonan Layanan -->
    <?php if (isset($component)) { $__componentOriginal7ee86e5f94391e46b6c415ae44e01517 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ee86e5f94391e46b6c415ae44e01517 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.beranda.alur-prosedur','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.beranda.alur-prosedur'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ee86e5f94391e46b6c415ae44e01517)): ?>
<?php $attributes = $__attributesOriginal7ee86e5f94391e46b6c415ae44e01517; ?>
<?php unset($__attributesOriginal7ee86e5f94391e46b6c415ae44e01517); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ee86e5f94391e46b6c415ae44e01517)): ?>
<?php $component = $__componentOriginal7ee86e5f94391e46b6c415ae44e01517; ?>
<?php unset($__componentOriginal7ee86e5f94391e46b6c415ae44e01517); ?>
<?php endif; ?>

    <!-- 4. Statistik Transparansi PPID FMIPA Unila -->
    <?php if (isset($component)) { $__componentOriginal325f09ff3d186aa910379dece624c706 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal325f09ff3d186aa910379dece624c706 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.beranda.statistik-section','data' => ['totalDokumen' => $totalDokumen,'totalPermohonan' => $totalPermohonan,'totalPermohonanSelesai' => $totalPermohonanSelesai,'totalPermohonanDitolak' => $totalPermohonanDitolak,'totalKeberatan' => $totalKeberatan,'totalDilihat' => $totalDilihat,'kategoriCount' => $kategoriCount,'chartTahunan' => $chartTahunan,'chartBulanan' => $chartBulanan,'chartBulananPerTahun' => $chartBulananPerTahun,'rataRataWaktuTeks' => $rataRataWaktuTeks]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.beranda.statistik-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['totalDokumen' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalDokumen),'totalPermohonan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalPermohonan),'totalPermohonanSelesai' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalPermohonanSelesai),'totalPermohonanDitolak' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalPermohonanDitolak),'totalKeberatan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalKeberatan),'totalDilihat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalDilihat),'kategoriCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($kategoriCount),'chartTahunan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($chartTahunan),'chartBulanan' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($chartBulanan),'chartBulananPerTahun' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($chartBulananPerTahun),'rataRataWaktuTeks' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($rataRataWaktuTeks)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal325f09ff3d186aa910379dece624c706)): ?>
<?php $attributes = $__attributesOriginal325f09ff3d186aa910379dece624c706; ?>
<?php unset($__attributesOriginal325f09ff3d186aa910379dece624c706); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal325f09ff3d186aa910379dece624c706)): ?>
<?php $component = $__componentOriginal325f09ff3d186aa910379dece624c706; ?>
<?php unset($__componentOriginal325f09ff3d186aa910379dece624c706); ?>
<?php endif; ?>

    <!-- 5. Tanya Jawab / FAQ Seputar PPID (Accordion) -->
    <?php if (isset($component)) { $__componentOriginal8153beea8c1ae7100033b9888c14ddef = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8153beea8c1ae7100033b9888c14ddef = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.beranda.faq-section','data' => ['faqs' => $faqs]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.beranda.faq-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['faqs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($faqs)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8153beea8c1ae7100033b9888c14ddef)): ?>
<?php $attributes = $__attributesOriginal8153beea8c1ae7100033b9888c14ddef; ?>
<?php unset($__attributesOriginal8153beea8c1ae7100033b9888c14ddef); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8153beea8c1ae7100033b9888c14ddef)): ?>
<?php $component = $__componentOriginal8153beea8c1ae7100033b9888c14ddef; ?>
<?php unset($__componentOriginal8153beea8c1ae7100033b9888c14ddef); ?>
<?php endif; ?>

    <!-- Banner Call to Action & Bantuan Helpdesk -->
    <?php if (isset($component)) { $__componentOriginal91d39baf1c531410e8c636b0e3f14e83 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91d39baf1c531410e8c636b0e3f14e83 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.beranda.cta-helpdesk','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.beranda.cta-helpdesk'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91d39baf1c531410e8c636b0e3f14e83)): ?>
<?php $attributes = $__attributesOriginal91d39baf1c531410e8c636b0e3f14e83; ?>
<?php unset($__attributesOriginal91d39baf1c531410e8c636b0e3f14e83); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91d39baf1c531410e8c636b0e3f14e83)): ?>
<?php $component = $__componentOriginal91d39baf1c531410e8c636b0e3f14e83; ?>
<?php unset($__componentOriginal91d39baf1c531410e8c636b0e3f14e83); ?>
<?php endif; ?>

</main>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('components.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/masyarakat/beranda/index.blade.php ENDPATH**/ ?>