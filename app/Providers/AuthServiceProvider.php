<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // ROLE CHECK
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('petugas', function ($user) {
            return $user->role === 'petugas';
        });

        Gate::define('masyarakat', function ($user) {
            return $user->role === 'masyarakat';
        });
    }
}