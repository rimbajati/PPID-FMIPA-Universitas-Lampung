@props(['years', 'totalCount', 'kategoryCounts'])

@php
    $reqKategori = request('kategori');
    if (is_string($reqKategori)) {
        $selectedKategori = [$reqKategori];
    } elseif (is_array($reqKategori)) {
        $selectedKategori = array_values(array_filter($reqKategori));
    } else {
        $selectedKategori = [];
    }

    $reqTahun = request('tahun');
    if (is_string($reqTahun)) {
        $selectedTahun = [$reqTahun];
    } elseif (is_array($reqTahun)) {
        $selectedTahun = array_values(array_filter($reqTahun));
    } else {
        $selectedTahun = [];
    }

    $selectedSort = request('sort', 'terbaru');
    $searchVal = request('search', '');
@endphp

<div x-data="{
        openDropdown: null,
        selectedKategori: {{ json_encode($selectedKategori) }},
        selectedTahun: {{ json_encode($selectedTahun) }},
        selectedSort: '{{ $selectedSort }}',
        searchQuery: '{{ $searchVal }}',
        
        toggleDropdown(name) {
            this.openDropdown = this.openDropdown === name ? null : name;
        },
        closeAll() {
            this.openDropdown = null;
        },
        removeKategori(item) {
            this.selectedKategori = this.selectedKategori.filter(k => k !== item);
            this.submitForm();
        },
        removeTahun(item) {
            this.selectedTahun = this.selectedTahun.filter(t => String(t) !== String(item));
            this.submitForm();
        },
        submitForm() {
            const params = new URLSearchParams();
            this.selectedKategori.forEach(k => params.append('kategori[]', k));
            this.selectedTahun.forEach(t => params.append('tahun[]', t));
            if (this.selectedSort && this.selectedSort !== 'terbaru') {
                params.append('sort', this.selectedSort);
            }
            if (this.searchQuery && this.searchQuery.trim() !== '') {
                params.append('search', this.searchQuery.trim());
            }
            window.location.href = '{{ url('/informasi-publik') }}?' + params.toString();
        },
        resetAll() {
            this.selectedKategori = [];
            this.selectedTahun = [];
            this.selectedSort = 'terbaru';
            this.searchQuery = '';
            window.location.href = '{{ url('/informasi-publik') }}';
        },
        get kategoriLabel() {
            if (this.selectedKategori.length === 0) return 'Kategori';
            if (this.selectedKategori.length === 1) return this.selectedKategori[0];
            return this.selectedKategori.length + ' Kategori';
        },
        get tahunLabel() {
            if (this.selectedTahun.length === 0) return 'Tahun';
            if (this.selectedTahun.length === 1) return this.selectedTahun[0];
            return this.selectedTahun.length + ' Tahun';
        },
        get sortLabel() {
            if (this.selectedSort === 'terlama') return 'Terlama';
            if (this.selectedSort === 'populer') return 'Sering Dilihat';
            return 'Terbaru';
        }
    }" 
    @click.outside="closeAll()"
    class="bg-white border border-slate-200/90 rounded-3xl p-5 md:p-6 shadow-xs space-y-4">

    <form x-ref="filterForm" action="{{ url('/informasi-publik') }}" method="GET" @submit.prevent="submitForm()" class="space-y-4">
        
        <!-- ROW 1: Pill Dropdown Buttons (Full Width 3 Columns) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full relative">
            
            <!-- 1. KATEGORI PILL DROPDOWN -->
            <div class="relative w-full">
                <button type="button" 
                        @click="toggleDropdown('kategori')"
                        :class="selectedKategori.length > 0 ? 'border-2 border-sky-500 bg-sky-50 text-sky-700' : 'border border-slate-300 bg-white text-slate-700 hover:border-slate-400'"
                        class="w-full px-5 py-2.5 rounded-full text-xs md:text-sm font-bold flex items-center justify-between gap-2.5 transition shadow-2xs cursor-pointer select-none">
                    <span x-text="kategoriLabel"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-500 transition-transform duration-200" :class="openDropdown === 'kategori' ? 'rotate-180' : ''"></i>
                </button>

                <!-- Floating Dropdown Modal -->
                <div x-show="openDropdown === 'kategori'" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-cloak
                     class="absolute left-0 mt-2 w-full min-w-[240px] bg-white border border-slate-200 rounded-2xl shadow-xl z-50 p-3 space-y-1">
                    
                    @php
                        $kategoriPills = [
                            'Informasi Berkala'      => 'bg-[#1B365D] text-white',
                            'Informasi Serta-Merta'  => 'bg-rose-500 text-white',
                            'Informasi Setiap Saat'  => 'bg-emerald-500 text-white',
                            'Informasi Dikecualikan' => 'bg-slate-600 text-white',
                        ];
                    @endphp

                    @foreach($kategoriPills as $cat => $bgClass)
                        <label class="flex items-center gap-3 p-2.5 hover:bg-slate-50 rounded-xl cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" 
                                   name="kategori[]" 
                                   value="{{ $cat }}" 
                                   x-model="selectedKategori"
                                   @change="submitForm()"
                                   class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500 cursor-pointer">
                            <span class="px-3.5 py-1 rounded-full text-xs font-bold {{ $bgClass }} shadow-2xs">
                                {{ $cat }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 2. TAHUN PILL DROPDOWN -->
            <div class="relative w-full">
                <button type="button" 
                        @click="toggleDropdown('tahun')"
                        :class="selectedTahun.length > 0 ? 'border-2 border-sky-500 bg-sky-50 text-sky-700' : 'border border-slate-300 bg-white text-slate-700 hover:border-slate-400'"
                        class="w-full px-5 py-2.5 rounded-full text-xs md:text-sm font-bold flex items-center justify-between gap-2.5 transition shadow-2xs cursor-pointer select-none">
                    <span x-text="tahunLabel"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-500 transition-transform duration-200" :class="openDropdown === 'tahun' ? 'rotate-180' : ''"></i>
                </button>

                <!-- Floating Dropdown Modal -->
                <div x-show="openDropdown === 'tahun'" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-cloak
                     class="absolute left-0 mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl z-50 p-3 space-y-1 max-h-56 overflow-y-auto">
                    
                    @foreach($years as $yr)
                        <label class="flex items-center gap-3 p-2.5 hover:bg-slate-50 rounded-xl cursor-pointer text-xs font-bold text-slate-700">
                            <input type="checkbox" 
                                   name="tahun[]" 
                                   value="{{ $yr }}" 
                                   x-model="selectedTahun"
                                   @change="submitForm()"
                                   class="w-4 h-4 text-sky-600 rounded border-slate-300 focus:ring-sky-500 cursor-pointer">
                            <span>{{ $yr }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 3. URUTKAN PILL DROPDOWN (Matching Floating Design) -->
            <div class="relative w-full">
                <button type="button" 
                        @click="toggleDropdown('sort')"
                        :class="selectedSort !== 'terbaru' ? 'border-2 border-sky-500 bg-sky-50 text-sky-700' : 'border border-slate-300 bg-white text-slate-700 hover:border-slate-400'"
                        class="w-full px-5 py-2.5 rounded-full text-xs md:text-sm font-bold flex items-center justify-between gap-2.5 transition shadow-2xs cursor-pointer select-none">
                    <span x-text="sortLabel"></span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-500 transition-transform duration-200" :class="openDropdown === 'sort' ? 'rotate-180' : ''"></i>
                </button>

                <!-- Floating Dropdown Modal -->
                <div x-show="openDropdown === 'sort'" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-cloak
                     class="absolute right-0 mt-2 w-full bg-white border border-slate-200 rounded-2xl shadow-xl z-50 p-2 space-y-1">
                    
                    @php
                        $sortOptions = [
                            'terbaru' => 'Terbaru',
                            'terlama' => 'Terlama',
                            'populer' => 'Sering Dilihat',
                        ];
                    @endphp

                    @foreach($sortOptions as $val => $label)
                        <button type="button" 
                                @click="selectedSort = '{{ $val }}'; openDropdown = null; submitForm()"
                                class="w-full text-left p-2.5 hover:bg-slate-50 rounded-xl cursor-pointer text-xs font-bold transition flex items-center justify-between"
                                :class="selectedSort === '{{ $val }}' ? 'text-sky-600 bg-sky-50/60 font-black' : 'text-slate-700'">
                            <span>{{ $label }}</span>
                            <i x-show="selectedSort === '{{ $val }}'" class="fa-solid fa-check text-xs text-sky-600"></i>
                        </button>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- ROW 2: Active Filter Chips (Tags dengan warna spesifik & tombol 'x') -->
        <div x-show="selectedKategori.length > 0 || selectedTahun.length > 0" class="flex flex-wrap items-center gap-2 pt-1">
            
            <!-- Kategori Chips -->
            <template x-for="cat in selectedKategori" :key="cat">
                <span :class="{
                        'bg-[#1B365D] text-white': cat === 'Informasi Berkala',
                        'bg-rose-500 text-white': cat === 'Informasi Serta-Merta',
                        'bg-emerald-500 text-white': cat === 'Informasi Setiap Saat',
                        'bg-slate-600 text-white': cat === 'Informasi Dikecualikan'
                      }" 
                      class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold rounded-full shadow-2xs">
                    <span x-text="cat"></span>
                    <button type="button" @click.stop.prevent="removeKategori(cat)" class="hover:opacity-70 transition cursor-pointer p-0.5">
                        <i class="fa-solid fa-xmark text-[11px]"></i>
                    </button>
                </span>
            </template>

            <!-- Tahun Chips (Biru Muda Sky-500) -->
            <template x-for="thn in selectedTahun" :key="thn">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-sky-500 text-white text-xs font-bold rounded-full shadow-2xs">
                    <span x-text="thn"></span>
                    <button type="button" @click.stop.prevent="removeTahun(thn)" class="hover:text-slate-200 transition cursor-pointer p-0.5">
                        <i class="fa-solid fa-xmark text-[11px]"></i>
                    </button>
                </span>
            </template>
        </div>

        <!-- ROW 3: Pill Search Bar + Tombol Cari (Biru Muda) & Hapus Semua -->
        <div class="flex items-center gap-3 pt-1">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       x-model="searchQuery"
                       placeholder="Cari informasi..." 
                       class="w-full px-6 py-3 bg-slate-50/80 border border-slate-200 rounded-full text-xs md:text-sm font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-sky-500 focus:ring-4 focus:ring-sky-100 transition shadow-inner">
            </div>

            <button type="submit" 
                    class="px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white font-extrabold text-xs md:text-sm rounded-full transition flex items-center justify-center gap-2 shadow-md cursor-pointer whitespace-nowrap">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                <span>Cari</span>
            </button>

            <!-- Tombol Hapus Semua (Reset) -->
            <button type="button" 
                    @click="resetAll()"
                    x-show="selectedKategori.length > 0 || selectedTahun.length > 0 || searchQuery !== ''"
                    class="text-xs font-extrabold text-slate-700 hover:text-red-600 transition whitespace-nowrap px-2 cursor-pointer">
                Hapus Semua
            </button>
        </div>

    </form>
</div>




