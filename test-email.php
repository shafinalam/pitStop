<?php

require __DIR__.'/vendor/autoload.php';

// Load environment variables manually
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value, "\" '\t\n\r\0\x0B");
            putenv("{$name}={$value}");
        }
    }
}

// Set up email configuration manually
$mailHost = getenv('MAIL_HOST') ?: 'sandbox.smtp.mailtrap.io';
$mailPort = getenv('MAIL_PORT') ?: '2525';
$mailUsername = getenv('MAIL_USERNAME') ?: '84dea8bb07cf55';
$mailPassword = getenv('MAIL_PASSWORD') ?: 'd154e964127692';
$mailEncryption = getenv('MAIL_ENCRYPTION') ?: 'tls';
$mailFromAddress = getenv('MAIL_FROM_ADDRESS') ?: 'carservice@example.com';
$mailFromName = getenv('MAIL_FROM_NAME') ?: 'Car Service Center';

// Display current configuration
echo "Email Configuration:\n";
echo "-------------------------\n";
echo "MAIL_HOST: $mailHost\n";
echo "MAIL_PORT: $mailPort\n";
echo "MAIL_USERNAME: $mailUsername\n";
echo "MAIL_PASSWORD: " . (empty($mailPassword) ? "Not set" : "[set]") . "\n";
echo "MAIL_ENCRYPTION: $mailEncryption\n";
echo "MAIL_FROM_ADDRESS: $mailFromName\n";
echo "MAIL_FROM_NAME: $mailFromName\n";
echo "-------------------------\n\n";

// Email data
$recipient = 'shafinalam2002@gmail.com';
$subject = 'Test Email from Car Service Center';

// Create email content
$emailContent = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Email</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        h1 { color: #3498db; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .details { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Email</h1>
        <p>Dear Test User,</p>
        <p>This is a test email to verify the email functionality of Car Service Center application.</p>
        <div class="details">
            <p><strong>Date:</strong> ' . date('Y-m-d') . '</p>
            <p><strong>Time:</strong> ' . date('H:i') . '</p>
            <p><strong>Test ID:</strong> TEST-' . rand(1000, 9999) . '</p>
        </div>
        <p>If you received this email, it means the email configuration is working correctly!</p>
        <p>Regards,<br>The Car Service Center Team</p>
    </div>
</body>
</html>';

// Set up email headers
$headers = [
    'MIME-Version: 1.0',
    'Content-type: text/html; charset=utf-8',
    'From: ' . $mailFromName . ' <' . $mailFromAddress . '>',
    'Reply-To: ' . $mailFromAddress,
    'X-Mailer: PHP/' . phpversion()
];

// Try sending the email using PHP's mail function
echo "Attempting to send test email to $recipient...\n";

try {
    // Use PHPMailer instead if available
    if (class_exists('\\PHPMailer\\PHPMailer\\PHPMailer')) {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $mailHost;
        $mail->SMTPAuth = true;
        $mail->Username = $mailUsername;
        $mail->Password = $mailPassword;
        $mail->SMTPSecure = $mailEncryption;
        $mail->Port = $mailPort;
        $mail->setFrom($mailFromAddress, $mailFromName);
        $mail->addAddress($recipient);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $emailContent;
        $mail->send();
        echo "Email sent successfully using PHPMailer!\n";
    } else {
        // Fall back to mail() function
        $success = mail($recipient, $subject, $emailContent, implode("\r\n", $headers));
        if ($success) {
            echo "Email sent successfully using PHP mail() function!\n";
        } else {
            echo "Failed to send email using PHP mail() function.\n";
        }
    }
} catch (Exception $e) {
    echo "Error sending email: " . $e->getMessage() . "\n";
} 