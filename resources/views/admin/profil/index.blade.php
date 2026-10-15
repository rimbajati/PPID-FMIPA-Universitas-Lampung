@extends('components.layouts.admin')

@section('title', 'Profil - PPID Pelaksana FMIPA Universitas Lampung')
@section('header_title', 'Kelola Profil PPID')

@section('content')
<div class="space-y-6 w-full pb-10" x-data="{ tab: 'tentang' }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-[1.7rem] font-black text-slate-900 tracking-tight">Kelola Profil PPID</h1>
            <p class="text-sm text-slate-500 font-medium mt-1 leading-relaxed">Atur profil struktur PPID pelaksana dan seluruh teks konten di halaman Profil PPID masyarakat.</p>
        </div>
        <a href="{{ route('profil.ppid') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-secondary/30 bg-secondary-light hover:bg-secondary-light text-primary text-xs font-bold transition">
            <i class="mdi mdi-open-in-new"></i> Lihat Halaman Profil
        </a>
    </div>

    <!-- Nav Tab Sesuai Urutan Baru -->
    <div class="flex gap-2 border-b border-slate-200 pb-2">
        <button type="button" @click="tab = 'tentang'"
                :class="tab === 'tentang' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer">
            <i class="mdi mdi-information-outline mr-1.5"></i> Tentang PPID
        </button>
        <button type="button" @click="tab = 'visimisi'"
                :class="tab === 'visimisi' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer">
            <i class="mdi mdi-target mr-1.5"></i> Visi & Misi
        </button>
        <button type="button" @click="tab = 'struktur'"
                :class="tab === 'struktur' ? 'bg-primary text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                class="px-4 py-2 rounded-xl text-xs sm:text-sm font-bold transition cursor-pointer">
            <i class="mdi mdi-sitemap-outline mr-1.5"></i> Struktur Organisasi
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


            <!-- BAGAN HIERARKI STRUKTUR ORGANISASI (PORTAL PUBLIK) -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">Bagan Struktur Organisasi (Portal Publik)</h3>
                </div>

                <!-- Pimpinan: Kepala PPID & Wakil Kepala PPID (Atas Bawah) -->
                <div class="space-y-5">
                    <!-- Kepala PPID -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-primary text-white space-y-4">
                        <h4 class="text-sm font-black tracking-wide text-secondary border-b border-white/10 pb-2">Kepala PPID</h4>
                        
                        <div class="space-y-4">
                            <!-- 1 Baris: Gelar Depan, Nama Lengkap, Gelar Belakang -->
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                                <div class="md:col-span-3 space-y-1">
                                    <label class="block text-xs font-bold text-secondary">Gelar Depan</label>
                                    <input type="text" name="gelar_depan" value="{{ old('gelar_depan', $profil['gelar_depan'] ?? 'Dr. Eng.') }}" placeholder="Contoh: Dr. Eng." class="w-full px-3 py-2.5 rounded-xl border-0 text-sm font-bold text-slate-900 bg-white focus:ring-2 focus:ring-secondary">
                                </div>

                                <div class="md:col-span-6 space-y-1">
                                    <label class="block text-xs font-bold text-secondary">Nama Lengkap <span class="text-rose-400">*</span></label>
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profil['nama_lengkap'] ?? ($profil['nama'] ?? 'Heri Satria')) }}" placeholder="Nama Lengkap" class="w-full px-3 py-2.5 rounded-xl border-0 text-sm font-bold text-slate-900 bg-white focus:ring-2 focus:ring-secondary">
                                </div>

                                <div class="md:col-span-3 space-y-1">
                                    <label class="block text-xs font-bold text-secondary">Gelar Belakang</label>
                                    <input type="text" name="gelar_belakang" value="{{ old('gelar_belakang', $profil['gelar_belakang'] ?? 'S.Si., M.Si.') }}" placeholder="Contoh: S.Si., M.Si." class="w-full px-3 py-2.5 rounded-xl border-0 text-sm font-bold text-slate-900 bg-white focus:ring-2 focus:ring-secondary">
                                </div>
                            </div>

                            <!-- Baris Jabatan -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-secondary">Jabatan</label>
                                <input type="text" name="struktur_atasan_jabatan" value="{{ old('struktur_atasan_jabatan', $halaman['struktur_atasan']['jabatan'] ?? 'Dekan') }}" placeholder="Contoh: Dekan" class="w-full px-3 py-2.5 rounded-xl border-0 text-sm font-bold text-slate-900 bg-white focus:ring-2 focus:ring-secondary">
                            </div>
                        </div>
                    </div>

                    <!-- Wakil Kepala PPID -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-white border-2 border-secondary/30 space-y-4">
                        <h4 class="text-sm font-black tracking-wide text-primary border-b border-slate-100 pb-2">Wakil Kepala</h4>
                        
                        <div class="space-y-4">
                            <!-- 1 Baris: Gelar Depan, Nama Lengkap, Gelar Belakang -->
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                                <div class="md:col-span-3 space-y-1">
                                    <label class="block text-xs font-bold text-slate-600">Gelar Depan</label>
                                    <input type="text" name="wakil_gelar_depan" value="{{ old('wakil_gelar_depan', $profil['wakil_gelar_depan'] ?? 'Dr.') }}" placeholder="Contoh: Dr." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                                </div>

                                <div class="md:col-span-6 space-y-1">
                                    <label class="block text-xs font-bold text-slate-600">Nama Lengkap</label>
                                    <input type="text" name="wakil_nama_lengkap" value="{{ old('wakil_nama_lengkap', $profil['wakil_nama_lengkap'] ?? ($profil['wakil_nama'] ?? 'Aristoteles')) }}" placeholder="Nama Lengkap" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                                </div>

                                <div class="md:col-span-3 space-y-1">
                                    <label class="block text-xs font-bold text-slate-600">Gelar Belakang</label>
                                    <input type="text" name="wakil_gelar_belakang" value="{{ old('wakil_gelar_belakang', $profil['wakil_gelar_belakang'] ?? 'S.Si., M.Si.') }}" placeholder="Contoh: S.Si., M.Si." class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                                </div>
                            </div>

                            <!-- Baris Jabatan -->
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-600">Jabatan</label>
                                <input type="text" name="struktur_ketua_jabatan" value="{{ old('struktur_ketua_jabatan', $halaman['struktur_ketua']['jabatan'] ?? 'Wakil Dekan Bidang Umum dan Keuangan') }}" placeholder="Contoh: Wakil Dekan Bidang Umum dan Keuangan" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Koordinator Bidang (Dinamis: Bisa Tambah & Hapus) -->
                @php
                    $bidangList = old('struktur_bidang_nama') !== null
                        ? array_map(function($n, $j) { return ['nama' => $n, 'jabatan' => $j]; }, old('struktur_bidang_nama', []), old('struktur_bidang_jabatan', []))
                        : array_map(function($b) {
                            return [
                                'nama'    => $b['nama'] ?? ($b['jabatan'] ?? ''),
                                'jabatan' => $b['jabatan'] ?? ($b['peran'] ?? '')
                            ];
                        }, ($halaman['struktur_bidang'] ?? [
                            ['nama' => 'Nama Koordinator', 'jabatan' => 'Layanan Informasi'],
                            ['nama' => 'Nama Koordinator', 'jabatan' => 'Dokumentasi & Arsip'],
                            ['nama' => 'Nama Koordinator', 'jabatan' => 'Sengketa & Keberatan'],
                            ['nama' => 'Nama Koordinator', 'jabatan' => 'TI & Publikasi'],
                        ]));
                @endphp
                <div class="space-y-4 pt-3 border-t border-slate-100" 
                     x-data="{ 
                         items: {{ json_encode($bidangList) }},
                         addItem() {
                             this.items.push({ nama: '', jabatan: '' });
                         },
                         removeItem(index) {
                             if (this.items.length > 1) {
                                 this.items.splice(index, 1);
                             } else {
                                 alert('Minimal harus ada 1 bidang koordinator.');
                             }
                         }
                     }">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <label class="block text-sm font-bold text-slate-800">Koordinator Bidang</label>
                            <span class="text-xs text-slate-400">Atas untuk Nama Lengkap Pejabat, bawah untuk Jabatan / Peran. Inisial lingkaran otomatis dibuat dari nama lengkap.</span>
                        </div>
                        <button type="button" @click="addItem()" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-primary text-white hover:bg-primary-light text-xs font-bold transition shadow-xs self-start sm:self-auto cursor-pointer">
                            <i class="mdi mdi-plus-circle-outline text-sm"></i> Tambah Bidang
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/70 space-y-2.5 hover:border-secondary/40 transition relative group">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-black text-primary uppercase" x-text="'Kartu ' + (index + 1)"></span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[10px] px-2 py-0.5 rounded bg-slate-200 text-slate-600 font-bold">Koordinator</span>
                                        <button type="button" @click="removeItem(index)" 
                                                title="Hapus bidang ini"
                                                class="w-6 h-6 rounded-md bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition flex items-center justify-center text-xs cursor-pointer">
                                            <i class="mdi mdi-delete-outline"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="space-y-1">
                                        <label class="block text-xs font-bold text-slate-700">Nama</label>
                                        <input type="text" name="struktur_bidang_nama[]" x-model="item.nama" placeholder="Contoh: Dr. Nama Pejabat / Nama Lengkap" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-xs font-bold text-slate-600">Jabatan / Peran</label>
                                        <input type="text" name="struktur_bidang_jabatan[]" x-model="item.jabatan" placeholder="Contoh: Koordinator Layanan Informasi" required class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-xs text-slate-700 focus:ring-2 focus:ring-primary/20">
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

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
        </div>

        <!-- TAB TENTANG PPID -->
        <div x-show="tab === 'tentang'" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-5">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3">Tentang Kami</h3>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Judul <span class="text-rose-500">*</span></label>
                    <input type="text" name="tentang_judul" required
                           value="{{ old('tentang_judul', $halaman['tentang_judul'] ?? 'Apa itu PPID?') }}"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">
                </div>

                @php
                    $tentangIsi = old('tentang_isi');
                    if ($tentangIsi === null) {
                        $tentangIsi = $halaman['tentang_isi'] ?? trim(($halaman['tentang_p1'] ?? '') . "\n\n" . ($halaman['tentang_p2'] ?? ''));
                    }
                @endphp
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Isi <span class="text-rose-500">*</span></label>
                    <textarea name="tentang_isi" rows="6" required placeholder="Tuliskan uraian tentang PPID. Paragraf akan otomatis terbagi berdasarkan baris baru (enter) yang Anda buat."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition">{{ $tentangIsi }}</textarea>
                    <p class="text-xs text-slate-400">Tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200 font-mono text-[11px] text-slate-600">Enter 2x</kbd> untuk membuat paragraf baru.</p>
                </div>
            </div>
        </div>

        <!-- TAB 3: VISI & MISI -->
        <div x-show="tab === 'visimisi'" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-4">
                <h3 class="text-base font-black text-slate-900 border-b border-slate-100 pb-3">Visi</h3>

                <textarea name="visi" rows="3" required placeholder="Tuliskan pernyataan visi..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-900 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition resize-none">{{ old('visi', $halaman['visi'] ?? '') }}</textarea>
            </div>

            @php
                $misiList = old('misi_judul') !== null
                    ? array_map(function($j, $d) { return ['judul' => $j, 'deskripsi' => $d]; }, old('misi_judul', []), old('misi_deskripsi', []))
                    : ($halaman['misi'] ?? [
                        ['judul' => 'Penyediaan Informasi', 'deskripsi' => 'Menyediakan dan melayani informasi publik secara cepat, tepat, dan akurat.'],
                        ['judul' => 'Transparansi Tata Kelola', 'deskripsi' => 'Mewujudkan keterbukaan tata kelola di lingkungan fakultas secara konsisten.'],
                        ['judul' => 'Infrastruktur Digital', 'deskripsi' => 'Mengembangkan sistem informasi dan dokumentasi yang terintegrasi berbasis teknologi modern.'],
                        ['judul' => 'Peningkatan Kompetensi', 'deskripsi' => 'Meningkatkan kapasitas dan integritas sumber daya manusia pengelola informasi publik.']
                    ]);
            @endphp

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7 space-y-4"
                 x-data="{
                     misiItems: {{ json_encode($misiList) }},
                     addMisi() {
                         this.misiItems.push({ judul: '', deskripsi: '' });
                     },
                     removeMisi(index) {
                         if (this.misiItems.length > 1) {
                             this.misiItems.splice(index, 1);
                         } else {
                             alert('Minimal harus ada 1 butir misi.');
                         }
                     }
                 }">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">Misi</h3>
                    <button type="button" 
                            @click="addMisi()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary text-white text-xs font-bold hover:bg-primary-dark transition cursor-pointer">
                        <i class="mdi mdi-plus"></i> Tambah Misi
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(item, index) in misiItems" :key="index">
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 space-y-2 relative group hover:border-slate-300 transition">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-md bg-primary text-white font-bold text-xs flex items-center justify-center shrink-0" x-text="index + 1"></span>
                                <input type="text" name="misi_judul[]" x-model="item.judul" placeholder="Judul Misi (contoh: Penyediaan Informasi)" required
                                       class="flex-1 px-3 py-2 rounded-lg border border-slate-200 bg-white text-xs font-bold text-slate-900 focus:ring-2 focus:ring-primary/20">
                                <button type="button" 
                                        @click="removeMisi(index)"
                                        title="Hapus misi ini"
                                        class="w-7 h-7 rounded-md bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition flex items-center justify-center text-sm shrink-0 cursor-pointer">
                                    <i class="mdi mdi-delete-outline"></i>
                                </button>
                            </div>
                            <textarea name="misi_deskripsi[]" x-model="item.deskripsi" rows="2" placeholder="Uraian Misi lengkap..." required
                                      class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-white text-xs text-slate-600 focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
                        </div>
                    </template>
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
