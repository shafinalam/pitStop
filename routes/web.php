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

Route::get('/', function() {
    return Inertia::render('Home');
})->name('home');

Route::get('/about', function() {
    return Inertia::render('About');
})->name('about');

Route::get('/contact', function() {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/services', function() {
    return Inertia::render('Services');
})->name('services');

/*
|--------------------------------------------------------------------------
| Mechanics & Appointments
|--------------------------------------------------------------------------
| Routes for mechanics listing and appointment management
*/

Route::get('/mechanics', function() {
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

Route::get('/appointments/create', function() {
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

Route::post('/appointments', function() {
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
    
    Log::info('Appointment created', [
        'client' => $validated['client_name'],
        'email' => $validated['email'],
        'date' => $validated['appointment_date'],
        'time' => $validated['appointment_time'],
        'mechanic' => $mechanicData['name'],
    ]);
    
    $emailSent = false;
    try {
        $mailHost = config('mail.mailers.smtp.host');
        $mailPort = config('mail.mailers.smtp.port');
        $mailUsername = config('mail.mailers.smtp.username');
        $mailPassword = config('mail.mailers.smtp.password');
        $mailEncryption = config('mail.mailers.smtp.encryption');
        $fromAddress = config('mail.from.address');
        $fromName = config('mail.from.name');
        
        $mail = new PHPMailer(true);
        
        $mail->isSMTP();
        $mail->Host = $mailHost;
        $mail->SMTPAuth = true;
        $mail->Username = $mailUsername;
        $mail->Password = $mailPassword;
        $mail->SMTPSecure = $mailEncryption;
        $mail->Port = $mailPort;
        
        $mail->setFrom($fromAddress, $fromName);
        $mail->addAddress($validated['email'], $validated['client_name']);
        
        $mail->isHTML(true);
        $mail->Subject = 'Appointment Confirmation';
        $mail->Body = "Appointment Complete! Your car service appointment has been confirmed.";
        
        Log::info('Attempting to send email using PHPMailer', [
            'to' => $validated['email']
        ]);
        
        $mail->send();
        $emailSent = true;
        
        Log::info('Email sent successfully');
    } catch (Exception $e) {
        Log::error('Failed to send email: ' . ($mail->ErrorInfo ?? $e->getMessage()));
    }
    
    return redirect()->route('appointments.create')
        ->with('message', 'Appointment scheduled!' . 
                ($emailSent ? ' Confirmation email sent.' : ''));
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