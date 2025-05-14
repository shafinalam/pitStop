<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    // Fields that can be filled when creating or updating an appointment
    protected $fillable = [
        'user_id',             // ID of user who made appointment (if registered)
        'mechanic_id',         // ID of the selected mechanic
        'client_name',         // Name of the client
        'email',               // Email for confirmation
        'address',             // Client's address
        'phone',               // Contact phone number
        'car_license_number',  // License plate of the car
        'car_engine_number',   // Engine number of the car
        'appointment_date',    // Date of appointment
        'appointment_time',    // Time of appointment
        'service_type',        // Type of service requested
        'status',              // Status of appointment (pending, confirmed, completed, etc.)
        'description'          // Additional details
    ];

    // Convert database fields to proper types
    protected $casts = [
        'appointment_date' => 'date',      // Convert to PHP Date object
        'appointment_time' => 'datetime',  // Convert to PHP DateTime object
    ];

    // Define relationship: an appointment belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship: an appointment belongs to a mechanic
    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(Mechanic::class);
    }
}
