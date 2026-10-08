<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['informasi', 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => [], 'tableKey' => 'main', 'forceTable' => false, 'unified' => false]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['informasi', 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => [], 'tableKey' => 'main', 'forceTable' => false, 'unified' => false]); ?>
<?php foreach (array_filter((['informasi', 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => [], 'tableKey' => 'main', 'forceTable' => false, 'unified' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<!-- Table Container -->
<div class="bg-white <?php echo e(($unified && request('kategori') === '') ? 'rounded-2xl' : (request('kategori') === 'Informasi Serta-Merta' ? 'rounded-none' : 'rounded-2xl')); ?> border border-slate-200/80 shadow-xs overflow-hidden">
        <?php
            $isUnified = (bool) $unified;
            $isKategoriMode = !$isUnified && request()->filled('kategori') && !$forceTable;
            $isSertaMertaCategory = $isKategoriMode && request('kategori') === 'Informasi Serta-Merta';
            $curSortBy = request('sort_by');
            $curSortDir = request('sort_direction', 'asc');
        ?>

        <?php
            $isSertaMertaMode = $isSertaMertaCategory;
        ?>

        <?php if($isSertaMertaMode): ?>
            <!-- Tampilan Card List Serta-Merta (Sesuai Desain Publik / Masyarakat) dengan Kontrol Admin -->
            <div class="p-8 space-y-3">
                <!-- Checkbox Pilih Semua Khusus Mode Serta-Merta -->
                <div id="col-checkbox-header-<?php echo e($tableKey); ?>" class="col-checkbox-header hidden flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 select-none">
                    <input type="checkbox" class="check-all w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-0 cursor-pointer" onclick="toggleCheckAll(this)">
                    <label class="cursor-pointer">Pilih Semua Pengumuman</label>
                </div>

                <!-- Container Card List Serta-Merta -->
                <div id="container-admin-serta-merta" data-admin-dip-tbody="<?php echo e($tableKey); ?>" data-category-mode="true" data-serta-merta-table="true" data-category-table="false" class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $informasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                            $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                            $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                ? $item->link_informasi 
                                : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName).'?from_admin=1') : null);
                            $tglPembuatan = $item->created_at ? $item->created_at->translatedFormat('d F Y') : '-';
                        ?>
                        <div class="table-admin-dip-row card-admin-serta-merta group/card flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 sm:p-6 rounded-none border border-slate-200/80 bg-white hover:bg-sky-50/40 hover:border-sky-200 transition-all duration-200"
                             data-id="<?php echo e($item->id); ?>"
                             data-no="<?php echo e($idx + 1); ?>"
                             data-dilihat="<?php echo e((int)($item->dilihat ?? 0)); ?>"
                             data-tanggal="<?php echo e($item->created_at?->timestamp ?? ''); ?>"
                             data-rincian="<?php echo e(strtolower($item->rincian_informasi ?? '')); ?>"
                             data-sub_informasi="<?php echo e(strtolower($item->sub_informasi ?? '')); ?>"
                             data-ringkasan="<?php echo e(strtolower($item->sub_informasi ?? '')); ?>"
                             data-pejabat="<?php echo e(strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '')); ?>"
                             data-waktu="<?php echo e(strtolower($tglPembuatan)); ?>"
                             data-retensi="<?php echo e(strtolower($item->retensi_arsip ?? '')); ?>"
                             data-bentuk="<?php echo e(strtolower($item->bentuk_informasi_yang_tersedia ?? '')); ?>">
                            
                            <div class="flex items-start gap-3.5 flex-1 min-w-0">
                                <!-- Checkbox Mode Hapus -->
                                <div class="col-checkbox-cell hidden pt-1 shrink-0">
                                    <input type="checkbox" value="<?php echo e($item->id); ?>" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                                </div>

                                <!-- Megaphone Icon -->
                                <div class="w-11 h-11 rounded-xl bg-sky-100/70 text-sky-600 flex items-center justify-center shrink-0 group-hover/card:bg-sky-500 group-hover/card:text-white transition-colors duration-200 mt-0.5">
                                    <i class="fa-solid fa-bullhorn text-sm"></i>
                                </div>

                                <!-- Text Content -->
                                <div class="space-y-1 flex-1 min-w-0">
                                    <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover/card:text-sky-600 transition-colors leading-snug break-words">
                                        <?php echo e($item->sub_informasi); ?>

                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400 font-semibold">
                                        <span class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar text-[11px]"></i>
                                            <span><?php echo e($tglPembuatan); ?></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Lihat dan aksi pengelolaan admin -->
                            <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                <?php if($fileTargetUrl): ?>
                                    <a href="<?php echo e($fileTargetUrl); ?>" target="_blank" 
                                       title="Lihat Berkas" aria-label="Lihat Berkas"
                                       class="inline-flex h-8 w-8 items-center justify-center bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white rounded-xl transition cursor-pointer">
                                        <i class="fa-regular fa-eye text-sm"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-xs font-semibold text-slate-400 italic px-3 py-1.5 bg-slate-100">Dokumen Belum Ada</span>
                                <?php endif; ?>

                                <button type="button" onclick="editData(<?php echo e(json_encode($item)); ?>)" title="Edit Pengumuman" 
                                        class="inline-flex h-8 w-8 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white rounded-xl transition cursor-pointer">
                                    <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                                </button>

                                <button type="button" onclick="triggerDelete('<?php echo e(url('/admin/informasi-publik/'.$item->id)); ?>', '<?php echo e(addslashes($item->sub_informasi)); ?>')" title="Hapus Pengumuman" 
                                        class="inline-flex h-8 w-8 items-center justify-center text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-xl transition cursor-pointer">
                                    <i class="fa-solid fa-trash text-[11px]"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-12 text-center text-slate-400 font-semibold bg-slate-50/50 border border-dashed border-slate-200">
                            Belum ada Informasi Serta-Merta yang ditambahkan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Tabel Daftar Informasi Publik — horizontal scroll on mobile -->
            <div class="overflow-x-auto -webkit-overflow-scrolling-touch">
                <table class="w-full <?php echo e($isKategoriMode ? 'min-w-0 table-fixed' : 'min-w-[1200px] table-auto'); ?> text-left border-collapse border border-slate-200">
                    <thead>
                        <?php if($isUnified): ?>
                        <tr class="bg-sky-500 text-white text-xs sm:text-sm md:text-lg font-black tracking-tight text-center leading-snug select-none">
                            <th id="col-checkbox-header-<?php echo e($tableKey); ?>" class="col-checkbox-header hidden px-1 py-3 w-10 text-center">
                                <input type="checkbox" class="check-all w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer" onclick="toggleCheckAll(this)">
                            </th>
                            <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'no')" class="px-2 py-3 text-center w-12 min-w-[48px] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
                                <div class="flex items-center justify-center gap-1.5">
                                    <span>No</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'ringkasan')" class="px-3.5 py-3 text-left min-w-[300px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Ringkasan Isi Informasi">
                                <div class="flex items-center justify-between gap-1.5">
                                    <span>Ringkasan Isi Informasi</span>
                                    <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                        <i class="fa-solid fa-sort"></i>
                                    </span>
                                </div>
                            </th>
                            <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'pejabat')" class="px-3.5 py-3 text-left min-w-[210px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Pejabat/Unit yang Menguasai Informasi">
                                <div class="flex items-center justify-between gap-1.5"><span>Pejabat/Unit yang Menguasai Informasi</span><span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span></div>
                            </th>
                            <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'penanggung_jawab')" class="px-3.5 py-3 text-left min-w-[180px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Penanggung Jawab"><div class="flex items-center justify-between gap-1.5"><span>Penanggung Jawab</span><span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span></div></th>
                            <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'waktu')" class="px-3.5 py-3 text-left min-w-[170px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Waktu dan Tempat Pembuatan"><div class="flex items-center justify-between gap-1.5"><span>Waktu dan Tempat Pembuatan</span><span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span></div></th>
                            <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'bentuk')" class="px-3 py-3 text-center min-w-[120px] cursor-pointer hover:bg-sky-600/60 transition group"><div class="flex items-center justify-center gap-1.5"><span>Format</span><span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span></div></th>
                            <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'retensi')" class="px-3 py-3 text-center min-w-[140px] cursor-pointer hover:bg-sky-600/60 transition group"><div class="flex items-center justify-center gap-1.5"><span>Retensi Arsip</span><span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition"><i class="fa-solid fa-sort"></i></span></div></th>
                            <th class="px-2 py-3 text-center w-24 min-w-[90px] shrink-0"><span>Aksi</span></th>
                        </tr>
                        <?php elseif($isKategoriMode && $isSertaMertaCategory): ?>
                            <tr class="bg-sky-500 text-white text-xs md:text-sm font-extrabold tracking-wide select-none">
                                <th id="col-checkbox-header-<?php echo e($tableKey); ?>" class="col-checkbox-header hidden px-2 py-3.5 w-12 text-center">
                                    <input type="checkbox" class="check-all w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer" onclick="toggleCheckAll(this)">
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'sub_informasi')" class="px-4 py-3.5 text-left w-[58%] cursor-pointer hover:bg-sky-600/60 transition group">
                                    <div class="flex items-center justify-between gap-1.5"><span>Informasi</span><span class="inline-flex items-center text-white/70 group-hover:text-white"><i class="fa-solid fa-sort"></i></span></div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'tanggal')" class="px-4 py-3.5 text-left w-[27%] cursor-pointer hover:bg-sky-600/60 transition group">
                                    <div class="flex items-center justify-between gap-1.5"><span>Tanggal Ditambahkan</span><span class="inline-flex items-center text-white/70 group-hover:text-white"><i class="fa-solid fa-sort"></i></span></div>
                                </th>
                                <th class="px-2 py-3.5 text-center w-[15%] min-w-[116px]">Aksi</th>
                            </tr>
                        <?php elseif($isKategoriMode): ?>
                            
                            <tr class="bg-sky-500 text-white text-xs md:text-sm font-extrabold tracking-wide select-none">
                                <th id="col-checkbox-header-<?php echo e($tableKey); ?>" class="col-checkbox-header hidden px-2 py-3.5 w-12 text-center">
                                    <input type="checkbox" class="check-all w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer" onclick="toggleCheckAll(this)">
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'rincian')" class="px-4 py-3.5 text-left w-[35%] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Rincian Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Rincian Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'sub_informasi')" class="px-4 py-3.5 text-left w-[53%] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Sub Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Sub Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'dilihat')" class="px-2 py-3.5 text-center w-[12%] min-w-[116px] cursor-pointer hover:bg-sky-600/60 transition" title="Urutkan berdasarkan akses"><div class="flex items-center justify-center gap-1"><span>Aksi</span><i class="fa-solid fa-sort text-white/70"></i></div></th>
                            </tr>
                        <?php else: ?>
                            
                            <tr class="bg-sky-500 text-white text-xs sm:text-sm md:text-lg font-black tracking-tight text-center leading-snug select-none">
                                <th id="col-checkbox-header-<?php echo e($tableKey); ?>" class="col-checkbox-header hidden px-1 py-3 w-10 text-center">
                                    <input type="checkbox" class="check-all w-4 h-4 rounded border-white/30 text-sky-600 focus:ring-0 cursor-pointer" onclick="toggleCheckAll(this)">
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'no')" class="px-2 py-3 text-center w-12 min-w-[48px] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>No</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'ringkasan')" class="px-3.5 py-3 text-left min-w-[300px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Ringkasan Isi Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Ringkasan Isi Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <?php if (! ($forceTable)): ?>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'jenis')" class="px-3.5 py-3 text-center min-w-[140px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Jenis Informasi">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Jenis Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <?php endif; ?>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'pejabat')" class="px-3.5 py-3 text-left min-w-[210px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Pejabat/Unit yang Menguasai Informasi">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Pejabat/Unit yang Menguasai Informasi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'penanggung_jawab')" class="px-3.5 py-3 text-left min-w-[180px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Penanggung Jawab">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Penanggung Jawab</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'waktu')" class="px-3.5 py-3 text-left min-w-[170px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Waktu dan Tempat Pembuatan">
                                    <div class="flex items-center justify-between gap-1.5">
                                        <span>Waktu dan Tempat Pembuatan</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'bentuk')" class="px-3 py-3 text-center min-w-[120px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Format">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Format</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'retensi')" class="px-3 py-3 text-center min-w-[140px] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Retensi Arsip">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Retensi Arsip</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                                <th onclick="sortAdminDipTable('<?php echo e($tableKey); ?>', 'dilihat')" class="px-2 py-3 text-center w-24 min-w-[90px] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan berdasarkan Akses / Sering Dilihat">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <span>Aksi</span>
                                        <span class="inline-flex items-center justify-center text-xs md:text-sm text-white/70 group-hover:text-white transition">
                                            <i class="fa-solid fa-sort"></i>
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        <?php endif; ?>
                    </thead>
            <tbody id="table-admin-dip-body-<?php echo e($tableKey); ?>" data-admin-dip-tbody="<?php echo e($tableKey); ?>" data-unified="<?php echo e($isUnified ? 'true' : 'false'); ?>" data-category-mode="<?php echo e($isKategoriMode ? 'true' : 'false'); ?>" data-serta-merta-table="<?php echo e($isSertaMertaCategory ? 'true' : 'false'); ?>" data-category-table="<?php echo e($isKategoriMode && !$isSertaMertaCategory ? 'true' : 'false'); ?>" class="<?php echo e($isUnified ? 'divide-y divide-slate-200' : ($isKategoriMode ? '' : 'divide-y divide-slate-200')); ?> text-sm md:text-base font-medium text-slate-800">
                        <?php $unifiedGroupCurrent = null; $unifiedColspan = 9; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $informasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if($isUnified && !request()->filled('kategori')): ?>
                                <?php if($unifiedGroupCurrent !== ($item->jenis_informasi ?? '')): ?>
                                    <?php
                                        $unifiedGroupCurrent = $item->jenis_informasi ?? '';
                                        $unifiedGroupLabel = match($unifiedGroupCurrent) {
                                            'Informasi Berkala' => 'Informasi Publik yang Wajib Disediakan Secara Berkala',
                                            'Informasi Setiap Saat' => 'Informasi Publik yang Wajib Tersedia Setiap Saat',
                                            'Informasi Serta-Merta' => 'Informasi Publik yang Wajib Diumumkan Secara Serta-Merta',
                                            default => \Illuminate\Support\Str::title($unifiedGroupCurrent),
                                        };
                                    ?>
                                    <tr class="table-admin-dip-group bg-sky-50/80">
                                        <td colspan="<?php echo e($unifiedColspan); ?>" class="px-4 py-3 font-black text-xs md:text-sm tracking-wide text-sky-700 border-t border-sky-100">
                                            <span class="inline-flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                                                <?php echo e($unifiedGroupLabel); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php
                                $rincianText = trim($item->rincian_informasi ?: '-');
                                $subInformasiText = trim($item->sub_informasi ?: '');
                                $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                    ? $item->link_informasi 
                                    : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName).'?from_admin=1') : null);
                            ?>
                            <tr class="table-admin-dip-row hover:bg-sky-50/70 transition-colors"
                                data-id="<?php echo e($item->id); ?>"
                                data-no="<?php echo e($idx + 1); ?>"
                                data-dilihat="<?php echo e((int)($item->dilihat ?? 0)); ?>"
                                data-rincian="<?php echo e(strtolower($rincianText)); ?>"
                                data-sub_informasi="<?php echo e(strtolower($subInformasiText)); ?>"
                                data-tanggal="<?php echo e($item->created_at?->timestamp ?? ''); ?>"
                                data-ringkasan="<?php echo e(strtolower($item->sub_informasi ?? '')); ?>"
                                data-jenis="<?php echo e(strtolower($item->jenis_informasi ?? '')); ?>"
                                data-pejabat="<?php echo e(strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '')); ?>"
                                data-penanggung_jawab="<?php echo e(strtolower($item->penanggung_jawab_pembuatan_informasi ?? '')); ?>"
                                data-waktu="<?php echo e(strtolower($item->waktu_pembuatan_informasi ?? '')); ?>"
                                data-retensi="<?php echo e(strtolower($item->retensi_arsip ?? '')); ?>"
                                data-bentuk="<?php echo e(strtolower($item->bentuk_informasi_yang_tersedia ?? '')); ?>">
                                <td class="col-checkbox-cell hidden px-2 py-3 text-center">
                                    <input type="checkbox" value="<?php echo e($item->id); ?>" onclick="updateBulkState()" class="item-checkbox w-4 h-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900 cursor-pointer">
                                </td>

                                <?php if($isUnified): ?>
                                    <td class="col-admin-dip-no px-2 py-3 text-center font-bold text-slate-400"><?php echo e($idx + 1); ?></td>
                                    <td class="px-4 py-3.5 text-slate-900 leading-normal break-words text-sm md:text-base">
                                        <?php $subValU = trim($item->sub_informasi ?: ''); ?>
                                        <div class="space-y-1">
                                            <?php if($subValU && $subValU !== 'Dokumen sedang dilengkapi unit'): ?>
                                                <div class="font-medium text-slate-900 leading-snug"><?php echo e($subValU); ?></div>
                                            <?php else: ?>
                                                <div class="font-medium text-slate-900 leading-snug">-</div>
                                                <div class="text-xs text-amber-600 font-semibold italic flex items-center gap-1"><i class="fa-regular fa-clock text-[10px]"></i><span>Dokumen sedang dilengkapi unit</span></div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 font-medium text-slate-700 text-left break-words text-sm md:text-base leading-normal"><?php echo e($item->pejabat_unit_yang_menguasai_informasi ?: '-'); ?></td>
                                    <td class="px-4 py-3.5 font-medium text-slate-700 text-left break-words text-sm md:text-base leading-normal"><?php echo e($item->penanggung_jawab_pembuatan_informasi ?: '-'); ?></td>
                                    <td class="px-4 py-3.5 text-left font-medium text-slate-700 break-words text-sm md:text-base leading-normal"><?php echo e($item->waktu_pembuatan_informasi ?: '-'); ?></td>
                                    <td class="px-3.5 py-3.5 text-left font-semibold text-slate-700 break-words text-sm md:text-base leading-normal"><?php echo e($item->bentuk_informasi_yang_tersedia ?: '-'); ?></td>
                                    <td class="px-3.5 py-3.5 text-left font-medium text-slate-700 break-words text-sm md:text-base leading-normal"><?php echo e($item->retensi_arsip ?: '-'); ?></td>
                                    <td class="px-3 py-3.5 text-center align-middle">
                                        <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                            <?php if($fileTargetUrl && $fileTargetUrl !== '#'): ?>
                                                <a href="<?php echo e($fileTargetUrl); ?>" target="_blank" title="Lihat Tautan / Berkas" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white transition shadow-2xs rounded-lg"><i class="fa-regular fa-eye text-[11px] not-italic leading-none"></i></a>
                                            <?php endif; ?>
                                            <button type="button" onclick="editData(<?php echo e(json_encode($item)); ?>)" title="Edit Data" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg"><i class="fa-solid fa-pen-to-square text-[11px] not-italic leading-none"></i></button>
                                            <button type="button" onclick="triggerDelete('<?php echo e(url('/admin/informasi-publik/'.$item->id)); ?>', '<?php echo e(addslashes($item->sub_informasi)); ?>')" title="Hapus Data" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg"><i class="fa-solid fa-trash-can text-[11px] not-italic leading-none"></i></button>
                                        </div>
                                    </td>
                                <?php elseif($isSertaMertaCategory): ?>
                                    <td class="col-admin-sub-info px-4 py-3 font-medium text-slate-800 leading-relaxed align-middle break-words">
                                        <?php echo e($item->sub_informasi); ?>

                                    </td>
                                    <td class="px-4 py-3 text-left text-slate-600 align-middle whitespace-nowrap">
                                        <?php echo e($item->created_at?->translatedFormat('d F Y') ?? '-'); ?>

                                    </td>
                                    <td class="px-2 py-3 text-center align-middle">
                                        <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                            <?php if($fileTargetUrl && $fileTargetUrl !== '#'): ?>
                                                <a href="<?php echo e($fileTargetUrl); ?>" target="_blank" title="Lihat Berkas" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white rounded-lg transition"><i class="fa-regular fa-eye text-[11px]"></i></a>
                                            <?php endif; ?>
                                            <button type="button" onclick="editData(<?php echo e(json_encode($item)); ?>)" title="Edit" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white rounded-lg transition cursor-pointer"><i class="fa-solid fa-pen-to-square text-[11px]"></i></button>
                                            <button type="button" onclick="triggerDelete('<?php echo e(url('/admin/informasi-publik/'.$item->id)); ?>', '<?php echo e(addslashes($subInformasiText ?: $rincianText)); ?>')" title="Hapus" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-lg transition cursor-pointer"><i class="fa-solid fa-trash-can text-[11px]"></i></button>
                                        </div>
                                    </td>
                                <?php elseif($isKategoriMode): ?>
                                    <!-- 1. Rincian Informasi (Topik Induk) - Dynamic Rowspan Handled by Client Engine -->
                                    <td class="col-admin-rincian px-4 py-3 font-medium text-slate-800 leading-relaxed align-top bg-white break-words"><?php echo e($rincianText); ?></td>

                                    <!-- 2. Sub Informasi (Nama Dokumen) + Aksi Langsung di Dalamnya -->
                                    <td class="col-admin-sub-info px-4 py-3 font-medium text-slate-800 leading-relaxed align-top break-words">
                                        <?php
                                            $subText = trim($item->sub_informasi ?: '');
                                            $isPending = empty($subText) || $subText === 'Dokumen sedang dilengkapi unit';
                                        ?>
                                        <div class="space-y-1.5">
                                            <?php if(!$isPending): ?>
                                                <div class="font-medium text-slate-800" title="<?php echo e($subText); ?>"><?php echo e($subText); ?></div>
                                            <?php else: ?>
                                                <div class="flex items-center gap-2 py-0.5">
                                                    <i class="fa-regular fa-clock text-[11px] text-amber-500"></i>
                                                    <span class="text-xs text-amber-600 italic font-medium">Dokumen sedang dilengkapi unit</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-2 py-3 text-center align-middle">
                                        <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                            <?php if($fileTargetUrl && $fileTargetUrl !== '#'): ?>
                                                <a href="<?php echo e($fileTargetUrl); ?>" target="_blank" title="Lihat Tautan / Berkas" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white rounded-lg transition"><i class="fa-regular fa-eye text-[11px] not-italic leading-none"></i></a>
                                            <?php endif; ?>
                                            <button type="button" onclick="editData(<?php echo e(json_encode($item)); ?>)" title="Edit" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white rounded-lg transition cursor-pointer"><i class="fa-solid fa-pen-to-square text-[11px] not-italic leading-none"></i></button>
                                            <button type="button" onclick="triggerDelete('<?php echo e(url('/admin/informasi-publik/'.$item->id)); ?>', '<?php echo e(addslashes($subText ?: $rincianText)); ?>')" title="Hapus" class="inline-flex h-7 w-7 shrink-0 items-center justify-center text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-lg transition cursor-pointer"><i class="fa-solid fa-trash-can text-[11px] not-italic leading-none"></i></button>
                                        </div>
                                    </td>
                                <?php else: ?>
                                     <!-- 1. Ringkasan Isi Informasi -->
                                     <td class="px-4 py-3.5 text-slate-900 leading-normal break-words text-sm md:text-base">
                                         <?php
                                             $subVal = trim($item->sub_informasi ?: '');
                                         ?>
                                         <div class="space-y-1">
                                             <?php if($subVal && $subVal !== 'Dokumen sedang dilengkapi unit'): ?>
                                                 <div class="font-medium text-slate-900 leading-snug"><?php echo e($subVal); ?></div>
                                             <?php else: ?>
                                                 <div class="font-medium text-slate-900 leading-snug">-</div>
                                                 <div class="text-xs text-amber-600 font-semibold italic flex items-center gap-1">
                                                     <i class="fa-regular fa-clock text-[10px]"></i>
                                                     <span>Dokumen sedang dilengkapi unit</span>
                                                 </div>
                                             <?php endif; ?>
                                         </div>
                                     </td>

                                     <?php if (! ($forceTable)): ?>
                                     <!-- 2. Jenis Informasi -->
                                     <td class="px-3.5 py-3.5 text-center align-middle whitespace-nowrap">
                                         <?php
                                             $jVal = trim($item->jenis_informasi ?: '');
                                             $jBadgeClass = match($jVal) {
                                                 'Informasi Berkala' => 'bg-[#1B365D] text-white',
                                                 'Informasi Serta Merta', 'Informasi Serta-Merta' => 'bg-rose-500 text-white',
                                                 'Informasi Setiap Saat' => 'bg-emerald-600 text-white',
                                                 'Informasi Dikecualikan' => 'bg-slate-700 text-white',
                                                 default => 'bg-sky-600 text-white'
                                             };
                                         ?>
                                         <?php if($jVal): ?>
                                             <span class="inline-flex items-center justify-center px-2.5 py-1 text-[11px] font-bold rounded-lg <?php echo e($jBadgeClass); ?> shadow-2xs">
                                                 <?php echo e($jVal); ?>

                                             </span>
                                         <?php else: ?>
                                             <span class="text-slate-400 font-bold text-xs">-</span>
                                         <?php endif; ?>
                                     </td>

                                     <?php endif; ?>
                                     <!-- 3. Pejabat/Unit yang Menguasai Informasi -->
                                     <td class="px-4 py-3.5 font-medium text-slate-700 text-left break-words text-sm md:text-base leading-normal">
                                         <?php echo e($item->pejabat_unit_yang_menguasai_informasi ?: '-'); ?>

                                     </td>

                                     <!-- 4. Penanggung Jawab -->
                                     <td class="px-4 py-3.5 font-medium text-slate-700 text-left break-words text-sm md:text-base leading-normal">
                                         <?php echo e($item->penanggung_jawab_pembuatan_informasi ?: '-'); ?>

                                     </td>

                                     <!-- 5. Waktu dan Tempat Pembuatan -->
                                     <td class="px-4 py-3.5 text-left font-medium text-slate-700 break-words text-sm md:text-base leading-normal">
                                         <?php echo e($item->waktu_pembuatan_informasi ?: '-'); ?>

                                     </td>

                                     <!-- 6. Format -->
                                     <td class="px-3.5 py-3.5 text-left font-semibold text-slate-700 break-words text-sm md:text-base leading-normal">
                                         <?php echo e($item->bentuk_informasi_yang_tersedia ?: '-'); ?>

                                     </td>

                                     <!-- 7. Retensi Arsip -->
                                     <td class="px-3.5 py-3.5 text-left font-medium text-slate-700 break-words text-sm md:text-base leading-normal">
                                         <?php echo e($item->retensi_arsip ?: '-'); ?>

                                     </td>

                                     <!-- 8. Akses / Aksi (Kolom Paling Kanan) -->
                                     <td class="px-3 py-3.5 text-center align-middle">
                                         <div class="flex items-center justify-center gap-1.5 whitespace-nowrap">
                                             <?php if($fileTargetUrl && $fileTargetUrl !== '#'): ?>
                                                 <a href="<?php echo e($fileTargetUrl); ?>" target="_blank" title="Lihat Tautan / Berkas" 
                                                    class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-sky-600 bg-sky-50 hover:bg-sky-600 hover:text-white transition shadow-2xs rounded-lg">
                                                     <i class="fa-regular fa-eye text-[11px] not-italic leading-none"></i>
                                                 </a>
                                             <?php endif; ?>
                                             <button type="button" onclick="editData(<?php echo e(json_encode($item)); ?>)" title="Edit Data" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                                 <i class="fa-solid fa-pen-to-square text-[11px] not-italic leading-none"></i>
                                             </button>
                                             <button type="button" onclick="triggerDelete('<?php echo e(url('/admin/informasi-publik/'.$item->id)); ?>', '<?php echo e(addslashes($item->sub_informasi)); ?>')" title="Hapus Data" class="inline-flex h-8 w-8 shrink-0 items-center justify-center text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition shadow-2xs cursor-pointer rounded-lg">
                                                 <i class="fa-solid fa-trash-can text-[11px] not-italic leading-none"></i>
                                             </button>
                                         </div>
                                     </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="<?php echo e($isSertaMertaCategory ? '4' : ($isKategoriMode ? '4' : ($forceTable ? '9' : '10'))); ?>" class="p-12 text-center text-slate-400 font-semibold"><?php echo e($isKategoriMode ? 'Tidak ada data informasi untuk kategori ini.' : 'Tidak ada data Informasi Publik.'); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Footer Kontrol Paginasi Client-side Instan -->
        <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div id="table-admin-dip-info-<?php echo e($tableKey); ?>" data-admin-dip-info="<?php echo e($tableKey); ?>" class="text-sm md:text-lg text-slate-800">
                Menampilkan 0–0 dari 0 informasi
            </div>
            <div id="table-admin-dip-pagination-<?php echo e($tableKey); ?>" data-admin-dip-pagination="<?php echo e($tableKey); ?>" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden bg-white select-none">
                <!-- Render dinamis via JavaScript -->
            </div>
        </div>
</div>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/admin/informasi_publik/table.blade.php ENDPATH**/ ?>