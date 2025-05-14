<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TextToSpeechController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    
    // Return success response
    return redirect()->route('appointments.create')
        ->with('message', 'Appointment scheduled successfully! A confirmation email will be sent shortly.');
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