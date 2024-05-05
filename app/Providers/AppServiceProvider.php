<?php

namespace App\Providers;

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
    public function boot()
    {
        Request::setTrustedProxies(
            [Request::HEADER_X_FORWARDED_ALL],
            Request::HEADER_X_FORWARDED_ALL
        );
    }
}
