@extends('layout.bilah_sisi')

@section('content')
<div class="max-w-4xl mx-auto">

    @if (session('status'))
        <div id="notifBox" class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-sm flex items-center justify-between animate-in fade-in slide-in-from-top-4 duration-300">
            <div class="flex items-center gap-3">
                <div class="bg-emerald-500 text-white w-6 h-6 rounded-full flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-check text-[10px]"></i>
                </div>
                <p class="text-sm font-semibold text-emerald-800">{{ session('status') }}</p>
            </div>
            <button onclick="document.getElementById('notifBox').style.display='none'" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
    @endif

    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-900">Edit Profile Anda</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui identitas dasar dan keamanan akun Anda.</p>
        </div>

        <form id="profileForm" action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:border-[#1B365D] focus:ring-2 focus:ring-[#1B365D]/20 outline-none transition-all text-sm font-medium">
                    @error('nama_lengkap') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Alamat Email</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-4 py-3 rounded-2xl border border-slate-100 bg-slate-50 text-slate-400 cursor-not-allowed text-sm font-medium">
                </div>
            </div>

            <div class="border-t border-slate-100 pt-6 space-y-6">
                <h3 class="font-bold text-slate-900 text-md flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-[#1B365D]"></i> Keamanan Akun
                </h3>
                
                @if(auth()->user()->password)
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Password Lama</label>
                        <input type="password" name="current_password" placeholder="Masukkan password saat ini" class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:border-[#1B365D] focus:ring-2 focus:ring-[#1B365D]/20 outline-none transition-all text-sm font-medium">
                        @error('current_password') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                    </div>
                @else
                    <div class="p-4 bg-cyan-50/70 border border-cyan-200/50 rounded-2xl text-cyan-900 text-xs flex items-start gap-3">
                        <i class="fa-solid fa-circle-info mt-0.5 text-base text-[#1B365D] shrink-0"></i>
                        <div>
                            <p class="font-bold text-[#1B365D]">Akun Terhubung dengan Google</p>
                            <p class="mt-1 text-cyan-800 leading-relaxed">Anda masuk menggunakan Google Sign-In dan belum menyetel kata sandi manual. Anda dapat mengisi kolom **Password Baru** secara langsung untuk membuat kata sandi baru untuk akun Anda.</p>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Password Baru</label>
                        <input type="password" name="password" placeholder="Masukkan password baru" class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:border-[#1B365D] focus:ring-2 focus:ring-[#1B365D]/20 outline-none transition-all text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wider">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full px-4 py-3 rounded-2xl border border-slate-300 focus:border-[#1B365D] focus:ring-2 focus:ring-[#1B365D]/20 outline-none transition-all text-sm font-medium">
                    </div>
                </div>
                @error('password') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="button" id="btnSubmit" class="bg-[#1B365D] text-white px-8 py-3.5 rounded-2xl font-bold hover:bg-[#1B365D] transition-all shadow-md hover:-translate-y-0.5">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl border border-slate-100 transform transition-all duration-200">
        <div class="flex items-center gap-4 mb-4 text-[#1B365D]">
            <div class="w-12 h-12 rounded-full bg-cyan-50 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-question text-xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Konfirmasi Perubahan</h3>
        </div>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">Apakah Anda yakin ingin menyimpan perubahan profil dan data keamanan ini?</p>
        <div class="flex gap-3">
            <button id="cancelBtn" class="flex-1 px-4 py-3 rounded-2xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all">Batal</button>
            <button id="confirmBtn" class="flex-1 px-4 py-3 rounded-2xl text-sm font-bold text-white bg-[#1B365D] hover:bg-[#1B365D] transition-all shadow-md">Ya, Simpan</button>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('profileForm');
    const modal = document.getElementById('confirmModal');
    const btnSubmit = document.getElementById('btnSubmit');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');

    btnSubmit.addEventListener('click', () => modal.classList.remove('hidden'));
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));
    confirmBtn.addEventListener('click', () => form.submit());
</script>
@endsection
