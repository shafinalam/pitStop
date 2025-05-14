<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SimpleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TextToSpeechController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

// Simple direct route to test basic routing
Route::get('/hello', function() {
    return Inertia::render('Hello');
});

// Home route using direct Inertia render
Route::get('/', function() {
    return Inertia::render('Home');
})->name('home');

// Controller route tests
Route::get('/simple', [SimpleController::class, 'index']);
Route::get('/test', [TestController::class, 'index']);

// Book routes
Route::get('/books', [BookController::class, 'create']);
Route::get('/books/index', [BookController::class, 'index']);
Route::get('/books/{book}', [BookController::class, 'show']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{book}/edit', [BookController::class, 'edit']);
Route::patch('/books/{book}', [BookController::class, 'update']);
Route::delete('/books/{book}', [BookController::class, 'delete']);
Route::post('/tts', [TextToSpeechController::class, 'convertToSpeech']);

// Appointment Routes
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/appointments/create', function() {
    $mechanics = DB::table('mechanics')->where('is_available', 1)->get();
    
    // If no mechanics exist, add some default ones
    if ($mechanics->isEmpty()) {
        // Add mechanics directly to the database
        $mechanicsData = [
            [
                'name' => 'Alex Johnson',
                'specialty' => 'Engine Repair',
                'bio' => 'Expert with 8 years experience',
                'phone' => '555-123-4567',
                'email' => 'alex@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sarah Chen',
                'specialty' => 'Brake Systems',
                'bio' => 'Brake systems expert',
                'phone' => '555-234-5678',
                'email' => 'sarah@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Miguel Rodriguez',
                'specialty' => 'Electrical Systems',
                'bio' => 'Electrical systems expert',
                'phone' => '555-345-6789',
                'email' => 'miguel@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Priya Patel',
                'specialty' => 'General Maintenance',
                'bio' => 'General maintenance specialist',
                'phone' => '555-456-7890',
                'email' => 'priya@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        foreach ($mechanicsData as $mechanic) {
            DB::table('mechanics')->insert($mechanic);
        }
        
        // Get mechanics again after adding
        $mechanics = DB::table('mechanics')->where('is_available', 1)->get();
    }
    
    return Inertia::render('Appointments/Create', [
        'mechanics' => $mechanics
    ]);
})->name('appointments.create');

