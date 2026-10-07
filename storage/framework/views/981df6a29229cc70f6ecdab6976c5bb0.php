<?php $__env->startSection('title', 'Daftar Informasi Publik (DIP) - Admin PPID'); ?>
<?php $__env->startSection('header_title', 'Daftar Informasi Publik (DIP)'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <!-- Section Header: Dinamis sesuai Klasifikasi yang Dipilih -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">
                Daftar Informasi Publik
            </h1>
            <p class="text-xs md:text-sm font-semibold text-slate-400 mt-1">
                Kelola dan publikasikan informasi publik PPID FMIPA Universitas Lampung
            </p>
        </div>

            <!-- Tombol Aksi Header (Export & Tambah) -->
            <div class="flex items-center gap-2.5 shrink-0">
                <!-- Tombol Export Sesuai Kategori, Filter, dan Sort Header Aktif -->
                <a id="btn-export-pdf" href="<?php echo e(route('admin.export.informasi.pdf', request()->only(['kategori', 'tahun', 'satker', 'search', 'sort_by', 'sort_direction']))); ?>" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs md:text-sm font-extrabold rounded-2xl transition-all shadow-2xs hover:shadow-xs cursor-pointer">
                    <i class="fa-solid fa-file-pdf text-rose-500 text-sm"></i>
                    <span>Export</span>
                </a>

                <!-- Tombol Tambah Utama -->
                <button type="button" onclick="openModalCreate()" 
                        class="inline-flex items-center justify-center gap-2.5 px-5 py-3 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-2xl transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer">
                    <i class="fa-solid fa-plus text-sm"></i>
                    <span>Tambah</span>
                </button>
            </div>
    </div>

    <form id="form-bulk-delete" action="<?php echo e(route('admin.informasi.bulk')); ?>" method="POST" class="hidden">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <div id="bulk-selected-inputs"></div>
    </form>

    <!-- Kontrol pemilihan berlaku untuk semua tabel kategori -->
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

    </div>

    <?php
        $jenisPublik = [
            ['nama' => 'Informasi Berkala', 'judul' => 'Informasi Publik yang Wajib Disediakan secara Berkala', 'key' => 'berkala', 'deskripsi' => 'informasi yang wajib disediakan secara berkala.'],
            ['nama' => 'Informasi Setiap Saat', 'judul' => 'Informasi Publik yang Wajib Tersedia Setiap Saat', 'key' => 'setiap-saat', 'deskripsi' => 'informasi yang tersedia untuk diakses setiap saat.'],
            ['nama' => 'Informasi Serta-Merta', 'judul' => 'Informasi Publik yang Wajib Diumumkan secara Serta-Merta', 'key' => 'serta-merta', 'deskripsi' => 'informasi yang wajib diumumkan segera.'],
        ];
    ?>

    <?php $selectedKategori = trim((string) request()->query('kategori', '')); ?>
    <div class="space-y-10">
        <?php $__currentLoopData = $jenisPublik; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($selectedKategori === '' || mb_strtolower($selectedKategori) === mb_strtolower($jenis['nama'])): ?>
            <?php $daftarJenis = $informasiGroups->get($jenis['nama'], collect()); ?>
            <section class="space-y-4" aria-labelledby="judul-admin-<?php echo e($jenis['key']); ?>">
                <header class="space-y-1">
                    <h2 id="judul-admin-<?php echo e($jenis['key']); ?>" class="text-xl md:text-2xl font-extrabold text-slate-900"><?php echo e($jenis['judul']); ?></h2>
                    <p class="text-sm md:text-base text-slate-600"><?php echo e(number_format($daftarJenis->count(), 0, ',', '.')); ?> informasi <?php echo e($jenis['deskripsi']); ?></p>
                </header>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-800">Tampilkan
                        <select data-admin-dip-per-page="<?php echo e($jenis['key']); ?>" onchange="changePerPageAdminDip('<?php echo e($jenis['key']); ?>', this.value)" class="px-3 py-1.5 bg-white border border-slate-300 rounded-lg text-sm font-bold text-slate-900">
                            <option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                        </select> baris
                    </label>
                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-800">Cari:
                        <input data-admin-dip-search="<?php echo e($jenis['key']); ?>" oninput="searchAdminDipTable('<?php echo e($jenis['key']); ?>', this.value)" value="<?php echo e(request('search')); ?>" class="w-48 sm:w-64 px-3 py-2 bg-white border border-slate-300 rounded-lg text-sm font-normal focus:outline-none focus:ring-2 focus:ring-sky-500/30">
                    </label>
                </div>

                <?php if (isset($component)) { $__componentOriginal4e54bfa09d6d407e669b3077e7e173e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4e54bfa09d6d407e669b3077e7e173e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.informasi_publik.table','data' => ['informasi' => $daftarJenis,'tableKey' => $jenis['key'],'forceTable' => $selectedKategori === '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.informasi_publik.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['informasi' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($daftarJenis),'table-key' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($jenis['key']),'force-table' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedKategori === '')]); ?>
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
            </section>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
<?php if (isset($component)) { $__componentOriginal005b20d902616bd5c696c1c04eff5adf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal005b20d902616bd5c696c1c04eff5adf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.informasi_publik.modal-add-edit','data' => ['listRincian' => $listRincian ?? [],'listRincianBerkala' => $listRincianBerkala ?? [],'listRincianSetiapSaat' => $listRincianSetiapSaat ?? [],'listRincianSertaMerta' => $listRincianSertaMerta ?? [],'listJudul' => $listJudul ?? [],'listSatker' => $listSatker ?? [],'listPenanggungJawab' => $listPenanggungJawab ?? [],'listTahun' => $listTahun ?? [],'listRetensi' => $listRetensi ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.informasi_publik.modal-add-edit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listRincian' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincian ?? []),'listRincianBerkala' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianBerkala ?? []),'listRincianSetiapSaat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianSetiapSaat ?? []),'listRincianSertaMerta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianSertaMerta ?? []),'listJudul' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listJudul ?? []),'listSatker' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listSatker ?? []),'listPenanggungJawab' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listPenanggungJawab ?? []),'listTahun' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listTahun ?? []),'listRetensi' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRetensi ?? [])]); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if (isset($component)) { $__componentOriginal8faaee0fb911f36987939f0c6667044a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8faaee0fb911f36987939f0c6667044a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.informasi_publik.script','data' => ['listRincianBerkala' => $listRincianBerkala ?? [],'listRincianSetiapSaat' => $listRincianSetiapSaat ?? [],'listRincianSertaMerta' => $listRincianSertaMerta ?? [],'listRincian' => $listRincian ?? [],'listSubByRincian' => $listSubByRincian ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.informasi_publik.script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['listRincianBerkala' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianBerkala ?? []),'listRincianSetiapSaat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianSetiapSaat ?? []),'listRincianSertaMerta' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincianSertaMerta ?? []),'listRincian' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listRincian ?? []),'listSubByRincian' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($listSubByRincian ?? [])]); ?>
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