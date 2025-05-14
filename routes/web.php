<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TextToSpeechController;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function() {
    return Inertia::render('Home');
})->name('home');

// Simple test routes
Route::get('/hello', function() {
    return Inertia::render('Hello');
});

// About page
Route::get('/about', function() {
    return Inertia::render('About');
})->name('about');

// Contact page
Route::get('/contact', function() {
    return Inertia::render('Contact');
})->name('contact');

// Services page
Route::get('/services', function() {
    return Inertia::render('Services');
})->name('services');

// Mechanics page
Route::get('/mechanics', function() {
    return Inertia::render('Mechanics', [
        'mechanics' => [
            [
                'id' => 1,
                'name' => 'Alex Johnson',
                'specialty' => 'Engine Repair',
                'bio' => 'Expert with 8 years experience',
                'phone' => '555-123-4567',
                'email' => 'alex@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 2,
                'name' => 'Sarah Chen',
                'specialty' => 'Brake Systems',
                'bio' => 'Brake systems expert',
                'phone' => '555-234-5678',
                'email' => 'sarah@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 3,
                'name' => 'Miguel Rodriguez',
                'specialty' => 'Electrical Systems',
                'bio' => 'Electrical systems expert',
                'phone' => '555-345-6789',
                'email' => 'miguel@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 4,
                'name' => 'Priya Patel',
                'specialty' => 'General Maintenance',
                'bio' => 'General maintenance specialist',
                'phone' => '555-456-7890',
                'email' => 'priya@carservice.com',
                'is_available' => true
            ]
        ]
    ]);
})->name('mechanics');

// Appointment routes
Route::get('/appointments/create', function() {
    return Inertia::render('Appointments/Create', [
        'mechanics' => [
            [
                'id' => 1,
                'name' => 'Alex Johnson',
                'specialty' => 'Engine Repair',
                'bio' => 'Expert with 8 years experience',
                'phone' => '555-123-4567',
                'email' => 'alex@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 2,
                'name' => 'Sarah Chen',
                'specialty' => 'Brake Systems',
                'bio' => 'Brake systems expert',
                'phone' => '555-234-5678',
                'email' => 'sarah@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 3,
                'name' => 'Miguel Rodriguez',
                'specialty' => 'Electrical Systems',
                'bio' => 'Electrical systems expert',
                'phone' => '555-345-6789',
                'email' => 'miguel@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 4,
                'name' => 'Priya Patel',
                'specialty' => 'General Maintenance',
                'bio' => 'General maintenance specialist',
                'phone' => '555-456-7890',
                'email' => 'priya@carservice.com',
                'is_available' => true
            ]
        ]
    ]);
})->name('appointments.create');

// Handle appointment form submission
Route::post('/appointments', function() {
    // Form validation
    $validated = request()->validate([
        'mechanic_id' => 'required',
        'client_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'car_license_number' => 'required|string|max:50',
        'car_engine_number' => 'required|string|max:50',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
        'service_type' => 'required|string',
        'description' => 'nullable|string',
    ]);
    
    // Get mechanic data
    $mechanicId = (int)$validated['mechanic_id'];
    $mechanics = [
        1 => [
            'id' => 1,
            'name' => 'Alex Johnson',
            'specialty' => 'Engine Repair',
        ],
        2 => [
            'id' => 2,
            'name' => 'Sarah Chen',
            'specialty' => 'Brake Systems',
        ],
        3 => [
            'id' => 3,
            'name' => 'Miguel Rodriguez',
            'specialty' => 'Electrical Systems',
        ],
        4 => [
            'id' => 4,
            'name' => 'Priya Patel',
            'specialty' => 'General Maintenance',
        ]
    ];
    
    $mechanicData = $mechanics[$mechanicId] ?? ['name' => 'Selected Mechanic', 'specialty' => 'General Service'];
    
    // Log appointment details
    Log::info('Appointment created', [
        'client' => $validated['client_name'],
        'email' => $validated['email'],
        'date' => $validated['appointment_date'],
        'time' => $validated['appointment_time'],
        'mechanic' => $mechanicData['name'],
    ]);
    
    // Try to send email using PHPMailer
    $emailSent = false;
    try {
        // Get mail configuration from config file
        $mailHost = config('mail.mailers.smtp.host');
        $mailPort = config('mail.mailers.smtp.port');
        $mailUsername = config('mail.mailers.smtp.username');
        $mailPassword = config('mail.mailers.smtp.password');
        $mailEncryption = config('mail.mailers.smtp.encryption');
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        
        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host = $mailHost;
        $mail->SMTPAuth = true;
        $mail->Username = $mailUsername;
        $mail->Password = $mailPassword;
        $mail->SMTPSecure = $mailEncryption;
        $mail->Port = $mailPort;
        
        // Set sender and recipient
        $mail->setFrom($fromAddress, $fromName);
        $mail->addAddress($validated['email'], $validated['client_name']);
        
        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Your Car Service Appointment Confirmation';
        $mail->Body = "
        <html>
        <head>
            <title>Appointment Confirmation</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
                h1 { color: #3498db; }
                .details { background-color: #f9f9f9; padding: 15px; margin-bottom: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Appointment Confirmation</h1>
                <p>Dear {$validated['client_name']},</p>
                <p>Thank you for booking an appointment with Car Service Center. Your appointment has been scheduled for:</p>
                
                <div class='details'>
                    <p><strong>Date:</strong> {$validated['appointment_date']}</p>
                    <p><strong>Time:</strong> {$validated['appointment_time']}</p>
                    <p><strong>Service Type:</strong> {$validated['service_type']}</p>
                    <p><strong>Mechanic:</strong> {$mechanicData['name']} ({$mechanicData['specialty']})</p>
                    
                    <p><strong>Vehicle Information:</strong><br>
                    License Plate: {$validated['car_license_number']}<br>
                    Engine Number: {$validated['car_engine_number']}</p>
                </div>
                
                <p>Please arrive 10 minutes before your scheduled appointment time.</p>
                <p>Thank you for choosing Car Service Center.</p>
                <p>Regards,<br>The Car Service Center Team</p>
            </div>
        </body>
        </html>
        ";
        
        // Log before sending
        Log::info('Attempting to send email using PHPMailer with configuration', [
            'host' => $mailHost,
            'port' => $mailPort,
            'username' => $mailUsername,
            'to' => $validated['email']
        ]);
        
        // Send the email
        $mail->send();
        $emailSent = true;
        
        Log::info('Email sent successfully using PHPMailer');
    } catch (Exception $e) {
        Log::error('Failed to send email: ' . ($mail->ErrorInfo ?? $e->getMessage()));
    }
    
    // Return success response
    return redirect()->route('appointments.create')
        ->with('message', 'Appointment scheduled successfully!' . 
                ($emailSent ? ' A confirmation email has been sent.' : ''));
})->name('appointments.store');

/*
|--------------------------------------------------------------------------
| Text to Speech Routes
|--------------------------------------------------------------------------
*/
Route::post('/tts', [TextToSpeechController::class, 'convertToSpeech']);

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']); 