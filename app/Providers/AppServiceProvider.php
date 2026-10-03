<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Tambahkan baris ini di atas

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Carbon\Carbon::setLocale('id');
        config(['app.locale' => 'id']);

        // Tambahkan pengaman HTTPS khusus untuk environment production (di VPS)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
