<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

echo "=======================================\n";
echo "ENHANCED MAILTRAP CONNECTION TEST\n";
echo "=======================================\n\n";

// Record the start time
$startTime = microtime(true);
echo "Test started at: " . date('Y-m-d H:i:s') . "\n\n";

try {
    echo "Environment Information:\n";
    echo "PHP Version: " . phpversion() . "\n";
    echo "Operating System: " . PHP_OS . "\n";
    echo "Server Software: " . (isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'CLI') . "\n\n";
    
    echo "Setting up PHPMailer...\n";
    $mail = new PHPMailer(true);

    // Enable very verbose debug output
    $mail->SMTPDebug = 3; // 3 = most detailed debug output
    
    // Capture debug output to a variable
    $debugOutput = "";
    $mail->Debugoutput = function($str, $level) use (&$debugOutput) {
        echo $str;
        $debugOutput .= $str . "\n";
    };
    
    // Configure Mailtrap
    echo "\nConfiguring SMTP settings...\n";
    $mail->isSMTP();
    $mail->Host       = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = '84dea8bb07cf55';
    $mail->Password   = 'd154e964127692';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 2525;
    
    // Test connection first
    echo "\nTesting SMTP Connection...\n";
    if ($mail->SmtpConnect()) {
        echo "SMTP Connection Successful!\n";
        $mail->SmtpClose();
    } else {
        echo "SMTP Connection Failed!\n";
        throw new Exception("Failed to connect to SMTP server");
    }
    
    // Proceed with sending a test email
    echo "\nPreparing to send test email...\n";
    
    // Recipients
    $mail->setFrom('carservice@example.com', 'Car Service Center');
    $mail->addAddress('test@example.com', 'Test User');
    
    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Enhanced Test Email - ' . date('Y-m-d H:i:s');
    $mail->Body    = '
        <html>
        <body>
            <h1>This is an enhanced test email</h1>
            <p>Sent at: ' . date('Y-m-d H:i:s') . '</p>
            <p>This email tests the Mailtrap connection</p>
        </body>
        </html>
    ';
    
    echo "\nSending email...\n";
    $result = $mail->send();
    echo "Email sent successfully!\n";
    
    // Calculate and show execution time
    $endTime = microtime(true);
    $executionTime = ($endTime - $startTime);
    echo "\nTest completed in " . number_format($executionTime, 2) . " seconds\n";
    
    // Save detailed logs
    file_put_contents(
        __DIR__ . '/mailtrap-test-log.txt', 
        date('Y-m-d H:i:s') . " - Mailtrap Test Results\n" .
        "Result: " . ($result ? 'SUCCESS' : 'FAILURE') . "\n" .
        "Debug Output:\n" . $debugOutput . "\n" .
        "Execution Time: " . number_format($executionTime, 2) . " seconds\n" .
        "----------------------------------------------\n", 
        FILE_APPEND
    );
    
} catch (Exception $e) {
    echo "Failed to send email!\n";
    echo "Error message: {$e->getMessage()}\n";
    
    if (isset($mail) && isset($mail->ErrorInfo) && !empty($mail->ErrorInfo)) {
        echo "PHPMailer Error: {$mail->ErrorInfo}\n";
    }
    
    // Calculate execution time even if it failed
    $endTime = microtime(true);
    $executionTime = ($endTime - $startTime);
    
    // Save error log
    file_put_contents(
        __DIR__ . '/mailtrap-test-error.txt', 
        date('Y-m-d H:i:s') . " - Mailtrap Test Error\n" .
        "Error: " . $e->getMessage() . "\n" .
        (isset($mail) && isset($mail->ErrorInfo) ? "PHPMailer Error: {$mail->ErrorInfo}\n" : "") .
        (isset($debugOutput) ? "Debug Output:\n{$debugOutput}\n" : "") .
        "Stack Trace:\n" . $e->getTraceAsString() . "\n" .
        "Execution Time: " . number_format($executionTime, 2) . " seconds\n" .
        "----------------------------------------------\n", 
        FILE_APPEND
    );
}

echo "\n=======================================\n";
echo "TEST COMPLETE\n";
echo "If successful, check your Mailtrap inbox\n";
echo "Log files have been created in the project directory\n";
echo "=======================================\n"; 