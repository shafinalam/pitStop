<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointmentData;
    protected $mechanicName;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $appointmentData, string $mechanicName)
    {
        $this->appointmentData = $appointmentData;
        $this->mechanicName = $mechanicName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Car Service Appointment Confirmation')
            ->greeting('Hello ' . $this->appointmentData['client_name'] . '!')
            ->line('Your appointment has been successfully scheduled with Car Service Center.')
            ->line('**Appointment Details:**')
            ->line('**Date:** ' . $this->appointmentData['appointment_date'])
            ->line('**Time:** ' . $this->appointmentData['appointment_time'])
            ->line('**Mechanic:** ' . $this->mechanicName)
            ->line('**Vehicle:** ' . $this->appointmentData['car_license_number'])
            ->line('Please arrive 10 minutes before your scheduled time. If you need to cancel or reschedule, please contact us at least 24 hours in advance.')
            ->action('Manage Your Appointment', url('/appointments'))
            ->line('Thank you for choosing Car Service Center!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_date' => $this->appointmentData['appointment_date'],
            'appointment_time' => $this->appointmentData['appointment_time'],
            'mechanic_name' => $this->mechanicName,
        ];
    }
}
