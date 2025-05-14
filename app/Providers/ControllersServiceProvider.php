<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\AppointmentController;

class ControllersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Explicitly bind the MechanicController
        $this->app->bind('App\Http\Controllers\MechanicController', function ($app) {
            return new MechanicController();
        });

        // Explicitly bind the AppointmentController
        $this->app->bind('App\Http\Controllers\AppointmentController', function ($app) {
            return new AppointmentController();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 