@extends('layout.utama')

@section('title', 'Lengkapi Profil - PPID FMIPA Unila')

@section('content')
<main class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-slate-50">

    <div class="bg-white shadow-xl flex flex-col md:flex-row overflow-hidden w-full rounded-3xl max-w-5xl min-h-[600px]">

        <div class="w-full md:w-1/2 h-72 md:h-auto relative overflow-hidden">
            <img src="{{ asset('images/FMIPA.jpg') }}" alt="Gedung FMIPA Unila" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#1B365D]/85 via-[#1B365D]/45 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-full p-10 md:p-12 text-left">
                <h2 class="text-white text-3xl md:text-4xl font-black leading-tight">
                    Pejabat Pengelola <br> Informasi & Dokumentasi (PPID)
                </h2>
                <div class="w-16 h-1.5 bg-white mt-4 mb-4"></div>
                <p class="text-cyan-100 text-lg font-medium">FMIPA Universitas Lampung</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">

            <div class="text-center mb-8">
                <div class="inline-flex items-center space-x-1 bg-green-50 text-green-800 px-4 py-1.5 border-2 rounded-3xl border-green-700 font-black text-xs mb-4">
                    <i class="fa-solid fa-check-circle mr-1.5"></i> EMAIL TERVERIFIKASI
                </div>
                <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Lengkapi Profil</h2>
                <p class="text-sm text-gray-500">Lengkapi identitas Anda untuk mengaktifkan akun.</p>
            </div>

            <form action="{{ route('register.step3.process', ['email' => $email]) }}" method="POST" class="space-y-5" novalidate autocomplete="off">
                @csrf

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="text" value="{{ $email }}" class="w-full px-5 py-3.5 border-2 border-gray-300 bg-gray-100 text-gray-500 text-base rounded-3xl cursor-not-allowed font-black" disabled>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value=""
                        class="w-full px-5 py-3.5 border-2 {{ $errors->has('nama_lengkap') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} rounded-3xl outline-none text-base transition"
                        placeholder="Masukkan nama lengkap" required autofocus>
                    @error('nama_lengkap') <p class="text-red-700 text-xs mt-1 font-black">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-5 py-3.5 border-2 {{ $errors->has('password') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} rounded-3xl outline-none text-base transition"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-3.5 text-gray-500 hover:text-gray-800">
                            <i class="fa-solid fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-red-700 text-xs mt-1 font-black">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-5 py-3.5 border-2 border-[#1B365D] focus:border-[#1B365D] outline-none rounded-3xl text-base transition"
                        placeholder="Ulangi kata sandi" required>
                </div>

                <button type="submit" class="w-full bg-[#1B365D] hover:bg-[#1B365D] text-white font-black py-4 transition rounded-3xl text-base mt-4 uppercase tracking-widest">
                    Lengkapi Profil
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById(id + '-icon');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('border-red-700', 'border-red-500');
                this.classList.add('border-[#1B365D]');
                const container = this.closest('div');
                if (container) {
                    const errorMsg = container.querySelector('.text-red-700, .text-red-600, .text-red-500');
                    if (errorMsg) {
                        errorMsg.style.display = 'none';
                    }
                }
            });
        });
    });
</script>
@endsection

