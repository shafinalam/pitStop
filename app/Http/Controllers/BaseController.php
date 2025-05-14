<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Log;

class BaseController extends Controller
{
    /**
     * Send a confirmation email to the client
     */
    public function sendAppointmentEmail($appointmentData, $mechanicData)
    {
        try {
            // Only proceed if we have a valid email
            if (empty($appointmentData['email'])) {
                Log::warning('No email provided for appointment confirmation');
                return false;
            }
            
            Log::info('Sending appointment confirmation email', [
                'to' => $appointmentData['email'],
                'appointment_date' => $appointmentData['appointment_date'],
            ]);
            
            // Send email using the AppointmentConfirmationMail mailable
            Mail::to($appointmentData['email'])
                ->send(new AppointmentConfirmationMail($appointmentData, $mechanicData));
            
            Log::info('Email sent successfully');
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send appointment confirmation email', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
} 