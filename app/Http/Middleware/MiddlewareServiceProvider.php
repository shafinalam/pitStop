<?php

namespace App\Http\Middleware;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', HandleInertiaRequests::class);
    }
} 