<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


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
        Gate::define('worker', function($user) {
            return $user->role == 1;
        });
        
        Gate::define('organizer', function($user) {
            return $user->role == 2;
        });
        Gate::define('user', function($user) {
            return $user->role == 0;
        });
    }
}
