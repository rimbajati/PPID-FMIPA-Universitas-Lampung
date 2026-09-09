<!-- MODAL POPUP SUKSES PERMOHONAN / KEBERATAN DENGAN NOMOR TIKET -->
@if(session('success_tiket') || session('success_keberatan_tiket'))
@php
    $isKeberatan = session()->has('success_keberatan_tiket');
    $nomorTiket = $isKeberatan ? session('success_keberatan_tiket') : session('success_tiket');
    $judulSukses = $isKeberatan ? 'Keberatan Berhasil Dikirim!' : 'Permohonan Berhasil!';
    $deskripsiSukses = $isKeberatan
        ? 'Pengajuan keberatan informasi Anda telah terkirim dan akan segera kami proses.'
        : 'Permohonan informasi Anda telah terkirim dan akan segera kami proses.';
@endphp
<div x-data="{ openSuccessModal: true, copied: false }"
     x-show="openSuccessModal"
     x-cloak
     class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95">

    <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center border border-slate-100">

        <!-- Ikon Sukses Ceria / Clean -->
        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-3xl mb-4">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <h3 class="text-xl font-bold text-slate-800 mb-1.5">{{ $judulSukses }}</h3>
        <p class="text-xs text-slate-500 mb-5 leading-relaxed">
            {{ $deskripsiSukses }}
        </p>

        <!-- Badge Nomor Tiket Ringkas -->
        <div class="bg-slate-50 border border-dashed border-slate-200 rounded-2xl py-3 px-4 mb-6">
            <p class="text-[11px] text-slate-400 font-medium mb-1">Nomor Tiket Anda</p>
            <div class="flex items-center justify-center gap-2">
                <span class="font-mono text-base font-bold text-slate-800 tracking-wide select-all">
                    {{ $nomorTiket }}
                </span>
                <button type="button"
                        @click="navigator.clipboard.writeText('{{ $nomorTiket }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="text-slate-400 hover:text-slate-700 transition p-1 cursor-pointer"
                        title="Salin Nomor Tiket">
                    <i class="fa-solid text-xs" :class="copied ? 'fa-check text-emerald-600' : 'fa-copy'"></i>
                </button>
            </div>
            <span x-show="copied" x-cloak class="text-[10px] text-emerald-600 font-medium block mt-0.5">Berhasil disalin!</span>
        </div>

        <!-- Tombol Utama Tunggal (Oke/Mengerti) -->
        <button type="button"
                @click="openSuccessModal = false"
                class="w-full py-3 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-2xl transition cursor-pointer shadow-sm mb-2">
            Mengerti
        </button>

        <!-- Link alternatif halus untuk cek status -->
        <a href="{{ url('/riwayat-layanan') }}" class="inline-block text-xs text-slate-400 hover:text-slate-600 font-medium transition py-1">
            Lihat riwayat layanan <i class="fa-solid fa-arrow-right text-[10px] ml-0.5"></i>
        </a>

    </div>
</div>
@endif
