<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - PPID FMIPA Unila</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Portal Admin PPID</h1>
            <p class="text-sm text-gray-500 mt-2">Masuk menggunakan kredensial pengelola</p>
        </div>

        <form action="/admin-panel/login" method="POST">
            <!-- Tambahkan @csrf nanti saat integrasi dengan Controller -->
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Staf</label>
                <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-blue-900" placeholder="admin@fmipa.unila.ac.id" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi</label>
                <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-blue-900" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-[#0f2b4a] text-white font-bold py-3 px-4 rounded-lg hover:bg-[#0a1d33] transition duration-200">
                Otorisasi Masuk
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-500 hover:text-[#0f2b4a] transition">&larr; Kembali ke Beranda Publik</a>
        </div>
    </div>

</body>
</html>
