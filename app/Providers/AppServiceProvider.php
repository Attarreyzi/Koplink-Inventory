<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Registrasi service aplikasi
    public function register(): void
    {
        //
    }

    // Inisialisasi awal aplikasi (paksa HTTPS di server production)
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}

