@props(['keberatan'])

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden"
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

    <div class="px-5 py-4 border-b border-slate-100">
        <p class="text-sm font-semibold text-slate-900">Status Keberatan</p>
        <p class="text-xs text-slate-500 mt-0.5">Tentukan keputusan atas keberatan yang diajukan</p>
    </div>

    <div class="p-5">
        @if(in_array($keberatan->status, ['Selesai', 'Ditolak']))
            <div class="space-y-3">
                <p class="text-sm text-slate-600 leading-relaxed">Keberatan berstatus <span class="font-semibold text-slate-900">{{ $keberatan->status }}</span> — tidak dapat diubah.</p>
                @php $pesanTersimpan = $keberatan->catatan_selesai ?: ($keberatan->alasan_ditolak ?: $keberatan->tanggapan_atasan); @endphp
                @if($pesanTersimpan)
                    <div class="rounded-lg bg-slate-50 border border-slate-200 px-3 py-3 text-xs leading-relaxed text-slate-700 whitespace-pre-line">{{ trim($pesanTersimpan) }}</div>
                @endif
                @if($keberatan->status === 'Selesai')
                    @if($keberatan->file_jawaban)
                        <a href="{{ asset('storage/' . $keberatan->file_jawaban) }}" target="_blank" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 hover:bg-black text-white text-xs font-medium py-2.5 transition"><i class="fa-solid fa-download text-xs"></i> Unduh file keputusan</a>
                    @elseif($keberatan->link_jawaban)
                        <a href="{{ $keberatan->link_jawaban }}" target="_blank" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 hover:bg-black text-white text-xs font-medium py-2.5 transition"><i class="fa-solid fa-link text-xs"></i> Buka tautan</a>
                    @endif
                @endif
                <p class="text-[11px] text-slate-400">Diperbarui {{ $keberatan->updated_at ? $keberatan->updated_at->diffForHumans() : '-' }}</p>
            </div>
        @else
            <form x-ref="statusForm" action="{{ route('admin.keberatan.update-status', $keberatan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <p class="text-sm font-medium text-slate-700 mb-2">Keputusan <span class="text-rose-500">*</span></p>
                    <div class="inline-flex p-1 bg-slate-100 rounded-full">
                        <label class="px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition" :class="statusSelect === 'Diproses' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500'">
                            <input type="radio" name="status" value="Diproses" x-model="statusSelect" class="sr-only"> Diproses
                        </label>
                        <label class="px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition" :class="statusSelect === 'Selesai' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500'">
                            <input type="radio" name="status" value="Selesai" x-model="statusSelect" class="sr-only"> Selesai
                        </label>
                        <label class="px-4 py-2 rounded-full text-sm font-medium cursor-pointer transition" :class="statusSelect === 'Ditolak' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500'">
                            <input type="radio" name="status" value="Ditolak" x-model="statusSelect" class="sr-only"> Ditolak
                        </label>
                    </div>
                </div>

                <div x-show="statusSelect === 'Diproses'" x-cloak class="space-y-1.5">
                    <label class="text-sm font-medium text-slate-700">Catatan pemrosesan <span class="text-rose-500">*</span></label>
                    <textarea name="catatan_diproses" rows="9" :required="statusSelect === 'Diproses'" placeholder="Tulis catatan pemrosesan..."
                              class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 placeholder:text-slate-400">{{ old('catatan_diproses', $keberatan->catatan_diproses) }}</textarea>
                    <x-admin.input-error name="catatan_diproses" />
                    <p class="text-xs text-slate-400">Terkirim otomatis ke email pemohon.</p>
                </div>

                <div x-show="statusSelect === 'Selesai'" x-cloak class="space-y-3">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-700">Catatan penyelesaian <span class="text-rose-500">*</span></label>
                        <textarea name="catatan_selesai" rows="9" :required="statusSelect === 'Selesai'"
                                  placeholder="Tuliskan keputusan atasan PPID..."
                                  class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200">{{ old('catatan_selesai', $keberatan->catatan_selesai ?? 'Pengajuan keberatan Anda telah diterima dan disetujui. Silakan cek email Anda (termasuk Spam).') }}</textarea>
                        <x-admin.input-error name="catatan_selesai" />
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-slate-700">Jawaban <span class="text-rose-500">*</span></p>
                        <div class="flex gap-2">
                            <label class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg border text-xs font-medium cursor-pointer" :class="tipeJawaban === 'file' ? 'border-sky-500 bg-sky-500 text-white' : 'border-slate-200 bg-white text-slate-600'">
                                <input type="radio" value="file" x-model="tipeJawaban" class="sr-only"> File
                            </label>
                            <label class="flex-1 flex items-center justify-center gap-1.5 py-2 rounded-lg border text-xs font-medium cursor-pointer" :class="tipeJawaban === 'link' ? 'border-sky-500 bg-sky-500 text-white' : 'border-slate-200 bg-white text-slate-600'">
                                <input type="radio" value="link" x-model="tipeJawaban" class="sr-only"> Tautan
                            </label>
                        </div>
                        <div x-show="tipeJawaban === 'file'" x-data="{
                            fileName: '',
                            fileSize: '',
                            fileUrl: '{{ $keberatan->file_jawaban ? asset('storage/' . $keberatan->file_jawaban) : '' }}',
                            fileError: '',
                            init() { if (this.fileUrl) { let name = '{{ $keberatan->file_jawaban ? basename($keberatan->file_jawaban) : '' }}'; this.fileName = name; } },
                            handle(e) {
                                const f = e.target.files[0];
                                this.fileError='';
                                if (!f) return;
                                if (f.size > 5*1024*1024) { this.fileError='Ukuran file maksimal 5 MB'; e.target.value=''; this.fileName=''; this.fileSize=''; if(this.fileUrl) URL.revokeObjectURL(this.fileUrl); this.fileUrl=''; return; }
                                this.fileName = f.name;
                                this.fileSize = (f.size / 1024).toFixed(1) + ' KB';
                                if (f.size > 1024*1024) this.fileSize = (f.size / (1024*1024)).toFixed(1) + ' MB';
                                this.fileUrl = URL.createObjectURL(f);
                            },
                            clear() { document.getElementById('admin_keberatan_file').value = ''; this.fileName = ''; this.fileSize = ''; this.fileUrl = ''; this.fileError=''; }
                        }">
                            <input type="file" id="admin_keberatan_file" name="file_jawaban" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" @change="handle($event)" class="sr-only">
                            <div @click="document.getElementById('admin_keberatan_file').click()" class="flex items-center gap-2 w-full rounded-lg border border-slate-200 bg-white p-2 pr-2 cursor-pointer transition hover:border-slate-300">
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
                            <p class="text-xs text-slate-400 mt-1">Format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG (Maksimal 5 MB)</p>
                        </div>
                        <div x-show="tipeJawaban === 'link'">
                            <input type="url" name="link_jawaban" placeholder="https://..." value="{{ old('link_jawaban', $keberatan->link_jawaban) }}" :required="statusSelect === 'Selesai' && tipeJawaban === 'link'"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200">
                            <x-admin.input-error name="link_jawaban" />
                        </div>
                    </div>
                </div>

                <div x-show="statusSelect === 'Ditolak'" x-cloak class="space-y-1.5">
                    <label class="text-sm font-medium text-slate-700">Alasan penolakan <span class="text-rose-500">*</span></label>
                    <textarea name="alasan_ditolak" rows="9" :required="statusSelect === 'Ditolak'" placeholder="Tulis alasan penolakan..."
                              class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200">{{ old('alasan_ditolak', $keberatan->alasan_ditolak) }}</textarea>
                    <x-admin.input-error name="alasan_ditolak" />
                </div>

                <div class="pt-1">
                    <button type="button" @click="triggerConfirm()" class="w-full rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-sm font-medium py-2.5 transition">Perbarui Status</button>
                    <p class="text-[11px] text-center text-slate-400 mt-2">Diperbarui {{ $keberatan->updated_at ? $keberatan->updated_at->diffForHumans() : '-' }}</p>
                </div>

                @include('components.admin.keberatan.detail.modal-konfirmasi', ['keberatan' => $keberatan])
            </form>
        @endif
    </div>
</div>
