<?php
/**
 * Laravel Environment Variable Test
 * 
 * This script attempts to debug Laravel's environment variable loading
 * by checking both native PHP environment and Laravel's config.
 */

// Require the autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Check if dotenv is available
if (!class_exists('Dotenv\Dotenv')) {
    echo "ERROR: Dotenv class not found. Please install vlucas/phpdotenv package.\n";
    exit(1);
}

echo "======================================\n";
echo "LARAVEL ENVIRONMENT VARIABLE TEST\n";
echo "======================================\n\n";

// Basic environment info
echo "PHP Version: " . phpversion() . "\n";
echo "Current Directory: " . __DIR__ . "\n\n";

// Try loading .env file directly
echo "CHECKING FOR .ENV FILE:\n";
if (file_exists(__DIR__ . '/.env')) {
    echo " - .env file found ✓\n";
    echo " - File size: " . filesize(__DIR__ . '/.env') . " bytes\n";
    echo " - File permissions: " . substr(sprintf('%o', fileperms(__DIR__ . '/.env')), -4) . "\n";
    
    // Try to load it with dotenv
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        echo " - Successfully loaded .env file with Dotenv ✓\n";
    } catch (Exception $e) {
        echo " - Failed to load .env file: " . $e->getMessage() . " ✗\n";
    }
} else {
    echo " - .env file not found! ✗\n";
    echo " - This is likely causing your configuration issues\n";
    
    // Check for .env.example
    if (file_exists(__DIR__ . '/.env.example')) {
        echo " - .env.example found - you should copy this to .env ✓\n";
    } else {
        echo " - .env.example not found either ✗\n";
    }
}

echo "\nENVIRONMENT VARIABLES (getenv):\n";
$env_vars = [
    'APP_ENV', 'APP_DEBUG', 'APP_URL',
    'MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 
    'MAIL_PASSWORD', 'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME'
];

foreach ($env_vars as $var) {
    $value = getenv($var);
    if ($value) {
        if (strpos($var, 'PASSWORD') !== false) {
            echo " - $var: [SET] ✓\n";
        } else {
            echo " - $var: $value ✓\n";
        }
    } else {
        echo " - $var: Not set ✗\n";
    }
}

echo "\nCHECKING LARAVEL CONFIG:\n";
echo " - Attempting to load directly from config/mail.php...\n";
if (file_exists(__DIR__ . '/config/mail.php')) {
    try {
        $config = include __DIR__ . '/config/mail.php';
        if (is_array($config)) {
            echo "   - Default driver: " . $config['default'] . "\n";
            echo "   - SMTP Host: " . $config['mailers']['smtp']['host'] . "\n";
            echo "   - SMTP Port: " . $config['mailers']['smtp']['port'] . "\n";
            echo "   - SMTP Username: " . $config['mailers']['smtp']['username'] . "\n";
            echo "   - SMTP Encryption: " . ($config['mailers']['smtp']['encryption'] ?? 'null') . "\n";
        } else {
            echo "   - Invalid config format ✗\n";
        }
    } catch (Exception $e) {
        echo "   - Error loading config: " . $e->getMessage() . " ✗\n";
    }
} else {
    echo "   - config/mail.php not found ✗\n";
}

echo "\nCONFIGURATION ANALYSIS:\n";
if (file_exists(__DIR__ . '/.env')) {
    $env_contents = file_get_contents(__DIR__ . '/.env');
    
    if (strpos($env_contents, 'MAIL_MAILER=smtp') !== false) {
        echo " - MAIL_MAILER is set to smtp in .env ✓\n";
    } else {
        echo " - MAIL_MAILER not set to smtp in .env ✗\n";
        echo "   Recommended fix: Add MAIL_MAILER=smtp to .env\n";
    }
    
    if (strpos($env_contents, 'MAIL_HOST=sandbox.smtp.mailtrap.io') !== false) {
        echo " - MAIL_HOST is set to Mailtrap in .env ✓\n";
    } else {
        echo " - MAIL_HOST not set to Mailtrap in .env ✗\n";
        echo "   Recommended fix: Add MAIL_HOST=sandbox.smtp.mailtrap.io to .env\n";
    }
    
    if (strpos($env_contents, 'MAIL_PORT=2525') !== false) {
        echo " - MAIL_PORT is set to 2525 in .env ✓\n";
    } else {
        echo " - MAIL_PORT not set to 2525 in .env ✗\n";
        echo "   Recommended fix: Add MAIL_PORT=2525 to .env\n";
    }
} else {
    echo " - Cannot analyze .env (file not found) ✗\n";
}

if (file_exists(__DIR__ . '/bootstrap/cache/config.php')) {
    echo " - Cached configuration found. Try running:\n";
    echo "   php artisan config:clear\n";
    echo "   php artisan cache:clear\n";
}

echo "\n======================================\n";
echo "RECOMMENDATIONS:\n";
echo "======================================\n";
echo "1. Make sure you have a .env file in your Laravel root directory\n";
echo "2. Ensure these settings are in your .env file:\n";
echo "   MAIL_MAILER=smtp\n";
echo "   MAIL_HOST=sandbox.smtp.mailtrap.io\n";
echo "   MAIL_PORT=2525\n";
echo "   MAIL_USERNAME=84dea8bb07cf55\n";
echo "   MAIL_PASSWORD=d154e964127692\n";
echo "   MAIL_ENCRYPTION=tls\n";
echo "   MAIL_FROM_ADDRESS=carservice@example.com\n";
echo "   MAIL_FROM_NAME=\"Car Service Center\"\n";
echo "3. Clear Laravel's configuration cache:\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n";
echo "4. Remember: Check Mailtrap.io for emails, not your Gmail\n";
echo "======================================\n"; 