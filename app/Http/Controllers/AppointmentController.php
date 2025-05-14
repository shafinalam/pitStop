<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Mechanic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Auth::check() 
            ? Auth::user()->appointments()->with('mechanic')->latest()->get() 
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
            // Check if mechanic is available on the selected date
            $mechanic = Mechanic::findOrFail($validated['mechanic_id']);
            if (!$mechanic->isAvailableOnDate($validated['appointment_date'])) {
                return back()->withErrors([
                    'mechanic_id' => 'This mechanic is not available on the selected date.'
                ]);
            }

            // Check if user already has an appointment on this date
            if (Auth::check()) {
                $existingAppointment = Auth::user()->appointments()
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
            
            Log::info('Appointment saved successfully', [
                'appointment_id' => $appointment->id,
                'client' => $validated['client_name'],
                'date' => $validated['appointment_date']
            ]);

            return redirect()->route('appointments.create')->with('message', 'Appointment scheduled successfully!');
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
