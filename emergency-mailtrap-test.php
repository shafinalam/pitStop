<?php
// Load PHPMailer classes
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get email address from command line argument or use default
$emailTo = $argv[1] ?? 'test@example.com';

echo "==========================================\n";
echo "EMERGENCY MAILTRAP EMAIL TEST\n";
echo "==========================================\n\n";

echo "Sending to: $emailTo\n\n";

try {
    echo "Creating PHPMailer instance...\n";
    $mail = new PHPMailer(true);
    
    echo "Setting up SMTP...\n";
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '84dea8bb07cf55';
    $mail->Password = 'd154e964127692';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 2525;
    
    echo "Setting sender and recipient...\n";
    $mail->setFrom('carservice@example.com', 'Car Service Center');
    $mail->addAddress($emailTo);
    
    echo "Setting email content...\n";
    $mail->isHTML(true);
    $mail->Subject = 'EMERGENCY TEST EMAIL - ' . date('Y-m-d H:i:s');
    $mail->Body = "
        <h1>Emergency Test Email</h1>
        <p>This is a test email sent directly with PHPMailer.</p>
        <p>Sent at: " . date('Y-m-d H:i:s') . "</p>
        <p>If you receive this email, your Mailtrap configuration is working correctly.</p>
        <hr>
        <p><strong>This email was sent using emergency-mailtrap-test.php script.</strong></p>
    ";
    
    echo "Sending email...\n";
    
    // Try to send it
    $result = $mail->send();
    
    if ($result) {
        echo "\nSUCCESS: Email was sent to Mailtrap!\n";
        echo "Please check your Mailtrap inbox at: https://mailtrap.io/inboxes\n";
    } else {
        echo "\nERROR: Failed to send email.\n";
        echo "Error: " . $mail->ErrorInfo . "\n";
    }
    
} catch (Exception $e) {
    echo "\nEXCEPTION: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n";
}

echo "\n==========================================\n";
echo "TEST COMPLETE\n";
echo "==========================================\n"; 