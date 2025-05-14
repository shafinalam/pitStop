<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments
     */
    public function index()
    {
        $appointments = Auth::check() 
            ? Appointment::where('user_id', Auth::id())->with('mechanic')->latest()->get() 
            : [];
            
        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments
        ]);
    }

    /**
     * Show the form for creating a new appointment
     */
    public function create()
    {
        // Return the view with mechanics data
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
    }

    /**
     * Store a newly created appointment
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'mechanic_id' => 'required|exists:mechanics,id',
            'client_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'car_license_number' => 'required|string|max:50',
            'car_engine_number' => 'required|string|max:50',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'service_type' => 'required|string',
            'description' => 'nullable|string',
        ]);

        try {
            // Find the requested mechanic
            $mechanic = Mechanic::findOrFail($validated['mechanic_id']);
            
            // Check if mechanic is available on the selected date
            if (!$mechanic->isAvailableOnDate($validated['appointment_date'])) {
                return back()->withErrors([
                    'mechanic_id' => 'This mechanic is not available on the selected date.'
                ]);
            }

            // Check if logged-in user already has an appointment on this date
            if (Auth::check()) {
                $existingAppointment = Appointment::where('user_id', Auth::id())
                    ->whereDate('appointment_date', $validated['appointment_date'])
                    ->exists();
                    
                if ($existingAppointment) {
                    return back()->withErrors([
                        'appointment_date' => 'You already have an appointment scheduled on this date.'
                    ]);
                }
            }

            // Create a new appointment
            $appointment = new Appointment($validated);
            
            // Associate with logged-in user if any
            if (Auth::check()) {
                $appointment->user_id = Auth::id();
            }
            
            // Save to database
            $appointment->save();

            // Send confirmation email
            $this->sendConfirmationEmail($validated, $mechanic);
            
            // Return success message
            return redirect()->route('appointments.create')
                ->with('message', 'Appointment scheduled successfully! A confirmation email will be sent shortly.');
                
        } catch (\Exception $e) {
            return back()->withErrors([
                'general' => 'An error occurred while booking your appointment. Please try again.'
            ])->withInput();
        }
    }
    
    /**
     * Display the specified appointment
     */
    public function show(Appointment $appointment)
    {
        if (Auth::check() && $appointment->user_id !== Auth::id()) {
            abort(403);
        }
        
        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment->load('mechanic')
        ]);
    }

    /**
     * Show the form for editing the appointment
     */
    public function edit(Appointment $appointment)
    {
        if (Auth::check() && $appointment->user_id !== Auth::id()) {
            abort(403);
        }
        
        $mechanics = Mechanic::where('is_available', true)->get();
        
        return Inertia::render('Appointments/Edit', [
            'appointment' => $appointment,
            'mechanics' => $mechanics
        ]);
    }

    /**
     * Update the specified appointment
     */
    public function update(Request $request, Appointment $appointment)
    {
        if (Auth::check() && $appointment->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'mechanic_id' => 'required|exists:mechanics,id',
            'client_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'car_license_number' => 'required|string|max:50',
            'car_engine_number' => 'required|string|max:50',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'description' => 'nullable|string',
        ]);
        
        try {
            // Check if mechanic is available on the selected date
            if ($validated['mechanic_id'] != $appointment->mechanic_id || 
                $validated['appointment_date'] != $appointment->appointment_date) {
                
                $mechanic = Mechanic::findOrFail($validated['mechanic_id']);
                if (!$mechanic->isAvailableOnDate($validated['appointment_date'])) {
                    return back()->withErrors([
                        'mechanic_id' => 'This mechanic is not available on the selected date.'
                    ]);
                }
            }
            
            $appointment->update($validated);
            
            return redirect()->route('appointments.show', $appointment)
                ->with('message', 'Appointment updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'general' => 'An error occurred while updating your appointment. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Remove the specified appointment
     */
    public function destroy(Appointment $appointment)
    {
        if (Auth::check() && $appointment->user_id !== Auth::id()) {
            abort(403);
        }
        
        try {
            $appointment->delete();
            
            return redirect()->route('appointments.index')
                ->with('message', 'Appointment cancelled successfully!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'general' => 'An error occurred while cancelling your appointment. Please try again.'
            ]);
        }
    }
    
    /**
     * Send a confirmation email to the client
     */
    private function sendConfirmationEmail($appointmentData, $mechanic)
    {
        try {
            // Only proceed if we have a valid email
            if (empty($appointmentData['email'])) {
                return false;
            }
            
            // Send a simple email with appointment details
            Mail::send('emails.appointment-confirmation', [
                'appointmentData' => $appointmentData,
                'mechanicData' => [
                    'name' => $mechanic->name,
                    'specialty' => $mechanic->specialty
                ]
            ], function($message) use ($appointmentData) {
                $message->to($appointmentData['email'])
                        ->subject('Your Car Service Appointment Confirmation');
            });
            
            return true;
        } catch (\Exception $e) {
            // If email fails, just log it but don't stop the process
            return false;
        }
    }
    
    /**
     * Create default mechanics if none exist
     */
    private function createDefaultMechanics()
    {
        $mechanicsData = [
            [
                'name' => 'Alex Johnson',
                'specialty' => 'Engine Repair',
                'bio' => 'Expert with 8 years experience',
                'phone' => '555-123-4567',
                'email' => 'alex@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => true,
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
                'is_available' => true,
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
                'is_available' => true,
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
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        // Create each mechanic
        foreach ($mechanicsData as $mechanicData) {
            Mechanic::create($mechanicData);
        }
    }
} 