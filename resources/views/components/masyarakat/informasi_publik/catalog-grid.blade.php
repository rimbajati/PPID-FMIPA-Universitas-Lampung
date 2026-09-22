@props(['informasiList'])

<!-- Card Grid Catalog View (Matching Reference UI Style) -->
<div class="space-y-5">
    @if($informasiList->count() > 0)
        @php
            $kategoriStyles = [
                'Informasi Berkala'      => 'bg-[#1B365D] text-white',
                'Informasi Serta-Merta'  => 'bg-rose-500 text-white',
                'Informasi Setiap Saat'  => 'bg-emerald-500 text-white',
                'Informasi Dikecualikan' => 'bg-slate-600 text-white',
            ];
        @endphp

        <!-- 3-COLUMN CARD GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($informasiList as $info)
                @php
                    $jenisInfo = $info->jenis_informasi ?: $info->kategori_informasi;
                    $isDikecualikan = ($jenisInfo === 'Informasi Dikecualikan');
                    $isCetakOnly = (($info->bentuk_informasi_yang_tersedia ?? $info->bentuk_informasi) === 'Cetak' && empty($info->file_informasi) && empty($info->link_informasi));
                    $fileUrl = '#';
                    $fileExt = 'CETAK';
                    
                    if ($isDikecualikan) {
                        $fileExt = 'DIKECUALIKAN';
                    } elseif (!empty($info->nama_file_asli) && !empty($info->file_informasi)) {
                        $fileUrl = url('/informasi/file/' . $info->id . '/' . rawurlencode($info->nama_file_asli));
                        $fileExt = strtoupper(pathinfo($info->nama_file_asli, PATHINFO_EXTENSION) ?: 'FILE');
                    } elseif (!empty($info->link_informasi)) {
                        $fileUrl = $info->link_informasi;
                        $fileExt = 'LINK';
                    } elseif (!$isCetakOnly) {
                        $fileUrl = route('informasi.lihat', $info->id);
                        $fileExt = 'PDF';
                    }
                    
                    $badgeStyle = $kategoriStyles[$jenisInfo] ?? 'bg-sky-500 text-white';

                    $extUpper = strtoupper($fileExt);
                    $extBadgeStyle = 'bg-slate-100 text-slate-600 border-slate-200/80';
                    
                    if ($extUpper === 'PDF') {
                        $extBadgeStyle = 'bg-rose-50 text-rose-600 border-rose-200/80';
                    } elseif (in_array($extUpper, ['DOC', 'DOCX', 'WORD'])) {
                        $extBadgeStyle = 'bg-blue-50 text-blue-600 border-blue-200/80';
                    } elseif (in_array($extUpper, ['XLS', 'XLSX', 'CSV', 'EXCEL', 'SPREADSHEET'])) {
                        $extBadgeStyle = 'bg-emerald-50 text-emerald-600 border-emerald-200/80';
                    } elseif ($extUpper === 'LINK') {
                        $extBadgeStyle = 'bg-slate-100 text-slate-600 border-slate-200/80';
                    } elseif ($extUpper === 'CETAK') {
                        $extBadgeStyle = 'bg-amber-50 text-amber-700 border-amber-200/80';
                    } elseif ($extUpper === 'DIKECUALIKAN') {
                        $extBadgeStyle = 'bg-slate-700 text-white border-slate-700';
                    }
                @endphp

                <!-- INDIVIDUAL CARD (Clickable Link, DIK Modal Opener, or Static Cetak) -->
                @if($isDikecualikan)
                    <div onclick="openPublicDikModal({{ json_encode($info) }})"
                         class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs hover:shadow-md hover:-translate-y-0.5 group cursor-pointer transition-all duration-200 flex flex-col justify-between h-full">
                @elseif(!$isCetakOnly)
                    <a href="{{ $fileUrl }}" target="_blank" onclick="incrementCounter({{ $info->id }})"
                       class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs hover:shadow-md hover:-translate-y-0.5 group cursor-pointer transition-all duration-200 flex flex-col justify-between h-full">
                @else
                    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs transition-all duration-200 flex flex-col justify-between h-full">
                @endif
                    
                    <!-- Top Content Section (Judul, Deskripsi, Kategori Badge) -->
                    <div class="space-y-2.5">
                        <!-- Title -->
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-sky-600 transition-colors leading-snug block break-words [word-break:break-word]">
                            {{ $info->sub_informasi ?? $info->judul_informasi }}
                            @if($isDikecualikan)
                                <span class="inline-block ml-1 text-slate-400 text-xs"><i class="fa-solid fa-lock"></i></span>
                            @endif
                        </h3>

                        <!-- Tag Pills Row (Kategori UU KIP & Satker Penguasa) -->
                        <div class="flex flex-wrap items-center gap-1.5 pt-1 pb-1.5 mb-1">
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold {{ $badgeStyle }} shadow-2xs inline-block">
                                {{ $jenisInfo }}
                            </span>
                            @php
                                $pejabatPenguasa = $info->pejabat_unit_yang_menguasai_informasi ?? $info->pejabat_unit_yang_menguasai ?? $info->pejabat_penguasa;
                            @endphp
                            @if(!empty($pejabatPenguasa))
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200/80 shadow-2xs inline-block">
                                    {{ $pejabatPenguasa }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Bottom Card Footer Line (Pushed to Bottom) -->
                    <div class="mt-auto pt-3.5 mt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 font-medium">
                        <span class="flex items-center gap-1.5 text-slate-500 font-medium">
                            <i class="fa-regular fa-eye text-sky-500 text-[11px]"></i>
                            <span>Dilihat <span id="click-count-{{ $info->id }}">{{ $info->dilihat ?? 0 }}</span> kali</span>
                        </span>

                        <!-- Format File & Tahun Terbit -->
                        <div class="flex items-center gap-2.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border shadow-2xs {{ $extBadgeStyle }}">
                                {{ $fileExt }}
                            </span>

                            <span class="flex items-center gap-1 text-[11px] font-bold text-slate-500">
                                <i class="fa-regular fa-calendar text-slate-400 text-[11px]"></i>
                                <span>{{ $info->waktu_pembuatan_informasi ?? $info->tahun_terbit ?? '2026' }}</span>
                            </span>
                        </div>
                    </div>

                @if($isDikecualikan || $isCetakOnly)
                    </div>
                @else
                    </a>
                @endif
            @endforeach
        </div>

        <!-- Pagination Footer -->
        <div class="pt-4">
            <x-ui.pagination :paginator="$informasiList" label="informasi publik" />
        </div>

    @else
        <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center space-y-4 shadow-xs">
            <div class="w-16 h-16 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-2xl mx-auto border border-sky-100">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-lg font-black text-slate-900">Tidak Ada Informasi Ditemukan</h3>
                <p class="text-xs md:text-sm text-slate-500 font-medium max-w-md mx-auto">
                    Coba ubah pencarian atau pilih kategori filter yang berbeda.
                </p>
            </div>
        </div>
    @endif
</div>

<!-- ======================================================== -->
<!-- MODAL POPUP: DETAIL INFORMASI YANG DIKECUALIKAN (PUBLIK) -->
<!-- ======================================================== -->
<div id="modalPublicDetailDikecualikan" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden transition-all duration-200">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col max-h-[90vh] animate-in fade-in zoom-in-95 duration-150">
        <!-- Header Modal -->
        <div class="px-6 pt-6 pb-4 flex items-start justify-between gap-4 border-b border-slate-100">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400">Daftar Informasi yang Dikecualikan</p>
                <h3 id="publicDikDetailJudul" class="text-xl sm:text-2xl font-black text-slate-900 leading-tight"></h3>
            </div>
            <button type="button" onclick="closePublicDikModal()" 
                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition cursor-pointer shrink-0">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Body Modal (Struktur Persis Referensi Gambar) -->
        <div class="p-6 overflow-y-auto space-y-6 text-sm divide-y divide-slate-100">
            <!-- 1. Dasar Hukum Pengecualian Informasi -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-2 first:pt-0">
                <div class="sm:col-span-4 font-bold text-slate-900">
                    Dasar Hukum Pengecualian Informasi
                </div>
                <div id="publicDikDetailDasarHukum" class="sm:col-span-8 text-slate-700 font-medium whitespace-pre-line leading-relaxed">
                </div>
            </div>

            <!-- 2. Dibuka -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-5">
                <div class="sm:col-span-4 font-bold text-slate-900">
                    Dibuka
                </div>
                <div id="publicDikDetailDibuka" class="sm:col-span-8 text-slate-700 font-medium">
                    -
                </div>
            </div>

            <!-- 3. Ditutup -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-5">
                <div class="sm:col-span-4 font-bold text-slate-900">
                    Ditutup
                </div>
                <div id="publicDikDetailDitutup" class="sm:col-span-8 text-slate-700 font-medium leading-relaxed">
                </div>
            </div>

            <!-- 4. Jangka Waktu -->
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 pt-5">
                <div class="sm:col-span-4 font-bold text-slate-900">
                    Jangka Waktu
                </div>
                <div id="publicDikDetailJangkaWaktu" class="sm:col-span-8 text-slate-700 font-medium leading-relaxed">
                </div>
            </div>
        </div>

        <!-- Footer Modal -->
        <div class="px-6 py-3.5 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end">
            <button type="button" onclick="closePublicDikModal()" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

