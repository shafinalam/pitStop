<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "=======================================\n";
echo "DIRECT MAILTRAP TEST SCRIPT\n";
echo "=======================================\n\n";

try {
    echo "Setting up PHPMailer...\n";
    $mail = new PHPMailer(true);

    // Enable verbose debug output
    $mail->SMTPDebug = 2; // 2 = detailed debug output
    
    // Configure Mailtrap
    echo "Configuring SMTP settings...\n";
    $mail->isSMTP();
    $mail->Host       = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = '84dea8bb07cf55';
    $mail->Password   = 'd154e964127692';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 2525;
    
    // Recipients
    echo "Setting up email headers...\n";
    $mail->setFrom('carservice@example.com', 'Car Service Center');
    $mail->addAddress('test@example.com', 'Test User');
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Direct Test Email - ' . date('Y-m-d H:i:s');
    $mail->Body    = '
        <html>
        <body>
            <h1>This is a direct test email</h1>
            <p>Sent at: ' . date('Y-m-d H:i:s') . '</p>
            <p>This email bypasses Laravel\'s mail system</p>
        </body>
        </html>
    ';
    
    echo "Sending email...\n";
    $mail->send();
    echo "Email sent successfully!\n";
    
} catch (Exception $e) {
    echo "Failed to send email: {$mail->ErrorInfo}\n";
    echo "Exception details: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=======================================\n";
echo "TEST COMPLETE\n";
echo "If successful, check your Mailtrap inbox\n";
echo "=======================================\n"; 