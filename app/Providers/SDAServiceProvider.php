<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Sda;

class SDAServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // SHARE DATA STATISTIK SDA
        view()->composer('*', function ($view) {
            $view->with('totalSdaGlobal', Sda::count());
        });
    }
}