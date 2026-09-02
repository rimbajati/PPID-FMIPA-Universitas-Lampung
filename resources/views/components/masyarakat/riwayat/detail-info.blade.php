<!-- DETAIL Rincian Layanan Tiket -->
<div class="space-y-5 text-xs md:text-sm">
    <div>
        <span class="block font-black text-slate-400 text-[14px]">Tanggal Pengajuan</span>
        <span class="block font-black text-slate-900 text-sm md:text-base mt-1" x-text="activeItem.tanggal_pengajuan || '-'"></span>
    </div>

    <div>
        <div class="flex items-center gap-1.5">
            <span class="font-black text-slate-400 text-[14px]">Estimasi Selesai</span>
            <!-- <span class="text-[10px] font-extrabold text-[#1B365D] bg-sky-100 border border-sky-200 px-1.5 py-0.5 rounded-md">(10 Hari Kerja)</span> -->
        </div>
        <span class="block font-black text-slate-900 text-sm md:text-base mt-1" x-text="activeItem.estimasi_selesai || '-'"></span>
    </div>

    <!-- Pengecekan agar Cara Memperoleh Informasi tidak muncul saat tipe keberatan -->
    <template x-if="activeItem.type !== 'keberatan'">
        <div>
            <span class="block font-black text-slate-400 text-[14px]">Cara Memperoleh Informasi</span>
            <span class="block font-black text-slate-900 text-sm md:text-base mt-1" 
                  x-text="activeItem.cara_memperoleh_informasi === 'email' ? 'Dikirim melalui Email' : (activeItem.cara_memperoleh_informasi === 'dekanat' ? 'Datang langsung ke Dekanat FMIPA Universitas Lampung' : (activeItem.cara_memperoleh_informasi === 'whatsapp' ? 'Dikirim melalui WhatsApp' : (activeItem.cara_memperoleh_informasi || '-')))"></span>
        </div>
    </template>

    <div class="pt-4 border-t border-slate-100">
        <span class="block font-black text-slate-400 text-[14px]" x-text="activeItem.type === 'keberatan' ? 'Alasan Keberatan' : 'Informasi Yang Diminta'"></span>
        <p class="font-black text-slate-900 mt-1 text-sm md:text-base leading-relaxed" x-text="activeItem.type === 'keberatan' ? (activeItem.alasan_keberatan || activeItem.judul) : (activeItem.informasi_yang_diminta || activeItem.judul)"></p>
    </div>

    <template x-if="activeItem.deskripsi || activeItem.tujuan_penggunaan_informasi || activeItem.kronologi_keberatan">
        <div class="pt-3 border-t border-slate-100">
            <span class="block font-black text-slate-400 text-[14px]" x-text="activeItem.type === 'keberatan' ? 'Kronologi Keberatan' : 'Tujuan Penggunaan Informasi'"></span>
            <p class="font-semibold text-slate-800 mt-1 text-xs md:text-sm leading-relaxed" x-text="activeItem.type === 'keberatan' ? (activeItem.kronologi_keberatan || activeItem.deskripsi) : (activeItem.tujuan_penggunaan_informasi || activeItem.deskripsi)"></p>
        </div>
    </template>

    <template x-if="activeItem.type !== 'keberatan'">
        <div class="pt-3 border-t border-slate-100">
            <span class="block font-black text-slate-400 text-[14px]">Dokumen Identitas (KTP / SIM)</span>
            <div class="mt-1">
                <template x-if="activeItem.file_identitas || activeItem.identitas_file || activeItem.identitas_file_url">
                    <a :href="activeItem.identitas_file_url || ('/storage/' + (activeItem.file_identitas || activeItem.identitas_file))" target="_blank" class="font-extrabold text-[#0284c7] underline hover:text-[#0369a1] inline-flex items-center gap-1.5 cursor-pointer text-xs md:text-sm">
                        <!-- <i class="fa-solid fa-eye text-xs"></i> -->
                        <span>Lihat Identitas</span>
                    </a>
                </template>
                <template x-if="!activeItem.file_identitas && !activeItem.identitas_file && !activeItem.identitas_file_url">
                    <span class="font-black text-slate-400">-</span>
                </template>
            </div>
        </div>
    </template>

    <div class="pt-3 border-t border-slate-100">
        <span class="block font-black text-slate-400 text-[14px]" x-text="activeItem.type === 'keberatan' ? 'Dokumen Pendukung Keberatan' : 'Dokumen Pendukung Permohonan'"></span>
        <div class="mt-1">
            <template x-if="activeItem.file_pendukung || activeItem.pendukung_file || activeItem.file_pendukung_url">
                <a :href="activeItem.file_pendukung_url || ('/storage/' + (activeItem.file_pendukung || activeItem.pendukung_file))" target="_blank" class="font-extrabold text-[#0284c7] underline hover:text-[#0369a1] inline-flex items-center gap-1.5 cursor-pointer text-xs md:text-sm">
                    <!-- <i class="fa-solid fa-eye text-xs"></i> -->
                    <span>Lihat Dokumen Pendukung</span>
                </a>
            </template>
            <template x-if="!activeItem.file_pendukung && !activeItem.pendukung_file && !activeItem.file_pendukung_url">
                <span class="font-black text-slate-400">-</span>
            </template>
        </div>
    </div>
</div>