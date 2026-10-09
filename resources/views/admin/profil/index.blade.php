@extends('components.layouts.admin')

@section('title', 'Profil PPID - Admin PPID')
@section('header_title', 'Kelola Profil PPID')

@section('content')
<div class="space-y-6 w-full pb-10">

    <div>
        <h1 class="text-2xl sm:text-[1.7rem] font-black text-slate-900 tracking-tight">Profil PPID Pelaksana</h1>
        <p class="text-sm text-slate-500 font-medium mt-1.5 leading-relaxed">Kelola foto, identitas, dan uraian tugas pejabat yang ditampilkan di halaman beranda masyarakat.</p>
    </div>

    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
        @csrf

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 sm:p-7">
                {{-- KIRI: Nama Pejabat, Foto, Jabatan --}}
                <div class="space-y-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Nama Pejabat <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" required
                               value="{{ old('nama', $profil['nama'] ?? 'Aristoeteles') }}"
                               placeholder="Contoh: Dr. Aristoteles, S.Si., M.Si."
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Foto Pejabat</label>
                        <div class="flex items-center gap-4">
                            <div id="foto-preview-wrap"
                                 class="w-48 h-32 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center shrink-0 shadow-sm">
                                @if(!empty($profil['foto']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($profil['foto']))
                                    <img id="foto-preview-img"
                                         src="{{ asset('storage/' . $profil['foto']) }}"
                                         alt="Foto Profil"
                                         class="w-full h-full object-contain bg-white">
                                @else
                                    <div id="foto-preview-empty" class="flex items-center justify-center w-full h-full text-slate-400 font-black text-xl">
                                        {{ strtoupper(substr($profil['nama'] ?? 'A', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 space-y-2">
                                <label for="foto-input" class="flex items-center gap-2.5 w-full px-3 py-2.5 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 hover:bg-sky-50 hover:border-sky-200 cursor-pointer transition group">
                                    <span class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 group-hover:border-sky-200 group-hover:bg-sky-600 group-hover:text-white text-slate-700 font-bold text-xs shadow-sm transition whitespace-nowrap">
                                        Pilih File
                                    </span>
                                    <span id="foto-file-name" class="text-xs text-slate-400 font-medium truncate">Belum ada file</span>
                                </label>
                                <input type="file" name="foto" id="foto-input" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="previewFoto(this)">
                                <p class="text-[11px] font-medium text-slate-400">JPG / PNG / WebP · Maks. 3 MB</p>
                            </div>
                        </div>
                        @if(!empty($profil['foto']))
                            <label class="flex items-center gap-2 pt-1 cursor-pointer select-none w-fit">
                                <input type="checkbox" name="hapus_foto" value="1" class="rounded border-rose-300 text-rose-600 focus:ring-rose-500 w-4 h-4">
                                <span class="text-xs font-bold text-rose-600">Hapus foto saat ini</span>
                            </label>
                        @endif
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Jabatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="jabatan" required
                               value="{{ old('jabatan', $profil['jabatan'] ?? 'Kasubag TU / PIC PPID Pelaksana') }}"
                               placeholder="Contoh: Kasubag TU / PIC PPID Pelaksana"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                    </div>
                </div>

                {{-- KANAN: Tugas dan Fungsi, Email, WhatsApp --}}
                <div class="space-y-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Tugas dan Fungsi <span class="text-rose-500">*</span></label>
                        <textarea name="tugas_fungsi" rows="7" required
                                  placeholder="Deskripsikan tugas dan fungsi PPID Pelaksana..."
                                  class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition resize-none leading-relaxed">{{ old('tugas_fungsi', $profil['tugas_fungsi'] ?? 'Mengelola, menyediakan, dan melayani informasi publik di lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam; menyusun Daftar Informasi Publik unit; melayani permohonan dan keberatan; serta melaporkan layanan kepada PPID Utama Universitas Lampung.') }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Email Helpdesk <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" required
                                   value="{{ old('email', $profil['email'] ?? 'ppid.fmipa@unila.ac.id') }}"
                                   placeholder="ppid.fmipa@unila.ac.id"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Nomor WhatsApp <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-500 text-sm"><i class="fa-brands fa-whatsapp"></i></span>
                            <input type="text" name="whatsapp" required
                                   value="{{ old('whatsapp', $profil['whatsapp'] ?? '6281320178069') }}"
                                   placeholder="6281320178069"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                        </div>
                        <p class="text-xs font-medium text-slate-400">Format 62xxxx, tanpa spasi/strip.</p>
                    </div>
                </div>
            </div>

            <div class="px-6 sm:px-7 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="px-8 py-3.5 bg-sky-600 hover:bg-sky-700 text-white font-black text-sm rounded-xl shadow-sm transition cursor-pointer">
                    Simpan
                </button>
            </div>
        </div>

    </form>
</div>

@push('scripts')
<script>
function previewFoto(input) {
    const nameEl = document.getElementById('foto-file-name');
    const wrap = document.getElementById('foto-preview-wrap');
    if (input.files && input.files[0]) {
        if (nameEl) nameEl.textContent = input.files[0].name;
        if (nameEl) { nameEl.classList.remove('text-slate-400'); nameEl.classList.add('text-slate-700'); }
        const reader = new FileReader();
        reader.onload = function(e) {
            wrap.innerHTML = `<img id="foto-preview-img" src="${e.target.result}" class="w-full h-full object-contain bg-white" alt="Preview">`;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        if (nameEl) nameEl.textContent = 'Belum ada file';
    }
}
</script>
@endpush
@endsection
