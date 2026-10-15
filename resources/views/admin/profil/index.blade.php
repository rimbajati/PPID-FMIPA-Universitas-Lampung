@extends('components.layouts.admin')

@section('title', 'Profil - PPID Pelaksana FMIPA Universitas Lampung')
@section('header_title', 'Kelola Profil PPID')

@section('content')
<div class="space-y-6 w-full pb-10" x-data="{ tab: 'struktur' }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-[1.7rem] font-black text-slate-900 tracking-tight">Kelola Profil PPID</h1>
            <p class="text-sm text-slate-500 font-medium mt-1 leading-relaxed">Atur profil struktur PPID pelaksana dan seluruh teks konten di halaman Profil PPID masyarakat.</p>
        </div>
        <a href="{{ route('profil.ppid') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-secondary/30 bg-secondary-light hover:bg-secondary-light text-primary text-xs font-bold transition">
            <i class="mdi mdi-open-in-new"></i> Lihat Halaman Profil
        </a>
    </div>

    <!-- Nav Tab -->
    <div class="flex gap-2 border-b border-slate-200 pb-2">
        <button type="button" @click="tab = 'struktur'"
                :class="tab === 'struktur' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer">
            <i class="mdi mdi-sitemap-outline mr-1.5"></i> Struktur Organisasi
        </button>
        <button type="button" @click="tab = 'hero'"
                :class="tab === 'hero' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer">
            <i class="mdi mdi-bullhorn-outline mr-1.5"></i> Banner & Tentang
        </button>
        <button type="button" @click="tab = 'visimisi'"
                :class="tab === 'visimisi' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer">
            <i class="mdi mdi-target mr-1.5"></i> Visi & Misi
        </button>
        <button type="button" @click="tab = 'maklumat'"
                :class="tab === 'maklumat' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer">
            <i class="mdi mdi-certificate-outline mr-1.5"></i> Maklumat & Standar
        </button>
    </div>

    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
        @csrf

        <!-- TAB 1: STRUKTUR ORGANISASI / PROFIL PPID PELAKSANA -->
        <div x-show="tab === 'struktur'" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-5">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3">Profil PPID Pelaksana & Struktur</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Nama Pejabat / PIC PPID <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" required
                               value="{{ old('nama', $profil['nama'] ?? 'Dr. Aristoteles, S.Si., M.Si.') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Jabatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="jabatan" required
                               value="{{ old('jabatan', $profil['jabatan'] ?? 'Kasubag TU / PIC PPID Pelaksana') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Email Helpdesk <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required
                               value="{{ old('email', $profil['email'] ?? 'ppid.fmipa@unila.ac.id') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Nomor WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="text" name="whatsapp" required
                               value="{{ old('whatsapp', $profil['whatsapp'] ?? '6281320178069') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                        <p class="text-[11px] text-slate-400">Format: 628xxxxxxxx (tanpa tanda + atau spasi)</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Foto Pejabat</label>
                    <div class="flex items-center gap-4">
                        <div id="foto-preview-wrap" class="w-20 h-20 rounded-xl border border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center shrink-0">
                            @if(!empty($profil['foto']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($profil['foto']))
                                <img src="{{ asset('storage/' . $profil['foto']) }}" alt="Foto" class="w-full h-full object-cover">
                            @else
                                <span class="text-slate-400 font-black text-xl">{{ strtoupper(substr($profil['nama'] ?? 'A', 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <input type="file" name="foto" accept="image/jpeg,image/png,image/webp" class="text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-secondary-light file:text-primary hover:file:bg-secondary-light">
                            <p class="text-[11px] text-slate-400">Format: JPG, PNG, WebP maks 3MB</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 pt-2 border-t border-slate-100">
                    <label class="block text-sm font-bold text-slate-800">Tugas dan Fungsi <span class="text-rose-500">*</span></label>
                    <textarea name="tugas_fungsi" rows="4"
                              placeholder="Mengelola, menyediakan, dan melayani informasi publik..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition leading-relaxed">{{ old('tugas_fungsi', $profil['tugas_fungsi'] ?? 'Mengelola, menyediakan, dan melayani informasi publik di lingkungan Fakultas Matematika dan Ilmu Pengetahuan Alam; menyusun Daftar Informasi Publik unit; melayani permohonan dan keberatan; serta melaporkan layanan kepada PPID Utama Universitas Lampung.') }}</textarea>
                    <p class="text-[11px] text-slate-400">Teks ini akan tampil pada bagian Tugas dan Fungsi di sebelah kanan foto profil pelaksana.</p>
                </div>
            </div>
        </div>

        <!-- TAB 2: HERO BANNER & TENTANG PPID -->
        <div x-show="tab === 'hero'" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-5">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3">Hero Banner Atas</h3>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Judul Banner <span class="text-rose-500">*</span></label>
                    <input type="text" name="hero_judul" required
                           value="{{ old('hero_judul', $halaman['hero_judul'] ?? 'Profil PPID Pelaksana FMIPA') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Deskripsi Banner <span class="text-rose-500">*</span></label>
                    <textarea name="hero_deskripsi" rows="3" required
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none">{{ old('hero_deskripsi', $halaman['hero_deskripsi'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-5">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3">Section "Tentang Kami (Apa itu PPID?)"</h3>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Judul Section</label>
                    <input type="text" name="tentang_judul"
                           value="{{ old('tentang_judul', $halaman['tentang_judul'] ?? 'Apa itu PPID?') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Paragraf 1 (Definisi PPID) <span class="text-rose-500">*</span></label>
                    <textarea name="tentang_p1" rows="3" required
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none">{{ old('tentang_p1', $halaman['tentang_p1'] ?? '') }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Paragraf 2 (Komitmen & Dasar Hukum) <span class="text-rose-500">*</span></label>
                    <textarea name="tentang_p2" rows="3" required
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none">{{ old('tentang_p2', $halaman['tentang_p2'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- TAB 3: VISI & MISI -->
        <div x-show="tab === 'visimisi'" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-5">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3">Visi</h3>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Pernyataan Visi <span class="text-rose-500">*</span></label>
                    <textarea name="visi" rows="3" required
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none">{{ old('visi', $halaman['visi'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">Daftar Misi (4 Poin)</h3>
                </div>

                <div class="space-y-4">
                    @foreach(($halaman['misi'] ?? []) as $i => $m)
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-md bg-primary text-white font-bold text-xs flex items-center justify-center">{{ $i + 1 }}</span>
                            <input type="text" name="misi_judul[]" value="{{ $m['judul'] }}" placeholder="Judul Misi"
                                   class="flex-1 px-3 py-2 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-900">
                        </div>
                        <textarea name="misi_deskripsi[]" rows="2" placeholder="Uraian Misi"
                                  class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-xs text-slate-600 resize-none">{{ $m['deskripsi'] }}</textarea>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- TAB 4: MAKLUMAT & STANDAR PELAYANAN -->
        <div x-show="tab === 'maklumat'" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-5">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3">Maklumat Pelayanan</h3>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Teks Janji Maklumat <span class="text-rose-500">*</span></label>
                    <textarea name="maklumat_quote" rows="3" required
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none">{{ old('maklumat_quote', $halaman['maklumat_quote'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-4">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3">Standar Pelayanan (8 Butir)</h3>

                <div class="space-y-3">
                    @foreach(($halaman['standar_pelayanan'] ?? []) as $i => $s)
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-2 items-center p-3 rounded-xl border border-slate-100 bg-slate-50">
                        <div class="sm:col-span-4">
                            <input type="text" name="standar_label[]" value="{{ $s['label'] }}" placeholder="Label"
                                   class="w-full px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-800">
                        </div>
                        <div class="sm:col-span-8">
                            <input type="text" name="standar_isi[]" value="{{ $s['isi'] }}" placeholder="Isi Standar"
                                   class="w-full px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-xs text-slate-600">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>



        <!-- Tombol Simpan Fixed Bawah -->
        <div class="sticky bottom-4 z-20 mt-6 bg-white border border-slate-200 rounded-2xl p-4 shadow-lg flex items-center justify-between">
            <span class="text-xs text-slate-400 font-medium">Pastikan semua data sudah terisi dengan benar</span>
            <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary-light text-white font-black text-sm rounded-xl shadow-md transition cursor-pointer">
                <i class="mdi mdi-content-save-outline mr-1.5"></i> Simpan Semua Perubahan
            </button>
        </div>

    </form>
</div>
@endsection
