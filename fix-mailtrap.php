<?php
/**
 * Mailtrap Email Debugging Script
 * 
 * This script tests Mailtrap connection and sends a test email with detailed logging
 * to help diagnose any email sending issues.
 */

// Load the PHPMailer library
require_once __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "==============================================\n";
echo "MAILTRAP EMAIL DEBUG SCRIPT\n";
echo "==============================================\n\n";

// Load .env file
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    die("Error: .env file not found!\n");
}

$env = file_get_contents($envFile);
$lines = explode("\n", $env);
$envVars = [];

foreach ($lines as $line) {
    if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, "\" '\t\n\r\0\x0B");
        $envVars[$name] = $value;
    }
}

// Display current email settings
echo "Current Mailtrap Settings:\n";
echo "-------------------------\n";
echo "MAIL_HOST: " . ($envVars['MAIL_HOST'] ?? 'Not set') . "\n";
echo "MAIL_PORT: " . ($envVars['MAIL_PORT'] ?? 'Not set') . "\n";
echo "MAIL_USERNAME: " . ($envVars['MAIL_USERNAME'] ?? 'Not set') . "\n";
echo "MAIL_PASSWORD: " . (isset($envVars['MAIL_PASSWORD']) ? '[Set]' : 'Not set') . "\n";
echo "MAIL_ENCRYPTION: " . ($envVars['MAIL_ENCRYPTION'] ?? 'Not set') . "\n";
echo "MAIL_FROM_ADDRESS: " . ($envVars['MAIL_FROM_ADDRESS'] ?? 'Not set') . "\n";
echo "MAIL_FROM_NAME: " . ($envVars['MAIL_FROM_NAME'] ?? 'Not set') . "\n";
echo "-------------------------\n\n";

// Check if settings are for Mailtrap
if (strpos($envVars['MAIL_HOST'] ?? '', 'mailtrap.io') === false) {
    echo "Warning: You're not using Mailtrap! Current host is: " . ($envVars['MAIL_HOST'] ?? 'Not set') . "\n";
    echo "Would you like to switch to Mailtrap? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) == 'y') {
        $envVars['MAIL_HOST'] = 'sandbox.smtp.mailtrap.io';
        $envVars['MAIL_PORT'] = '2525';
        $envVars['MAIL_USERNAME'] = '84dea8bb07cf55';
        $envVars['MAIL_PASSWORD'] = 'd154e964127692';
        $envVars['MAIL_ENCRYPTION'] = 'tls';
        $envVars['MAIL_FROM_ADDRESS'] = 'carservice@example.com';
        $envVars['MAIL_FROM_NAME'] = 'Car Service Center';
        
        // Update .env file
        $newEnv = '';
        foreach ($lines as $line) {
            $keep = true;
            foreach ($envVars as $key => $value) {
                if (strpos($line, $key . '=') === 0) {
                    $newEnv .= "$key=$value\n";
                    $keep = false;
                    break;
                }
            }
            if ($keep) {
                $newEnv .= "$line\n";
            }
        }
        
        file_put_contents($envFile, $newEnv);
        echo "Updated .env file with Mailtrap settings!\n\n";
    }
}

// Send a test email using PHPMailer directly
echo "Sending test email to Mailtrap...\n";

try {
    $mail = new PHPMailer(true);
    
    // Server settings
    $mail->SMTPDebug = 2; // Detailed debug output
    $mail->isSMTP();
    $mail->Host       = $envVars['MAIL_HOST'] ?? 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = $envVars['MAIL_USERNAME'] ?? '84dea8bb07cf55';
    $mail->Password   = $envVars['MAIL_PASSWORD'] ?? 'd154e964127692';
    $mail->SMTPSecure = $envVars['MAIL_ENCRYPTION'] ?? 'tls';
    $mail->Port       = $envVars['MAIL_PORT'] ?? 2525;
    
    // Recipients
    $mail->setFrom($envVars['MAIL_FROM_ADDRESS'] ?? 'carservice@example.com', 
                  $envVars['MAIL_FROM_NAME'] ?? 'Car Service Center');
    $mail->addAddress('test@example.com', 'Test User');
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from Car Service Center - ' . date('Y-m-d H:i:s');
    $mail->Body    = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { padding: 20px; border: 1px solid #ccc; }
                h1 { color: #333; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Test Email</h1>
                <p>This is a test email sent at: ' . date('Y-m-d H:i:s') . '</p>
                <p>If you can see this in your Mailtrap inbox, the email system is working correctly!</p>
            </div>
        </body>
        </html>
    ';
    
    $mail->send();
    echo "\nMessage has been sent to Mailtrap successfully!\n";
    
    echo "\nTo check your emails:\n";
    echo "1. Go to https://mailtrap.io/\n";
    echo "2. Log in with your Mailtrap account\n";
    echo "3. Check your inbox for the test email\n";
    
} catch (Exception $e) {
    echo "\nMessage could not be sent. Error: {$mail->ErrorInfo}\n";
    
    echo "\nTroubleshooting tips:\n";
    echo "1. Check your Mailtrap credentials\n";
    echo "2. Make sure PHP can make outgoing connections\n";
    echo "3. Check firewall settings\n";
} 