<!-- SECTION 2: GRID KARTU DAFTAR RIWAYAT LAYANAN SAYA -->
<div id="daftar-riwayat-grid" class="space-y-6 pt-4">
    {{-- Form Lacak Tiket & Hint side by side --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        <form method="POST" action="{{ route('layanan.riwayat.track') }}" class="w-full">
            @csrf
            <div class="relative flex items-stretch gap-0 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-primary/30 focus-within:border-secondary transition-all duration-200">
                <div class="flex items-center pl-5 pr-3 text-slate-400 pointer-events-none flex-shrink-0">
                    <i class="mdi mdi-magnify text-lg"></i>
                </div>

                <input
                    id="track_no_tiket"
                    name="no_tiket"
                    value="{{ $ticket }}"
                    required
                    autocomplete="off"
                    placeholder="Contoh: PPID-20261006-A3B5"
                    oninput="if(this.value === '') { window.location.href = '{{ route('layanan.riwayat') }}' }"
                    class="flex-1 py-4 pr-4 bg-transparent text-slate-900 font-semibold text-base focus:outline-none placeholder:text-slate-400 placeholder:font-normal tracking-wide"
                >

                <button
                    type="submit"
                    class="flex-shrink-0 m-2 px-6 py-2.5 bg-primary hover:bg-primary active:bg-primary-light text-white font-bold text-sm rounded-xl transition-all duration-150 flex items-center gap-2.5 shadow-sm hover:shadow-md"
                >
                    <i class="mdi mdi-magnify text-xs"></i>
                    <span>Cek Tiket</span>
                </button>
            </div>

            @if($notFound)
                <div class="mt-3 flex items-start gap-2.5 px-4 py-3 bg-rose-50 border border-rose-200 rounded-xl">
                    <i class="mdi mdi-alert-circle-outline text-rose-500 mt-0.5 flex-shrink-0"></i>
                    <p class="text-sm text-rose-700 font-medium">Nomor tiket <span class="font-black">{{ $ticket }}</span> tidak ditemukan.</p>
                </div>
            @endif
        </form>

        {{-- Hint Card --}}
        <div class="flex items-start gap-3 px-5 py-4 bg-secondary-light/60 border border-secondary/20 rounded-2xl">
            <i class="mdi mdi-help-circle-outline text-primary mt-0.5 flex-shrink-0"></i>
            <div class="text-xs md:text-sm text-slate-600 leading-relaxed">
                Nomor tiket diberikan setelah Anda mengajukan permohonan/keberatan. Contoh:
                <code class="font-mono font-black text-primary bg-secondary-light px-1.5 py-0.5 rounded-md text-[10px] md:text-xs mx-1">PPID-20261006-A3B5</code>
                Cek juga email Anda.
            </div>
        </div>
    </div>


</div>
