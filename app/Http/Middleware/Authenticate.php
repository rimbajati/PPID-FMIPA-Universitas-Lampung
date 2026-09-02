<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Jika mencoba mengakses area admin (AFK / sesi habis), alihkan ke Halaman Login Admin
        if ($request->is('admin*') || $request->is('admin-panel*')) {
            return route('admin.login');
        }

        // Jika masyarakat belum login dan mengakses layanan berproteksi, alihkan ke Halaman Login Masyarakat
        return route('login');
    }
}
