@props(['permohonan'])

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden"
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

    {{-- header ringkas dengan badge di kanan --}}
    <div class="px-5 py-4 border-b border-slate-100">
        <p class="text-sm font-semibold text-slate-900">Status Permohonan</p>
        <p class="text-xs text-slate-500 mt-0.5">Tentukan keputusan atas permohonan informasi</p>
    </div>

    <div class="p-5">
        @if(in_array($permohonan->status, ['Selesai', 'Ditolak']))
            <div class="space-y-3">
                <p class="text-sm text-slate-600 leading-relaxed">Tiket berstatus <span class="font-semibold text-slate-900">{{ $permohonan->status }}</span> — tidak dapat diubah.</p>
                @php $pesanTersimpan = $permohonan->status === 'Selesai' ? $permohonan->catatan_selesai : ($permohonan->alasan_ditolak ?: $permohonan->pesan_ditolak); @endphp
                @if($pesanTersimpan)
                    <div class="rounded-lg bg-slate-50 border border-slate-200 px-3 py-3 text-xs leading-relaxed text-slate-700 whitespace-pre-line">{{ trim($pesanTersimpan) }}</div>
                @endif
                @if($permohonan->status === 'Selesai')
                    @if($permohonan->file_jawaban)
                        <a href="{{ asset('storage/' . $permohonan->file_jawaban) }}" target="_blank" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 hover:bg-black text-white text-xs font-medium py-2.5 transition"><i class="fa-solid fa-download text-xs"></i> Unduh file jawaban</a>
                    @elseif($permohonan->link_jawaban)
                        <a href="{{ $permohonan->link_jawaban }}" target="_blank" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-slate-900 hover:bg-black text-white text-xs font-medium py-2.5 transition"><i class="fa-solid fa-link text-xs"></i> Buka tautan</a>
                    @endif
                @endif
                <p class="text-[11px] text-slate-400">Diperbarui {{ $permohonan->updated_at ? $permohonan->updated_at->diffForHumans() : '-' }}</p>
            </div>

        @elseif($permohonan->keberatan)
            <div class="text-center py-6">
                <div class="w-8 h-8 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-xs"><i class="fa-solid fa-lock"></i></div>
                <p class="text-xs font-medium text-slate-700 mt-2">Terkunci — ada keberatan</p>
                <p class="text-xs text-slate-500 mt-1">Kelola di halaman keberatan.</p>
            </div>

        @else
            <form x-ref="statusForm" action="{{ route('admin.permohonan.update-status', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- segmented control simpel --}}
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

                {{-- Diproses --}}
                <div x-show="statusSelect === 'Diproses'" x-cloak class="space-y-1.5">
                    <label class="text-sm font-medium text-slate-700">Catatan pemrosesan <span class="text-rose-500">*</span></label>
                    <textarea name="catatan_diproses" rows="9" :required="statusSelect === 'Diproses'" placeholder="Tulis catatan pemrosesan..."
                              class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 placeholder:text-slate-400">{{ old('catatan_diproses', $permohonan->catatan_diproses) }}</textarea>
                    <x-admin.input-error name="catatan_diproses" />
                    <p class="text-xs text-slate-400">Terkirim otomatis ke email pemohon.</p>
                </div>

                {{-- Selesai --}}
                <div x-show="statusSelect === 'Selesai'" x-cloak class="space-y-3">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-700">Catatan penyelesaian <span class="text-rose-500">*</span></label>
                        @php
                            $defaultCatatanSelesai = $permohonan->catatan_selesai;
                            if (!$defaultCatatanSelesai) {
                                $cara = strtolower($permohonan->cara_memperoleh_informasi ?? '');
                                $defaultCatatanSelesai = str_contains($cara, 'email')
                                    ? 'Permohonan telah dipenuhi. Silakan cek email Anda (termasuk Spam).'
                                    : 'Permohonan telah dipenuhi. Silakan ambil di Dekanat FMIPA Unila jam kerja.';
                            }
                        @endphp
                        <textarea name="catatan_selesai" rows="9" :required="statusSelect === 'Selesai'"
                                  class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300">{{ old('catatan_selesai', $defaultCatatanSelesai) }}</textarea>
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
                            fileUrl: '{{ $permohonan->file_jawaban ? asset('storage/' . $permohonan->file_jawaban) : '' }}',
                            init() { if (this.fileUrl) { let name = '{{ $permohonan->file_jawaban ? basename($permohonan->file_jawaban) : '' }}'; this.fileName = name; } },
                            handle(e) {
                                const f = e.target.files[0];
                                if (!f) return;
                                this.fileName = f.name;
                                this.fileSize = (f.size / 1024).toFixed(1) + ' KB';
                                if (f.size > 1024*1024) this.fileSize = (f.size / (1024*1024)).toFixed(1) + ' MB';
                                this.fileUrl = URL.createObjectURL(f);
                            },
                            clear() { document.getElementById('admin_jawaban_file').value = ''; this.fileName = ''; this.fileSize = ''; this.fileUrl = ''; }
                        }">
                            <input type="file" id="admin_jawaban_file" name="file_jawaban" accept=".pdf,.docx,.xlsx,.zip,.rar" @change="handle($event)" class="sr-only">
                            <div @click="document.getElementById('admin_jawaban_file').click()" class="flex items-center gap-2 w-full rounded-lg border border-slate-200 bg-white p-2 pr-2 cursor-pointer transition hover:border-slate-300">
                                <span class="shrink-0 inline-flex items-center justify-center rounded-lg bg-slate-100 px-3 py-1.5 text-[11px] font-bold text-slate-700">Pilih File</span>
                                <span class="flex-1 min-w-0 truncate text-sm" :class="fileName ? 'text-slate-800' : 'text-slate-400'" x-text="fileName || 'Belum ada berkas'"></span>
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
                        </div>
                        <div x-show="tipeJawaban === 'link'">
                            <input type="url" name="link_jawaban" placeholder="https://..." value="{{ old('link_jawaban', $permohonan->link_jawaban) }}" :required="statusSelect === 'Selesai' && tipeJawaban === 'link'"
                                   class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200">
                            <x-admin.input-error name="link_jawaban" />
                        </div>
                    </div>
                </div>

                {{-- Ditolak --}}
                <div x-show="statusSelect === 'Ditolak'" x-cloak class="space-y-1.5">
                    <label class="text-sm font-medium text-slate-700">Alasan penolakan <span class="text-rose-500">*</span></label>
                    <textarea name="alasan_ditolak" rows="9" :required="statusSelect === 'Ditolak'" placeholder="Tulis alasan penolakan..."
                              class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200">{{ old('alasan_ditolak', $permohonan->alasan_ditolak) }}</textarea>
                    <x-admin.input-error name="alasan_ditolak" />
                </div>

                <div class="pt-1">
                    <button type="button" @click="triggerConfirm()" class="w-full rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-sm font-medium py-2.5 transition">Perbarui Status</button>
                    <p class="text-[11px] text-center text-slate-400 mt-2">Diperbarui {{ $permohonan->updated_at ? $permohonan->updated_at->diffForHumans() : '-' }}</p>
                </div>

                @include('components.admin.permohonan.detail.modal-konfirmasi', ['noTiket' => $permohonan->no_tiket])
            </form>
        @endif
    </div>
</div>

@if($permohonan->keberatan)
    <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 flex items-center justify-between gap-3">
        <div>
            <p class="text-xs font-semibold text-amber-900">Ada keberatan</p>
            <p class="text-xs font-mono text-amber-800">{{ $permohonan->keberatan->no_tiket }}</p>
        </div>
        <a href="{{ route('admin.keberatan.show', $permohonan->keberatan->id) }}" class="shrink-0 inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white border border-amber-200 text-amber-800 text-xs font-medium hover:bg-amber-100 transition">Buka <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
    </div>
@endif
