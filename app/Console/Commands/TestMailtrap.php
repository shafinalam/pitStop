<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmationMail;

class TestMailtrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test-mailtrap {email? : Email address to send the test to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email via Mailtrap to verify configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        
        $this->info('Checking mail configuration...');
        $this->info('Mail driver: ' . config('mail.default'));
        $this->info('Mail host: ' . config('mail.mailers.smtp.host'));
        $this->info('Mail port: ' . config('mail.mailers.smtp.port'));
        $this->info('Mail encryption: ' . config('mail.mailers.smtp.encryption'));
        $this->info('Mail username: ' . config('mail.mailers.smtp.username'));
        
        $this->info('Sending test email to: ' . $email);
        
        try {
            $this->info('Creating test appointment data...');
            
            $appointmentData = [
                'client_name' => 'Test User',
                'email' => $email,
                'appointment_date' => date('Y-m-d'),
                'appointment_time' => date('H:i'),
                'car_license_number' => 'TEST-123',
                'car_engine_number' => 'TEST-ENGINE',
                'service_type' => 'Test Service',
                'description' => 'This is a test email sent via Laravel artisan command'
            ];
            
            $mechanicData = [
                'name' => 'Test Mechanic',
                'specialty' => 'Email Testing'
            ];
            
            $this->info('Creating mail object...');
            $mail = new AppointmentConfirmationMail($appointmentData, $mechanicData);
            
            $this->info('Sending email via Laravel Mail facade...');
            Mail::to($email)->send($mail);
            
            $this->info('Email sent successfully! Please check your Mailtrap inbox.');
            $this->info('This email will NOT be delivered to a real mailbox - it is captured by Mailtrap.io');
            Log::info('Test email sent successfully to ' . $email . ' via Laravel Mail facade');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to send test email!');
            $this->error('Error: ' . $e->getMessage());
            Log::error('Failed to send test email: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
} 