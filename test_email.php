<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Illuminate\Support\Facades\Mail::raw('Test email dari PPID FMIPA Unila. Sistem email berfungsi dengan baik!', function($m) {
        $m->to('rimbajati54@gmail.com')->subject('[Test] PPID FMIPA Unila - SMTP Gmail');
    });
    echo "✅ Email berhasil dikirim ke rimbajati54@gmail.com\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
