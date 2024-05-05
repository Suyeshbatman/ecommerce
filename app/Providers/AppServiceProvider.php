<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request;


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
         // Trust all headers set by the proxy (useful for Heroku deployments)
        Request::setTrustedProxies(
            [Request::HEADER_X_FORWARDED_FOR, Request::HEADER_X_FORWARDED_HOST, Request::HEADER_X_FORWARDED_PROTO, Request::HEADER_X_FORWARDED_PORT],
            Request::HEADER_X_FORWARDED_ALL
        );
    }
}
