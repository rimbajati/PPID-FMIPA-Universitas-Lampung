<!-- Tanya Jawab Seputar PPID Section (FAQ Accordion) -->
<section class="max-w-4xl mx-auto px-6 md:px-12 mb-20" x-data="{ activeAccordion: null }">
    <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sky-50 text-sky-700 text-xs font-extrabold border border-sky-100">
            <i class="fa-solid fa-circle-question"></i>
            <span>FAQ PPID</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Pertanyaan yang Sering Diajukan</h2>
        <p class="text-sm sm:text-base text-slate-600 font-medium">Informasi penting terkait tata kelola dan pengajuan permohonan informasi publik.</p>
    </div>

    <div class="space-y-4">
        
        <!-- FAQ 1 -->
        <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-2xs transition-all">
            <button 
                type="button" 
                @click="activeAccordion = (activeAccordion === 1 ? null : 1)" 
                class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 cursor-pointer focus:outline-none">
                <span class="font-extrabold text-sm sm:text-base text-slate-900">
                    Berapa biaya pengajuan permohonan informasi publik di PPID FMIPA Unila?
                </span>
                <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition-transform duration-300" :class="{ 'rotate-180 bg-sky-100 text-sky-700': activeAccordion === 1 }">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </span>
            </button>
            <div x-show="activeAccordion === 1" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed border-t border-slate-100">
                Layanan permohonan informasi publik di PPID FMIPA Universitas Lampung adalah <strong class="text-emerald-700">GRATIS (tidak dipungut biaya)</strong>. Namun apabila pemohon memerlukan salinan cetak atau pengiriman fisik melalui pos, biaya fotokopi dan ongkos kirim ditanggung oleh pemohon sesuai ketentuan perundang-undangan.
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-2xs transition-all">
            <button 
                type="button" 
                @click="activeAccordion = (activeAccordion === 2 ? null : 2)" 
                class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 cursor-pointer focus:outline-none">
                <span class="font-extrabold text-sm sm:text-base text-slate-900">
                    Berapa lama jangka waktu penyelesaian permohonan informasi?
                </span>
                <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition-transform duration-300" :class="{ 'rotate-180 bg-sky-100 text-sky-700': activeAccordion === 2 }">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </span>
            </button>
            <div x-show="activeAccordion === 2" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed border-t border-slate-100">
                Sesuai amanat UU No. 14 Tahun 2008, PPID FMIPA Unila wajib memberikan pemberitahuan tertulis paling lambat <strong class="text-sky-700">10 (sepuluh) hari kerja</strong> sejak permohonan dinyatakan lengkap. Jangka waktu ini dapat diperpanjang paling lama 7 (tujuh) hari kerja berikutnya dengan disertai alasan tertulis.
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-2xs transition-all">
            <button 
                type="button" 
                @click="activeAccordion = (activeAccordion === 3 ? null : 3)" 
                class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 cursor-pointer focus:outline-none">
                <span class="font-extrabold text-sm sm:text-base text-slate-900">
                    Apa saja syarat untuk mengajukan permohonan informasi?
                </span>
                <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition-transform duration-300" :class="{ 'rotate-180 bg-sky-100 text-sky-700': activeAccordion === 3 }">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </span>
            </button>
            <div x-show="activeAccordion === 3" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed border-t border-slate-100">
                Pemohon wajib memiliki akun terdaftar dan melampirkan identitas resmi:
                <ul class="list-disc pl-5 mt-2 space-y-1">
                    <li>Bagi individu: Kartu Tanda Penduduk (KTP) atau Kartu Tanda Mahasiswa (KTM).</li>
                    <li>Bagi badan hukum/organisasi: Akta notaris/SK Kemenkumham serta surat kuasa perwakilan.</li>
                    <li>Menyebutkan tujuan penggunaan informasi secara jelas dan tidak bertentangan dengan hukum.</li>
                </ul>
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-2xs transition-all">
            <button 
                type="button" 
                @click="activeAccordion = (activeAccordion === 4 ? null : 4)" 
                class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 cursor-pointer focus:outline-none">
                <span class="font-extrabold text-sm sm:text-base text-slate-900">
                    Kapan pemohon dapat mengajukan keberatan?
                </span>
                <span class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shrink-0 transition-transform duration-300" :class="{ 'rotate-180 bg-sky-100 text-sky-700': activeAccordion === 4 }">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </span>
            </button>
            <div x-show="activeAccordion === 4" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-600 font-medium leading-relaxed border-t border-slate-100">
                Keberatan dapat diajukan jika: permohonan informasi ditolak tanpa alasan yang sah, informasi tidak diberikan dalam batas waktu yang ditentukan, biaya yang dikenakan tidak wajar, atau informasi yang diterima tidak sesuai dengan permohonan. Keberatan diajukan kepada Atasan PPID paling lambat 30 hari kerja.
            </div>
        </div>

    </div>
</section>
