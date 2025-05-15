<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/*
|--------------------------------------------------------------------------
| Basic Page Routes
|--------------------------------------------------------------------------
| These routes serve the main pages of the application
*/

// Home page
Route::get('/', function() {
    return Inertia::render('Home');
})->name('home');

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

/*
|--------------------------------------------------------------------------
| Mechanics & Appointments
|--------------------------------------------------------------------------
| Routes for mechanics listing and appointment management
*/

// Mechanics listing page
Route::get('/mechanics', function() {
    // Sample mechanics data (in a real app, this would come from database)
    $mechanics = [
        [
            'id' => 1,
            'name' => 'Shafin',
            'specialty' => 'Engine Repair',
            'bio' => 'Expert with 8 years experience',
            'phone' => '555-123-4567',
            'email' => 'shafin@carservice.com',
            'is_available' => true
        ],
        [
            'id' => 2,
            'name' => 'Arif',
            'specialty' => 'Brake Systems',
            'bio' => 'Brake systems expert',
            'phone' => '555-234-5678',
            'email' => 'arif@carservice.com',
            'is_available' => true
        ],
        [
            'id' => 3,
            'name' => 'Nilima',
            'specialty' => 'Electrical Systems',
            'bio' => 'Electrical systems expert',
            'phone' => '555-345-6789',
            'email' => 'nilima@carservice.com',
            'is_available' => true
        ],
        [
            'id' => 4,
            'name' => 'Fatema',
            'specialty' => 'General Maintenance',
            'bio' => 'General maintenance specialist',
            'phone' => '555-456-7890',
            'email' => 'fatema@carservice.com',
            'is_available' => true
        ]
    ];
    
    return Inertia::render('Mechanics', [
        'mechanics' => $mechanics
    ]);
})->name('mechanics');

// Appointment creation form
Route::get('/appointments/create', function() {
    // Sample mechanics data (same as above)
    $mechanics = [
        [
            'id' => 1,
            'name' => 'Shafin',
            'specialty' => 'Engine Repair',
            'bio' => 'Expert with 8 years experience',
            'phone' => '555-123-4567',
            'email' => 'shafin@carservice.com',
            'is_available' => true
        ],
        [
            'id' => 2,
            'name' => 'Arif',
            'specialty' => 'Brake Systems',
            'bio' => 'Brake systems expert',
            'phone' => '555-234-5678',
            'email' => 'arif@carservice.com',
            'is_available' => true
        ],
        [
            'id' => 3,
            'name' => 'Nilima',
            'specialty' => 'Electrical Systems',
            'bio' => 'Electrical systems expert',
            'phone' => '555-345-6789',
            'email' => 'nilima@carservice.com',
            'is_available' => true
        ],
        [
            'id' => 4,
            'name' => 'Fatema',
            'specialty' => 'General Maintenance',
            'bio' => 'General maintenance specialist',
            'phone' => '555-456-7890',
            'email' => 'fatema@carservice.com',
            'is_available' => true
        ]
    ];
    
    return Inertia::render('Appointments/Create', [
        'mechanics' => $mechanics
    ]);
})->name('appointments.create');

// Handle appointment form submission
Route::post('/appointments', function() {
    // 1. Validate the form data
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
    
    // 2. Get mechanic data
    $mechanicId = (int)$validated['mechanic_id'];
    $mechanics = [
        1 => [
            'id' => 1,
            'name' => 'Shafin',
            'specialty' => 'Engine Repair',
        ],
        2 => [
            'id' => 2,
            'name' => 'Arif',
            'specialty' => 'Brake Systems',
        ],
        3 => [
            'id' => 3,
            'name' => 'Nilima',
            'specialty' => 'Electrical Systems',
        ],
        4 => [
            'id' => 4,
            'name' => 'Fatema',
            'specialty' => 'General Maintenance',
        ]
    ];
    
    $mechanicData = $mechanics[$mechanicId] ?? ['name' => 'Selected Mechanic', 'specialty' => 'General Service'];
    
    // 3. Log appointment details
    Log::info('Appointment created', [
        'client' => $validated['client_name'],
        'email' => $validated['email'],
        'date' => $validated['appointment_date'],
        'time' => $validated['appointment_time'],
        'mechanic' => $mechanicData['name'],
    ]);
    
    // 4. Send confirmation email
    $emailSent = false;
    try {
        // Get mail configuration from config
        $mailHost = config('mail.mailers.smtp.host');
        $mailPort = config('mail.mailers.smtp.port');
        $mailUsername = config('mail.mailers.smtp.username');
        $mailPassword = config('mail.mailers.smtp.password');
        $mailEncryption = config('mail.mailers.smtp.encryption');
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        
        // Create PHPMailer instance
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
        
        // Log sending attempt
        Log::info('Attempting to send email using PHPMailer', [
            'to' => $validated['email']
        ]);
        
        // Send the email
        $mail->send();
        $emailSent = true;
        
        Log::info('Email sent successfully');
    } catch (Exception $e) {
        Log::error('Failed to send email: ' . ($mail->ErrorInfo ?? $e->getMessage()));
    }
    
    // 5. Return to the appointments page with success message
    return redirect()->route('appointments.create')
        ->with('message', 'Appointment scheduled successfully!' . 
                ($emailSent ? ' A confirmation email has been sent.' : ''));
})->name('appointments.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
| Routes for user registration, login, and logout
*/

Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']); 