<?php
/**
 * Helper script to fix .env file format
 * Run with: php fix-env.php
 */

// Configuration for email - modify these values as needed
$config = [
    'MAIL_MAILER' => 'smtp',
    'MAIL_HOST' => 'smtp.mailtrap.io',
    'MAIL_PORT' => '2525',
    'MAIL_USERNAME' => 'your_mailtrap_username', // Replace this with your actual username (no spaces)
    'MAIL_PASSWORD' => 'your_mailtrap_password', // Replace this with your actual password
    'MAIL_ENCRYPTION' => 'tls',
    'MAIL_FROM_ADDRESS' => 'carservice@example.com',
    'MAIL_FROM_NAME' => 'Car Service Center',
];

// Read the current .env file
$envPath = __DIR__ . '/.env';
$envContent = file_exists($envPath) ? file_get_contents($envPath) : '';

if (empty($envContent)) {
    echo "Error: .env file not found or empty\n";
    exit(1);
}

// Create a backup of the original .env file
$backupPath = __DIR__ . '/.env.backup-' . date('Y-m-d-H-i-s');
file_put_contents($backupPath, $envContent);
echo "Created backup of .env file at: {$backupPath}\n";

// Process the .env file line by line
$lines = explode("\n", $envContent);
$updatedLines = [];
$mailConfigFound = false;

foreach ($lines as $line) {
    // Skip comment lines and empty lines
    if (empty(trim($line)) || strpos(trim($line), '#') === 0) {
        $updatedLines[] = $line;
        continue;
    }
    
    // Check if this is a mail config line
    foreach ($config as $key => $value) {
        if (strpos($line, $key . '=') === 0) {
            $updatedLines[] = $key . '=' . $value;
            $mailConfigFound = true;
            // Remove the processed key from config
            unset($config[$key]);
            continue 2; // Skip to the next line
        }
    }
    
    // Add any non-mail config line as is
    $updatedLines[] = $line;
}

// Add any missing mail config lines
foreach ($config as $key => $value) {
    $updatedLines[] = $key . '=' . $value;
}

// Write the updated content back to .env
file_put_contents($envPath, implode("\n", $updatedLines));
echo "Updated .env file with correct mail configuration\n";

// Output instructions
echo "\nYour .env file has been updated. If you're using a different mail service than Mailtrap,\n";
echo "please manually edit your .env file and set the appropriate values for:\n";
echo "MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, and MAIL_ENCRYPTION\n"; 