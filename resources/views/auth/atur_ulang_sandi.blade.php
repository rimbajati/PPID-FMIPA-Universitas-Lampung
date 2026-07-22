@extends('layout.utama')

@section('title', 'Reset Kata Sandi - PPID FMIPA Unila')

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
            <div class="mb-8">
                <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Reset Kata Sandi</h2>
                <p class="text-gray-500 mt-2 text-sm">Masukkan kata sandi baru untuk akun Anda.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5" novalidate autocomplete="off">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-wider mb-1.5">Email Akun</label>
                    <input type="email" value="{{ request()->email }}" disabled
                        class="w-full px-5 py-3.5 border-2 border-gray-300 bg-gray-100 text-gray-600 text-base rounded-3xl cursor-not-allowed font-bold">
                    <input type="hidden" name="email" value="{{ request()->email }}">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Kata Sandi Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" value=""
                            class="w-full px-5 py-3.5 border-2 {{ $errors->has('password') ? 'border-red-700' : 'border-[#1B365D] focus:border-[#1B365D]' }} rounded-3xl outline-none text-base transition"
                            placeholder="Minimal 8 karakter" required>
                        <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-3.5 text-gray-500 hover:text-gray-800 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-700 text-xs mt-2 font-bold flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-exclamation text-xs"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-900 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" value=""
                            class="w-full px-5 py-3.5 border-2 border-[#1B365D] focus:border-[#1B365D] rounded-3xl outline-none text-base transition"
                            placeholder="Ulangi kata sandi baru" required>
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-3.5 text-gray-500 hover:text-gray-800 focus:outline-none cursor-pointer">
                            <i class="fa-solid fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>

                @if ($errors->has('email') && !$errors->has('password'))
                    <div class="mt-4 p-4 text-sm text-red-800 bg-red-50 border-2 border-red-700 rounded-3xl font-bold text-center flex items-center justify-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-red-600 text-base"></i>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                @endif

                <button type="submit" class="w-full bg-[#1B365D] hover:bg-[#1B365D] text-white font-black py-4 transition text-base mt-4 rounded-3xl uppercase tracking-widest cursor-pointer shadow-md">
                    Perbarui Kata Sandi
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
                this.classList.remove('border-red-700', 'border-red-500', 'border-red-600');
                this.classList.add('border-[#1B365D]');
                
                // Cari dan sembunyikan pesan error spesifik di bawah input
                let parent = this.parentElement;
                while (parent && !parent.classList.contains('space-y-5') && parent.tagName !== 'FORM') {
                    const errorMsg = parent.querySelector('.text-red-700, .text-red-600, .text-red-500');
                    if (errorMsg) {
                        errorMsg.style.display = 'none';
                    }
                    parent = parent.parentElement;
                }

                // Sembunyikan juga kotak alert error umum jika ada
                const alertBox = document.querySelector('.bg-red-50');
                if (alertBox) {
                    alertBox.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
