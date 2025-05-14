<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AppointmentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointmentData;
    public $mechanicData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $appointmentData, array $mechanicData)
    {
        // Ensure all required fields are available
        $this->appointmentData = array_merge([
            'client_name' => 'Client',
            'email' => 'client@example.com',
            'appointment_date' => date('Y-m-d'),
            'appointment_time' => date('H:i'),
            'car_license_number' => 'Not provided',
            'car_engine_number' => 'Not provided',
            'service_type' => 'General Service',
            'description' => '',
        ], $appointmentData);
        
        $this->mechanicData = array_merge([
            'name' => 'Assigned Mechanic',
            'specialty' => 'General Mechanic',
        ], $mechanicData);
        
        Log::info('Creating appointment confirmation email', [
            'client' => $this->appointmentData['client_name'],
            'email' => $this->appointmentData['email'],
            'date' => $this->appointmentData['appointment_date'],
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Car Service Appointment Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info('Building email message for ' . $this->appointmentData['email']);
        
        return $this->subject('Your Car Service Appointment Confirmation')
            ->view('emails.appointment-confirmation')
            ->with([
                'appointmentData' => $this->appointmentData,
                'mechanicData' => $this->mechanicData,
            ]);
    }
}
