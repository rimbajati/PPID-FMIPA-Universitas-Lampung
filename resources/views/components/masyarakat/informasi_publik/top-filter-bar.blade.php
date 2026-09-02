@props(['years', 'totalCount', 'kategoryCounts'])
<!-- Top Horizontal Filter & Search Bar Layout Baru -->
<div class="space-y-6">
    <!-- Top Row: Full Search Bar & Quick Stats -->
    <form action="{{ url('/informasi-publik') }}" method="GET" class="space-y-4">
        <div class="flex flex-col md:flex-row items-center gap-3">
            <!-- Search Input -->
            <div class="relative flex-1 w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari informasi berdasarkan judul atau deskripsi..." 
                       class="w-full pl-11 pr-24 py-3.5 bg-white border border-slate-200/90 rounded-2xl text-xs md:text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:border-[#1B365D] focus:ring-4 focus:ring-sky-100 transition shadow-xs">
                @if(request('kategori')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
                @if(request('tahun')) <input type="hidden" name="tahun" value="{{ request('tahun') }}"> @endif
                
                <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 px-5 py-2.5 bg-[#1B365D] hover:bg-[#152a4a] text-white font-extrabold text-xs uppercase tracking-wider transition rounded-xl flex items-center gap-1.5 shadow-xs cursor-pointer">
                    <span>Cari</span>
                </button>
            </div>

            <!-- Ajukan Permohonan Quick CTA Button -->
            <a href="{{ url('/permohonan') }}" class="w-full md:w-auto px-6 py-3.5 bg-gradient-to-r from-sky-500 to-sky-700 hover:from-sky-600 hover:to-sky-700 text-white font-black text-xs md:text-sm rounded-2xl transition shadow-sm flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                <i class="fa-solid fa-file-circle-plus text-sm"></i>
                <span>Tidak Menemukan? Ajukan Permohonan</span>
            </a>
        </div>
    </form>

    <!-- Bottom Row: Horizontal Kategori Pill Tabs & Filter Dropdowns (Seamless No-Cutoff) -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-slate-200/80">
        @php
            $categories = [
                'Informasi Berkala' => 'Berkala',
                'Informasi Serta-Merta' => 'Serta-Merta',
                'Informasi Setiap Saat' => 'Setiap Saat',
                'Informasi Dikecualikan' => 'Dikecualikan'
            ];
            $isCatAll = !request('kategori');
        @endphp

        <!-- Kategori Pill Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-0.5" style="scrollbar-width: none; -ms-overflow-style: none;">
            <!-- Tab Semua -->
            <a href="{{ request()->fullUrlWithQuery(['kategori' => null]) }}" 
               class="px-3.5 py-2 rounded-xl text-xs transition-all duration-200 whitespace-nowrap flex items-center gap-2 cursor-pointer font-extrabold shadow-2xs shrink-0 {{ $isCatAll ? 'bg-[#1B365D] text-white ring-2 ring-[#1B365D]/30' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 hover:text-slate-900' }}">
                <i class="fa-solid fa-layer-group text-[11px]"></i>
                <span>Semua Kategori</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black {{ $isCatAll ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $totalCount }}</span>
            </a>

            @foreach($categories as $fullCat => $shortCat)
                @php
                    $count = $kategoryCounts[$fullCat] ?? 0;
                    $isActive = request('kategori') === $fullCat;
                    
                    $icon = 'fa-solid fa-folder';
                    if ($fullCat === 'Informasi Berkala') $icon = 'fa-solid fa-clock';
                    if ($fullCat === 'Informasi Serta-Merta') $icon = 'fa-solid fa-bullhorn';
                    if ($fullCat === 'Informasi Setiap Saat') $icon = 'fa-solid fa-globe';
                    if ($fullCat === 'Informasi Dikecualikan') $icon = 'fa-solid fa-lock';
                @endphp
                <a href="{{ request()->fullUrlWithQuery(['kategori' => $fullCat]) }}" 
                   class="px-3.5 py-2 rounded-xl text-xs transition-all duration-200 whitespace-nowrap flex items-center gap-2 cursor-pointer font-extrabold shadow-2xs shrink-0 {{ $isActive ? 'bg-[#1B365D] text-white ring-2 ring-[#1B365D]/30' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50 hover:text-slate-900' }}">
                    <i class="{{ $icon }} text-[11px]"></i>
                    <span>{{ $fullCat }}</span>
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $count }}</span>
                </a>
            @endforeach
        </div>

        <!-- Filter Dropdowns (Tahun & Urutkan) -->
        <div class="flex items-center gap-2 shrink-0 justify-end">
            <!-- Filter Dropdown Tahun -->
            <select onchange="window.location.href=this.value" 
                    class="bg-white border border-slate-200 text-slate-700 text-xs font-extrabold py-2 px-3 rounded-xl focus:bg-white focus:outline-none focus:border-[#1B365D] transition cursor-pointer shadow-2xs">
                <option value="{{ request()->fullUrlWithQuery(['tahun' => null]) }}" {{ !request('tahun') ? 'selected' : '' }}>Semua Tahun</option>
                @foreach($years as $yr)
                    <option value="{{ request()->fullUrlWithQuery(['tahun' => $yr]) }}" {{ request('tahun') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>

            <!-- Dropdown Urutkan -->
            <select onchange="window.location.href=this.value" 
                    class="bg-white border border-slate-200 text-slate-700 text-xs font-extrabold py-2 px-3 rounded-xl focus:bg-white focus:outline-none focus:border-[#1B365D] transition cursor-pointer shadow-2xs">
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'terlama']) }}" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama</option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'populer']) }}" {{ request('sort') === 'populer' ? 'selected' : '' }}>Sering Dilihat</option>
            </select>
        </div>
    </div>
</div>