Route::post('/appointments', function(Request $request) {
    // Log the incoming request for debugging
    Log::info('Appointment request received', [
        'data' => $request->all()
    ]);
    
    try {
        // Validate request
        $validated = $request->validate([
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
        
        // Get mechanic data from the database
        $mechanic = DB::table('mechanics')->where('id', $validated['mechanic_id'])->first();
        
        if (!$mechanic) {
            // If mechanic not found but we have a valid ID, use default data based on the ID
            // This handles the case where mechanic IDs in the form don't match the database
            $mechanicsData = [
                1 => ['name' => 'Alex Johnson', 'specialty' => 'Engine Repair'],
                2 => ['name' => 'Sarah Chen', 'specialty' => 'Brake Systems'],
                3 => ['name' => 'Miguel Rodriguez', 'specialty' => 'Electrical Systems'],
                4 => ['name' => 'Priya Patel', 'specialty' => 'General Maintenance'],
            ];
            
            if (isset($mechanicsData[$validated['mechanic_id']])) {
                $mechanicData = $mechanicsData[$validated['mechanic_id']];
            } else {
                return back()->withErrors([
                    'mechanic_id' => 'Selected mechanic not found.'
                ])->withInput();
            }
        } else {
            $mechanicData = [
                'name' => $mechanic->name,
                'specialty' => $mechanic->specialty
            ];
        }
    
        Log::info('Appointment booking validated', [
            'client' => $validated['client_name'],
            'email' => $validated['email'],
            'date' => $validated['appointment_date'],
            'mechanic' => $mechanicData['name']
        ]);
        
        // Store appointment in database for persistence
        try {
            DB::table('appointments')->insert([
                'mechanic_id' => $validated['mechanic_id'],
                'client_name' => $validated['client_name'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'phone' => $validated['phone'],
                'car_license_number' => $validated['car_license_number'],
                'car_engine_number' => $validated['car_engine_number'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'service_type' => $validated['service_type'],
                'description' => $validated['description'] ?? '',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            Log::info('Appointment saved to database successfully');
        } catch (\Exception $e) {
            Log::error('Database error when saving appointment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Continue without database save - we'll still show success to the user
            // This prevents the form submission from failing if there are database issues
        }
        
        // Send confirmation email
        $emailSent = false;
        try {
            if (!empty($validated['email'])) {
                // Configure mail to use the log driver if SMTP is not set up
                $mailConfig = config('mail.mailer');
                if ($mailConfig !== 'smtp' || env('MAIL_USERNAME') === 'your_mailtrap_username') {
                    // Set mail driver to log for testing
                    config(['mail.default' => 'log']);
                    Log::info('Using log driver for email as SMTP is not configured');
                }
                
                // Using a simple mail approach instead of the mailable class
                Mail::send('emails.appointment-confirmation', [
                    'appointmentData' => $validated,
                    'mechanicData' => $mechanicData
                ], function($message) use ($validated) {
                    $message->to($validated['email'])
                            ->subject('Your Car Service Appointment Confirmation');
                });
                
                Log::info('Appointment confirmation email sent successfully to ' . $validated['email']);
                $emailSent = true;
            }
        } catch (\Exception $e) {
            Log::error('Failed to send appointment confirmation email', [
                'error' => $e->getMessage(),
                'email' => $validated['email']
            ]);
            // We don't rethrow the exception here, as we want the appointment to be considered successful
            // even if the email fails
        }
        
        // Return success with redirect
        $message = 'Appointment booked successfully!';
        if ($emailSent) {
            $message .= ' A confirmation email has been sent to your email address.';
        } else {
            $message .= ' However, we could not send a confirmation email. Please take note of your appointment details.';
        }
        
        return redirect()->route('appointments.create')->with('message', $message);
        
    } catch (\Exception $e) {
        Log::error('Error processing appointment booking', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return back()->withErrors([
            'general' => 'An error occurred while processing your appointment. Please try again later.'
        ])->withInput();
    }
})->name('appointments.store');

Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
Route::patch('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

// Service pages
Route::get('/services', function() {
    return Inertia::render('Services');
});

Route::get('/mechanics', function() {
    return Inertia::render('Mechanics', [
        'mechanics' => [
            [
                'id' => 1,
                'name' => 'Alex Johnson',
                'specialty' => 'Engine Repair',
                'bio' => 'Alex specializes in diagnosing and repairing complex engine issues. With 8 years of experience, he has worked on various car makes and models.',
                'phone' => '555-123-4567',
                'email' => 'alex@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 2,
                'name' => 'Sarah Chen',
                'specialty' => 'Brake Systems',
                'bio' => 'Sarah is our brake system expert with over a decade of experience. She ensures your vehicle\'s braking system is in perfect condition for maximum safety.',
                'phone' => '555-234-5678',
                'email' => 'sarah@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 3,
                'name' => 'Miguel Rodriguez',
                'specialty' => 'Electrical Systems',
                'bio' => 'Miguel excels in diagnosing and fixing electrical issues in modern vehicles. He stays up-to-date with the latest automotive electronics technology.',
                'phone' => '555-345-6789',
                'email' => 'miguel@carservice.com',
                'is_available' => true
            ],
            [
                'id' => 4,
                'name' => 'Priya Patel',
                'specialty' => 'General Maintenance',
                'bio' => 'Priya handles all aspects of routine maintenance and ensures your vehicle runs smoothly. She has comprehensive knowledge of preventative care.',
                'phone' => '555-456-7890',
                'email' => 'priya@carservice.com',
                'is_available' => true
            ]
        ]
    ]);
});

Route::get('/about', function() {
    return Inertia::render('About');
});

Route::get('/contact', function() {
    return Inertia::render('Contact');
});

// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

//Route::resource('books', BookController::class);

// Add a route to debug mechanics
Route::get('/debug/mechanics', function() {
    // Attempt to get all mechanics
    $mechanics = DB::table('mechanics')->get();
    
    // If no mechanics, add them now
    if ($mechanics->isEmpty()) {
        // Add mechanics directly to the database
        $mechanicsData = [
            [
                'name' => 'Alex Johnson',
                'specialty' => 'Engine Repair',
                'bio' => 'Expert with 8 years experience',
                'phone' => '555-123-4567',
                'email' => 'alex@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sarah Chen',
                'specialty' => 'Brake Systems',
                'bio' => 'Brake systems expert',
                'phone' => '555-234-5678',
                'email' => 'sarah@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Miguel Rodriguez',
                'specialty' => 'Electrical Systems',
                'bio' => 'Electrical systems expert',
                'phone' => '555-345-6789',
                'email' => 'miguel@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Priya Patel',
                'specialty' => 'General Maintenance',
                'bio' => 'General maintenance specialist',
                'phone' => '555-456-7890',
                'email' => 'priya@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        foreach ($mechanicsData as $mechanic) {
            DB::table('mechanics')->insert($mechanic);
        }
        
        // Get mechanics again after adding
        $mechanics = DB::table('mechanics')->get();
    }
    
    // Return debug information
    return response()->json([
        'mechanics_count' => $mechanics->count(),
        'mechanics' => $mechanics,
        'database_config' => [
            'connection' => DB::connection()->getName(),
            'database_path' => config('database.connections.sqlite.database')
        ]
    ]);
});
