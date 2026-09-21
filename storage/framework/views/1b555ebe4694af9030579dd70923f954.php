<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo e(asset('images/logoPPID.png')); ?>?v=2.0">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logoPPID.png')); ?>?v=2.0">
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('images/logoPPID.png')); ?>?v=2.0">
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/logoPPID.png')); ?>?v=2.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Inter"', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    borderRadius: {
                        'DEFAULT': '0.625rem',
                        'sm': '0.375rem',
                        'md': '0.5rem',
                        'lg': '0.625rem',
                        'xl': '0.625rem',
                        '2xl': '0.625rem',
                        '3xl': '0.625rem',
                        'full': '9999px',
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        html { 
            scroll-behavior: smooth; 
            font-size: 14px; 
        }
        @media (min-width: 1700px) {
            html { font-size: 16px; }
        }
        @media (min-width: 1400px) and (max-width: 1699px) {
            html { font-size: 14.5px; }
        }
        @media (max-width: 1200px) {
            html { font-size: 13.5px; }
        }
        body { 
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important; 
            font-size: 1rem; 
        }
    </style>
</head>

<body class="antialiased text-gray-800 bg-slate-50 min-h-screen flex flex-col <?php echo e(request()->is('/') ? 'is-home' : ''); ?>">

    <?php if (isset($component)) { $__componentOriginala02bf2c07d7e78a7e7f116823e74edbd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala02bf2c07d7e78a7e7f116823e74edbd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala02bf2c07d7e78a7e7f116823e74edbd)): ?>
<?php $attributes = $__attributesOriginala02bf2c07d7e78a7e7f116823e74edbd; ?>
<?php unset($__attributesOriginala02bf2c07d7e78a7e7f116823e74edbd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala02bf2c07d7e78a7e7f116823e74edbd)): ?>
<?php $component = $__componentOriginala02bf2c07d7e78a7e7f116823e74edbd; ?>
<?php unset($__componentOriginala02bf2c07d7e78a7e7f116823e74edbd); ?>
<?php endif; ?>

    <main class="flex-grow">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php if (isset($component)) { $__componentOriginal68815235f0a09eac1e56d0adbe6c15bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68815235f0a09eac1e56d0adbe6c15bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68815235f0a09eac1e56d0adbe6c15bb)): ?>
<?php $attributes = $__attributesOriginal68815235f0a09eac1e56d0adbe6c15bb; ?>
<?php unset($__attributesOriginal68815235f0a09eac1e56d0adbe6c15bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68815235f0a09eac1e56d0adbe6c15bb)): ?>
<?php $component = $__componentOriginal68815235f0a09eac1e56d0adbe6c15bb; ?>
<?php unset($__componentOriginal68815235f0a09eac1e56d0adbe6c15bb); ?>
<?php endif; ?>
</body>
</html>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>