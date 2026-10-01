<?php $__env->startSection('title', 'Kelola Beranda - Admin PPID'); ?>
<?php $__env->startSection('header_title', 'Kelola Beranda'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">

    
    <?php if(session('success')): ?>
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200/80 rounded-2xl text-emerald-800 text-xs sm:text-sm font-bold shadow-2xs">
            <i class="fa-solid fa-circle-check text-emerald-600 text-base shrink-0"></i>
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="p-4 bg-rose-50 border border-rose-200/80 rounded-2xl text-rose-800 text-xs sm:text-sm space-y-1 shadow-2xs">
            <div class="font-black flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Terjadi kesalahan pada input:</span>
            </div>
            <ul class="list-disc list-inside font-semibold space-y-0.5 pl-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Profil PPID Pelaksana</h1>
        <p class="text-xs sm:text-sm font-semibold text-slate-400 mt-1">Kelola foto, nama, jabatan, dan tugas fungsi pejabat yang tampil di beranda publik.</p>
    </div>

    <form action="<?php echo e(route('admin.profil.update')); ?>" method="POST" enctype="multipart/form-data"
          class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-7 shadow-2xs space-y-6">
        <?php echo csrf_field(); ?>

        
        <div class="flex flex-col lg:flex-row gap-6">

            
            <div class="shrink-0 flex flex-col items-center gap-3">
                <div id="foto-preview-wrap"
                     class="w-full lg:w-56 xl:w-64 min-h-[220px] max-h-[340px] overflow-hidden rounded-2xl border-2 border-sky-300 shadow-md bg-slate-100 flex items-center justify-center p-2"
                     style="max-width: 260px;">
                    <?php if(!empty($profil['foto']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($profil['foto'])): ?>
                        <img id="foto-preview-img"
                             src="<?php echo e(asset('storage/' . $profil['foto'])); ?>"
                             alt="Foto Profil"
                             class="max-w-full max-h-[320px] w-auto h-auto object-contain rounded-xl drop-shadow-sm">
                    <?php else: ?>
                        <div class="flex flex-col items-center gap-3 p-6 text-center">
                            <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-sky-600 to-blue-700 flex items-center justify-center shadow-md">
                                <span id="foto-preview-initial" class="text-white font-black text-4xl select-none leading-none">
                                    <?php echo e(strtoupper(substr($profil['nama'] ?? 'A', 0, 1))); ?>

                                </span>
                            </div>
                            <span class="text-slate-500 text-xs font-semibold">Belum ada foto</span>
                        </div>
                    <?php endif; ?>
                </div>
                <p class="text-[11px] text-slate-400 font-medium text-center">Preview foto profil</p>
            </div>

            
            <div class="flex-1 min-w-0 space-y-4">
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-700">Upload Foto Baru
                        <span class="text-slate-400 font-medium ml-1">(JPG / PNG / WebP, maks. 3 MB)</span>
                    </label>
                    <input type="file" name="foto" id="foto-input" accept="image/jpeg,image/png,image/jpg,image/webp"
                           onchange="previewFoto(this)"
                           class="w-full text-xs sm:text-sm text-slate-700 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 file:cursor-pointer transition-all">

                    <?php if(!empty($profil['foto'])): ?>
                        <label class="inline-flex items-center gap-2 mt-1.5 cursor-pointer select-none">
                            <input type="checkbox" name="hapus_foto" value="1"
                                   class="rounded border-slate-300 text-rose-500 focus:ring-rose-400">
                            <span class="text-xs font-semibold text-rose-600">Hapus foto saat ini</span>
                        </label>
                    <?php endif; ?>
                </div>

                
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-700">Nama Pejabat / PIC PPID <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required
                           value="<?php echo e(old('nama', $profil['nama'] ?? 'Aristoeteles')); ?>"
                           placeholder="Nama lengkap pejabat..."
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all">
                </div>

                
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-700">Jabatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="jabatan" required
                           value="<?php echo e(old('jabatan', $profil['jabatan'] ?? 'Kasubag TU / PIC PPID Pelaksana')); ?>"
                           placeholder="Contoh: Kasubag TU / PIC PPID Pelaksana..."
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all">
                </div>

                
                <div class="p-3.5 bg-sky-50 border border-sky-200/60 rounded-xl">
                    <p class="text-[11px] text-sky-700 font-medium leading-relaxed">
                        <i class="fa-solid fa-circle-info mr-1"></i>
                        Gunakan foto formal dengan background polos atau natural. Foto akan ditampilkan besar di halaman beranda publik.
                    </p>
                </div>
            </div>
        </div>

        
        <div class="space-y-1.5">
            <label class="block text-xs font-black text-slate-700">Tugas dan Fungsi <span class="text-rose-500">*</span></label>
            <textarea name="tugas_fungsi" rows="4" required
                      placeholder="Deskripsikan tugas dan fungsi PPID Pelaksana..."
                      class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all resize-none"><?php echo e(old('tugas_fungsi', $profil['tugas_fungsi'] ?? '')); ?></textarea>
        </div>

        
        <div class="flex items-center justify-end pt-2 border-t border-slate-100">
            <button type="submit"
                    class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-black text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-floppy-disk text-xs"></i>
                <span>Simpan Profil PPID</span>
            </button>
        </div>
    </form>

    
    <div>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Tanya Jawab (FAQ)</h2>
        <p class="text-xs sm:text-sm font-semibold text-slate-400 mt-1">Daftar pertanyaan dan jawaban yang tampil di beranda pemohon untuk memandu masyarakat.</p>
    </div>

    
    <div class="space-y-3.5">
        <?php $__empty_1 = true; $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col sm:flex-row sm:items-start justify-between gap-4 group">
                <div class="space-y-2 flex-1 min-w-0">
                    <div class="flex items-start gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-sky-100 text-sky-700 font-black text-xs flex items-center justify-center shrink-0 mt-0.5">Q</span>
                        <h3 class="text-sm sm:text-base font-black text-slate-900 break-words leading-snug">
                            <?php echo e($faq['pertanyaan'] ?? ''); ?>

                        </h3>
                    </div>
                    <div class="pl-8 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed whitespace-pre-line break-words">
                        <?php echo e($faq['jawaban'] ?? ''); ?>

                    </div>
                </div>

                <div class="shrink-0 pl-8 sm:pl-0 sm:pt-0.5">
                    <button type="button"
                            onclick="triggerDelete('<?php echo e(route('admin.faq.destroy', $faq['id'])); ?>', '<?php echo e(addslashes($faq['pertanyaan'] ?? 'pertanyaan ini')); ?>')"
                            class="px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs inline-flex items-center gap-1.5 transition-all border border-rose-200/60 cursor-pointer">
                        <i class="fa-regular fa-trash-can text-xs"></i>
                        <span>Hapus</span>
                    </button>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-10 text-center bg-white rounded-2xl border border-slate-200/90 shadow-2xs space-y-2.5">
                <div class="w-11 h-11 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-lg">
                    <i class="fa-regular fa-circle-question"></i>
                </div>
                <p class="text-xs sm:text-sm font-bold text-slate-600">Belum ada pertanyaan FAQ yang dibuat.</p>
                <p class="text-[11px] sm:text-xs text-slate-400 max-w-sm mx-auto font-medium">Gunakan formulir di bawah ini untuk menambahkan tanya jawab pertama ke beranda pemohon.</p>
            </div>
        <?php endif; ?>
    </div>

    
    <div id="formTambahFaq" class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-2xs space-y-4 scroll-mt-6">
        <div class="flex items-center gap-2.5 border-b border-slate-100 pb-3.5">
            <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-sm font-black shrink-0">
                <i class="fa-solid fa-circle-plus"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-black text-slate-900">Tambah Tanya Jawab (FAQ)</h3>
                <p class="text-xs text-slate-400 font-medium">Tuliskan pertanyaan baru dan jawabannya untuk langsung ditampilkan di beranda pemohon.</p>
            </div>
        </div>

        <form action="<?php echo e(route('admin.faq.store')); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div class="space-y-1.5">
                <label class="block text-xs font-black text-slate-700">Pertanyaan</label>
                <input type="text" name="pertanyaan" required
                       value="<?php echo e(old('pertanyaan')); ?>"
                       placeholder="Contoh: Berapa biaya pengajuan permohonan informasi?"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-slate-700">Jawaban</label>
                <textarea name="jawaban" rows="4" required
                          placeholder="Tuliskan jawaban yang jelas dan informatif untuk pemohon..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm font-medium text-slate-800 placeholder:text-slate-400 focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-all resize-none"><?php echo e(old('jawaban')); ?></textarea>
            </div>

            <div class="flex items-center justify-end pt-2">
                <button type="submit"
                        class="px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-black text-xs rounded-xl shadow-xs transition-all inline-flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Preview foto sebelum upload — tampilkan gambar fleksibel
function previewFoto(input) {
    const wrap = document.getElementById('foto-preview-wrap');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            wrap.innerHTML = `<img src="${e.target.result}" class="max-w-full max-h-[320px] w-auto h-auto object-contain rounded-xl drop-shadow-sm" alt="Preview Foto">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('components.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/admin/beranda/index.blade.php ENDPATH**/ ?>