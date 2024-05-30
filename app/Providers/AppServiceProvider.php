<?php

namespace App\Providers;

use App\Models\Pengguna;
use App\Models\User;
use App\Observers\PenggunaObserver;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFour();
        Pengguna::observe(PenggunaObserver::class);
        User::observe(UserObserver::class);
    }
}
