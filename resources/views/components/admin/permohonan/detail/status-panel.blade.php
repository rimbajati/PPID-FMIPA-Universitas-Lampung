@props(['permohonan'])
@php
    $defaultPesanSelesai = 'Permohonan Anda telah selesai dipenuhi. Silakan periksa kotak masuk email Anda (termasuk folder Spam) untuk mengunduh dokumen jawaban informasi yang diminta.';
    $defaultPesanDitolak = 'Mohon maaf, permohonan informasi Anda tidak dapat dipenuhi. Silakan periksa kotak masuk email Anda (termasuk folder Spam) untuk membaca alasan penolakan.';
    $caraLower = strtolower($permohonan->cara_memperoleh_informasi ?? '');
    $isDatangLangsung = str_contains($caraLower, 'langsung') || str_contains($caraLower, 'melihat') || str_contains($caraLower, 'tempat');
@endphp

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden"
     x-data="{
        statusSelect: '{{ in_array($permohonan->status, ['Selesai', 'Ditolak']) ? $permohonan->status : 'Diproses' }}',
        showConfirmModal: false,
        triggerConfirm() {
            if (this.$refs.statusForm.reportValidity()) {
                this.showConfirmModal = true;
            }
        }
     }">

    <div class="px-5 py-4 border-b border-slate-100">
        <p class="text-sm font-semibold text-slate-900">Status Permohonan</p>
        <p class="text-xs text-slate-500 mt-0.5">Tentukan keputusan atas permohonan informasi</p>
    </div>

    <div class="p-5">
        @if(in_array($permohonan->status, ['Selesai', 'Ditolak']))
            <div class="space-y-3">
                <p class="text-sm text-slate-600 leading-relaxed">Tiket berstatus <span class="font-semibold text-slate-900">{{ $permohonan->status }}</span> — tidak dapat diubah.</p>
                @php
                    $pesanTersimpan = $permohonan->catatan_selesai ?: $permohonan->catatan_diproses;
                    $jawabanTersimpan = $permohonan->jawaban;
                    $alasanTersimpan = $permohonan->alasan_ditolak ?: $permohonan->pesan_ditolak;
                @endphp
                @if($pesanTersimpan)
                    <div>
                        <p class="text-[11px] font-semibold text-slate-500 mb-1">Pesan PPID:</p>
                        <div class="rounded-lg bg-slate-50 border border-slate-200 px-3 py-3 text-xs leading-relaxed text-slate-700 whitespace-pre-line">{{ trim($pesanTersimpan) }}</div>
                    </div>
                @endif
                @if($permohonan->status === 'Selesai' && $jawabanTersimpan)
                    <div>
                        <p class="text-[11px] font-semibold text-slate-500 mb-1">Jawaban (terkirim ke email):</p>
                        <div class="rounded-lg bg-slate-50 border border-slate-200 px-3 py-3 text-xs leading-relaxed text-slate-700 whitespace-pre-line">{{ trim($jawabanTersimpan) }}</div>
                    </div>
                @endif
                @if($permohonan->status === 'Ditolak' && $alasanTersimpan)
                    <div>
                        <p class="text-[11px] font-semibold text-slate-500 mb-1">Alasan penolakan (terkirim ke email):</p>
                        <div class="rounded-lg bg-rose-50 border border-rose-200 px-3 py-3 text-xs leading-relaxed text-rose-800 whitespace-pre-line">{{ trim($alasanTersimpan) }}</div>
                    </div>
                @endif
                @if($permohonan->status === 'Selesai' && $permohonan->jawabanFiles->count() > 0)
                    <div class="space-y-1.5 pt-1">
                        <p class="text-xs font-semibold text-slate-700">File Jawaban:</p>
                        @foreach($permohonan->jawabanFiles as $jf)
                            <a href="{{ asset('storage/' . $jf->file_path) }}" target="_blank" class="flex items-center justify-between gap-2 rounded-lg bg-slate-50 border border-slate-200 hover:bg-slate-100 px-3 py-2 text-xs font-medium text-slate-700 transition">
                                <span class="truncate"><i class="fa-regular fa-file text-slate-400 mr-1.5"></i> {{ $jf->file_name }}</span>
                                <i class="fa-solid fa-download text-[11px] text-slate-400"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
                <p class="text-[11px] text-slate-400 leading-relaxed">
                    @if($permohonan->updated_at)
                        {{ $permohonan->status === 'Ditolak' ? 'Ditolak' : 'Selesai' }} pada: {{ $permohonan->updated_at->translatedFormat('d F Y — H:i') }} WIB
                    @endif
                </p>
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
                    <label class="text-sm font-medium text-slate-700">Pesan PPID <span class="text-rose-500">*</span></label>
                    <textarea name="catatan_diproses" rows="9" :required="statusSelect === 'Diproses'" :disabled="statusSelect !== 'Diproses'" placeholder="Contoh : informasi yang anda minta sedang disiapkan oleh pihak terkait...."
                              class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 placeholder:text-slate-400">{{ old('catatan_diproses', $permohonan->catatan_diproses) }}</textarea>
                    <x-admin.input-error name="catatan_diproses" />
                    <p class="text-xs text-slate-400">Pesan yang akan dibaca oleh pemohon saat melacak tiket</p>
                </div>

                {{-- Selesai --}}
                <div x-show="statusSelect === 'Selesai'" x-cloak class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-700">Pesan PPID <span class="text-rose-500">*</span></label>
                        <textarea name="catatan_selesai" rows="4" :required="statusSelect === 'Selesai'" :disabled="statusSelect !== 'Selesai'" placeholder="{{ $defaultPesanSelesai }}"
                                  class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 placeholder:text-slate-400 disabled:bg-slate-50">{{ old('catatan_selesai', $permohonan->catatan_selesai ?: $defaultPesanSelesai) }}</textarea>
                        <x-admin.input-error name="catatan_selesai" />
                        <p class="text-xs text-slate-400">Pesan yang akan dibaca oleh pemohon saat melacak tiket</p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-700">Jawaban <span class="text-rose-500">*</span></label>
                         <textarea name="jawaban" rows="9" :required="statusSelect === 'Selesai'" :disabled="statusSelect !== 'Selesai'" placeholder="Tulis jawaban untuk pemohon. Jika informasi yang diminta diberikan dalam bentuk tautan silahkan letakkan disini tautannya..."
                                  class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 placeholder:text-slate-400">{{ old('jawaban', $permohonan->jawaban) }}</textarea>
                        <x-admin.input-error name="jawaban" />
                        <p class="text-xs text-slate-400">Terkirim otomatis ke email pemohon.</p>
                    </div>
                    <div class="space-y-2" x-data="{ fileName: '', fileSize: '', fileError: '', handleFile(e) { const f = e.target.files[0]; this.fileError=''; this.fileName=''; this.fileSize=''; if(!f) return; if(f.size > 5*1024*1024){ this.fileError='File melebihi 5 MB'; e.target.value=''; return;} this.fileName=f.name; this.fileSize = f.size > 1024*1024 ? (f.size/(1024*1024)).toFixed(1)+' MB' : (f.size/1024).toFixed(1)+' KB'; }, clearFile(){ document.getElementById('admin_jawaban_file').value=''; this.fileName=''; this.fileSize=''; this.fileError=''; } }" @if($isDatangLangsung) style="display:none" @endif>
                        <label class="text-sm font-medium text-slate-700">File jawaban <span class="text-slate-400 font-normal">(opsional)</span></label>
                        <input type="file" id="admin_jawaban_file" name="file_jawaban" accept=".pdf,.xls,.xlsx,.jpg,.jpeg,.png" @change="handleFile($event)" class="sr-only">
                        <div @click="document.getElementById('admin_jawaban_file').click()" class="flex items-center gap-2 w-full rounded-lg border border-slate-200 bg-white p-2.5 cursor-pointer transition hover:border-slate-300">
                            <span class="shrink-0 inline-flex items-center justify-center rounded-lg bg-slate-100 px-3 py-1.5 text-[11px] font-bold text-slate-700">Pilih File</span>
                            <span class="flex-1 min-w-0 truncate text-sm" :class="fileName ? 'text-slate-700' : 'text-slate-400'" x-text="fileName || 'Belum ada file dipilih'"></span>
                        </div>
                        <template x-if="fileName">
                            <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-2">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600 text-xs"><i class="fa-regular fa-file"></i></span>
                                <div class="flex-1 min-w-0">
                                    <p class="truncate text-xs font-semibold text-slate-800" x-text="fileName"></p>
                                    <p class="text-[10px] text-slate-500" x-text="fileSize"></p>
                                </div>
                                <button type="button" @click="clearFile()" class="shrink-0 inline-flex h-6 w-6 items-center justify-center rounded-full text-rose-500 hover:bg-rose-50 transition"><i class="fa-regular fa-trash-can text-xs"></i></button>
                            </div>
                        </template>
                        @if($permohonan->jawabanFiles->count() > 0)
                            <div class="mt-2 text-xs text-slate-500">
                                <span class="font-semibold text-slate-700">File sebelumnya:</span>
                                <ul class="list-disc list-inside mt-1 space-y-0.5">
                                    @foreach($permohonan->jawabanFiles as $jf)
                                        <li class="truncate"><a href="{{ asset('storage/' . $jf->file_path) }}" target="_blank" class="text-sky-600 hover:underline">{{ $jf->file_name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <template x-if="fileError">
                            <p class="mt-1.5 flex items-center gap-1 text-xs font-semibold text-rose-600"><i class="fa-solid fa-circle-exclamation text-[11px]"></i> <span x-text="fileError"></span></p>
                        </template>
                        <x-admin.input-error name="file_jawaban" />
                        <p class="text-xs text-slate-400 mt-1">Format: PDF, XLS, XLSX, JPG, PNG — maks 5 MB.</p>
                    </div>
                </div>

                {{-- Ditolak --}}
                <div x-show="statusSelect === 'Ditolak'" x-cloak class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-700">Pesan PPID <span class="text-rose-500">*</span></label>
                        <textarea name="catatan_selesai" rows="4" :required="statusSelect === 'Ditolak'" :disabled="statusSelect !== 'Ditolak'" placeholder="{{ $defaultPesanDitolak }}"
                                  class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 placeholder:text-slate-400">{{ old('catatan_selesai', $permohonan->catatan_selesai ?: $defaultPesanDitolak) }}</textarea>
                        <x-admin.input-error name="catatan_selesai" />
                        <p class="text-xs text-slate-400">Pesan yang akan dibaca oleh pemohon saat melacak tiket</p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-slate-700">Alasan penolakan <span class="text-rose-500">*</span></label>
                        <textarea name="alasan_ditolak" rows="9" :required="statusSelect === 'Ditolak'" :disabled="statusSelect !== 'Ditolak'" placeholder="Tulis alasan penolakan..."
                                  class="w-full rounded-lg border border-slate-200 px-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200 placeholder:text-slate-400">{{ old('alasan_ditolak', $permohonan->alasan_ditolak) }}</textarea>
                        <x-admin.input-error name="alasan_ditolak" />
                        <p class="text-xs text-slate-400">Terkirim otomatis ke email pemohon.</p>
                    </div>
                </div>

                <div class="pt-1">
                    <button type="button" @click="triggerConfirm()" 
                            class="w-full text-white text-sm font-extrabold py-3 rounded-xl transition shadow-md cursor-pointer"
                            :class="{
                                'bg-sky-500 hover:bg-sky-600': statusSelect === 'Diproses',
                                'bg-emerald-600 hover:bg-emerald-700': statusSelect === 'Selesai',
                                'bg-rose-600 hover:bg-rose-700': statusSelect === 'Ditolak'
                            }"
                            x-text="statusSelect === 'Diproses' ? 'Perbarui Status' : (statusSelect === 'Selesai' ? 'Selesaikan' : 'Tolak')">
                    </button>
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
