# Email Setup Guide for Car Service Center

This guide will help you set up email functionality for appointment confirmations in your Car Service Center application.

## Configure .env File

Add or update the following settings in your `.env` file:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="carservice@example.com"
MAIL_FROM_NAME="Car Service Center"
```

## Mailtrap Setup (for Testing)

1. Sign up for a free account at [Mailtrap.io](https://mailtrap.io)
2. Create an inbox (or use the default one)
3. Go to the SMTP settings tab
4. Copy the provided credentials to your `.env` file
5. Test your application by submitting an appointment form

## Production Mail Setup

For production, you'll want to use a real email service like:

- [SendGrid](https://sendgrid.com/)
- [Mailgun](https://www.mailgun.com/)
- [Amazon SES](https://aws.amazon.com/ses/)

Update your `.env` file with the appropriate credentials for your chosen service.

## Queue Setup (Optional)

For better performance, you can set up a queue worker to process emails:

1. Configure a queue connection in your `.env` file:
   ```
   QUEUE_CONNECTION=database
   ```

2. Run the queue migration:
   ```
   php artisan queue:table
   php artisan migrate
   ```

3. Start a queue worker:
   ```
   php artisan queue:work
   ```

In production, you'll want to use a process monitor like Supervisor to keep the queue worker running.

## Troubleshooting

If emails aren't being sent:

1. Check your .env settings
2. Make sure you're using the correct SMTP credentials
3. Check Laravel logs in `storage/logs/laravel.log`
4. Try running `php artisan config:clear` to clear cached config

## Test Email

You can test your email setup with Tinker:

```php
php artisan tinker
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmationMail;
$appointmentData = [
    'client_name' => 'Test User',
    'appointment_date' => '2023-06-01',
    'appointment_time' => '10:00 AM',
    'car_license_number' => 'ABC-1234',
    'service_type' => 'Oil Change'
];
$mechanicData = [
    'name' => 'Alex Johnson',
    'specialty' => 'Engine Repair'
];
Mail::to('your-email@example.com')->send(new AppointmentConfirmationMail($appointmentData, $mechanicData));
```

If everything is set up correctly, you should see the email in your Mailtrap inbox. 