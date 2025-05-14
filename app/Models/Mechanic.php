<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mechanic extends Model
{
    use HasFactory;

    // Fields that can be filled when creating or updating a mechanic
    protected $fillable = [
        'name',        // Mechanic's full name
        'specialty',   // Their area of expertise (e.g., "Engine Repair")
        'bio',         // Short biography about the mechanic
        'phone',       // Contact phone number
        'email',       // Contact email address
        'max_appointments_per_day', // Maximum number of appointments they can handle daily
        'is_available' // Whether the mechanic is currently available (true/false)
    ];

    // Convert database fields to proper types
    protected $casts = [
        'is_available' => 'boolean', // Convert 0/1 to false/true
    ];

    // Define relationship: a mechanic has many appointments
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    // Count how many appointments this mechanic has on a specific date
    public function getAppointmentsForDate($date)
    {
        return $this->appointments()
            ->whereDate('appointment_date', $date)
            ->count();
    }

    // Check if mechanic can take more appointments on a specific date
    public function isAvailableOnDate($date)
    {
        // First check if mechanic is available at all
        if (!$this->is_available) {
            return false;
        }

        // Count current appointments and check against maximum
        $appointmentsCount = $this->getAppointmentsForDate($date);
        $maxAppointments = $this->max_appointments_per_day ?? 5; // Default to 5 if not set
        
        return $appointmentsCount < $maxAppointments;
    }
}
