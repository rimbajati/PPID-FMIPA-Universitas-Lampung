@props(['permohonan'])

<div class="space-y-4">
    <!-- TABEL DATA PERMOHONAN SEAMLESS -->
    <table class="w-full text-sm border-collapse">
        <tbody class="divide-y divide-slate-100/60 [&>tr:nth-child(odd)]:bg-slate-100/70 [&>tr:nth-child(even)]:bg-white">
            <!-- 1. Kategori Pemohon -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Kategori Pemohon</td>
                <td class="px-4 py-2 font-bold text-slate-800 align-middle">
                    {{ $permohonan->kategori_pemohon ?? 'Perorangan' }}
                </td>
            </tr>

            @if(!empty($permohonan->nama_organisasi_lembaga))
            <!-- 1.1. Nama Organisasi / Lembaga Dinamis Sesuai Kategori -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">
                    Nama {{ in_array($permohonan->kategori_pemohon, ['Organisasi', 'Lembaga']) ? $permohonan->kategori_pemohon : 'Organisasi / Lembaga' }}
                </td>
                <td class="px-4 py-2 font-bold text-slate-800 align-middle">
                    {{ trim($permohonan->nama_organisasi_lembaga) }}
                </td>
            </tr>
            @endif

            <!-- 2. Nama Lengkap -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Nama Lengkap Pemohon</td>
                <td class="px-4 py-2 font-bold text-slate-800 align-middle">{{ trim($permohonan->nama_lengkap) }}</td>
            </tr>

            <!-- 3. No. Identitas (NIK) + Tombol Lampiran Identitas Langsung Menempel -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">No. Identitas (NIK)</td>
                <td class="px-4 py-2 align-middle">
                    <div class="inline-flex items-center gap-2.5 flex-wrap">
                        <span class="font-semibold text-slate-800">{{ trim($permohonan->no_identitas ?? ($permohonan->nik ?? '-')) }}</span>
                        
                        @if($permohonan->file_identitas)
                            @php
                                $namaIdTampil = $permohonan->nama_file_identitas_asli ?: basename($permohonan->file_identitas);
                                $urlIdentitas = route('permohonan.file', ['id' => $permohonan->id, 'type' => 'identitas', 'filename' => rawurlencode($namaIdTampil)]);
                            @endphp
                            <a href="{{ $urlIdentitas }}" target="_blank" 
                               class="inline-flex items-center gap-1.5 px-2.5 py-0.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-[11px] rounded transition shadow-2xs cursor-pointer"
                               title="{{ $namaIdTampil }}">
                                <i class="fa-solid fa-id-card text-[10px]"></i>
                                <span>Identitas</span>
                            </a>
                        @else
                            <span class="text-[11px] font-semibold text-slate-400 italic">
                                (Tidak ada lampiran)
                            </span>
                        @endif
                    </div>
                </td>
            </tr>

            <!-- 4. Email -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Email</td>
                <td class="px-4 py-2 font-semibold text-slate-800 break-all align-middle">{{ trim($permohonan->email ?? '-') }}</td>
            </tr>

            <!-- 5. WhatsApp -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">No. Telepon / Whatsapp</td>
                <td class="px-4 py-2 font-semibold text-slate-800 align-middle">
                    <span class="inline-flex items-center gap-2">
                        <span>{{ trim($permohonan->no_telepon ?? ($permohonan->no_hp ?? '-')) }}</span>
                    </span>
                </td>
            </tr>

            <!-- 6. Pekerjaan -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Pekerjaan</td>
                <td class="px-4 py-2 font-semibold text-slate-800 align-middle">{{ trim($permohonan->pekerjaan ?? '-') }}</td>
            </tr>

            <!-- 7. Alamat Lengkap -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Alamat Lengkap</td>
                <td class="px-4 py-2 font-medium text-slate-800 leading-relaxed align-middle">{{ trim($permohonan->alamat_lengkap ?? ($permohonan->alamat ?? '-')) }}</td>
            </tr>

            <!-- 8. Informasi yang Diminta -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Informasi yang Diminta</td>
                <td class="px-4 py-2 font-medium text-slate-800 leading-relaxed align-middle">{{ trim($permohonan->informasi_yang_diminta) }}</td>
            </tr>

            <!-- 9. Tujuan Penggunaan -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Tujuan Penggunaan Informasi</td>
                <td class="px-4 py-2 font-medium text-slate-800 leading-relaxed align-middle">{{ trim($permohonan->tujuan_penggunaan_informasi) }}</td>
            </tr>

            <!-- 10. Cara Memperoleh Informasi -->
            <tr>
                <td class="w-[30%] px-4 py-2 font-black text-slate-900 whitespace-nowrap align-middle">Cara Memperoleh Informasi</td>
                <td class="px-4 py-2 font-semibold text-slate-800 align-middle">
                    {{ trim($permohonan->cara_memperoleh_informasi ?? '-') }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- BERKAS LAMPIRAN PERSYARATAN -->
    <div class="pt-2">
        <div class="flex items-center gap-2 text-slate-700 font-extrabold text-xs sm:text-sm mb-2.5">
            <i class="fa-regular fa-folder-open text-slate-700 text-sm"></i>
            <span>Lampiran Pendukung</span>
        </div>

        <div class="inline-flex items-center gap-3.5 p-2.5 sm:p-3 bg-slate-50 border border-slate-200/90 rounded max-w-full hover:bg-slate-100/70 transition">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 text-sm font-bold">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <span class="font-extrabold text-slate-800 text-xs sm:text-sm truncate" title="{{ $permohonan->nama_file_pendukung_asli ?: ($permohonan->file_pendukung ? basename($permohonan->file_pendukung) : '') }}">
                    {{ $permohonan->nama_file_pendukung_asli ?: ($permohonan->file_pendukung ? basename($permohonan->file_pendukung) : 'Tidak dilampirkan oleh pemohon') }}
                </span>
            </div>

            @if($permohonan->file_pendukung)
                @php
                    $namaPendukungTampil = $permohonan->nama_file_pendukung_asli ?: basename($permohonan->file_pendukung);
                    $urlPendukung = route('permohonan.file', ['id' => $permohonan->id, 'type' => 'pendukung', 'filename' => rawurlencode($namaPendukungTampil)]);
                @endphp
                <a href="{{ $urlPendukung }}" target="_blank" 
                   class="inline-flex items-center px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded transition shadow-2xs shrink-0 cursor-pointer">
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
