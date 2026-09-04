<!-- ==================== MODAL TERPADU PREMIUM: PEMROSESAN TINDAKLANJUT PERMOHONAN ==================== -->
<div x-show="detailModalOpen" style="display: none;" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs transition-opacity">
        
        <div @click.away="detailModalOpen = false" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 scale-95"
             class="bg-white shadow-2xl w-full max-w-6xl max-h-[92vh] rounded-2xl overflow-hidden border-0 flex flex-col">
            
            <form :action="'/admin/permohonan/' + (selectedPermohonan ? selectedPermohonan.id : '') + '/status'" method="POST" enctype="multipart/form-data" class="flex flex-col h-full overflow-hidden">
                @csrf
                @method('PUT')

                <!-- Header Modal Sky-Blue tanpa celah/garis tepi -->
                <div class="bg-sky-500 text-white px-8 py-5 flex items-center justify-between shrink-0 rounded-t-2xl w-full">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-black tracking-tight text-white" x-text="selectedPermohonan ? 'Nomor Tiket: ' + selectedPermohonan.no_tiket : ''"></h3>
                    </div>
                    <button type="button" @click="closeModal()" class="w-9 h-9 rounded-xl bg-white/15 hover:bg-white/25 text-white flex items-center justify-center transition cursor-pointer shrink-0 ml-4">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Body Content (Scrollable) -->
                <div class="p-6 sm:p-8 overflow-y-auto text-base text-slate-700 flex-1 space-y-7 bg-slate-50/60 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                    <template x-if="selectedPermohonan">
                        <div class="space-y-7">

                            <!-- BARIS 1: GRID DATA DIRI (8/12) & LAMPIRAN (4/12) -->
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                                
                                <!-- KIRI (8/12): DATA DIRI PEMOHON -->
                                <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-6 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                                            <h4 class="font-black text-slate-900 text-base sm:text-[1.15rem]">Data Diri Pemohon</h4>
                                            <span class="px-4 py-1.5 bg-slate-100 text-slate-800 text-xs sm:text-sm font-extrabold rounded-full uppercase tracking-wider" x-text="selectedPermohonan.kategori_pemohon"></span>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-sm sm:text-base">
                                            <div>
                                                <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">Nama Lengkap</span>
                                                <span class="font-extrabold text-slate-900 text-base block leading-snug" x-text="selectedPermohonan.nama_lengkap"></span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">No. Identitas (NIK)</span>
                                                <span class="font-extrabold text-slate-900 text-base block leading-snug" x-text="selectedPermohonan.no_identitas || selectedPermohonan.nik || '-'"></span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">Pekerjaan</span>
                                                <span class="font-extrabold text-slate-900 text-base block leading-snug" x-text="selectedPermohonan.pekerjaan"></span>
                                            </div>

                                            <div>
                                                <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">Email</span>
                                                <span class="font-extrabold text-slate-900 text-base break-all block leading-snug" x-text="selectedPermohonan.email || '-'"></span>
                                            </div>
                                            <div>
                                                <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">No. Telp / WhatsApp</span>
                                                <span class="font-extrabold text-slate-900 text-base block leading-snug" x-text="selectedPermohonan.no_telepon || selectedPermohonan.no_hp"></span>
                                            </div>
                                            <template x-if="selectedPermohonan.nama_organisasi_lembaga">
                                                <div>
                                                    <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm" x-text="'Nama ' + selectedPermohonan.kategori_pemohon"></span>
                                                    <span class="font-black text-slate-800 text-base block leading-snug" x-text="selectedPermohonan.nama_organisasi_lembaga"></span>
                                                </div>
                                            </template>

                                            <div class="sm:col-span-2 lg:col-span-3 pt-3 border-t border-slate-100">
                                                <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">Alamat Lengkap</span>
                                                <span class="font-semibold text-slate-900 leading-relaxed block text-base" x-text="selectedPermohonan.alamat_lengkap || selectedPermohonan.alamat"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- KANAN (4/12): LAMPIRAN PEMOHON -->
                                <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-6 flex flex-col justify-between">
                                    <div>
                                        <div class="border-b border-slate-100 pb-4 mb-5">
                                            <h4 class="font-black text-slate-900 text-base sm:text-[1.15rem]">Lampiran</h4>
                                        </div>

                                        <div class="space-y-4">
                                            <div>
                                                <span class="text-slate-500 font-extrabold block mb-1.5 text-xs sm:text-sm">Identitas (KTP /SIM)</span>
                                                <template x-if="selectedPermohonan.file_identitas">
                                                    <a :href="'/storage/' + selectedPermohonan.file_identitas" target="_blank" class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-sky-50 hover:border-sky-300 transition group cursor-pointer">
                                                        <span class="font-black text-sky-700 group-hover:underline text-xs sm:text-sm flex items-center gap-2">
                                                            <i class="fa-solid fa-id-card"></i> Lihat lampiran
                                                        </span>
                                                        <i class="fa-solid fa-arrow-up-right-from-square text-sky-500 text-xs"></i>
                                                    </a>
                                                </template>
                                                <template x-if="!selectedPermohonan.file_identitas">
                                                    <span class="text-xs text-slate-400 italic">-</span>
                                                </template>
                                            </div>

                                            <div>
                                                <span class="text-slate-500 font-extrabold block mb-1.5 text-xs sm:text-sm">Dokumen Pendukung</span>
                                                <template x-if="selectedPermohonan.file_pendukung">
                                                    <a :href="'/storage/' + selectedPermohonan.file_pendukung" target="_blank" class="flex items-center justify-between p-3.5 bg-slate-50 border border-slate-200 rounded-xl hover:bg-sky-50 hover:border-sky-300 transition group cursor-pointer">
                                                        <span class="font-black text-sky-700 group-hover:underline text-xs sm:text-sm flex items-center gap-2">
                                                            <i class="fa-solid fa-file-lines"></i> Lihat lampiran
                                                        </span>
                                                        <i class="fa-solid fa-arrow-up-right-from-square text-sky-500 text-xs"></i>
                                                    </a>
                                                </template>
                                                <template x-if="!selectedPermohonan.file_pendukung">
                                                    <span class="text-xs text-slate-400 italic">-</span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- BARIS 2: RINCIAN PERMOHONAN -->
                            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 space-y-4">
                                <div class="border-b border-slate-100 pb-3">
                                    <h4 class="font-black text-slate-900 text-base sm:text-[1.15rem]">Rincian Permohonan Informasi</h4>
                                </div>

                                <div class="space-y-4 text-sm sm:text-base">
                                    <div>
                                        <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">Informasi yang Diminta</span>
                                        <p class="font-bold text-slate-900 leading-relaxed whitespace-pre-line break-words [word-break:break-word] break-all" x-text="selectedPermohonan.informasi_yang_diminta"></p>
                                    </div>
                                    <div class="pt-3 border-t border-slate-100">
                                        <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">Tujuan Penggunaan Informasi</span>
                                        <p class="font-bold text-slate-900 leading-relaxed whitespace-pre-line break-words [word-break:break-word] break-all" x-text="selectedPermohonan.tujuan_penggunaan_informasi"></p>
                                    </div>
                                    <div class="pt-3 border-t border-slate-100">
                                        <span class="text-slate-500 font-extrabold block mb-1 text-xs sm:text-sm">Cara Memperoleh Informasi</span>
                                        <p class="font-bold text-slate-900 leading-relaxed whitespace-pre-line break-words [word-break:break-word] break-all" x-text="selectedPermohonan.cara_memperoleh_informasi || '-'"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- PESAN STATUS FINAL (TIDAK BISA DIUBAH) -->
                            <template x-if="['Selesai','Ditolak'].includes(selectedPermohonan.status)">
                                <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-md p-6 sm:p-8 space-y-5">
                                    <div class="flex items-center gap-4 p-5 rounded-2xl"
                                         :class="selectedPermohonan.status === 'Selesai' ? 'bg-emerald-50 border border-emerald-200' : 'bg-rose-50 border border-rose-200'">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl shrink-0"
                                             :class="selectedPermohonan.status === 'Selesai' ? 'bg-emerald-500' : 'bg-rose-500'">
                                            <i :class="selectedPermohonan.status === 'Selesai' ? 'fa-solid fa-circle-check' : 'fa-solid fa-circle-xmark'"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-lg" :class="selectedPermohonan.status === 'Selesai' ? 'text-emerald-900' : 'text-rose-900'" x-text="'Permohonan ' + selectedPermohonan.status"></h4>
                                            <p class="text-sm font-medium" :class="selectedPermohonan.status === 'Selesai' ? 'text-emerald-700' : 'text-rose-700'">Status ini bersifat final dan tidak dapat diubah lagi.</p>
                                        </div>
                                    </div>

                                    <template x-if="selectedPermohonan.pesan_selesai || selectedPermohonan.pesan_diproses || selectedPermohonan.alasan_ditolak || selectedPermohonan.pesan_ditolak">
                                        <div class="space-y-2">
                                            <span class="text-slate-500 font-extrabold block text-xs sm:text-sm">Pesan untuk Pemohon</span>
                                            <p class="font-semibold text-slate-800 leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-200 break-words [word-break:break-word] break-all" x-text="selectedPermohonan.pesan_selesai || selectedPermohonan.alasan_ditolak || selectedPermohonan.pesan_ditolak || selectedPermohonan.pesan_diproses"></p>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <!-- BARIS 3: FORM PEMROSESAN TINDAKLANJUT PPID (hanya tampil jika status belum final) -->
                            <div x-show="!['Selesai','Ditolak'].includes(selectedPermohonan.status)" class="bg-white rounded-2xl border-2 border-sky-500/30 shadow-md p-6 sm:p-8 space-y-6">
                                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                                    <div>
                                        <h4 class="font-black text-slate-900 text-xl sm:text-xl">Tindak Lanjut Permohonan Informasi</h4>
                                        <p class="text-md text-slate-500 font-medium">Pilih status permohonan dan berikan pesan kepada pemohon</p>
                                    </div>

                                    <span class="px-4 py-1.5 rounded-full font-black text-md tracking-wider shadow-2xs border"
                                          :class="{
                                              'bg-emerald-100 text-emerald-800 border-emerald-300': selectedPermohonan.status === 'Selesai',
                                              'bg-amber-100 text-amber-800 border-amber-300': selectedPermohonan.status === 'Diproses',
                                              'bg-rose-100 text-rose-800 border-rose-300': selectedPermohonan.status === 'Ditolak',
                                              'bg-slate-100 text-slate-700 border-slate-300': selectedPermohonan.status === 'Diajukan'
                                          }"
                                          x-text="'Status Saat Ini: ' + selectedPermohonan.status">
                                    </span>
                                </div>

                                <!-- PILIHAN STATUS BARU -->
                                <div class="space-y-3" x-data="{ statusSelect: selectedPermohonan.status }">
                                    <label class="block font-black text-slate-900 text-md tracking-wider">
                                        Pilih Keputusan <span class="text-rose-500">*</span>
                                    </label>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <!-- OPSI 1: DIPROSES / VERIFIKASI -->
                                        <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all"
                                               :class="statusSelect === 'Diproses' ? 'border-amber-500 bg-amber-50/50 shadow-sm' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                            <input type="radio" name="status" value="Diproses" x-model="statusSelect" class="sr-only">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                                     :class="statusSelect === 'Diproses' ? 'bg-amber-500 ring-4 ring-amber-100' : 'bg-slate-300'">
                                                    <i class="fa-solid fa-spinner" :class="statusSelect === 'Diproses' ? 'animate-spin' : ''"></i>
                                                </div>
                                                <div>
                                                    <span class="block font-black text-slate-900 text-md">Diproses</span>
                                                    <span class="block text-[12px] text-slate-500 font-medium">Informasi sedang disiapkan</span>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- OPSI 2: SELESAI -->
                                        <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all"
                                               :class="statusSelect === 'Selesai' ? 'border-emerald-500 bg-emerald-50/50 shadow-sm' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                            <input type="radio" name="status" value="Selesai" x-model="statusSelect" class="sr-only">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                                     :class="statusSelect === 'Selesai' ? 'bg-emerald-500 ring-4 ring-emerald-100' : 'bg-slate-300'">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                                <div>
                                                    <span class="block font-black text-slate-900 text-md">Selesai</span>
                                                    <span class="block text-[12px] text-slate-500 font-medium">Permohonan dipenuhi</span>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- OPSI 3: DITOLAK -->
                                        <label class="relative flex items-center p-4 rounded-2xl border-2 cursor-pointer transition-all"
                                               :class="statusSelect === 'Ditolak' ? 'border-rose-500 bg-rose-50/50 shadow-sm' : 'border-slate-200 hover:border-slate-300 bg-white'">
                                            <input type="radio" name="status" value="Ditolak" x-model="statusSelect" class="sr-only">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                                                     :class="statusSelect === 'Ditolak' ? 'bg-rose-500 ring-4 ring-rose-100' : 'bg-slate-300'">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </div>
                                                <div>
                                                    <span class="block font-black text-slate-900 text-md">Ditolak</span>
                                                    <span class="block text-[12px] text-slate-500 font-medium">Permohonan tidak dipenuhi</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                     <!-- SECTION JIKA KEPUTUSAN: DIPROSES -->
                                     <div x-show="statusSelect === 'Diproses'" x-cloak class="p-5 bg-amber-50/80 rounded-2xl border border-amber-200/90 space-y-3">
                                         <label class="block font-black text-amber-950 text-md tracking-wider">
                                             Pesan Untuk Pemohon <span class="text-rose-500">*</span>
                                         </label>
                                         <textarea name="pesan_diproses" rows="3" placeholder="Tuliskan pesan kepada pemohon apabila informasi yang diminta membutuhkan waktu untuk disiapkan. Contoh: Permohonan sedang diverifikasi oleh tim bidang akademik..."
                                                   class="w-full p-3.5 bg-white border border-amber-300 rounded-xl text-xs sm:text-sm font-normal text-slate-600 focus:outline-none focus:ring-2 focus:ring-amber-400"
                                                   x-text="selectedPermohonan ? (selectedPermohonan.pesan_diproses || '') : ''"></textarea>
                                     </div>

                                      <!-- SECTION JIKA KEPUTUSAN: SELESAI -->
                                      <div x-show="statusSelect === 'Selesai'" x-cloak class="p-5 bg-emerald-50/80 rounded-2xl border border-emerald-200/90 space-y-4" 
                                           x-data="{ 
                                               tipeJawaban: 'file',
                                               pesanSelesai: '',
                                               isDatangLangsung() {
                                                   if (!selectedPermohonan || !selectedPermohonan.cara_memperoleh_informasi) return false;
                                                   let cara = selectedPermohonan.cara_memperoleh_informasi.toLowerCase();
                                                   return cara.includes('dekanat') || cara.includes('langsung') || cara.includes('mengambil');
                                               },
                                               initDefaultPesan() {
                                                   if (selectedPermohonan) {
                                                       if (selectedPermohonan.pesan_selesai) {
                                                           this.pesanSelesai = selectedPermohonan.pesan_selesai;
                                                       } else {
                                                           let cara = (selectedPermohonan.cara_memperoleh_informasi || '').toLowerCase();
                                                           if (cara.includes('email')) {
                                                               this.pesanSelesai = 'Permohonan Anda telah selesai dipenuhi. Silakan periksa kotak masuk email Anda (termasuk folder Spam) untuk melihat dan mengakses jawaban atas informasi yang diminta.';
                                                           } else if (cara.includes('dekanat') || cara.includes('langsung')) {
                                                               this.pesanSelesai = 'Permohonan Anda telah selesai dipenuhi. Silakan datang langsung ke kantor Dekanat FMIPA Universitas Lampung pada jam kerja untuk mengambil salinan informasi yang diminta.';
                                                           } else {
                                                               this.pesanSelesai = 'Permohonan Anda telah selesai dipenuhi.';
                                                           }
                                                       }
                                                   }
                                               }
                                           }"
                                           x-init="initDefaultPesan()"
                                           x-effect="if (statusSelect === 'Selesai' && selectedPermohonan) { initDefaultPesan(); }">
                                          <div class="space-y-1.5">
                                              <label class="block font-black text-emerald-950 text-md tracking-wider">Pesan Untuk Pemohon <span class="text-rose-500">*</span></label>
                                              <textarea name="pesan_selesai" x-model="pesanSelesai" rows="3" placeholder="Tuliskan pesan untuk pemohon..."
                                                        class="w-full p-3.5 bg-white border border-emerald-300 rounded-xl text-xs sm:text-sm font-normal text-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-400"></textarea>
                                          </div>

                                         <!-- Pilihan Tipe Lampiran Jawaban & Dynamic Input -->
                                         <div x-show="!isDatangLangsung()" class="space-y-2 pt-2 border-t border-emerald-200/70">
                                             <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                                                 <!-- Kolom Kiri: Format Jawaban Permohonan -->
                                                 <div class="md:col-span-5 space-y-2">
                                                     <label class="block font-black text-emerald-950 text-md tracking-wider">Jenis Jawaban Permohonan <span class="text-rose-500">*</span></label>
                                                     <div class="flex items-center gap-3">
                                                         <label class="flex items-center gap-2 px-4 py-2.5 bg-white/80 border border-emerald-300 rounded-xl cursor-pointer hover:bg-white transition shadow-xs">
                                                             <input type="radio" value="file" x-model="tipeJawaban" class="accent-emerald-600">
                                                             <span class="font-extrabold text-xs sm:text-sm text-emerald-950">File</span>
                                                         </label>
                                                         <label class="flex items-center gap-2 px-4 py-2.5 bg-white/80 border border-emerald-300 rounded-xl cursor-pointer hover:bg-white transition shadow-xs">
                                                             <input type="radio" value="link" x-model="tipeJawaban" class="accent-emerald-600">
                                                             <span class="font-extrabold text-xs sm:text-sm text-emerald-950">Tautan</span>
                                                         </label>
                                                     </div>
                                                 </div>

                                                 <!-- Kolom Kanan: Upload File / Tautan URL -->
                                                 <div class="md:col-span-7 space-y-1.5">
                                                     <div x-show="tipeJawaban === 'file'" class="space-y-1.5">
                                                         <label class="block font-black text-emerald-950 text-md tracking-wider">Upload File <span class="text-rose-500">*</span></label>
                                                         <input type="file" name="file_jawaban" accept=".pdf,.docx,.zip,.rar"
                                                                class="w-full p-2.5 bg-white border border-emerald-300 rounded-xl text-slate-700 text-xs sm:text-sm font-medium file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 transition">
                                                         <p class="text-[11px] text-emerald-800/80 font-medium">Format yang didukung: PDF, DOC, DOCX (Maks 5MB)</p>
                                                     </div>
                                                     <div x-show="tipeJawaban === 'link'" class="space-y-1.5">
                                                         <label class="block font-black text-emerald-950 text-md tracking-wider">Tautan / URL Dokumen <span class="text-rose-500">*</span></label>
                                                         <input type="url" name="link_jawaban" placeholder="https://drive.google.com/..."
                                                                class="w-full p-3 bg-white border border-emerald-300 rounded-xl text-slate-800 text-xs sm:text-sm font-normal focus:outline-none focus:ring-2 focus:ring-emerald-400 transition">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <!-- SECTION JIKA KEPUTUSAN: DITOLAK -->
                                     <div x-show="statusSelect === 'Ditolak'" x-cloak class="p-5 bg-rose-50/80 rounded-2xl border border-rose-200/90 space-y-3">
                                         <label class="block font-black text-rose-950 text-md tracking-wider">Alasan Penolakan <span class="text-rose-600">*</span></label>
                                         <textarea name="alasan_ditolak" rows="3" placeholder="Jelaskan alasan penolakan permohonan ini..."
                                                   class="w-full p-3.5 bg-white border border-rose-300 rounded-xl text-xs sm:text-sm font-normal text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-400"></textarea>
                                     </div>
                                 </div>
                             </div>

                         </div>
                     </template>
                 </div>

                 <!-- Footer Action Buttons -->
                 <div class="p-6 bg-white border-t border-slate-200 flex items-center justify-end gap-3 shrink-0">
                     <button type="button" @click="closeModal()" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold text-xs sm:text-sm rounded-xl transition cursor-pointer">
                         <span x-text="selectedPermohonan && ['Selesai','Ditolak'].includes(selectedPermohonan.status) ? 'Tutup' : 'Batal'"></span>
                     </button>
                     <button x-show="selectedPermohonan && !['Selesai','Ditolak'].includes(selectedPermohonan.status)" type="submit" class="px-8 py-3 bg-sky-500 hover:bg-sky-600 text-white font-black text-xs sm:text-sm rounded-xl transition shadow-md cursor-pointer flex items-center gap-2">
                         Simpan
                     </button>
                 </div></div>

            </form>
        </div>
    </div>
