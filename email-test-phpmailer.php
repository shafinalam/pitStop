<?php

// Test email with PHPMailer instead of mail()
require __DIR__.'/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Mailtrap configuration
$mailHost = 'sandbox.smtp.mailtrap.io';
$mailPort = 2525;
$mailUsername = '84dea8bb07cf55';
$mailPassword = 'd154e964127692';
$from = 'carservice@example.com';
$fromName = 'Car Service Center';

// Create a new PHPMailer instance
$mail = new PHPMailer(true); // true enables exceptions

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = $mailHost;
    $mail->SMTPAuth   = true;
    $mail->Username   = $mailUsername;
    $mail->Password   = $mailPassword;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = $mailPort;
    
    // Recipients
    $mail->setFrom($from, $fromName);
    $mail->addAddress('test@example.com'); // Add a recipient (will go to Mailtrap)
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'PHPMailer Test Email from Car Service';
    $mail->Body    = '
    <html>
    <head>
        <title>Test Email</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
            h1 { color: #3498db; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>PHPMailer Test Email</h1>
            <p>This is a test email sent at ' . date('Y-m-d H:i:s') . '</p>
            <p>If you can see this in your Mailtrap inbox, email sending is working with PHPMailer!</p>
        </div>
    </body>
    </html>
    ';
    
    // Print configuration
    echo "Attempting to send test email to Mailtrap using PHPMailer...\n";
    echo "Configuration:\n";
    echo "Host: $mailHost\n";
    echo "Port: $mailPort\n";
    echo "Username: $mailUsername\n";
    echo "From: $from\n";
    echo "To: test@example.com\n\n";
    
    // Send the email
    $mail->send();
    
    echo "Email has been sent successfully using PHPMailer!\n";
    echo "Please check your Mailtrap inbox.\n";
    
} catch (Exception $e) {
    echo "Failed to send email. Error: " . $mail->ErrorInfo . "\n";
    echo "Exception message: " . $e->getMessage() . "\n";
} 