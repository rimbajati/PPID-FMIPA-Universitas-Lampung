@props(['keberatan'])

<div class="space-y-4">
    <!-- TABEL DATA KEBERATAN SEAMLESS -->
    <table class="w-full text-sm border-collapse">
        <tbody class="divide-y divide-slate-100/60 [&>tr:nth-child(odd)]:bg-slate-100/70 [&>tr:nth-child(even)]:bg-white">
            <!-- 1. Permohonan Asal (Tiket) -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Permohonan Asal</td>
                <td class="px-4 py-2 align-middle">
                    @if($keberatan->permohonan)
                        <a href="{{ route('admin.permohonan.show', $keberatan->permohonan->id) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-black bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow-2xs">
                            <span>{{ $keberatan->permohonan->no_tiket }}</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    @else
                        <span class="text-xs text-slate-500 font-semibold">-</span>
                    @endif
                </td>
            </tr>

            <!-- 2. Alasan Penolakan dari Admin (alasan_ditolak di permohonan asal) -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Alasan Penolakan dari PPID</td>
                <td class="px-4 py-2 font-medium text-slate-800 leading-relaxed align-middle">
                    {{ trim($keberatan->permohonan->alasan_ditolak ?? '-') ?: '-' }}
                </td>
            </tr>

            <!-- 3. Alasan Keberatan -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Alasan Pengajuan Keberatan</td>
                <td class="px-4 py-2 font-bold text-slate-800 leading-relaxed align-middle">
                    {{ trim($keberatan->alasan_keberatan) }}
                </td>
            </tr>

            <!-- 4. Kronologi Keberatan -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Kronologi Pengajuan Keberatan</td>
                <td class="px-4 py-2 font-medium text-slate-800 leading-relaxed align-middle">
                    {{ trim($keberatan->kronologi_keberatan ?: 'Pemohon tidak menyertakan penjelasan kronologi tambahan.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- BERKAS LAMPIRAN KEBERATAN -->
    <div class="pt-2">
        <div class="flex items-center gap-2 text-slate-700 font-extrabold text-xs sm:text-sm mb-2.5">
            <i class="fa-regular fa-folder-open text-slate-700 text-sm"></i>
            <span>Lampiran Pendukung Keberatan</span>
        </div>

        <div class="inline-flex items-center gap-3.5 p-2.5 sm:p-3 bg-slate-50 border border-slate-200/90 rounded max-w-full hover:bg-slate-100/70 transition">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded bg-amber-100 text-amber-600 flex items-center justify-center shrink-0 text-sm font-bold">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <span class="font-extrabold text-slate-800 text-xs sm:text-sm truncate" title="{{ $keberatan->nama_file_pendukung_asli ?: ($keberatan->file_pendukung ? basename($keberatan->file_pendukung) : '') }}">
                    {{ $keberatan->nama_file_pendukung_asli ?: ($keberatan->file_pendukung ? basename($keberatan->file_pendukung) : 'Tidak dilampirkan oleh pemohon') }}
                </span>
            </div>

            @if($keberatan->file_pendukung)
                @php
                    $namaPendukungTampil = $keberatan->nama_file_pendukung_asli ?: basename($keberatan->file_pendukung);
                    $urlPendukung = route('keberatan.file', ['id' => $keberatan->id, 'filename' => rawurlencode($namaPendukungTampil)]);
                @endphp
                <a href="{{ $urlPendukung }}" target="_blank" 
                   class="inline-flex items-center px-3.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded transition shadow-2xs shrink-0 cursor-pointer">
                    <span>Lihat</span>
                </a>
            @else
                <span class="px-2.5 py-1 text-xs font-semibold text-slate-400 bg-slate-200/60 rounded shrink-0">
                    Tidak Ada
                </span>
            @endif
        </div>
    </div>
</div>
