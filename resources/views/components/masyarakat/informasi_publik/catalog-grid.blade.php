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
                    $fileUrl = route('informasi.lihat', $info->id);
                    $fileExt = 'PDF';
                    
                    if (!empty($info->nama_file_asli) && !empty($info->file_informasi)) {
                        $fileUrl = url('/informasi/file/' . $info->id . '/' . rawurlencode($info->nama_file_asli));
                        $fileExt = strtoupper(pathinfo($info->nama_file_asli, PATHINFO_EXTENSION) ?: 'FILE');
                    } elseif (!empty($info->link_informasi)) {
                        $fileUrl = $info->link_informasi;
                        $fileExt = 'LINK';
                    }
                    
                    $badgeStyle = $kategoriStyles[$info->kategori_informasi] ?? 'bg-sky-500 text-white';

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
                    }
                @endphp

                <!-- INDIVIDUAL CARD (Clickable Container) -->
                <a href="{{ $fileUrl }}" target="_blank" 
                   class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col justify-between h-full group cursor-pointer">
                    
                    <!-- Top Content Section (Judul, Deskripsi, Kategori Badge) -->
                    <div class="space-y-2.5">
                        <!-- Title -->
                        <h3 class="text-base font-extrabold text-slate-900 group-hover:text-sky-600 transition-colors leading-snug block break-words [word-break:break-word]">
                            {{ $info->judul_informasi }}
                        </h3>

                        <!-- Description -->
                        <p class="text-xs md:text-sm text-slate-500 font-normal leading-relaxed break-words [word-break:break-word]">
                            {{ $info->deskripsi_informasi ?: 'Dokumen dan informasi publik resmi PPID Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Lampung.' }}
                        </p>

                        <!-- Tag Pills Row (Kategori UU KIP & Topik Informasi) -->
                        <div class="flex flex-wrap items-center gap-1.5 pt-1 pb-1.5 mb-1">
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold {{ $badgeStyle }} shadow-2xs inline-block">
                                {{ $info->kategori_informasi }}
                            </span>
                            @if(!empty($info->topik_informasi))
                                <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-sky-50 text-sky-700 border border-sky-200/80 shadow-2xs inline-block">
                                    {{ $info->topik_informasi }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Bottom Card Footer Line (Pushed to Bottom) -->
                    <div class="mt-auto pt-3.5 mt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 font-medium">
                        <span class="flex items-center gap-1.5 text-slate-500 font-medium">
                            <i class="fa-regular fa-eye text-sky-500 text-[11px]"></i>
                            <span>Dilihat {{ $info->dilihat ?? 0 }} kali</span>
                        </span>

                        <!-- Format File & Tahun Terbit -->
                        <div class="flex items-center gap-2.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold border shadow-2xs {{ $extBadgeStyle }}">
                                {{ $fileExt }}
                            </span>

                            <span class="flex items-center gap-1 text-[11px] font-bold text-slate-500">
                                <i class="fa-regular fa-calendar text-slate-400 text-[11px]"></i>
                                <span>{{ $info->tahun_terbit ?? '2026' }}</span>
                            </span>
                        </div>
                    </div>

                </a>
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

