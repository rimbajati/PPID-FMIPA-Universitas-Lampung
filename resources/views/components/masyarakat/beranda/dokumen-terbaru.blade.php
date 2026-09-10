@props([
    'dokumenTerbaru' => collect()
])

<!-- Dokumen Publik Terbaru Section -->
<section class="max-w-7xl mx-auto px-6 md:px-16 lg:px-24 mb-20">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-700 text-xs font-extrabold border border-sky-100">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Publikasi Terkini</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Dokumen Informasi Publik Terbaru</h2>
            <p class="text-sm sm:text-base text-slate-600 font-medium">Berkas dan dokumen resmi yang baru saja diperbarui dan dapat diakses langsung oleh publik.</p>
        </div>

        <a href="{{ url('/informasi-publik') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-extrabold text-sky-600 hover:text-sky-700 hover:gap-3 transition-all shrink-0">
            <span>Lihat Semua Dokumen (Katalog)</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    @if($dokumenTerbaru->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($dokumenTerbaru as $doc)
                <div class="bg-white border border-slate-200/90 rounded-3xl p-6 hover:shadow-lg hover:border-sky-300 transition-all duration-300 flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            @php
                                $badgeColor = match($doc->kategori_informasi) {
                                    'Informasi Berkala' => 'bg-sky-50 text-sky-700 border-sky-200',
                                    'Informasi Setiap Saat' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'Informasi Serta-Merta' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold border {{ $badgeColor }}">
                                {{ $doc->kategori_informasi }}
                            </span>
                            <span class="text-xs font-bold text-slate-500 flex items-center gap-1.5">
                                <i class="fa-regular fa-calendar text-slate-400"></i>
                                Tahun {{ $doc->tahun_terbit ?? '-' }}
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-black text-slate-900 group-hover:text-sky-600 transition-colors line-clamp-2">
                            {{ $doc->judul_informasi }}
                        </h3>

                        @if($doc->deskripsi_informasi)
                            <p class="text-xs text-slate-600 font-medium line-clamp-2 leading-relaxed">
                                {{ $doc->deskripsi_informasi }}
                            </p>
                        @endif
                    </div>

                    <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between gap-3">
                        <div class="text-[11px] text-slate-500 font-semibold flex items-center gap-1.5">
                            <i class="fa-solid fa-eye text-sky-500"></i>
                            <span>{{ number_format($doc->dilihat ?? 0) }} kali dilihat</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ url('/informasi-publik/' . $doc->id) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all">
                                Detail
                            </a>
                            <a href="{{ route('informasi.lihat', $doc->id) }}" target="_blank" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm hover:shadow-md inline-flex items-center gap-1.5 cursor-pointer">
                                <span>Buka Berkas</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white border border-slate-200 rounded-3xl p-10 text-center">
            <div class="w-14 h-14 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-xl mb-3">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <p class="text-sm font-bold text-slate-700">Belum ada dokumen yang dipublikasikan</p>
            <p class="text-xs text-slate-500 mt-1">Dokumen publik akan tampil di sini segera setelah diunggah oleh admin PPID.</p>
        </div>
    @endif
</section>
