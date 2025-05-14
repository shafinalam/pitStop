<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Override mail configuration settings
        $this->overrideMailConfig();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Override the mail configuration settings to ensure SMTP is used
     */
    protected function overrideMailConfig(): void
    {
        Log::info('MailConfigServiceProvider: Overriding mail configuration');
        
        // Force SMTP configuration
        Config::set('mail.default', 'smtp');
        Config::set('mail.mailers.smtp.transport', 'smtp');
        Config::set('mail.mailers.smtp.host', 'sandbox.smtp.mailtrap.io');
        Config::set('mail.mailers.smtp.port', 2525);
        Config::set('mail.mailers.smtp.encryption', 'tls');
        Config::set('mail.mailers.smtp.username', '84dea8bb07cf55');
        Config::set('mail.mailers.smtp.password', 'd154e964127692');
        Config::set('mail.from.address', 'carservice@example.com');
        Config::set('mail.from.name', 'Car Service Center');
        
        Log::info('MailConfigServiceProvider: Mail configuration set to SMTP');
    }
} 