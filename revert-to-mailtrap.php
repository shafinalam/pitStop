<?php
// Simple script to ensure Mailtrap settings are correctly configured

// Mailtrap settings
$mailtrapSettings = [
    'MAIL_HOST' => 'sandbox.smtp.mailtrap.io',
    'MAIL_PORT' => '2525',
    'MAIL_USERNAME' => '84dea8bb07cf55',
    'MAIL_PASSWORD' => 'd154e964127692',
    'MAIL_ENCRYPTION' => 'tls',
    'MAIL_FROM_ADDRESS' => '"carservice@example.com"',
    'MAIL_FROM_NAME' => '"Car Service Center"'
];

// Back up the current .env file
copy('.env', '.env.gmail-backup');
echo "Created backup of current .env file as .env.gmail-backup\n";

// Read the current .env file
$envContent = file_get_contents('.env');
$lines = explode("\n", $envContent);
$newLines = [];

// Process each line
foreach ($lines as $line) {
    $keep = true;
    
    foreach ($mailtrapSettings as $key => $value) {
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
file_put_contents('.env', implode("\n", $newLines));
echo "Restored Mailtrap settings in .env file.\n";

// Clear Laravel's cache
echo "Clearing configuration cache...\n";
system('php artisan config:clear');
system('php artisan cache:clear');

echo "\nAll done! Your application is now configured to use Mailtrap again.\n";
echo "Emails will be captured in your Mailtrap inbox at https://mailtrap.io/\n";
echo "You should be able to see them in your Mailtrap dashboard.\n"; 