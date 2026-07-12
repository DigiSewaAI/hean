<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage; // ✅ Storage Facade थपियो

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
        // ✅ Ensure storage framework directories exist (Windows/Unix compatible)
        $dirs = ['cache', 'sessions', 'views'];
        foreach ($dirs as $dir) {
            $path = storage_path('framework/' . $dir);
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }
    }
}