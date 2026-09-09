@props(['permohonan'])

<div class="bg-white rounded border border-slate-200/90 shadow-2xs overflow-hidden" 
     x-data="{
        statusSelect: '{{ in_array($permohonan->status, ['Selesai', 'Ditolak']) ? $permohonan->status : 'Diproses' }}',
        tipeJawaban: '{{ $permohonan->link_jawaban ? 'link' : 'file' }}',
        hasFileJawaban: {{ $permohonan->file_jawaban ? 'true' : 'false' }},
        showConfirmModal: false,
        triggerConfirm() {
            if (this.$refs.statusForm.reportValidity()) {
                this.showConfirmModal = true;
            }
        }
     }">

    <!-- Header Panel Kanan: Background abu-abu terang, ikon + teks persis referensi -->
    <div class="bg-slate-50/80 px-5 py-3 border-b border-slate-200/90 flex items-center justify-between">
        <div class="flex items-center gap-2 text-slate-900 font-extrabold text-sm sm:text-base">
            <i class="fa-solid fa-sliders text-slate-900 text-sm"></i>
            <span>Status & Aksi Pemrosesan</span>
        </div>
    </div>

    <div class="p-6 space-y-6">

        <!-- Status Saat Ini (Tanpa Kotak Abu-Abu Besar) -->
        <div class="text-center py-2 space-y-2 border-b border-slate-100 pb-5">
            <span class="text-sm font-bold text-slate-500 block">Status Saat Ini:</span>
            
            @if($permohonan->status === 'Diajukan')
                <span class="inline-block px-4 py-1.5 text-xs font-black bg-slate-100 text-slate-800 rounded-xl border border-slate-300 shadow-2xs">
                    Diajukan
                </span>
            @elseif($permohonan->status === 'Diproses')
                <span class="inline-block px-4 py-1.5 text-xs font-black bg-orange-100 text-orange-800 rounded-xl border border-orange-300 shadow-2xs">
                    Diproses
                </span>
            @elseif($permohonan->status === 'Selesai')
                <span class="inline-block px-4 py-1.5 text-xs font-black bg-emerald-100 text-emerald-800 rounded-xl border border-emerald-300 shadow-2xs">
                    Selesai
                </span>
            @elseif($permohonan->status === 'Ditolak')
                <span class="inline-block px-4 py-1.5 text-xs font-black bg-rose-100 text-rose-800 rounded-xl border border-rose-300 shadow-2xs">
                    Ditolak
                </span>
            @endif

            <div class="pt-1 flex items-center justify-center gap-1 text-[11px] text-slate-400 font-semibold">
                <i class="fa-regular fa-clock"></i>
                <span>Diperbarui: {{ $permohonan->updated_at ? $permohonan->updated_at->diffForHumans() : '-' }}</span>
            </div>
        </div>

        <!-- KONDISI JIKA STATUS SUDAH FINAL (SELESAI / DITOLAK) -->
        @if(in_array($permohonan->status, ['Selesai', 'Ditolak']))
            <div class="p-4 rounded-2xl border {{ $permohonan->status === 'Selesai' ? 'bg-emerald-50/60 border-emerald-200' : 'bg-rose-50/60 border-rose-200' }} space-y-3">
                <div class="flex items-center gap-2">
                    <i class="fa-solid {{ $permohonan->status === 'Selesai' ? 'fa-circle-check text-emerald-600' : 'fa-circle-xmark text-rose-600' }}"></i>
                    <span class="font-black text-xs sm:text-sm {{ $permohonan->status === 'Selesai' ? 'text-emerald-900' : 'text-rose-900' }}">
                        Keputusan Final
                    </span>
                </div>
                <p class="text-xs font-medium {{ $permohonan->status === 'Selesai' ? 'text-emerald-700' : 'text-rose-700' }} leading-relaxed">
                    Permohonan ini telah berstatus <span class="font-bold">{{ $permohonan->status }}</span> dan keputusan tidak dapat diubah lagi.
                </p>

                <!-- Catatan untuk Pemohon yang Tersimpan -->
                @php
                    $pesanTersimpan = $permohonan->status === 'Selesai' ? $permohonan->catatan_selesai : ($permohonan->alasan_ditolak ?: $permohonan->pesan_ditolak);
                @endphp
                @if($pesanTersimpan)
                    <div class="pt-2 border-t {{ $permohonan->status === 'Selesai' ? 'border-emerald-200' : 'border-rose-200' }}">
                        <span class="text-[11px] font-black uppercase tracking-wider block mb-1.5 text-slate-600">Catatan untuk Pemohon:</span>
                        <div class="bg-white/90 p-3 rounded-md border border-slate-200 text-xs font-semibold text-slate-800 whitespace-pre-line leading-relaxed">{{ trim($pesanTersimpan) }}</div>
                    </div>
                @endif

                <!-- Berkas / Link Balasan jika Selesai -->
                @if($permohonan->status === 'Selesai')
                    @if($permohonan->file_jawaban)
                        <div class="pt-2">
                            <a href="{{ asset('storage/' . $permohonan->file_jawaban) }}" target="_blank" 
                               class="w-full py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xl transition flex items-center justify-center gap-2 shadow-2xs">
                                <i class="fa-solid fa-file-arrow-down"></i>
                                <span>Unduh File Jawaban Informasi</span>
                            </a>
                        </div>
                    @elseif($permohonan->link_jawaban)
                        <div class="pt-2">
                            <a href="{{ $permohonan->link_jawaban }}" target="_blank" 
                               class="w-full py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xl transition flex items-center justify-center gap-2 shadow-2xs">
                                <i class="fa-solid fa-link"></i>
                                <span>Buka Tautan Jawaban Informasi</span>
                            </a>
                        </div>
                    @endif
                @endif
            </div>

        <!-- KONDISI JIKA ADA SENGKETA KEBERATAN (KUNCI AKSI JIKA STATUS BELUM FINAL) -->
        @elseif($permohonan->keberatan)
            <div class="p-4 bg-slate-100 border border-slate-200 rounded-2xl space-y-2 text-center">
                <i class="fa-solid fa-lock text-slate-400 text-xl"></i>
                <h4 class="font-black text-slate-700 text-xs sm:text-sm">Pemrosesan Dialihkan</h4>
                <p class="text-[11px] text-slate-500 font-medium leading-relaxed">
                    Pemrosesan tiket ini dikunci karena sedang dalam penanganan berkas keberatan.
                </p>
            </div>

        <!-- KONDISI NORMAL: FORM PEMROSESAN AKTIF -->
        @else
            <form x-ref="statusForm" action="{{ route('admin.permohonan.update-status', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <label class="block font-black text-slate-800 text-xs sm:text-sm">
                        Pilih Keputusan / Tahap <span class="text-rose-500">*</span>
                    </label>

                    <!-- Pilihan Radio Keputusan -->
                    <div class="grid grid-cols-3 gap-2">
                        <!-- 1. DIPROSES -->
                        <label class="flex flex-col items-center justify-center p-2 sm:p-2.5 rounded-xl border-2 cursor-pointer transition text-center"
                               :class="statusSelect === 'Diproses' ? 'border-orange-500 bg-orange-50/50 shadow-2xs' : 'border-slate-200 hover:border-slate-300 bg-white'">
                            <input type="radio" name="status" value="Diproses" x-model="statusSelect" class="sr-only">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center text-white text-xs font-bold shrink-0 mb-1"
                                 :class="statusSelect === 'Diproses' ? 'bg-orange-500' : 'bg-slate-200 text-slate-400'">
                                <i class="fa-solid fa-gears text-[11px]" :class="statusSelect === 'Diproses' ? 'fa-spin' : ''"></i>
                            </div>
                            <span class="block font-black text-slate-900 text-xs">Diproses</span>
                        </label>

                        <!-- 2. SELESAI -->
                        <label class="flex flex-col items-center justify-center p-2 sm:p-2.5 rounded-xl border-2 cursor-pointer transition text-center"
                               :class="statusSelect === 'Selesai' ? 'border-emerald-500 bg-emerald-50/50 shadow-2xs' : 'border-slate-200 hover:border-slate-300 bg-white'">
                            <input type="radio" name="status" value="Selesai" x-model="statusSelect" class="sr-only">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center text-white text-xs font-bold shrink-0 mb-1"
                                 :class="statusSelect === 'Selesai' ? 'bg-emerald-500' : 'bg-slate-200 text-slate-400'">
                                <i class="fa-solid fa-check text-[11px]"></i>
                            </div>
                            <span class="block font-black text-slate-900 text-xs">Selesai</span>
                        </label>

                        <!-- 3. DITOLAK -->
                        <label class="flex flex-col items-center justify-center p-2 sm:p-2.5 rounded-xl border-2 cursor-pointer transition text-center"
                               :class="statusSelect === 'Ditolak' ? 'border-rose-500 bg-rose-50/50 shadow-2xs' : 'border-slate-200 hover:border-slate-300 bg-white'">
                            <input type="radio" name="status" value="Ditolak" x-model="statusSelect" class="sr-only">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center text-white text-xs font-bold shrink-0 mb-1"
                                 :class="statusSelect === 'Ditolak' ? 'bg-rose-500' : 'bg-slate-200 text-slate-400'">
                                <i class="fa-solid fa-xmark text-[11px]"></i>
                            </div>
                            <span class="block font-black text-slate-900 text-xs">Ditolak</span>
                        </label>
                    </div>
                </div>

                <!-- SUB-FORM: JIKA STATUS DIPROSES -->
                <div x-show="statusSelect === 'Diproses'" x-cloak class="p-4 bg-orange-50/80 border border-orange-200 rounded-md space-y-2.5">
                    <label class="block font-black text-orange-950 text-xs">
                        Catatan untuk Pemohon <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="catatan_diproses" rows="3" 
                              :required="statusSelect === 'Diproses'"
                              placeholder="Berikan catatan kepada pemohon apabila informasi yang diminta membutuhkan waktu untuk disiapkan. Contoh: Dokumen sedang dikoordinasikan dengan bagian terkait..."
                              class="w-full p-3 bg-white border border-orange-300 rounded text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('catatan_diproses', $permohonan->catatan_diproses) }}</textarea>
                    
                    <x-admin.input-error name="catatan_diproses" />

                    <p class="text-[10px] text-amber-800 font-medium">Catatan ini akan otomatis dikirimkan ke email pemohon.</p>
                </div>

                <!-- SUB-FORM: JIKA STATUS SELESAI -->
                <div x-show="statusSelect === 'Selesai'" x-cloak class="p-4 bg-emerald-50/80 border border-emerald-200 rounded-md space-y-3.5">
                    <div class="space-y-1.5">
                        <label class="block font-black text-emerald-950 text-xs">
                            Catatan untuk Pemohon <span class="text-rose-500">*</span>
                        </label>
                        @php
                            $defaultCatatanSelesai = $permohonan->catatan_selesai;
                            if (!$defaultCatatanSelesai) {
                                $cara = strtolower($permohonan->cara_memperoleh_informasi ?? '');
                                if (str_contains($cara, 'email')) {
                                    $defaultCatatanSelesai = 'Permohonan Anda telah selesai dipenuhi. Silakan periksa kotak masuk email Anda (termasuk folder Spam) untuk mengakses informasi yang diminta.';
                                } else {
                                    $defaultCatatanSelesai = 'Permohonan Anda telah selesai dipenuhi. Silakan datang langsung ke Dekanat FMIPA Universitas Lampung pada jam kerja untuk mengambil salinan informasi.';
                                }
                            }
                        @endphp
                        <textarea name="catatan_selesai" rows="3"
                                  :required="statusSelect === 'Selesai'"
                                  placeholder="Tuliskan catatan penyelesaian permohonan..."
                                  class="w-full p-3 bg-white border border-emerald-300 rounded text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400">{{ old('catatan_selesai', $defaultCatatanSelesai) }}</textarea>
                        
                        <x-admin.input-error name="catatan_selesai" />
                    </div>

                    <!-- Jenis Dokumen Jawaban -->
                    <div class="pt-2 border-t border-emerald-200 space-y-2">
                        <label class="block font-black text-emerald-950 text-xs">Jenis Jawaban Permohonan <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center justify-center gap-2 p-2 bg-white rounded border border-emerald-300 cursor-pointer text-xs font-bold text-emerald-900">
                                <input type="radio" value="file" x-model="tipeJawaban" class="accent-emerald-600">
                                <span>File</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 p-2 bg-white rounded border border-emerald-300 cursor-pointer text-xs font-bold text-emerald-900">
                                <input type="radio" value="link" x-model="tipeJawaban" class="accent-emerald-600">
                                <span>Tautan</span>
                            </label>
                        </div>

                        <div x-show="tipeJawaban === 'file'" class="pt-1.5 space-y-1">
                            <input type="file" name="file_jawaban" accept=".pdf,.docx,.xlsx,.zip,.rar"
                                   :required="statusSelect === 'Selesai' && tipeJawaban === 'file' && !hasFileJawaban"
                                   class="w-full p-2 bg-white border border-emerald-300 rounded text-xs text-slate-700 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-[11px] file:font-black file:bg-emerald-600 file:text-white">
                            
                            <x-admin.input-error name="file_jawaban" />

                            <p class="text-[10px] text-emerald-800 font-medium">PDF, DOCX, ZIP (Maks. 5MB)</p>
                        </div>

                        <div x-show="tipeJawaban === 'link'" class="pt-1.5 space-y-1">
                            <input type="url" name="link_jawaban" placeholder="https://fmipa.unila.ac.id/dokumen/..." 
                                   value="{{ old('link_jawaban', $permohonan->link_jawaban) }}"
                                   :required="statusSelect === 'Selesai' && tipeJawaban === 'link'"
                                   class="w-full p-2.5 bg-white border border-emerald-300 rounded text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                            
                            <x-admin.input-error name="link_jawaban" />
                        </div>
                    </div>
                </div>

                <!-- SUB-FORM: JIKA STATUS DITOLAK -->
                <div x-show="statusSelect === 'Ditolak'" x-cloak class="p-4 bg-rose-50/80 border border-rose-200 rounded-md space-y-2.5">
                    <label class="block font-black text-rose-950 text-xs">
                        Alasan Penolakan <span class="text-rose-600">*</span>
                    </label>
                    <textarea name="alasan_ditolak" rows="3" 
                              :required="statusSelect === 'Ditolak'"
                              placeholder="Berikan dasar/alasan penolakan permohonan informasi ini..."
                              class="w-full p-3 bg-white border border-rose-300 rounded text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-400">{{ old('alasan_ditolak', $permohonan->alasan_ditolak) }}</textarea>
                    
                    <x-admin.input-error name="alasan_ditolak" />

                    <p class="text-[10px] text-rose-800 font-medium">Alasan ini akan disampaikan secara transparan kepada pemohon.</p>
                </div>

                <!-- Tombol Trigger Konfirmasi -->
                <div class="pt-2">
                    <button type="button" 
                            @click="triggerConfirm()"
                            class="w-full py-3.5 px-4 font-black text-xs sm:text-sm rounded-md transition flex items-center justify-center gap-2 shadow-md cursor-pointer text-white"
                            :class="{
                                'bg-orange-500 hover:bg-orange-600': statusSelect === 'Diproses',
                                'bg-emerald-600 hover:bg-emerald-700': statusSelect === 'Selesai',
                                'bg-rose-600 hover:bg-rose-700': statusSelect === 'Ditolak'
                            }">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span x-text="statusSelect === 'Selesai' ? 'Setujui & Selesaikan Permohonan' : (statusSelect === 'Ditolak' ? 'Tolak Permohonan' : 'Simpan & Perbarui Status')"></span>
                    </button>
                </div>

                <!-- Modal Konfirmasi Perubahan Status (Teleported ke body) -->
                @include('components.admin.permohonan.detail.modal-konfirmasi', ['noTiket' => $permohonan->no_tiket])
        </form>
        @endif

    </div>
</div>

<!-- BOX SENGKETA KEBERATAN (Tampil di bawah Status & Aksi Pemrosesan) -->
@if($permohonan->keberatan)
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-md shadow-2xs p-5 text-white space-y-3.5 border border-amber-600">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded bg-white/20 flex items-center justify-center text-white shrink-0 text-lg">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <div>
                <h4 class="font-black text-sm leading-tight text-white">Dalam Pengajuan Keberatan</h4>
                <p class="text-[11px] text-amber-100 font-semibold mt-1 leading-relaxed">
                    Pemohon telah mengajukan keberatan atas permohonan ini dengan nomor tiket <span class="font-bold underline text-white">{{ $permohonan->keberatan->no_tiket }}</span>.
                </p>
            </div>
        </div>

        <div class="pt-2 border-t border-amber-400/40">
            <a href="{{ route('admin.keberatan.show', $permohonan->keberatan->id) }}" 
               class="w-full py-2.5 px-4 bg-white hover:bg-amber-50 text-amber-900 font-black text-xs rounded transition flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                <span>Buka Pengajuan Keberatan</span>
                <i class="fa-solid fa-arrow-right text-[11px]"></i>
            </a>
        </div>
    </div>
@endif
