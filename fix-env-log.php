<?php
/**
 * Helper script to set mailer to LOG
 * Run with: php fix-env-log.php
 */

// Configuration for using log driver
$config = [
    'MAIL_MAILER' => 'log',
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
    
    // Skip other mail config lines
    if (strpos($line, 'MAIL_') === 0) {
        // Comment out the line
        $updatedLines[] = '# ' . $line;
        continue;
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
echo "Updated .env file to use LOG mail driver for debugging\n";

echo "\nYour .env file has been updated to use the LOG mail driver.\n";
echo "Emails will be written to storage/logs/laravel.log instead of being sent via SMTP.\n";
echo "To revert to using SMTP, edit your .env file manually or restore from backup.\n"; 