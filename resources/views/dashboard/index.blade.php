@extends('layouts.sidebar')

@section('content')
<div class="max-w-4xl mx-auto">

    @if (session('status'))
        <div id="notifBox" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-none shadow flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-check text-[10px]"></i>
                </div>
                <p class="text-sm font-bold text-green-800">{{ session('status') }}</p>
            </div>
            <button onclick="document.getElementById('notifBox').style.display='none'" class="text-green-400">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    <div class="bg-white p-8 rounded-none border border-gray-200 shadow-sm">
        <div class="mb-8">
            <h2 class="text-xl font-bold text-[#0a192f]">Edit Profile Anda</h2>
            <p class="text-sm text-gray-500">Perbarui identitas dasar dan keamanan akun Anda.</p>
        </div>

        <form id="profileForm" action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" class="w-full px-4 py-2.5 rounded-none border border-gray-300 focus:ring-2 focus:ring-[#0a192f] outline-none">
                    @error('nama_lengkap') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Alamat Email *</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-4 py-2.5 rounded-none border border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6 space-y-4">
                <h3 class="font-bold text-gray-800 text-sm"><i class="fa-solid fa-lock mr-2"></i> Keamanan Akun</h3>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Password Lama *</label>
                    <input type="password" name="current_password" placeholder="Masukkan password saat ini" class="w-full px-4 py-2.5 rounded-none border border-gray-300 focus:ring-2 focus:ring-[#0a192f] outline-none">
                    @error('current_password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Password Baru</label>
                        <input type="password" name="password" placeholder="Masukkan password baru" class="w-full px-4 py-2.5 rounded-none border border-gray-300 focus:ring-2 focus:ring-[#0a192f] outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full px-4 py-2.5 rounded-none border border-gray-300 focus:ring-2 focus:ring-[#0a192f] outline-none">
                    </div>
                </div>
                @error('password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="button" id="btnSubmit" class="bg-[#0a192f] text-white px-8 py-3 rounded-none font-bold hover:bg-gray-800 transition shadow-sm">
                SIMPAN PERUBAHAN
            </button>
        </form>
    </div>
</div>

<div id="confirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-xl">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Perubahan</h3>
        <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menyimpan perubahan profil dan data keamanan ini?</p>
        <div class="flex gap-3">
            <button id="cancelBtn" class="flex-1 px-4 py-2 rounded-none text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200">Batal</button>
            <button id="confirmBtn" class="flex-1 px-4 py-2 rounded-none text-sm font-bold text-white bg-[#0a192f] hover:bg-gray-800">Ya, Simpan</button>
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
