<?php

// Simple standalone script to test email sending

// Use Mailtrap settings directly from our know-working configuration
$mailHost = 'sandbox.smtp.mailtrap.io';
$mailPort = 2525;
$mailUsername = '84dea8bb07cf55';
$mailPassword = 'd154e964127692';
$from = 'carservice@example.com';
$fromName = 'Car Service Center';

// Test email parameters
$to = 'test@example.com'; // This will be sent to Mailtrap
$subject = 'Test Email from Car Service';
$message = '
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
        <h1>Test Email</h1>
        <p>This is a test email sent at ' . date('Y-m-d H:i:s') . '</p>
        <p>If you can see this in your Mailtrap inbox, email sending is working!</p>
    </div>
</body>
</html>
';

// Headers
$headers = [
    'MIME-Version: 1.0',
    'Content-type: text/html; charset=utf-8',
    'From: ' . $fromName . ' <' . $from . '>',
    'Reply-To: ' . $from,
    'X-Mailer: PHP/' . phpversion()
];

// Print configuration
echo "Attempting to send test email to Mailtrap...\n";
echo "Configuration:\n";
echo "Host: $mailHost\n";
echo "Port: $mailPort\n";
echo "Username: $mailUsername\n";
echo "From: $from\n";
echo "To: $to\n\n";

// Attempt to send using mail()
$result = mail($to, $subject, $message, implode("\r\n", $headers));

// Output result
if ($result) {
    echo "Email appears to have been sent successfully!\n";
    echo "Please check your Mailtrap inbox.\n";
} else {
    echo "Failed to send email using mail() function.\n";
    echo "This may be because your server is not configured to send mail\n";
    echo "or because Mailtrap requires SMTP authentication which mail() doesn't support.\n";
}

echo "\nNote: On Windows systems, the mail() function often doesn't work without additional configuration.\n";
echo "If this doesn't work, we can try using PHPMailer or another library.\n"; 