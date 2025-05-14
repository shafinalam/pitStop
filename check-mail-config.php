<?php
/**
 * Laravel Mail Configuration Diagnostic Tool
 * 
 * This script checks your Laravel mail configuration and environment settings
 * to help diagnose email delivery issues.
 */

// Require the autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load .env file if it exists
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    echo "No .env file found! This may be causing your mail configuration issues.\n";
}

// Print header
echo "=========================================\n";
echo "LARAVEL MAIL CONFIGURATION DIAGNOSTIC\n";
echo "=========================================\n\n";

// Check PHP version and extensions
echo "PHP VERSION: " . phpversion() . "\n";
echo "Required Extensions:\n";
$required_extensions = ['openssl', 'pdo', 'mbstring', 'tokenizer', 'xml', 'curl'];
foreach ($required_extensions as $ext) {
    echo " - $ext: " . (extension_loaded($ext) ? "Loaded ✓" : "Not Loaded ✗") . "\n";
}
echo "\n";

// Check .env mail settings
echo "MAIL ENVIRONMENT VARIABLES:\n";
$env_vars = [
    'MAIL_MAILER', 'MAIL_HOST', 'MAIL_PORT', 'MAIL_USERNAME', 
    'MAIL_PASSWORD', 'MAIL_ENCRYPTION', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME'
];

foreach ($env_vars as $var) {
    $value = getenv($var);
    echo " - $var: " . ($value ? (strpos($var, 'PASSWORD') !== false ? '[SET]' : $value) : 'Not set ✗') . "\n";
}
echo "\n";

// Try to load Laravel config
echo "ATTEMPTING TO LOAD LARAVEL CONFIG:\n";
try {
    // Create a new Illuminate application instance
    $app = new Illuminate\Foundation\Application(__DIR__);
    $app->singleton(
        Illuminate\Contracts\Http\Kernel::class,
        App\Http\Kernel::class
    );
    $app->singleton(
        Illuminate\Contracts\Console\Kernel::class,
        App\Console\Kernel::class
    );
    $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        App\Exceptions\Handler::class
    );
    
    // Load configuration
    $app->make('config')->set('app.key', 'base64:'.base64_encode(Illuminate\Encryption\Encrypter::generateKey('AES-256-CBC')));
    
    // Try to get mail configuration
    $mail_config = $app->make('config')->get('mail');
    
    if ($mail_config) {
        echo " - Default mailer: " . $mail_config['default'] . "\n";
        echo " - SMTP Host: " . ($mail_config['mailers']['smtp']['host'] ?? 'Not set') . "\n";
        echo " - SMTP Port: " . ($mail_config['mailers']['smtp']['port'] ?? 'Not set') . "\n";
        echo " - SMTP Username: " . ($mail_config['mailers']['smtp']['username'] ?? 'Not set') . "\n";
        echo " - SMTP Password: " . (isset($mail_config['mailers']['smtp']['password']) ? '[SET]' : 'Not set') . "\n";
        echo " - SMTP Encryption: " . ($mail_config['mailers']['smtp']['encryption'] ?? 'Not set') . "\n";
        echo " - From Address: " . ($mail_config['from']['address'] ?? 'Not set') . "\n";
        echo " - From Name: " . ($mail_config['from']['name'] ?? 'Not set') . "\n";
    } else {
        echo " - Failed to get mail configuration ✗\n";
    }
} catch (Exception $e) {
    echo " - Error loading Laravel config: " . $e->getMessage() . " ✗\n";
    echo " - This is normal if running this script outside of a Laravel context.\n";
}
echo "\n";

// Check direct connectivity to Mailtrap
echo "TESTING DIRECT CONNECTION TO MAILTRAP:\n";
$host = getenv('MAIL_HOST') ?: 'sandbox.smtp.mailtrap.io';
$port = getenv('MAIL_PORT') ?: 2525;

echo " - Trying to connect to $host:$port...\n";
$socket = @fsockopen($host, $port, $errno, $errstr, 10);
if ($socket) {
    echo " - Connection successful! ✓\n";
    fclose($socket);
} else {
    echo " - Connection failed: $errstr ($errno) ✗\n";
    echo " - Check your network connectivity and firewall settings.\n";
}
echo "\n";

// PHPMailer test
echo "TESTING PHPMAILER CONFIGURATION:\n";
try {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->Port = $port;
    $mail->SMTPAuth = true;
    $mail->Username = getenv('MAIL_USERNAME') ?: '84dea8bb07cf55';
    $mail->Password = getenv('MAIL_PASSWORD') ?: 'd154e964127692';
    $mail->SMTPSecure = getenv('MAIL_ENCRYPTION') ?: 'tls';
    
    if ($mail->SmtpConnect()) {
        echo " - PHPMailer SMTP connection successful! ✓\n";
        $mail->SmtpClose();
    } else {
        echo " - PHPMailer SMTP connection failed! ✗\n";
    }
} catch (Exception $e) {
    echo " - PHPMailer error: " . $e->getMessage() . " ✗\n";
}
echo "\n";

// Recommendations
echo "RECOMMENDATIONS:\n";
if (!file_exists(__DIR__ . '/.env')) {
    echo " - Create a .env file with proper mail settings\n";
} else {
    if (!getenv('MAIL_MAILER') || getenv('MAIL_MAILER') != 'smtp') {
        echo " - Set MAIL_MAILER=smtp in your .env file\n";
    }
    if (!getenv('MAIL_HOST')) {
        echo " - Set MAIL_HOST=sandbox.smtp.mailtrap.io in your .env file\n";
    }
    if (!getenv('MAIL_PORT')) {
        echo " - Set MAIL_PORT=2525 in your .env file\n";
    }
    if (!getenv('MAIL_USERNAME') || !getenv('MAIL_PASSWORD')) {
        echo " - Set your Mailtrap credentials in MAIL_USERNAME and MAIL_PASSWORD\n";
    }
}

echo " - Run 'php artisan config:clear' and 'php artisan cache:clear'\n";
echo " - Ensure no code is explicitly setting mail driver to 'log'\n";
echo " - Check Laravel logs for detailed error messages\n";
echo " - Test email sending with 'php artisan mail:test-mailtrap'\n";
echo " - Remember: Emails sent to Mailtrap won't appear in your Gmail inbox\n";
echo "\n";

echo "=========================================\n";
echo "DIAGNOSTIC COMPLETE\n";
echo "=========================================\n"; 