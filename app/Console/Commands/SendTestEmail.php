<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmationMail;

class SendTestEmail extends Command
{
    protected $signature = 'email:test {email}';
    protected $description = 'Send a test email to verify email functionality';

    public function handle()
    {
        $email = $this->argument('email');
        $this->info("Sending test email to: {$email}");

        try {
            $appointmentData = [
                'client_name' => 'Test User',
                'email' => $email,
                'appointment_date' => date('Y-m-d'),
                'appointment_time' => date('H:i'),
                'car_license_number' => 'TEST-123',
                'car_engine_number' => 'TEST-ENGINE-456',
                'service_type' => 'Test Service',
                'description' => 'This is a test email to verify email functionality'
            ];
            
            $mechanicData = [
                'name' => 'Test Mechanic',
                'specialty' => 'Email Testing'
            ];
            
            $result = Mail::mailer('smtp')
                          ->to($email)
                          ->send(new AppointmentConfirmationMail($appointmentData, $mechanicData));
            
            $this->info("Email sent successfully!");
            $this->info("Mail configuration:");
            $this->table(
                ['Setting', 'Value'],
                [
                    ['MAIL_MAILER', config('mail.default')],
                    ['MAIL_HOST', config('mail.mailers.smtp.host')],
                    ['MAIL_PORT', config('mail.mailers.smtp.port')],
                    ['MAIL_USERNAME', config('mail.mailers.smtp.username')],
                    ['MAIL_ENCRYPTION', config('mail.mailers.smtp.encryption') ?? 'null'],
                    ['MAIL_FROM_ADDRESS', config('mail.from.address')],
                    ['MAIL_FROM_NAME', config('mail.from.name')],
                ]
            );
        } catch (\Exception $e) {
            $this->error("Failed to send email: {$e->getMessage()}");
            $this->line("Stack trace:");
            $this->line($e->getTraceAsString());
        }
    }
} 