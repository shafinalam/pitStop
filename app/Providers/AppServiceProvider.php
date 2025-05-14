<?php

namespace App\Providers;

use App\Http\Middleware\MiddlewareServiceProvider;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(MailConfigServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
