<?php
/**
 * Simple Gmail Setup Script
 * 
 * This script will modify your .env file to use Gmail SMTP
 * instead of Mailtrap, so emails go directly to real addresses.
 */

// Edit these settings with your own Gmail details
$settings = [
    'MAIL_HOST' => 'smtp.gmail.com',
    'MAIL_PORT' => '587',
    'MAIL_USERNAME' => 'your.email@gmail.com', // CHANGE THIS to your Gmail address
    'MAIL_PASSWORD' => 'your-16-char-app-password', // CHANGE THIS to your App Password
    'MAIL_ENCRYPTION' => 'tls',
    'MAIL_FROM_ADDRESS' => 'your.email@gmail.com', // CHANGE THIS to your Gmail address
    'MAIL_FROM_NAME' => 'Car Service Center' 
];

$envFile = __DIR__ . '/.env';

// Backup the original .env file
copy($envFile, $envFile . '.backup');
echo "Created backup of .env file to .env.backup\n";

// Read the current .env file
$envContents = file_get_contents($envFile);
$lines = explode("\n", $envContents);
$newLines = [];

// Process each line
foreach ($lines as $line) {
    $keep = true;
    
    foreach ($settings as $key => $value) {
        if (strpos($line, $key . '=') === 0) {
            $newLines[] = $key . '=' . $value;
            $keep = false;
            echo "Updated setting: {$key}={$value}\n";
            break;
        }
    }
    
    if ($keep) {
        $newLines[] = $line;
    }
}

// Write the updated .env file
file_put_contents($envFile, implode("\n", $newLines));
echo "Updated .env file with Gmail settings.\n";
echo "\nIMPORTANT NEXT STEPS:\n";
echo "1. Run: php artisan config:clear\n";
echo "2. Run: php artisan cache:clear\n";
echo "3. Test: php test-email.php\n";

echo "\nIf you still don't receive emails, check:\n";
echo "1. Gmail security settings - allow less secure apps\n";
echo "2. App Password is correct\n";
echo "3. Check your spam folder\n";
echo "4. Your Gmail sending limits\n"; 