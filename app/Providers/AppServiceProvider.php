<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AmeliaCategory; // Pastikan modelnya sesuai dengan nama kamu

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Membagikan semua kategori ke seluruh view
        View::share('navbarCategories', AmeliaCategory::all());
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
