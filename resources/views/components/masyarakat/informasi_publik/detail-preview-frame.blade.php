@props(['info', 'isLink', 'viewUrl', 'embedUrl' => null, 'isDriveFolder' => false])

<div class="bg-white border border-slate-200/90 rounded-3xl p-6 md:p-8 shadow-sm space-y-4">
    
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
        <div class="flex items-center gap-2.5">
            <span class="w-3 h-3 rounded-full bg-sky-500 animate-pulse"></span>
            <h2 class="text-md font-extrabold text-slate-800">
                Preview Informasi
            </h2>
        </div>

        @if($info->kategori_informasi !== 'Informasi Dikecualikan' && !$isLink)
            <a href="{{ $viewUrl }}" target="_blank" class="text-xs font-extrabold text-sky-600 hover:text-sky-700 flex items-center gap-1.5 cursor-pointer">
                <span>Full Screen</span>
                <i class="fa-solid fa-up-right-and-down-left-from-center text-[10px]"></i>
            </a>
        @endif
    </div>

    <!-- Preview Frame Container -->
    <div class="w-full rounded-2xl overflow-hidden border border-slate-200/80 relative shadow-inner">
        @if($info->kategori_informasi === 'Informasi Dikecualikan')
            <div class="w-full flex flex-col items-center justify-center p-8 bg-slate-50 text-center space-y-4 min-h-[500px]">
                <div class="w-16 h-16 rounded-2xl bg-slate-200/80 text-slate-500 flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="space-y-1.5">
                    <h3 class="text-lg font-black text-slate-800">Informasi Dikecualikan</h3>
                    <p class="text-xs md:text-sm text-slate-500 max-w-md mx-auto leading-relaxed">
                        Informasi ini bersifat rahasia/dikecualikan sesuai ketentuan UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
                    </p>
                </div>
            </div>
        @elseif($isLink && $isDriveFolder)
            <div class="w-full flex flex-col items-center justify-center p-8 bg-slate-50 text-center space-y-3 min-h-[500px]">
                <div class="w-16 h-16 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-3xl shadow-xs border border-sky-100">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div class="space-y-2 max-w-md">
                    <h3 class="text-lg font-black text-slate-800">Folder Google Drive</h3>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        Tautan ini menuju ke folder Google Drive. Silakan gunakan tombol di sebelah kiri untuk membuka folder.
                    </p>
                </div>
            </div>
        @elseif($isLink)
            <div class="w-full bg-white min-h-[550px] md:min-h-[650px] relative">
                <iframe src="{{ $embedUrl ?: $viewUrl }}" class="w-full h-full min-h-[550px] md:min-h-[650px] border-0 bg-white"></iframe>
            </div>
        @else
            <div class="w-full bg-slate-900 min-h-[550px] md:min-h-[650px]">
                <iframe src="{{ $viewUrl }}" class="w-full h-full min-h-[550px] md:min-h-[650px] border-0"></iframe>
            </div>
        @endif
    </div>

</div>
