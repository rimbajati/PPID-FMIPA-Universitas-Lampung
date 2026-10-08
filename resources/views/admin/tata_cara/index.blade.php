@extends('components.layouts.admin')

@section('title', 'Tata Cara - Admin PPID')
@section('header_title', 'Kelola Tata Cara')

@section('content')
<div class="space-y-6 w-full pb-10">

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-bold shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-sm space-y-1.5 shadow-sm">
            <div class="font-black flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-rose-600"></i><span>Terjadi kesalahan:</span></div>
            <ul class="list-disc list-inside font-medium space-y-0.5 pl-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div>
        <h1 class="text-2xl sm:text-[1.7rem] font-black text-slate-900 tracking-tight">Tata Cara Permohonan & Keberatan</h1>
        <p class="text-sm text-slate-500 font-medium mt-1.5 leading-relaxed">Kelola seluruh konten halaman <span class="font-bold text-slate-700">/tata-cara-permohonan-dan-keberatan</span> — header, 2 kartu prosedur, SLA & biaya, serta daftar SOP/dokumen. Perubahan langsung tampil di halaman masyarakat.</p>
    </div>

    <form action="{{ route('admin.tata_cara.update') }}" method="POST" id="tataCaraForm" class="space-y-6">
        @csrf
        <input type="hidden" name="permohonan_langkah" id="permohonan-langkah-input">
        <input type="hidden" name="keberatan_langkah" id="keberatan-langkah-input">
        <input type="hidden" name="dokumen" id="dokumen-input">

        {{-- Header / Hero --}}
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 sm:px-7 pt-6 pb-4 border-b border-slate-100 flex items-center gap-3">
                <span class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-sm border border-sky-100"><i class="fa-solid fa-window-maximize"></i></span>
                <div><h2 class="text-base font-extrabold text-slate-900">Header / Hero Banner</h2><p class="text-xs font-medium text-slate-400 mt-0.5">Judul besar & deskripsi di banner gradasi biru</p></div>
            </div>
            <div class="px-6 sm:px-7 py-6 grid grid-cols-1 gap-5">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Judul Header <span class="text-rose-500">*</span></label>
                    <input type="text" name="header_judul" required value="{{ old('header_judul', $data['header_judul']) }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-bold text-slate-900 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-800">Deskripsi Header <span class="text-rose-500">*</span></label>
                    <textarea name="header_deskripsi" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-[15px] font-medium text-slate-700 focus:ring-4 focus:ring-sky-500/10 focus:border-sky-500 outline-none transition resize-none leading-relaxed">{{ old('header_deskripsi', $data['header_deskripsi']) }}</textarea>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Kartu Permohonan --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2"><span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs border border-blue-100"><i class="fa-solid fa-file-signature"></i></span> Kartu Permohonan</h2>
                    <p class="text-xs font-medium text-slate-400 mt-1">Kartu biru — sebelah kiri di halaman</p>
                </div>
                <div class="px-6 py-6 space-y-4 flex-1">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Badge</label><input type="text" name="permohonan_badge" value="{{ $data['permohonan_badge'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-sky-500 outline-none"></div>
                        <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Label SLA</label><input type="text" name="permohonan_sla" value="{{ $data['permohonan_sla'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-sky-500 outline-none"></div>
                    </div>
                    <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Judul Kartu *</label><input type="text" name="permohonan_judul" required value="{{ $data['permohonan_judul'] }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-[15px] font-extrabold text-slate-900 focus:border-sky-500 outline-none"></div>
                    <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Deskripsi Kartu</label><textarea name="permohonan_deskripsi" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 focus:border-sky-500 outline-none resize-none">{{ $data['permohonan_deskripsi'] }}</textarea></div>
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between"><label class="text-sm font-extrabold text-slate-800">Langkah-langkah Permohonan</label><button type="button" onclick="addLangkah('permohonan')" class="px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-xs border border-blue-200 transition inline-flex items-center gap-1.5"><i class="fa-solid fa-plus"></i> Tambah</button></div>
                        <div id="permohonan-langkah-list" class="space-y-3"></div>
                        <p class="text-xs font-medium text-slate-400">Urutan angka mengikuti urutan list. Minimal 1, tidak ada batas.</p>
                    </div>
                </div>
            </div>

            {{-- Kartu Keberatan --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                    <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2"><span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs border border-amber-100"><i class="fa-solid fa-scale-balanced"></i></span> Kartu Keberatan</h2>
                    <p class="text-xs font-medium text-slate-400 mt-1">Kartu amber — sebelah kanan di halaman</p>
                </div>
                <div class="px-6 py-6 space-y-4 flex-1">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Badge</label><input type="text" name="keberatan_badge" value="{{ $data['keberatan_badge'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-sky-500 outline-none"></div>
                        <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Label SLA</label><input type="text" name="keberatan_sla" value="{{ $data['keberatan_sla'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-sky-500 outline-none"></div>
                    </div>
                    <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Judul Kartu *</label><input type="text" name="keberatan_judul" required value="{{ $data['keberatan_judul'] }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-[15px] font-extrabold text-slate-900 focus:border-sky-500 outline-none"></div>
                    <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Deskripsi Kartu</label><textarea name="keberatan_deskripsi" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 focus:border-sky-500 outline-none resize-none">{{ $data['keberatan_deskripsi'] }}</textarea></div>
                    <div class="space-y-2 pt-2 border-t border-slate-100">
                        <div class="flex items-center justify-between"><label class="text-sm font-extrabold text-slate-800">Langkah-langkah Keberatan</label><button type="button" onclick="addLangkah('keberatan')" class="px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold text-xs border border-amber-200 transition inline-flex items-center gap-1.5"><i class="fa-solid fa-plus"></i> Tambah</button></div>
                        <div id="keberatan-langkah-list" class="space-y-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- SLA & Biaya --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                    <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2"><span class="w-7 h-7 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-xs"><i class="fa-regular fa-clock"></i></span> SLA & Biaya</h2>
                </div>
                <div class="px-6 py-6 space-y-5">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-800">Judul SLA</label>
                        <input type="text" name="sla_judul" value="{{ $data['sla_judul'] }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:border-sky-500 outline-none">
                        <textarea name="sla_items_text" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 focus:border-sky-500 outline-none resize-none leading-relaxed" placeholder="Satu item per baris">{{ implode("\n", $data['sla_items'] ?? []) }}</textarea>
                        <p class="text-xs font-medium text-slate-400">Satu baris = satu bullet di halaman.</p>
                    </div>
                    <div class="space-y-2 pt-4 border-t border-slate-100">
                        <label class="text-sm font-bold text-slate-800">Judul Biaya</label>
                        <input type="text" name="biaya_judul" value="{{ $data['biaya_judul'] }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:border-sky-500 outline-none">
                        <textarea name="biaya_items_text" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 focus:border-sky-500 outline-none resize-none leading-relaxed" placeholder="Satu item per baris">{{ implode("\n", $data['biaya_items'] ?? []) }}</textarea>
                        <div class="grid grid-cols-1 gap-3 pt-2">
                            <input type="text" name="biaya_link_text" value="{{ $data['biaya_link_text'] }}" placeholder="Teks tautan biaya" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-sky-700 focus:border-sky-500 outline-none">
                            <input type="url" name="biaya_link_url" value="{{ $data['biaya_link_url'] }}" placeholder="https://..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 focus:border-sky-500 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dokumen Standar --}}
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                    <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2"><span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-xs"><i class="fa-solid fa-file-pdf"></i></span> Dokumen Standar</h2>
                    <p class="text-xs font-medium text-slate-400 mt-1">Kartu grid di bawah SLA/Biaya</p>
                </div>
                <div class="px-6 py-6 space-y-4 flex-1">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Badge</label><input type="text" name="dokumen_badge" value="{{ $data['dokumen_badge'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-sky-500 outline-none"></div>
                        <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Tautan Indeks Label</label><input type="text" name="dokumen_link_text" value="{{ $data['dokumen_link_text'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm font-bold text-slate-800 focus:border-sky-500 outline-none"></div>
                    </div>
                    <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">Judul Section</label><input type="text" name="dokumen_judul" value="{{ $data['dokumen_judul'] }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-extrabold text-slate-900 focus:border-sky-500 outline-none"></div>
                    <div class="space-y-1.5"><label class="text-xs font-bold text-slate-600">URL Indeks</label><input type="url" name="dokumen_link_url" value="{{ $data['dokumen_link_url'] }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 focus:border-sky-500 outline-none"></div>
                    <div class="space-y-2 pt-3 border-t border-slate-100">
                        <div class="flex items-center justify-between"><label class="text-sm font-extrabold text-slate-800">Daftar Dokumen / Kartu</label><button type="button" onclick="addDokumen()" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition inline-flex items-center gap-1.5"><i class="fa-solid fa-plus"></i> Tambah</button></div>
                        <div id="dokumen-list" class="space-y-3"></div>
                        <p class="text-xs font-medium text-slate-400">Judul + deskripsi singkat + URL — tampil sebagai 3 kolom grid.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ url('/admin/tata-cara-admin') }}" class="px-5 py-2.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-sm hover:bg-slate-50 transition">Batal</a>
            <button type="submit" class="px-7 py-3 bg-sky-600 hover:bg-sky-700 text-white font-extrabold text-sm rounded-xl shadow-md shadow-sky-600/20 transition inline-flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Tata Cara
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
const permohonanData = @json($data['permohonan_langkah'] ?? []);
const keberatanData = @json($data['keberatan_langkah'] ?? []);
const dokumenData = @json($data['dokumen'] ?? []);

function esc(s){ const d=document.createElement('div'); d.textContent=s??''; return d.innerHTML; }

function renderLangkah(type, steps){
    const id = type==='permohonan' ? 'permohonan-langkah-list' : 'keberatan-langkah-list';
    const wrap = document.getElementById(id);
    const color = type==='permohonan' ? 'blue' : 'amber';
    wrap.innerHTML = '';
    steps.forEach((s, i)=>{
        const el = document.createElement('div');
        el.className = 'p-3.5 rounded-xl border border-slate-200 bg-slate-50/70 space-y-2.5';
        el.innerHTML = `
            <div class="flex items-center justify-between gap-2">
                <span class="w-7 h-7 rounded-lg bg-${color}-600 text-white font-black text-xs flex items-center justify-center shrink-0">${i+1}</span>
                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="moveLangkah('${type}',${i},-1)" class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center text-xs" title="Naik"><i class="fa-solid fa-chevron-up"></i></button>
                    <button type="button" onclick="moveLangkah('${type}',${i},1)" class="w-7 h-7 rounded-lg bg-white border border-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center text-xs" title="Turun"><i class="fa-solid fa-chevron-down"></i></button>
                    <button type="button" onclick="removeLangkah('${type}',${i})" class="w-7 h-7 rounded-lg bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 flex items-center justify-center text-xs" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>
            <input type="text" value="${esc(s.judul)}" placeholder="Judul langkah" oninput="updateLangkah('${type}',${i},'judul',this.value)" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-900 focus:border-sky-500 outline-none">
            <textarea rows="2" placeholder="Deskripsi langkah" oninput="updateLangkah('${type}',${i},'deskripsi',this.value)" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-600 focus:border-sky-500 outline-none resize-none leading-relaxed">${esc(s.deskripsi)}</textarea>
        `;
        wrap.appendChild(el);
    });
}
function renderDokumen(){
    const wrap = document.getElementById('dokumen-list');
    wrap.innerHTML = '';
    dokumenData.forEach((d,i)=>{
        const el = document.createElement('div');
        el.className = 'p-3.5 rounded-xl border border-slate-200 bg-slate-50/60 space-y-2';
        el.innerHTML = `
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-black text-slate-500">#${i+1}</span>
                <button type="button" onclick="removeDokumen(${i})" class="w-7 h-7 rounded-lg bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center text-xs"><i class="fa-solid fa-trash-can"></i></button>
            </div>
            <input type="text" value="${esc(d.judul)}" placeholder="Judul dokumen" oninput="updateDokumen(${i},'judul',this.value)" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-900 focus:border-sky-500 outline-none">
            <input type="text" value="${esc(d.deskripsi)}" placeholder="Deskripsi singkat" oninput="updateDokumen(${i},'deskripsi',this.value)" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-600 focus:border-sky-500 outline-none">
            <input type="url" value="${esc(d.url)}" placeholder="https://..." oninput="updateDokumen(${i},'url',this.value)" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white text-sm font-medium text-sky-700 focus:border-sky-500 outline-none">
        `;
        wrap.appendChild(el);
    });
}
function updateLangkah(type,i,field,val){ const arr = type==='permohonan'?permohonanData:keberatanData; arr[i][field]=val; }
function addLangkah(type){ const arr=type==='permohonan'?permohonanData:keberatanData; arr.push({judul:'',deskripsi:''}); renderLangkah(type,arr); }
function removeLangkah(type,i){ const arr=type==='permohonan'?permohonanData:keberatanData; arr.splice(i,1); renderLangkah(type,arr); }
function moveLangkah(type,i,dir){ const arr=type==='permohonan'?permohonanData:keberatanData; const j=i+dir; if(j<0||j>=arr.length) return; const t=arr[i]; arr[i]=arr[j]; arr[j]=t; renderLangkah(type,arr); }
function updateDokumen(i,field,val){ dokumenData[i][field]=val; }
function addDokumen(){ dokumenData.push({judul:'',deskripsi:'',url:''}); renderDokumen(); }
function removeDokumen(i){ dokumenData.splice(i,1); renderDokumen(); }

renderLangkah('permohonan', permohonanData);
renderLangkah('keberatan', keberatanData);
renderDokumen();

document.getElementById('tataCaraForm').addEventListener('submit', function(){
    document.getElementById('permohonan-langkah-input').value = JSON.stringify(permohonanData);
    document.getElementById('keberatan-langkah-input').value = JSON.stringify(keberatanData);
    document.getElementById('dokumen-input').value = JSON.stringify(dokumenData);
});
</script>
@endpush
@endsection
