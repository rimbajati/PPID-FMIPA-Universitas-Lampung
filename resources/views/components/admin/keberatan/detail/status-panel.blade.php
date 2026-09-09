@props(['keberatan'])

<div class="bg-white rounded border border-slate-200/90 shadow-2xs overflow-hidden" 
     x-data="{
        statusSelect: '{{ in_array($keberatan->status, ['Selesai', 'Ditolak']) ? $keberatan->status : 'Diproses' }}',
        tipeJawaban: '{{ $keberatan->link_jawaban ? 'link' : 'file' }}',
        hasFileJawaban: {{ $keberatan->file_jawaban ? 'true' : 'false' }},
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

        <!-- Status Keberatan Saat Ini (Tanpa Kotak Abu-Abu Besar) -->
        <div class="text-center py-2 space-y-2 border-b border-slate-100 pb-5">
            <span class="text-sm font-bold text-slate-500 block">Status Saat Ini:</span>
            
            @if($keberatan->status === 'Diajukan')
                <span class="inline-block px-4 py-1.5 text-xs font-black bg-slate-100 text-slate-800 rounded-xl border border-slate-300 shadow-2xs">
                    Diajukan
                </span>
            @elseif($keberatan->status === 'Diproses')
                <span class="inline-block px-4 py-1.5 text-xs font-black bg-orange-100 text-orange-800 rounded-xl border border-orange-300 shadow-2xs">
                    Diproses
                </span>
            @elseif($keberatan->status === 'Selesai')
                <span class="inline-block px-4 py-1.5 text-xs font-black bg-emerald-100 text-emerald-800 rounded-xl border border-emerald-300 shadow-2xs">
                    Selesai
                </span>
            @elseif($keberatan->status === 'Ditolak')
                <span class="inline-block px-4 py-1.5 text-xs font-black bg-rose-100 text-rose-800 rounded-xl border border-rose-300 shadow-2xs">
                    Ditolak
                </span>
            @endif

            <div class="pt-1 flex items-center justify-center gap-1 text-[11px] text-slate-400 font-semibold">
                <i class="fa-regular fa-clock"></i>
                <span>Diperbarui: {{ $keberatan->updated_at ? $keberatan->updated_at->diffForHumans() : '-' }}</span>
            </div>
        </div>

        <!-- KONDISI JIKA STATUS SUDAH FINAL (SELESAI / DITOLAK) -->
        @if(in_array($keberatan->status, ['Selesai', 'Ditolak']))
            <div class="p-4 rounded-xs border {{ $keberatan->status === 'Selesai' ? 'bg-emerald-50/60 border-emerald-200' : 'bg-rose-50/60 border-rose-200' }} space-y-3">
                <div class="flex items-center gap-2">
                    <i class="fa-solid {{ $keberatan->status === 'Selesai' ? 'fa-circle-check text-emerald-600' : 'fa-circle-xmark text-rose-600' }}"></i>
                    <span class="font-black text-xs sm:text-sm {{ $keberatan->status === 'Selesai' ? 'text-emerald-900' : 'text-rose-900' }}">
                        Keputusan Final Atasan PPID
                    </span>
                </div>
                <p class="text-xs font-medium {{ $keberatan->status === 'Selesai' ? 'text-emerald-700' : 'text-rose-700' }} leading-relaxed">
                    Keberatan ini telah diputuskan dengan status <span class="font-bold">{{ $keberatan->status }}</span> dan tidak dapat diubah kembali.
                </p>

                <!-- Catatan / Respon Atasan PPID yang Tersimpan -->
                @php
                    $pesanTersimpan = $keberatan->catatan_selesai ?: ($keberatan->alasan_ditolak ?: $keberatan->tanggapan_atasan);
                @endphp
                @if($pesanTersimpan)
                    <div class="pt-2 border-t {{ $keberatan->status === 'Selesai' ? 'border-emerald-200' : 'border-rose-200' }}">
                        <span class="text-[11px] font-black uppercase tracking-wider block mb-1.5 text-slate-600">Catatan Tanggapan Atasan PPID:</span>
                        <div class="bg-white/90 p-3 rounded-md border border-slate-200 text-xs font-semibold text-slate-800 whitespace-pre-line leading-relaxed">{{ trim($pesanTersimpan) }}</div>
                    </div>
                @endif

                <!-- Berkas / Link Keputusan jika Selesai -->
                @if($keberatan->status === 'Selesai')
                    @if($keberatan->file_jawaban)
                        <div class="pt-2">
                            <a href="{{ asset('storage/' . $keberatan->file_jawaban) }}" target="_blank" 
                               class="w-full py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xs transition flex items-center justify-center gap-2 shadow-2xs">
                                <i class="fa-solid fa-file-arrow-down"></i>
                                <span>Unduh Surat Keputusan / Berkas Jawaban</span>
                            </a>
                        </div>
                    @elseif($keberatan->link_jawaban)
                        <div class="pt-2">
                            <a href="{{ $keberatan->link_jawaban }}" target="_blank" 
                               class="w-full py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xs transition flex items-center justify-center gap-2 shadow-2xs">
                                <i class="fa-solid fa-link"></i>
                                <span>Buka Tautan Jawaban Keberatan</span>
                            </a>
                        </div>
                    @endif
                @endif
            </div>

        <!-- KONDISI NORMAL: FORM PEMROSESAN ATASAN AKTIF -->
        @else
            <form x-ref="statusForm" action="{{ route('admin.keberatan.update-status', $keberatan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <label class="block font-black text-slate-800 text-xs sm:text-sm">
                        Pilih Keputusan / Tahap <span class="text-rose-500">*</span>
                    </label>

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

                        <!-- 2. SELESAI / DIKABULKAN -->
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
                              placeholder="Contoh: Pengajuan keberatan sedang dibahas bersama Komisi Etik PPID..."
                              class="w-full p-3 bg-white border border-orange-300 rounded text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-orange-400">{{ old('catatan_diproses', $keberatan->catatan_diproses) }}</textarea>

                    <x-admin.input-error name="catatan_diproses" />
                </div>

                <!-- SUB-FORM: JIKA STATUS SELESAI / DIKABULKAN -->
                <div x-show="statusSelect === 'Selesai'" x-cloak class="p-4 bg-emerald-50/80 border border-emerald-200 rounded-md space-y-3.5">
                    <div class="space-y-1.5">
                        <label class="block font-black text-emerald-950 text-xs">
                            Catatan untuk Pemohon <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="catatan_selesai" rows="3" 
                                  :required="statusSelect === 'Selesai'"
                                  placeholder="Tuliskan keputusan resmi dan instruksi tindak lanjut pemenuhan permohonan..."
                                  class="w-full p-3 bg-white border border-emerald-300 rounded text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400">{{ old('catatan_selesai', $keberatan->catatan_selesai ?? 'Pengajuan keberatan Anda telah diterima dan disetujui. Silakan periksa kotak masuk email Anda (termasuk folder Spam) untuk mengakses informasi yang diminta.') }}</textarea>

                        <x-admin.input-error name="catatan_selesai" />
                    </div>

                    <!-- Jenis Dokumen Jawaban -->
                    <div class="pt-2 border-t border-emerald-200 space-y-2">
                        <label class="block font-black text-emerald-950 text-xs">Jenis Jawaban Keberatan <span class="text-rose-500">*</span></label>
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

                        <!-- Upload File Input -->
                        <div x-show="tipeJawaban === 'file'" class="pt-1.5 space-y-1">
                            <input type="file" name="file_jawaban" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip,.rar"
                                   :required="statusSelect === 'Selesai' && tipeJawaban === 'file' && !hasFileJawaban"
                                   class="w-full p-2 bg-white border border-emerald-300 rounded text-xs text-slate-700 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-[11px] file:font-black file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition cursor-pointer">
                            
                            <x-admin.input-error name="file_jawaban" />

                            @if($keberatan->file_jawaban)
                                <p class="text-[11px] text-emerald-700 font-medium">Berkas saat ini: <span class="font-bold underline">{{ basename($keberatan->file_jawaban) }}</span></p>
                            @endif
                            <p class="text-[10px] text-emerald-800 font-medium">PDF, DOC, DOCX, XLS, XLSX, ZIP (Maks. 5MB)</p>
                        </div>

                        <!-- Link URL Input -->
                        <div x-show="tipeJawaban === 'link'" class="pt-1.5 space-y-1">
                            <input type="url" name="link_jawaban" 
                                   :required="statusSelect === 'Selesai' && tipeJawaban === 'link'"
                                   value="{{ old('link_jawaban', $keberatan->link_jawaban) }}"
                                   placeholder="https://drive.google.com/..."
                                   class="w-full p-2.5 bg-white border border-emerald-300 rounded text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                            
                            <x-admin.input-error name="link_jawaban" />
                        </div>
                    </div>
                </div>

                <!-- SUB-FORM: JIKA STATUS DITOLAK -->
                <div x-show="statusSelect === 'Ditolak'" x-cloak class="p-4 bg-rose-50/80 border border-rose-200 rounded-md space-y-2.5">
                    <label class="block font-black text-rose-950 text-xs">
                        Alasan Penolakan Keberatan <span class="text-rose-600">*</span>
                    </label>
                    <textarea name="alasan_ditolak" rows="3" 
                              :required="statusSelect === 'Ditolak'"
                              placeholder="Berikan pertimbangan hukum / regulasi penolakan keberatan ini..."
                              class="w-full p-3 bg-white border border-rose-300 rounded text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-400">{{ old('alasan_ditolak', $keberatan->alasan_ditolak) }}</textarea>

                    <x-admin.input-error name="alasan_ditolak" />
                </div>

                <!-- Tombol Trigger Konfirmasi Atasan PPID -->
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
                        <span x-text="statusSelect === 'Selesai' ? 'Terima & Selesaikan Keberatan' : (statusSelect === 'Ditolak' ? 'Tolak Keberatan' : 'Simpan & Perbarui Status')"></span>
                    </button>
                </div>

                <!-- Modal Konfirmasi Putusan Keberatan (Teleported ke body) -->
                @include('components.admin.keberatan.detail.modal-konfirmasi', ['keberatan' => $keberatan])
            </form>
        @endif

    </div>
</div>
