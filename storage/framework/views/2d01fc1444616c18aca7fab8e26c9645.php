<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['keberatans']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['keberatans']); ?>
<?php foreach (array_filter((['keberatans']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<!-- Table Container -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Filter & Action Bar Header -->
    <div class="p-6 border-b border-slate-100">
        <form id="filter-search-form" action="<?php echo e(route('admin.keberatan.index')); ?>" method="GET" class="flex flex-col lg:flex-row lg:items-center justify-between gap-3.5 w-full">
            <?php if(request('status')): ?>
                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
            <?php endif; ?>

            <!-- Sisi Kiri: Tombol Pilih & Pill Filter Status -->
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" id="btn-toggle-select" onclick="toggleSelectMode()"
                            class="inline-flex items-center justify-center gap-2 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs md:text-sm font-extrabold rounded-xl transition cursor-pointer h-10 whitespace-nowrap">
                        <i class="fa-solid fa-list-check"></i> <span id="text-select-mode">Hapus</span>
                    </button>

                    <button type="button" id="btn-bulk-delete" onclick="triggerBulkDelete()"
                            class="hidden inline-flex items-center justify-center gap-2 px-4 bg-rose-600 hover:bg-rose-700 text-white text-xs md:text-sm font-extrabold rounded-xl transition shadow-xs cursor-pointer h-10 whitespace-nowrap">
                        <i class="fa-solid fa-trash"></i> <span>Hapus (<span id="selected-count">0</span>)</span>
                    </button>
                </div>

                <div class="flex items-center gap-1 bg-slate-100/80 p-1 rounded-xl border border-slate-200/50 overflow-x-auto max-w-full">
                    <a href="<?php echo e(route('admin.keberatan.index')); ?>" 
                       class="px-3 py-1.5 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap <?php echo e(!request('status') || request('status') == 'Semua' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
                        Semua
                    </a>
                    <a href="<?php echo e(route('admin.keberatan.index', array_merge(request()->query(), ['status' => 'Diajukan']))); ?>" 
                       class="px-3 py-1.5 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap <?php echo e(request('status') == 'Diajukan' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
                        Diajukan
                    </a>
                    <a href="<?php echo e(route('admin.keberatan.index', array_merge(request()->query(), ['status' => 'Diproses']))); ?>" 
                       class="px-3 py-1.5 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap <?php echo e(request('status') == 'Diproses' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
                        Diproses
                    </a>
                    <a href="<?php echo e(route('admin.keberatan.index', array_merge(request()->query(), ['status' => 'Selesai']))); ?>" 
                       class="px-3 py-1.5 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap <?php echo e(request('status') == 'Selesai' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
                        Selesai
                    </a>
                    <a href="<?php echo e(route('admin.keberatan.index', array_merge(request()->query(), ['status' => 'Ditolak']))); ?>" 
                       class="px-3 py-1.5 rounded-lg text-xs md:text-sm transition-all duration-200 whitespace-nowrap <?php echo e(request('status') == 'Ditolak' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-500 font-bold hover:text-slate-900'); ?>">
                        Ditolak
                    </a>
                </div>
            </div>

            <!-- Sisi Kanan: Search Bar & Tombol Cari Fleksibel -->
            <div class="flex items-center gap-2 flex-1 lg:max-w-[480px] w-full">
                <div class="flex-1 min-w-0 h-10 relative">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari tiket keberatan, nama, NIK..." class="w-full h-full px-3.5 bg-slate-50 border border-slate-200 text-xs md:text-sm font-semibold text-slate-800 placeholder-slate-400 rounded-xl focus:outline-none focus:bg-white focus:border-sky-500 transition-all shadow-xs" autocomplete="off">
                </div>

                <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs md:text-sm font-extrabold rounded-xl transition cursor-pointer shadow-xs h-10 shrink-0 whitespace-nowrap">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i> <span>Cari</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Form Bulk Delete Tersembunyi -->
    <form id="form-bulk-delete" action="<?php echo e(route('admin.keberatan.bulk')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>

        <!-- Tabel Data Pengajuan Keberatan -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-sky-500 text-white text-xs md:text-sm font-extrabold tracking-wide whitespace-nowrap">
                        <th id="col-checkbox-header" class="hidden px-4 py-4 w-10 text-center">
                            <input type="checkbox" id="check-all" onclick="toggleCheckAll(this)" class="w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer">
                        </th>
                        <th class="px-6 py-4 whitespace-nowrap">No. Tiket</th>
                        <th class="px-6 py-4 whitespace-nowrap">Pemohon</th>
                        <th class="px-6 py-4 whitespace-nowrap">Tgl. Pengajuan</th>
                        <th class="px-6 py-4 whitespace-nowrap">Alasan Keberatan</th>
                        <th class="px-6 py-4 whitespace-nowrap text-center">Status</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-xs sm:text-sm font-medium text-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $keberatans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-sky-50/70 transition-colors">
                            <td class="col-checkbox-cell hidden px-4 py-2.5 text-center">
                                <input type="checkbox" name="ids[]" form="form-bulk-delete" value="<?php echo e($item->id); ?>" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                            </td>

                            <td class="px-6 py-2.5 font-black text-slate-600 whitespace-nowrap">
                                <?php echo e($item->no_tiket ?? '-'); ?>

                            </td>

                            <td class="px-6 py-2.5">
                                <div class="text-xs md:text-sm font-extrabold text-slate-900"><?php echo e($item->permohonan->nama_lengkap ?? ($item->user->nama_lengkap ?? '-')); ?></div>
                                <div class="text-xs text-slate-400 font-semibold">NIK: <?php echo e($item->permohonan->no_identitas ?? '-'); ?></div>
                            </td>

                            <td class="px-6 py-2.5 text-slate-500 whitespace-nowrap font-semibold">
                                <?php echo e($item->created_at ? $item->created_at->translatedFormat('d M Y') : '-'); ?>

                            </td>

                            <td class="px-6 py-2.5 font-semibold text-slate-700 min-w-[14rem] max-w-md whitespace-normal break-words leading-relaxed" title="<?php echo e($item->alasan_keberatan); ?>">
                                <?php echo e($item->alasan_keberatan ?? '-'); ?>

                            </td>

                            <td class="px-6 py-2.5 text-center whitespace-nowrap">
                                <?php if($item->status === 'Diajukan' || $item->status === 'Menunggu'): ?>
                                    <span class="inline-block px-3.5 py-1 text-xs font-extrabold bg-slate-100 text-slate-700 rounded-lg border border-slate-200">
                                        Diajukan
                                    </span>
                                <?php elseif($item->status === 'Perlu Tindakan' || $item->status === 'Diproses' || $item->status === 'Proses'): ?>
                                    <span class="inline-block px-3.5 py-1 text-xs font-extrabold bg-amber-50 text-amber-700 rounded-lg border border-amber-200">
                                        Diproses
                                    </span>
                                <?php elseif($item->status === 'Terima' || $item->status === 'Selesai' || $item->status === 'Disetujui'): ?>
                                     <span class="inline-block px-3.5 py-1 text-xs font-extrabold bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-200">
                                         Selesai
                                     </span>
                                 <?php elseif($item->status === 'Ditolak'): ?>
                                     <span class="inline-block px-3.5 py-1 text-xs font-extrabold bg-rose-50 text-rose-700 rounded-lg border border-rose-200">
                                         Ditolak
                                     </span>
                                 <?php endif; ?>
                             </td>
                             <td class="px-6 py-2.5 text-center whitespace-nowrap">
                                 <div class="flex items-center justify-center gap-2">
                                     <?php
                                         $statusAwal = $item->status;
                                     ?>

                                     <?php if($statusAwal === 'Diajukan' || $statusAwal === 'Menunggu'): ?>
                                         <a href="<?php echo e(route('admin.keberatan.show', $item->id)); ?>"
                                            class="w-8 h-8 flex items-center justify-center rounded-xl text-amber-700 bg-amber-50 hover:bg-amber-500 hover:text-white transition cursor-pointer shadow-2xs border border-amber-200"
                                            title="Proses Keberatan">
                                             <i class="fa-solid fa-gears text-xs"></i>
                                         </a>
                                     <?php elseif($statusAwal === 'Perlu Tindakan' || $statusAwal === 'Diproses' || $statusAwal === 'Proses'): ?>
                                         <a href="<?php echo e(route('admin.keberatan.show', $item->id)); ?>"
                                            class="w-8 h-8 flex items-center justify-center rounded-xl text-sky-700 bg-sky-50 hover:bg-sky-500 hover:text-white transition cursor-pointer shadow-2xs border border-sky-200"
                                            title="Tindaklanjuti">
                                             <i class="fa-solid fa-reply text-xs"></i>
                                         </a>
                                     <?php else: ?>
                                         <a href="<?php echo e(route('admin.keberatan.show', $item->id)); ?>"
                                            class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-500 bg-slate-100 hover:bg-slate-200 hover:text-slate-800 transition cursor-pointer shadow-2xs border border-slate-200"
                                            title="Lihat Detail">
                                             <i class="fa-solid fa-eye text-xs"></i>
                                         </a>
                                     <?php endif; ?>

                                     <button type="button" onclick="triggerDelete('<?php echo e(route('admin.keberatan.destroy', $item->id)); ?>', '<?php echo e(addslashes($item->no_tiket ?? $item->id)); ?>')"
                                             class="w-8 h-8 flex items-center justify-center rounded-xl text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white transition cursor-pointer shadow-2xs border border-rose-200"
                                             title="Hapus Data Keberatan">
                                         <i class="fa-solid fa-trash text-xs"></i>
                                     </button>
                                 </div>
                             </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-semibold">
                                Tidak ada data pengajuan keberatan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>

    <!-- Pagination Footer -->
    <div class="p-6 border-t border-slate-100">
        <?php if (isset($component)) { $__componentOriginal4d04f29578652eb91560cfbf2ab48c57 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4d04f29578652eb91560cfbf2ab48c57 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.pagination','data' => ['paginator' => $keberatans,'label' => 'pengajuan keberatan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ui.pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($keberatans),'label' => 'pengajuan keberatan']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4d04f29578652eb91560cfbf2ab48c57)): ?>
<?php $attributes = $__attributesOriginal4d04f29578652eb91560cfbf2ab48c57; ?>
<?php unset($__attributesOriginal4d04f29578652eb91560cfbf2ab48c57); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4d04f29578652eb91560cfbf2ab48c57)): ?>
<?php $component = $__componentOriginal4d04f29578652eb91560cfbf2ab48c57; ?>
<?php unset($__componentOriginal4d04f29578652eb91560cfbf2ab48c57); ?>
<?php endif; ?>
    </div>
</div>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/admin/keberatan/table.blade.php ENDPATH**/ ?>