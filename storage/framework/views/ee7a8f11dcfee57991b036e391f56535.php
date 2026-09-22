
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'listRincian' => [],
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => [],
    'listJudul' => [],
    'listSatker' => [],
    'listPenanggungJawab' => [],
    'listTahun' => [],
    'listRetensi' => [],
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'listRincian' => [],
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => [],
    'listJudul' => [],
    'listSatker' => [],
    'listPenanggungJawab' => [],
    'listTahun' => [],
    'listRetensi' => [],
]); ?>
<?php foreach (array_filter(([
    'listRincian' => [],
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => [],
    'listJudul' => [],
    'listSatker' => [],
    'listPenanggungJawab' => [],
    'listTahun' => [],
    'listRetensi' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<!-- Modal Tambah / Edit Informasi Publik -->
<div id="modalAddEdit" class="hidden fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div id="modalAddEditBox" class="bg-white rounded-2xl max-w-xl w-full shadow-2xl border-0 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[96vh] transition-all duration-300 ease-in-out">

        <!-- Header Modal Sky-Blue -->
        <div class="bg-sky-500 text-white px-6 py-3.5 shrink-0 rounded-t-2xl w-full">
            <h3 id="modalTitle" class="text-lg sm:text-xl font-extrabold text-white tracking-tight leading-snug">Tambah Informasi Publik</h3>
            <p id="modalSubtitle" class="text-xs text-white/90 font-medium mt-0.5 leading-normal">Pilih klasifikasi informasi untuk melanjutkan pengisian</p>
        </div>

        <!-- Form Body -->
        <form id="formAddEdit" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0" onsubmit="handleFormSubmit(event)">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="p-6 text-xs md:text-sm overflow-y-auto flex-1 space-y-4">

                <!-- STEP 1: Klasifikasi Informasi -->
                <div class="space-y-1.5">
                    <label class="block text-xs md:text-sm font-bold text-slate-800">
                        Jenis Informasi <span class="text-rose-500">*</span>
                    </label>
                    <select id="inputJenisInformasi" name="jenis_informasi" required onchange="handleJenisInformasiChange(this.value)"
                            class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-bold focus:bg-white focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition cursor-pointer text-xs sm:text-sm">
                        <option value="">-- Pilih Jenis Informasi --</option>
                        <option value="Informasi Berkala">Informasi Berkala</option>
                        <option value="Informasi Serta-Merta">Informasi Serta-Merta</option>
                        <option value="Informasi Setiap Saat">Informasi Setiap Saat</option>
                    </select>
                </div>

                <!-- STEP 2: Rincian Informasi (full-width, muncul setelah pilih klasifikasi) -->
                <div id="section-rincian-field" class="hidden pt-3 border-t border-slate-100 space-y-3 animate-in fade-in duration-200">
                    <div class="space-y-1">
                        <label class="block text-xs md:text-sm font-bold text-slate-800">
                            Rincian Informasi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="inputRincianInformasi" name="rincian_informasi" list="list-rincian-dynamic" autocomplete="off" required
                                   placeholder="Pilih atau ketik Rincian Informasi..."
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-bold focus:bg-white focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-xs sm:text-sm">
                            <datalist id="list-rincian-dynamic"></datalist>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: 2-Kolom — Kiri: Sub → Jangka Waktu | Kanan: Bentuk + Akses -->
                <div id="section-form-fields" class="hidden pt-3 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-3 animate-in fade-in duration-200">

                    <!-- ===== KOLOM KIRI ===== -->
                    <div class="space-y-3 flex flex-col">

                        <!-- Sub Informasi -->
                        <div class="space-y-1">
                            <label class="block text-xs md:text-sm font-bold text-slate-800">
                                Sub Informasi <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="inputSubInformasi" name="sub_informasi" maxlength="150"
                                   placeholder="Contoh: Kedudukan, Tugas, Visi dan Misi,..."
                                   list="list-sub-informasi-history"
                                   autocomplete="off"
                                   class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold placeholder:text-slate-400 focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            <datalist id="list-sub-informasi-history">
                                <?php $__currentLoopData = $listJudul; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>"></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                        </div>

                        <!-- Pejabat/Unit/Satker -->
                        <div class="space-y-1">
                            <label class="block text-xs md:text-sm font-bold text-slate-800">
                                Pejabat/Unit/Satker yang Menguasai Informasi <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="inputPejabatPenguasa" name="pejabat_unit_yang_menguasai_informasi" required autocomplete="off"
                                   placeholder="Contoh: Dekanat / Bagian Tata Usaha FMIPA"
                                   list="list-satker-history"
                                   class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            <datalist id="list-satker-history">
                                <?php $__currentLoopData = $listSatker; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>"></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                        </div>

                        <!-- Penanggung Jawab -->
                        <div class="space-y-1">
                            <label class="block text-xs md:text-sm font-bold text-slate-800">
                                Penanggung Jawab Pembuatan atau Penerbitan Informasi <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="inputPenanggungJawab" name="penanggung_jawab_pembuatan_informasi" required autocomplete="off"
                                   placeholder="Contoh: PPID Pelaksana FMIPA Unila"
                                   list="list-penanggung-jawab-history"
                                   class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            <datalist id="list-penanggung-jawab-history">
                                <?php $__currentLoopData = $listPenanggungJawab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>"></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                        </div>

                        <!-- Waktu dan Tempat Pembuatan Informasi -->
                        <div class="space-y-1">
                            <label class="block text-xs md:text-sm font-bold text-slate-800">
                                Waktu dan Tempat Pembuatan Informasi <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="inputTahun" name="waktu_pembuatan_informasi" required autocomplete="off"
                                   placeholder="Contoh: 2026, Dekanat FMIPA"
                                   list="list-waktu-history"
                                   class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            <datalist id="list-waktu-history">
                                <?php $__currentLoopData = $listTahun; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>"></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                        </div>

                    </div>

                    <!-- ===== KOLOM KANAN ===== -->
                    <div class="space-y-3 flex flex-col">

                        <!-- Bentuk Informasi yang Tersedia -->
                        <div class="space-y-1">
                            <label class="block text-xs md:text-sm font-bold text-slate-800">
                                Bentuk Informasi yang Tersedia <span class="text-rose-500">*</span>
                            </label>
                            <select id="inputBentukInformasi" name="bentuk_informasi_yang_tersedia" required onchange="handleBentukInformasiChange(this.value)"
                                    class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition cursor-pointer text-xs sm:text-sm">
                                <option value="Cetak dan Online">Cetak dan Online</option>
                                <option value="Cetak">Cetak</option>
                                <option value="Online">Online</option>
                            </select>
                        </div>

                        <!-- Jangka Waktu Penyimpanan / Retensi Arsip -->
                        <div class="space-y-1">
                            <label class="block text-xs md:text-sm font-bold text-slate-800">
                                Jangka Waktu Penyimpanan atau Retensi Arsip <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   id="inputRetensiArsip"
                                   name="retensi_arsip"
                                   required
                                   autocomplete="off"
                                   list="list-retensi-history"
                                   placeholder="Contoh: 2 Tahun / Selama Berlaku / Permanen"
                                   class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            <datalist id="list-retensi-history">
                                <?php $__currentLoopData = $listRetensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>"></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                        </div>

                        <!-- Akses & Upload/Link -->
                        <div id="sectionAksesOnline" class="space-y-3">

                            <!-- Akses -->
                            <div class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Format</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="flex items-center gap-2 h-[38px] px-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                        <input type="radio" name="jenis_informasi_format" id="radioFile" value="file" checked onclick="toggleInputType('file')" class="text-sky-600 focus:ring-0">
                                        <span class="font-bold text-slate-700 text-xs truncate">File</span>
                                    </label>
                                    <label class="flex items-center gap-2 h-[38px] px-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 transition">
                                        <input type="radio" name="jenis_informasi_format" id="radioLink" value="link" onclick="toggleInputType('link')" class="text-sky-600 focus:ring-0">
                                        <span class="font-bold text-slate-700 text-xs truncate">Tautan</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Upload File -->
                            <div id="containerFile" class="space-y-1">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Upload File</label>
                                <div class="relative flex items-center w-full min-h-[38px] p-1 bg-slate-50 border border-slate-200 rounded-xl transition focus-within:border-sky-500 focus-within:bg-white">
                                    <input type="file" id="inputFile" name="file_informasi" accept=".pdf,.doc,.docx,.xls,.xlsx" class="sr-only" onchange="handleFileChange(this)">
                                    <button type="button" onclick="document.getElementById('inputFile').click()"
                                            class="shrink-0 px-3 py-1 bg-sky-500 hover:bg-sky-600 active:bg-sky-700 text-white text-xs font-black rounded-lg transition shadow-2xs cursor-pointer">
                                        Choose File
                                    </button>
                                    <div class="flex-1 min-w-0 px-2 flex items-center">
                                        <span id="fileDisplayName" class="text-xs text-slate-500 font-medium truncate">No file chosen</span>
                                        <a id="currentFileLink" href="#" target="_blank" title="Klik untuk melihat file saat ini"
                                           class="hidden text-xs font-semibold text-sky-600 hover:text-sky-700 underline truncate block cursor-pointer max-w-full">
                                            <span id="currentFileName" class="truncate"></span>
                                        </a>
                                    </div>
                                </div>
                                <p id="fileHelpText" class="text-[10px] text-slate-400 font-medium">Format: PDF, DOC, DOCX, XLS, XLSX (Maks 5MB)</p>
                            </div>

                            <!-- Tautan Link -->
                            <div id="containerLink" class="space-y-1 hidden">
                                <label class="block text-xs md:text-sm font-bold text-slate-800">Tautan <span class="text-rose-500">*</span></label>
                                <input type="url" id="inputLink" name="link_informasi" placeholder="Contoh: https://drive.google.com/..."
                                       class="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 font-semibold focus:bg-white focus:outline-none focus:border-sky-500 transition text-xs sm:text-sm">
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="px-5 py-3 sm:px-6 bg-slate-50/90 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0 rounded-b-2xl">
                <button type="button" onclick="closeAddEditModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs sm:text-sm font-extrabold rounded-xl transition cursor-pointer">
                    Batal
                </button>

                <div class="flex items-center gap-2">
                    <!-- Tombol Simpan Rincian & Lanjut -->
                    <button type="button" id="btnStepNext" onclick="handleStepNext()" class="hidden px-5 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs sm:text-sm font-extrabold rounded-xl transition shadow-xs cursor-pointer flex items-center gap-1.5">
                        <span id="textBtnStep">Simpan Rincian &amp; Lanjut</span>
                        <i id="iconBtnStep" class="fa-solid fa-arrow-right"></i>
                    </button>

                    <!-- Tombol Simpan Akhir -->
                    <button type="submit" id="btnSubmitAddEdit" class="hidden px-5 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs sm:text-sm font-extrabold rounded-xl transition shadow-xs cursor-pointer flex items-center gap-1.5">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH D:\laragon\www\ppid-fmipa-baru\resources\views/components/admin/informasi_publik/modal-add-edit.blade.php ENDPATH**/ ?>