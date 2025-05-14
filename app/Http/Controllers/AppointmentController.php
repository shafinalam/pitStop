<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Mechanic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmationMail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mechanics = Mechanic::where('is_available', true)->get();
        
        return Inertia::render('Appointments/Create', [
            'mechanics' => $mechanics
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('AppointmentController@store called', $request->all());
        
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
            'description' => 'nullable|string',
        ]);

        try {
            // Debug validation success
            Log::info('Form validation successful', $validated);

            // Check if mechanic is available on the selected date
            $mechanic = Mechanic::findOrFail($validated['mechanic_id']);
            if (!$mechanic->isAvailableOnDate($validated['appointment_date'])) {
                return back()->withErrors([
                    'mechanic_id' => 'This mechanic is not available on the selected date.'
                ]);
            }

            // Check if user already has an appointment on this date
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

            $appointment = new Appointment($validated);
            
            if (Auth::check()) {
                $appointment->user_id = Auth::id();
            }
            
            $appointment->save();
            Log::info('Appointment saved to database', ['id' => $appointment->id]);

            $appointmentData = [
                'client_name' => $validated['client_name'],
                'email' => $validated['email'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
                'car_license_number' => $validated['car_license_number'],
                'car_engine_number' => $validated['car_engine_number'] ?? '',
                'service_type' => $validated['service_type'] ?? 'General Service',
                'description' => $validated['description'] ?? 'General Service'
            ];
            
            $mechanic = Mechanic::findOrFail($validated['mechanic_id']);
            $mechanicData = [
                'name' => $mechanic->name,
                'specialty' => $mechanic->specialty ?? 'General Mechanic'
            ];
            
            Log::info('About to send email', [
                'to' => $validated['email'],
                'recipient_name' => $validated['client_name']
            ]);
            
            // LAST RESORT APPROACH: Save data to file and execute standalone script
            try {
                // Create a temporary data file with appointment information
                $emailData = [
                    'to_email' => $validated['email'],
                    'to_name' => $validated['client_name'],
                    'appointment_date' => $validated['appointment_date'],
                    'appointment_time' => $validated['appointment_time'],
                    'car_license' => $validated['car_license_number'],
                    'mechanic_name' => $mechanic->name,
                    'service_type' => $validated['service_type'] ?? 'General Service',
                    'notes' => $validated['description'] ?? '',
                    'timestamp' => date('Y-m-d H:i:s')
                ];
                
                // Save data to JSON file
                $dataFilePath = storage_path('app/email_data_' . time() . '.json');
                file_put_contents($dataFilePath, json_encode($emailData, JSON_PRETTY_PRINT));
                
                Log::info('Email data saved to file', ['path' => $dataFilePath]);
                
                // Execute standalone PHP script to send email
                $scriptPath = base_path('send-appointment-email.php');
                
                // Create standalone email script if it doesn't exist
                if (!file_exists($scriptPath)) {
                    $scriptContent = '<?php
// Standalone email sender - completely independent of Laravel
require_once __DIR__ . "/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get data file path from command line
$dataFile = $argv[1] ?? null;

if (!$dataFile || !file_exists($dataFile)) {
    echo "Error: Data file not found or not specified\n";
    exit(1);
}

// Read appointment data
$emailData = json_decode(file_get_contents($dataFile), true);
if (!$emailData) {
    echo "Error: Could not parse email data\n";
    exit(1);
}

try {
    // Create PHPMailer instance
    $mail = new PHPMailer(true);
    
    // Set up SMTP
    $mail->isSMTP();
    $mail->Host = "sandbox.smtp.mailtrap.io";
    $mail->SMTPAuth = true;
    $mail->Username = "84dea8bb07cf55";
    $mail->Password = "d154e964127692";
    $mail->SMTPSecure = "tls";
    $mail->Port = 2525;
    
    // Set sender and recipient
    $mail->setFrom("carservice@example.com", "Car Service Center");
    $mail->addAddress($emailData["to_email"], $emailData["to_name"]);
    
    // Set email content
    $mail->isHTML(true);
    $mail->Subject = "Car Service Appointment Confirmation";
    $mail->Body = "
        <h1>Appointment Confirmation</h1>
        <p>Dear " . $emailData["to_name"] . ",</p>
        <p>Your appointment is scheduled for " . $emailData["appointment_date"] . " at " . $emailData["appointment_time"] . ".</p>
        <p><strong>Mechanic:</strong> " . $emailData["mechanic_name"] . "</p>
        <p><strong>Vehicle:</strong> " . $emailData["car_license"] . "</p>
        <p><strong>Service Type:</strong> " . $emailData["service_type"] . "</p>
        " . (!empty($emailData["notes"]) ? "<p><strong>Notes:</strong> " . $emailData["notes"] . "</p>" : "") . "
        <p>This email was sent using a standalone script.</p>
    ";
    
    // Send the email
    $mail->send();
    echo "SUCCESS: Email sent to " . $emailData["to_email"] . "\n";
    
    // Delete data file after successful sending
    unlink($dataFile);
    echo "Data file deleted\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    // Keep data file for debugging
}
';
                    file_put_contents($scriptPath, $scriptContent);
                    Log::info('Created standalone email script', ['path' => $scriptPath]);
                }
                
                // Execute the script in background (no waiting)
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    // Windows - use start command
                    pclose(popen('start /B php "' . $scriptPath . '" "' . $dataFilePath . '" > NUL', 'r'));
                } else {
                    // Unix/Linux - use nohup
                    exec('nohup php "' . $scriptPath . '" "' . $dataFilePath . '" > /dev/null 2>&1 &');
                }
                
                Log::info('Standalone email script executed');
                
                $successMessage = 'Appointment scheduled successfully! A confirmation email will be sent shortly.';
            } catch (\Exception $e) {
                Log::error('Failed to execute standalone email script: ' . $e->getMessage());
                $successMessage = 'Appointment scheduled successfully, but we could not send a confirmation email.';
            }
            
            Log::info('Appointment process completed successfully');

            return redirect()->route('appointments.create')->with('message', $successMessage);
        } catch (\Exception $e) {
            Log::error('Error saving appointment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors([
                'general' => 'An error occurred while booking your appointment. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
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
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
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
            
            Log::info('Appointment updated successfully', [
                'appointment_id' => $appointment->id
            ]);
            
            return redirect()->route('appointments.show', $appointment)->with('message', 'Appointment updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating appointment', [
                'error' => $e->getMessage(),
                'appointment_id' => $appointment->id
            ]);
            
            return back()->withErrors([
                'general' => 'An error occurred while updating your appointment. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        if (Auth::check() && $appointment->user_id !== Auth::id()) {
            abort(403);
        }
        
        try {
            $appointment->delete();
            
            Log::info('Appointment cancelled successfully', [
                'appointment_id' => $appointment->id
            ]);
            
            return redirect()->route('appointments.index')->with('message', 'Appointment cancelled successfully!');
        } catch (\Exception $e) {
            Log::error('Error cancelling appointment', [
                'error' => $e->getMessage(),
                'appointment_id' => $appointment->id
            ]);
            
            return back()->withErrors([
                'general' => 'An error occurred while cancelling your appointment. Please try again.'
            ]);
        }
    }
}
