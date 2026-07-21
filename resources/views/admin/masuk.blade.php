<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PPID FMIPA Unila</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Mengimpor font Plus Jakarta Sans & Inter dari Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        /* Menerapkan font Plus Jakarta Sans ke seluruh halaman */
        body { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }

        /* Force 90-degree sharp corners globally across the entire system */
        *, ::before, ::after {
            border-radius: 0px !important;
        }
    </style>
</head>
<body class="relative flex items-center justify-center min-h-screen bg-[#1B365D]">

    <!-- Background Layer -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('{{ asset('images/GedungDekanatFMIPA.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#1B365D]/85 via-[#1B365D]/45 to-transparent"></div>

    <!-- Login Container (Ukuran besar max-w-lg) -->
    <div class="relative z-10 w-full max-w-lg px-6">

        <!-- White Card -->
        <div class="bg-white p-10 sm:p-12 rounded-3xl shadow-2xl border border-gray-100">

            <!-- Header Section -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Login Admin</h1>
                <p class="text-base text-gray-500">PPID FMIPA Universitas Lampung</p>
            </div>

            <form action="/admin-panel/login" method="POST" class="space-y-6">
                <!-- Tambahkan @csrf nanti saat integrasi dengan Controller -->
                @csrf

                <!-- Input Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Email Admin</label>
                    <input type="email" name="email"
                        class="w-full px-5 py-3.5 bg-white border border-gray-300 rounded-2xl text-base text-gray-900 focus:ring-2 focus:ring-[#1B365D] focus:border-[#1B365D] transition-all outline-none"
                        placeholder="Masukkan email admin" required>
                </div>

                <!-- Input Password -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full pl-5 pr-14 py-3.5 bg-white border border-gray-300 rounded-2xl text-base text-gray-900 focus:ring-2 focus:ring-[#1B365D] focus:border-[#1B365D] transition-all outline-none"
                            placeholder="••••••••" required>
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-5 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                            <i class="fa-regular fa-eye text-lg" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#1B365D] hover:bg-[#1B365D] text-white font-bold py-4 px-4 rounded-2xl text-lg transition-all shadow-md">
                        Masuk
                    </button>
                </div>
            </form>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-8 text-center">
            <a href="/" class="inline-flex items-center gap-2 text-sm font-medium text-gray-300 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Beranda Publik
            </a>
        </div>

    </div>

    <!-- Script untuk Toggle Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

