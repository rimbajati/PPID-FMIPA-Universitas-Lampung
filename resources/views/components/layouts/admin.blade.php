<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/logoPPID.png') }}?v=2.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logoPPID.png') }}?v=2.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logoPPID.png') }}?v=2.0">
    <link rel="apple-touch-icon" href="{{ asset('images/logoPPID.png') }}?v=2.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

    <style>
        html { font-size: 16px; scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important; font-size: 0.975rem; }
        /* Scrollbar kustom untuk sidebar agar lebih rapi */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Alpine.js Cloak Directive */
        [x-cloak] { display: none !important; }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    },
                    borderRadius: {
                        'DEFAULT': '0.625rem',
                        'sm': '0.375rem',
                        'md': '0.5rem',
                        'lg': '0.625rem',
                        'xl': '0.625rem',
                        '2xl': '0.625rem',
                        '3xl': '0.625rem',
                        'full': '9999px',
                    }
                }
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#f1f5f9] text-slate-800 antialiased overflow-hidden flex flex-col h-screen relative">

    <!-- 1. Header Topbar Biru Muda Sistem (bg-sky-600) -->
    <header class="bg-sky-600 h-[64px] flex items-center justify-between px-6 text-white shadow-md w-full flex-shrink-0">
        <!-- Sisi Kiri: Logo PPID FMIPA + Tombol Hamburger Berjarak Lega -->
        <div class="flex items-center gap-6 md:gap-8">
            <a href="/" class="flex items-center shrink-0 gap-3 group">
                <div class="text-left leading-snug">
                    <span class="block text-white font-extrabold text-base tracking-tight">PPID FMIPA</span>
                    <span class="block text-white/80 font-bold text-[10px] tracking-wider uppercase">Universitas Lampung</span>
                </div>
            </a>

            <!-- Tombol Hamburger (Berjarak Rapi & Fit Dengan Batas Sidebar) -->
            <button onclick="toggleSidebar()" type="button" class="ml-2 md:ml-4 p-1.5 text-white/90 hover:text-white text-xl transition-all cursor-pointer focus:outline-none" title="Tampilkan/Sembunyikan Menu Sidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <!-- Sisi Kanan: Teks Tanggal Clean Tanpa Icon & Border -->
        <div class="flex items-center">
            <div class="text-right">
                <span class="text-xs md:text-sm font-black text-white/90 uppercase tracking-wider">
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>
    </header>

    <!-- 2. Container Bawah Header (Sidebar Navigasi Menu + Main Content) -->
    <div class="flex flex-1 min-h-0 w-full relative">

        <!-- Sidebar Container Navigasi Admin -->
        <x-ui.sidebar-admin />

        <!-- Main Content (Warna latar Slate-100 #f1f5f9 Soft & Terang) -->
        <div class="flex-1 flex flex-col min-w-0 bg-[#f1f5f9] relative">
            <!-- Area Konten Utama -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8 w-full bg-[#f1f5f9]">
                <!-- Toast Popup Notification (Hilang Otomatis 3.5 Detik) -->
                @if(session('success'))
                    <div id="toast-success" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 bg-emerald-600 text-white rounded-xl shadow-2xl transition-all duration-500 transform translate-y-0 opacity-100 border border-emerald-500">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                        <span class="text-sm font-bold tracking-wide">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div id="toast-error" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 bg-red-600 text-white rounded-xl shadow-2xl transition-all duration-500 transform translate-y-0 opacity-100 border border-red-500">
                        <i class="fa-solid fa-circle-exclamation text-xl"></i>
                        <span class="text-sm font-bold tracking-wide">{{ session('error') }}</span>
                    </div>
                @endif
                @if($errors->any())
                    <div id="toast-validation-error" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 bg-red-600 text-white rounded-xl shadow-2xl transition-all duration-500 transform translate-y-0 opacity-100 border border-red-500">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                        <span class="text-sm font-bold tracking-wide">{{ $errors->first() }}</span>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <div class="relative z-[99999]">
        @yield('modals')
    </div>

    <form id="globalDeleteForm" action="" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- Global Modal Konfirmasi Hapus -->
    <x-modals.delete />

    <!-- Script Utama Admin Layout (Toggle Sidebar & Toast Notification) -->
    <script>
        // Shared delete modal state (window-scoped agar bisa diakses dari komponen script mana pun)
        window.currentDeleteType = window.currentDeleteType || null;
        window.currentDeleteUrl  = window.currentDeleteUrl  || null;
        window.isSelectMode      = false;

        window.toggleSelectMode = function() {
            window.isSelectMode = !window.isSelectMode;
            const isSelectMode = window.isSelectMode;
            const colHeader = document.getElementById('col-checkbox-header');
            const colCells = document.querySelectorAll('.col-checkbox-cell');
            const toggleBtn = document.getElementById('btn-toggle-select');
            const textSelectMode = document.getElementById('text-select-mode');
            const checkAll = document.getElementById('check-all');

            if (colHeader) colHeader.classList.toggle('hidden', !isSelectMode);
            colCells.forEach(cell => cell.classList.toggle('hidden', !isSelectMode));

            if (toggleBtn && textSelectMode) {
                if (isSelectMode) {
                    toggleBtn.classList.remove('bg-slate-100', 'text-slate-700');
                    toggleBtn.classList.add('bg-rose-50', 'text-rose-600');
                    textSelectMode.innerText = 'Batal';
                } else {
                    toggleBtn.classList.remove('bg-rose-50', 'text-rose-600');
                    toggleBtn.classList.add('bg-slate-100', 'text-slate-700');
                    textSelectMode.innerText = 'Pilih';
                    
                    if (checkAll) checkAll.checked = false;
                    document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = false);
                    window.updateBulkState();
                }
            }
        };

        window.toggleCheckAll = function(master) {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(cb => cb.checked = master.checked);
            window.updateBulkState();
        };

        window.updateBulkState = function() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
            const bulkBtn = document.getElementById('btn-bulk-delete');
            const selectedCount = document.getElementById('selected-count');
            const checkAll = document.getElementById('check-all');
            const totalItems = document.querySelectorAll('.item-checkbox').length;

            if (selectedCount) selectedCount.innerText = checkedCount;

            if (bulkBtn) {
                if (checkedCount > 0 && window.isSelectMode) {
                    bulkBtn.classList.remove('hidden');
                } else {
                    bulkBtn.classList.add('hidden');
                }
            }

            if (checkAll && totalItems > 0) {
                checkAll.checked = (checkedCount === totalItems);
            }
        };

        window.triggerBulkDelete = function() {
            const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
            if (checkedCount === 0) return;
            const confirmText = document.getElementById('deleteConfirmText');
            if (confirmText) {
                confirmText.innerHTML = 'Apakah Anda yakin ingin menghapus <b>' + checkedCount + '</b> data yang dipilih?';
            }
            window.currentDeleteType = 'bulk';
            const modal = document.getElementById('modalConfirmDelete');
            if (modal) modal.classList.remove('hidden');
        };

        window.triggerDelete = function(url, title) {
            const confirmText = document.getElementById('deleteConfirmText');
            if (confirmText) {
                confirmText.innerHTML = 'Apakah Anda yakin ingin menghapus <b>"' + title + '"</b> ini?';
            }
            window.currentDeleteType = 'single';
            window.currentDeleteUrl = url;
            const modal = document.getElementById('modalConfirmDelete');
            if (modal) modal.classList.remove('hidden');
        };

        function closeDeleteModal() {
            const modal = document.getElementById('modalConfirmDelete');
            if (modal) modal.classList.add('hidden');
            window.currentDeleteType = null;
            window.currentDeleteUrl  = null;
        }

        function executeDelete() {
            if (window.currentDeleteType === 'bulk') {
                const bulkForm = document.getElementById('form-bulk-delete');
                if (bulkForm) bulkForm.submit();
            } else if (window.currentDeleteType === 'single' && window.currentDeleteUrl) {
                const singleForm = document.getElementById('globalDeleteForm');
                if (singleForm) {
                    singleForm.action = window.currentDeleteUrl;
                    singleForm.submit();
                }
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (!sidebar) return;

            if (window.innerWidth >= 1024) {
                sidebar.classList.toggle('lg:-ml-[300px]');
            } else {
                sidebar.classList.toggle('-translate-x-full');
            }
        }

        // Auto Hide Toast Notification Popup
        document.addEventListener('DOMContentLoaded', function() {
            ['toast-success', 'toast-error', 'toast-validation-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    setTimeout(() => {
                        el.classList.add('-translate-y-4', 'opacity-0');
                        setTimeout(() => el.remove(), 500);
                    }, 3500);
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
