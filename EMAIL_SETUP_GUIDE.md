# Email Setup Guide for Car Service Center

## Introduction

This guide will help you set up and configure email functionality for the Car Service Center application. The application sends confirmation emails when appointments are booked.

## Important Note About Mailtrap

**Mailtrap is a testing service that does not deliver emails to real inboxes.** When using Mailtrap SMTP settings (which you're currently using), emails are captured in your Mailtrap account where you can view them, not delivered to the recipient's actual inbox.

To check if your emails are being sent correctly:
1. Log in to your Mailtrap account at https://mailtrap.io/
2. View your inbox to see the captured emails

## Configuration Steps

### 1. Testing Configuration (Current Setup)

Your current `.env` file has Mailtrap settings:

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=84dea8bb07cf55
MAIL_PASSWORD=d154e964127692
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="carservice@example.com"
MAIL_FROM_NAME="Car Service Center"
```

### 2. Production Configuration (To Send Real Emails)

When you're ready to send real emails to customers, update your `.env` file with one of these production email services:

#### Gmail SMTP
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your.email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="carservice@example.com"
MAIL_FROM_NAME="Car Service Center"
```
Note: For Gmail, you'll need to create an App Password in your Google account settings.

#### SendGrid
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="carservice@example.com"
MAIL_FROM_NAME="Car Service Center"
```

#### Mailgun
```
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.com
MAILGUN_SECRET=your-mailgun-key
MAIL_FROM_ADDRESS="carservice@example.com"
MAIL_FROM_NAME="Car Service Center"
```

### 3. Using PHPMailer (Already Set Up)

We've integrated PHPMailer as a more reliable method for sending emails:

1. The system automatically prefers PHPMailer when available
2. The email settings are taken from your `.env` file, so changing the settings above will affect PHPMailer too

### 4. Clear Configuration Cache

After changing your mail settings, run:

```bash
php artisan config:clear
php artisan cache:clear
```

## Testing Email Functionality

### Option 1: Test in Mailtrap (Current Setup)

With your current Mailtrap setup, run:

```bash
php test-email.php
```

This will send a test email to your Mailtrap inbox (not to your actual Gmail account).

### Option 2: Test with Real Email Service

After switching to a production email service:

1. Update the email address in `test-email.php` to your actual email
2. Run `php test-email.php`
3. Check your real email inbox for the test message

## Troubleshooting

### Common Issues

1. **Emails showing as sent but not in Gmail**: 
   - If using Mailtrap: This is expected behavior. Emails are captured in Mailtrap, not sent to real inboxes.
   - If using production service: Check spam folder or email service logs

2. **Connection refused error**:
   - Check your firewall settings
   - Verify the MAIL_HOST and MAIL_PORT are correct

3. **Authentication failed**:
   - Double-check your MAIL_USERNAME and MAIL_PASSWORD

### Debug Tips

1. Check Laravel logs in `storage/logs/laravel.log`
2. Run the test script which will show detailed error messages
3. Check your email service dashboard for delivery status

## Production Email Setup

For production environments, consider using a reliable email service like:

- **Mailgun**: Offers a generous free tier
- **SendGrid**: Popular for large-scale email sending
- **Amazon SES**: Very cost-effective for high volume

Update your `.env` configuration accordingly for your chosen provider. 