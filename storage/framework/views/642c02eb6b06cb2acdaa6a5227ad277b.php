<?php $__env->startSection('title', 'Katalog Informasi Publik - PPID FMIPA Universitas Lampung'); ?>

<?php $__env->startSection('content'); ?>
<main class="pt-16 md:pt-[4.5rem] bg-slate-100/70 min-h-screen pb-20">

    <!-- Header Hero Banner (Matching Reference UI Title & Subtitle) -->
    <?php if (isset($component)) { $__componentOriginalab1c78331ae0916e4ce116f3c9683deb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalab1c78331ae0916e4ce116f3c9683deb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.informasi_publik.hero-header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.informasi_publik.hero-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalab1c78331ae0916e4ce116f3c9683deb)): ?>
<?php $attributes = $__attributesOriginalab1c78331ae0916e4ce116f3c9683deb; ?>
<?php unset($__attributesOriginalab1c78331ae0916e4ce116f3c9683deb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalab1c78331ae0916e4ce116f3c9683deb)): ?>
<?php $component = $__componentOriginalab1c78331ae0916e4ce116f3c9683deb; ?>
<?php unset($__componentOriginalab1c78331ae0916e4ce116f3c9683deb); ?>
<?php endif; ?>

    <!-- Main Content Container: Tabel Informasi Publik (Matching Admin DIP Table) -->
    <div class="max-w-[96rem] mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="space-y-4">

            <!-- Bar Kontrol Tabel: Show Entries di Kiri & Search di Kanan (DataTables Style) -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
                <!-- Dropdown Show Entries -->
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                    <span>Show</span>
                    <select id="select-per-page-dip" onchange="changePerPageDip(this.value)" 
                            class="px-3 py-1.5 bg-white border border-slate-900 rounded-2xl text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                        <option value="10" <?php echo e((int)request('per_page', 10) === 10 ? 'selected' : ''); ?>>10</option>
                        <option value="25" <?php echo e((int)request('per_page', 10) === 25 ? 'selected' : ''); ?>>25</option>
                        <option value="50" <?php echo e((int)request('per_page', 10) === 50 ? 'selected' : ''); ?>>50</option>
                        <option value="100" <?php echo e((int)request('per_page', 10) === 100 ? 'selected' : ''); ?>>100</option>
                    </select>
                    <span>entries</span>
                </div>

                <!-- Search Bar Pencarian Seluruh Isi Tabel (Format DataTables Style: Search: [_____ x]) -->
                <form id="form-search-dip" onsubmit="event.preventDefault();" class="flex items-center gap-2">
                    <label for="input-search-dip" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">
                        Search:
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="input-search-dip"
                               value="<?php echo e(request('search')); ?>" 
                               autocomplete="off"
                               oninput="debounceSearchDip()"
                               class="w-48 sm:w-56 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-2xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                        <button type="button" id="btn-clear-search" onclick="clearSearchDip()" title="Hapus pencarian" 
                                class="<?php echo e(request('search') ? '' : 'hidden'); ?> absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabel Informasi Publik dengan Filter Terpadu (Akses Hanya Tautan Berkas) -->
            <div id="table-dip-wrapper" class="relative transition-opacity duration-150">
                <?php if (isset($component)) { $__componentOriginale470d041fb0fe925f37f2c26455327c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale470d041fb0fe925f37f2c26455327c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.informasi_publik.table','data' => ['informasi' => $informasiList,'listJenis' => $listJenis ?? [],'listTahun' => $listTahun ?? [],'listSatker' => $listSatker ?? [],'listBentuk' => $listBentuk ?? [],'listRetensi' => $listRetensi ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.informasi_publik.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['informasi' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($informasiList),'listJenis' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listJenis ?? []),'listTahun' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listTahun ?? []),'listSatker' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listSatker ?? []),'listBentuk' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listBentuk ?? []),'listRetensi' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRetensi ?? [])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale470d041fb0fe925f37f2c26455327c7)): ?>
<?php $attributes = $__attributesOriginale470d041fb0fe925f37f2c26455327c7; ?>
<?php unset($__attributesOriginale470d041fb0fe925f37f2c26455327c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale470d041fb0fe925f37f2c26455327c7)): ?>
<?php $component = $__componentOriginale470d041fb0fe925f37f2c26455327c7; ?>
<?php unset($__componentOriginale470d041fb0fe925f37f2c26455327c7); ?>
<?php endif; ?>
            </div>

            <!-- Card Bantuan / Ajukan Permohonan Jika Tidak Menemukan Informasi -->
            <div class="bg-gradient-to-r from-sky-600 via-sky-700 to-blue-800 text-white rounded-2xl p-6 shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="space-y-1 text-center sm:text-left">
                    <h4 class="font-extrabold text-base sm:text-lg">Tidak Menemukan Informasi yang Anda Cari?</h4>
                    <p class="text-xs sm:text-sm text-sky-100">
                        Anda dapat mengajukan permohonan informasi publik secara online melalui formulir permohonan resmi PPID FMIPA Unila.
                    </p>
                </div>
                <a href="<?php echo e(url('/permohonan')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-sky-700 hover:bg-sky-50 font-extrabold text-xs sm:text-sm rounded-xl transition shadow-sm cursor-pointer shrink-0 whitespace-nowrap">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <span>Ajukan Permohonan</span>
                </a>
            </div>

        </div>
    </div>

</main>

<!-- Helper Script Scroll & Click Counter -->
<?php if (isset($component)) { $__componentOriginal76773e8a6e7d9fadd2e5d9a9a688857a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal76773e8a6e7d9fadd2e5d9a9a688857a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.masyarakat.informasi_publik.script','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('masyarakat.informasi_publik.script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal76773e8a6e7d9fadd2e5d9a9a688857a)): ?>
<?php $attributes = $__attributesOriginal76773e8a6e7d9fadd2e5d9a9a688857a; ?>
<?php unset($__attributesOriginal76773e8a6e7d9fadd2e5d9a9a688857a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal76773e8a6e7d9fadd2e5d9a9a688857a)): ?>
<?php $component = $__componentOriginal76773e8a6e7d9fadd2e5d9a9a688857a; ?>
<?php unset($__componentOriginal76773e8a6e7d9fadd2e5d9a9a688857a); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('components.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/masyarakat/informasi_publik/index.blade.php ENDPATH**/ ?>