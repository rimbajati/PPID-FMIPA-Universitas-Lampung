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

        <!-- TAB 1: STRUKTUR ORGANISASI (PORTAL PUBLIK) -->
        <div x-show="tab === 'struktur'" class="space-y-6">

            <!-- KONTAK HELPDESK & LAYANAN PPID -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">Kontak Helpdesk Layanan PPID</h3>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-secondary-light text-primary font-bold">Kanal Resmi</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Email Helpdesk <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required
                               value="{{ old('email', $profil['email'] ?? 'ppid.fmipa@unila.ac.id') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                        <p class="text-[11px] text-slate-400">Digunakan pada footer & tombol kontak layanan.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Nomor WhatsApp <span class="text-rose-500">*</span></label>
                        <input type="text" name="whatsapp" required
                               value="{{ old('whatsapp', $profil['whatsapp'] ?? '6281320178069') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                        <p class="text-[11px] text-slate-400">Format: 628xxxxxxxx (untuk tombol WhatsApp Hubungi PPID)</p>
                    </div>
                </div>
            </div>


            <!-- BAGAN HIERARKI STRUKTUR ORGANISASI (PORTAL PUBLIK) -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">Bagan Struktur Organisasi (Portal Publik)</h3>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-secondary-light text-primary font-bold">Hierarki 3 Lapis</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Judul Section Struktur</label>
                        <input type="text" name="struktur_judul" value="{{ old('struktur_judul', $halaman['struktur_judul'] ?? 'Struktur Organisasi') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-800">Deskripsi Section</label>
                        <input type="text" name="struktur_deskripsi" value="{{ old('struktur_deskripsi', $halaman['struktur_deskripsi'] ?? '') }}" placeholder="Keterangan singkat bila ada" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm">
                    </div>
                </div>

                <!-- Level 1 & 2: Pimpinan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <!-- Level 1: Kepala PPID -->
                    <div class="p-5 rounded-2xl bg-primary text-white space-y-3">
                        <span class="text-[10px] font-black uppercase tracking-widest bg-white/20 text-slate-100 px-3 py-1 rounded-full">Level 1: Kepala PPID (Kotak Navy)</span>
                        <div class="space-y-2 pt-1">
                            <label class="block text-xs font-bold text-secondary">Nama Kepala PPID / Dekan <span class="text-rose-400">*</span></label>
                            <input type="text" name="nama" required value="{{ old('nama', $profil['nama'] ?? 'Dr. Eng. Suripto Dwi Yuwono, S.Si., M.T.') }}" placeholder="Nama Lengkap dengan Gelar" class="w-full px-3 py-2.5 rounded-xl border-0 text-sm font-bold text-slate-900 bg-white focus:ring-2 focus:ring-secondary">

                            <label class="block text-xs font-bold text-secondary">Jabatan Kepala</label>
                            <input type="text" name="struktur_atasan_jabatan" value="{{ old('struktur_atasan_jabatan', $halaman['struktur_atasan']['jabatan'] ?? 'Dekan FMIPA') }}" class="w-full px-3 py-2.5 rounded-xl border-0 text-sm font-bold text-slate-900 bg-white focus:ring-2 focus:ring-secondary">

                            <label class="block text-xs font-bold text-secondary">Peran / Label</label>
                            <input type="text" name="struktur_atasan_peran" value="{{ old('struktur_atasan_peran', $halaman['struktur_atasan']['peran'] ?? 'Atasan PPID') }}" class="w-full px-3 py-2.5 rounded-xl border-0 text-sm text-slate-900 bg-white focus:ring-2 focus:ring-secondary">
                        </div>
                    </div>

                    <!-- Level 2: Wakil Kepala PPID -->
                    <div class="p-5 rounded-2xl bg-white border-2 border-secondary/30 space-y-3">
                        <span class="text-[10px] font-black uppercase tracking-widest bg-primary text-white px-3 py-1 rounded-full">Level 2: Wakil Kepala (Kotak Putih)</span>
                        <div class="space-y-2 pt-1">
                            <label class="block text-xs font-bold text-slate-600">Nama Wakil Kepala PPID</label>
                            <input type="text" name="wakil_nama" value="{{ old('wakil_nama', $profil['wakil_nama'] ?? '') }}" placeholder="Contoh: Dr. Ir. ..." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                            <label class="block text-xs font-bold text-slate-600">Jabatan Wakil</label>
                            <input type="text" name="struktur_ketua_jabatan" value="{{ old('struktur_ketua_jabatan', $halaman['struktur_ketua']['jabatan'] ?? 'Wakil Dekan Bidang Umum dan Keuangan') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                            <label class="block text-xs font-bold text-slate-600">Peran / Label</label>
                            <input type="text" name="struktur_ketua_peran" value="{{ old('struktur_ketua_peran', $halaman['struktur_ketua']['peran'] ?? 'Ketua PPID Pelaksana') }}" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700 focus:ring-2 focus:ring-primary/20">
                        </div>
                    </div>
                </div>

                <!-- Level 3: Koordinator 4 Bidang -->
                <div class="space-y-3 pt-3 border-t border-slate-100">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-bold text-slate-800">Level 3: Koordinator Bidang (4 Kartu)</label>
                        <span class="text-[11px] text-slate-400">Inisial lingkaran otomatis dibuat dari 2 kata pertama nama bidang</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach(($halaman['struktur_bidang'] ?? []) as $i => $b)
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/60 space-y-2 hover:border-secondary/40 transition">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-black text-primary uppercase">Kartu {{ $i+1 }}</span>
                                <span class="text-[10px] px-2 py-0.5 rounded bg-slate-200 text-slate-600 font-bold">Koordinator</span>
                            </div>
                            <input type="text" name="struktur_bidang_jabatan[]" value="{{ $b['jabatan'] }}" placeholder="Nama Bidang" class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                            <input type="text" name="struktur_bidang_peran[]" value="{{ $b['peran'] }}" placeholder="Keterangan / peran singkat" class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-xs text-slate-600 focus:ring-2 focus:ring-primary/20">
                        </div>
                        @endforeach
                    </div>
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
