@echo off
setlocal
echo =======================================================
echo    PPID FMIPA UNILA - SAKLAR KONTROL BRANCH VERSI
echo =======================================================
echo.
echo Pilih versi yang ingin Anda aktifkan:
echo [1] Versi 1 (Branch: v1, Database: ppid_fmipa_unila - Desain awal stabil)
echo [2] Versi 2 (Branch: v2, Database: ppid_fmipa_unila_v2 - Fitur Monev & Export baru)
echo.
set /p opt="Pilihan (1 atau 2): "

if "%opt%"=="1" (
    echo.
    echo Mengaktifkan VERSI 1...
    git checkout v1
    (
        echo APP_NAME=Laravel
        echo APP_ENV=local
        echo APP_KEY=base64:3ruDG24Q97ArKC9P/q6/S7vXugX2Rvhg+cYidTuAjiQ=
        echo APP_DEBUG=true
        echo APP_URL=http://localhost
        echo.
        echo LOG_CHANNEL=stack
        echo LOG_DEPRECATIONS_CHANNEL=null
        echo LOG_LEVEL=debug
        echo.
        echo DB_CONNECTION=mysql
        echo DB_HOST=127.0.0.1
        echo DB_PORT=3306
        echo DB_DATABASE=ppid_fmipa_unila
        echo DB_USERNAME=root
        echo DB_PASSWORD=
    ) > .env
    echo [SUKSES] Sekarang aktif di Versi 1 ^(Branch: v1, Database: ppid_fmipa_unila^)
) else if "%opt%"=="2" (
    echo.
    echo Mengaktifkan VERSI 2...
    git checkout v2
    copy /y .env.iterasi2 .env >nul
    echo [SUKSES] Sekarang aktif di Versi 2 ^(Branch: v2, Database: ppid_fmipa_unila_v2^)
) else (
    echo Pilihan tidak valid.
)
echo.
pause
