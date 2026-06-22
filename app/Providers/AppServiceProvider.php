<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa Laravel menggunakan APP_URL dari .env untuk semua link
        if (config('app.url')) {
            URL::forceRootUrl(config('app.url'));
        }
    }
}