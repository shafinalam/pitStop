<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

/**
 * This service provider sets up our email configuration
 * It runs when the application starts and configures the mail system
 */
class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services - this runs when the application is starting up
     */
    public function register(): void
    {
        // Configure the mail settings
        $this->setupMailConfig();
    }

    /**
     * Bootstrap services - runs after registration
     */
    public function boot(): void
    {
        // We don't need anything here
    }

    /**
     * Set up the email configuration to use Mailtrap for testing
     * 
     * IMPORTANT FOR BEGINNERS:
     * Mailtrap is a test inbox service that catches all emails
     * In a real application, you would use a real email service
     * The credentials below are for testing purposes only
     */
    protected function setupMailConfig(): void
    {
        // Configure email settings - all in one place for simplicity
        // In a production application, these would typically be in .env file
        
        // Basic mail configuration
        Config::set('mail.default', 'smtp');                              // Use SMTP protocol
        Config::set('mail.mailers.smtp.transport', 'smtp');               // Transport type
        Config::set('mail.mailers.smtp.host', 'sandbox.smtp.mailtrap.io'); // Mailtrap server
        Config::set('mail.mailers.smtp.port', 2525);                      // Mailtrap port
        Config::set('mail.mailers.smtp.encryption', 'tls');               // Encryption type
        
        // Authentication details for Mailtrap
        Config::set('mail.mailers.smtp.username', '84dea8bb07cf55');      // Mailtrap username
        Config::set('mail.mailers.smtp.password', 'd154e964127692');      // Mailtrap password
        
        // From address (who the email appears to be from)
        Config::set('mail.from.address', 'carservice@example.com');       // Sender email
        Config::set('mail.from.name', 'Car Service Center');              // Sender name
    }
} 