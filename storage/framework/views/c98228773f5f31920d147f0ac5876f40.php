<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['informasi', 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => []]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['informasi', 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => []]); ?>
<?php foreach (array_filter((['informasi', 'listJenis' => [], 'listTahun' => [], 'listSatker' => [], 'listBentuk' => [], 'listRetensi' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<!-- Table Container Informasi Publik (Masyarakat / Publik) -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <!-- Tabel Daftar Informasi Publik (Fit Screen, Never Horizontal Scroll) -->
    <div>
        <table class="w-full table-fixed text-left border-collapse border border-slate-300">
            <thead>
                <?php
                    $curSortBy = request('sort_by');
                    $curSortDir = request('sort_direction', 'asc');
                ?>
                <tr class="bg-sky-500 text-white text-[11px] sm:text-xs md:text-sm font-black tracking-tight divide-x divide-white/40 border-b border-sky-600 text-center leading-snug select-none">
                    <th onclick="sortDipTable('no')" class="px-1 py-3 text-center w-12 shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Nomor">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>No</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'no' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'no'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('ringkasan')" class="px-2 py-3 text-center w-[20%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Ringkasan Isi Informasi">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Ringkasan Isi Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'ringkasan' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'ringkasan'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('jenis')" class="px-1.5 py-3 w-[11%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Jenis Informasi">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Jenis Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'jenis' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'jenis'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('pejabat')" class="px-2 py-3 w-[14%] break-normal cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Pejabat/Unit/Satker">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Pejabat/Unit/Satker yang Menguasai Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'pejabat' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'pejabat'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('penanggung_jawab')" class="px-1.5 py-3 w-[14%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Penanggung Jawab">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Penanggung Jawab Pembuatan atau Penerbitan Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'penanggung_jawab' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'penanggung_jawab'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('waktu')" class="px-1.5 py-3 w-[12%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Waktu dan Tempat">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Waktu dan Tempat Pembuatan Informasi</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'waktu' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'waktu'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('retensi')" class="px-1.5 py-3 w-[11%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Retensi Arsip">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Jangka Waktu Penyimpanan atau Retensi Arsip</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'retensi' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'retensi'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('bentuk')" class="px-1.5 py-3 w-[10.5%] [overflow-wrap:anywhere] cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan Bentuk Informasi">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Bentuk Informasi yang Tersedia</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'bentuk' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'bentuk'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                    <th onclick="sortDipTable('dilihat')" class="px-1.5 py-3 w-[8%] shrink-0 cursor-pointer hover:bg-sky-600/60 transition group" title="Klik untuk mengurutkan berdasarkan Sering Dilihat">
                        <div class="flex items-center justify-center gap-1.5">
                            <span>Akses</span>
                            <span class="inline-flex items-center justify-center text-xs md:text-sm <?php echo e($curSortBy === 'dilihat' ? 'text-white' : 'text-white/70 group-hover:text-white'); ?> transition">
                                <?php if($curSortBy === 'dilihat'): ?>
                                    <i class="fa-solid <?php echo e($curSortDir === 'desc' ? 'fa-sort-down' : 'fa-sort-up'); ?>"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-sort"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="table-dip-body" class="divide-y divide-slate-200 text-xs sm:text-sm font-medium text-slate-800">
                <?php $__empty_1 = true; $__currentLoopData = $informasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="table-dip-row hover:bg-sky-50/70 transition-colors divide-x divide-slate-200"
                        data-id="<?php echo e($item->id); ?>"
                        data-no="<?php echo e($idx + 1); ?>"
                        data-dilihat="<?php echo e((int)($item->dilihat ?? 0)); ?>"
                        data-ringkasan="<?php echo e(strtolower($item->sub_informasi ?? '')); ?>"
                        data-jenis="<?php echo e(strtolower($item->jenis_informasi ?? '')); ?>"
                        data-pejabat="<?php echo e(strtolower($item->pejabat_unit_yang_menguasai_informasi ?? '')); ?>"
                        data-penanggung_jawab="<?php echo e(strtolower($item->penanggung_jawab_pembuatan_informasi ?? '')); ?>"
                        data-waktu="<?php echo e(strtolower($item->waktu_pembuatan_informasi ?? '')); ?>"
                        data-retensi="<?php echo e(strtolower($item->retensi_arsip ?? '')); ?>"
                        data-bentuk="<?php echo e(strtolower($item->bentuk_informasi_yang_tersedia ?? '')); ?>">
                        <!-- 0. Kolom No -->
                        <td class="col-dip-no px-2 py-3 text-center font-bold text-slate-400">
                            <?php echo e($idx + 1); ?>

                        </td>

                        <!-- 1. Ringkasan Isi Informasi (Sub Informasi & Rincian Informasi) -->
                        <td class="px-3.5 py-3 text-slate-900 leading-normal break-words text-xs sm:text-sm">
                            <?php
                                $rincianVal = trim($item->rincian_informasi ?: '');
                                $subVal = trim($item->sub_informasi ?: '');
                            ?>
                            <div class="space-y-1">
                                <?php if($subVal && $subVal !== 'Dokumen sedang dilengkapi unit'): ?>
                                    <div class="font-black text-slate-900 leading-snug"><?php echo e($subVal); ?></div>
                                    <?php if($rincianVal && strcasecmp($rincianVal, $subVal) !== 0): ?>
                                        <div class="text-[11px] text-slate-500 font-semibold flex items-center gap-1">
                                            <span class="px-1.5 py-0.5 bg-slate-100 rounded text-slate-600 border border-slate-200/80"><?php echo e($rincianVal); ?></span>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="font-black text-slate-900 leading-snug"><?php echo e($rincianVal ?: '-'); ?></div>
                                    <div class="text-[11px] text-amber-600 font-semibold italic flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-[10px]"></i>
                                        <span>Dokumen sedang dilengkapi unit</span>
                                    </div>
                                <?php endif; ?>

                                <?php if($item->dilihat): ?>
                                    <div class="text-[11px] text-slate-400 font-semibold flex items-center gap-1.5 pt-0.5">
                                        <i class="fa-regular fa-eye text-[10px]"></i>
                                        <span><?php echo e(number_format($item->dilihat)); ?> dilihat</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>

                        <!-- 2. Jenis Informasi (Berkala / Serta Merta / Setiap Saat) -->
                        <td class="px-2.5 py-3 font-medium text-slate-700 text-center break-words text-xs sm:text-sm leading-normal">
                            <?php
                                $cleanJenis = preg_replace('/^informasi\s+/i', '', trim($item->jenis_informasi ?? ''));
                            ?>
                            <?php echo e($cleanJenis ?: ($item->jenis_informasi ?: '-')); ?>

                        </td>

                        <!-- 3. Pejabat/Unit/Satker Yang Menguasai Informasi -->
                        <td class="px-3 py-3 font-medium text-slate-700 text-center break-words text-xs sm:text-sm leading-normal">
                            <?php echo e($item->pejabat_unit_yang_menguasai_informasi ?: '-'); ?>

                        </td>

                        <!-- 4. Penanggung Jawab Pembuatan Informasi -->
                        <td class="px-3 py-3 font-medium text-slate-700 text-center break-words text-xs sm:text-sm leading-normal">
                            <?php echo e($item->penanggung_jawab_pembuatan_informasi ?: '-'); ?>

                        </td>

                        <!-- 5. Waktu dan Tempat Pembuatan Informasi -->
                        <td class="px-3 py-3 text-center font-medium text-slate-700 break-words text-xs sm:text-sm leading-normal">
                            <?php echo e($item->waktu_pembuatan_informasi ?: '-'); ?>

                        </td>

                        <!-- 6. Jangka Waktu Penyimpanan atau Retensi Arsip -->
                        <td class="px-3 py-3 text-center font-medium text-slate-700 break-words text-xs sm:text-sm leading-normal">
                            <?php echo e($item->retensi_arsip ?: '-'); ?>

                        </td>

                        <!-- 7. Bentuk/Format Informasi yang Tersedia -->
                        <td class="px-3 py-3 text-center font-semibold text-slate-700 break-words text-xs sm:text-sm leading-normal">
                            <?php echo e($item->bentuk_informasi_yang_tersedia ?: '-'); ?>

                        </td>

                        <!-- 9. Akses (Hanya untuk Melihat Dokumen/Tautan) -->
                        <td class="px-2 py-3 text-center align-middle">
                            <div class="flex items-center justify-center">
                                <?php
                                    $ext = pathinfo($item->file_informasi, PATHINFO_EXTENSION);
                                    $fileDisplayName = $item->nama_file_asli ?: (\Illuminate\Support\Str::slug($item->sub_informasi) . ($ext ? '.' . $ext : '.pdf'));
                                    $fileTargetUrl = ($item->link_informasi && !$item->file_informasi) 
                                        ? $item->link_informasi 
                                        : ($item->file_informasi ? url('/informasi/file/'.$item->id.'/'.rawurlencode($fileDisplayName)) : null);
                                ?>
                                <?php if($item->bentuk_informasi_yang_tersedia === 'Cetak' && !$item->file_informasi && !$item->link_informasi): ?>
                                    <span class="text-slate-400 font-bold text-xs">-</span>
                                <?php elseif($fileTargetUrl && $fileTargetUrl !== '#'): ?>
                                    <a href="<?php echo e($fileTargetUrl); ?>" target="_blank" title="Lihat Tautan / Berkas" 
                                       class="inline-flex items-center justify-center px-3 py-1.5 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-lg transition shadow-2xs">
                                        Lihat
                                    </a>
                                <?php else: ?>
                                    <span class="text-slate-400 font-bold text-xs">-</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="9" class="p-12 text-center text-slate-400 font-semibold">Tidak ada data Informasi Publik yang sesuai.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer Kontrol Paginasi Client-side Instan (Persis seperti Unpad / DataTables) -->
    <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div id="table-dip-info" class="text-xs md:text-sm text-slate-800">
            Menampilkan 0 sampai 0 dari 0 entri
        </div>
        <div id="table-dip-pagination" class="inline-flex items-center rounded-xl border border-slate-200/90 shadow-2xs overflow-hidden divide-x divide-slate-200 bg-white select-none">
            <!-- Render dinamis via JavaScript -->
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/masyarakat/informasi_publik/table.blade.php ENDPATH**/ ?>