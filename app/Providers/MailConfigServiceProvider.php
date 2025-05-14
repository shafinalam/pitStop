<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services - this runs when the application is starting up
     */
    public function register(): void
    {
        // Set up our email configuration
        $this->setupMailConfig();
    }

    /**
     * Bootstrap services - runs after registration
     */
    public function boot(): void
    {
        // Empty - we don't need anything here
    }

    /**
     * Set up the email configuration to use Mailtrap for testing
     * Mailtrap is a test inbox service that catches all emails without sending to real users
     */
    protected function setupMailConfig(): void
    {
        // Configure all email settings with simple values
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.transport', 'smtp');
        Config::set('mail.mailers.smtp.host', 'sandbox.smtp.mailtrap.io');
        Config::set('mail.mailers.smtp.port', 2525);
        Config::set('mail.mailers.smtp.encryption', 'tls');
        Config::set('mail.mailers.smtp.username', '84dea8bb07cf55');
        Config::set('mail.mailers.smtp.password', 'd154e964127692');
        Config::set('mail.from.address', 'carservice@example.com');
        Config::set('mail.from.name', 'Car Service Center');
    }
} 