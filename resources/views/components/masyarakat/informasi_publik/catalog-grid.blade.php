@props(['informasiList'])
<!-- Full-Width Catalog Grid dengan Filter Dropdowns & View Switcher -->
<!-- Data $informasiList disediakan oleh InformasiPublikController@index -->
<div class="space-y-6" x-data="{ viewMode: 'grid' }">

    @if($informasiList->count() > 0)
        
        <!-- GRID CARDS (4 KOLOM LEBAR FULL) -->
        <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($informasiList as $info)
                @php
                    $isLink = !empty($info->link_informasi) && empty($info->file_informasi);
                    $fileSize = $isLink ? 'Tautan Drive' : '2.4 MB';
                    if (!$isLink && $info->file_informasi && \Illuminate\Support\Facades\Storage::disk('local')->exists($info->file_informasi)) {
                        $bytes = \Illuminate\Support\Facades\Storage::disk('local')->size($info->file_informasi);
                        $fileSize = $bytes < 1024 * 1024 ? round($bytes / 1024, 1) . ' KB' : round($bytes / (1024 * 1024), 1) . ' MB';
                    }
                @endphp

                <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                    <div class="space-y-3">
                        <!-- Card Header: Kategori di Kiri, Tahun & Dilihat di Kanan -->
                        <div class="flex items-center justify-between gap-2 min-h-[22px]">
                            <span class="text-[12px] font-black text-sky-700 tracking-wider block whitespace-nowrap overflow-hidden text-ellipsis">
                                {{ $info->kategori_informasi }}
                            </span>
                            <div class="flex items-center gap-2.5 text-[11px] font-bold text-slate-400 shrink-0">
                                @if($info->kategori_informasi !== 'Informasi Dikecualikan')
                                    <span class="flex items-center gap-1">
                                        <i class="fa-regular fa-eye"></i> <span id="click-count-{{ $info->id }}">{{ number_format($info->dilihat ?? 0, 0, ',', '.') }}</span>
                                    </span>
                                @endif
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-calendar"></i> {{ $info->tahun_terbit ?? \Carbon\Carbon::parse($info->created_at)->format('Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body: Judul & Deskripsi (Penuh & Whole-Word Line Break) -->
                        <div class="space-y-1.5">
                            <h3 class="text-sm md:text-base font-black text-slate-900 group-hover:text-[#1B365D] transition-colors leading-snug break-words" title="{{ $info->judul_informasi }}">
                                {{ $info->judul_informasi }}
                            </h3>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed break-words">
                                {{ $info->deskripsi_informasi ?: 'Tidak ada deskripsi tambahan.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer: Tombol Aksi -->
                    <div class="pt-3 mt-4 border-t border-slate-100">
                        @if($info->kategori_informasi === 'Informasi Dikecualikan')
                            <button disabled class="w-full py-2.5 bg-slate-100 text-slate-400 text-xs font-bold cursor-not-allowed border border-slate-200 rounded-xl flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-lock text-xs"></i> Dikecualikan
                            </button>
                        @else
                            @php
                                $viewUrl = route('informasi.lihat', $info->id);
                                if (!$isLink && !empty($info->nama_file_asli)) {
                                    $viewUrl = url('/informasi/file/' . $info->id . '/' . rawurlencode($info->nama_file_asli));
                                }
                            @endphp
                            <a href="{{ $viewUrl }}" target="_blank" onclick="incrementCounter({{ $info->id }})" 
                               class="w-full py-2.5 bg-[#1B365D] hover:bg-[#152a4a] text-white text-xs font-extrabold text-center transition rounded-xl flex items-center justify-center gap-2 shadow-xs cursor-pointer">
                                <i class="fa-regular fa-eye"></i> Lihat Informasi
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Footer (Dengan Informasi Counter Menampilkan) -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-slate-200/60 mt-4">
            <!-- Counter info -->
            <p class="text-xs md:text-sm text-slate-600 font-medium">
                Menampilkan <span class="font-extrabold text-slate-900">{{ $informasiList->firstItem() ?? 0 }}-{{ $informasiList->lastItem() ?? 0 }}</span> dari <span class="font-black text-[#1B365D]">{{ $informasiList->total() }}</span> informasi publik
            </p>

            @if($informasiList->hasPages())
                <div class="flex items-center gap-1.5">
                    {{-- Previous --}}
                    @if($informasiList->onFirstPage())
                        <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 text-xs font-bold cursor-not-allowed select-none border border-slate-200/50">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </span>
                    @else
                        <a href="{{ $informasiList->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white text-slate-600 text-xs font-bold border border-slate-200 hover:bg-slate-50 transition cursor-pointer">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach($informasiList->getUrlRange(1, $informasiList->lastPage()) as $page => $url)
                        @if($page == $informasiList->currentPage())
                            <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#1B365D] text-white text-xs font-black shadow-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white text-slate-600 text-xs font-bold border border-slate-200 hover:bg-slate-50 transition cursor-pointer">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($informasiList->hasMorePages())
                        <a href="{{ $informasiList->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white text-slate-600 text-xs font-bold border border-slate-200 hover:bg-slate-50 transition cursor-pointer">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 text-xs font-bold cursor-not-allowed select-none border border-slate-200/50">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </span>
                    @endif
                </div>
            @else
                <div class="flex items-center gap-1.5">
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 text-xs font-bold cursor-not-allowed select-none border border-slate-200/50">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </span>
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#1B365D] text-white text-xs font-black shadow-xs">
                        1
                    </span>
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-100 text-slate-300 text-xs font-bold cursor-not-allowed select-none border border-slate-200/50">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </span>
                </div>
            @endif
        </div>

    @else
        <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center space-y-4 shadow-xs">
            <div class="w-16 h-16 bg-sky-50 text-[#1B365D] rounded-2xl flex items-center justify-center text-2xl mx-auto border border-sky-100">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-lg font-black text-slate-900">Tidak Ada Dokumen Ditemukan</h3>
                <p class="text-xs md:text-sm text-slate-500 font-medium max-w-md mx-auto">
                    Coba ubah pencarian atau pilih kategori filter yang berbeda.
                </p>
            </div>
        </div>
    @endif

</div>
