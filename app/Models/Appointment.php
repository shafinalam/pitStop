<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mechanic_id',
        'client_name',
        'email',
        'address',
        'phone',
        'car_license_number',
        'car_engine_number',
        'appointment_date',
        'appointment_time',
        'service_type',
        'status',
        'description'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(Mechanic::class);
    }
}
