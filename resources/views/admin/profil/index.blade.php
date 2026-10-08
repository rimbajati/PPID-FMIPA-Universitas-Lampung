@extends('components.layouts.admin')

@section('title', 'Profil PPID - Admin PPID')
@section('header_title', 'Kelola Profil PPID')

@section('content')
<div class="space-y-6 w-full pb-10">

    {{-- Alert --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-bold shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-sm space-y-1.5 shadow-sm">
            <div class="font-black flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>Terjadi kesalahan pada input:</span>
            </div>
            <ul class="list-disc list-inside font-medium space-y-0.5 pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Page Title --}}
    <div>
        <h1 class="text-2xl sm:text-[1.7rem] font-black text-slate-900 tracking-tight">Profil PPID Pelaksana</h1>
        <p class="text-sm text-slate-500 font-medium mt-1.5 leading-relaxed">Kelola foto, identitas, dan uraian tugas pejabat yang ditampilkan di halaman beranda masyarakat.</p>
    </div>

        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-[360px_1fr] gap-6 items-start" onsubmit="$el.querySelector('button[type=submit]').innerHTML='Memproses...'; $el.querySelector('button[type=submit]').disabled=true;">
        @csrf

        {{-- Kiri: Foto --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 pt-6 pb-4">
                <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-xs"><i class="fa-solid fa-camera"></i></span>
                    Foto Pejabat / PIC
                </h2>
                <p class="text-sm text-slate-400 font-medium mt-1 leading-snug">Foto formal akan tampil besar di beranda. Gunakan rasio potrait.</p>
            </div>

            <div class="px-6 pb-6 space-y-4">
                {{-- Preview --}}
                <div id="foto-preview-wrap"
                     class="w-full aspect-[3/4] max-h-[380px] rounded-2xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center shadow-inner">
                    @if(!empty($profil['foto']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($profil['foto']))
                        <img id="foto-preview-img"
                             src="{{ asset('storage/' . $profil['foto']) }}"
                             alt="Foto Profil"
                             class="w-full h-full object-cover">
                    @else
                        <div id="foto-preview-empty" class="flex flex-col items-center justify-center gap-3 p-8 text-center w-full h-full">
                            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center shadow-md text-white font-black text-3xl">
                                {{ strtoupper(substr($profil['nama'] ?? 'A', 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-400">Belum ada foto</span>
                        </div>
                    @endif
                </div>

                {{-- Upload --}}
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-800">Ganti Foto</label>

                    <label for="foto-input" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 hover:bg-sky-50 hover:border-sky-200 cursor-pointer transition group">
                        <span class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 group-hover:border-sky-200 group-hover:bg-sky-600 group-hover:text-white text-slate-700 font-bold text-sm shadow-sm transition whitespace-nowrap">
                            Pilih File
                        </span>
                        <span id="foto-file-name" class="text-sm text-slate-400 font-medium truncate">Belum ada file dipilih</span>
                    </label>
                    <input type="file" name="foto" id="foto-input" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="previewFoto(this)">

                    <p class="text-xs font-medium text-slate-400 leading-relaxed">Format JPG / PNG / WebP · Maks. 3 MB · Disarankan foto potrait formal.</p>

                    @if(!empty($profil['foto']))
                        <label class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl bg-rose-50 border border-rose-200 cursor-pointer select-none hover:bg-rose-100 transition">
                            <input type="checkbox" name="hapus_foto" value="1" class="rounded border-rose-300 text-rose-600 focus:ring-rose-500 w-4 h-4">
                            <span class="text-sm font-bold text-rose-700">Hapus foto saat ini</span>
                        </label>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan: Form --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 sm:px-7 pt-6 pb-4 border-b border-slate-100">
                <h2 class="text-base font-extrabold text-slate-900">Informasi Pejabat PPID</h2>
                <p class="text-sm text-slate-400 font-medium mt-1">Perbarui identitas dan uraian tugas yang tampil di beranda.</p>
            </div>

            <div class="px-6 sm:px-7 py-6 space-y-5">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Nama Pejabat / PIC <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required
                           value="{{ old('nama', $profil['nama'] ?? 'Aristoeteles') }}"
                           placeholder="Contoh: Dr. Aristoteles, S.Si., M.Si."
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Jabatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="jabatan" required
                           value="{{ old('jabatan', $profil['jabatan'] ?? 'Kasubag TU / PIC PPID Pelaksana') }}"
                           placeholder="Contoh: Kasubag TU / PIC PPID Pelaksana"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Tugas dan Fungsi <span class="text-rose-500">*</span></label>
                    <textarea name="tugas_fungsi" rows="6" required
                              placeholder="Deskripsikan tugas dan fungsi PPID Pelaksana..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition resize-none leading-relaxed">{{ old('tugas_fungsi', $profil['tugas_fungsi'] ?? 'Mengelola, menyediakan, dan melayani informasi publik di lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam; menyusun Daftar Informasi Publik unit; melayani permohonan dan keberatan; serta melaporkan layanan kepada PPID Utama Universitas Lampung.') }}</textarea>
                    <p class="text-xs font-medium text-slate-400">Teks ini tampil tepat di samping foto pada section Profil di beranda.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2 border-t border-slate-100">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Email Helpdesk <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" required
                                   value="{{ old('email', $profil['email'] ?? 'ppid.fmipa@unila.ac.id') }}"
                                   placeholder="ppid.fmipa@unila.ac.id"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-900 placeholder:text-slate-400 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                        </div>
                        <p class="text-xs font-medium text-slate-400">Tampil di banner bantuan & footer.</p>
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

            <div class="px-6 sm:px-7 py-4 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ url('/admin/profil-ppid') }}" class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-50 transition">Batal</a>
                <button type="submit"
                        class="px-7 py-3 bg-sky-600 hover:bg-sky-700 text-white font-extrabold text-sm rounded-xl shadow-md shadow-sky-600/20 transition inline-flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Perubahan
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
            wrap.innerHTML = `<img id="foto-preview-img" src="${e.target.result}" class="w-full h-full object-cover" alt="Preview Foto">`;
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        if (nameEl) nameEl.textContent = 'Belum ada file dipilih';
    }
}
</script>
@endpush
@endsection
