<?php
// Make a backup first
copy('.env', '.env.backup');
echo "Created backup of .env file as .env.backup\n";

// Direct update of the .env file with Gmail settings
$envContent = file_get_contents('.env');

// Replace Mailtrap with Gmail settings
$envContent = str_replace(
    ['MAIL_HOST=sandbox.smtp.mailtrap.io', 'MAIL_PORT=2525'],
    ['MAIL_HOST=smtp.gmail.com', 'MAIL_PORT=587'],
    $envContent
);

// Update the username and password directly - Put your Gmail info here
$gmail = 'shafinalam2002@gmail.com'; // Your Gmail address
$appPassword = 'pitStop'; // Your App Password

// Update the settings
$envContent = preg_replace('/MAIL_USERNAME=.*/', 'MAIL_USERNAME=' . $gmail, $envContent);
$envContent = preg_replace('/MAIL_PASSWORD=.*/', 'MAIL_PASSWORD=' . $appPassword, $envContent);
$envContent = preg_replace('/MAIL_FROM_ADDRESS=.*/', 'MAIL_FROM_ADDRESS="' . $gmail . '"', $envContent);

file_put_contents('.env', $envContent);
echo "Updated .env with Gmail settings.\n";
echo "Gmail: $gmail\n";
echo "App Password is set\n";
echo "\nClearing Laravel cache...\n";

// Clear Laravel cache
system('php artisan config:clear');
system('php artisan cache:clear');

echo "\nSetup complete! Your emails should now be sent directly via Gmail.\n";
echo "If you don't receive emails, please check your spam folder.\n"; 