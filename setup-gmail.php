<?php
/**
 * Setup Gmail SMTP Configuration
 * 
 * This script will help you switch from Mailtrap (testing) to Gmail (production)
 * so you can send real emails to customers.
 * 
 * Usage:
 * 1. Update the variables below with your Gmail information
 * 2. Run: php setup-gmail.php
 * 3. Test the new configuration with: php test-email.php
 */

// Your Gmail information
$gmail_username = "your.email@gmail.com"; // Replace with your Gmail address
$gmail_password = "your-app-password";    // Replace with your Gmail App Password (not your regular password)
$from_name = "Car Service Center";
$from_email = "carservice@yourdomain.com"; // This can be different from your Gmail

// Ask for confirmation
echo "This script will update your email configuration from Mailtrap to Gmail.\n";
echo "Make sure you have created an App Password in your Google account settings.\n";
echo "Continue? (y/n): ";
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
if(trim($line) != 'y'){
    echo "Operation cancelled.\n";
    exit;
}

// Create backup of current .env file
$env_file = __DIR__ . '/.env';
$backup_file = __DIR__ . '/.env.backup-' . date('Y-m-d-H-i-s');

if (file_exists($env_file)) {
    copy($env_file, $backup_file);
    echo "Created backup of .env file: {$backup_file}\n";
    
    // Read current .env content
    $env_content = file_get_contents($env_file);
    
    // Replace Mailtrap settings with Gmail settings
    $env_content = preg_replace('/MAIL_HOST=.*/', 'MAIL_HOST=smtp.gmail.com', $env_content);
    $env_content = preg_replace('/MAIL_PORT=.*/', 'MAIL_PORT=587', $env_content);
    $env_content = preg_replace('/MAIL_USERNAME=.*/', "MAIL_USERNAME={$gmail_username}", $env_content);
    $env_content = preg_replace('/MAIL_PASSWORD=.*/', "MAIL_PASSWORD={$gmail_password}", $env_content);
    $env_content = preg_replace('/MAIL_ENCRYPTION=.*/', 'MAIL_ENCRYPTION=tls', $env_content);
    $env_content = preg_replace('/MAIL_FROM_ADDRESS=.*/', "MAIL_FROM_ADDRESS=\"{$from_email}\"", $env_content);
    $env_content = preg_replace('/MAIL_FROM_NAME=.*/', "MAIL_FROM_NAME=\"{$from_name}\"", $env_content);
    
    // Save updated .env file
    file_put_contents($env_file, $env_content);
    echo "Updated .env file with Gmail SMTP settings.\n";
    
    echo "\nNext steps:\n";
    echo "1. Run: php artisan config:clear\n";
    echo "2. Run: php artisan cache:clear\n";
    echo "3. Test the configuration: php test-email.php\n";
} else {
    echo "Error: .env file not found.\n";
    exit(1);
} 