@extends('components.layouts.admin')

@section('title', 'Tata Cara - Admin PPID')
@section('header_title', 'Kelola Tata Cara')

@section('content')
<div class="space-y-8 w-full pb-10">

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
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tata Cara Permohonan & Keberatan</h1>
        <p class="text-sm text-slate-500 font-medium mt-1">Kelola langkah-langkah prosedur layanan.</p>
    </div>

    <form action="{{ route('admin.tata_cara.update') }}" method="POST" id="tataCaraForm" class="space-y-8">
        @csrf
        <input type="hidden" name="permohonan_langkah" id="permohonan-langkah-input">
        <input type="hidden" name="keberatan_langkah" id="keberatan-langkah-input">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Permohonan --}}
            <div class="space-y-6">
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Permohonan Informasi</h2>

                <div class="space-y-4" id="permohonan-langkah-list"></div>

                <button type="button" id="btn-show-permohonan" onclick="toggleForm('permohonan')" class="w-full py-2.5 bg-white border border-dashed border-slate-300 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:border-slate-400 hover:text-slate-800 transition inline-flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Tambah Langkah
                </button>

                <div id="form-permohonan" class="hidden bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-plus text-sky-600 text-xs"></i> Tambah Langkah Permohonan
                    </h3>
                    <div class="space-y-3">
                        <input type="text" id="new-permohonan-judul" placeholder="Langkah" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:border-sky-500 outline-none bg-white">
                        <textarea id="new-permohonan-deskripsi" rows="3" placeholder="Penjelasan" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 focus:border-sky-500 outline-none resize-none bg-white leading-relaxed"></textarea>
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" onclick="toggleForm('permohonan')" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">Batal</button>
                            <button type="button" onclick="addNewLangkah('permohonan')" class="px-5 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs transition shadow-sm">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keberatan --}}
            <div class="space-y-6">
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Pengajuan Keberatan</h2>

                <div class="space-y-4" id="keberatan-langkah-list"></div>

                <button type="button" id="btn-show-keberatan" onclick="toggleForm('keberatan')" class="w-full py-2.5 bg-white border border-dashed border-slate-300 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-50 hover:border-slate-400 hover:text-slate-800 transition inline-flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Tambah Langkah
                </button>

                <div id="form-keberatan" class="hidden bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-plus text-sky-600 text-xs"></i> Tambah Langkah Keberatan
                    </h3>
                    <div class="space-y-3">
                        <input type="text" id="new-keberatan-judul" placeholder="Langkah" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:border-sky-500 outline-none bg-white">
                        <textarea id="new-keberatan-deskripsi" rows="3" placeholder="Penjelasan" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 focus:border-sky-500 outline-none resize-none bg-white leading-relaxed"></textarea>
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" onclick="toggleForm('keberatan')" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">Batal</button>
                            <button type="button" onclick="addNewLangkah('keberatan')" class="px-5 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs transition shadow-sm">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-8 py-3.5 bg-sky-600 hover:bg-sky-700 text-white font-black text-sm rounded-xl shadow-sm transition cursor-pointer">
                Simpan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
const permohonanData = @json($data['permohonan_langkah'] ?? []);
const keberatanData = @json($data['keberatan_langkah'] ?? []);

function esc(s){ const d=document.createElement('div'); d.textContent=s??''; return d.innerHTML; }

function toggleForm(type){
    const form = document.getElementById('form-'+type);
    const btn = document.getElementById('btn-show-'+type);
    const isHidden = form.classList.contains('hidden');
    if(isHidden){
        form.classList.remove('hidden');
        btn.classList.add('hidden');
        document.getElementById('new-'+type+'-judul').focus();
    } else {
        form.classList.add('hidden');
        btn.classList.remove('hidden');
        document.getElementById('new-'+type+'-judul').value = '';
        document.getElementById('new-'+type+'-deskripsi').value = '';
    }
}

function renderLangkah(type, steps){
    const wrap = document.getElementById(type+'-langkah-list');
    if(!wrap) return;
    wrap.innerHTML = '';
    steps.forEach((s, i)=>{
        const el = document.createElement('div');
        el.className = 'bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-3';
        el.innerHTML = `
            <div class="flex items-center justify-between gap-3">
                <span class="text-xs font-black text-slate-500 uppercase tracking-wide">Langkah ${i+1}</span>
                <div class="flex items-center gap-1.5 shrink-0">
                    <button type="button" onclick="moveLangkah('${type}',${i},-1)" class="w-7 h-7 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-900 flex items-center justify-center text-[10px] transition" title="Naik"><i class="fa-solid fa-chevron-up"></i></button>
                    <button type="button" onclick="moveLangkah('${type}',${i},1)" class="w-7 h-7 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-900 flex items-center justify-center text-[10px] transition" title="Turun"><i class="fa-solid fa-chevron-down"></i></button>
                    <button type="button" onclick="removeLangkah('${type}',${i})" class="w-7 h-7 rounded-lg bg-rose-50 border border-rose-200 text-rose-600 hover:bg-rose-100 flex items-center justify-center text-[10px] transition" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                </div>
            </div>
            <input type="text" value="${esc(s.judul)}" oninput="updateLangkah('${type}',${i},'judul',this.value)" placeholder="Langkah" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:border-sky-500 outline-none bg-white">
            <textarea rows="3" oninput="updateLangkah('${type}',${i},'deskripsi',this.value)" placeholder="Penjelasan" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 focus:border-sky-500 outline-none resize-none bg-white leading-relaxed">${esc(s.deskripsi)}</textarea>
        `;
        wrap.appendChild(el);
    });
}

function syncHidden(){
    document.getElementById('permohonan-langkah-input').value = JSON.stringify(permohonanData);
    document.getElementById('keberatan-langkah-input').value = JSON.stringify(keberatanData);
}

function updateLangkah(type, i, field, val){
    const arr = type==='permohonan' ? permohonanData : keberatanData;
    arr[i][field] = val;
    syncHidden();
}

function addNewLangkah(type){
    const jInput = document.getElementById('new-'+type+'-judul');
    const dInput = document.getElementById('new-'+type+'-deskripsi');
    const judul = jInput.value.trim();
    const deskripsi = dInput.value.trim();
    if(!judul || !deskripsi){
        alert('Langkah dan Penjelasan wajib diisi!');
        return;
    }
    const arr = type==='permohonan' ? permohonanData : keberatanData;
    arr.push({judul, deskripsi});
    jInput.value = '';
    dInput.value = '';
    // tutup form, tampilkan tombol tambah lagi
    toggleForm(type);
    renderLangkah(type, arr);
    syncHidden();
}

function removeLangkah(type, i){
    if(!confirm('Hapus langkah ini?')) return;
    const arr = type==='permohonan' ? permohonanData : keberatanData;
    arr.splice(i, 1);
    renderLangkah(type, arr);
    syncHidden();
}

function moveLangkah(type, i, dir){
    const arr = type==='permohonan' ? permohonanData : keberatanData;
    const j = i + dir;
    if(j < 0 || j >= arr.length) return;
    const t = arr[i];
    arr[i] = arr[j];
    arr[j] = t;
    renderLangkah(type, arr);
    syncHidden();
}

renderLangkah('permohonan', permohonanData);
renderLangkah('keberatan', keberatanData);
syncHidden();

document.getElementById('tataCaraForm').addEventListener('submit', function(){ syncHidden(); });
</script>
@endpush
@endsection
