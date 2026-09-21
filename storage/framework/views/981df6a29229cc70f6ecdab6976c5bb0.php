<?php $__env->startSection('title', 'Daftar Informasi Publik (DIP) - Admin PPID'); ?>
<?php $__env->startSection('header_title', 'Daftar Informasi Publik (DIP)'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Section Header: Dinamis sesuai Klasifikasi yang Dipilih -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                <?php echo e(request('kategori') ? request('kategori') : 'Daftar Informasi Publik'); ?>

            </h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">
                <?php if(request('kategori')): ?>
                    Kelola rincian informasi dan sub informasi untuk klasifikasi <?php echo e(request('kategori')); ?>

                <?php else: ?>
                    Kelola dan publikasikan informasi publik PPID FMIPA Universitas Lampung
                <?php endif; ?>
            </p>
        </div>

            <!-- Tombol Aksi Header (Cetak PDF & Tambah) -->
            <div class="flex items-center gap-2.5 shrink-0">
                <!-- Tombol Export PDF Sesuai Kategori, Filter, dan Sort Header Aktif -->
                <a id="btn-export-pdf" href="<?php echo e(route('admin.export.informasi.pdf', request()->only(['kategori', 'tahun', 'satker', 'search', 'sort_by', 'sort_direction']))); ?>" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                    <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i>
                    <span>Export PDF</span>
                </a>

                <!-- Tombol Export Excel/CSV Sesuai Kategori, Filter, dan Sort Header Aktif -->
                <a id="btn-export-excel" href="<?php echo e(route('admin.export.informasi.excel', request()->only(['kategori', 'tahun', 'satker', 'search', 'sort_by', 'sort_direction']))); ?>" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-emerald-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                    <i class="fa-solid fa-file-excel text-emerald-600 text-sm"></i>
                    <span>Export Excel</span>
                </a>

                <!-- Tombol Tambah Utama -->
                <button type="button" onclick="openModalCreate()" 
                        class="inline-flex items-center justify-center gap-2.5 px-5 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer">
                    <i class="fa-solid fa-plus text-sm"></i>
                    <span>Tambah</span>
                </button>
            </div>
    </div>

    <!-- Bar Kontrol Tabel: Mode Pilih & Show Entries di Kiri, Search di Kanan -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 w-full">
        <!-- Sisi Kiri: Tombol Mode Pilih, Tombol Hapus Bulk, dan Show Entries Dropdown -->
        <div class="flex items-center gap-3 flex-wrap">
            <!-- Tombol Mode Hapus -->
            <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition shadow-2xs hover:shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-list-check"></i> <span id="text-select-mode">Hapus</span>
            </button>

            <!-- Tombol Hapus Bulk (Muncul saat mode pilih aktif & ada item dicentang) -->
            <button type="button" id="btn-bulk-delete" onclick="triggerBulkDelete()"
                    class="hidden inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-2xl transition shadow-xs cursor-pointer shrink-0 whitespace-nowrap">
                <i class="fa-solid fa-trash"></i> <span>Hapus (<span id="selected-count">0</span>) data terpilih</span>
            </button>

            <!-- Dropdown Show Entries -->
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-800">
                <span>Show</span>
                <select id="select-per-page-admin-dip" onchange="changePerPageAdminDip(this.value)" 
                        class="px-3 py-1.5 bg-white border border-slate-900 rounded-2xl text-xs sm:text-sm font-bold text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs cursor-pointer">
                    <option value="10" <?php echo e((int)request('per_page', 10) === 10 ? 'selected' : ''); ?>>10</option>
                    <option value="25" <?php echo e((int)request('per_page', 10) === 25 ? 'selected' : ''); ?>>25</option>
                    <option value="50" <?php echo e((int)request('per_page', 10) === 50 ? 'selected' : ''); ?>>50</option>
                    <option value="100" <?php echo e((int)request('per_page', 10) === 100 ? 'selected' : ''); ?>>100</option>
                </select>
                <span>entries</span>
            </div>
        </div>

        <!-- Sisi Kanan: Search Bar Pencarian Seluruh Isi Tabel (Format DataTables: Search: [_____ x]) -->
        <form id="form-search-admin-dip" onsubmit="event.preventDefault();" class="flex items-center gap-2">
            <label for="input-search-admin-dip" class="text-sm font-semibold text-slate-800 select-none cursor-pointer">
                Search:
            </label>
            <div class="relative">
                <input type="text" 
                       name="search" 
                       id="input-search-admin-dip"
                       value="<?php echo e(request('search')); ?>" 
                       autocomplete="off"
                       oninput="debounceSearchAdminDip()"
                       class="w-48 sm:w-56 pl-3.5 pr-8 py-1.5 text-sm bg-white border border-slate-900 rounded-2xl text-slate-900 focus:outline-none focus:ring-1 focus:ring-slate-900 shadow-2xs">
                <button type="button" id="btn-clear-search-admin-dip" onclick="clearSearchAdminDip()" title="Hapus pencarian" 
                        class="<?php echo e(request('search') ? '' : 'hidden'); ?> absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 transition font-bold text-xs flex items-center justify-center cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Container & Data Tabel -->
    <?php if (isset($component)) { $__componentOriginal4e54bfa09d6d407e669b3077e7e173e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e54bfa09d6d407e669b3077e7e173e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.informasi_publik.table','data' => ['informasi' => $informasi,'listJenis' => $listJenis ?? [],'listTahun' => $listTahun,'listSatker' => $listSatker,'listBentuk' => $listBentuk ?? [],'listRetensi' => $listRetensi ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.informasi_publik.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['informasi' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($informasi),'listJenis' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listJenis ?? []),'listTahun' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listTahun),'listSatker' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listSatker),'listBentuk' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listBentuk ?? []),'listRetensi' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRetensi ?? [])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4e54bfa09d6d407e669b3077e7e173e7)): ?>
<?php $attributes = $__attributesOriginal4e54bfa09d6d407e669b3077e7e173e7; ?>
<?php unset($__attributesOriginal4e54bfa09d6d407e669b3077e7e173e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4e54bfa09d6d407e669b3077e7e173e7)): ?>
<?php $component = $__componentOriginal4e54bfa09d6d407e669b3077e7e173e7; ?>
<?php unset($__componentOriginal4e54bfa09d6d407e669b3077e7e173e7); ?>
<?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
<?php if (isset($component)) { $__componentOriginal005b20d902616bd5c696c1c04eff5adf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal005b20d902616bd5c696c1c04eff5adf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.informasi_publik.modal-add-edit','data' => ['listRincian' => $listRincian ?? [],'listRincianBerkala' => $listRincianBerkala ?? [],'listRincianSetiapSaat' => $listRincianSetiapSaat ?? [],'listRincianSertaMerta' => $listRincianSertaMerta ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.informasi_publik.modal-add-edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listRincian' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincian ?? []),'listRincianBerkala' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianBerkala ?? []),'listRincianSetiapSaat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianSetiapSaat ?? []),'listRincianSertaMerta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianSertaMerta ?? [])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal005b20d902616bd5c696c1c04eff5adf)): ?>
<?php $attributes = $__attributesOriginal005b20d902616bd5c696c1c04eff5adf; ?>
<?php unset($__attributesOriginal005b20d902616bd5c696c1c04eff5adf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal005b20d902616bd5c696c1c04eff5adf)): ?>
<?php $component = $__componentOriginal005b20d902616bd5c696c1c04eff5adf; ?>
<?php unset($__componentOriginal005b20d902616bd5c696c1c04eff5adf); ?>
<?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if (isset($component)) { $__componentOriginal8faaee0fb911f36987939f0c6667044a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8faaee0fb911f36987939f0c6667044a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.informasi_publik.script','data' => ['listRincianBerkala' => $listRincianBerkala ?? [],'listRincianSetiapSaat' => $listRincianSetiapSaat ?? [],'listRincianSertaMerta' => $listRincianSertaMerta ?? [],'listRincian' => $listRincian ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.informasi_publik.script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listRincianBerkala' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianBerkala ?? []),'listRincianSetiapSaat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianSetiapSaat ?? []),'listRincianSertaMerta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianSertaMerta ?? []),'listRincian' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincian ?? [])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8faaee0fb911f36987939f0c6667044a)): ?>
<?php $attributes = $__attributesOriginal8faaee0fb911f36987939f0c6667044a; ?>
<?php unset($__attributesOriginal8faaee0fb911f36987939f0c6667044a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8faaee0fb911f36987939f0c6667044a)): ?>
<?php $component = $__componentOriginal8faaee0fb911f36987939f0c6667044a; ?>
<?php unset($__componentOriginal8faaee0fb911f36987939f0c6667044a); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('components.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/admin/informasi_publik/index.blade.php ENDPATH**/ ?>