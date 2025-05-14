<?php
/**
 * Test Email Script with PHPMailer
 * 
 * This is a standalone script to test email sending using PHPMailer
 * You can run this script from the command line to test if emails work
 * without involving the Laravel application.
 */

// Load Composer autoloader to access PHPMailer
require __DIR__.'/vendor/autoload.php';

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Mailtrap test configuration
$mailHost = 'sandbox.smtp.mailtrap.io';  // Mailtrap SMTP server address
$mailPort = 2525;                         // Mailtrap SMTP port
$mailUsername = '84dea8bb07cf55';         // Your Mailtrap username
$mailPassword = 'd154e964127692';         // Your Mailtrap password
$from = 'carservice@example.com';         // Sender email address
$fromName = 'Car Service Center';         // Sender name

try {
    // Create and configure new PHPMailer instance
    $mail = new PHPMailer(true);           // true enables exceptions for error handling
    
    // SMTP Configuration
    $mail->isSMTP();                        // Set mailer to use SMTP
    $mail->Host = $mailHost;                // SMTP server address
    $mail->SMTPAuth = true;                 // Enable SMTP authentication
    $mail->Username = $mailUsername;        // SMTP username
    $mail->Password = $mailPassword;        // SMTP password
    $mail->SMTPSecure = 'tls';              // Enable TLS encryption
    $mail->Port = $mailPort;                // TCP port to connect to
    
    // Recipients
    $mail->setFrom($from, $fromName);       // Sender email and name
    $mail->addAddress('test@example.com');  // Add a recipient (will go to Mailtrap)
    
    // Email Content
    $mail->isHTML(true);                    // Set email format to HTML
    $mail->Subject = 'PHPMailer Test Email from Car Service';
    $mail->Body = '
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
    
    // Print configuration for debugging
    echo "Attempting to send test email to Mailtrap using PHPMailer...\n";
    echo "Configuration:\n";
    echo "Host: $mailHost\n";
    echo "Port: $mailPort\n";
    echo "Username: $mailUsername\n";
    echo "From: $from\n";
    echo "To: test@example.com\n\n";
    
    // Send the email
    $mail->send();
    
    // Success message
    echo "Email has been sent successfully using PHPMailer!\n";
    echo "Please check your Mailtrap inbox.\n";
    
} catch (Exception $e) {
    // Error handling
    echo "Failed to send email. Error: " . $mail->ErrorInfo . "\n";
    echo "Exception message: " . $e->getMessage() . "\n";
} 