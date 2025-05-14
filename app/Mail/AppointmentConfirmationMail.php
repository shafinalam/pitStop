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
        $this->appointmentData = $appointmentData;
        $this->mechanicData = $mechanicData;
        
        Log::info('Creating appointment confirmation email', [
            'client' => $appointmentData['client_name'] ?? 'No name provided',
            'email' => $appointmentData['email'] ?? 'No email provided',
            'date' => $appointmentData['appointment_date'] ?? 'No date provided',
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
        return $this->subject('Your Car Service Appointment Confirmation')
            ->view('emails.appointment-confirmation')
            ->with([
                'appointmentData' => $this->appointmentData,
                'mechanicData' => $this->mechanicData,
            ]);
    }
}
