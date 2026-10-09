
@props([
    'listRincian' => [],
    'listRincianBerkala' => [],
    'listRincianSetiapSaat' => [],
    'listRincianSertaMerta' => [],
    'listJudul' => [],
    'listSatker' => [],
    'listPenanggungJawab' => [],
    'listTahun' => [],
    'listRetensi' => [],
])

<!-- Modal Tambah / Edit Informasi Publik -->
<div id="modalAddEdit" class="hidden fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-xs transition-opacity">
    <div id="modalAddEditBox" class="bg-white rounded-2xl max-w-5xl w-full shadow-2xl border-0 overflow-hidden animate-in fade-in zoom-in duration-200 flex flex-col max-h-[95vh]">

        <!-- Header -->
        <div class="bg-gradient-to-r from-sky-500 to-blue-500 text-white px-7 py-5 shrink-0">
            <h3 id="modalTitle" class="text-xl font-bold">Tambah Informasi Publik</h3>
            <p id="modalSubtitle" class="text-sm text-white/90 mt-1">Tambahkan informasi baru ke sistem</p>
        </div>

        <!-- Form Body -->
        <form id="formAddEdit" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0" onsubmit="return handleFormSubmit(event)">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div class="p-6 overflow-y-auto flex-1 space-y-4">

                <!-- Grid 2 Kolom -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Kategori Informasi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            Kategori Informasi <span class="text-rose-500">*</span>
                        </label>
                        <select id="inputKategoriInformasi" name="kategori_informasi" required onchange="handleKategoriInformasiChange(this.value)"
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-sm">
                            <option value="">-- Pilih Kategori Informasi --</option>
                            <option value="Informasi Berkala">Informasi Berkala</option>
                            <option value="Informasi Setiap Saat">Informasi Setiap Saat</option>
                            <option value="Informasi Serta-Merta">Informasi Serta-Merta</option>
                        </select>
                    </div>

                    <!-- Rincian Informasi -->
                    <div id="section-rincian-field" class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            Rincian Informasi <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputRincianInformasi" name="rincian_informasi" list="list-rincian-dynamic" autocomplete="off" required
                               placeholder="Pilih atau ketik..."
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-sm">
                        <datalist id="list-rincian-dynamic"></datalist>
                    </div>

                    <!-- Sub Informasi -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            <span id="labelSubInformasi">Sub Informasi</span> <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputSubInformasi" name="sub_informasi" maxlength="150" required
                               placeholder="Judul atau deskripsi singkat..." list="list-sub-informasi-history" autocomplete="off"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-sm">
                        <datalist id="list-sub-informasi-history">
                            @foreach($listJudul as $val)
                                <option value="{{ $val }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Pejabat/Unit yang Menguasai Informasi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            Pejabat/Unit yang Menguasai Informasi <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputPejabatPenguasa" name="pejabat_unit_yang_menguasai_informasi" required autocomplete="off"
                               placeholder="Contoh: Dekanat..." list="list-satker-history"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-sm">
                        <datalist id="list-satker-history">
                            @foreach($listSatker as $val)
                                <option value="{{ $val }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Penanggung Jawab -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            Penanggung Jawab <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputPenanggungJawab" name="penanggung_jawab_pembuatan_informasi" required maxlength="255" autocomplete="off" list="list-penanggung-jawab-history"
                               placeholder="Contoh: Dekan..."
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-sm">
                        <datalist id="list-penanggung-jawab-history">
                            @foreach($listPenanggungJawab as $val)
                                <option value="{{ $val }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Waktu dan Tempat Pembuatan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            Waktu dan Tempat Pembuatan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="inputTahun" name="waktu_pembuatan_informasi" required autocomplete="off"
                               placeholder="Contoh: 2026, Dekanat..." list="list-waktu-history"
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-sm">
                        <datalist id="list-waktu-history">
                            @foreach($listTahun as $val)
                                <option value="{{ $val }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Format -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">
                            Format <span class="text-rose-500">*</span>
                        </label>
                        <select id="inputBentukInformasi" name="bentuk_informasi_yang_tersedia" required onchange="handleBentukInformasiChange(this.value)"
                                class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-sm cursor-pointer">
                            <option value="Cetak dan Online">Cetak dan Online</option>
                            <option value="Online">Online</option>
                            <option value="Cetak">Cetak</option>
                        </select>
                    </div>

                    <!-- Retensi Arsip + Bentuk * — 1 baris 2 kolom (swap) -->
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Retensi Arsip Kiri -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-slate-700">
                                Retensi Arsip <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="inputRetensiArsip" name="retensi_arsip" required autocomplete="off" list="list-retensi-history"
                                   placeholder="Contoh: Permanen..."
                                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-100 transition text-sm">
                            <datalist id="list-retensi-history">
                                @foreach($listRetensi as $val)
                                    <option value="{{ $val }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div id="sectionAksesOnline" class="space-y-2" x-data="{
                            tipe: 'file',
                            fileName: '',
                            fileSize: '',
                            fileUrl: '',
                            fileError: '',
                            handle(e){
                                const f = e.target.files[0];
                                this.fileError='';
                                if(!f) return;
                                if(f.size > 5*1024*1024){
                                    this.fileError='Ukuran file maksimal 5 MB';
                                    e.target.value='';
                                    this.fileName=''; this.fileSize='';
                                    if(this.fileUrl) URL.revokeObjectURL(this.fileUrl);
                                    this.fileUrl='';
                                    const disp=document.getElementById('fileDisplayName');
                                    if(disp) disp.textContent='';
                                    return;
                                }
                                this.fileName = f.name;
                                this.fileSize = (f.size/1024).toFixed(1)+' KB';
                                if(f.size>1024*1024) this.fileSize = (f.size/(1024*1024)).toFixed(1)+' MB';
                                this.fileUrl = URL.createObjectURL(f);
                                const disp = document.getElementById('fileDisplayName');
                                if(disp) disp.textContent = f.name;
                            },
                            clear(){
                                document.getElementById('inputFile').value='';
                                if(this.fileUrl) URL.revokeObjectURL(this.fileUrl);
                                this.fileName=''; this.fileSize=''; this.fileUrl=''; this.fileError='';
                            }
                        }" x-init="$watch('tipe', val => toggleInputType(val))">
                            <label class="block text-sm font-semibold text-slate-700">Bentuk <span class="text-rose-500">*</span></label>
                            <!-- File / Tautan 1 baris kiri-kanan -->
                            <div class="flex gap-2">
                                <label class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg border text-xs font-medium cursor-pointer" :class="tipe==='file' ? 'border-sky-500 bg-sky-500 text-white' : 'border-slate-200 bg-white text-slate-600'">
                                    <input type="radio" name="kategori_informasi_format" value="file" x-model="tipe" class="sr-only"> File
                                </label>
                                <label class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg border text-xs font-medium cursor-pointer" :class="tipe==='link' ? 'border-sky-500 bg-sky-500 text-white' : 'border-slate-200 bg-white text-slate-600'">
                                    <input type="radio" name="kategori_informasi_format" value="link" x-model="tipe" class="sr-only"> Tautan
                                </label>
                            </div>
                            <div x-show="tipe==='file'">
                                <input type="file" id="inputFile" name="file_informasi" accept=".pdf,.xls,.xlsx,.jpg,.jpeg,.png" class="sr-only" @change="handle($event)">
                                <div @click="document.getElementById('inputFile').click()" class="flex items-center gap-2 w-full rounded-lg border border-slate-200 bg-white p-2 pr-2 cursor-pointer transition hover:border-slate-300">
                                    <span class="shrink-0 inline-flex items-center justify-center rounded-lg bg-slate-100 px-3 py-1.5 text-[11px] font-bold text-slate-700">Pilih File</span>
                                    <span class="flex-1 min-w-0 truncate text-sm" :class="fileName ? 'text-slate-800' : 'text-slate-400'" x-text="fileName || 'Belum ada file'"></span>
                                    <template x-if="fileName">
                                        <button type="button" @click.stop="clear()" class="shrink-0 inline-flex h-7 w-7 items-center justify-center rounded-full text-rose-500 hover:bg-rose-50 transition"><i class="fa-regular fa-trash-can text-sm"></i></button>
                                    </template>
                                </div>
                                <template x-if="fileName">
                                    <div class="mt-2 flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-2">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600"><i class="fa-regular fa-file text-xs"></i></span>
                                        <div class="flex-1 min-w-0">
                                            <p class="truncate text-xs font-semibold text-slate-800" x-text="fileName"></p>
                                            <p class="text-[10px] text-slate-500" x-text="fileSize"></p>
                                        </div>
                                        <a :href="fileUrl" target="_blank" class="shrink-0 inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 transition">Lihat</a>
                                    </div>
                                </template>
                                <template x-if="fileError">
                                    <p class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600"><i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="fileError"></span></p>
                                </template>
                                <span id="fileDisplayName" class="hidden"></span>
                                <a id="currentFileLink" href="#" class="hidden"><span id="currentFileName"></span></a>
                                <p class="text-xs text-slate-400 mt-1">Format: PDF, XLS, XLSX, JPG, JPEG, PNG (Maksimal 5 MB)</p>
                            </div>
                            <div x-show="tipe==='link'">
                                <input type="url" id="inputLink" name="link_informasi" placeholder="Contoh: https://drive.google.com/..." class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 font-medium focus:outline-none focus:border-sky-500 transition text-sm">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0">
                <button type="button" onclick="closeAddEditModal()" class="px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-bold rounded-xl transition shadow-2xs">
                    Batal
                </button>
                <button type="submit" id="btnSubmitAddEdit" class="px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white text-sm font-bold rounded-xl transition shadow-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
